<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TpDashboardModel; 


class TpPublisherDashboard extends BaseController
{

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->TpDashboardModel = new TpDashboardModel();
        helper('url');
        $this->session = session();
    }
    public function tpPublisherDashboard()
    {
        $session = session();
        $user_id   = $session->get('user_id');
        $user_type = $session->get('user_type');

        if (!$user_id) {
            return redirect()->to('/login');
        }

        if ($user_type == 4) {
            $data['details'] = $this->TpDashboardModel->getAlltpPublishersDetails();
        } else {
            $publisher_id = $this->TpDashboardModel->getPublisherIdFromUserId($user_id);

            if (!$publisher_id) {
                echo "No publisher found for user ID: $user_id";
                exit;
            }      
            $data['publisher_data'] = $this->TpDashboardModel->countData($publisher_id);
            $data['orders'] = $this->TpDashboardModel->getPublisherOrdersByStatus(0, 0, $publisher_id);
            $data['pendingOrders'] = $this->TpDashboardModel->getPendingOrders($publisher_id);
            $data['pendingSales']  = $this->TpDashboardModel->getPendingSales($publisher_id);
        }

        $data['user_type'] = $user_type;
        $data['title'] = 'Publisher Dashboard';
        $data['subTitle'] = 'Overview and Statistics';

        return view('tppublisherdashboard/tppublisherDashboard', $data);
    }
    public function viewPublisherBooks()
    {
        $session = session();
        $user_id = $session->get('user_id');
        $user_type = $session->get('user_type');

        if (!$user_id) {
            return redirect()->to('/login');
        }

        $publisher_id = $this->TpDashboardModel->getPublisherIdFromUserId($user_id);

        if (!$publisher_id) {
            echo "No publisher found for user ID: $user_id";
            exit;
        }

        $data['books'] = $this->TpDashboardModel->getBooksByPublisher($publisher_id);
        $data['title'] = 'Titles';
        $data['subTitle'] = 'View All Books for this Publisher'; 

        return view('tppublisherdashboard/tpViewBooks', $data);
    }

    public function tppublisherCreateOrder()
    {
        if (!session()->has('user_id')) {
            return redirect()->to(base_url('adminv4'));
        }

        $user_id = session()->get('user_id');
        $publisher_id = $this->TpDashboardModel->getPublisherIdFromUserId($user_id);

        if (!$publisher_id) {
            return redirect()->back()->with('error', 'Publisher not found.');
        }

        $data = [
            'title' => 'Create Orders',
            'subTitle' => 'Selected Book Order Details',
            'details' => $this->TpDashboardModel->gettpPublishersDetails($publisher_id),
        ];

        return view('tppublisherdashboard/tpCreateOrder', $data);
    }
    public function tppublisherOrder()
    {
        if (!session()->has('user_id')) {
            return redirect()->to(base_url('adminv4'));
        }

        $selected_book_list = $this->request->getPost('selected_book_list');

        log_message('debug', 'Selected Books list.... ' . $selected_book_list);

        $tpModel = new TpdashboardModel();
        $booksData = $tpModel->tppublisherSelectedBooks($selected_book_list);

        $data = [
            'title' => 'Publisher Orders',
            'subTitle' => 'Selected Book Order Details',
            'tppublisher_selected_book_id' => $selected_book_list,
            'tppublisher_selected_books_data' => $booksData,
        ];

        return view('tppublisherdashboard/tppublisherOrderList', $data);
    }
    public function tppublisherOrderStock()
{
    if (!session()->has('user_id')) {
        return redirect()->to(base_url('adminv4'));
    }

    $request = service('request');
    
    if ($request->getMethod() !== 'POST') {
        return redirect()->back()->with('error', 'Invalid request method');
    }

    // Your existing data processing code...
    $num_of_books       = (int) $request->getPost('num_of_books');
    $selected_book_list = $request->getPost('selected_book_list');
    $address            = $request->getPost('address');
    $mobile             = $request->getPost('mobile');
    $ship_date          = $request->getPost('ship_date');
    $author_id          = $request->getPost('author_id');
    $publisher_id       = $request->getPost('publisher_id');
    $transport          = $request->getPost('transport');
    $comments           = $request->getPost('comments');
    $contact_person     = $request->getPost('contact_person');
    $city               = $request->getPost('city');

    $book_qtys   = [];
    $book_prices = [];

    for ($i = 0; $i < $num_of_books; $i++) {
        $index = $i + 1;
        $book_qtys[]   = $request->getPost('bk_qty' . $index);
        $book_prices[] = $request->getPost('price' . $index);
    }

    $tpModel = new TpdashboardModel();
    $paperback_stock = $tpModel->tppublisherOrderStock($selected_book_list);

    $data = [
        'title'        => 'Publisher Orders',
        'subTitle'     => 'Selected Book Order Details',
        'tppublisher_selected_book_id' => $selected_book_list,
        'tppublisher_paperback_stock'  => $paperback_stock,
        'book_qtys'    => $book_qtys,
        'book_prices'  => $book_prices,
        'address'      => $address,
        'mobile'       => $mobile,
        'ship_date'    => $ship_date,
        'author_id'    => $author_id,
        'publisher_id' => $publisher_id,
        'transport'    => $transport,
        'comments'     => $comments,
        'contact_person' => $contact_person,
        'city'           => $city,
    ];

    // ✅ Store with flashdata that persists for one more request
    session()->setFlashdata('order_preview_data', $data);
    return redirect()->to('/tppublisherdashboard/orderpreview');
}

