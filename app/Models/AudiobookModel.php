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
}