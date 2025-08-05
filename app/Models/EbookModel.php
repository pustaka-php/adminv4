<?php

namespace App\Models;

use CodeIgniter\Model;

class EbookModel extends Model
{
    
    public function getDashboardData()
    {
        $builder = $this->db->table('book_tbl');
        $builder->select('status, COUNT(*) as cnt');
        $builder->where('type_of_book', 1); 
        $builder->groupBy('status');
        
        $result1 = $builder->get()->getResultArray();
        
        $ebookCounts = [
            'total_books' => 0,
            'active_books' => 0,
            'inactive_books' => 0,
            'withdrawn_books' => 0
        ];
        $pustaka = array('books_count'=>0);
        // Process the result set and assign counts
        foreach ($result1 as $row) {
            $pustaka['books_count'] += $row['cnt']; 
            
            if ($row['status'] == 0) {
                $pustaka['inactive'] = $row['cnt'];
            } elseif ($row['status'] == 1) {
                $pustaka['active'] = $row['cnt'];
            } elseif ($row['status'] == 2) {
                $pustaka['withdrawn'] = $row['cnt'];
            }
        }
        $pustaka['channel_name'] = "Pustaka";
        $result['Pustaka'] = $pustaka;
        //  to get eBook counts from various external channels
        $sql1 = "

            SELECT 'Amazon' as channel_name, COUNT(DISTINCT book_id) AS books_count
            FROM amazon_books

            UNION ALL

            SELECT 'Pratilipi' as channel_name, COUNT(DISTINCT book_id)
            FROM pratilipi_books

            UNION ALL

            SELECT 'Scribd' as channel_name, COUNT(DISTINCT book_id)
            FROM scribd_books

            UNION ALL

            SELECT 'Overdrive' as channel_name, COUNT(DISTINCT book_id)
            FROM overdrive_books
            WHERE type_of_book = 1

            UNION ALL

            SELECT 'Google' as channel_name, COUNT(DISTINCT book_id)
            FROM google_books
            WHERE book_format = 'Digital'

            UNION ALL

            SELECT 'Storytel' as channel_name, COUNT(DISTINCT book_id)
            FROM storytel_books
            WHERE type_of_book = 1;
            ";
        
        $query = $this->db->query($sql1);
        // Store each channel’s book count into the result array
        foreach ($query->getResultArray() as $row)
        {
            $res['channel_name'] = $row['channel_name'];
            $res['books_count'] = $row['books_count'];
            $result[$res['channel_name']] = $res;
        }     
        
        return $result;
    }
     public function getEbookDetails($status = null)
{
    $sql = "SELECT 
                book_tbl.book_id, 
                book_tbl.book_title, 
                author_tbl.author_name, 
                book_tbl.status, 
                book_tbl.created_at
            FROM book_tbl
            JOIN author_tbl ON book_tbl.author_name = author_tbl.author_id
            WHERE book_tbl.type_of_book = 1";

    if ($status !== null) {
        $sql .= " AND book_tbl.status = ?";
        $query = $this->db->query($sql, [$status]);
    } else {
        $query = $this->db->query($sql);
    }

    return $query->getResultArray();
}

