<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class TpPublisher extends BaseController
{
     public function index(): string
    {
        $data = [
            'title' => 'Dashboard',
            'subTitle' => 'Medical',
        ];

        return view('Tppublisher/tppublisherDashboard', $data);
    }
    
}