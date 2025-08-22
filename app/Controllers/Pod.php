<?php

namespace App\Controllers;

use App\Models\PodModel;

class Pod extends BaseController
{
    protected $podModel;

        public function __construct()
    {
        helper(['form', 'url', 'file', 'email', 'html', 'cookie', 'text']);
        $this->podModel = new PodModel();
    }

    public function publisherDashboard()
    {
        // $data = $this->userModel->getUserDashboardData();
        $data['publisher_data'] = $this->podModel->getPODPublishers();
        $data['title'] = 'POD Publisher List';

        return view('pod/publisherDashboard', $data);
    }
}