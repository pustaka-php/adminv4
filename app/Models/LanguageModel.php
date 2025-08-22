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
}
