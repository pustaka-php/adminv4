<?php

namespace App\Models;

use CodeIgniter\Model;

class AudiobookModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getDashboardData()
    {
        $builder = $this->db->table('book_tbl');
        $builder->select('status, COUNT(*) AS cnt')
                ->where('type_of_book', 3) 
                ->groupBy('status');
        $result1 = $builder->get()->getResultArray();

        $audiobookCounts = [
            'total_books' => 0,
            'inactive_books' => 0,
            'active_books' => 0,
            'withdrawn_books' => 0
        ];
         $audio = array('books_count'=>0);
        foreach ($result1 as $row) {
            $audio['books_count'] += $row['cnt'];

            if ($row['status'] == 0) {
                $audio['inactive'] = $row['cnt'];
            } elseif ($row['status'] == 1) {
                $audio['active'] = $row['cnt'];
            } elseif ($row['status'] == 2) {
                $audio['withdrawn'] = $row['cnt'];
            }
        }
        $audio['channel_name'] = "audio";
        $result['audio'] = $audio;
        $sql1 = "

            SELECT 'Pustaka' AS channel_name, COUNT(DISTINCT book_id) AS books_count
            FROM book_tbl
            WHERE type_of_book = 3 AND status = 1

            UNION ALL

            SELECT 'Audible', COUNT(DISTINCT book_id)
            FROM audible_books

            UNION ALL

            SELECT 'Google Books', COUNT(DISTINCT book_id)
            FROM google_books
            WHERE book_format = 'Audiobook'

            UNION ALL

            SELECT 'Storytel', COUNT(DISTINCT book_id)
            FROM storytel_books
            WHERE type_of_book = 3

            UNION ALL

            SELECT 'OverDrive', COUNT(DISTINCT book_id)
            FROM overdrive_books
            WHERE type_of_book = 3

            UNION ALL

            SELECT 'Kuku FM', COUNT(DISTINCT book_id)
            FROM kukufm_books

            UNION ALL

            SELECT 'YouTube', COUNT(DISTINCT book_id)
            FROM youtube_transaction;

            ";
        $query = $this->db->query($sql1);
        foreach ($query->getResultArray() as $row)
        {
            $res['channel_name'] = $row['channel_name'];
            $res['books_count'] = $row['books_count'];
            $result[$res['channel_name']] = $res;
        }     
        
        return $result;
    }
     public function getAudiobookDetails($status = null)
{
    $sql = "SELECT 
                book_tbl.book_id, 
                book_tbl.book_title, 
                author_tbl.author_name, 
                book_tbl.status, 
                book_tbl.created_at
            FROM book_tbl
            JOIN author_tbl ON book_tbl.author_name = author_tbl.author_id
            WHERE book_tbl.type_of_book = 3";

    if ($status !== null) {
        $sql .= " AND book_tbl.status = ?";
        $query = $this->db->query($sql, [$status]);
    } else {
        $query = $this->db->query($sql);
    }

    return $query->getResultArray();
}
    public function getBookDashboardData(): array
{
    $db = \Config\Database::connect();
    $result = [];

    // Language map (id => code)
    $languages = [
        1 => 'tml',
        2 => 'kan',
        3 => 'tel',
        4 => 'mlylm',
        5 => 'eng'
    ];

    // Helper to normalize counts
    $normalize = function($rows, $key = 'language_id') use ($languages) {
        $counts = [];
        foreach ($languages as $id => $code) {
            $counts[$code] = 0; // default 0
        }
        foreach ($rows as $row) {
            $langId = $row[$key];
            if (isset($languages[$langId])) {
                $code = $languages[$langId];
                $counts[$code] = (int)$row['cnt'];
            }
        }
        return $counts;
    };

    //Pustaka
    $rows = $db->query("
        SELECT language AS language_id, COUNT(*) AS cnt
        FROM book_tbl 
        WHERE type_of_book = 3 AND status = 1
        GROUP BY language
    ")->getResultArray();
    $pus = $normalize($rows, 'language_id');
    foreach ($pus as $code => $cnt) {
        $result["pus_{$code}_cnt"] = $cnt;
    }

    //Overdrive
    $rows = $db->query("
        SELECT language_id, COUNT(*) AS cnt
        FROM overdrive_books
        WHERE type_of_book = 3
        GROUP BY language_id
    ")->getResultArray();
    $over = $normalize($rows);
    foreach ($over as $code => $cnt) {
        $result["over_{$code}_cnt"] = $cnt;
    }

    //Google Books
$rows = $db->query("
    SELECT gb.language_id, COUNT(*) AS cnt
    FROM google_books gb
    JOIN book_tbl b ON b.book_id = gb.book_id
    WHERE b.type_of_book = 3
    GROUP BY gb.language_id
")->getResultArray();
$goog = $normalize($rows, 'language_id');
foreach ($goog as $code => $cnt) {
    $result["goog_{$code}_cnt"] = $cnt;
}

    //Storytel
    $rows = $db->query("
       SELECT l.language_id, l.language_name, COUNT(*) as cnt 
        FROM storytel_books sb
        JOIN book_tbl b ON b.book_id = sb.book_id
        JOIN language_tbl l ON b.language = l.language_id
        WHERE b.type_of_book = 3
        GROUP BY l.language_id, l.language_name
    ")->getResultArray();
    $storytel = $normalize($rows);
    foreach ($storytel as $code => $cnt) {
        $result["storytel_{$code}_cnt"] = $cnt;
    }

    //Audible
    $rows = $db->query("
        SELECT l.language_id, l.language_name, COUNT(*) as cnt
        FROM audible_books ab
        JOIN book_tbl b ON b.book_id = ab.book_id
        JOIN language_tbl l ON b.language = l.language_id
        GROUP BY l.language_name
    ")->getResultArray();
    $aud = $normalize($rows, 'language_id');
    foreach ($aud as $code => $cnt) {
        $result["aud_{$code}_cnt"] = $cnt;
    }

    //KukuFM
    $rows = $db->query("
        SELECT kf.language_id, COUNT(*) AS cnt
        FROM kukufm_books kf
        JOIN book_tbl b ON b.book_id = kf.book_id
        WHERE b.type_of_book = 3
        GROUP BY kf.language_id
    ")->getResultArray();
    $ku = $normalize($rows);
    foreach ($ku as $code => $cnt) {
        $result["ku_{$code}_cnt"] = $cnt;
    }

    //YouTube
    $rows = $db->query("
        SELECT yt.language_id, COUNT(*) AS cnt
        FROM youtube_transaction yt
        JOIN book_tbl b ON b.book_id = yt.book_id
        WHERE b.type_of_book = 3
        GROUP BY yt.language_id
    ")->getResultArray();
    $you = $normalize($rows);
    foreach ($you as $code => $cnt) {
        $result["you_{$code}_cnt"] = $cnt;
    }

    return $result;
}

        public function getAudioBookDashboardData()
{
    $result = [];

    // Active Audio Books
    $activeAudioBooks = $this->db->table('book_tbl b')
        ->select('b.book_id, b.book_title, a.author_name, n.narrator_name, b.number_of_page, l.language_name')
        ->join('author_tbl a', 'b.author_name = a.author_id', 'left')
        ->join('narrator_tbl n', 'b.narrator_id = n.narrator_id', 'left')
        ->join('language_tbl l', 'b.language = l.language_id', 'left')
        ->where(['b.type_of_book' => 3, 'b.status' => 1])
        ->get()
        ->getResultArray();

    // Inactive Audio Books
    $inactiveAudioBooks = $this->db->table('book_tbl b')
        ->select('b.book_id, b.book_title, a.author_name, n.narrator_name, b.number_of_page, l.language_name')
        ->join('author_tbl a', 'b.author_name = a.author_id', 'left')
        ->join('narrator_tbl n', 'b.narrator_id = n.narrator_id', 'left')
        ->join('language_tbl l', 'b.language = l.language_id', 'left')
        ->where(['b.type_of_book' => 3, 'b.status' => 0])
        ->get()
        ->getResultArray();

    // Cancelled Audio Books
    $cancelledAudioBooks = $this->db->table('book_tbl b')
        ->select('b.book_id, b.book_title, a.author_name, n.narrator_name, b.number_of_page, l.language_name')
        ->join('author_tbl a', 'b.author_name = a.author_id', 'left')
        ->join('narrator_tbl n', 'b.narrator_id = n.narrator_id', 'left')
        ->join('language_tbl l', 'b.language = l.language_id', 'left')
        ->where(['b.type_of_book' => 3, 'b.status' => 2])
        ->get()
        ->getResultArray();

    // Graph Data
    $graphQuery = $this->db->table('book_tbl')
        ->select("COUNT(*) AS cnt, DATE_FORMAT(activated_at, '%b, %y') AS date_activated")
        ->where(['type_of_book' => 3, 'status' => 1])
        ->where('activated_at IS NOT NULL')
        ->groupBy('date_activated')
        ->orderBy('activated_at', 'ASC')
        ->get()
        ->getResultArray();

    $graphData = [
        'activated_cnt' => [],
        'activated_date' => []
    ];

    foreach ($graphQuery as $row) {
        $graphData['activated_cnt'][] = $row['cnt'];
        $graphData['activated_date'][] = $row['date_activated'];
    }

    // Language-wise Pustaka Dashboard Counts
    $pustakaQuery = $this->db->table('book_tbl b')
        ->select('l.language_name, COUNT(b.book_id) as cnt')
        ->join('language_tbl l', 'b.language = l.language_id', 'left')
        ->where(['b.type_of_book' => 3, 'b.status' => 1])
        ->groupBy('b.language, l.language_name')
        ->get()
        ->getResult();

    $dashboardCounts = [];
    foreach ($pustakaQuery as $row) {
        $dashboardCounts["pus_{$row->language_name}_cnt"] = $row->cnt;
    }

    // External Platforms
    $platforms = [
        'amazon_books'    => 'amz',
        'scribd_books'    => 'scr',
        'storytel_books'  => 'storytel',
        'google_books'    => 'goog',
        'overdrive_books' => 'over',
        'pratilipi_books' => 'prat',
    ];

    foreach ($platforms as $table => $prefix) {
        $platformQuery = $this->db->table($table)
            ->select('l.language_name, COUNT(*) as cnt')
            ->join('language_tbl l', "{$table}.language_id = l.language_id", 'left')
            ->where("{$table}.language_id IS NOT NULL")
            ->groupBy("{$table}.language_id, l.language_name")
            ->get()
            ->getResult();

        foreach ($platformQuery as $row) {
            $dashboardCounts["{$prefix}_{$row->language_name}_cnt"] = $row->cnt;
        }
    }

    // Final Result
    $result = [
        'active_audio_books'    => $activeAudioBooks,
        'inactive_audio_books'  => $inactiveAudioBooks,
        'cancelled_audio_books' => $cancelledAudioBooks,
        'graph_data'            => $graphData,
        'dashboard_data'        => $dashboardCounts
    ];

    return $result;
}


    public function addAudioBook(array $data)
    {
        $db = \Config\Database::connect();

        // Language mapping
        $langMap = [
            1 => ['tam','tamil'],
            2 => ['kan','kannada'],
            3 => ['tel','telugu'],
            4 => ['mal','malayalam'],
        ];
        [$language,$full_lang_name] = $langMap[$data['lang_id']] ?? ['eng','english'];

        // Genre details
        $genreRow = $db->table('genre_details_tbl')
                       ->select('url_name, genre_id')
                       ->where('genre_id',$data['genre_id'])
                       ->get()
                       ->getRowArray();
        $genre_name = $genreRow['url_name'] ?? '';

        // Paths
        $cover_file_path = $language.'/cover/'.$genre_name.'/'.$data['url_title'].'.jpg';
        $book_file_path  = $language.'/book/'.$genre_name.'/'.$data['url_title'].'/';

        // Author details
        $authorRow = $db->table('author_tbl')
                        ->select('user_id, copyright_owner')
                        ->where('author_id',$data['author_id'])
                        ->get()
                        ->getRowArray();
        $author_user_id   = $authorRow['user_id'] ?? 0;
        $copyright_owner  = $authorRow['copyright_owner'] ?? '';

        // Check duplicate url_name
        $check = $db->table('book_tbl')->where('url_name',$data['url_title'])->countAllResults();
        if ($check > 0) {
            return 2; // already exists
        }

        // Insert
        $insertData = [
            "author_name"              => $data['author_id'],
            "narrator_id"              => $data['narrator_id'],
            "book_title"               => $data['title'],
            "regional_book_title"      => $data['regional_title'],
            "language"                 => $data['lang_id'],
            "description"              => $data['desc_text'],
            "book_category"            => $data['book_category'],
            "royalty"                  => $data['royalty'],
            "copyright_owner"          => $copyright_owner,
            "genre_id"                 => $data['genre_id'],
            "number_of_page"           => $data['no_of_minutes'],
            "status"                   => 0,
            "type_of_book"             => 3,
            "cover_image"              => $cover_file_path,
            "download_link"            => $book_file_path,
            "url_name"                 => $data['url_title'],
            "cost"                     => $data['cost_inr'],
            "book_cost_international"  => $data['cost_usd'],
            "rental_cost_inr"          => $data['rental_cost_inr'],
            "rental_cost_usd"          => $data['rental_cost_usd'],
            "created_by"               => session()->get('user_id'),
        ];

        $db->table('book_tbl')->insert($insertData);
        $lastId = $db->insertID();

        return $lastId ? $data['lang_id'] : 0;
    }
          public function addAudioBookChapter($data)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('audio_book_details');   // ✅ table used inside function only

        $insertData = [
            "book_id"              => $data['book_id'] ?? null,
            "chapter_id"           => $data['chp_id'] ?? null,
            "chapter_name"         => $data['regional_name'] ?? null,
            "chapter_name_english" => $data['title'] ?? null,
            "chapter_url"          => $data['file_path'] ?? null,
            "chapter_duration"     => $data['chapter_duration'] ?? null,
        ];

        $builder->insert($insertData);
        return $db->insertID();  // last inserted id
    }
    public function getAudioBookChaptersData($book_id)
    {
        // ✅ Fetch book info
        $bookQuery = $this->db->table('book_tbl')
            ->select('book_tbl.*, language_tbl.url_name AS language_url_name, genre_details_tbl.url_name AS genre_url_name, book_tbl.url_name AS url_name')
            ->join('genre_details_tbl', 'book_tbl.genre_id = genre_details_tbl.genre_id')
            ->join('language_tbl', 'book_tbl.language = language_tbl.language_id')
            ->where('book_tbl.book_id', $book_id)
            ->get();

        $book_info = $bookQuery->getRowArray();

        $result = [];
        if ($book_info) {
            $result['book_info'] = $book_info;
        }

        // ✅ Fetch chapters
        $chaptersQuery = $this->db->table('audio_book_details')
            ->where('book_id', $book_id)
            ->get();

        $chapters_data = $chaptersQuery->getResultArray();

        if (!empty($chapters_data)) {
            $result['chapters_data'] = $chapters_data;
        }

        return $result;
    }
    // Language Wise Books
    public function getLanguageWiseBookCount()
    {
        return $this->db->table('book_tbl b')
            ->select('l.language_name, COUNT(b.book_id) as total_books')
            ->join('language_tbl l', 'l.language_id = b.language')
            ->where(['b.status' => 1, 'b.type_of_book' => 3])
            ->groupBy('l.language_name')
            ->orderBy('total_books', 'DESC')
            ->get()
            ->getResultArray();
    }

    // Genre Wise Books
    public function getGenreWiseBookCount()
    {
        return $this->db->table('book_tbl b')
            ->select('g.genre_name, COUNT(b.book_id) as total_books')
            ->join('genre_details_tbl g', 'g.genre_id = b.genre_id')
            ->where(['b.status' => 1, 'b.type_of_book' => 3])
            ->groupBy('g.genre_name')
            ->orderBy('total_books', 'DESC')
            ->get()
            ->getResultArray();
    }

    // Category Wise Books
    public function getBookCategoryCount()
    {
        return $this->db->table('book_tbl b')
            ->select('b.book_category, COUNT(b.book_id) as total_books')
            ->where(['b.status' => 1, 'b.type_of_book' => 3])
            ->groupBy('b.book_category')
            ->orderBy('total_books', 'DESC')
            ->get()
            ->getResultArray();
    }

    // Author Wise Books
    public function getAuthorWiseBookCount()
    {
        return $this->db->table('book_tbl b')
            ->select('a.author_name, COUNT(b.book_id) as total')
            ->join('author_tbl a', 'a.author_id = b.author_name', 'left')
            ->where(['b.status' => 1, 'b.type_of_book' => 3])
            ->groupBy('a.author_id')
            ->orderBy('total', 'DESC')
            ->get()
            ->getResultArray();
    }
    public function overdriveAudioDetails($langId = null)
    {
        $result = [];
        $languages = [
            1 => 'tamil',
            2 => 'kannada',
            3 => 'telugu',
            4 => 'malayalam',
            5 => 'english'
        ];

        // Summary counts (only if $langId not passed)
        if ($langId === null) {
            // Published counts
            $query = $this->db->query("
                SELECT b.language, COUNT(ob.book_id) as cnt
                FROM overdrive_books ob
                LEFT JOIN book_tbl b ON b.book_id = ob.book_id
                WHERE b.type_of_book = 3
                GROUP BY b.language
            ")->getResult();

            foreach ($languages as $id => $name) {
                $result['over_' . $name . '_cnt'] = 0;
            }

            foreach ($query as $row) {
                $langName = $languages[$row->language] ?? null;
                if ($langName) $result['over_' . $langName . '_cnt'] = $row->cnt;
            }

            // Unpublished counts
            $query = $this->db->query("
                SELECT b.language, COUNT(b.book_id) as cnt
                FROM book_tbl b
                WHERE b.status = 1
                  AND b.type_of_book = 3
                  AND b.book_id NOT IN (SELECT book_id FROM overdrive_books)
                GROUP BY b.language
            ")->getResult();

            foreach ($languages as $id => $name) $result['over_' . $name . '_unpub_cnt'] = 0;
            foreach ($query as $row) {
                $langName = $languages[$row->language] ?? null;
                if ($langName) $result['over_' . $langName . '_unpub_cnt'] = $row->cnt;
            }

            return $result;
        }

        // Fetch unpublished books for a specific language
        $books = $this->db->query("
            SELECT b.book_id, b.book_title, a.author_name, b.epub_url
            FROM book_tbl b
            LEFT JOIN author_tbl a ON b.author_name = a.author_id
            WHERE b.status = 1
              AND b.type_of_book = 3
              AND b.language = ?
              AND b.book_id NOT IN (SELECT book_id FROM overdrive_books)
            ORDER BY b.book_id ASC
        ", [$langId])->getResultArray();

        return $books;
    }
public function pustakaAudioDetails()
    {
        $db = \Config\Database::connect();
        $result = [];

        // 1. Monthly pages count
        $builder = $db->table('book_tbl')
            ->select("DATE_FORMAT(activated_at, '%m-%y') as monthly_number, SUM(number_of_page) as cnt")
            ->where('status', 1)
            ->where('type_of_book', 3)
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
            ->where('book_tbl.type_of_book', 3)
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
            ->where('book_tbl.type_of_book', 3)
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
    public function googleAudioDetails($langId = null)
{
    $db = \Config\Database::connect();
    $languages = [
        1 => 'tamil',
        2 => 'kannada',
        3 => 'telugu',
        4 => 'malayalam',
        5 => 'english'
    ];

    // Summary Counts (all languages)
    if ($langId === null) {
        $result = [];

        // Published counts
        $sqlPub = "
            SELECT b.language, COUNT(gb.book_id) as cnt
            FROM google_books gb
            JOIN book_tbl b ON b.book_id = gb.book_id
            WHERE b.type_of_book = 3
            GROUP BY b.language
        ";
        $published = $db->query($sqlPub)->getResult();

        // Init all to 0
        foreach ($languages as $id => $name) {
            $result['goog_' . $name . '_cnt'] = 0;
        }
        // Fill values
        foreach ($published as $row) {
            $langName = $languages[$row->language] ?? null;
            if ($langName) {
                $result['goog_' . $langName . '_cnt'] = $row->cnt;
            }
        }

        // Unpublished counts
        $sqlUnpub = "
            SELECT b.language, COUNT(b.book_id) as cnt
            FROM book_tbl b
            WHERE b.status = 1
              AND b.type_of_book = 3
              AND b.book_id NOT IN (SELECT book_id FROM google_books)
            GROUP BY b.language
        ";
        $unpublished = $db->query($sqlUnpub)->getResult();

        // Init all to 0
        foreach ($languages as $id => $name) {
            $result['goog_' . $name . '_unpub_cnt'] = 0;
        }
        // Fill values
        foreach ($unpublished as $row) {
            $langName = $languages[$row->language] ?? null;
            if ($langName) {
                $result['goog_' . $langName . '_unpub_cnt'] = $row->cnt;
            }
        }

        return $result;
    }

    // Details for given language
    $sql = "
        SELECT b.book_id, b.book_title, a.author_name, l.language_name
        FROM book_tbl b
        JOIN author_tbl a ON a.author_id = b.author_name
        JOIN language_tbl l ON l.language_id = b.language
        WHERE b.status = 1
          AND b.type_of_book = 3
          AND b.language = ?
          AND b.book_id NOT IN (SELECT book_id FROM google_books)
        ORDER BY b.book_id ASC
    ";
    return $db->query($sql, [$langId])->getResultArray();
}
public function storytelAudioDetails()
{
    $db = \Config\Database::connect();
    $result = [];

    // Language mapping (id => name)
    $languages = [
        1 => 'tamil',
        2 => 'kannada',
        3 => 'telugu',
        4 => 'malayalam',
        5 => 'english'
    ];

    // Published counts
    
    $pubQuery = $db->query("
        SELECT l.language_id, l.language_name, COUNT(*) as cnt 
        FROM storytel_books sb
        JOIN book_tbl b ON b.book_id = sb.book_id
        JOIN language_tbl l ON b.language = l.language_id
        WHERE b.type_of_book = 3
        GROUP BY l.language_id, l.language_name
    ")->getResultArray();

    foreach ($languages as $id => $key) {
        $match = array_filter($pubQuery, fn($row) => $row['language_id'] == $id);
        $row = reset($match);
        $result['storytel_' . $key . '_cnt'] = $row['cnt'] ?? 0;
    }

    
    // Unpublished counts
    
    $unpubQuery = $db->query("
        SELECT l.language_id, l.language_name, COUNT(b.book_id) as cnt 
        FROM book_tbl b
        JOIN language_tbl l ON b.language = l.language_id
        WHERE b.status = 1 AND b.type_of_book = 3
        AND b.book_id NOT IN (SELECT book_id FROM storytel_books)
        GROUP BY l.language_id, l.language_name
    ")->getResultArray();

    foreach ($languages as $id => $key) {
        $match = array_filter($unpubQuery, fn($row) => $row['language_id'] == $id);
        $row = reset($match);
        $result['storytel_' . $key . '_unpub_cnt'] = $row['cnt'] ?? 0;
    }

   
    // Unpublished details (per language)
    
    foreach ($languages as $id => $key) {
        $details = $db->query("
            SELECT b.book_id, b.book_title, a.author_name, b.epub_url
            FROM book_tbl b
            JOIN author_tbl a ON b.author_name = a.author_id
            WHERE b.status = 1 
              AND b.type_of_book = 3 
              AND b.book_id NOT IN (SELECT book_id FROM storytel_books)
              AND b.language = ?
            ORDER BY b.book_id
        ", [$id])->getResultArray();

        $result['storytel_' . $key . '_books'] = $details;
    }

    return $result;
}
public function audibleAudioDetails($langId = null)
{
    $db = \Config\Database::connect();
    $result = [];

    $languages = [
        1 => 'tamil',
        2 => 'kannada',
        3 => 'telugu',
        5 => 'english'  
    ];

    // Published counts
    $pubQuery = $db->query("
        SELECT l.language_name, COUNT(*) as cnt
        FROM audible_books ab
        JOIN book_tbl b ON b.book_id = ab.book_id
        JOIN language_tbl l ON b.language = l.language_id
        GROUP BY l.language_name
    ")->getResultArray();

    foreach ($languages as $id => $key) {
        $match = array_filter($pubQuery, fn($row) => strtolower($row['language_name']) == $key);
        $row = reset($match);
        $result['aud_' . $key . '_cnt'] = $row['cnt'] ?? 0;
    }

    // Unpublished counts
    $unpubQuery = $db->query("
        SELECT l.language_name, COUNT(b.book_id) as cnt
        FROM book_tbl b
        JOIN language_tbl l ON b.language = l.language_id
        WHERE b.status = 1 AND b.type_of_book = 3
          AND b.book_id NOT IN (SELECT book_id FROM audible_books)
        GROUP BY l.language_name
    ")->getResultArray();

    foreach ($languages as $id => $key) {
        $match = array_filter($unpubQuery, fn($row) => strtolower($row['language_name']) == $key);
        $row = reset($match);
        $result['aud_' . $key . '_unpub_cnt'] = $row['cnt'] ?? 0;
    }

   // Unpublished book details per language
    foreach ($languages as $id => $key) {
        if ($langId && $id != $langId) continue; // Only fetch requested language

        $details = $db->query("
            SELECT b.book_id, b.book_title, a.author_name, b.epub_url
            FROM book_tbl b
            JOIN author_tbl a ON b.author_name = a.author_id
            WHERE b.status = 1
              AND b.type_of_book = 3
              AND b.book_id NOT IN (SELECT book_id FROM audible_books)
              AND b.language = ?
            ORDER BY b.book_id
        ", [$id])->getResultArray();

        $result[$key] = $details;
    }

    return $result;
}
public function kukufmAudioDetails()
{
    $result = [];

    // 1. Published counts per language
    $published = $this->db->query("
        SELECT kb.language_id, l.language_name, COUNT(*) AS cnt
        FROM kukufm_books kb
        LEFT JOIN book_tbl b ON b.book_id = kb.book_id
        LEFT JOIN language_tbl l ON l.language_id = kb.language_id
        WHERE b.type_of_book = 3
        GROUP BY kb.language_id, l.language_name


    ")->getResultArray();

    foreach ($published as $row) {
        $key = strtolower(substr($row['language_name'], 0, 3));
        $result["ku_{$key}_cnt"] = $row['cnt'];
    }

    // 2. Unpublished counts per language
    $unpublished = $this->db->query("
        SELECT lt.language_name, bt.language, COUNT(bt.book_id) AS cnt
        FROM book_tbl bt
        JOIN language_tbl lt ON bt.language = lt.language_id
        WHERE bt.status = 1
          AND bt.type_of_book = 3
          AND bt.book_id NOT IN (SELECT book_id FROM kukufm_books)
        GROUP BY bt.language
    ")->getResultArray();

    foreach ($unpublished as $row) {
        $key = strtolower(substr($row['language_name'], 0, 3));
        $result["ku_{$key}_unpub_cnt"] = $row['cnt'];
    }

    // 3. Detailed unpublished books
    $books = $this->db->query("
        SELECT bt.book_id, bt.book_title, at.author_name, bt.epub_url, lt.language_name
        FROM book_tbl bt
        LEFT JOIN author_tbl at ON bt.author_name = at.author_id
        LEFT JOIN language_tbl lt ON bt.language = lt.language_id
        WHERE bt.status = 1
          AND bt.type_of_book = 3
          AND bt.book_id NOT IN (SELECT book_id FROM kukufm_books)
        ORDER BY bt.book_id ASC
    ")->getResultArray();

    foreach ($books as $row) {
        $lang = strtolower($row['language_name']);
        $result[$lang][] = [
            'book_id'     => $row['book_id'],
            'book_title'  => $row['book_title'],
            'author_name' => $row['author_name'],
            'epub_url'    => $row['epub_url']
        ];
    }

    return $result;
}
public function youtubeAudioDetails()
{
    $result = [];

    // 1. Published counts per language
    $published = $this->db->query("
        SELECT yt.language_id, l.language_name, COUNT(*) AS cnt
        FROM youtube_transaction yt
        LEFT JOIN book_tbl b ON b.book_id = yt.book_id
        LEFT JOIN language_tbl l ON l.language_id = yt.language_id
        WHERE b.type_of_book = 3
        GROUP BY yt.language_id, l.language_name
    ")->getResultArray();

    foreach ($published as $row) {
        $langKey = strtolower(substr($row['language_name'], 0, 3));
        $result['you_' . $langKey . '_cnt'] = $row['cnt'];
    }

    // 2. Unpublished counts per language
    $unpublished = $this->db->query("
        SELECT b.language, l.language_name, COUNT(b.book_id) AS cnt
        FROM book_tbl b
        LEFT JOIN language_tbl l ON l.language_id = b.language
        WHERE b.status = 1
          AND b.type_of_book = 3
          AND b.book_id NOT IN (SELECT book_id FROM youtube_transaction)
        GROUP BY b.language, l.language_name
    ")->getResultArray();

    foreach ($unpublished as $row) {
        $langKey = strtolower(substr($row['language_name'], 0, 3));
        $result['you_' . $langKey . '_unpub_cnt'] = $row['cnt'];
    }

    // 3. Detailed unpublished books per language
    $languages = [1=>'Tamil', 2=>'Kannada', 3=>'Telugu', 5=>'English'];
    foreach ($languages as $id => $name) {
        $books = $this->db->query("
            SELECT b.book_id, b.book_title, a.author_name, b.epub_url
            FROM book_tbl b
            LEFT JOIN author_tbl a ON a.author_id = b.author_name
            WHERE b.status = 1
              AND b.type_of_book = 3
              AND b.language = {$id}
              AND b.book_id NOT IN (SELECT book_id FROM youtube_transaction)
            ORDER BY b.book_id ASC
        ")->getResultArray();

        $langKey = strtolower(substr($name, 0, 3));
        $result['you_' . $langKey . '_books'] = $books;
    }

    return $result;
}




}