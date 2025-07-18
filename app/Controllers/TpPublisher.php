<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TpPublisherModel; 


class TpPublisher extends BaseController
{

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->TpPublisherModel = new TpPublisherModel();
        helper('url');
        $this->session = session();
    }

    
   public function tppublisherDashboard()
{
    $data = [
        'title' => 'TpPublisher',
        'subTitle' => 'Dashboard',
        'publisher_data' => $this->TpPublisherModel->countData(),
        'orders' => $this->TpPublisherModel->getPublisherOrders(),
        'payments' => $this->TpPublisherModel->tpPublisherOrderPayment(), 
    ];

    return view('tppublisher/tppublisherdashboard', $data);
}
    public function tpPublisherDetails()
{
    $model = new TpPublisherModel();
    $publishers = $model->tpPublisherDetails(); 

    $data = [
        'title' => 'TpPublisher',
        'subTitle' => 'Publisher Details',
        'publishers' => $publishers 
    ];

    return view('tppublisher/tppublisherdetails', $data); 
}
public function setpublisherstatus()
{
    $publisherId = $this->request->getPost('publisher_id');
    $status = $this->request->getPost('status');

    $model = new \App\Models\TpPublisherModel();

    if ($status == 1) {
        $result = $model->activePublishers($publisherId);
    } else {
        $result = $model->inactivePublishers($publisherId);
    }

    return $this->response->setJSON([
        'success' => $result == 1
    ]);
}
    public function tpPublisherView()
        {
            return view('tppublisher/tpPublisherAdd', [
        'title' => 'Publishers',
        'subTitle' => 'Add Publisher'
    ]);
        }

    public function tpPublisherAdd()
{
    if (!$this->request->isAJAX()) {
        return $this->response->setJSON(['error' => 'Invalid request']);
    }

    $rules = [
        'publisher_name' => 'required|min_length[3]',
        'contact_person' => 'required',
        'email_id'       => 'required|valid_email',
        'mobile'         => 'required|numeric|min_length[10]'
    ];

    if (!$this->validate($rules)) {
        return $this->response->setJSON([
            'error'    => true,
            'messages' => $this->validator->getErrors()
        ]);
    }

    $data = [
        'publisher_name' => $this->request->getPost('publisher_name'),
        'contact_person' => $this->request->getPost('contact_person'),
        'email_id'       => $this->request->getPost('email_id'),
        'mobile'         => $this->request->getPost('mobile'),
    ];

    $model = new \App\Models\TpPublisherModel();
    $insertedId = $model->tpPublisherAdd($data);

    if ($insertedId) {
        return $this->response->setJSON([
            'success'    => true,
            'message'    => 'Publisher added successfully!',
            'insert_id'  => $insertedId
        ]);
    }

    return $this->response->setJSON([
        'error'   => true,
        'message' => 'Insert failed!'
    ]);
}

    public function tpAuthorDetails()
    {
        $authors_data = $this->TpPublisherModel->tpAuthorDetails();

        $data = [
            'title'           => 'TpAuthor',
            'subTitle'        => 'Dashboard',
            'active_authors'   => $authors_data['active'] ?? [],
            'inactive_authors' => $authors_data['inactive'] ?? [],
        ];

        return view('tppublisher/tpauthordetails', $data);
    }
    public function tpAuthorAddDetails()
{
    $model = new TpPublisherModel();
    $data = [
        'title' => 'Add Author',
        'subTitle' => 'Enter Author and Publisher Information',
        'publisher_details' => $model->getTpAuthor()
    ];

    return view('tppublisher/tpauthorAdd', $data);
}


    public function tpAuthoradd()
    {
        // if (!session()->get('user_id')) {
        //     return $this->response->setJSON(['status' => 'unauthorized']);
        // }
        if (!$this->request->isAJAX()) {
        return $this->response->setJSON(['error' => 'Invalid request']);
    }

        $postData = $this->request->getPost();

        if (empty($postData['publisher_id']) || empty($postData['author_name'])) {
            return $this->response->setJSON([
                'status'  => 'validation_error',
                'message' => 'Publisher ID and Author Name are required.'
            ]);
        }

        $model  = new TpPublisherModel();
        $result = $model->tpAuthorsAdd($postData);

        return $this->response->setJSON([
            'status'  => $result ? 'success' : 'error',
            'message' => $result ? 'Author added.' : 'Insert failed.'
        ]);
    }
