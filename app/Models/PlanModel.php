<?php

namespace App\Models;

use CodeIgniter\Model;

class PlanModel extends Model
{
    protected $table = 'plan_tbl';
    protected $primaryKey = 'plan_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'plan_name',
        'amount',
        'duration',
        'description',
        'status',
    ];

    public function getUserplans()
    {
        return $this->where('status', 1)->findAll();
    }
    
}

