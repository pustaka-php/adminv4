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

   public function tppublisherDashboard($publisher_id = null)
{
    $tpModel = new TpPublisherModel();

    // Always load all publishers
    $data['all_publishers'] = $tpModel->getAllPublishers();

    // Base data for title
    $data['title']    = 'TpPublisher';
    $data['subTitle'] = 'Dashboard';

    // If a publisher is selected → load that publisher’s details
    if ($publisher_id) {
        $data['selected_publisher_id'] = $publisher_id;
        $data['publisher_info']        = $tpModel->getPublisherById($publisher_id);
        $data['publisher_data']        = $tpModel->countData($publisher_id);
        $data['orders']                = $tpModel->getPublisherOrders($publisher_id);
        $data['payments']              = $tpModel->tpPublisherOrderPayment($publisher_id);
    } else {
        // Otherwise → show overall totals
        $data['selected_publisher_id'] = null;
        $data['publisher_data']        = $tpModel->countData();
        $data['orders']                = $tpModel->getPublisherOrders();
        $data['payments']              = $tpModel->tpPublisherOrderPayment();
    }

    return view('tppublisher/tppublisherDashboard', $data);
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
            return view('tppublisher/tppublisheradd', [
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
public function tpPublisherEdit($publisher_id)
{
    $model = new TpPublisherModel();
    $data['publishers_data'] = $model->tpPublisherEdit($publisher_id);
    
    $data['title'] = 'Edit Publisher';
    $data['subTitle'] = 'Update publisher details.';

    return view('tppublisher/tppublisherEdit', $data);
}
public function editPublisherPost()
    {
        $request     = service('request');
        $publisherId = $request->getPost('publisher_id');

        $model  = new TpPublisherModel();
        $result = $model->tpPublisherEditPost($publisherId, $request);

        return $this->response->setJSON([
            'status'  => $result ? 1 : 0,
            'message' => $result ? 'Publisher updated successfully' : 'Failed to update publisher'
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

        return view('tppublisher/tpauthorDetails', $data);
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
    public function tpAuthorView($author_id)
{
    $model = new TpPublisherModel();
    $data  = $model->tpAuthorView($author_id);

    $view_data = [
        'title'                 => 'Author Details',
        'subTitle'              => 'View detailed profile.',
        'authors_data'          => [$data['author_details']],
        'book_count'            => $data['book_count'],
        'publishers_data'       => $data['publishers'],
        'publishers_books_data' => $data['books']
    ];

    return view('tppublisher/tpauthorView', $view_data);
}


    public function tpAuthorEdit($author_id)
{
    $model = new TpPublisherModel();
    $data  = $model->getAuthorAndPublishers($author_id);

    $view_data = [
        'title'             => 'Edit Author',
        'subTitle'          => 'Update author details and publisher assignments.',
        'authors_data'      => $data['author'],
        'publisher_details' => $data['publishers']
    ];

    return view('tppublisher/tpauthorEdit', $view_data);
}


    public function editAuthorPost()
    {
        $author_id = $this->request->getPost('author_id');

        $data = [
            'publisher_id'        => $this->request->getPost('publisher_id'),
            'author_name'         => $this->request->getPost('author_name'),
            'mobile'              => $this->request->getPost('mobile'),
            'email_id'            => $this->request->getPost('email_id'),
            'author_discription'  => $this->request->getPost('author_discription'),
            'author_image'        => $this->request->getPost('author_image'),
        ];

        $model   = new TpPublisherModel();
        $updated = $model->updateAuthor($author_id, $data);

        return $this->response->setJSON($updated ? 1 : 0);
    }

    public function updateTpAuthorStatus()
    {
        $authorId = $this->request->getPost('author_id');
        $status   = $this->request->getPost('status'); // 1 or 0

        if (!is_numeric($authorId) || !in_array($status, ['0', '1'], true)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid input']);
        }

        $model  = new TpPublisherModel();
        $result = $model->setTpAuthorStatus((int)$authorId, (int)$status);

        return $this->response->setJSON(['success' => $result === 1]);
    }
    public function setBookStatus()
{
    $bookId = $this->request->getPost('book_id');
    $status = $this->request->getPost('status');

    if (!$bookId || $status === null) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Missing book ID or status.'
        ]);
    }

    $db = \Config\Database::connect();

    // Get the author status for the book
    $book = $db->table('tp_publisher_bookdetails b')
        ->select('a.status as author_status')
        ->join('tp_publisher_author_details a', 'a.author_id = b.author_id', 'left')
        ->where('b.book_id', $bookId)
        ->get()
        ->getRow();

    if (!$book) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Book not found.'
        ]);
    }

    // If trying to activate book, check if author is active
    if ((int)$status === 1 && (int)$book->author_status !== 1) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Cannot activate this book. The author is inactive.'
        ]);
    }

    // Proceed to update book status
    $updated = $db->table('tp_publisher_bookdetails')
        ->where('book_id', $bookId)
        ->update(['status' => $status]);

    if ($updated) {
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Book status updated successfully.'
        ]);
    } else {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to update book status.'
        ]);
    }
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
public function setAuthorStatus()
{
    $authorId = $this->request->getPost('author_id');
    $status   = (int) $this->request->getPost('status');
    $db       = \Config\Database::connect();

    // Check if author exists and get publisher status
    $builder = $db->table('tp_publisher_author_details a');
    $builder->select('a.publisher_id, a.status as author_status, p.status as publisher_status');
    $builder->join('tp_publisher_details p', 'p.publisher_id = a.publisher_id');
    $builder->where('a.author_id', $authorId);
    $info = $builder->get()->getRowArray();

    if (!$info) {
        return $this->response->setJSON(['success' => false, 'message' => 'Author not found']);
    }

    // If activating author, ensure publisher is active
    if ($status == 1 && $info['publisher_status'] != 1) {
        return $this->response->setJSON(['success' => false, 'message' => 'Publisher is inactive']);
    }

    $db->transStart();

    // Update author status
    $db->table('tp_publisher_author_details')
        ->where('author_id', $authorId)
        ->update(['status' => $status]);

    // Update all their books to match new status
    $db->table('tp_publisher_bookdetails')
        ->where('author_id', $authorId)
        ->update(['status' => $status]);

    $db->transComplete();

    if ($db->transStatus() === false) {
        return $this->response->setJSON(['success' => false, 'message' => 'Update failed']);
    }

    return $this->response->setJSON(['success' => true]);
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
        'title' => 'Tp Stock Details',
        'subTitle' => 'Stock Details',
        'stock_details' => $model->getStockDetails(),
        'description' => 'stock',
    ];

    return view('tppublisher/tpstockDetails', $data); 
}

