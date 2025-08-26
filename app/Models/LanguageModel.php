<?php
namespace App\Models;

use CodeIgniter\Model;

class LanguageModel extends Model
{
    protected $table      = 'language_tbl';
    protected $primaryKey = 'language_id';
    protected $returnType = 'array';

    public function getAllLanguages()
    {
        $query = $this->db->table($this->table)
                          ->where('language_id !=', 0)
                          ->orderBy('language_id')
                          ->get();

        return $query->getResult(); // returns array of objects
    }

    public function getLangName($lang_id)
    {
        $query = $this->db->table($this->table)
                          ->where('language_id', $lang_id)
                          ->get()
                          ->getRowArray();

        return $query['language_name'] ?? null;
    }
    public function bookDetails()
{
    $db = \Config\Database::connect();
    $data = [];

    // Amazon Books: Total
    $data['total_books'] = $db->query("SELECT COUNT(book_id) AS total_books FROM amazon_books")->getResultArray();

    // Amazon Books: Language-wise
    $data['lan_total'] = $db->query("
        SELECT language, COUNT(book_id) AS book_count
        FROM amazon_books
        WHERE language IN ('TAM', 'KAN', 'TEL', 'MLYLM', 'ENG')
        GROUP BY language
    ")->getResultArray();

    // Amazon Books: KU Enabled counts
    $data['enb_total'] = $db->query("
        SELECT 
            COUNT(CASE WHEN ku_enabled IS NOT NULL THEN 1 END) AS ku_enabled_count,
            COUNT(CASE WHEN ku_us_enabled IS NOT NULL THEN 1 END) AS ku_us_enabled_count,
            COUNT(CASE WHEN ku_uk_enabled IS NOT NULL THEN 1 END) AS ku_uk_enabled_count
        FROM amazon_books
    ")->getResultArray();

    // Google Books: Total
    $data['google_total'] = $db->query("SELECT COUNT(book_id) AS total_books FROM google_books")->getResultArray();

    // Google Books: Language-wise
    $data['google_lan_total'] = $db->query("
        SELECT g.language_id, l.language_name, COUNT(g.book_id) AS total_books
        FROM google_books g
        JOIN language_tbl l ON l.language_id = g.language_id
        GROUP BY g.language_id
    ")->getResultArray();

    // Scribd Books: Total
    $data['scribd_total'] = $db->query("SELECT COUNT(book_id) AS total_books FROM scribd_books")->getResultArray();

    // Scribd Books: Language-wise
    $data['scribd_lan_total'] = $db->query("
        SELECT s.language_id, l.language_name, COUNT(s.book_id) AS total_books
        FROM scribd_books s
        JOIN language_tbl l ON l.language_id = s.language_id
        GROUP BY s.language_id
    ")->getResultArray();

    // Storytel Books: Total
    $data['storytel_total'] = $db->query("SELECT COUNT(book_id) AS total_books FROM storytel_books")->getResultArray();

    // Storytel Books: Language-wise
    $data['storytel_lan_total'] = $db->query("
        SELECT s.language_id, l.language_name, COUNT(s.book_id) AS total_books
        FROM storytel_books s
        JOIN language_tbl l ON l.language_id = s.language_id
        GROUP BY s.language_id
    ")->getResultArray();

    // Overdrive Books: Total
    $data['overdrive_total'] = $db->query("SELECT COUNT(book_id) AS total_books FROM overdrive_books")->getResultArray();

    // Overdrive Books: Language-wise
    $data['overdrive_lan_total'] = $db->query("
        SELECT o.language_id, l.language_name, COUNT(o.book_id) AS total_books
        FROM overdrive_books o
        JOIN language_tbl l ON l.language_id = o.language_id
        GROUP BY o.language_id
    ")->getResultArray();

    // Pratilipi Books: Total
    $data['pratilipi_total'] = $db->query("SELECT COUNT(book_id) AS total_books FROM pratilipi_books")->getResultArray();

    // Pratilipi Books: Language-wise
    $data['pratilipi_lan_total'] = $db->query("
        SELECT p.language_id, l.language_name, COUNT(p.book_id) AS total_books
        FROM pratilipi_books p
        JOIN language_tbl l ON l.language_id = p.language_id
        GROUP BY p.language_id
    ")->getResultArray();

    return $data;
}

}
