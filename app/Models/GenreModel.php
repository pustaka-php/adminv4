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
    public function get_all_genres()
    {
        $query = $this->db->table($this->table)
                          ->orderBy('genre_name')
                          ->get();

        $gen = [];
        foreach ($query->getResult() as $genre) {
            $gen[$genre->genre_id] = $genre; 
        }
        return $gen;
    }
}
