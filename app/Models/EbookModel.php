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

        // Type of book count
        $sql = "SELECT type_of_book, FORMAT(COUNT(*), 'en_IN') as cnt FROM book_tbl WHERE status=1 GROUP BY type_of_book";
        $query = $this->db->query($sql)->getResult();
        $result['ebook_cnt'] = $query[0]->cnt ?? 0;
        $result['audiobook_cnt'] = $query[1]->cnt ?? 0;

        // Paper Back count
        $query = $this->db->query("select count(*) as paper_back_cnt from book_tbl where paper_back_flag = 1")->getResult();
        $result['paper_back_cnt'] = $query[0]->paper_back_cnt ?? 0;

        // Paper Back Readiness count
       $query = $this->db->query("
                SELECT 
                    SUM(CASE 
                        WHEN MONTH(paperback_activate_at) = MONTH(CURRENT_DATE()) 
                        AND YEAR(paperback_activate_at) = YEAR(CURRENT_DATE()) 
                        THEN 1 ELSE 0 END) AS current_month_cnt,
                    
                    SUM(CASE 
                        WHEN MONTH(paperback_activate_at) = MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)) 
                        AND YEAR(paperback_activate_at) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)) 
                        THEN 1 ELSE 0 END) AS previous_month_cnt
                FROM book_tbl 
                WHERE paper_back_readiness_flag = 1
            ")->getRowArray();

            $result['paper_back_current_cnt']  = $query['current_month_cnt'] ?? 0;
            $result['paper_back_previous_cnt'] = $query['previous_month_cnt'] ?? 0;

            $month = date('m');
            $year  = date('Y');

            // E-Book Readiness count
            $query = $this->db->query("
                SELECT 
                    COUNT(CASE 
                        WHEN MONTH(activated_at) = MONTH(CURRENT_DATE()) 
                        AND YEAR(activated_at) = YEAR(CURRENT_DATE()) 
                        THEN 1 END) AS current_month_cnt,
                        
                    COUNT(CASE 
                        WHEN MONTH(activated_at) = MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)) 
                        AND YEAR(activated_at) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)) 
                        THEN 1 END) AS previous_month_cnt
                FROM book_tbl 
                WHERE type_of_book = 1
            ")->getRowArray();

            $result['ebook_current_cnt']  = $query['current_month_cnt'] ?? 0;
            $result['ebook_previous_cnt'] = $query['previous_month_cnt'] ?? 0;

            $month = date('m');
            $year  = date('Y');
            // Audio Book Readiness count
            $query = $this->db->query("
                SELECT 
                    SUM(CASE 
                        WHEN MONTH(activated_at) = MONTH(CURRENT_DATE()) 
                        AND YEAR(activated_at) = YEAR(CURRENT_DATE()) 
                        THEN 1 ELSE 0 END) AS current_month_cnt,
                    
                    SUM(CASE 
                        WHEN MONTH(activated_at) = MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)) 
                        AND YEAR(activated_at) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)) 
                        THEN 1 ELSE 0 END) AS previous_month_cnt
                FROM book_tbl
                WHERE type_of_book = 3
            ")->getRowArray();

            $result['audio_book_current_cnt']  = $query['current_month_cnt'] ?? 0;
            $result['audio_book_previous_cnt'] = $query['previous_month_cnt'] ?? 0;

            $month = date('m');
            $year  = date('Y');

        // Pustaka language-wise
        $query = $this->db->query("
        SELECT language_tbl.language_name, COUNT(book_tbl.book_id) as cnt
        FROM book_tbl
        JOIN language_tbl ON book_tbl.language = language_tbl.language_id
        WHERE book_tbl.type_of_book = 1 
          AND book_tbl.status = 1
        GROUP BY book_tbl.language, language_tbl.language_name
    ")->getResult();

    // Map results by language_name with prefix "pus_"
    foreach ($query as $row) {
        $result["pus_{$row->language_name}_cnt"] = $row->cnt;
    }

    // External platforms
    $platforms = [
        'amazon_books'    => 'amz',
        'scribd_books'    => 'scr',
        'storytel_books'  => 'storytel',
        'google_books'    => 'goog',
        'overdrive_books' => 'over',
        'pratilipi_books' => 'prat',
    ];

    foreach ($platforms as $table => $prefix) {
        $query = $this->db->query("
            SELECT language_tbl.language_name, COUNT(*) as cnt
            FROM {$table}
            JOIN language_tbl ON {$table}.language_id = language_tbl.language_id
            WHERE {$table}.language_id IS NOT NULL
            GROUP BY {$table}.language_id, language_tbl.language_name
        ")->getResult();

        foreach ($query as $row) {
            $result["{$prefix}_{$row->language_name}_cnt"] = $row->cnt;
        }
    }

        // Pages & Minutes
        $query = $this->db->query("
            SELECT type_of_book, FORMAT(SUM(number_of_page), 'en_IN') as cnt 
            FROM book_tbl 
            WHERE status = 1 
            GROUP BY type_of_book
        ")->getResult();
        $result['ebook_pages'] = $query[0]->cnt ?? 0;
        $result['audiobook_minutes'] = $query[1]->cnt ?? 0;

        // Inactive books
        $inactive = $this->db->query("
            SELECT type_of_book, COUNT(*) as cnt 
            FROM book_tbl 
            WHERE status = 0 
            GROUP BY type_of_book
        ")->getResult();
        $result['e_book_inactive_books'] = $inactive[0]->cnt ?? 0;
        $result['audio_book_inactive_books'] = $inactive[1]->cnt ?? 0;
        $result['magazine_inactive_books'] = $inactive[2]->cnt ?? 0;

        // Paper Back Inactive
        $query = $this->db->query("SELECT COUNT(*) AS paper_back_inactive_cnt 
                        FROM book_tbl 
                        WHERE status = 0 
                        AND paper_back_flag = 1")->getResult();
        $result['paper_back_inactive_cnt'] = $query[0]->paper_back_inactive_cnt ?? 0;

        // Cancelled Books
        $cancelled = $this->db->query("
            SELECT type_of_book, COUNT(*) as cnt 
            FROM book_tbl 
            WHERE status = 2 
            GROUP BY type_of_book
        ")->getResult();
        $result['e_book_cancelled_books'] = $cancelled[0]->cnt ?? 0;
        $result['audio_book_cancelled_books'] = $cancelled[1]->cnt ?? 0;
        $result['magazine_cancelled_books'] = $cancelled[2]->cnt ?? 0;

        // Paper Back Cancelled
        $query = $this->db->query("SELECT count(*) as paper_back_cancelled_cnt FROM book_tbl where status=2 and paper_back_flag = 1")->getResult();
        $result['paper_back_cancelled_cnt'] = $query[0]->paper_back_cancelled_cnt ?? 0;

        // In Progress Books
        $result['in_progress_data'] = [];

        $main = $this->db->query("
            SELECT COUNT(*) as cnt 
            FROM books_processing 
            WHERE start_flag = 1 AND completed = '0'
            ")->getResultArray();
        $result['in_progress_data']['main_cnt'] = $main[0]['cnt'] ?? 0;

        $completed = $this->db->query("
            SELECT COUNT(*) as cnt 
            FROM books_processing  
            WHERE completed = 1;
            ")->getResultArray();
        $result['in_progress_data']['completed_data']['book_cnt'] = $completed[0]['cnt'] ?? 0;

        $unassigned = $this->db->query("
            SELECT COUNT(*) as cnt 
            FROM books_processing 
            WHERE start_flag = 0;
            ")->getResultArray();
        $result['in_progress_data']['unassigned_cnt'] = $unassigned[0]['cnt'] ?? 0;

        $result['paperback_data'] = [];

        // In-Progress Count
        $main = $this->db->query("
            SELECT COUNT(*) as cnt 
            FROM indesign_processing 
            WHERE start_flag = 1 AND completed_flag = '0'
        ")->getResultArray();
        $result['paperback_data']['main_cnt'] = $main[0]['cnt'] ?? 0;

        // Completed Count
        $completed = $this->db->query("
            SELECT COUNT(*) as cnt 
            FROM indesign_processing  
            WHERE completed_flag = 1
        ")->getResultArray();
        $result['paperback_data']['completed_data']['book_cnt'] = $completed[0]['cnt'] ?? 0;

        // Unassigned Count
        $unassigned = $this->db->query("
            SELECT COUNT(*) as cnt 
            FROM indesign_processing 
            WHERE start_flag = 0
        ")->getResultArray();
        $result['paperback_data']['unassigned_cnt'] = $unassigned[0]['cnt'] ?? 0;


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
    public function getEbookData()
    {
        $result = [];

        // pustaka
            $query = $this->db->table('book_tbl')
        ->select("COUNT(*) as cnt, DATE_FORMAT(activated_at, '%b-%Y') as monthly_publish") // Jan-2025 format
        ->where(['type_of_book' => 1, 'status' => 1])
        ->where('activated_at IS NOT NULL') // avoid NULL dates
        ->groupBy('YEAR(activated_at), MONTH(activated_at)')
        ->orderBy('YEAR(activated_at)', 'ASC')
        ->orderBy('MONTH(activated_at)', 'ASC')
        ->get();

        $pus_publish_monthly_cnt = [];
        $month = [];

        foreach ($query->getResultArray() as $row) {
            $pus_publish_monthly_cnt[] = (int)$row['cnt'];      // count of books
            $month[] = $row['monthly_publish'] ?: 'Unknown';   // show Unknown if no month
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

    public function getEbooksStatusDetails()
    {
        $ebooks = [];

        // Books status details
        $books_sql = "SELECT books_processing.*, author_tbl.author_id, author_tbl.author_name, book_tbl.book_title 
                      FROM books_processing
                      JOIN book_tbl ON books_processing.book_id = book_tbl.book_id
                      JOIN author_tbl ON book_tbl.author_name = author_tbl.author_id
                      WHERE books_processing.start_flag = 1 
                      AND books_processing.completed = 0";
        $ebooks['status_details'] = $this->db->query($books_sql)->getResultArray();

        // Author count
        $author_count_sql = "SELECT COUNT(DISTINCT author_tbl.author_id) as total_author_count
                             FROM books_processing
                             JOIN book_tbl ON books_processing.book_id = book_tbl.book_id
                             JOIN author_tbl ON book_tbl.author_name = author_tbl.author_id";
        $ebooks['author_count'] = $this->db->query($author_count_sql)->getRowArray()['total_author_count'];

        // Not started books
        $books_start_sql = "SELECT author_tbl.author_name, book_tbl.book_title, books_processing.book_id, books_processing.date_created
                            FROM books_processing
                            JOIN book_tbl ON books_processing.book_id = book_tbl.book_id
                            JOIN author_tbl ON book_tbl.author_name = author_tbl.author_id
                            WHERE books_processing.start_flag = 0";
        $ebooks['book_not_start'] = $this->db->query($books_start_sql)->getResultArray();

        // Helper function for single-count queries
        $countQuery = function($sql) {
            return $this->db->query($sql)->getRowArray()['cnt'] ?? 0;
        };

        // Counts
        $ebooks['start_flag_cnt']         = $countQuery("SELECT COUNT(*) as cnt FROM books_processing WHERE start_flag = 0");
        $ebooks['not_start_hardcopy']     = $countQuery("SELECT COUNT(*) as cnt FROM books_processing WHERE content_type='Hard Copy' AND start_flag = 0");
        $ebooks['not_start_wrd']          = $countQuery("SELECT COUNT(*) as cnt FROM books_processing WHERE start_flag=0 AND content_type='Soft Copy' AND soft_copy_type='Word Document'");
        $ebooks['not_start_pdf']          = $countQuery("SELECT COUNT(*) as cnt FROM books_processing WHERE start_flag=0 AND content_type='Soft Copy' AND soft_copy_type='PDF'");
        $ebooks['in_progress_cnt']        = $countQuery("SELECT COUNT(*) as cnt FROM books_processing JOIN book_tbl ON books_processing.book_id=book_tbl.book_id JOIN author_tbl ON book_tbl.author_name=author_tbl.author_id WHERE books_processing.start_flag=1 AND books_processing.completed=0");
        $ebooks['scan_flag_cnt']          = $countQuery("SELECT COUNT(*) as cnt FROM books_processing WHERE start_flag=1 AND scan_flag=0");
        $ebooks['ocr_flag_cnt']           = $countQuery("SELECT COUNT(*) as cnt FROM books_processing WHERE start_flag=1 AND scan_flag=1 AND ocr_flag=0");
        $ebooks['ocr_flag_cnt_pdf']       = $countQuery("SELECT COUNT(*) as cnt FROM books_processing WHERE start_flag=1 AND scan_flag=2 AND ocr_flag=0");
        $ebooks['level1_flag_cnt']        = $countQuery("SELECT COUNT(*) as cnt FROM books_processing WHERE start_flag=1 AND scan_flag=1 AND ocr_flag=1 AND level1_flag=0");
        $ebooks['level1_flag_cnt_pdf']    = $countQuery("SELECT COUNT(*) as cnt FROM books_processing WHERE start_flag=1 AND scan_flag=2 AND ocr_flag=1 AND level1_flag=0");
        $ebooks['level2_flag_cnt']        = $countQuery("SELECT COUNT(*) as cnt FROM books_processing WHERE start_flag=1 AND scan_flag=1 AND level1_flag=1 AND level2_flag=0");
        $ebooks['level2_flag_cnt_pdf']    = $countQuery("SELECT COUNT(*) as cnt FROM books_processing WHERE start_flag=1 AND scan_flag=2 AND level1_flag=1 AND level2_flag=0");
        $ebooks['cover_flag_cnt']         = $countQuery("SELECT COUNT(*) as cnt FROM books_processing WHERE start_flag=1 AND scan_flag!=2 AND cover_flag=0");
        $ebooks['cover_flag_cnt_wrd']     = $countQuery("SELECT COUNT(*) as cnt FROM books_processing WHERE start_flag=1 AND level2_flag=2 AND cover_flag=0");
        $ebooks['cover_flag_cnt_pdf']     = $countQuery("SELECT COUNT(*) as cnt FROM books_processing WHERE start_flag=1 AND scan_flag=2 AND level2_flag!=2 AND cover_flag=0");
        $ebooks['book_generation_flag_cnt']   = $countQuery("SELECT COUNT(*) as cnt FROM books_processing WHERE start_flag=1 AND scan_flag=1 AND level2_flag=1 AND cover_flag=1 AND book_generation_flag=0");
        $ebooks['book_generation_flag_wrd']   = $countQuery("SELECT COUNT(*) as cnt FROM books_processing WHERE start_flag=1 AND scan_flag=2 AND level2_flag=2 AND cover_flag=1 AND book_generation_flag=0");
        $ebooks['book_generation_flag_pdf']   = $countQuery("SELECT COUNT(*) as cnt FROM books_processing WHERE start_flag=1 AND scan_flag=2 AND level2_flag=1 AND cover_flag=1 AND book_generation_flag=0");
        $ebooks['upload_flag_cnt']            = $countQuery("SELECT COUNT(*) as cnt FROM books_processing WHERE start_flag=1 AND scan_flag=1 AND book_generation_flag=1 AND upload_flag=0");
        $ebooks['upload_flag_cnt_wrd']        = $countQuery("SELECT COUNT(*) as cnt FROM books_processing WHERE start_flag=1 AND scan_flag=2 AND level2_flag=2 AND book_generation_flag=1 AND upload_flag=0");
        $ebooks['upload_flag_cnt_pdf']        = $countQuery("SELECT COUNT(*) as cnt FROM books_processing WHERE start_flag=1 AND scan_flag=2 AND level2_flag=1 AND book_generation_flag=1 AND upload_flag=0");
        $ebooks['completed_flag_cnt']         = $countQuery("SELECT COUNT(*) as cnt FROM book_tbl WHERE status=1 AND type_of_book = 1");
        $ebooks['holdbook_cnt']               = $countQuery("SELECT COUNT(*) as cnt FROM books_processing WHERE start_flag=2");
        $ebooks['in_active_cnt']              = $countQuery("SELECT COUNT(*) as cnt FROM books_processing JOIN book_tbl ON books_processing.book_id=book_tbl.book_id WHERE books_processing.completed=1 AND books_processing.start_flag=1 AND book_tbl.status=0");
        $ebooks['total_not_start']            = $countQuery("SELECT COUNT(*) as cnt FROM books_processing WHERE start_flag=0");

        return $ebooks;
    }
   public function getHoldBookDetails()
{
    $db = \Config\Database::connect();

    $sql = "SELECT 
                author_tbl.author_name,
                book_tbl.book_title,
                books_processing.book_id
            FROM books_processing
            JOIN book_tbl 
                ON books_processing.book_id = book_tbl.book_id
            JOIN author_tbl 
                ON book_tbl.author_name = author_tbl.author_id
            WHERE books_processing.start_flag = 2";

    $query = $db->query($sql);
    return $query->getResultArray();
}
public function getInactiveBooks()
{
    $db = \Config\Database::connect();

    $sql = "SELECT 
                books_processing.*,
                book_tbl.*,
                author_tbl.author_name
            FROM books_processing
            JOIN book_tbl 
                ON books_processing.book_id = book_tbl.book_id
            JOIN author_tbl 
                ON author_tbl.author_id = book_tbl.author_name
            WHERE books_processing.completed = 1
              AND books_processing.start_flag = 1
              AND book_tbl.status = 0";

    $query = $db->query($sql);
    return $query->getResultArray();
}
 public function getFillData($book_id)
    {
        $builder = $this->db->table('book_tbl'); // table() use pannikalam
        $row = $builder->select('book_id, book_title, description, number_of_page, proof_flag')
                       ->where('book_id', $book_id)
                       ->get()
                       ->getRowArray();

        if (!$row) {
            return [];
        }

        return [
            'book_id'    => $row['book_id'],
            'book_title' => $row['book_title'],
            'desc_text'  => $row['description'],
            'num_pages'  => $row['number_of_page'],
            'proof_flag' => $row['proof_flag'],
        ];
    }

    // ✅ UPDATE query with table() use
    public function fillData()
    {
        $request = service('request');

        $update_data = [
            'description'             => $request->getPost('description'),
            'cost'                    => $request->getPost('final_cost_inr'),
            'number_of_page'          => $request->getPost('num_pages'),
            'book_cost_international' => $request->getPost('final_cost_usd'),
            'proof_flag'              => $request->getPost('proof_flag'),
        ];

        $book_id = $request->getPost('id');

        $builder = $this->db->table('book_tbl'); 
        $builder->where('book_id', $book_id)
                ->update($update_data);

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }
    public function addToTest($userId, $bookId)
    {
        $table = 'free_book_subscription';  

        $data = [
            'user_id'  => $userId,
            'book_id'  => $bookId,
            'comments' => 'Free book added to book-shelf'
        ];

        $db = \Config\Database::connect();
        $builder = $db->table($table);

        $builder->insert($data);

        return ($db->insertID() > 0) ? 1 : 0;
    }
public function holdInProgress($bookId)
{
    $updateData = ['start_flag' => 2];

    $builder = $this->db->table('books_processing');
    $builder->where('book_id', $bookId);
    $builder->update($updateData);

    return ($this->db->affectedRows() > 0) ? 1 : 0;
}
public function getBookDetails($book_id)
{
    $db = \Config\Database::connect();

    // Book details
    $book_details = $db->table('book_tbl')->where('book_id', $book_id)->get()->getRowArray();

    // Language details
    $lang_details = $db->table('language_tbl')
        ->where('language_id', $book_details['language'])
        ->get()
        ->getRowArray();
    $book_details['language'] = $lang_details['language_name'];

    // Genre details
    $genre_details = $db->table('genre_details_tbl')
        ->where('genre_id', $book_details['genre_id'])
        ->get()
        ->getRowArray();
    $book_details['genre_id'] = $genre_details['genre_name'];

    // Created by details
    $created_by_details = $db->table('users_tbl')
        ->where('user_id', $book_details['created_by'])
        ->get()
        ->getRowArray();
    $book_details['created_by'] = $created_by_details['username'];

    $result['book_details'] = $book_details;

    // Author details
    $author_details = $db->table('author_tbl')
        ->where('author_id', $book_details['author_name'])
        ->get()
        ->getRowArray();
    $author_details['status'] = $author_details['status'] == 0 ? 'Inactive' : 'Active';
    $result['author_details'] = $author_details;

    // Copyright owner (user) details
    $user_details = $db->table('users_tbl')
        ->where('user_id', $book_details['copyright_owner'])
        ->get()
        ->getRowArray();
    $result['user_details'] = $user_details;

    // Publisher details
    $publisher_details = $db->table('publisher_tbl')
        ->where('copyright_owner', $book_details['copyright_owner'])
        ->get()
        ->getRowArray();
    $result['publisher_details'] = $publisher_details;

    // Copyright mapping
    $copyright_mapping_details = $db->table('copyright_mapping')
        ->where('copyright_owner', $book_details['copyright_owner'])
        ->get()
        ->getResultArray();
    $result['copyright_mapping_details'] = $copyright_mapping_details;

    // If audiobook
    if ($book_details['type_of_book'] == 3) {
        // Narrator details
        $narrator_details = $db->table('narrator_tbl')
            ->where('narrator_id', $book_details['narrator_id'])
            ->get()
            ->getRowArray();
        $result['narrator_details'] = $narrator_details;

        // Audio chapters
        $audio_chapters = $db->table('audio_book_details')
            ->where('book_id', $book_id)
            ->get()
            ->getResultArray();
        $result['audio_chapters'] = $audio_chapters;
    }

    return $result;
    }
    public function activateBook($book_id, $send_mail_flag)
    {
        if ($send_mail_flag) {
            $this->send_activate_book_mail($book_id);
        }

        $current_date = date("Y-m-d H:i:s");
        $db = \Config\Database::connect();

        $sql = "UPDATE book_tbl SET status = 1, activated_at = ? WHERE book_id = ?";
        $db->query($sql, [$current_date, $book_id]);

        return $db->affectedRows() > 0;
    }

    public function send_activate_book_mail($book_id)
    {
        $db = \Config\Database::connect();

        // Book Details
        $book_details = $db->table('book_tbl')
            ->where('book_id', $book_id)
            ->get()
            ->getRowArray();

        // Language
        $lang_details = $db->table('language_tbl')
            ->where('language_id', $book_details['language'])
            ->get()
            ->getRowArray();
        $book_details['language'] = $lang_details['language_name'];

        // Genre
        $genre_details = $db->table('genre_details_tbl')
            ->where('genre_id', $book_details['genre_id'])
            ->get()
            ->getRowArray();
        $book_details['genre_id'] = $genre_details['genre_name'];

        // Author
        $author_details = $db->table('author_tbl')
            ->where('author_id', $book_details['author_name'])
            ->get()
            ->getRowArray();

        // User (Copyright Owner)
        $user_details = $db->table('users_tbl')
            ->where('user_id', $book_details['copyright_owner'])
            ->get()
            ->getRowArray();

        $book_url = config('App')->pustaka_url . "/home/ebook/" . strtolower($book_details['language']) . "/" . $book_details['url_name'];
        $subject = $book_details['book_title'] . " - Published in Pustaka";
        $message ="<html lang=\"en\">
				  <head>
	  			  <meta charset=\"utf-8\"/>
	  			  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
	  			  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />
	  			  <meta name=\"x-apple-disable-message-reformatting\" />
	  			  <!--[if !mso]><!-->
	   			  <meta http-equiv=\"X-UA-Compatible\" content\"IE=edge\" />
	  			  <!--<![endif]-->
	  			  <title></title>
	  			  <!--[if !mso]><!-->
	  			 <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\" />
	   			 <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin=\"\" />
	  			 <link href=\"https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&amp;display=swap\"
				 rel=\"stylesheet\"/>
	  			 <!--<![endif]-->
				</head>
				<body
				style=\"
				  margin: 0;
				  padding: 0;
				  background-color: #ffffff;
				  color: #000000;
				  font-family: 'Quicksand', sans-serif;
				  font-size: 16px;\"
				data-new-gr-c-s-check-loaded=\"14.1052.0\"
				data-gr-ext-installed=\"\">
				<table
				  class=\"main-table\"
				  style=\"
					max-width: 850px;
					min-width: 350px;
					margin: 0 auto;
					padding-left: 20px;
					padding-right: 20px;\"
				    cellpadding=\"0\"
				    cellspacing=\"0\">
				  <tbody>
					<tr
					  style=\"
						background: linear-gradient(
							0deg,
							rgba(0, 41, 107, 0.2),
							rgba(0, 41, 107, 0.2)
						  ),
						  linear-gradient(135deg, #4685ec 0%, #00296b 100%);\">
					  <td style=\"padding: 40px 0px; text-align: center\">
					  <img src=\"https://pustaka-assets.s3.ap-south-1.amazonaws.com/images/pustaka-logo.png\"
						  alt=\"Logo\"
						  title=\"Logo\"
						  style=\"
							display: inline-block !important;
							width: 33%;
							max-width: 174.9px;
						  \"/>
					  </td>
					</tr>
					<tr>
					  <td style=\"text-align: center\">
						<h1 style=\"
							text-align: center;
							word-wrap: break-word;
							font-weight: 600;
							font-size: 36px;
							margin-top: 30px;
							margin-bottom: 30px;\">
						Your Book is Published
						</h1>
						</td>
					  </tr>
					  <tr>
						<td style=\"text-align: right\">
						  <p style=\"font-size: 18px; line-height: 28px; margin: 0\">";
		
		$message .= "Published Date: " . date('d/M/Y');

		$message .= "</p>
					<p style=\"font-size: 18px; line-height: 28px; margin: 0\">
				    </p>
	  				</td>
					</tr>
					<tr>
	  				<td style=\"text-align: left; padding-top: 30px; padding-bottom: 20px\">
					<p style=\"font-size: 18px; line-height: 28px\">";
		$message .="<p>Dear ". $author_details['author_name'];
		
		$message .= ",</p>
					<p>Greetings!!!</p>
                    <p>Your book - <b>".$book_details['book_title'] ." </b>is published today in our portal. Link to the latest book is <a href= ".$book_url.">here</a>. </p>
					<p>Here are few details about the book:</p>
					<p>Genre: <b>" . $book_details['genre_id'] . "</p></b>
					<p>Type: <b>" . $book_details['book_category'] . "</p></b>";
		if ($book_details['type_of_book'] == 1)
			$message .= "<p>Pages: <b>" . $book_details['number_of_page'] . "</p></b>";
		else
			$message .= "<p>Duration: <b>" . $book_details['number_of_page'] . " minutes </p></b>";
		$message .= "<p></p>Kindly, let us know if you want us to change any of the above details. Reply to this email with the details.</p>";
		if ($book_details['type_of_book'] == 1)
		{
			$message .= "<p>You can read your book in laptop/browser or in Android mobile App. Here are instructions for the same:</p>";
			$message .= "To read the book in laptop using a standard browser (like Chrome): ";
			$message .= "<ol>
						<li>Go to <a target='_blank' href='https://www.pustaka.co.in'>https://www.pustaka.co.in</a></li>
						<li>Click \"Login\" on the top right corner and provide your email id and password</li>
						<li>Click \"My Library\" on the top menu</li>
						<li>You can see the books with the label \"My Published Books\" </li>
						<li>Click the book wrapper to open the book and read</li>
					</ol>";	
			$message .= "To read the book in android mobile app";
			$message .= "<ol>
						<li>Install the mobile app from play store (search \"pustaka\") or install the app from the given link <a target='_blank' href='https://play.google.com/store/apps/details?id=com.pustaka.ebooks'>https://play.google.com/store/apps/details?id=com.pustaka.ebooks</a></li>
						<li>Login using  the same email id and password</li>
						<li>Click \"My Library\" in the bottom</li>
						<li>Click \"eBooks\" tab in the top</li>
						<li>Click the book cover and click Download or Continue to Read</li>
					</ol>";	
		}
		else
		{
			$message .= "To listen to your audio in android mobile app";
			$message .= "<ol>
						<li>Install the mobile app from play store (search \"pustaka\") or install the app from the given link <a target='_blank' href='https://play.google.com/store/apps/details?id=com.pustaka.ebooks'>https://play.google.com/store/apps/details?id=com.pustaka.ebooks</a></li>
						<li>Login using  the same email id and password</li>
						<li>Click \"My Library\" in the bottom</li>
						<li>Click \"Audio Books\" tab in the top</li>
						<li>Click the book cover and click Play button to listen to the audio book</li>
					</ol>";	

		}

		$message .= "You can also gift this book to 10 people of your choice. Please follow the steps to send this book as a gift:<br>";
		$message .= "<ol>
						<li>Go to <a target='_blank' href='https://dashboard.pustaka.co.in/'>https://dashboard.pustaka.co.in/</a></li>
						<li>Login using your email and password</li>
						<li>Select \"Gift a Book\" link in the left side</li>
						<li>Select the book that you wanted to give and provide the name and email id of the person you wanted to send it as a gift</li>
						<li>An email will be automatically sent to the person(Click Refresh if you have any trouble)</li>
					</ol><br>";		

		$message .=	"<tr style=\"display: table; margin: 0 auto\">
					 <td style=\"text-align: center; padding-top: 20px; font-size: 20px\">
				  	 Notice Something Wrong?
				  	<a href=\"https://www.pustaka.co.in/contact-us\"
					style=\"
					  font-size: 20px;
					  line-height: normal;
					  font-weight: 500;
					  color: #00296b;
					  cursor: pointer;
					  text-decoration: none;
					  transition: all 0.15s;\">
					Contact us</a>
				</td>
			  </tr>
			  <tr style=\"display: table; margin: 0 auto; margin-bottom: 30px\">
				<td style=\"text-align: center; padding-top: 20px; font-size: 20px\">
				  Want to Learn how it works?
				  <a href=\"https://www.pustaka.co.in/how-it-works\"
					style=\"
					  font-size: 20px;
					  line-height: normal;
					  font-weight: 500;
					  color: #00296b;
					  cursor: pointer;
					  text-decoration: none;
					  transition: all 0.15s;\">
					Click here</a>
				</td>
			  </tr>
			  <tr style=\"display: table; margin: 0 auto; margin-bottom: 50px\">
				<td style=\"text-align: center; padding-top: 20px\">
				  <img src=\"https://pustaka-assets.s3.ap-south-1.amazonaws.com/images/app-store-badge.png\"
					alt=\"Logo\"
					title=\"Logo\"
					style=\"height: 50px; margin-right: 20px\"/>
				</td>
				<td style=\"text-align: center; padding-top: 20px\">
				  <img src=\"https://pustaka-assets.s3.ap-south-1.amazonaws.com/images/play-store-badge.png\"
					alt=\"Logo\"
					title=\"Logo\"
					style=\"height: 50px\"/>
				</td>
			  </tr>
			  <tr style=\"background-color: #f9f9f9\">
				<td style=\"text-align: center\">
				  <table style=\"text-align: center; padding: 20px; margin: 0 auto\">
					<tbody>
					  <tr>
						<td>
						  <a href=\"https://www.facebook.com/PustakaDigitalMedia\">
						  <img src=\"https://pustaka-assets.s3.ap-south-1.amazonaws.com/images/facebook.png\"
						  style=\"width: 10px\"/></a>
						</td>
						<td style=\"padding-left: 30px; padding-right: 30px\">
						  <a href=\"https://twitter.com/pustakabook\">
						  <img src=\"https://pustaka-assets.s3.ap-south-1.amazonaws.com/images/twitter.png\"
						  style=\"width: 20px\"/></a>
						</td>
						<td style=\"padding-right: 30px\">
						  <a href=\"https://www.instagram.com/pustaka_ebooks/\">
						  <img src=\"https://pustaka-assets.s3.ap-south-1.amazonaws.com/images/instagram.png\"
							  style=\"width: 20px\"/></a>
						</td>
						<td>
						  <a href=\"https://in.pinterest.com/pustakadigital/_created/\">
						  <img src=\"https://pustaka-assets.s3.ap-south-1.amazonaws.com/images/pinterest.png\"
						  style=\"width: 17px\"/></a>
						</td>
					  </tr>
					</tbody>
				  </table>
				  <table style=\"text-align: center; padding-bottom: 20px; margin: 0 auto\">
					<tbody>
					  <tr>
						<td style=\"padding-right: 30px\">
						  <a href=\"tel:9980387852\"
							style=\"
							  font-size: 18px;
							  color: #212121;
							  text-decoration: none;\">
							  <img src=\"https://pustaka-assets.s3.ap-south-1.amazonaws.com/images/call.png\"
							  style=\"
								width: 20px;
								padding-right: 6px;
								vertical-align: sub;\"/>
								9980387852</a>
						</td>
						<td>
						  <a
							href=\"mailto:admin@pustaka.co.in\"
							style=\"
							  font-size: 18px;
							  color: #212121;
							  text-decoration: none;\">
							<img src=\"https://pustaka-assets.s3.ap-south-1.amazonaws.com/images/mail.png\"
							  style=\"
								width: 20px;
								padding-right: 6px;
								vertical-align: sub;
							  \"/>admin@pustaka.co.in</a>
						</td>
					  </tr>
					</tbody>
				  </table>
				</td>
			  </tr>
			</tbody>
		  </table>";
           $email = \Config\Services::email();
        $email->setFrom('admin@pustaka.co.in', 'Pustaka Admin');
        $email->setTo($user_details['email']);
        $email->setCC('admin@pustaka.co.in');
        $email->setSubject($subject);
        $email->setMessage($message);
        $email->send();

}
public function addBook()
    {
        $request = service('request');
        $session = session();

        $lang_id = $request->getPost('lang_id');
        switch ($lang_id) {
            case 1:
                $language = "tam";
                $full_lang_name = "tamil";
                break;
            case 2:
                $language = "kan";
                $full_lang_name = "kannada";
                break;
            case 3:
                $language = "tel";
                $full_lang_name = "telugu";
                break;
            case 4:
                $language = "mal";
                $full_lang_name = "malayalam";
                break;
            default:
                $language = "eng";
                $full_lang_name = "english";
                break;
        }

        // get genre details
        $genre_sql = "SELECT url_name, genre_id FROM genre_details_tbl WHERE genre_id = ?";
        $genre_query = $this->db->query($genre_sql, [$request->getPost('genre_id')]);
        $genre_details = $genre_query->getResultArray();
        $genre_name = $genre_details[0]['url_name'];

        // file paths
        $cover_file_path = $language.'/cover/'.$genre_name.'/'.$request->getPost('url_title').'.jpg';
        $epub_file_path  = $language.'/epub/'.$genre_name.'/'.$request->getPost('url_title').'.epub';
        $book_file_path  = $language.'/book/'.$genre_name.'/'.$request->getPost('url_title').'/';

        // author details
        $author_query = $this->db->query("SELECT * FROM author_tbl WHERE author_id = ?", [$request->getPost('author_id')]);
        $author = $author_query->getRowArray();

        // check duplicate url_name
        $url_title = $request->getPost('url_title');
        $check_query = $this->db->query("SELECT * FROM book_tbl WHERE url_name = ?", [$url_title]);
        if ($check_query->getNumRows() > 0) {
            return 2; // duplicate
        }

        // insert into book_tbl
        $insert_data = [
            "author_name"        => $request->getPost('author_id'),
            "book_title"         => $request->getPost('title'),
            "regional_book_title"=> $request->getPost('regional_title'),
            "language"           => $request->getPost('lang_id'),
            "description"        => $request->getPost('desc_text'),
            "book_category"      => $request->getPost('book_category'),
            "royalty"            => $request->getPost('royalty'),
            "copyright_owner"    => $author['copyright_owner'] ?? '',
            "genre_id"           => $request->getPost('genre_id'),
            "status"             => 0,
            "type_of_book"       => 1,
            "created_by"         => $session->get('user_id'),
            "cover_image"        => $cover_file_path,
            "epub_url"           => $epub_file_path,
            "download_link"      => $book_file_path,
            "url_name"           => $url_title,
            "agreement_flag"     => $request->getPost('agreement_flag'),
            "paper_back_flag"    => $request->getPost('paperback_flag')
        ];
        $this->db->table('book_tbl')->insert($insert_data);
        $last_insert_book_id = $this->db->insertID();

        // process flags
        $soft_copy_type = $request->getPost('soft_copy_type');
        if ($soft_copy_type == 'Word Document') {
            $scan = $ocr = $level1 = $level2 = 2;
            $cover = $book_gen = $upload = 0;
        } elseif ($soft_copy_type == 'PDF') {
            $scan = 2; $ocr = $level1 = $level2 = 0;
            $cover = $book_gen = $upload = 0;
        } else {
            $scan = $ocr = $level1 = $level2 = $cover = $book_gen = $upload = 0;
        }

        // insert into books_processing
        $books_processing = [
            "content_type"        => $request->getPost('content_type'),
            "hard_copy_type"      => $request->getPost('hard_copy_type'),
            "soft_copy_type"      => $soft_copy_type,
            "priority"            => $request->getPost('priority'),
            "book_id"             => $last_insert_book_id,
            "initial_page_number" => $request->getPost('no_of_pages'),
            "date_created"        => $request->getPost('date_assigned'),
            "scan_flag"           => $scan,
            "ocr_flag"            => $ocr,
            "level1_flag"         => $level1,
            "level2_flag"         => $level2,
            "cover_flag"          => $cover,
            "book_generation_flag"=> $book_gen,
            "upload_flag"         => $upload,
            "completed"           => 0,
            "rework"              => 0,
        ];
        $this->db->table('books_processing')->insert($books_processing);

        return ($last_insert_book_id >= 1) ? 1 : 0;
    }
    public function getBrowseBooksData()
{
    $db = \Config\Database::connect();

    // Main books query
    $books_sql = "
        SELECT *, author_tbl.author_name as author_name 
        FROM book_tbl, author_tbl, books_progress, books_processing 
        WHERE book_tbl.author_name = author_tbl.author_id 
          AND book_tbl.book_id = books_progress.book_id 
          AND books_progress.book_id = books_processing.book_id 
          AND books_processing.completed = '0' 
        GROUP BY book_tbl.book_id
    ";
    $books_query = $db->query($books_sql);
    $books = $books_query->getResultArray();

    // Call stages (replace with your actual logic)
    $stages = $this->getAllStages();

    $result = [];

    foreach ($books as $book) {
        $book_id = $book['book_id'];

        $rework_book_status = ($book['rework'] == 1) ? "rework" : "normal";

        foreach ($stages as $stage_id => $stage_name) {
            $stage_sql = "
                SELECT *, COUNT(*) as count 
                FROM books_progress 
                WHERE book_id = $book_id 
                  AND stage = $stage_id
            ";
            $stage_query = $db->query($stage_sql);
            $stage_details = $stage_query->getRowArray();

            if ($stage_details && $stage_details['count'] > 0) {
                $result[$rework_book_status][$book['book_title']]['stage_details'][$stage_id] = $stage_details['status'];
            } else {
                $result[$rework_book_status][$book['book_title']]['stage_details'][$stage_id] = -1;
            }

            $book_details = [
                "book_title"   => $book['book_title'],
                "author_name"  => $book['author_name'],
                "priority"     => $book['priority']
            ];
            $result[$rework_book_status][$book['book_title']]['book_details'] = $book_details;
        }
    }

    return $result;
    }
    public function pusDetails()
    {
        $db = \Config\Database::connect();
        $result = [];

        // 1. Monthly pages count
        $builder = $db->table('book_tbl')
            ->select("DATE_FORMAT(activated_at, '%m-%y') as monthly_number, SUM(number_of_page) as cnt")
            ->where('status', 1)
            ->where('type_of_book', 1)
            ->groupBy('monthly_number')
            ->orderBy('activated_at', 'ASC');
        $query = $builder->get();

        $pus_page_cnt = [];
        $month = [];
        foreach ($query->getResultArray() as $row) {
            $pus_page_cnt[] = $row['cnt'];
            $month[] = $row['monthly_number'];
        }
        $result['pus_page_cnt'] = $pus_page_cnt;
        $result['pus_page_month'] = $month;

        // 2. Genre-wise count
        $builder = $db->table('book_tbl')
            ->select('genre_details_tbl.genre_id, genre_name, COUNT(*) as cnt, SUM(number_of_page) as page_cnt')
            ->join('genre_details_tbl', 'genre_details_tbl.genre_id = book_tbl.genre_id')
            ->where('book_tbl.type_of_book', 1)
            ->where('book_tbl.status', 1)
            ->groupBy('genre_name')
            ->orderBy('cnt', 'DESC');
        $query = $builder->get();

        $pus_genre_id = $pus_genre_name = $pus_genre_cnt = $pus_genre_page_cnt = [];
        foreach ($query->getResultArray() as $row) {
            $pus_genre_id[] = $row['genre_id'];
            $pus_genre_name[] = $row['genre_name'];
            $pus_genre_cnt[] = $row['cnt'];
            $pus_genre_page_cnt[] = $row['page_cnt'];
        }
        $result['pus_genre_id'] = $pus_genre_id;
        $result['pus_genre_name'] = $pus_genre_name;
        $result['pus_genre_cnt'] = $pus_genre_cnt;
        $result['pus_genre_page_cnt'] = $pus_genre_page_cnt;

        // 3. Language-wise count
        $builder = $db->table('book_tbl')
            ->select('language_name, COUNT(*) as cnt')
            ->join('language_tbl', 'book_tbl.language = language_tbl.language_id')
            ->where('book_tbl.status', 1)
            ->where('book_tbl.type_of_book', 1)
            ->groupBy('language_name');
        $query = $builder->get();

        $pus_lang_name = $pus_lang_book_cnt = [];
        foreach ($query->getResultArray() as $row) {
            $pus_lang_name[] = $row['language_name'];
            $pus_lang_book_cnt[] = (int)$row['cnt'];
        }
        $result['pus_lang_name'] = $pus_lang_name;
        $result['pus_lang_book_cnt'] = $pus_lang_book_cnt;

        // 4. Top authors
        $builder = $db->table('author_tbl')
            ->select('author_tbl.author_name, COUNT(*) as cnt')
            ->join('book_tbl', 'author_tbl.author_id = book_tbl.author_name')
            ->where('book_tbl.language', 1)
            ->groupBy('author_tbl.author_name')
            ->orderBy('cnt', 'DESC')
            ->limit(10);
        $query = $builder->get();

        $pus_author_name = $pus_author_cnt = [];
        foreach ($query->getResultArray() as $row) {
            $pus_author_name[] = $row['author_name'];
            $pus_author_cnt[] = (int)$row['cnt'];
        }
        $result['pus_author_name'] = $pus_author_name;
        $result['pus_author_cnt'] = $pus_author_cnt;

        return $result;
    }
    public function amzDetails()
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
    $result['amz_mlylm_cnt'] = 0;
    $result['amz_eng_cnt']   = 0;

    foreach ($publishedQuery as $row) {
        if ($row->language_id == 1) { // Tamil
            $result['amz_tml_cnt'] = $row->cnt;
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
                    WHERE b.status=1 AND b.book_id IN (SELECT book_id FROM amazon_books)
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
    public function getActiveBooks()
    {
        $db = \Config\Database::connect();

        $sql = "SELECT 
                    book_tbl.*,
                    author_tbl.author_name
                FROM book_tbl
                JOIN author_tbl 
                    ON author_tbl.author_id = book_tbl.author_name
                WHERE book_tbl.type_of_book = 1
                AND book_tbl.status = 1;
                ";

        $query = $db->query($sql);
        return $query->getResultArray();
    }
    public function getLanguageWiseBookCount()
    {
        return $this->db->table('book_tbl b')
            ->select('l.language_name, COUNT(b.book_id) as total_books', false)
            ->join('language_tbl l', 'l.language_id = b.language')
            ->where(['b.status' => 1, 'b.type_of_book' => 1])
            ->groupBy('l.language_name')
            ->get()
            ->getResultArray();
    }


    public function getGenreWiseBookCount()
    {
        return $this->db->table('book_tbl b')
        ->select('g.genre_name, COUNT(b.book_id) as total_books')
        ->join('genre_details_tbl g', 'g.genre_id = b.genre_id')
        ->where(['b.status' => 1, 'b.type_of_book' => 1])  // type_of_book = 1 filter added
        ->groupBy('g.genre_name')
        ->get()
        ->getResultArray();
    }

    public function getBookCategoryCount()
    {
        return $this->db->table('book_tbl b')
        ->select('b.book_category, COUNT(b.book_id) as total_books')
        ->where('b.status', 1)
        ->where('b.type_of_book', 1)   // type_of_book filter
        ->groupBy('b.book_category')
        ->get()
        ->getResultArray();
    }

   public function getAuthorWiseBookCount()
{
    return $this->db->table('book_tbl b')
        ->select('a.author_name, COUNT(b.book_id) as total')
        ->join('author_tbl a', 'a.author_id = b.author_name', 'left')
        ->where(['b.status' => 1, 'b.type_of_book' => 1])
        ->groupBy('a.author_id')
        ->orderBy('total', 'DESC') // Use the alias instead of COUNT()
        ->get()
        ->getResultArray();
    }
    public function amzonDetails()
    {
        $db = \Config\Database::connect();   // ✅ CI4 DB connection
        $result = [];

        // Published counts
        $sql = "SELECT language_id, count(*) as cnt FROM amazon_books GROUP BY language_id";
        $query = $this->db->query($sql)->getResult();
        if (!empty($query)) {
            $result['amz_tml_cnt']   = $query[0]->cnt ?? 0;
            $result['amz_mlylm_cnt'] = $query[1]->cnt ?? 0;
            $result['amz_eng_cnt']   = $query[2]->cnt ?? 0;
        }

        // Published Tamil Books
        $sql_tamil = "SELECT b.book_id, b.book_title, a.author_name, b.epub_url
                        FROM book_tbl b, author_tbl a 
                        WHERE b.status=1 
                          AND b.book_id IN (SELECT book_id FROM amazon_books) 
                          AND b.language=1 
                          AND b.cost != 3 
                          AND b.author_name != 11 
                          AND b.type_of_book = 1 
                          AND b.author_name = a.author_id 
                          AND (type_of_book = 1 OR type_of_book = 2) 
                        ORDER BY b.book_id";

        $query = $this->db->query($sql_tamil)->getResultArray();
        $result['amazon_tml_book_id']          = array_column($query, 'book_id');
        $result['amazon_tml_book_title']       = array_column($query, 'book_title');
        $result['amazon_tml_book_author_name'] = array_column($query, 'author_name');
        $result['amazon_tml_book_epub_url']    = array_column($query, 'epub_url');

        // Malayalam
        $sql_mlylm = "SELECT b.book_id, b.book_title, a.author_name, b.epub_url
                        FROM book_tbl b, author_tbl a 
                        WHERE b.status=1 
                          AND b.book_id IN (SELECT book_id FROM amazon_books) 
                          AND b.language=4 
                          AND b.cost != 3 
                          AND b.author_name != 11 
                          AND b.type_of_book = 1 
                          AND b.author_name = a.author_id 
                          AND (type_of_book = 1 OR type_of_book = 2) 
                        ORDER BY b.book_id";
        $query = $this->db->query($sql_mlylm)->getResultArray();
        $result['amazon_mlylm_book_id']          = array_column($query, 'book_id');
        $result['amazon_mlylm_book_title']       = array_column($query, 'book_title');
        $result['amazon_mlylm_book_author_name'] = array_column($query, 'author_name');
        $result['amazon_mlylm_book_epub_url']    = array_column($query, 'epub_url');

        // English
        $sql_eng = "SELECT b.book_id, b.book_title, a.author_name, b.epub_url
                      FROM book_tbl b, author_tbl a 
                      WHERE b.status=1 
                        AND b.book_id IN (SELECT book_id FROM amazon_books) 
                        AND b.language=5 
                        AND b.cost != 3 
                        AND b.author_name != 11 
                        AND b.type_of_book = 1 
                        AND b.author_name = a.author_id 
                        AND (type_of_book = 1 OR type_of_book = 2) 
                      ORDER BY b.book_id";
        $query = $this->db->query($sql_eng)->getResultArray();
        $result['amazon_eng_book_id']          = array_column($query, 'book_id');
        $result['amazon_eng_book_title']       = array_column($query, 'book_title');
        $result['amazon_eng_book_author_name'] = array_column($query, 'author_name');
        $result['amazon_eng_book_epub_url']    = array_column($query, 'epub_url');

        // Unpublished Counts
        $sql = "SELECT b.language, COUNT(b.book_id) as cnt 
                  FROM book_tbl b, language_tbl l 
                 WHERE b.status=1 
                   AND b.book_id NOT IN (SELECT book_id FROM amazon_books) 
                   AND b.cost != 3 
                   AND b.author_name != 11 
                   AND b.type_of_book = 1 
                   AND b.language=l.language_id 
              GROUP BY b.language";
        $query = $this->db->query($sql)->getResult();
        if (!empty($query)) {
            $result['amz_tml_unpub_cnt']   = $query[0]->cnt ?? 0;
            $result['amz_mlylm_unpub_cnt'] = $query[1]->cnt ?? 0;
            $result['amz_eng_unpub_cnt']   = $query[2]->cnt ?? 0;
        }

        // Unpublished Tamil
        $sql = "SELECT b.book_id, b.book_title, a.author_name, b.epub_url
                  FROM book_tbl b, author_tbl a 
                 WHERE b.status=1 
                   AND b.book_id NOT IN (SELECT book_id FROM amazon_books) 
                   AND b.language=1 
                   AND b.cost != 3 
                   AND b.author_name != 11 
                   AND b.type_of_book = 1 
                   AND b.author_name = a.author_id 
                   AND (type_of_book = 1 OR type_of_book = 2) 
              ORDER BY b.book_id";
        $query = $this->db->query($sql)->getResultArray();
        $result['amz_tml_book_id']          = array_column($query, 'book_id');
        $result['amz_tml_book_title']       = array_column($query, 'book_title');
        $result['amz_tml_book_author_name'] = array_column($query, 'author_name');
        $result['amz_tml_book_epub_url']    = array_column($query, 'epub_url');

        // Tamil Short Stories
        $sql = "SELECT b.book_id, b.book_title, a.author_name, b.epub_url
                  FROM book_tbl b, author_tbl a 
                 WHERE b.status=1 
                   AND b.book_id NOT IN (SELECT book_id FROM amazon_books) 
                   AND b.language=1 
                   AND b.author_name = a.author_id 
                   AND type_of_book = 1 
                   AND b.cost <> 3 
              ORDER BY b.book_id";
        $query = $this->db->query($sql)->getResultArray();
        $result['amz_short_stories_id']          = array_column($query, 'book_id');
        $result['amz_short_stories_title']       = array_column($query, 'book_title');
        $result['amz_short_stories_author_name'] = array_column($query, 'author_name');
        $result['amz_short_stories_epub_url']    = array_column($query, 'epub_url');

        // Malayalam Unpublished
        $sql = "SELECT b.book_id, b.book_title, a.author_name, b.epub_url
                  FROM book_tbl b, author_tbl a 
                 WHERE b.status=1 
                   AND b.book_id NOT IN (SELECT book_id FROM amazon_books) 
                   AND b.language=4 
                   AND b.author_name = a.author_id 
                   AND type_of_book = 1 
              ORDER BY b.book_id";
        $query = $this->db->query($sql)->getResultArray();
        $result['amz_mlylm_book_id']          = array_column($query, 'book_id');
        $result['amz_mlylm_book_title']       = array_column($query, 'book_title');
        $result['amz_mlylm_book_author_name'] = array_column($query, 'author_name');
        $result['amz_mlylm_book_epub_url']    = array_column($query, 'epub_url');

        // English Unpublished
        $sql = "SELECT b.book_id, b.book_title, a.author_name, b.epub_url
                  FROM book_tbl b, author_tbl a 
                 WHERE b.status=1 
                   AND b.book_id NOT IN (SELECT book_id FROM amazon_books) 
                   AND b.language=5 
                   AND b.author_name = a.author_id 
                   AND type_of_book = 1 
              ORDER BY b.book_id";
        $query = $this->db->query($sql)->getResultArray();
        $result['amz_eng_book_id']          = array_column($query, 'book_id');
        $result['amz_eng_book_title']       = array_column($query, 'book_title');
        $result['amz_eng_book_author_name'] = array_column($query, 'author_name');
        $result['amz_eng_book_epub_url']    = array_column($query, 'epub_url');

        return $result;
    }
   public function scribdDetails()
{
    $db = \Config\Database::connect(); 
    $result = [];

    // --- Initialize counts and arrays for all languages ---
    $languages = ['tamil', 'kannada', 'telugu', 'malayalam', 'english'];
    foreach ($languages as $lang) {
        // Published / unpublished counts
        $result['scr_' . $lang . '_cnt'] = 0;
        $result['scr_' . $lang . '_unpub_cnt'] = 0;

        // Published book arrays
        $result["scribd_{$lang}_book_id"] = [];
        $result["scribd_{$lang}_book_title"] = [];
        $result["scribd_{$lang}_book_author_name"] = [];
        $result["scribd_{$lang}_book_epub_url"] = [];

        // Unpublished book arrays
        $result["scribd_{$lang}_unpub_book_id"] = [];
        $result["scribd_{$lang}_unpub_book_title"] = [];
        $result["scribd_{$lang}_unpub_book_author_name"] = [];
        $result["scribd_{$lang}_unpub_book_epub_url"] = [];
    }

    // --- Published counts by language ---
    $sql = "SELECT l.language_name, COUNT(s.language_id) AS cnt
            FROM scribd_books AS s
            JOIN language_tbl AS l ON s.language_id = l.language_id
            GROUP BY s.language_id, l.language_name";
    $query = $db->query($sql)->getResult();
    foreach ($query as $row) {
        $key = 'scr_' . strtolower($row->language_name) . '_cnt';
        $result[$key] = $row->cnt;
    }

    // --- Published book details ---
    foreach ($languages as $lang) {
        $lang_id = match($lang) {
            'tamil' => 1,
            'kannada' => 2,
            'telugu' => 3,
            'malayalam' => 4,
            'english' => 5,
        };

        $sql_books = "SELECT b.book_id, b.book_title, a.author_name, b.epub_url
                      FROM book_tbl b
                      JOIN author_tbl a ON b.author_name = a.author_id
                      WHERE b.status = 1
                      AND b.book_id IN (SELECT book_id FROM scribd_books)
                      AND b.language = $lang_id
                      " . ($lang == 'tamil' ? "AND (b.type_of_book = 1 OR b.type_of_book = 2)" : "AND b.type_of_book = 1") . "
                      ORDER BY b.book_id";
        $rows = $db->query($sql_books)->getResultArray();

        $result["scribd_{$lang}_book_id"]          = array_column($rows, 'book_id');
        $result["scribd_{$lang}_book_title"]       = array_column($rows, 'book_title');
        $result["scribd_{$lang}_book_author_name"] = array_column($rows, 'author_name');
        $result["scribd_{$lang}_book_epub_url"]    = array_column($rows, 'epub_url');
    }

    // --- Unpublished counts ---
    $sql = "SELECT l.language_name, COUNT(b.book_id) AS cnt
            FROM book_tbl b
            JOIN language_tbl l ON b.language = l.language_id
            WHERE b.status = 1
            AND b.book_id NOT IN (SELECT book_id FROM scribd_books)
            GROUP BY b.language, l.language_name";
    $query = $db->query($sql)->getResult();
    foreach ($query as $row) {
        $key = 'scr_' . strtolower($row->language_name) . '_unpub_cnt';
        $result[$key] = $row->cnt;
    }

    // --- Unpublished book details ---
    foreach ($languages as $lang) {
        $lang_id = match($lang) {
            'tamil' => 1,
            'kannada' => 2,
            'telugu' => 3,
            'malayalam' => 4,
            'english' => 5,
        };

        $sql_unpub = "SELECT b.book_id, b.book_title, a.author_name, b.epub_url
                      FROM book_tbl b
                      JOIN author_tbl a ON b.author_name = a.author_id
                      WHERE b.status = 1
                      AND b.book_id NOT IN (SELECT book_id FROM scribd_books)
                      AND b.language = $lang_id
                      ORDER BY b.book_id";
        $rows_unpub = $db->query($sql_unpub)->getResultArray();

        $result["scribd_{$lang}_unpub_book_id"]          = array_column($rows_unpub, 'book_id');
        $result["scribd_{$lang}_unpub_book_title"]       = array_column($rows_unpub, 'book_title');
        $result["scribd_{$lang}_unpub_book_author_name"] = array_column($rows_unpub, 'author_name');
        $result["scribd_{$lang}_unpub_book_epub_url"]    = array_column($rows_unpub, 'epub_url');
    }

    return $result;
}
public function storytelDetails()
{
    $db = \Config\Database::connect();
    $result = [];

    // Define languages
    $languages = [
        1 => 'tamil',
        2 => 'kannada',
        3 => 'telugu',
        4 => 'malayalam',
        5 => 'english'
    ];

    foreach ($languages as $langId => $langName) {

        
        // Published count
        
        $publishedCount = $db->table('book_tbl b')
            ->join('storytel_books s', 'b.book_id = s.book_id', 'inner')
            ->where('b.status', 1)
            ->where('b.language', $langId)
            ->whereIn('b.type_of_book', [1,2])
            ->countAllResults();

        $result['scr_' . $langName . '_cnt'] = $publishedCount;

        
        // Unpublished count
        
        $unpublishedCount = $db->table('book_tbl b')
            ->where('b.status', 1)
            ->where('b.language', $langId)
            ->whereIn('b.type_of_book', [1,2])
            ->whereNotIn('b.book_id', function($builder){
                $builder->select('book_id')->from('storytel_books');
            })
            ->countAllResults();

        $result['scr_' . $langName . '_unpub_cnt'] = $unpublishedCount;

        
        // Published books
        
        $publishedBooks = $db->table('book_tbl b')
            ->select('b.book_id, b.book_title, a.author_name, b.epub_url, l.language_name')
            ->join('author_tbl a', 'b.author_name = a.author_id', 'left')
            ->join('language_tbl l', 'b.language = l.language_id', 'left')
            ->where('b.status', 1)
            ->where('b.language', $langId)
            ->whereIn('b.type_of_book', [1,2])
            ->whereIn('b.book_id', function($builder){
                $builder->select('book_id')->from('storytel_books');
            })
            ->orderBy('b.book_id', 'ASC')
            ->get()
            ->getResultArray();

        $result['scr_' . $langName . '_books'] = $publishedBooks;

        
        // Unpublished books
        
        $unpublishedBooks = $db->table('book_tbl b')
            ->select('b.book_id, b.book_title, a.author_name, b.epub_url, l.language_name')
            ->join('author_tbl a', 'b.author_name = a.author_id', 'left')
            ->join('language_tbl l', 'b.language = l.language_id', 'left')
            ->where('b.status', 1)
            ->where('b.language', $langId)
            ->whereIn('b.type_of_book', [1,2])
            ->whereNotIn('b.book_id', function($builder){
                $builder->select('book_id')->from('storytel_books');
            })
            ->orderBy('b.book_id', 'ASC')
            ->get()
            ->getResultArray();

        $result['scr_' . $langName . '_unpub_books'] = $unpublishedBooks;
    }

    return $result;
}
   public function googleDetails()
{
    $db = \Config\Database::connect();
    $result = [];

    
    // Published counts by language
    
    $query = $db->table('google_books gb')
        ->select('l.language_name, COUNT(gb.book_id) as cnt')
        ->join('language_tbl l', 'gb.language_id = l.language_id', 'left')
        ->where('gb.language_id IS NOT NULL')
        ->groupBy('l.language_name')
        ->orderBy('l.language_id', 'ASC')
        ->get();

    $tmp = $query->getResult();

    // Initialize published counts
    $result['published_counts'] = [
        'Tamil'     => 0,
        'Kannada'   => 0,
        'Telugu'    => 0,
        'Malayalam' => 0,
        'English'   => 0,
    ];

    foreach ($tmp as $row) {
        $result['published_counts'][$row->language_name] = $row->cnt;
    }

    // Helper function to fetch published books
    $fetchPublished = function($langId) use ($db) {
        return $db->table('book_tbl b')
            ->select('b.book_id, b.book_title, a.author_name, b.epub_url, l.language_name')
            ->join('author_tbl a', 'b.author_name = a.author_id', 'left')
            ->join('language_tbl l', 'b.language = l.language_id', 'left')
            ->where('b.status', 1)
            ->where('b.language', $langId)
            ->whereIn('b.type_of_book', ($langId == 1) ? [1,2] : [1]) // Tamil special case
            ->whereIn('b.book_id', function($builder) {
                return $builder->select('book_id')->from('google_books');
            })
            ->orderBy('b.book_id', 'ASC')
            ->get()
            ->getResultArray();
    };

    // Fetch published books by language
    $result['google_tamil']     = $fetchPublished(1);
    $result['google_kannada']   = $fetchPublished(2);
    $result['google_telugu']    = $fetchPublished(3);
    $result['google_malayalam'] = $fetchPublished(4);
    $result['google_english']   = $fetchPublished(5);

    
    // Unpublished counts by language
    
    $query = $db->table('book_tbl b')
        ->select('l.language_name, COUNT(b.book_id) as cnt')
        ->join('language_tbl l', 'b.language = l.language_id', 'left')
        ->where('b.status', 1)
        ->whereIn('b.type_of_book', [1,2])
        ->whereNotIn('b.book_id', function($builder) {
            return $builder->select('book_id')->from('google_books');
        })
        ->groupBy('l.language_name')
        ->orderBy('l.language_id', 'ASC')
        ->get();

    $tmp = $query->getResult();

    // Initialize unpublished counts
    $result['unpublished_counts'] = [
        'Tamil'     => 0,
        'Kannada'   => 0,
        'Telugu'    => 0,
        'Malayalam' => 0,
        'English'   => 0,
    ];

    foreach ($tmp as $row) {
        $result['unpublished_counts'][$row->language_name] = $row->cnt;
    }

    // Helper function to fetch unpublished books
    $fetchUnpublished = function($langId) use ($db) {
        return $db->table('book_tbl b')
            ->select('b.book_id, b.book_title, a.author_name, b.epub_url, l.language_name')
            ->join('author_tbl a', 'b.author_name = a.author_id', 'left')
            ->join('language_tbl l', 'b.language = l.language_id', 'left')
            ->where('b.status', 1)
            ->where('b.language', $langId)
            ->whereIn('b.type_of_book', ($langId == 1) ? [1,2] : [1]) // Tamil special case
            ->whereNotIn('b.book_id', function($builder) {
                return $builder->select('book_id')->from('google_books');
            })
            ->orderBy('b.book_id', 'ASC')
            ->get()
            ->getResultArray();
    };

    // Fetch unpublished books by language
    $result['google_tml_unpublished']   = $fetchUnpublished(1);
    $result['google_kan_unpublished']   = $fetchUnpublished(2);
    $result['google_tel_unpublished']   = $fetchUnpublished(3);
    $result['google_mlylm_unpublished'] = $fetchUnpublished(4);
    $result['google_eng_unpublished']   = $fetchUnpublished(5);

    return $result;
}

public function overdriveDetails()
{
    $db = \Config\Database::connect();
    $result = [];
    // Published counts by language
    $sql = "
        SELECT l.language_name, COUNT(o.book_id) as cnt
        FROM overdrive_books o
        JOIN book_tbl b ON b.book_id = o.book_id
        JOIN language_tbl l ON b.language = l.language_id
        WHERE b.status = 1 AND b.type_of_book = 1
        GROUP BY l.language_name
    ";
    $query = $db->query($sql)->getResultArray();

    foreach ($query as $row) {
        $key = strtolower($row['language_name']); // tamil, kannada, malayalam, english
        $result['over_' . $key . '_cnt'] = $row['cnt'];
    }    
    // Published book details by language    
    $languages = ['Tamil' => 1, 'Kannada' => 2, 'Malayalam' => 4, 'English' => 5];

    foreach ($languages as $langName => $langId) {
        $sql = "
            SELECT b.book_id, b.book_title, a.author_name, b.epub_url
            FROM book_tbl b
            JOIN author_tbl a ON b.author_name = a.author_id
            WHERE b.status = 1 
              AND b.type_of_book = 1
              AND b.book_id IN (SELECT book_id FROM overdrive_books)
              AND b.language = ?
            ORDER BY b.book_id
        ";
        $books = $db->query($sql, [$langId])->getResultArray();
        $result['over_' . strtolower($langName) . '_books'] = $books;
    }   
    // Unpublished counts by language    
    $sql = "
        SELECT l.language_name, COUNT(b.book_id) as cnt
        FROM book_tbl b
        JOIN language_tbl l ON b.language = l.language_id
        WHERE b.status = 1 
          AND b.type_of_book = 1
          AND b.book_id NOT IN (SELECT book_id FROM overdrive_books)
        GROUP BY l.language_name
    ";
    $query = $db->query($sql)->getResultArray();

    foreach ($query as $row) {
        $key = strtolower($row['language_name']);
        $result['over_' . $key . '_unpub_cnt'] = $row['cnt'];
    }
  
    // Unpublished book details by language
    foreach ($languages as $langName => $langId) {
        $sql = "
            SELECT b.book_id, b.book_title, a.author_name, b.epub_url
            FROM book_tbl b
            JOIN author_tbl a ON b.author_name = a.author_id
            WHERE b.status = 1 
              AND b.type_of_book = 1
              AND b.book_id NOT IN (SELECT book_id FROM overdrive_books)
              AND b.language = ?
            ORDER BY b.book_id
        ";
        $books = $db->query($sql, [$langId])->getResultArray();
        $result['over_' . strtolower($langName) . '_unpub_books'] = $books;
    }

    return $result;
}
public function pratilipiDetails()
{
    $db = \Config\Database::connect();
    $result = [];

    // Published counts by language
    $query = $db->table('pratilipi_books pb')
        ->select('l.language_name, COUNT(pb.book_id) as cnt')
        ->join('language_tbl l', 'pb.language_id = l.language_id', 'left')
        ->where('pb.language_id IS NOT NULL')
        ->groupBy('l.language_name')
        ->orderBy('l.language_id', 'ASC')
        ->get();

    $tmp = $query->getResult();

    // Initialize counts
    $result['published_counts'] = [
        'Tamil'     => 0,
        'Kannada'   => 0,
        'Telugu'    => 0,
        'Malayalam' => 0,
        'English'   => 0,
    ];

    foreach ($tmp as $row) {
        $result['published_counts'][$row->language_name] = $row->cnt;
    }

    // Helper function to fetch published books by language
    $fetchPublished = function($langId) use ($db) {
        return $db->table('book_tbl b')
            ->select('b.book_id, b.book_title, a.author_name, b.epub_url, l.language_name')
            ->join('author_tbl a', 'b.author_name = a.author_id', 'left')
            ->join('language_tbl l', 'b.language = l.language_id', 'left')
            ->where('b.status', 1)
            ->where('b.type_of_book', 1)
            ->where('b.language', $langId)
            ->whereIn('b.book_id', function($builder) {
                return $builder->select('book_id')->from('pratilipi_books');
            })
            ->orderBy('b.book_id', 'ASC')
            ->get()
            ->getResultArray();
    };

    // Fetch published books by language
    $result['pratilipi_tamil']     = $fetchPublished(1);
    $result['pratilipi_kannada']   = $fetchPublished(2);
    $result['pratilipi_telugu']    = $fetchPublished(3);
    $result['pratilipi_malayalam'] = $fetchPublished(4);
    $result['pratilipi_english']   = $fetchPublished(5);

    // Unpublished counts by language
    $query = $db->table('book_tbl b')
        ->select('l.language_name, COUNT(b.book_id) as cnt')
        ->join('language_tbl l', 'b.language = l.language_id', 'left')
        ->where('b.status', 1)
        ->where('b.type_of_book', 1)
        ->whereNotIn('b.book_id', function($builder) {
            return $builder->select('book_id')->from('pratilipi_books');
        })
        ->groupBy('l.language_name')
        ->orderBy('l.language_id', 'ASC')
        ->get();

    $tmp = $query->getResult();

    // Initialize unpublished counts
    $result['unpublished_counts'] = [
        'Tamil'     => 0,
        'Kannada'   => 0,
        'Telugu'    => 0,
        'Malayalam' => 0,
        'English'   => 0,
    ];

    foreach ($tmp as $row) {
        $result['unpublished_counts'][$row->language_name] = $row->cnt;
    }

    // Helper function to fetch unpublished books by language
    $fetchUnpublished = function($langId) use ($db) {
        return $db->table('book_tbl b')
            ->select('b.book_id, b.book_title, a.author_name, b.epub_url, l.language_name')
            ->join('author_tbl a', 'b.author_name = a.author_id', 'left')
            ->join('language_tbl l', 'b.language = l.language_id', 'left')
            ->where('b.status', 1)
            ->where('b.type_of_book', 1)
            ->where('b.language', $langId)
            ->whereNotIn('b.book_id', function($builder) {
                return $builder->select('book_id')->from('pratilipi_books');
            })
            ->orderBy('b.book_id', 'ASC')
            ->get()
            ->getResultArray();
    };

    // Fetch unpublished books by language
    $result['prat_tml_unpublished']   = $fetchUnpublished(1);
    $result['prat_kan_unpublished']   = $fetchUnpublished(2);
    $result['prat_tel_unpublished']   = $fetchUnpublished(3);
    $result['prat_mlylm_unpublished'] = $fetchUnpublished(4);
    $result['prat_eng_unpublished']   = $fetchUnpublished(5);

    return $result;
}
 


}