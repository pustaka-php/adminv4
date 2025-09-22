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
    $db = \Config\Database::connect();

    $data = [];

    // Not started
    $query = $db->query("SELECT COUNT(*) AS cnt FROM indesign_processing WHERE start_flag = 0");
    $data['not_start_cnt'] = $query->getRow()->cnt;

    // In progress
    $query = $db->query("SELECT COUNT(*) AS cnt FROM indesign_processing WHERE start_flag = 1 AND completed_flag = 0");
    $data['Processing'] = $query->getRow()->cnt;

    // Level 3 pending
    $query = $db->query("SELECT COUNT(*) AS cnt FROM indesign_processing WHERE start_flag = 1 AND level3_flag = 0");
    $data['level3_cnt'] = $query->getRow()->cnt;

    // InDesign pending
    $query = $db->query("SELECT COUNT(*) AS cnt FROM indesign_processing WHERE start_flag = 1 AND level3_flag = 1 AND indesign_flag = 0");
    $data['indesign_flag_cnt'] = $query->getRow()->cnt;

    // InDesign QC pending
    $query = $db->query("SELECT COUNT(*) AS cnt FROM indesign_processing WHERE start_flag = 1 AND indesign_flag = 1 AND indesign_qc_flag = 0");
    $data['indesign_qc_flag_cnt'] = $query->getRow()->cnt;

    // Re-QC pending
    $query = $db->query("SELECT COUNT(*) AS cnt FROM indesign_processing WHERE start_flag = 1 AND indesign_qc_flag = 1 AND re_qc_flag = 0");
    $data['re_qc_flag_cnt'] = $query->getRow()->cnt;

    // Cover pending
    $query = $db->query("SELECT COUNT(*) AS cnt FROM indesign_processing WHERE start_flag = 1 AND completed_flag = 0 AND indesign_cover_flag = 0");
    $data['indesign_cover_flagcnt'] = $query->getRow()->cnt;

    // ISBN ready pending
    $query = $db->query("SELECT COUNT(*) AS cnt FROM indesign_processing WHERE start_flag = 1 AND isbn_ready_flag = 0");
    $data['isbn_ready_cnt'] = $query->getRow()->cnt;

    // Final QC pending
    $query = $db->query("SELECT COUNT(*) AS cnt FROM indesign_processing WHERE start_flag = 1 AND indesign_cover_flag = 1 AND re_qc_flag = 1 AND isbn_ready_flag = 1  AND final_qc_flag = 0");
    $data['final_qc_flagcnt'] = $query->getRow()->cnt;

    // File upload pending
    $query = $db->query("SELECT COUNT(*) AS cnt FROM indesign_processing WHERE start_flag = 1 AND final_qc_flag = 1 AND file_upload_flag = 0");
    $data['file_upload_flagcnt'] = $query->getRow()->cnt;

    return $data;
}

