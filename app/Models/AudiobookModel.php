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

        // 🟢 Pustaka Audiobooks
        $sql1 = "SELECT language, COUNT(*) AS cnt 
                 FROM book_tbl 
                 WHERE type_of_book = 3 AND status = 1 
                 GROUP BY language 
                 ORDER BY language";
        $query = $db->query($sql1)->getResultArray();
        $result['pus_tml_cnt'] = $query[0]['cnt'] ?? 0;
        $result['pus_kan_cnt'] = $query[1]['cnt'] ?? 0;
        $result['pus_tel_cnt'] = $query[2]['cnt'] ?? 0;
        $result['pus_eng_cnt'] = $query[3]['cnt'] ?? 0;

        // 🟢 Overdrive
        $sql2 = "SELECT language_id, COUNT(*) AS cnt 
                 FROM overdrive_books  
                 WHERE type_of_book = 3 
                 GROUP BY language_id 
                 ORDER BY language_id";
        $query = $db->query($sql2)->getResultArray();
        $result['over_tml_cnt'] = $query[0]['cnt'] ?? 0;
        $result['over_kan_cnt'] = $query[1]['cnt'] ?? 0;
        $result['over_tel_cnt'] = $query[2]['cnt'] ?? 0;
        $result['over_eng_cnt'] = $query[3]['cnt'] ?? 0;

        // 🟢 Google Books
        $sql3 = "SELECT gb.language_id, COUNT(*) AS cnt 
                 FROM google_books gb
                 JOIN book_tbl b ON b.book_id = gb.book_id
                 WHERE b.type_of_book = 3 
                 GROUP BY gb.language_id 
                 ORDER BY gb.language_id";
        $query = $db->query($sql3)->getResultArray();
        $result['goog_tml_cnt'] = $query[0]['cnt'] ?? 0;
        $result['goog_kan_cnt'] = $query[1]['cnt'] ?? 0;
        $result['goog_tel_cnt'] = $query[2]['cnt'] ?? 0;
        $result['goog_eng_cnt'] = $query[3]['cnt'] ?? 0;

        // 🟢 Storytel
        $sql4 = "SELECT language_id, COUNT(DISTINCT book_id) AS cnt
                 FROM storytel_books
                 WHERE type_of_book = 3 
                 GROUP BY language_id 
                 ORDER BY language_id";
        $query = $db->query($sql4)->getResultArray();
        $result['storytel_tml_cnt'] = $query[0]['cnt'] ?? 0;
        $result['storytel_kan_cnt'] = $query[1]['cnt'] ?? 0;
        $result['storytel_tel_cnt'] = $query[2]['cnt'] ?? 0;
        $result['storytel_eng_cnt'] = $query[3]['cnt'] ?? 0;

        // 🟢 Audible
        $sql5 = "SELECT ab.language_id, COUNT(*) AS cnt 
                 FROM audible_books ab
                 JOIN book_tbl b ON b.book_id = ab.book_id
                 WHERE b.type_of_book = 3 
                 GROUP BY ab.language_id 
                 ORDER BY ab.language_id";
        $query = $db->query($sql5)->getResultArray();
        $result['aud_tml_cnt'] = $query[0]['cnt'] ?? 0;
        $result['aud_kan_cnt'] = $query[1]['cnt'] ?? 0;
        $result['aud_tel_cnt'] = $query[2]['cnt'] ?? 0;
        $result['aud_eng_cnt'] = $query[3]['cnt'] ?? 0;

        // 🟢 KukuFM
        $sql6 = "SELECT kf.language_id, COUNT(*) AS cnt 
                 FROM kukufm_books kf
                 JOIN book_tbl b ON b.book_id = kf.book_id
                 WHERE b.type_of_book = 3 
                 GROUP BY kf.language_id 
                 ORDER BY kf.language_id";
        $query = $db->query($sql6)->getResultArray();
        $result['ku_tml_cnt'] = $query[0]['cnt'] ?? 0;
        $result['ku_tel_cnt'] = $query[1]['cnt'] ?? 0;

        // 🟢 YouTube
        $sql7 = "SELECT yt.language_id, COUNT(*) AS cnt 
                 FROM youtube_transaction yt
                 JOIN book_tbl b ON b.book_id = yt.book_id
                 WHERE b.type_of_book = 3 
                 GROUP BY yt.language_id 
                 ORDER BY yt.language_id";
        $query = $db->query($sql7)->getResultArray();
        $result['you_tml_cnt'] = $query[0]['cnt'] ?? 0;

        return $result;
    }
    public function getAudioBookDashboardData()
    {
        // Active Audio Books
        $activeAudioBooks = $this->db->table('book_tbl b')
            ->select('b.book_id, b.book_title, a.author_name, n.narrator_name, b.number_of_page')
            ->join('author_tbl a', 'b.author_name = a.author_id', 'left')
            ->join('narrator_tbl n', 'b.narrator_id = n.narrator_id', 'left')
            ->where(['b.type_of_book' => 3, 'b.status' => 1])
            ->get()
            ->getResultArray();

        // Inactive Audio Books
        $inactiveAudioBooks = $this->db->table('book_tbl b')
            ->select('b.book_id, b.book_title, a.author_name, n.narrator_name, b.number_of_page')
            ->join('author_tbl a', 'b.author_name = a.author_id', 'left')
            ->join('narrator_tbl n', 'b.narrator_id = n.narrator_id', 'left')
            ->where(['b.type_of_book' => 3, 'b.status' => 0])
            ->get()
            ->getResultArray();

        // Cancelled Audio Books
        $cancelledAudioBooks = $this->db->table('book_tbl b')
            ->select('b.book_id, b.book_title, a.author_name, n.narrator_name, b.number_of_page')
            ->join('author_tbl a', 'b.author_name = a.author_id', 'left')
            ->join('narrator_tbl n', 'b.narrator_id = n.narrator_id', 'left')
            ->where(['b.type_of_book' => 3, 'b.status' => 2])
            ->get()
            ->getResultArray();

        // Graph Data
        $graphQuery = $this->db->table('book_tbl')
    ->select("COUNT(*) AS cnt, DATE_FORMAT(activated_at, '%b, %y') AS date_activated")
    ->where(['type_of_book' => 3, 'status' => 1])
    ->where('activated_at IS NOT NULL')   // ✅ Fix applied here
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

        return [
            'active_audio_books'   => $activeAudioBooks,
            'inactive_audio_books' => $inactiveAudioBooks,
            'cancelled_audio_books' => $cancelledAudioBooks,
            'graph_data' => $graphData
        ];
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

}