public function bookLedgerDetails($bookId, $description)
{
    $model = new TpPublisherModel();

    // Get book details
    $book = $model->getBookDetailsById($bookId);

    // Get ledger data only for that book + channel
    $ledgerData = $model->getBookLedgerByIdAndType($bookId, $description);

    return view('tppublisher/tpstockLedgerDetails', [
        'title'       => 'Book Ledger Details',
        'subTitle'    => 'Channel: ' . $description,
        'book'        => $book,
        'ledgerData'  => $ledgerData,
        'description' => $description
    ]);
}


public function tpbookaddstock()
{
    $TpPublisherModel = new TpPublisherModel();
    $combinedData = $TpPublisherModel->getBooksAndAuthors();

    $data['publisher_author_details'] = $combinedData['authors'];
    $data['books_data'] = $combinedData['books'];
    $data['title'] = 'Add Publisher Book Stock';
    $data['subTitle'] = 'Add Book Stock.'; 
    if ($this->request->getMethod() === 'post') {
        $postData = [
            'author_id' => $this->request->getPost('author_id'),
            'book_id' => $this->request->getPost('book_id'),
            'book_quantity' => $this->request->getPost('book_quantity'),
        ];

        $result = $TpPublisherModel->TpbookAddStock($postData);
        return $this->response->setJSON($result);
    }

    return view('tppublisher/tpbookAddStock', $data);
}


