<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Stock extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Dashboard',
            'subTitle' => 'Investment',
        ];
        return view('stock/stockDashboard', $data);
    }
}