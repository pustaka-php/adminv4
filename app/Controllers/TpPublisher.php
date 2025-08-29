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

    
   public function tppublisherDashboard($order_id = null)
{
    $tpModel = new TpPublisherModel(); // define model

    // Base dashboard data
    $data = [
        'title'           => 'TpPublisher',
        'subTitle'        => 'Dashboard',
        'publisher_data'  => $tpModel->countData(),
        'orders'          => $tpModel->getPublisherOrders(),
        'payments'        => $tpModel->tpPublisherOrderPayment(),
    ];

    // If order_id is given, fetch order details
    if (!empty($order_id)) {
        $result = $tpModel->tpOrderFullDetails($order_id);
        $data['order'] = $result['order'] ?? null;
        $data['books'] = $result['books'] ?? [];
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
        'title' => 'TpStock',
        'subTitle' => 'Stock Details',
        'stock_details' => $model->getStockDetails(),  // <- fixed
    ];

    return view('tppublisher/tpstockDetails', $data); 
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

    if (!$author_id) {
        return $this->response->setStatusCode(400)->setBody('No author ID');
    }

    $TpPublisherModel = new TpPublisherModel();
    $books = $TpPublisherModel->getBooksByAuthor($author_id);

    if (!$books) {
        return $this->response->setStatusCode(404)->setBody('No books found');
    }

    $options = '<option value="">Select Book</option>';
    foreach ($books as $book) {
        $options .= '<option value="' . $book->book_id . '">' . $book->book_title . '</option>';
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

    if ($order_id) {
        $this->db->table('tp_publisher_order')
            ->where('order_id', $order_id)
            ->update(['payment_status' => 'Paid']);
    }

    return redirect()->back()->with('success', 'Order marked as Paid.');
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

    // Get sales data
    $salesData    = $model->tpBookSalesData();  

    // Prepare data for the view
    $data = [
        'title'       => 'Book Sales Details',
        'subTitle'    => 'Sales Books Details',
        'sales_data'  => $salesData,
        'total_count' => count($salesData),
    ];

    return view('tppublisher/tpbookSalesView', $data);
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

    // In Progress
    $orders = $model->getPublisherOrders(0, 0);

    // Grouped orders
    $groupedOrders = [
        'shipped'   => $model->getPublisherOrders(1), // shipped
        'returned'  => $model->getPublisherOrders(3), // returned
        'cancelled' => $model->getPublisherOrders(2)  // cancelled
    ];

    $data = [
        'orders' => $orders,
        'groupedOrders' => $groupedOrders,
        'title' => 'TP Publisher Order Details',
        'subTitle' => 'In-Progress Orders'
    ];

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
        $ids = $tpModel->getPublisherAndAuthorId();

        if (!$ids || !isset($ids['publisher_id'], $ids['author_id'])) {
            return redirect()->back()->with('error', 'Publisher or Author ID not found.');
        }

        $publisher_id = $ids['publisher_id'];
        $author_id    = $ids['author_id'];
        $paid_status = $request->getPost('paid_status');
        $book_ids     = $request->getPost('book_ids') ?? [];
        $qtys         = $request->getPost('qtys') ?? [];
        $mrps         = $request->getPost('mrps') ?? [];
        $channels = $request->getPost('sales_channel') ?? [];

        $date = date('Y-m-d H:i:s');

        if (empty($book_ids)) {
            return redirect()->back()->with('error', 'No book order data submitted.');
        }

        $submittedOrders = [];

        foreach ($book_ids as $i => $book_id) {
            $qty     = (int)($qtys[$i] ?? 0);
            $mrp     = (float)($mrps[$i] ?? 0);
            $channel_raw = $channels[$i] ?? '';
            $channel = trim($channel_raw); // Keep original casing

            if (empty($channel)) {
                log_message('error', "Missing or invalid channel at index $i");
                continue;
            }

            if ($qty <= 0 || $mrp <= 0 || empty($channel)) {
                continue;
            }

            $total_amount  = $qty * $mrp;
            $discount      = round($total_amount * 0.40, 2);
            $author_amount = $total_amount - $discount;

            // Normalize and map to channel_type code
            $clean_channel = strtolower($channel);
            $channel_type = match ($clean_channel) {
                'amazon'     => 'AMZ',
                'book fair'  => 'BFR',
                'pustaka'    => 'PUS',
                'others'     => 'OTH',
                default      => 'OTH',
            };

            // Insert into tp_publisher_sales
            $db->table('tp_publisher_sales')->insert([
                'publisher_id'   => $publisher_id,
                'author_id'      => $author_id,
                'book_id'        => $book_id,
                'qty'            => $qty,
                'mrp'            => $mrp,
                'sales_channel' => $channel,
                'total_amount'   => $total_amount,
                'discount'       => $discount,
                'author_amount'  => $author_amount,
                'paid_status'   =>  $paid_status,
                'create_date'    => $date,
            ]);

            // Insert into tp_publisher_book_stock_ledger
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

            // Update stock in tp_publisher_book_stock
            $stockTable = $db->table('tp_publisher_book_stock');
            $existingStock = $stockTable->where('book_id', $book_id)->get()->getRow();

            if ($existingStock) {
                $currentQty = (int)$existingStock->book_quantity;
                $newQty     = max(0, $currentQty - $qty);

                $stockTable->where('book_id', $book_id)->update([
                    'book_quantity'     => $newQty,
                    'stock_in_hand'     => $newQty,
                    'last_update_date'  => $date,
                ]);
            }

            // Store submitted data
            $submittedOrders[] = [
                'book_id'       => $book_id,
                'qty'           => $qty,
                'mrp'           => $mrp,
                'total_amount'  => $total_amount,
                'discount'      => $discount,
                'author_amount' => $author_amount,
                'channel'       => $channel,
                'channel_type'  => $channel_type,
            ];
        }

        // Prepare view data
        $data = [
            'title'        => 'Order Submitted',
            'subTitle'     => 'Selected Book Order Details',
            'message'      => 'Your order has been submitted successfully!',
            'orders'       => $submittedOrders,
            'date'         => $date,
            'publisher_id' => $publisher_id,
            'author_id'    => $author_id,
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
     public function tpSalesFull($create_date, $sales_channel)
{
    $model = new TpPublisherModel();
    $data['sales'] = $model->getFullDetails($create_date, $sales_channel);

    return view('tppublisher/tpSalesFullDetails', $data);
}
public function tpSalesPaid()
    {
        $create_date   = $this->request->getPost('create_date');
        $sales_channel = $this->request->getPost('sales_channel');

        if (!$create_date || !$sales_channel) {
            return redirect()->back()->with('error', 'Invalid data provided.');
        }

        // Update paid_status in database
        $updated = $this->db->table('tp_publisher_sales')
            ->where('create_date', $create_date)
            ->where('sales_channel', $sales_channel)
            ->set([
                'paid_status'   => 'paid',
                'payment_date'  => date('Y-m-d H:i:s')
            ])
            ->update();

        if ($updated) {
            return redirect()->back()->with('success', 'Sales marked as Paid successfully.');
        }

        return redirect()->back()->with('error', 'Failed to update Paid status.');
    }

}
