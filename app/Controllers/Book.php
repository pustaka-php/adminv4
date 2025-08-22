<?php

namespace App\Controllers;

use App\Models\EbookModel;
use App\Models\AudiobookModel;
use App\Models\PaperbackModel;

class Book extends BaseController
{
    protected $ebookModel;
    protected $audiobookModel;
    protected $paperbackModel;

    public function __construct()
    {
        $this->ebookModel      = new EbookModel();
        $this->audiobookModel  = new AudiobookModel();
        $this->paperbackModel  = new PaperbackModel();

        helper(['url']);
        session();
    }

    public function bookDashboard()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/adminv4/index');
        }

        $data = [
            'title'                      => 'Book Dashboard',
            'subTitle'                   => 'Monthly statistics and book overview',
            'dashboard_data'             => $this->ebookModel->getBookDashboardData(),
            'book_statistics'            => $this->ebookModel->getBookDashboardMonthlyStatistics(),
            'dashboard_curr_month_data' => $this->ebookModel->getBookDashboardCurrMonthData(),
            'dashboard_prev_month_data' => $this->ebookModel->getBookDashboardPrevMonthData(),
            'dashboard'                  => $this->audiobookModel->getBookDashboardData(),
        ];

        return view('Book/BookDashboard', $data);
    }

    public function getEbooksStatus()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/adminv4/index');
        }

        $data = [
            'title'                      => 'E-Book Status Overview',
            'subTitle'                   => 'Detailed status of all eBooks',
            'in_progress_dashboard_data' => $this->ebookModel->getInProgressDashboardData(),
            'ebooks_data'                => $this->ebookModel->getEbooksStatusDetails(),
        ];

        return view('Book/EbookStatusView', $data);
    }

    public function Ebooks()
{
    $data = [
        'title'    => 'All E-Books',
        'subTitle' => 'List of uploaded and active eBooks',
        'e_books'  => $this->ebookModel->getEbookData(),
    ];

    return view('Book/Ebooks', $data);
}

    public function audioBookDashboard()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/adminv4/index');
        }

        $data = [
            'title'                     => 'Audio Books Dashboard',
            'subTitle'                  => 'Overview of Audiobook Activities',
            'audio_books_dashboard_data' => $this->audiobookModel->getAudioBookDashboardData(),
        ];

        return view('Book/AudiobookDashboard', $data);
    }

    public function podBooksDashboard()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/adminv4/index');
        }

        $data = [
            'title'     => 'POD Books Dashboard',
            'subTitle'  => 'InDesign Processing Overview',
            'books'     => $this->paperbackModel->podIndesignProcessing(),
            'count'     => $this->paperbackModel->indesignProcessingCount(),
        ];

        return view('Book/PodbookDashboard', $data);
    }
   public function getHoldBookDetails()
{
    $EbookModel = new \App\Models\EbookModel();

    $data = [
        'title'       => 'Hold Book Details',
        'subTitle'    => 'List of books currently on hold',
        'ebooks_data' => $EbookModel->getEbooksStatusDetails(),
        'holdbook'    => $EbookModel->getHoldBookDetails()
    ];

    return view('Book/HoldbookDetails', $data);
}
public function ebooksMarkStart()
    {
        $book_id = $this->request->getPost('book_id');

        $db = db_connect();
        $builder = $db->table('books_processing');
        $builder->where('book_id', $book_id);
        $builder->update(['start_flag' => 1]);

        return $this->response->setJSON([
            'status' => ($db->affectedRows() > 0 ? 1 : 0)
        ]);
    }
public function getInactiveBooks()
{
    $ebookModel = new \App\Models\EbookModel();

    // Fetch inactive books
    $data['in_active'] = $ebookModel->getInactiveBooks();

    $data['title'] = 'Inactive Books';
    $data['subTitle'] = 'List of books currently marked as inactive';

    return view('Book/getInactiveBooks', $data);
}

