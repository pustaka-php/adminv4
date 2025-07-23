<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PlanModel;
use CodeIgniter\Controller;

class User extends BaseController
{
    protected $userModel;
    protected $planModel;

    public function __construct()
    {
        helper(['form', 'url', 'file', 'email', 'html', 'cookie', 'text']);
        $this->userModel = new UserModel();
        $this->planModel = new PlanModel();
    }
     public function userDashboard()
{
    $userModel = new UserModel();

    $data = $userModel->getUserDashboardData();
    $data['title'] = 'User Dashboard';
    $data['subTitle'] = 'Overview of all users';

    return view('user/userdashboard', $data);
}


    public function getUserDetails()
{
    helper(['form']);

    $identifier = $this->request->getPost('identifier'); 
    if (!$identifier) {
        return redirect()->back()->with('error', 'Please provide a user identifier.');
    }

    $userModel = new \App\Models\UserModel();
    $planModel = new \App\Models\PlanModel();

    $data['display'] = $userModel->getUserDetails($identifier);
    $data['plans'] = $planModel->getUserplans();

    $data['title'] = 'User Details';
    $data['subTitle'] = 'Detailed view of selected user';

    return view('user/display', $data);
}


}