    public function getBookDashboardData()
    {
        $result = [];

        // 1. Type of book count
        $sql = "SELECT type_of_book, FORMAT(COUNT(*), 'en_IN') as cnt FROM book_tbl WHERE status=1 GROUP BY type_of_book";
        $query = $this->db->query($sql)->getResult();
        $result['ebook_cnt'] = $query[0]->cnt ?? 0;
        $result['audiobook_cnt'] = $query[1]->cnt ?? 0;

        // 2. Paper Back count
        $query = $this->db->query("SELECT COUNT(*) as paper_back_cnt FROM book_tbl WHERE paper_back_flag = 1")->getResult();
        $result['paper_back_cnt'] = $query[0]->paper_back_cnt ?? 0;

        // 3. Paper Back Readiness count
        $query = $this->db->query("SELECT COUNT(*) as paper_back_ready_cnt, SUM(paper_back_pages) as paper_back_pages 
                                   FROM book_tbl WHERE paper_back_flag = 1 AND paper_back_readiness_flag = 1")->getResult();
        $result['paper_back_ready_cnt'] = $query[0]->paper_back_ready_cnt ?? 0;
        $result['paper_back_pages'] = $query[0]->paper_back_pages ?? 0;

        $month = date('m');
        $year  = date('Y');

        // 4. Monthly counts
        $monthlyTypes = [
            'ebook_monthly_cnt'     => 1,
            'magazine_monthly_cnt'  => 2,
            'audiobook_monthly_cnt' => 3,
        ];
        foreach ($monthlyTypes as $key => $type) {
            $query = $this->db->query("
                SELECT COUNT(*) as cnt 
                FROM book_tbl 
                WHERE MONTH(activated_at) = {$month} AND YEAR(activated_at) = {$year} 
                      AND type_of_book = {$type} AND status = 1
            ")->getResult();
            $result[$key] = $query[0]->cnt ?? 0;
        }

        // 5. Pustaka language-wise
        $languages = ['pus_tml_cnt', 'pus_kan_cnt', 'pus_tel_cnt', 'pus_mlylm_cnt', 'pus_eng_cnt'];
        $query = $this->db->query("
            SELECT language, COUNT(*) as cnt 
            FROM book_tbl 
            WHERE type_of_book = 1 AND status = 1 
            GROUP BY language
        ")->getResult();
        foreach ($languages as $index => $langKey) {
            $result[$langKey] = $query[$index]->cnt ?? 0;
        }

        // 6–10. External books by platform
        $platforms = [
            'amazon_books'   => 'amz',
            'scribd_books'   => 'scr',
            'storytel_books' => 'storytel',
            'google_books'   => 'goog',
            'overdrive_books'=> 'over',
            'pratilipi_books'=> 'prat'
        ];
        $langs = ['tml', 'kan', 'tel', 'mlylm', 'eng'];

        foreach ($platforms as $table => $prefix) {
            $query = $this->db->query("
                SELECT language_id, COUNT(*) as cnt 
                FROM {$table} 
                WHERE language_id IS NOT NULL 
                GROUP BY language_id
            ")->getResult();
            foreach ($langs as $i => $langCode) {
                $result["{$prefix}_{$langCode}_cnt"] = $query[$i]->cnt ?? 0;
            }
        }

        // 11. Pages & Minutes
        $query = $this->db->query("
            SELECT type_of_book, FORMAT(SUM(number_of_page), 'en_IN') as cnt 
            FROM book_tbl 
            WHERE status = 1 
            GROUP BY type_of_book
        ")->getResult();
        $result['ebook_pages'] = $query[0]->cnt ?? 0;
        $result['audiobook_minutes'] = $query[1]->cnt ?? 0;

        // 12. Inactive books
        $inactive = $this->db->query("
            SELECT type_of_book, COUNT(*) as cnt 
            FROM book_tbl 
            WHERE status = 0 
            GROUP BY type_of_book
        ")->getResult();
        $result['e_book_inactive_books'] = $inactive[0]->cnt ?? 0;
        $result['audio_book_inactive_books'] = $inactive[1]->cnt ?? 0;
        $result['magazine_inactive_books'] = $inactive[2]->cnt ?? 0;

        // 13. Paper Back Inactive
        $query = $this->db->query("SELECT COUNT(*) as paper_back_inactive_cnt 
                                   FROM book_tbl 
                                   WHERE status = 0 AND paper_back_flag = 1")->getResult();
        $result['paper_back_inactive_cnt'] = $query[0]->paper_back_inactive_cnt ?? 0;

        // 14. Cancelled Books
        $cancelled = $this->db->query("
            SELECT type_of_book, COUNT(*) as cnt 
            FROM book_tbl 
            WHERE status = 2 
            GROUP BY type_of_book
        ")->getResult();
        $result['e_book_cancelled_books'] = $cancelled[0]->cnt ?? 0;
        $result['audio_book_cancelled_books'] = $cancelled[1]->cnt ?? 0;
        $result['magazine_cancelled_books'] = $cancelled[2]->cnt ?? 0;

        // 15. Paper Back Cancelled
        $query = $this->db->query("SELECT COUNT(*) as paper_back_cancelled_cnt 
                                   FROM book_tbl 
                                   WHERE status = 2 AND paper_back_flag = 1")->getResult();
        $result['paper_back_cancelled_cnt'] = $query[0]->paper_back_cancelled_cnt ?? 0;

        // 16. In Progress Books
        $result['in_progress_data'] = [];

        $main = $this->db->query("
            SELECT COUNT(*) as cnt 
            FROM books_processing 
            WHERE completed = '0'
        ")->getResultArray();
        $result['in_progress_data']['main_cnt'] = $main[0]['cnt'] ?? 0;

        $completed = $this->db->query("
            SELECT COUNT(*) as cnt 
            FROM books_processing bp 
            JOIN books_progress bpr ON bp.book_id = bpr.book_id 
            WHERE bp.stage_id = 5 AND bpr.status = 2
        ")->getResultArray();
        $result['in_progress_data']['completed_data']['book_cnt'] = $completed[0]['cnt'] ?? 0;

        $unassigned = $this->db->query("
            SELECT COUNT(*) as cnt 
            FROM books_progress 
            WHERE status = 0
        ")->getResultArray();
        $result['in_progress_data']['unassigned_cnt'] = $unassigned[0]['cnt'] ?? 0;

        $inProgress = $this->db->query("
            SELECT COUNT(*) as cnt 
            FROM books_progress 
            WHERE status = 1
        ")->getResultArray();
        $result['in_progress_data']['in_progress_cnt'] = $inProgress[0]['cnt'] ?? 0;

        return $result;
    }
    public function getBookDashboardMonthlyStatistics(): array
{
    $db = \Config\Database::connect();
    $statistics_array = [];

    // Current month range
    $firstDateCurr = date('Y-m-01');
    $lastDateCurr = date('Y-m-t');

    $queryCurr = $db->query("
        SELECT COUNT(*) AS cnt, SUM(number_of_page) AS total_pages
        FROM book_tbl 
        WHERE activated_at BETWEEN '$firstDateCurr' AND '$lastDateCurr' AND type_of_book = 1
    ")->getRowArray();

    $statistics_array[0] = $queryCurr['cnt'] ?? 0;
    $statistics_array[1] = $queryCurr['total_pages'] ?? 0;

    // Previous month range
    $firstDatePrev = date('Y-m-01', strtotime('first day of last month'));
    $lastDatePrev = date('Y-m-t', strtotime('last day of last month'));

    $queryPrev = $db->query("
        SELECT COUNT(*) AS cnt, SUM(number_of_page) AS total_pages
        FROM book_tbl 
        WHERE activated_at BETWEEN '$firstDatePrev' AND '$lastDatePrev' AND type_of_book = 1
    ")->getRowArray();

    $statistics_array[2] = $queryPrev['cnt'] ?? 0;
    $statistics_array[3] = $queryPrev['total_pages'] ?? 0;

    return $statistics_array;
}
public function getBookDashboardCurrMonthData(): array
{
    $db = \Config\Database::connect();

    $firstDate = date('Y-m-01');
    $lastDate = date('Y-m-t');

    $query = $db->query("
        SELECT 
            author_tbl.author_id, 
            author_tbl.author_name, 
            COUNT(*) AS auth_book_cnt
        FROM book_tbl
        JOIN author_tbl ON book_tbl.author_name = author_tbl.author_id
        WHERE 
            book_tbl.activated_at BETWEEN '$firstDate' AND '$lastDate'
            AND book_tbl.type_of_book = 1
        GROUP BY book_tbl.author_name
        ORDER BY auth_book_cnt DESC
    ");

    return $query->getResultArray();
}
public function getBookDashboardPrevMonthData(): array
{
    $db = \Config\Database::connect();

    $firstDate = date('Y-m-01', strtotime('first day of last month'));
    $lastDate = date('Y-m-t', strtotime('last day of last month'));

    $query = $db->query("
        SELECT 
            author_tbl.author_id, 
            author_tbl.author_name, 
            COUNT(*) AS auth_book_cnt
        FROM book_tbl
        JOIN author_tbl ON book_tbl.author_name = author_tbl.author_id
        WHERE 
            book_tbl.activated_at BETWEEN '$firstDate' AND '$lastDate'
            AND book_tbl.type_of_book = 1
        GROUP BY book_tbl.author_name
        ORDER BY auth_book_cnt DESC
    ");

    return $query->getResultArray();
}
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function getAllStages()
    {
        return [
            1 => 'Scanning',
            2 => 'OCR',
            3 => 'Level 1',
            4 => 'Level 2',
            5 => 'Cover',
            6 => 'Book Generation',
            7 => 'Upload',
        ];
    }

    public function getAllStates()
    {
        return [
            0 => 'Pending',
            1 => 'In Progress',
            2 => 'Completed',
            3 => 'Rework',
        ];
    }

    public function getInProgressDashboardData()
    {
        $result = [];
        $stages = $this->getAllStages();
        $states = $this->getAllStates();

        foreach ($stages as $stage_id => $stage_text) {
            foreach ($states as $state_id => $state_text) {
                // Normal books
                $queryNormal = $this->db->query("
                    SELECT COUNT(*) AS book_count 
                    FROM books_processing bp
                    JOIN books_progress pr ON bp.book_id = pr.book_id
                    WHERE pr.stage = $stage_id AND pr.status = $state_id 
                        AND bp.completed = 0 AND bp.rework = 0
                ");
                $result['books_data']['normal'][$stage_text][$state_text] = $queryNormal->getRow()->book_count;

                // Rework books
                $queryRework = $this->db->query("
                    SELECT COUNT(*) AS book_count 
                    FROM books_processing bp
                    JOIN books_progress pr ON bp.book_id = pr.book_id
                    WHERE pr.stage = $stage_id AND pr.status = $state_id 
                        AND bp.completed = 0 AND bp.rework = 1
                ");
                $result['books_data']['rework'][$stage_text][$state_text] = $queryRework->getRow()->book_count;
            }
        }

        // Completed books
        $activateBooks = $this->db->query("SELECT COUNT(*) AS book_cnt FROM books_processing WHERE completed = 1");
        $result['num_books_activate'] = $activateBooks->getRow()->book_cnt;

        return $result;
    }

    public function getEbooksStatusDetails()
    {
        $ebooks = [];

        // In-progress book details
        $ebooks['status_details'] = $this->db->query("
            SELECT bp.*, a.author_id, a.author_name, b.book_title
            FROM books_processing bp
            JOIN book_tbl b ON bp.book_id = b.book_id
            JOIN author_tbl a ON b.author_name = a.author_id
            WHERE bp.start_flag = 1 AND bp.completed = 0
        ")->getResultArray();

        // Author count
        $ebooks['author_count'] = $this->db->query("
            SELECT COUNT(DISTINCT a.author_id) AS total_author_count
            FROM books_processing bp
            JOIN book_tbl b ON bp.book_id = b.book_id
            JOIN author_tbl a ON b.author_name = a.author_id
        ")->getRow()->total_author_count;

        // Not started books
        $ebooks['book_not_start'] = $this->db->query("
            SELECT a.author_name, b.book_title, bp.book_id, bp.date_created
            FROM books_processing bp
            JOIN book_tbl b ON bp.book_id = b.book_id
            JOIN author_tbl a ON b.author_name = a.author_id
            WHERE bp.start_flag = 0
        ")->getResultArray();

        // Count queries
        $counts = [
            'start_flag_cnt' => "start_flag = 0",
            'not_start_hardcopy' => "start_flag = 0 AND content_type = 'Hard Copy'",
            'not_start_wrd' => "start_flag = 0 AND content_type = 'Soft Copy' AND soft_copy_type = 'Word Document'",
            'not_start_pdf' => "start_flag = 0 AND content_type = 'Soft Copy' AND soft_copy_type = 'PDF'",
            'scan_flag_cnt' => "start_flag = 1 AND scan_flag = 0",
            'ocr_flag_cnt' => "start_flag = 1 AND scan_flag = 1 AND ocr_flag = 0",
            'ocr_flag_cnt_pdf' => "start_flag = 1 AND scan_flag = 2 AND ocr_flag = 0",
            'level1_flag_cnt' => "start_flag = 1 AND scan_flag = 1 AND ocr_flag = 1 AND level1_flag = 0",
            'level1_flag_cnt_pdf' => "start_flag = 1 AND scan_flag = 2 AND ocr_flag = 1 AND level1_flag = 0",
            'level2_flag_cnt' => "start_flag = 1 AND scan_flag = 1 AND level1_flag = 1 AND level2_flag = 0",
            'level2_flag_cnt_pdf' => "start_flag = 1 AND scan_flag = 2 AND level1_flag = 1 AND level2_flag = 0",
            'cover_flag_cnt' => "start_flag = 1 AND scan_flag != 2 AND cover_flag = 0",
            'cover_flag_cnt_wrd' => "start_flag = 1 AND level2_flag = 2 AND cover_flag = 0",
            'cover_flag_cnt_pdf' => "start_flag = 1 AND scan_flag = 2 AND level2_flag != 2 AND cover_flag = 0",
            'book_generation_flag_cnt' => "start_flag = 1 AND scan_flag = 1 AND level2_flag = 1 AND cover_flag = 1 AND book_generation_flag = 0",
            'book_generation_flag_wrd' => "start_flag = 1 AND scan_flag = 2 AND level2_flag = 2 AND cover_flag = 1 AND book_generation_flag = 0",
            'book_generation_flag_pdf' => "start_flag = 1 AND scan_flag = 2 AND level2_flag = 1 AND cover_flag = 1 AND book_generation_flag = 0",
            'upload_flag_cnt' => "start_flag = 1 AND scan_flag = 1 AND book_generation_flag = 1 AND upload_flag = 0",
            'upload_flag_cnt_wrd' => "start_flag = 1 AND scan_flag = 2 AND level2_flag = 2 AND book_generation_flag = 1 AND upload_flag = 0",
            'upload_flag_cnt_pdf' => "start_flag = 1 AND scan_flag = 2 AND level2_flag = 1 AND book_generation_flag = 1 AND upload_flag = 0",
            'completed_flag_cnt' => "completed = 1",
            'holdbook_cnt' => "start_flag = 2",
            'total_not_start' => "start_flag = 0"
        ];

        foreach ($counts as $key => $where) {
            $query = $this->db->query("SELECT COUNT(*) as cnt FROM books_processing WHERE $where");
            $ebooks[$key] = $query->getRow()->cnt;
        }

        // Inactive books
        $ebooks['in_active_cnt'] = $this->db->query("
            SELECT COUNT(*) AS cnt
            FROM books_processing bp
            JOIN book_tbl b ON bp.book_id = b.book_id
            WHERE bp.completed = 1 AND bp.start_flag = 1 AND b.status = 0
        ")->getRow()->cnt;

        // In-progress count
        $ebooks['in_progress_cnt'] = $this->db->query("
            SELECT COUNT(*) AS cnt
            FROM books_processing bp
            JOIN book_tbl b ON bp.book_id = b.book_id
            JOIN author_tbl a ON b.author_name = a.author_id
            WHERE bp.start_flag = 1 AND bp.completed = 0
        ")->getRow()->cnt;

        return $ebooks;
    }
    public function getEbookData()
    {
        $result = [];

        // pustaka
        $query = $this->db->table('book_tbl')
            ->select("COUNT(*) as cnt, DATE_FORMAT(activated_at, '%m-%y') as monthly_publish")
            ->where(['type_of_book' => 1, 'status' => 1])
            ->groupBy('monthly_publish')
            ->orderBy('activated_at', 'ASC')
            ->get();

        $pus_publish_monthly_cnt = [];
        $month = [];
        foreach ($query->getResultArray() as $row) {
            $pus_publish_monthly_cnt[] = $row['cnt'];
            $month[] = $row['monthly_publish'];
        }
        $result['pus_publish_monthly_cnt'] = $pus_publish_monthly_cnt;
        $result['pus_month'] = $month;

        // amazon
        $query = $this->db->table('amazon_books')
            ->select("COUNT(*) as cnt, DATE_FORMAT(release_date, '%m-%y') as monthly_publish")
            ->groupBy('monthly_publish')
            ->orderBy('release_date', 'ASC')
            ->get();

        $amz_publish_monthly_cnt = [];
        $month = [];
        foreach ($query->getResultArray() as $row) {
            $amz_publish_monthly_cnt[] = $row['cnt'];
            $month[] = $row['monthly_publish'];
        }
        $result['amz_publish_monthly_cnt'] = $amz_publish_monthly_cnt;
        $result['amz_month'] = $month;

        // scribd
        $query = $this->db->table('scribd_books')
            ->select("COUNT(*) as cnt, DATE_FORMAT(updated_at, '%m-%y') as monthly_publish")
            ->groupBy('monthly_publish')
            ->orderBy('updated_at', 'ASC')
            ->get();

        $scr_publish_monthly_cnt = [];
        $month = [];
        foreach ($query->getResultArray() as $row) {
            $scr_publish_monthly_cnt[] = $row['cnt'];
            $month[] = $row['monthly_publish'];
        }
        $result['scr_publish_monthly_cnt'] = $scr_publish_monthly_cnt;
        $result['scr_month'] = $month;

        // storytel
        $query = $this->db->table('storytel_books')
            ->select("COUNT(*) as cnt, DATE_FORMAT(publication_date, '%m-%y') as monthly_publish")
            ->groupBy('monthly_publish')
            ->orderBy('publication_date', 'ASC')
            ->get();

        $storytel_publish_monthly_cnt = [];
        $month = [];
        foreach ($query->getResultArray() as $row) {
            $storytel_publish_monthly_cnt[] = $row['cnt'];
            $month[] = $row['monthly_publish'];
        }
        $result['storytel_publish_monthly_cnt'] = $storytel_publish_monthly_cnt;
        $result['storytel_month'] = $month;

        // google books
        $query = $this->db->table('google_books')
            ->select("COUNT(*) as cnt, DATE_FORMAT(publish_date, '%m-%y') as monthly_publish")
            ->groupBy('monthly_publish')
            ->orderBy('publish_date', 'ASC')
            ->get();

        $goog_publish_monthly_cnt = [];
        $month = [];
        foreach ($query->getResultArray() as $row) {
            $goog_publish_monthly_cnt[] = $row['cnt'];
            $month[] = $row['monthly_publish'];
        }
        $result['goog_publish_monthly_cnt'] = $goog_publish_monthly_cnt;
        $result['goog_month'] = $month;

        // overdrive
        $query = $this->db->table('overdrive_books')
            ->select("COUNT(*) as cnt, DATE_FORMAT(onsale_date, '%m-%y') as monthly_publish")
            ->groupBy('monthly_publish')
            ->orderBy('onsale_date', 'ASC')
            ->get();

        $over_publish_monthly_cnt = [];
        $month = [];
        foreach ($query->getResultArray() as $row) {
            $over_publish_monthly_cnt[] = $row['cnt'];
            $month[] = $row['monthly_publish'];
        }
        $result['over_publish_monthly_cnt'] = $over_publish_monthly_cnt;
        $result['over_month'] = $month;

        // total counts
        $result['pus_monthly'] = $this->db->table('book_tbl')->where(['type_of_book' => 1, 'status' => 1])->countAllResults();
        $result['amz_monthly'] = $this->db->table('amazon_books')->countAllResults();
        $result['scr_monthly'] = $this->db->table('scribd_books')->countAllResults();
        $result['storytel_monthly'] = $this->db->table('storytel_books')->countAllResults();
        $result['goog_monthly'] = $this->db->table('google_books')->countAllResults();
        $result['over_monthly'] = $this->db->table('overdrive_books')->countAllResults();

        return $result;
    }
}