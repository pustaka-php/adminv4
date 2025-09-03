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

    // Prepare all data before sending to view
    $dashboardData          = $this->ebookModel->getBookDashboardData();
    $bookStatistics         = $this->ebookModel->getBookDashboardMonthlyStatistics();
    $currMonthData          = $this->ebookModel->getBookDashboardCurrMonthData();
    $prevMonthData          = $this->ebookModel->getBookDashboardPrevMonthData();
    $audiobookDashboardData = $this->audiobookModel->getBookDashboardData();

    // Assign data properly
    $data = [
        'title'                      => 'Book Dashboard',
        'subTitle'                   => 'Monthly statistics and book overview',
        'dashboard_data'             => $dashboardData,
        'book_statistics'            => $bookStatistics,
        'dashboard_curr_month_data'  => $currMonthData,
        'dashboard_prev_month_data'  => $prevMonthData,
        'dashboard'                  => $audiobookDashboardData
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
    public function notStartedBooks()
{
    if (!session()->has('user_id')) {
        return redirect()->to('/adminv4/index');
    }

    $data = [
        'title'            => 'Books Not Yet Started',
        'subTitle'         => 'Detailed Start Work eBooks',
        'in_progress_dashboard_data' => $this->ebookModel->getInProgressDashboardData(),
        'ebooks_data'                => $this->ebookModel->getEbooksStatusDetails(),
    ];

    return view('Book/NotStartedBooks', $data);
}


    public function Ebooks()
    {
        $model = $this->ebookModel;

        $data = [
            'title'        => 'All E-Books',
            'subTitle'     => 'List of uploaded and active eBooks',
            'e_books'      => $model->getEbookData(),
            'languageData' => $model->getLanguageWiseBookCount(),
            'genreData'    => $model->getGenreWiseBookCount(),
            'categoryData' => $model->getBookCategoryCount(),
            'authorData'   => $model->getAuthorWiseBookCount()
        ];
    //      echo "<pre>";
    // print_r($data);   // prints full array nicely
    // echo "</pre>";

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
    $audiobookModel = new AudiobookModel();
    $mdl_data = $audiobookModel->getBookDetails($book_id);

    $data = [
        "book_details"              => $mdl_data["book_details"],
        "author_details"            => $mdl_data["author_details"],
        "user_details"              => $mdl_data["user_details"],
        "publisher_details"         => $mdl_data["publisher_details"],
        "copyright_mapping_details" => $mdl_data["copyright_mapping_details"],
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

    $audiobookModel = new \App\Models\AudiobookModel();
    $result = $audiobookModel->activateBook($book_id, $send_mail_flag);

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
    public function markScanComplete()
    {
        $book_id = $this->request->getPost('book_id');

        $db = db_connect();
        $builder = $db->table('books_processing');
        $builder->where('book_id', $book_id);
        $builder->update(['scan_flag' => 1]);

        return $this->response->setJSON([
            'status' => ($db->affectedRows() > 0 ? 1 : 0)
        ]);
    }
    
    public function markOcrComplete()
    {
        $book_id = $this->request->getPost('book_id');

        $db = db_connect();
        $builder = $db->table('books_processing');
        $builder->where('book_id', $book_id);
        $builder->update(['ocr_flag' => 1]);

        return $this->response->setJSON([
            'status' => ($db->affectedRows() > 0 ? 1 : 0)
        ]);
    }

    public function markLevel1Complete()
   {
        $book_id = $this->request->getPost('book_id');

        $db = db_connect();
        $builder = $db->table('books_processing');
        $builder->where('book_id', $book_id);
        $builder->update(['level1_flag' => 1]);

        return $this->response->setJSON([
            'status' => ($db->affectedRows() > 0 ? 1 : 0)
        ]);
    }

    public function markLevel2Complete()
    {
        $book_id = $this->request->getPost('book_id');

        $db = db_connect();
        $builder = $db->table('books_processing');
        $builder->where('book_id', $book_id);
        $builder->update(['level2_flag' => 1]);

        return $this->response->setJSON([
            'status' => ($db->affectedRows() > 0 ? 1 : 0)
        ]);
    }

    public function markCoverComplete()
    {
        $book_id = $this->request->getPost('book_id');

        $db = db_connect();
        $builder = $db->table('books_processing');
        $builder->where('book_id', $book_id);
        $builder->update(['cover_flag' => 1]);

        return $this->response->setJSON([
            'status' => ($db->affectedRows() > 0 ? 1 : 0)
        ]);
    }

    public function markBookGenerationComplete()
    {
        {
        $book_id = $this->request->getPost('book_id');

        $db = db_connect();
        $builder = $db->table('books_processing');
        $builder->where('book_id', $book_id);
        $builder->update(['book_generation_flag' => 1]);

        return $this->response->setJSON([
            'status' => ($db->affectedRows() > 0 ? 1 : 0)
        ]);
    }
    }

    public function markUploadComplete()
    {
        {
        $book_id = $this->request->getPost('book_id');

        $db = db_connect();
        $builder = $db->table('books_processing');
        $builder->where('book_id', $book_id);
        $builder->update(['upload_flag' => 1]);

        return $this->response->setJSON([
            'status' => ($db->affectedRows() > 0 ? 1 : 0)
        ]);
    }
    }

    public function markCompleted()
{
    $book_id = $this->request->getPost('book_id');

    $builder = $this->db->table('books_processing');
    $builder->set('completed', 1);
    $builder->set('completed_date', 'NOW()', false);
    $builder->where('book_id', $book_id)->update();

    return $this->response->setJSON([
        'status' => ($this->db->affectedRows() > 0 ? 1 : 0)
    ]);
}
public function addAudioBook()
{
    $session = session();
    if (!$session->has('user_id')) {
        return redirect()->to('/adminv4/index');
    }
    $languageModel = new \App\Models\LanguageModel();
    $genreModel    = new \App\Models\GenreModel();
    $authorModel   = new \App\Models\AuthorModel();
    $narratorModel = new \App\Models\NarratorModel();

    $data = [
        'title'         => 'Add Audio Book',
        'subTitle'      => 'Fill in the details below to create a new audio book',
        'lang_details'  => $languageModel->getAllLanguages(),
        'genre_details' => $genreModel->getAllGenres(),
        'author_list'   => $authorModel->getAuthorDetails(),
        'narrator_list' => $narratorModel->getAllNarrators(),
    ];

    return view('Book/AddAudioBook', $data);
}
public function addAudioBookPost()
{
    $audiobookModel = new \App\Models\AudiobookModel();

    // All POST data
    $postData = $this->request->getPost();

    $result = $audiobookModel->addAudioBook($postData);

    return $this->response->setJSON([
        'success' => $result ? true : false,
        'message' => $result ? 'Audio Book added successfully' : 'Failed to add audio book'
    ]);
}
public function audioBookChapters($book_id = null)
{
    $session = session();

    // Check login session
    if (!$session->has('user_id')) {
        return redirect()->to('/adminv4/index');
    }

    // Check if book_id is provided
    if (!$book_id) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Book ID not provided');
    }

    $AudiobookModel = new \App\Models\AudiobookModel();

    $data = [
        'title'           => 'Audio Book Chapters',
        'subTitle'        => 'Manage chapters for the selected audio book',
        'audio_book_info' => $AudiobookModel->getAudioBookChaptersData($book_id), // Pass $book_id here
         'book_id'         => $book_id, 
    ];

    return view('Book/AudioBookChapters', $data);
}

    public function addAudioBookChapter()
    {
        $AudiobookModel = new \App\Models\AudiobookModel();

        $result = $AudiobookModel->addAudioBookChapter($this->request->getPost());

        return $this->response->setJSON([
            'success' => $result ? true : false,
            'message' => $result ? 'Chapter added successfully' : 'Failed to add chapter'
        ]);
    }

  public function editAudioBookChapter()
{
    $db = \Config\Database::connect();
    $table = 'audio_book_details';

    $id = $this->request->getPost('id');
    if (!$id) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid request. Missing chapter ID'
        ]);
    }

    $update_data = [
        "chapter_id"           => $this->request->getPost('chp_id'),
        "chapter_name"         => $this->request->getPost('regional_name'),
        "chapter_name_english" => $this->request->getPost('title'),
        "chapter_url"          => $this->request->getPost('file_path'),
        "chapter_duration"     => $this->request->getPost('chapter_duration'),
    ];

    $builder = $db->table($table)->where('id', $id);
    $builder->update($update_data);
    $affectedRows = $db->affectedRows();

    // Even if no rows changed, return success if query executed
    return $this->response->setJSON([
        'success' => $builder ? true : false,
        'message' => $affectedRows > 0 ? 'Chapter updated successfully' : 'No changes made'
    ]);
}
public function pustakaDetails()
{
    // Create the model instance
    $ebookModel = new \App\Models\EbookModel();

    if (session()->has('user_id')) {
        $data['title'] = "Pustaka Details";
        $data['subTitle'] = "Overview of all books and their status";
        $data['pustaka'] = $ebookModel->pusDetails();
        $data['dashboard_data'] = $ebookModel->getBookDashboardData();

        return view('Book/pustakaDetails', $data);
    } else {
        return redirect()->to(site_url('adminv4/index'));
    }
}
public function amazonDetails()
{
    $session = session();

    if ($session->has('user_id')) {
        $EbookModel = new \App\Models\EbookModel();
        $LanguageModel = new \App\Models\LanguageModel();

        $data = [
            'title'        => 'Amazon Book Details',
            'subTitle'     => 'List of Amazon Books and Related Details',
            'amazon'       => $EbookModel->amzDetails(),
            'amazon_books' => $LanguageModel->bookDetails()
        ];

        return view('Book/AmazonDetails', $data);
    } else {
        return redirect()->to(site_url('adminv4/index'));
    }
    }
    public function getActiveBooks()
    {
        $ebookModel = new \App\Models\EbookModel();

        // Fetch active books
        $data['active'] = $ebookModel->getActiveBooks();

        $data['title'] = 'Active Books';
        $data['subTitle'] = 'List of books currently marked as active';

        return view('Book/getActiveBooks', $data);
    }

}