public function getAuthorTpBook()
{
    $author_id = $this->request->getPost('author_id');

    if (empty($author_id)) {
        return $this->response->setStatusCode(400)->setBody('No author ID');
    }

    $TpPublisherModel = new \App\Models\TpPublisherModel();
    $books = $TpPublisherModel->getBooksByAuthor($author_id);

    if (empty($books)) {
        return $this->response->setBody('<option value="">No books found</option>');
    }

    $options = '<option value="">Select Book</option>';
    foreach ($books as $book) {
        $options .= '<option value="' . $book->book_id . '">' . esc($book->book_title) . '</option>';
    }

    return $this->response->setBody($options);
}


    public function addTpBookStock()
{
    $TpPublisherModel = new TpPublisherModel();

    $data = [
        'author_id' => $this->request->getPost('author_id'),
        'book_id' => $this->request->getPost('book_id'),
        'book_quantity' => $this->request->getPost('book_quantity'),
    ];

    $result = $TpPublisherModel->TpbookAddStock($data);
    return $this->response->setJSON($result);
}
public function tppublisherOrderDetails()
{
    $model = new TpPublisherModel();
    $allOrders = $model->getPublisherOrders();

    $data = [
        'title' => 'Publisher Orders',
        'subTitle' => 'List of all publisher book orders with details.',
        'orders' => $allOrders,
        'today' => date('Y-m-d')
    ];

    return view('tppublisher/tppublisherOrderDetails', $data); 
}
    public function markShipped()
{
    $data = $this->request->getPost();

    $result = $this->TpPublisherModel->markShipped($data);

    return $this->response->setJSON([
        'status'  => $result ? 'success' : 'error',
        'message' => $result ? 'Book marked as shipped.' : 'Failed to ship.'
    ]);
}

    public function markCancel()
{
    $data = $this->request->getPost();
    $result = $this->TpPublisherModel->markCancel($data);
    return $this->response->setJSON([
        'status' => $result ? 'success' : 'error',
        'message' => $result ? 'Order cancelled.' : 'Failed to cancel order.'
    ]);
}

public function markReturn()
{
    $data = $this->request->getPost();
    $result = $this->TpPublisherModel->markReturn($data);
    return $this->response->setJSON([
        'status' => $result ? 'success' : 'error',
        'message' => $result ? 'Book returned.' : 'Failed to return book.'
    ]);
}

public function initiatePrint()
{
    $data = $this->request->getPost();
    $result = $this->TpPublisherModel->initiatePrint($data);
    return $this->response->setJSON([
        'status' => $result ? 'success' : 'error',
        'message' => $result ? 'Print initiated.' : 'Failed to start print.'
    ]);
}

public function tppublisherOrderPayment()
{
    $model = new TpPublisherModel();
    $allpayments = $model->tpPublisherOrderPayment();
    $groupedSales = $model->getGroupedSales();

    $data = [
        'title' => 'Publisher Payments',
        'subTitle' => 'Payment summary for publisher orders including status.',
        'sales'       => $groupedSales,
        'orders' => $allpayments,
        'today' => date('Y-m-d')
    ];

    return view('tppublisher/tppublisherOrderPayments', $data); 
}
public function markAsPaid()
{
    $order_id = $this->request->getPost('order_id');

    if (!$order_id) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Order ID missing.'
        ]);
    }

    $db = db_connect();
    $builder = $db->table('tp_publisher_order');

    $updated = $builder->where('order_id', $order_id)
                       ->update([
                           'payment_status' => 'Paid',
                           'payment_date'   => date('Y-m-d H:i:s')
                       ]);

    if ($db->affectedRows() > 0) {
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Order marked as Paid.'
        ]);
    } else {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'No rows updated — check order_id or table name.'
        ]);
    }
}


