<?php
namespace App\Models;

use CodeIgniter\Model;

class AuthorModel extends Model
{
    protected $table      = 'author_tbl';
    protected $primaryKey = 'author_id';
    protected $returnType = 'array';

    public function getAuthorDetails()
    {
        $query = $this->db->table($this->table)
                          ->orderBy('author_name')
                          ->get();

        return $query->getResult();
    }
}
