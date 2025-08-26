<?php
namespace App\Models;

use CodeIgniter\Model;

class GenreModel extends Model
{
    protected $table      = 'genre_details_tbl';
    protected $primaryKey = 'genre_id';
    protected $returnType = 'array';

    public function getAllGenres()
    {
        $query = $this->db->table($this->table)
                          ->orderBy('genre_name')
                          ->get();

        return $query->getResult(); 
    }
}
