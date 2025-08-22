<?php

namespace App\Models;

use CodeIgniter\Model;

class PaperbackModel extends Model
{
    public function getDashboardData()
    {
        // Step 1: Get paperback book status counts
        $builder = $this->db->table('book_tbl');
        $builder->select('paper_back_readiness_flag, paper_back_flag, COUNT(*) AS cnt');
        $builder->where('paper_back_flag', 1);
        $builder->groupBy('paper_back_readiness_flag');

        $result1 = $builder->get()->getResultArray();

        // Initialize paperback data
        $paperback = [
            'channel_name'   => 'paperback',
            'books_count'    => 0,
            'pending_books'  => 0,
            'active_books'   => 0,
            'rework_books'   => 0,
        ];
        $pustaka = array('books_count'=>0);
        foreach ($result1 as $row) {
    $paperback['books_count'] += $row['cnt'];

    if ($row['paper_back_readiness_flag'] == 0) {
        $paperback['pending_books'] += $row['cnt'];
    } elseif ($row['paper_back_readiness_flag'] == 1) {
        $paperback['active_books'] += $row['cnt'];
    } elseif ($row['paper_back_readiness_flag'] == 3) {
        $paperback['rework_books'] += $row['cnt'];
    }
}

        $result = [
            'paperback' => $paperback
        ];

        $paperback['channel_name'] = "paperback";
        $result['paperback'] = $paperback;
        $sql1 = "
            SELECT 'Amazon' AS channel_name, COUNT(DISTINCT book_id) AS books_count
            FROM amazon_paperback_books
            UNION ALL
            SELECT 'Flipkart' AS channel_name, COUNT(DISTINCT seller_sku_id) AS books_count
            FROM flipkart_paperback_books
            UNION ALL
            SELECT 'Pustaka' AS channel_name, COUNT(DISTINCT book_id) AS books_count
            FROM book_tbl
            WHERE paper_back_readiness_flag = 1
        ";

        $query1 = $this->db->query($sql1);
        foreach ($query1->getResultArray() as $row) {
            $res = [
                'channel_name' => $row['channel_name'],
                'books_count'  => $row['books_count']
            ];
            $result[$row['channel_name']] = $res;
        }

        return $result;
    }
    public function getPaperbackDetails($status = null)
{
    $sql = "SELECT 
                book_tbl.book_id, 
                book_tbl.book_title, 
                author_tbl.author_name, 
                book_tbl.status, 
                book_tbl.paper_back_readiness_flag,
                book_tbl.created_at
            FROM book_tbl
            JOIN author_tbl ON book_tbl.author_name = author_tbl.author_id
            WHERE book_tbl.paper_back_flag = 1";

    if ((int)$status === 0) {
        $sql .= " AND (book_tbl.paper_back_readiness_flag = 0 OR book_tbl.paper_back_readiness_flag IS NULL)";
        $query = $this->db->query($sql);
    } elseif ($status !== null) {
        $sql .= " AND book_tbl.paper_back_readiness_flag = ?";
        $query = $this->db->query($sql, [$status]);
    } else {
        $query = $this->db->query($sql);
    }

    return $query->getResultArray();
}
public function podIndesignProcessing()
    {
        $builder = $this->db->table('indesign_processing');
        $builder->select('indesign_processing.*, book_tbl.book_title, author_tbl.author_name');
        $builder->join('book_tbl', 'indesign_processing.book_id = book_tbl.book_id');
        $builder->join('author_tbl', 'author_tbl.author_id = book_tbl.author_name');
        $builder->where('indesign_processing.start_flag', 0);
        $builder->orderBy('indesign_processing.created_date', 'DESC');
        $data['not_started'] = $builder->get()->getResultArray();

        $builder = $this->db->table('indesign_processing'); // Reinitialize builder
        $builder->select('indesign_processing.*, book_tbl.book_title, author_tbl.author_name');
        $builder->join('book_tbl', 'indesign_processing.book_id = book_tbl.book_id');
        $builder->join('author_tbl', 'author_tbl.author_id = book_tbl.author_name');
        $builder->where('indesign_processing.start_flag', 1);
        $builder->where('indesign_processing.completed_flag', 0);
        $builder->orderBy('indesign_processing.created_date', 'DESC');
        $data['in_progress'] = $builder->get()->getResultArray();

        return $data;
    }
public function indesignProcessingCount()
{
    $builder = $this->db->table('indesign_processing');

    // Not started
    $data['not_start_cnt'] = $builder->where('start_flag', 0)->countAllResults();

    // In progress
    $data['Processing'] = $builder->where(['completed_flag' => 0, 'start_flag' => 1])->countAllResults();

    // Level 3 pending
    $data['level3_cnt'] = $builder->where(['level3_flag' => 0, 'start_flag' => 1])->countAllResults();

    // InDesign pending
    $data['indesign_flag_cnt'] = $builder->where(['start_flag' => 1, 'level3_flag' => 1, 'indesign_flag' => 0])->countAllResults();

    // InDesign QC pending
    $data['indesign_qc_flag_cnt'] = $builder->where(['start_flag' => 1, 'indesign_flag' => 1, 'indesign_qc_flag' => 0])->countAllResults();

    // Re-QC pending
    $data['re_qc_flag_cnt'] = $builder->where(['start_flag' => 1, 'indesign_qc_flag' => 1, 're_qc_flag' => 0])->countAllResults();

    // Cover pending
    $data['indesign_cover_flagcnt'] = $builder->where(['start_flag' => 1, 're_qc_flag' => 1, 'indesign_cover_flag' => 0])->countAllResults();

    // ISBN ready pending
    $data['isbn_ready_cnt'] = $builder->where(['start_flag' => 1, 'isbn_ready_flag' => 0])->countAllResults();

    // Final QC pending
    $data['final_qc_flagcnt'] = $builder->where(['start_flag' => 1, 'indesign_cover_flag' => 1, 'final_qc_flag' => 0])->countAllResults();

    // File upload pending
    $data['file_upload_flagcnt'] = $builder->where(['start_flag' => 1, 'final_qc_flag' => 1, 'file_upload_flag' => 0])->countAllResults();

    return $data;
}


}