public function tpBookDetails()
{
    $model = new TpPublisherModel();

    $data = [
        'title' => 'Books',
        'subTitle' => 'Book List',
        'author_name' => $model->getAuthorList(),
        'active_books' => $model->getBooks(1),
        'inactive_books' => $model->getBooks(0),
        'pending_books' => $model->getBooks(2),
    ];

    return view('tppublisher/tppublisherBookDetails', $data);
}
public function tpBookAddDetails()
{
    $model = new TpPublisherModel();

    $data = [
        'title'             => 'Books',
        'subTitle'          => 'Add Book Details',
        'type_details'      => $model->get_common_data('types'),
        'language_details'  => $model->get_common_data('languages'),
        'genre_details'     => $model->get_common_data('genres'),
        'author_details'    => $model->get_common_data('authors'),
        'publisher_details' => $model->get_common_data('publishers'),
    ];

    return view('tppublisher/tpbookAdd', $data);
}

 public function getAuthorsByPublisher()
{
    $publisher_id = $this->request->getPost('publisher_id');
    if (!$publisher_id) {
        return $this->response->setBody('<option value="">No publisher selected</option>');
    }

    $db = \Config\Database::connect();
    $builder = $db->table('tp_publisher_author_details');
    $builder->where('publisher_id', $publisher_id);
    $query = $builder->get();

    $authors = $query->getResult();

    if (empty($authors)) {
        return $this->response->setBody('<option value="">No authors found</option>');
    }

    $options = '<option value="">Select Author</option>';
    foreach ($authors as $author) {
        $options .= '<option value="' . $author->author_id . '">' . esc($author->author_name) . '</option>';
    }

    return $this->response->setBody($options);
}
        public function tpBookPost()
    {
        $postData = $this->request->getPost();
        $model = new TpPublisherModel();

        $bookId = $model->tpBookAdd($postData);

        if ($bookId) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Book added successfully.',
                'book_id' => $bookId
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to add book.'
            ]);
        }
    }
   public function tpBookUpdateStatus()
{
    $book_id = $this->request->getPost('book_id');
    $status = $this->request->getPost('status');

    if (!is_numeric($book_id) || !in_array($status, [0, 1, 2])) {
        echo 'invalid_status';
        return;
    }

    $result = $this->TpPublisherModel->updateBookStatus((int)$book_id, (int)$status);

    echo $result ? 'success' : 'error';
}
public function tpStockDetails()
{
    $model = new TpPublisherModel();

    $data = [
        'title' => 'TpStock',
        'subTitle' => 'Stock Details',
        'stock_details' => $model->getStockDetails(),  // <- fixed
    ];

    return view('tppublisher/tpstockdetails', $data); 
}
public function tpbookaddstock()
{
    $TpPublisherModel = new TpPublisherModel();
    $combinedData = $TpPublisherModel->getBooksAndAuthors();
    
    $data['title'] = 'Add Book Stock';
    $data['publisher_author_details'] = $combinedData['authors'];
    $data['books_data'] = $combinedData['books'];

    if ($this->request->getMethod() === 'post') {
        $postData = [
            'author_id' => $this->request->getPost('author_id'),
            'book_id' => $this->request->getPost('book_id'),
            'book_quantity' => $this->request->getPost('book_quantity'),
        ];

        $result = $TpPublisherModel->TpbookAddStock($postData);
        return $this->response->setJSON($result);
    }

    return view('tppublisher/tpBookAddStock', $data);
}
public function getAuthorTpBook()
    {
        $TpPublisherModel = new TpPublisherModel();
        $author_id = $this->request->getPost('author_id');
        $books = $TpPublisherModel->getBooksByAuthor($author_id);

        $options = '<option value="">Select Book</option>';
        foreach ($books as $book) {
            $options .= '<option value="' . $book->book_id . '">' . $book->book_title . '</option>';
        }

        return $options;
    }

    // public function addTpBookStock()
    // {
    //     $TpPublisherModel = new TpPublisherModel();

    //     $data = [
    //         'author_id' => $this->request->getPost('author_id'),
    //         'book_id' => $this->request->getPost('book_id'),
    //         'book_quantity' => $this->request->getPost('book_quantity'),
    //     ];

    //     $result = $TpPublisherModel->TpbookAddStock($data);
    //     return $this->response->setJSON($result ? 0 : 1); // 0 = success, 1 = fail
    // }

}