public function orderpreview()
{
    if (!session()->has('user_id')) {
        return redirect()->to(base_url('adminv4'));
    }

    // ✅ Use getFlashdata() instead of get()
    $data = session()->getFlashdata('order_preview_data');
    
    if (!$data) {
        // ✅ If no flashdata, check if we can get from temp session
        $data = session()->get('order_temp_data');
        if (!$data) {
            return redirect()->to('/tppublisherdashboard/tppublisherdashboard')->with('error', 'No order data found. Please start over.');
        }
    } else {
        // ✅ Store in temp session for page refresh
        session()->set('order_temp_data', $data);
    }

    return view('tppublisherdashboard/tppublisherOrderView', $data);
}

public function tppublisherOrderSubmit()
{
    $request = service('request');
    $session = session();
    $model   = new TpDashboardModel();

    $user_id = $session->get('user_id');
    if (!$user_id) {
        return redirect()->to(base_url('adminv4'));
    }

    // Check if it's a POST request
    if ($request->getMethod() !== 'POST') {
        return redirect()->back()->with('error', 'Invalid request method');
    }

    // Check if royalty payment completed
    $payment_status = $request->getPost('payment_status');
    if ($payment_status !== 'success') {
        return redirect()->back()->with('error', 'Royalty payment not completed. Please pay the royalty to confirm order.');
    }

    $ids = $model->getPublisherAndAuthorId($user_id);
    if (!$ids) {
        return redirect()->back()->with('error', 'Publisher or Author ID not found.');
    }

    $publisher_id = $ids['publisher_id'];
    $author_id    = $ids['author_id'];

    // Get arrays of book IDs and quantities
    $book_ids   = $request->getPost('book_id');      
    $quantities = $request->getPost('quantity');  
    $address    = $request->getPost('address');
    $mobile     = $request->getPost('mobile');
    $ship_date  = $request->getPost('ship_date');
    $transport  = $request->getPost('transport');
    $comments   = $request->getPost('comments');
    $contact_person = $request->getPost('contact_person');
    $city           = $request->getPost('city');

    if (empty($book_ids) || empty($quantities)) {
        return redirect()->back()->with('error', 'No books selected for the order.');
    }

    // Submit the order
    $result = $model->tppublisherOrderSubmit(
        $user_id,
        $author_id,
        $publisher_id,
        $book_ids,
        $quantities,
        $address,
        $mobile,
        $ship_date,
        $transport,
        $comments,
        $contact_person,  
        $city    
    );

    if (!$result) {
        return redirect()->back()->with('error', 'Order submission failed.');
    }

    // ✅ REDIRECT instead of loading view directly
    return redirect()->to('/tppublisherdashboard/ordersuccess')->with('success', 'Publisher order submitted successfully after royalty payment!');
}