public function getLanguageWiseBookCount()
{
    return $this->db->table('book_tbl b')
        ->select('l.language_name, COUNT(b.book_id) as total_books', false)
        ->join('language_tbl l', 'l.language_id = b.language')
        ->where(['b.paper_back_readiness_flag' => 1])
        ->groupBy('l.language_name')
        ->get()
        ->getResultArray();
}
    public function getGenreWiseBookCount()
    {
        return $this->db->table('book_tbl b')
        ->select('g.genre_name, COUNT(b.book_id) as total_books')
        ->join('genre_details_tbl g', 'g.genre_id = b.genre_id')
        ->where(['b.paper_back_readiness_flag' => 1])  // type_of_book = 1 filter added
        ->groupBy('g.genre_name')
        ->get()
        ->getResultArray();
    }

    public function getBookCategoryCount()
    {
        return $this->db->table('book_tbl b')
        ->select('b.book_category, COUNT(b.book_id) as total_books')
        ->where('b.status', 1)
        ->where('b.paper_back_readiness_flag', 1)   // type_of_book filter
        ->groupBy('b.book_category')
        ->get()
        ->getResultArray();
    }

   public function getAuthorWiseBookCount()
{
    return $this->db->table('book_tbl b')
        ->select('a.author_name, COUNT(b.book_id) as total')
        ->join('author_tbl a', 'a.author_id = b.author_name', 'left')
        ->where(['b.paper_back_readiness_flag' => 1])
        ->groupBy('a.author_id')
        ->orderBy('total', 'DESC') // Use the alias instead of COUNT()
        ->get()
        ->getResultArray();
}
    
  public function getPaperbackBooksData()
    {
        $result = [];

        // Main paperback books data
        $query = $this->db->query("
            SELECT language_tbl.language_name, COUNT(book_tbl.book_id) as cnt 
            FROM book_tbl
            JOIN language_tbl ON book_tbl.language = language_tbl.language_id
            WHERE book_tbl.paper_back_readiness_flag = 1 
            AND book_tbl.status = 1 
            GROUP BY book_tbl.language, language_tbl.language_name
        ")->getResult();

        // Map results by language_name
        foreach ($query as $row) {
            $result["pus_{$row->language_name}_cnt"] = $row->cnt;
        }

        // External books by platform
        $platforms = [
            'amazon_paperback_books'   => 'amz',
            'flipkart_paperback_books' => 'flp',
        ];

        foreach ($platforms as $table => $prefix) {
            $query = $this->db->query("
                SELECT language_tbl.language_name, COUNT(*) as cnt
                FROM {$table}
                JOIN language_tbl ON {$table}.language = language_tbl.language_id
                WHERE {$table}.language IS NOT NULL
                GROUP BY {$table}.language, language_tbl.language_name
            ")->getResult();

            // Add counts to result with prefix
            foreach ($query as $row) {
                $result["{$prefix}_{$row->language_name}_cnt"] = $row->cnt;
            }
        }

        return $result;
    }

        public function getPodBooksList()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('book_tbl');
        $builder->select([
            'book_tbl.book_id',
            'book_tbl.book_title',
            'book_tbl.regional_book_title',
            'book_tbl.paper_back_pages as number_of_page',
            'author_tbl.author_name',
            'author_tbl.author_id'
        ]);
        $builder->join('author_tbl', 'author_tbl.author_id = book_tbl.author_name', 'inner');
        $builder->where('book_tbl.paper_back_flag', 1);
        $builder->groupStart()
                ->where('book_tbl.paper_back_readiness_flag', 0)
                ->orWhere('book_tbl.paper_back_readiness_flag IS NULL', null, false)
                ->groupEnd();
        $builder->whereNotIn('book_tbl.book_id', function ($subQuery) {
            return $subQuery->select('book_id')->from('indesign_processing');
        });

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function selectedBookList($selected_book_list)
    {
        // Ensure the list is always an array
        if (!is_array($selected_book_list)) {
            $selected_book_list = explode(',', $selected_book_list);
        }

        $builder = $this->db->table('book_tbl');
        $builder->select('
            book_tbl.book_id,
            book_tbl.book_title,
            book_tbl.regional_book_title,
            book_tbl.paper_back_pages as number_of_page,
            author_tbl.author_name,
            author_tbl.author_id
        ');
        $builder->join('author_tbl', 'author_tbl.author_id = book_tbl.author_name');
        $builder->where('book_tbl.paper_back_flag', 1);
        $builder->whereIn('book_tbl.book_id', $selected_book_list);

        $query = $builder->get();
        return $query->getResultArray();
    }
    public function bookListSubmit($num_of_books, $selected_book_list, $postData)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('indesign_processing');

        $book_ids   = [];
        $author_ids = [];

        for ($i = 1; $i <= $num_of_books; $i++) {
            $tmpBook   = 'book_id' . $i;
            $tmpAuthor = 'author_id' . $i;

            $book_ids[$i]   = $postData[$tmpBook] ?? null;
            $author_ids[$i] = $postData[$tmpAuthor] ?? null;
        }

        for ($i = 1; $i <= $num_of_books; $i++) {
            if (empty($book_ids[$i]) || empty($author_ids[$i])) {
                continue;
            }

            $existing = $builder->where('book_id', $book_ids[$i])->get()->getRowArray();

            if (!$existing) {
                $data = [
                    'book_id'      => $book_ids[$i],
                    'author_id'    => $author_ids[$i],
                    'created_date' => date('Y-m-d H:i:s'),
                ];
                $builder->insert($data);
            } else {
                return "Error: Book ID " . $book_ids[$i] . " has already been submitted.";
            }
        }

        return ($db->affectedRows() > 0) ? 1 : 0;
    }
    public function indesignMarkStart($book_id)
    {
        $db = \Config\Database::connect();
        // Use table name directly here
        $builder = $db->table('indesign_processing');

        $builder->set('start_flag', 1)
                ->where('book_id', $book_id)
                ->update();

        return ($db->affectedRows() > 0) ? 1 : 0;
    }
    public function markLevel3Completed($book_id)
    {
    $db = \Config\Database::connect();
    $builder = $db->table('indesign_processing');

    $builder->set('level3_flag', 1)
            ->where('book_id', $book_id)
            ->update();

    return ($db->affectedRows() > 0) ? 1 : 0;
    }
    function markIndesignCompleted($book_id){

        $db = \Config\Database::connect();
        $builder = $db->table('indesign_processing');

        $builder->set('indesign_flag', 1)
                ->where('book_id', $book_id)
                ->update();

        return ($db->affectedRows() > 0) ? 1 : 0;
    }
    public function markIndesignQcCompleted($book_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('indesign_processing');

        $builder->set('indesign_qc_flag', 1)
                ->where('book_id', $book_id)
                ->update();

        return ($db->affectedRows() > 0) ? 1 : 0;
    }
    public function markreqccompleted($book_id){

        $db = \Config\Database::connect();
        $builder = $db->table('indesign_processing');

        $builder->set('re_qc_flag', 1)
                ->where('book_id', $book_id)
                ->update();

        return ($db->affectedRows() > 0) ? 1 : 0;
    }
    function markindesigncovercompleted($book_id){

        $db = \Config\Database::connect();
        $builder = $db->table('indesign_processing');

        $builder->set('indesign_cover_flag', 1)
                ->where('book_id', $book_id)
                ->update();

        return ($db->affectedRows() > 0) ? 1 : 0;
    }
    function markisbnreadycompleted($book_id){

        $db = \Config\Database::connect();
        $builder = $db->table('indesign_processing');

        $builder->set('isbn_ready_flag', 1)
                ->where('book_id', $book_id)
                ->update();

        return ($db->affectedRows() > 0) ? 1 : 0;
    }

    function markfinalqccompleted($book_id){

        $db = \Config\Database::connect();
        $builder = $db->table('indesign_processing');

        $builder->set('final_qc_flag', 1)
                ->where('book_id', $book_id)
                ->update();

        return ($db->affectedRows() > 0) ? 1 : 0;
    }

    function markfileuploadcompleted($book_id){

         $db = \Config\Database::connect();
        $builder = $db->table('indesign_processing');

        $builder->set('file_upload_flag', 1)
                ->where('book_id', $book_id)
                ->update();

        return ($db->affectedRows() > 0) ? 1 : 0;
    }
    public function completedBooksSubmit($book_id)
{
    $db = \Config\Database::connect();
    $builder = $db->table('book_tbl'); 

    $row = $builder->where('book_id', $book_id)
                   ->get()
                   ->getRowArray(); 

    return $row;
}
    public function indesignMarkCompleted($book_id, $pages, $price, $royalty, $copyright_owner, $isbn, $paper_back_desc, $paper_back_author_desc)
    {
        $db = \Config\Database::connect();

        // Update indesign_processing table
        $builder1 = $db->table('indesign_processing');
        $builder1->where('book_id', $book_id)
                 ->update([
                     'completed_flag' => 1,
                     'completed_date' => date('Y-m-d H:i:s')
                 ]);

        // Update book_tbl table
        $builder2 = $db->table('book_tbl');
        $builder2->where('book_id', $book_id)
                 ->update([
                     'paper_back_readiness_flag' => 1,
                     'paper_back_pages' => $pages,
                     'paper_back_inr' => $price,
                     'paper_back_royalty' => $royalty,
                     'paper_back_copyright_owner' => $copyright_owner,
                     'paper_back_isbn' => $isbn,
                     'paper_back_desc' => $paper_back_desc,
                     'paper_back_author_desc' => $paper_back_author_desc
                 ]);

        return ($db->affectedRows() > 0) ? 1 : 0;
    }
     public function podReworkBook()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('book_tbl');

        $builder->select('
                book_tbl.book_id,
                book_tbl.book_title,
                book_tbl.regional_book_title,
                book_tbl.paper_back_pages as number_of_page,
                author_tbl.author_name,
                author_tbl.author_id
            ')
            ->join('author_tbl', 'author_tbl.author_id = book_tbl.author_name')
            ->where('book_tbl.paper_back_flag', 1)
            ->where('book_tbl.paper_back_readiness_flag', 1);

        $query = $builder->get();
        return $query->getResultArray();
    }
     public function podReworkProcessing()
    {
        // 🔹 Not Started Books
        $sql1 = "SELECT 
                    indesign_processing.*,
                    book_tbl.book_title,
                    author_tbl.author_name
                 FROM 
                    indesign_processing
                 JOIN 
                    book_tbl ON indesign_processing.book_id = book_tbl.book_id
                 JOIN 
                    author_tbl ON author_tbl.author_id = book_tbl.author_name
                 WHERE 
                    indesign_processing.rework_start_flag = 0 
                    AND indesign_processing.rework_flag = 1";

        $query1 = $this->db->query($sql1);
        $data['not_started'] = $query1->getResultArray();

        // 🔹 In Progress Books
        $sql2 = "SELECT 
                    indesign_processing.*,
                    book_tbl.book_title,
                    author_tbl.author_name
                 FROM 
                    indesign_processing
                 JOIN 
                    book_tbl ON indesign_processing.book_id = book_tbl.book_id
                 JOIN 
                    author_tbl ON author_tbl.author_id = book_tbl.author_name
                 WHERE 
                    indesign_processing.rework_start_flag = 1 
                    AND indesign_processing.rework_flag = 1
                    AND indesign_processing.re_completed_flag = 0";

        $query2 = $this->db->query($sql2);
        $data['in_progress'] = $query2->getResultArray();

        return $data;
    }

    public function reworkProcessingCount()
    {
        $data = [];

        // 🔹 Not Started
        $query = $this->db->query(
            "SELECT COUNT(*) as cnt 
             FROM indesign_processing 
             WHERE rework_start_flag = 0 
             AND rework_flag = 1"
        );
        $data['not_start_cnt'] = $query->getRowArray();

        // 🔹 In Processing
        $query = $this->db->query(
            "SELECT COUNT(*) as cnt 
             FROM indesign_processing 
             WHERE rework_start_flag = 1 
             AND rework_flag = 1 
             AND re_completed_flag = 0"
        );
        $data['Processing'] = $query->getRowArray();

        // 🔹 Re-Proofing
        $query = $this->db->query(
            "SELECT COUNT(*) as cnt 
             FROM indesign_processing 
             WHERE rework_flag = 1 
             AND rework_start_flag = 1 
             AND re_proofing_flag = 0"
        );
        $data['re_proofing_cnt'] = $query->getRowArray();

        // 🔹 Re-Indesign
        $query = $this->db->query(
            "SELECT COUNT(*) as cnt 
             FROM indesign_processing 
             WHERE rework_flag = 1 
             AND re_proofing_flag = 1 
             AND re_indesign_flag = 0"
        );
        $data['re_indesign_cnt'] = $query->getRowArray();

        // 🔹 Re-File Upload
        $query = $this->db->query(
            "SELECT COUNT(*) as cnt 
             FROM indesign_processing 
             WHERE rework_flag = 1 
             AND re_indesign_flag = 1 
             AND re_fileupload_flag = 0"
        );
        $data['re_fileupload_cnt'] = $query->getRowArray();

        return $data;
    }
    public function reworkMarkStart()
{
    $book_id = $this->request->getPost('book_id');

    // Direct DB access using table name
    $db = \Config\Database::connect();
    $builder = $db->table('indesign_processing');

    $builder->where('book_id', $book_id);
    $builder->update(['rework_start_flag' => 1]);

    // Return 1 if affected, else 0
    return $this->response->setJSON($db->affectedRows() > 0 ? 1 : 0);
}

    public function markReProofingCompleted()
    {
        $book_id = $this->request->getPost('book_id');

        $result = $this->db->table('indesign_processing')
            ->where('book_id', $book_id)
            ->update(['re_proofing_flag' => 1]);

        return $this->db->affectedRows() > 0 ? 1 : 0;
    }

    public function markReIndesignCompleted()
    {
        $book_id = $this->request->getPost('book_id');

        $result = $this->db->table('indesign_processing')
            ->where('book_id', $book_id)
            ->update(['re_indesign_flag' => 1]);

        return $this->db->affectedRows() > 0 ? 1 : 0;
    }

    public function markReFileuploadCompleted()
    {
        $book_id = $this->request->getPost('book_id');

        $result = $this->db->table('indesign_processing')
            ->where('book_id', $book_id)
            ->update(['re_fileupload_flag' => 1]);

        return $this->db->affectedRows() > 0 ? 1 : 0;
    }
    public function amzonPaperbackDetails()
    {
        $db = \Config\Database::connect();
        $result = [];

        // Published books count by language
        $publishedQuery = $db->query("
        SELECT l.language_id, l.language_name, COUNT(*) AS cnt
        FROM amazon_books ab
        JOIN language_tbl l ON ab.language_id = l.language_id
        GROUP BY l.language_id, l.language_name
    ")->getResult();

    // Initialize counts
    $result['amz_tml_cnt']   = 0;
    $result['amz_kan_cnt']   = 0;
    $result['amz_tel_cnt']   = 0;
    $result['amz_mlylm_cnt'] = 0;
    $result['amz_eng_cnt']   = 0;

    foreach ($publishedQuery as $row) {
        if ($row->language_id == 1) { // Tamil
            $result['amz_tml_cnt'] = $row->cnt;
             } elseif ($row->language_id == 2) { // kannada
            $result['amz_kan_cnt'] = $row->cnt;
             } elseif ($row->language_id == 3) { // telgu
            $result['amz_tel_cnt'] = $row->cnt;
        } elseif ($row->language_id == 4) { // Malayalam
            $result['amz_mlylm_cnt'] = $row->cnt;
        } elseif ($row->language_id == 5) { // English
            $result['amz_eng_cnt'] = $row->cnt;
        }
    }

    // Helper function to fetch books
    $fetchBooks = function($sql) use ($db) {
        return $db->query($sql)->getResultArray();
    };
        // Published Tamil books
        $sqlTamil = "SELECT b.book_id, b.book_title, a.author_name, b.epub_url
                    FROM book_tbl b
                    JOIN author_tbl a ON b.author_name = a.author_id
                    WHERE b.status=1 AND b.book_id IN (SELECT book_id FROM amazon_paperback_books)
                    AND b.language=1 AND b.cost != 3 AND b.author_name != 11 
                    AND (b.type_of_book = 1 OR b.type_of_book = 2)
                    ORDER BY b.book_id";
        $tamilBooks = $fetchBooks($sqlTamil);
        $result['amazon_tml_book_id'] = array_column($tamilBooks, 'book_id');
        $result['amazon_tml_book_title'] = array_column($tamilBooks, 'book_title');
        $result['amazon_tml_book_author_name'] = array_column($tamilBooks, 'author_name');
        $result['amazon_tml_book_epub_url'] = array_column($tamilBooks, 'epub_url');

        // Published Malayalam books
        $sqlMalayalam = str_replace("b.language=1", "b.language=4", $sqlTamil);
        $malayalamBooks = $fetchBooks($sqlMalayalam);
        $result['amazon_mlylm_book_id'] = array_column($malayalamBooks, 'book_id');
        $result['amazon_mlylm_book_title'] = array_column($malayalamBooks, 'book_title');
        $result['amazon_mlylm_book_author_name'] = array_column($malayalamBooks, 'author_name');
        $result['amazon_mlylm_book_epub_url'] = array_column($malayalamBooks, 'epub_url');

        // Published English books
        $sqlEnglish = str_replace("b.language=4", "b.language=5", $sqlMalayalam);
        $englishBooks = $fetchBooks($sqlEnglish);
        $result['amazon_eng_book_id'] = array_column($englishBooks, 'book_id');
        $result['amazon_eng_book_title'] = array_column($englishBooks, 'book_title');
        $result['amazon_eng_book_author_name'] = array_column($englishBooks, 'author_name');
        $result['amazon_eng_book_epub_url'] = array_column($englishBooks, 'epub_url');
// Unpublished counts (safer mapping by language_id)
    $unpubQuery = $db->query("
        SELECT b.language, COUNT(b.book_id) AS cnt 
        FROM book_tbl b 
        JOIN language_tbl l ON b.language=l.language_id
        WHERE b.status=1 AND b.book_id NOT IN (SELECT book_id FROM amazon_books)
        AND b.cost != 3 AND b.author_name != 11 AND b.type_of_book = 1
        GROUP BY b.language
    ")->getResult();

    // Initialize unpublished counts
    $result['amz_tml_unpub_cnt']   = 0;
    $result['amz_mlylm_unpub_cnt'] = 0;
    $result['amz_eng_unpub_cnt']   = 0;

    foreach ($unpubQuery as $row) {
        if ($row->language == 1) {
            $result['amz_tml_unpub_cnt'] = $row->cnt;
        } elseif ($row->language == 4) {
            $result['amz_mlylm_unpub_cnt'] = $row->cnt;
        } elseif ($row->language == 5) {
            $result['amz_eng_unpub_cnt'] = $row->cnt;
        }
    }

        // Unpublished Tamil ebooks
        $sqlUnpubTamil = str_replace("b.book_id IN", "b.book_id NOT IN", $sqlTamil);
        $unpubTamilBooks = $fetchBooks($sqlUnpubTamil);
        $result['amz_tml_book_id'] = array_column($unpubTamilBooks, 'book_id');
        $result['amz_tml_book_title'] = array_column($unpubTamilBooks, 'book_title');
        $result['amz_tml_book_author_name'] = array_column($unpubTamilBooks, 'author_name');
        $result['amz_tml_book_epub_url'] = array_column($unpubTamilBooks, 'epub_url');

        // Short stories Tamil
        $sqlShortStories = "SELECT b.book_id, b.book_title, a.author_name, b.epub_url
                            FROM book_tbl b
                            JOIN author_tbl a ON b.author_name = a.author_id
                            WHERE b.status=1 AND b.book_id NOT IN (SELECT book_id FROM amazon_books)
                            AND b.language=1 AND b.type_of_book=1 AND b.cost <> 3
                            ORDER BY b.book_id";
        $shortStories = $fetchBooks($sqlShortStories);
        $result['amz_short_stories_id'] = array_column($shortStories, 'book_id');
        $result['amz_short_stories_title'] = array_column($shortStories, 'book_title');
        $result['amz_short_stories_author_name'] = array_column($shortStories, 'author_name');
        $result['amz_short_stories_epub_url'] = array_column($shortStories, 'epub_url');

        // Unpublished Malayalam ebooks
        $sqlUnpubMalayalam = str_replace("b.language=1", "b.language=4", $sqlUnpubTamil);
        $unpubMalayalamBooks = $fetchBooks($sqlUnpubMalayalam);
        $result['amz_mlylm_book_id'] = array_column($unpubMalayalamBooks, 'book_id');
        $result['amz_mlylm_book_title'] = array_column($unpubMalayalamBooks, 'book_title');
        $result['amz_mlylm_book_author_name'] = array_column($unpubMalayalamBooks, 'author_name');
        $result['amz_mlylm_book_epub_url'] = array_column($unpubMalayalamBooks, 'epub_url');

        // Unpublished English ebooks
        $sqlUnpubEnglish = str_replace("b.language=4", "b.language=5", $sqlUnpubMalayalam);
        $unpubEnglishBooks = $fetchBooks($sqlUnpubEnglish);
        $result['amz_eng_book_id'] = array_column($unpubEnglishBooks, 'book_id');
        $result['amz_eng_book_title'] = array_column($unpubEnglishBooks, 'book_title');
        $result['amz_eng_book_author_name'] = array_column($unpubEnglishBooks, 'author_name');
        $result['amz_eng_book_epub_url'] = array_column($unpubEnglishBooks, 'epub_url');

        return $result;
}
}