public function addBook()
{
    $session = session();
    if (!$session->has('user_id')) {
        return redirect()->to('/adminv4/index');
    }

    $langModel         = new \App\Models\LanguageModel();
    $genreModel        = new \App\Models\GenreModel();
    $authorModel       = new \App\Models\AuthorModel();
    $adminModel        = new \App\Models\AdminModel();
    $ebookModel        = new \App\Models\EbookModel();

    $data = [
        'title'         => 'Add New Book',              
        'subTitle'      => 'Fill in the book details',   
        'lang_details'  => $langModel->getAllLanguages(),
        'genre_details' => $genreModel->getAllGenres(),
        'author_list'   => $authorModel->getAuthorDetails(),
        'admin_users'   => $adminModel->getAdminUsers(),
        'book_stages'   => $ebookModel->getAllStages()
    ];

    return view('Book/AddBook', $data);
}
public function fillDataView($bookId = null)
{
    if (!session()->has('user_id')) {
        return redirect()->to('/adminv4/index');
    }

    $ebookModel = new EbookModel();
    $data['fill_data_info'] = $ebookModel->getFillData($bookId);
    $data['book_id'] = $bookId;
    $data['title'] = "Fill Book Data";  
    $data['subTitle'] = "Update details for Book ID: " . $bookId;

    return view('Book/FillDataView', $data);
}
    public function fillData()
    {
        log_message('debug', 'Inside fillData in controller');

        $ebookModel = new EbookModel();
        $result = $ebookModel->fillData();
        return $this->response->setJSON(['status' => $result]);
    }
     public function addToTest()
{
    $ebookModel = new \App\Models\EbookModel();

    $userId = $this->request->getPost('user_id');
    $bookId = $this->request->getPost('book_id');

    $result = $ebookModel->addToTest($userId, $bookId);

    // return plain 1 or 0 (not JSON)
    return $this->response->setBody((string)$result);
}
public function holdInProgress()
{
    $bookId = $this->request->getPost('book_id');
    $model  = new EbookModel();

    $result = $model->holdInProgress($bookId);

    return $this->response->setJSON($result);
}
public function activateBookPage($book_id = null)
{
    $ebookModel = new EbookModel();
    $mdl_data = $ebookModel->getBookDetails($book_id);

    $data = [
        "book_details"              => $mdl_data["book_details"],
        "author_details"            => $mdl_data["author_details"],
        "user_details"              => $mdl_data["user_details"],
        "publisher_details"         => $mdl_data["publisher_details"],
        "copyright_mapping_details" => $mdl_data["copyright_mapping_details"],
        // Title & Subtitle
        "title"                     => "Activate Book: " . $mdl_data["book_details"]["book_title"],
        "subTitle"                  => "Author: " . $mdl_data["author_details"]["author_name"]
    ];

    if (isset($mdl_data["narrator_details"])) {
        $data["narrator_details"] = $mdl_data["narrator_details"];
        $data["audio_chapters"]   = $mdl_data["audio_chapters"];
    }

    return view('Book/ActivateBookView', $data);
}
public function activateBook()
{
    $book_id = $this->request->getPost('book_id');
    $send_mail_flag = $this->request->getPost('send_mail');

    $bookModel = new \App\Models\EbookModel();
    $result = $bookModel->activateBook($book_id, $send_mail_flag);

    if ($result) {
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Book activated successfully!'
        ]);
    } else {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to activate book'
        ]);
    }
}
public function addBookPost()
{
    $bookModel = new \App\Models\EbookModel();

    $result = $bookModel->addBook($this->request->getPost());

    return $this->response->setJSON([
        'result' => $result ? true : false
    ]);
}
    public function browseInProgressBooks()
{
    $session = session();
    if (!$session->get('user_id')) {
        return redirect()->to('/adminv4/index');
    }

    $ebookModel = new \App\Models\EbookModel();

    $data = [
        'title'    => 'Browse In-Progress Books',
        'subTitle' => 'View and track the current status of all books',
        'books'    => $ebookModel->getBrowseBooksData()
    ];

    return view('Book/browseInProgressBooks', $data);
}


}
