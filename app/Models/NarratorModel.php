<?php
namespace App\Models;

use CodeIgniter\Model;

class NarratorModel extends Model
{

   public function getAllNarrators()
{
    return $this->db->table('narrator_tbl')
                    ->orderBy('narrator_id', 'ASC')
                    ->get()
                    ->getResultArray();   // return array
}
    public function getNarratorDashboardData()
    {
        $query = $this->db->query("SELECT * FROM narrator_tbl");
        $narrators = $query->getResultArray();

        return ['narrators' => $narrators];
    }

    public function getEditNarratorData($narrator_id = null)
    {
        if (!$narrator_id) return [];

        $query = $this->db->query("SELECT * FROM narrator_tbl WHERE narrator_id = ?", [$narrator_id]);
        $narrator = $query->getRowArray();

        return $narrator ?? [];
    }

    public function getNarratorBooksList($user_id)
    {
        $sql = "SELECT fbs.book_id, b.book_title, a.author_name
                FROM free_book_subscription fbs
                JOIN book_tbl b ON b.book_id = fbs.book_id
                JOIN author_tbl a ON b.author_name = a.author_id
                WHERE fbs.user_id = ?";
        $query = $this->db->query($sql, [$user_id]);
        return $query->getResultArray();
    }

    public function addNarrator($request)
    {
        $user_id = null;
        $email = $request->getPost('email');

        $user_query = $this->db->query("SELECT user_id FROM users_tbl WHERE email = ?", [$email]);
        if ($user_query->getNumRows() > 0) {
            $user = $user_query->getRowArray();
            $user_id = $user['user_id'];
        }

        $narrator_name = $request->getPost('narrator_name');
        $narrator_url = $request->getPost('narrator_url_name');
        $mobile = $request->getPost('mobile');
        $description = $request->getPost('description');

        $sql = "INSERT INTO narrator_tbl (narrator_name, narrator_url, narrator_image, mobile, email, description, user_id)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $this->db->query($sql, [
            $narrator_name,
            $narrator_url,
            "narrator/" . $narrator_url . ".jpg",
            $mobile,
            $email,
            $description,
            $user_id
        ]);

        return $this->db->insertID() ? 1 : 0;
    }

    public function editNarrator($request)
    {
        $narrator_id = $request->getPost('narrator_id');
        if (!$narrator_id) return 0;

        $narrator_name = $request->getPost('narrator_name');
        $narrator_url = $request->getPost('narrator_url_name');
        $narrator_image = $request->getPost('narrator_image');
        $mobile = $request->getPost('mobile');
        $email = $request->getPost('email');
        $description = $request->getPost('description');
        $user_id = $request->getPost('user_id');

        $sql = "UPDATE narrator_tbl SET
                    narrator_name = ?,
                    narrator_url = ?,
                    narrator_image = ?,
                    mobile = ?,
                    email = ?,
                    description = ?,
                    user_id = ?
                WHERE narrator_id = ?";
        $this->db->query($sql, [
            $narrator_name,
            $narrator_url,
            $narrator_image,
            $mobile,
            $email,
            $description,
            $user_id,
            $narrator_id
        ]);

        return $this->db->affectedRows() ? 1 : 0;
    }

    public function addBook($request)
    {
        $book_id = $request->getPost('book_id');
        $user_id = $request->getPost('user_id');

        if (!$book_id || !$user_id) return 2;

        $sql = "INSERT INTO free_book_subscription (book_id, user_id, comments)
                VALUES (?, ?, 'For narrating')";
        $this->db->query($sql, [$book_id, $user_id]);

        return $this->db->affectedRows() ? 1 : 0;
    }
}
