<?php
namespace App\Models;

use CodeIgniter\Model;

class NarratorModel extends Model
{
    // no $table property here

    public function getAllNarrators()
    {
        $builder = $this->db->table('narrator_tbl');
        $builder->orderBy('narrator_id', 'ASC');
        $query = $builder->get();
        return $query->getResult();
    }
}
