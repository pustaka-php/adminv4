<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PlanModel;

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
        $data = $this->userModel->getUserDashboardData();
        $data['title'] = 'User Dashboard';
        $data['subTitle'] = 'Overview of all users';

        return view('User/userdashboard', $data);
    }

    public function getUserDetails()
    {
        helper(['form']);

        $identifier = $this->request->getPost('identifier');

        if (!$identifier) {
            return redirect()->back()->with('error', 'Please provide a user identifier.');
        }

        $data['display'] = $this->userModel->getUserDetails($identifier);
        $data['plans'] = $this->planModel->getUserplans();

        $data['title'] = 'User Details';
        $data['subTitle'] = 'Detailed view of selected user';

        return view('User/userDetails', $data);
    }
}
