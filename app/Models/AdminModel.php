<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        helper('date');
    }

    
    function authenticateAdmin($email, $password) 
    {
        $md5_pass = md5((string)$password); // This avoids warning if $password is null
        $sql = "SELECT * FROM `users_tbl` WHERE (users_tbl.user_type = 3 or users_tbl.user_type = 4 or users_tbl.user_type = 5 or users_tbl.user_type = 7) and users_tbl.email = '" . $email . "' and users_tbl.password = '" . $md5_pass . "'";
        $query = $this->db->query($sql);
        if ($query->getNumRows()== 1) {
            $result = $query->getRow();
            return $result;
        } else {
            return null;
        }
	}
    public function getAdminUsers()
    {
        $query = $this->db->table('users_tbl')
                        ->groupStart() 
                            ->where('user_type', 3)
                            ->orWhere('user_type', 4)
                        ->groupEnd()
                        ->get();

        return $query->getResultArray(); 
    }
    public function getBookSearchResults(string $keyword)
    {
        $sql = "SELECT 
                *,
                LOWER(language_tbl.language_name) AS language_name,
                DATE_FORMAT(book_tbl.activated_at, '%d-%m-%y') AS date_activated,
                scribd_books.doc_id,
                amazon_books.asin,
                google_books.play_store_link,
                overdrive_books.sample_link,
                book_tbl.book_id AS book_id
            FROM
                ((((book_tbl
                    LEFT JOIN scribd_books ON book_tbl.book_id = scribd_books.book_id)
                    LEFT JOIN amazon_books ON book_tbl.book_id = amazon_books.book_id)
                    LEFT JOIN google_books ON book_tbl.book_id = google_books.book_id)
                    LEFT JOIN overdrive_books ON book_tbl.book_id = overdrive_books.book_id),
                author_tbl,
                users_tbl,
                language_tbl
            WHERE
                book_tbl.author_name = author_tbl.author_id
                AND book_tbl.created_by = users_tbl.user_id
                AND book_tbl.language = language_tbl.language_id
                AND ((book_tbl.book_title LIKE ?)
                OR (book_tbl.book_id LIKE ?))";

        $query = $this->db->query($sql, ["%$keyword%", "%$keyword%"]);
        $tmp   = $query->getResultArray();

        $search_results = [];
        foreach ($tmp as $row) {
            $search_results[] = [
                'book_id'        => $row['book_id'],
                'book_title'     => $row['book_title'],
                'author_name'    => $row['author_name'],
                'date_activated' => $row['date_activated'],
                'resource'       => $row['username'],
                'language_name'  => $row['language_name'],
                'download_link'  => $row['download_link'],
                'doc_id'         => $row['doc_id'],
                'asin'           => $row['asin'],
                'play_store_link'=> $row['play_store_link'],
                'sample_link'    => $row['sample_link'],
            ];
        }

        return [
            'search_results'    => $search_results,
            'keyword'           => $keyword,
            'num_records_found' => count($tmp),
        ];
    }

    public function getAuthorSearchResults(string $keyword)
    {
        $sql = "SELECT *, DATE_FORMAT(author_tbl.created_at, '%d %M, %y') AS created_at 
                FROM author_tbl, users_tbl 
                WHERE author_tbl.copyright_owner = users_tbl.user_id 
                AND author_tbl.author_name LIKE ?";

        $query = $this->db->query($sql, ["%$keyword%"]);
        $tmp   = $query->getResultArray();

        $search_results = [];
        foreach ($tmp as $row) {
            $search_results[] = [
                'author_name' => $row['author_name'],
                'author_id'   => $row['author_id'],
                'user_id'     => $row['user_id'],
                'url_name'    => $row['url_name'],
                'created_at'  => $row['created_at'],
            ];
        }

        return [
            'search_results'    => $search_results,
            'keyword'           => $keyword,
            'num_records_found' => count($tmp),
        ];
    }

}