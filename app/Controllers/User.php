<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\BookModel;
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

        return view('User/userDashboard', $data);
    }

    public function getUserDetails()
    {
       helper(['form']);

    $identifier = $this->request->getPost('identifier'); // Input field name must match
    if (!$identifier) {
        return redirect()->back()->with('error', 'Please provide a user identifier.');
    }

    $userModel = new \App\Models\UserModel();
    $planModel = new \App\Models\PlanModel();

    $data['display'] = $userModel->getUserDetails($identifier);
    $data['plans'] = $planModel->getUserplans();
     $data['title'] = 'User Dashboard';
        $data['subTitle'] = 'Overview of all users';

        return view('User/userDetails', $data);
    }
     public function clearUserDevices()
{
    $userId = $this->request->getPost('user_id');

    $userModel = new \App\Models\UserModel();
    $result = $userModel->clearUserDevices($userId);

    return $this->response->setJSON(['status' => $result ? 1 : 0]);
}

   public function addPlanForUser()
    {
        try {
            $userId = $this->request->getPost('user_id');
            $planId = $this->request->getPost('plan_id');

            $userModel = new \App\Models\UserModel();
            $result = $userModel->add_plan($userId, $planId);

            return $this->response->setJSON([
                'status' => $result ? 1 : 0,
                'message' => $result ? 'Plan added successfully.' : 'Plan add failed.'
            ]);
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'status' => 0,
                'message' => 'Exception: ' . $e->getMessage()
            ]);
        }
    }
    
    public function authorGiftBooks(){

        $bookModel = new BookModel();
        $data['title'] = 'Gift Books';
        $data['subTitle'] = 'Author Gift Books';

        $data['books'] = $bookModel->getBooksDetails();

        return view('author/giftbook', $data);
    }

    public function checkOrCreate() 
{
    $data = $this->request->getJSON(true);
    $email = $data['email'] ?? null;

    if (!$email) {
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Email required'
        ]);
    }

    $userModel = new UserModel();
    $userId = $userModel->checkOrCreateUser($email);

    return $this->response->setJSON([
        'status'  => 'success',
        'user_id' => $userId
    ]);
}

    public function CreateUser()
    {
        $request = $this->request->getJSON(true); // Get JSON POST data

        $email  = isset($request['email']) ? trim($request['email']) : '';
        $name   = isset($request['name']) ? trim($request['name']) : '';
        $mobile = isset($request['mobile']) ? trim($request['mobile']) : '';

        if (!$email || !$name || !$mobile) {
            return $this->respond([
                'status' => 'error',
                'message' => 'Email, Name, and Mobile are required.'
            ], 400);
        }

        $userModel = new UserModel();
        $userId = $userModel->CreateUser($email,$name,$mobile);
        if ($userId) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'User created successfully',
                'user_id' => $userId
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to create user'
            ]);
        }

    }


    public function submitGiftBook()
    {
        $data = $this->request->getJSON(true);

        $userId   = $data['user_id']   ?? null;
        $bookId   = $data['book_id']   ?? null;
        $authorId = $data['author_id'] ?? null;

        if (!$userId || !$bookId || !$authorId) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Missing required fields.'
            ]);
        }

        // Insert into DB
        $db = \Config\Database::connect();
        $builder = $db->table('author_gift_books');

        $insertData = [
            'user_id'   => $userId,
            'book_id'   => $bookId,
            'author_id' => $authorId,
            'date'=> date('Y-m-d H:i:s'),
        ];

        if ($builder->insert($insertData)) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Gift book inserted successfully!',
                'id'      => $db->insertID()
            ]);
        } else {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Failed to insert gift book.'
            ]);
        }
    }


}

