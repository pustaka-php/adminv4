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
        $data['orders'] = $this->TpDashboardModel->getPublisherOrdersByStatus(0, 0);
        $data['handlingCharges'] = $this->TpDashboardModel->getHandlingCharges();
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
    $data['title'] = 'Publisher Book Details';
    $data['subTitle'] = 'View All Books for this Publisher'; // 👈 Subtitle added

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
        'title' => 'TP Publisher Create Orders',
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
        'title' => 'TP Publisher Orders',
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
    $num_of_books     = (int) $request->getPost('num_of_books');
    $selected_book_list = $request->getPost('selected_book_list');
    $address          = $request->getPost('address');
    $mobile           = $request->getPost('mobile');
    $ship_date        = $request->getPost('ship_date');
    $author_id        = $request->getPost('author_id');
    $publisher_id     = $request->getPost('publisher_id');

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
        'title'        => 'TP Publisher Orders',
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
    ];
// echo '<pre>';
// print_r($_POST);
// echo '</pre>';
// exit;
    echo view('tppublisherdashboard/tppublisherOrderView', $data);
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
        $book_ids   = $request->getPost('book_id');      // array
        $quantities = $request->getPost('quantity');    // array
        $address    = $request->getPost('address');
        $mobile     = $request->getPost('mobile');
        $ship_date  = $request->getPost('ship_date');

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
            $ship_date
        );

        if (!$result) {
            return redirect()->back()->with('error', 'Order submission failed.');
        }

        $data = [
            'title'   => 'TP Publisher Orders',
            'subTitle'=> 'Selected Book Order Details',
            'success' => true,
            'message' => 'Publisher order submitted successfully after royalty payment!',
        ];

        return view('tppublisherdashboard/tpOrderSubmit', $data);
    }
public function tppublisherOrderDetails()
{
    $model = new TpDashboardModel();

    // In Progress
    $orders = $model->getPublisherOrdersByStatus(0, 0);

    // Grouped orders
    $groupedOrders = [
        'shipped'   => $model->getPublisherOrdersByStatus(1), // shipped
        'returned'  => $model->getPublisherOrdersByStatus(3), // returned
        'cancelled' => $model->getPublisherOrdersByStatus(2)  // cancelled
    ];

    $data = [
        'orders' => $orders,
        'groupedOrders' => $groupedOrders,
        'title' => 'TP Publisher Order Details',
        'subTitle' => 'In-Progress Orders'
    ];

    return view('tppublisherdashboard/tppublisherOrderDetails', $data);
}
 public function tpOrderFullDetails($order_id)
{
    $model = new TpDashboardModel();
    $result = $model->tpOrderFullDetails($order_id);

    $data = [
        'order'    => $result['order'], // pass main order
        'books'    => $result['books'], // pass books array
        'title'    => 'Author Order Details',
        'subTitle' => 'Order #' . $order_id
    ];

    return view('tppublisherdashboard/tpOrderFullDetails', $data);
}
 public function tpSalesDetails()
{
    $model = new TpDashboardModel();

    $data['sales']    = $model->tpSalesDetails();
    $data['title']    = 'Sales Summary';
    $data['subTitle'] = 'Total sales quantity and amount by sales channel';

    return view('tppublisherdashboard/tpSalesDetails', $data);
}
public function handlingAndPay()
{
    $model = new TpDashboardModel();
    $groupedSales = $model->getGroupedSales();

    $data = [
        'handlingCharges' => $model->getHandlingCharges(),
        'payAuthor'       => $model->getPayToAuthor(),
        'sales'           => $groupedSales,
        'title'           => 'Author Payment Details',
        'subTitle'        => 'Handling Charges (Pustaka) & Pay to Author Summary'
    ];

    return view('tppublisherdashboard/handlingAndPay', $data);
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
        'title'   => 'TP Publisher Sales Full Details',
        'subTitle'=> 'Date: ' . $createDate . ' | Channel: ' . $salesChannel
    ];

    return view('tppublisherdashboard/tpSalesFullDetails', $data);
}

}
