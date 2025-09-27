<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeModel extends Model
{
    protected $table = 'book_types'; // database table name
    protected $primaryKey = 'id';    // primary key column (set if you have one)
    protected $returnType = 'object'; // can also use 'array' if you prefer
    protected $useTimestamps = false; // set true if created_at, updated_at columns exist

    // Fetch all types ordered by type_name
    public function getAllTypes()
    {
        return $this->orderBy('type_name', 'ASC')->findAll();
    }
}
