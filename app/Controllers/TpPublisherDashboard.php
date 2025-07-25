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

        $data['details'] = $this->TpDashboardModel->gettpPublishersDetails($publisher_id);
    }

    $data['user_type'] = $user_type;
    $data['title'] = 'Publisher Dashboard';
    $data['subTitle'] = 'Overview and Statistics';

    return view('tppublisherdashboard/tppublisherDashboard', $data);
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
    $num_of_books = (int) $request->getPost('num_of_books');
    $selected_book_list = $request->getPost('selected_book_list');
    $address = $request->getPost('address');
    $mobile = $request->getPost('mobile');
    $ship_date = $request->getPost('ship_date');

    $author_id = $request->getPost('author_id');
    $publisher_id = $request->getPost('publisher_id');

    $book_qtys = [];
    $book_prices = [];

    for ($i = 0; $i < $num_of_books; $i++) {
        $index = $i + 1;
        $book_qtys[] = $request->getPost('bk_qty' . $index);
        $book_prices[] = $request->getPost('price' . $index);
    }

    $tpModel = new TpdashboardModel();
    $paperback_stock = $tpModel->tppublisherOrderStock($selected_book_list);

    $data = [
        'title' => 'TP Publisher Orders',
        'subTitle' => 'Selected Book Order Details',
        'tppublisher_selected_book_id' => $selected_book_list,
        'tppublisher_paperback_stock'  => $paperback_stock,
        'book_qtys'                    => $book_qtys,
        'book_prices'                  => $book_prices,
        'address'                      => $address,
        'mobile'                       => $mobile,
        'ship_date'                    => $ship_date,
        'author_id'                    => $author_id,
        'publisher_id'                 => $publisher_id,
    ];
    echo view('tppublisherdashboard/tppublisherOrderView', $data);
}


   public function tppublisherOrderSubmit()
{
    $request = service('request');
    $session = session();
    $model = new \App\Models\TpDashboardModel();

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

    $num_of_books       = (int) $request->getPost('num_of_books');
    $selected_book_list = $request->getPost('selected_book_list');
    $address            = $request->getPost('address');
    $mobile             = $request->getPost('mobile');
    $ship_date          = $request->getPost('ship_date');

    // Save the order after royalty payment success
    $result = $model->tppublisherOrderSubmit(
        $user_id,
        $author_id,
        $publisher_id,
        $num_of_books,
        $selected_book_list,
        $address,
        $mobile,
        $ship_date
    );

    if (!$result) {
        return redirect()->back()->with('error', 'Order submission failed.');
    }

    $data = [
        'title' => 'TP Publisher Orders',
        'subTitle' => 'Selected Book Order Details',
        'success' => true,
        'message' => 'Publisher order submitted successfully after royalty payment!',
    ];
    return view('tppublisherdashboard/tpOrderSubmit', $data);
}
public function tppublisherOrderDetails()
    {
        $model = new TpDashboardModel();
        $allOrders = $model->getPublisherOrders();

        $data = [
            'title' => 'All Publisher Orders',
            'subTitle' => 'Selected Book Order Details',
            'orders' => $allOrders,
            'today' => date('Y-m-d')
        ];
        return view('tppublisherdashboard/tppublisherOrderDetails', $data);  
    }
    public function tppublisherOrderPayment()
{
    $model = new TpDashboardModel();
    $allpayments = $model->tpPublisherOrderPayment();

    $data = [
        'title' => 'Publisher Payments',
        'subTitle' => 'Selected Book Order Details',
        'orders' => $allpayments,
        'today' => date('Y-m-d')
    ];
    echo view('tppublisherdashboard/tppublisherOrderPayment', $data);
}

}
