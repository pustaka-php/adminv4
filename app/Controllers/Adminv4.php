<?php

namespace App\Controllers;

use App\Controllers\BaseController;


class Adminv4 extends BaseController
{
   
    public function index()
    {
        if (!$this->session->get('user_id')) {
            return view('authentication/signin', ['login_error' => 0]);
        }

        $userId   = $this->session->get('user_id');
        $userType = $this->session->get('user_type');

        if ($userType == 4 || in_array($userType, [3, 5])) {
            return redirect()->to('/stock/stockdashboard');
        }

        if ($userType == 7) {
            $builder = $this->db->table('users_tbl');

            $userPublisher = $builder
                ->select('users_tbl.user_id')
                ->join('tp_publisher_details', 'users_tbl.user_id = tp_publisher_details.user_id')
                ->where([
                    'users_tbl.user_id' => $userId,
                    'users_tbl.user_type' => 7
                ])
                ->get()
                ->getRow();

            if ($userPublisher) {
                return redirect()->to('/tppublisherdashboard');
            } else {
                return redirect()->to('/no-access');
            }
        }

        return redirect()->to('/adminv4');
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/adminv4'); 
    }
    public function authenticate()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // FIX: assign to $result
        $result = $this->adminModel->authenticateAdmin($email, $password);

        // log_message('debug', print_r($result, true));

        if ($result) {
            // Set session data

            $cancel = $this->userModel->cancelSubscription();
           
            $this->session->set([
                'user_id'   => $result->user_id,
                'user_type' => $result->user_type,
                'username' => $result ->username,
                'logged_in' => true,
                'cancel_count' => count($cancel)
            ]);

            // Redirect based on user type
            if ($result->user_type == 4) {
                return redirect()->to('/stock/stockdashboard');
            } elseif (in_array($result->user_type, [3, 5])) {
                return redirect()->to('/stock/stockdashboard');
            } elseif ($result->user_type == 7) {
                 return redirect()->route('tppublisherdashboard');
            } else {
                return redirect()->to('/adminv4');
            }
        }

        // If authentication fails, return to login view with error
        return view('authentication/signin', ['login_error' => 1]);
    }
    public function search()
    {
        // Check session
        if (!session()->has('user_id')) {
            return redirect()->to('/adminv4/index');
        }

        $keyword = $this->request->getVar('search'); // get search term

        if (empty($keyword)) {
            return redirect()->back()->with('error', 'Please enter a search term.');
        }

        $adminModel = new \App\Models\AdminModel();
        $bookModel  = new \App\Models\BookModel();
        $data['title']   = '';
        $data['subTitle']   = '';
        $data['result_books']   = $adminModel->getBookSearchResults($keyword);
        $data['result_authors'] = $adminModel->getAuthorSearchResults($keyword);
        $data['stages']         = $bookModel->getAllStages();

        return view('authentication/Search', $data);
    }


}