public function tpPublisherDetailsView($publisher_id)
{
    $model = new TpPublisherModel();
    $data  = $model->getPublisherDetails($publisher_id);

    $data['title'] = 'Publisher Details';
    $data['subTitle'] = 'Detailed view of the selected publisher';

    return view('tppublisher/tppublisherView', $data);
}
public function tpBookView($book_id)
{
    $model = new TpPublisherModel();
    $data = $model->getFullBookData($book_id);

    $data['title'] = 'Book Details';
    $data['subTitle'] = 'Detailed view of the Book';
    $data['book_count'] = count($data['books_data'] ?? []);

    return view('tppublisher/tpbookView', $data);
}

     public function editTpBook($book_id)
    {
        $data['language_details']  = $this->TpPublisherModel->get_common_data('languages');
        $data['genre_details']     = $this->TpPublisherModel->get_common_data('genres');
        $data['type_details']      = $this->TpPublisherModel->get_common_data('types');
        $data['author_details']    = $this->TpPublisherModel->get_common_data('authors');
        $data['publisher_details'] = $this->TpPublisherModel->get_common_data('publishers');

        $data['books_list'] = $this->TpPublisherModel->getBooks();
        $data['books_data'] = $this->TpPublisherModel->getEditBooks($book_id);
        $data['title'] = 'Edit Book';
        $data['subTitle'] = 'Edit Book';

    return view('tppublisher/tpbookEdit', $data);
       
    }

    public function editTpBookPost()
    {
        $book_id = $this->request->getPost('book_id');
        $result = $this->TpPublisherModel->editBookPost($book_id);
        echo $result;
    }
    public function tpSalesDetails()
{
    $model = new \App\Models\TpPublisherModel();

    $data['sales']        = $model->tpBookSalesData();
    $data['payments']     = $model->tpPublisherOrderPayment();
    $data['salespay']     = $model->getGroupedSales();
    $data['paymentpay']     = $model->getPaymentSales();

    $data['salesSummary'] = $model->getSalesSummary(); // summary totals
    $data['publisher_data'] = $model->countData();      // corrected assignment

    $data['title']    = '';
    $data['subTitle'] = 'Total sales quantity and amount by sales channel';

    // echo '<pre>';
    // print_r($data); // prints the entire $data array in readable format
    // echo '</pre>';
    // exit; // stop execution so you can see the output

    return view('tppublisher/tpSalesDetails', $data);
}


    public function tpSalesAdd() {

    $data['details'] = $this->TpPublisherModel->getAlltpBookDetails();
    $data['title'] = 'Add Sales';
    $data['subTitle'] = 'Sales Book';

        return view('tppublisher/tpsalesAdd', $data);
    }
    public function tpbookOrderDetails() {
    $selected_book_list = $this->request->getPost('selected_book_list');

    log_message('debug', 'Selected Books list.... ' . $selected_book_list);

    $tpModel = new TpPublisherModel();
    $booksData = $tpModel->tppublisherSelectedBooks($selected_book_list);

    $data = [
        'title' => 'TP Publisher Orders',
        'subTitle' => 'Selected Book Order Details',
        'tppublisher_selected_book_id' => $selected_book_list,
        'tppublisher_selected_books_data' => $booksData,
    ];

    return view('tppublisher/tppublisherOrderList', $data);
}
    public function tppublisherOrder()
{
    $model = new TpPublisherModel();
    $orderModel = new \App\Models\TpPublisherModel();

    // Orders
    $ordersInProgress = $model->getPublisherOrders(0, 0); // In Progress
    $groupedOrders = [
        'shipped'   => $model->getPublisherOrders(1), // shipped
        'returned'  => $model->getPublisherOrders(3), // returned
        'cancelled' => $model->getPublisherOrders(2)  // cancelled
    ];
    $allPayments = $model->tpPublisherOrderPayment(); 
    $orderStats = $orderModel->getOrderPaymentStats();

    $data = [
        'title'         => 'Order Dashboard',
        'subTitle'      => 'Manage orders and payments for TP publishers',
        'orders'        => $ordersInProgress,
        'groupedOrders' => $groupedOrders,
        'payments'      => $allPayments,
        'orderStats'    => $orderStats,  
        'today'         => date('Y-m-d')
    ];
    // echo '<pre>';
    // print_r($orderStats);
    // echo '</pre>';
    // exit; // stop further execution

    // Pass data to view
    return view('tppublisher/tppublisherOrderDetails', $data);
}

 public function tpOrderFullDetails($order_id)
{
    $model = new TpPublisherModel();
    $result = $model->tpOrderFullDetails($order_id);

    $data = [
        'order'    => $result['order'], 
        'books'    => $result['books'], 
        'title'    => 'Author Order Details',
        'subTitle' => 'Order #' . $order_id
    ];

    return view('tppublisher/tpOrderFullDetails', $data);
}
public function tppublisherOrderPost()
    {
        $request = service('request');

        $num_of_books        = (int) $request->getPost('num_of_books');
        $selected_book_list  = $request->getPost('selected_book_list');
        $author_id           = $request->getPost('author_id');
        $publisher_id        = $request->getPost('publisher_id');
         $paid_status         = "paid";

        $book_qtys   = [];
        $book_prices = [];

        for ($i = 0; $i < $num_of_books; $i++) {
            $index = $i + 1;
            $book_qtys[]   = $request->getPost('bk_qty' . $index);
            $book_prices[] = $request->getPost('price' . $index);
        }

        // Get sales channel array and stringify
        $sales_channel = $request->getPost('sales_channel'); 
        $sales_channel = implode(', ', (array) $sales_channel); // Ensure it's a string

        $tpModel     = new TpPublisherModel();
        $order_post  = $tpModel->tppublisherOrderPost($selected_book_list);

       $data = [
        'title'                        => 'TP Publisher Orders',
        'subTitle'                     => 'Selected Book Order Details',
        'tppublisher_selected_book_id' => $selected_book_list,
        'tppublisher_order'             => $order_post,
        'book_qtys'                    => $book_qtys,
        'book_prices'                  => $book_prices,
        'author_id'                    => $author_id,
        'publisher_id'                 => $publisher_id,
        'sales_channel'                => $sales_channel,
        'paid_status'                  => $paid_status
    ];


        return view('tppublisher/tppublisherOrderView', $data);
    }

   public function tppublisherOrderSubmit()
{
    $db      = \Config\Database::connect();
    $request = service('request');
    $tpModel = new TpPublisherModel();

    $paid_status = $request->getPost('paid_status');
    $book_ids    = $request->getPost('book_ids') ?? [];
    $qtys        = $request->getPost('qtys') ?? [];
    $mrps        = $request->getPost('mrps') ?? [];
    $channels    = $request->getPost('sales_channel') ?? [];
    $date        = date('Y-m-d H:i:s');

    if (empty($book_ids)) {
        return redirect()->back()->with('error', 'No book order data submitted.');
    }

    $submittedOrders = [];

    foreach ($book_ids as $i => $book_id) {

        // Get publisher_id and author_id per book
        $ids = $tpModel->getPublisherAndAuthorByBookId($book_id);
        if (!$ids) {
            log_message('error', "Publisher/Author not found for book_id $book_id");
            continue;
        }

        $publisher_id = $ids['publisher_id'];
        $author_id    = $ids['author_id'];

        $qty     = (int)($qtys[$i] ?? 0);
        $mrp     = (float)($mrps[$i] ?? 0);
        $channel = trim($channels[$i] ?? '');

        if ($qty <= 0 || $mrp <= 0 || empty($channel)) {
            continue;
        }

        $total_amount  = $qty * $mrp;
        $discount      = round($total_amount * 0.40, 2);
        $author_amount = $total_amount - $discount;

        $channel_type = match (strtolower($channel)) {
            'amazon'     => 'AMZ',
            'book fair'  => 'BFR',
            'pustaka'    => 'PUS',
            'others'     => 'OTH',
            default      => 'BFR',
        };

        // Insert into sales table
        $db->table('tp_publisher_sales')->insert([
            'publisher_id'   => $publisher_id,
            'author_id'      => $author_id,
            'book_id'        => $book_id,
            'qty'            => $qty,
            'mrp'            => $mrp,
            'sales_channel'  => $channel,
            'channel_type'   => $channel_type,
            'total_amount'   => $total_amount,
            'discount'       => $discount,
            'author_amount'  => $author_amount,
            'paid_status'    => $paid_status,
            'create_date'    => $date,
        ]);

        // Insert into stock ledger
        $db->table('tp_publisher_book_stock_ledger')->insert([
            'publisher_id'     => $publisher_id,
            'author_id'        => $author_id,
            'book_id'          => $book_id,
            'description'      => $channel,
            'channel_type'     => $channel_type,
            'stock_in'         => 0,
            'stock_out'        => $qty,
            'transaction_date' => $date,
        ]);

        // Update stock
        $stockTable = $db->table('tp_publisher_book_stock');
        $existingStock = $stockTable->where('book_id', $book_id)->get()->getRow();
        if ($existingStock) {
            $newQty = max(0, (int)$existingStock->book_quantity - $qty);
            $stockTable->where('book_id', $book_id)
                       ->update([
                           'book_quantity'    => $newQty,
                           'stock_in_hand'    => $newQty,
                           'last_update_date' => $date,
                       ]);
        }

        // Store submitted data for view
        $submittedOrders[] = [
            'book_id'       => $book_id,
            'publisher_id'  => $publisher_id,
            'author_id'     => $author_id,
            'qty'           => $qty,
            'mrp'           => $mrp,
            'total_amount'  => $total_amount,
            'discount'      => $discount,
            'author_amount' => $author_amount,
            'channel'       => $channel,
            'channel_type'  => $channel_type,
        ];
    }

    // Prepare data for success view
    $data = [
        'title'    => 'Order Submitted',
        'subTitle' => 'Selected Book Order Details',
        'message'  => 'Your order has been submitted successfully!',
        'orders'   => $submittedOrders,
        'date'     => $date,
    ];

    return redirect()->to(base_url('tppublisher/tpordersuccess'))->with('order_data', $data);
}

        public function tpordersuccess()
        {
        $session = session();
        $data = $session->getFlashdata('order_data');

        if (!$data) {
            return redirect()->to(base_url('tppublisher/tpsalesdetails'))->with('error', 'No order data found.');
        }

        return view('tppublisher/tporderSubmit', $data);
    }
   public function tpSalesFull($createDate, $salesChannel)
{
    // decode URL encoded params
    $createDate   = rawurldecode($createDate);
    $salesChannel = rawurldecode($salesChannel);

    // load model and fetch details
    $model = new \App\Models\TpPublisherModel();
    $details = $model->getFullDetails($createDate, $salesChannel);

    // ensure $details is always an array (avoid undefined in view)
    if (empty($details) || !is_array($details)) {
        $details = [];
    }

    $data = [
        'details' => $details,
        'title'   => 'Sales Full Details',
        'subTitle'=> 'Date: ' . $createDate . ' | Channel: ' . $salesChannel
    ];

    return view('tppublisher/tpSalesFullDetails', $data);
}
public function tpSalesPaid()
{
    $create_date   = $this->request->getPost('create_date');
    $sales_channel = $this->request->getPost('sales_channel');

    // Validate input
    if (!$create_date || !$sales_channel) {
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Invalid data provided.'
        ]);
    }

    $db      = db_connect();
    $builder = $db->table('tp_publisher_sales');

    // Match date correctly
    $builder->where('sales_channel', trim($sales_channel));
    $builder->where('create_date >=', $create_date . ' 00:00:00');
    $builder->where('create_date <=', $create_date . ' 23:59:59');

    $builder->set([
        'paid_status'  => 'paid',
        'payment_date' => date('Y-m-d H:i:s')
    ]);

    $updated = $builder->update();

    if ($db->affectedRows() > 0) {
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Sales marked as Paid successfully.'
        ]);
    } else {
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'No matching sales found or already marked as Paid.'
        ]);
    }
}
    public function tpstockLedgerDetails()
    {
        $data['title']    = 'Tp Publisher Stock Ledger Details';
        $data['subTitle'] = 'Book list with stock and publisher details';
        $data['books']    = $this->TpPublisherModel->getBooks();

        return view('tppublisher/LedgerBookList', $data);
    }

    // View book details
   public function tpstockLedgerView($bookId)
{
    $data['title']    = 'ledger Book Details';
    $data['subTitle'] = 'Detailed information, stock, orders and royalty for selected book';

    // Existing model
    $model = $this->TpPublisherModel;

    // Fetch book details
    $data['book']      = $model->getBookDetails($bookId);
    $data['stock']     = $model->getBookStock($bookId);
    $data['ledger']    = $model->getLedgerStock($bookId);
    $data['orders']    = $model->getOrderDetails($bookId);

    // Fetch order + royalty and sales details
    $data['orderRoyalty'] = $model->getOrderRoyaltyDetails($bookId);
    $data['sales']        = $model->getSalesDetails($bookId);

    return view('tppublisher/LedgerBookView', $data);
}

  public function tppublishersdetails($publisher_id = null, $section = 'profile')
{
    $model = new TpPublisherModel();

    // Publisher list & info
    $all_publishers = $model->getAllPublishers();
    $publisher_info = $publisher_id ? $model->getPublisherById($publisher_id) : null;

    // Authors
    $authors = [];
    if ($publisher_id && $section === 'authors') {
        $authors = $model->getAuthorsByPublisher($publisher_id);
    }

    // Books
    $books = [];
    if ($section == 'books' && $publisher_id) {
        $books = $model->getPublisherBooks($publisher_id);
    }

    // Stock ledger
    $stock_books = [];
    if ($section == 'stock_ledger' && $publisher_id) {
        $stock_books = $model->getBooksByPublisher($publisher_id);
    }

    // Orders & Payments
    $orders = [];
    $groupedOrders = [];
    $payments = [];
    $orderStats = [];
    if ($publisher_id && in_array($section, ['orders', 'payments', 'sales'])) {
        $orders = $model->getPublisherOrder($publisher_id, 0);
        $groupedOrders = [
            'in_progress' => $model->getPublisherOrder($publisher_id, 0),
            'shipped'     => $model->getPublisherOrder($publisher_id, 1),
            'returned'    => $model->getPublisherOrder($publisher_id, 3),
            'cancelled'   => $model->getPublisherOrder($publisher_id, 2)
        ];
        $payments = $model->tpPublisherOrderPayments($publisher_id);
        $orderStats = $model->getOrdersPaymentStats($publisher_id);
    }

    // Sales & Payment Details
    $sales = $salespay = $paymentpay = $salesSummary = $publisher_data = [];
    $salesStats = []; // <--- Added for channel-wise stats

    if ($publisher_id && in_array($section, ['orders', 'payments', 'sales'])) {
        $sales = $model->tpBookSaleData($publisher_id);
        $salespay = $model->getGroupedSale($publisher_id);
        $paymentpay = $model->getPaymentSale($publisher_id);
        $salesSummary = $model->getSaleSummary($publisher_id);
        $publisher_data = $model->countsData($publisher_id);

        // New: Fetch sales stats (Amazon, Pustaka, Book Fair, Others)
        $salesStats = $model->getPublisherSalesStats($publisher_id);
    }

    $title = $publisher_info 
        ? $publisher_info['publisher_name'] . " - " . ucfirst($section)
        : "Select Publisher";

    // Pass all data to view
    $data = [
        'all_publishers'        => $all_publishers,
        'selected_publisher_id' => $publisher_id,
        'publisher_info'        => $publisher_info,
        'section'               => $section,
        'title'                 => $title,
        'authors'               => $authors,
        'books'                 => $books,
        'stock_books'           => $stock_books,
        'orders'                => $orders,
        'groupedOrders'         => $groupedOrders,
        'payments'              => $payments,
        'orderStats'            => $orderStats,
        'sales'                 => $sales,
        'salespay'              => $salespay,
        'paymentpay'            => $paymentpay,
        'salesSummary'          => $salesSummary,
        'publisher_data'        => $publisher_data,
        'salesStats'            => $salesStats, // ✅ send to view
    ];

    return view('tppublisher/tppublishersfullDetails', $data);
}
public function getShippedOrders()
    {
        $model = new TpPublisherModel();

        $data = [
            'title' => 'Shipped Orders - Last 30 Days & Pending Payments',
            'recentOrders' => $model->getRecentShippedOrders(),
            'oldPendingOrders' => $model->getOldPendingOrders(),
        ];

        return view('tppublisher/shippedOrders', $data);
    }

    // 🔹 All Shipped Orders (for Load All button)
    public function getAllShippedOrders()
    {
        $model = new TpPublisherModel();

        $data = [
            'title' => '',
            'allOrders' => $model->getAllShippedOrders(),
        ];

        return view('tppublisher/AllShippedOrders', $data);
    }


}
