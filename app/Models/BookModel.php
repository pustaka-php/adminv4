<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        helper('date');
    }

    
     public function getBooksDetails()
    {
        $sql = "SELECT 
                    book_tbl.book_id, 
                    book_tbl.book_title, 
                    book_tbl.regional_book_title,
                    book_tbl.copyright_owner,
                    book_tbl.paper_back_pages AS number_of_page, 
                    book_tbl.paper_back_inr, 
                    book_tbl.author_name as author_id,
                    author_tbl.author_name
                FROM 
                    book_tbl
                JOIN 
                    author_tbl ON author_tbl.author_id = book_tbl.author_name
                WHERE 
                    book_tbl.status = 1";

        $query = $this->db->query($sql);
        return $query->getResultArray();
       
    }

}