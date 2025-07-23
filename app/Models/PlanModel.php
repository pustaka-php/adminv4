<?php

namespace App\Models;

use CodeIgniter\Model;

class PlanModel extends Model
{
    public function getUserplans()
    {
        return $this->where('status', 1)->findAll();
    }
}
