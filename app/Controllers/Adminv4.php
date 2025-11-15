<?php

namespace App\Controllers;

use App\Controllers\BaseController;

    use App\Models\EbookModel;
    use App\Models\AudiobookModel;
    use App\Models\PaperbackModel;
    use App\Models\BookModel;
    use App\Models\AuthorModel;
    use App\Models\LanguageModel;
    use App\Models\GenreModel;
    use App\Models\TypeModel;
    use App\Models\BookshopModel;
    use App\Models\PodModel;
    use App\Models\PlanModel;

class Adminv4 extends BaseController
{
    protected $ebookModel;
    protected $audiobookModel;
    protected $paperbackModel;
    protected $bookModel;
    protected $authorModel;
    protected $languageModel;
    protected $genreModel;
    protected $typeModel;
    protected $bookshopModel;
    protected $podModel;
    protected $planModel;

    public function __construct()
    {
        $this->ebookModel      = new EbookModel();
        $this->audiobookModel  = new AudiobookModel();
        $this->paperbackModel  = new PaperbackModel();
        $this->bookModel       = new BookModel();
        $this->authorModel     = new AuthorModel();
        $this->languageModel   = new LanguageModel();
        $this->genreModel      = new GenreModel();
        $this->typeModel       = new TypeModel();
        $this->bookshopModel   = new BookshopModel();
        $this->podModel        = new PodModel();
        $this->planModel       = new PlanModel();

        helper(['url']);
        session();
   }
    public function index()
    {
        if (!$this->session->get('user_id')) {
            return view('authentication/signin', ['login_error' => 0]);
        }

        $userId   = $this->session->get('user_id');
        $userType = $this->session->get('user_type');


        if ($userType== 4) {
            return redirect()->to('adminv4/home');
        } elseif (in_array($userType, [3, 5])) {
            return redirect()->to('book/bookdashboard');
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
            $mismatch_count = $this->stockModel->mismatchstockcount();
           
            $this->session->set([
                'user_id'   => $result->user_id,
                'user_type' => $result->user_type,
                'username' => $result ->username,
                'logged_in' => true,
                'cancel_count' => count($cancel),
                'mismatch_count' => $mismatch_count

            ]);

            // Redirect based on user type
            if ($result->user_type == 4) {
                return redirect()->to('adminv4/home');
            } elseif (in_array($result->user_type, [3, 5])) {
                return redirect()->to('book/bookdashboard');
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

        $keyword = $this->request->getVar('search'); 

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

    public function home(){
    // Redirect if user not logged in
           if (!session()->has('user_id')) {
            return redirect()->to('/adminv4/index');
        }


    // Load data
    $data = [
        'title'                => '',
        'subTitle'             => '',
        'user_type'            => $this->session->get('user_type'),
        'ebooks_details'       => $this->ebookModel->getDashboardData(),
        'audiobooks_details'   => $this->audiobookModel->getDashboardData(),
        'paperback_details'    => $this->paperbackModel->getDashboardData(),
        'author_details'       => $this->authorModel->getDashboardData(),
        'bookshop_details'     => $this->bookshopModel->getDashboardData(),
        'pod_order_count'      => $this->podModel->getDashboardData(),
        'subscription_count'   => $this->planModel->getDashboardData(),
        'order_count'          => $this->podModel->getOrderDashboardData(),
    ];

    //    echo "<pre>";
    //    print_r($data);

       return view('partials/home', $data);
    }


}