// ✅ NEW METHOD - For order success page (GET request)
public function ordersuccess()
{
    if (!session()->has('user_id')) {
        return redirect()->to(base_url('adminv4'));
    }

    $data = [
        'title'    => 'Order Success',
        'subTitle' => 'Order Confirmation',
        'success'  => true,
        'message'  => session('success') ?? 'Order submitted successfully!',
    ];

    return view('tppublisherdashboard/tpOrderSubmit', $data);
}
    public function tppublisherOrderDetails()
    {
        if (!session()->has('user_id')) {
            return redirect()->to(base_url('adminv4'));
        }

        $user_id = session()->get('user_id');
        $publisher_id = $this->TpDashboardModel->getPublisherIdFromUserId($user_id);

        if (!$publisher_id) {
            return redirect()->back()->with('error', 'Publisher not found.');
        }

        $model = new TpDashboardModel();

        // In Progress Orders (status = 0)
        $orders = $model->getPublisherOrdersByStatus(0, 0, $publisher_id); // In-progress
        $groupedOrders = [
        'shipped'   => $model->getPublisherOrdersByStatus(1, 1, $publisher_id),
        'returned'  => $model->getPublisherOrdersByStatus(3, 3, $publisher_id),
        'cancelled' => $model->getPublisherOrdersByStatus(2, 2, $publisher_id)
    ];

        $data = [
            'orders' => $orders,
            'groupedOrders' => $groupedOrders,
            'title' => 'Order Details',
            'subTitle' => 'In-Progress Orders'
        ];

        return view('tppublisherdashboard/tppublisherOrderDetails', $data);
    }

    public function tpOrderFullDetails($order_id)
    {
        $model = new TpDashboardModel();
        $result = $model->tpOrderFullDetails($order_id);

        $data = [
            'order'    => $result['order'], 
            'books'    => $result['books'], 
            'title'    => 'Order Details',
            'subTitle' => 'Order #' . $order_id
        ];

        return view('tppublisherdashboard/tpOrderFullDetails', $data);
    }
    public function tpSalesDetails()
    {
        if (!session()->has('user_id')) {
            return redirect()->to(base_url('adminv4'));
        }

        $user_id = session()->get('user_id');

        // Get publisher_id using user_id
        $publisher_id = $this->TpDashboardModel->getPublisherIdFromUserId($user_id);

        if (!$publisher_id) {
            return redirect()->back()->with('error', 'Publisher not found.');
        }

        $model = new TpDashboardModel();

        // Pass publisher_id to model to get only that publisher’s sales
        $data['sales']    = $model->tpSalesDetails($publisher_id);
        $data['title']    = 'Sales Summary';
        $data['subTitle'] = 'Total sales quantity and amount by sales channel';

        return view('tppublisherdashboard/tpSalesDetails', $data);
    }

    public function handlingAndPay()
    {
        if (!session()->has('user_id')) {
            return redirect()->to(base_url('adminv4'));
        }

        $user_id = session()->get('user_id');
        $publisher_id = $this->TpDashboardModel->getPublisherIdFromUserId($user_id);

        if (!$publisher_id) {
            return redirect()->back()->with('error', 'Publisher not found.');
        }
        $model = new TpDashboardModel();
        $data = [
            'handlingCharges' => $model->getHandlingCharges($publisher_id),
            'payAuthor'       => $model->getPayToAuthor($publisher_id),
            'sales'           => $model->getGroupedSales($publisher_id),
            'title'           => 'Payment Details',
            'subTitle'        => 'Handling Charges (Pustaka) & Pay to Author Summary'
        ];

        return view('tppublisherdashboard/handlingAndPay', $data);
    }

    public function tpSalesFull($createDate, $salesChannel)
    {
        
        $createDate   = rawurldecode($createDate);
        $salesChannel = rawurldecode($salesChannel);
        $model = new \App\Models\TpDashboardModel();
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

        return view('tppublisherdashboard/tpSalesFullDetails', $data);
    }

    public function tpBookFullDetails($bookId)
    {
        $model = new \App\Models\TpDashboardModel();
        $book  = $model->getBookFullDetails($bookId); 

        if (!$book) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Book not found");
        }

        $data = [
            'book'       => $book,
            'title'      => 'Book Details',
            'subTitle'   => !empty($book['book_regional_title']) 
                            ? $book['book_regional_title'] 
                            : 'Complete information about the book'
        ];

        return view('tppublisherdashboard/viewBookDetails', $data);
    }
    public function tpSalesData()
    {
        return $this->db->table('tp_publisher_sales')
            ->select('sales_channel, create_date, SUM(qty) as total_qty, SUM(total_amount) as total_amount, SUM(discount) as discount, SUM(author_amount) as author_amount')
            ->groupBy(['sales_channel', 'create_date'])
            ->orderBy('sales_channel', 'ASC')
            ->orderBy('create_date', 'DESC')
            ->get()
            ->getResultArray();
    }
    public function tpstockLedgerDetails()
    {
        // Ensure user is logged in
        if (!session()->has('user_id')) {
            return redirect()->to(base_url('adminv4'));
        }
        $user_id = session()->get('user_id');

        // Get publisher ID from user ID
        $publisher_id = $this->TpDashboardModel->getPublisherIdFromUserId($user_id);

        if (!$publisher_id) {
            return redirect()->back()->with('error', 'Publisher not found.');
        }

        // Fetch only publisher-specific books
        $data['title']     = 'Tp Publisher Stock Ledger Details';
        $data['subTitle']  = 'Book list with stock and publisher details';
        $data['books']     = $this->TpDashboardModel->getBooks($publisher_id);
        return view('tppublisher/LedgerBookList', $data);
    }

    // View book details
    public function tpstockLedgerView($bookId)
    {
        $publisher_id      = session()->get('publisher_id');
        $data['title']     = 'Ledger Book Details';
        $data['subTitle']  = 'Detailed info, stock, orders and royalty for selected book';

        $model = $this->TpDashboardModel;

        // Fetch only publisher-specific data
        $data['book']         = $model->getBookDetails($bookId, $publisher_id);
        $data['stock']        = $model->getBookStock($bookId, $publisher_id);
        $data['ledger']       = $model->getLedgerStock($bookId, $publisher_id);
        $data['orders']       = $model->getOrderDetails($bookId, $publisher_id);
        $data['orderRoyalty'] = $model->getOrderRoyaltyDetails($bookId, $publisher_id);
        $data['sales']        = $model->getSalesDetails($bookId, $publisher_id);

        return view('tppublisher/LedgerBookView', $data);
    }
}
