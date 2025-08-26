<?php

namespace App\Controllers;
use App\Models\StockModel; 

use App\Controllers\BaseController;

class Stock extends BaseController
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->StockModel = new StockModel();
        helper('url');
        $this->session = session();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'subTitle' => 'Investment',
        ];
        return view('stock/stockDashboard', $data);
    }
    public function stockdashboard()
    {
        $StockModel = new StockModel();

        $data = [
            'details' => $StockModel->getDashboardDetails(),
            'title'     => 'Stock Dashboard',
            'subTitle'  => 'Overview',
        ];

        // ob_start();
        // echo "<pre>";
        // print_r($data['details']);
        // echo "</pre>";
        // return ob_get_clean();

        return view('stock/stockDashboard', $data); 
    }
    public function getstockdetails()
    {
       $StockModel = new StockModel();
       
       $data= [
        'stock_details' => $StockModel->getStockDetails(),
        'stock_data' => $StockModel->getBookFairDetails(),
        'mismatch_stock' => $StockModel->getMismatchStockDetails(),
        'title'     => 'Stock Details',
        'subTitle'  => 'Overview',
       ];
        //    echo"<pre>";
        //   print_r($data);
       return view('stock/stockDetails', $data);
        
    }
    public function outofstockdetails()
    {
        $StockModel = new StockModel();

        $data= [
            'stockout_details' => $StockModel->getOutofstockdetails(),
            'title'     => 'Out of Stock Details',
            'subTitle'  => 'Overview',
        ];

        return view('stock/outOfstockDetails', $data);

    }
    public function loststockdetails()
    {
        $StockModel = new StockModel();

        $data= [
            'loststock_details' => $StockModel->getLostStockDetails(),
            'title'     => 'Lost Stock Details',
            'subTitle'  => 'Overview',
        ];

        return view('stock/lostStockDetails', $data);
    }
    public function outsidestockdetails()
    {
        $StockModel = new StockModel();

        $data= [

            'outsidestock_details' => $StockModel->getOutsideStockDetails(),
            'stock_data' => $StockModel->getBookFairDetails(),
            'title'     => 'Outside Stock Details',
            'subTitle'  => 'Overview',
        ];
        //   echo"<pre>";

        // print_r($data);
    
        return view('stock/outSidestockDetails', $data);
    }
    public function addstock()
    {
       $StockModel = new StockModel();

       $data = [    
           'paperback_books' => $StockModel->getPaperbackBooks(),
           'title'     => 'Add Stock',
           'subTitle'  => 'Overview',
       ];

        // ob_start();
        // echo "<pre>";
        // print_r($data['paperback_books']);
        // echo "</pre>";
        // return ob_get_clean();

        return view('stock/addStock', $data);
    }
    public function bookslist()
    {
        $selectedBookList = $this->request->getPost('selected_book_list') ?: $this->request->getGet('selected_book_list');

        log_message('debug', 'Selected Books list: ' . $selectedBookList);

        $StockModel = new StockModel();

        $data = [
            'selected_book_id' => $selectedBookList,
            'selected_books_data' => $StockModel->getPaperbackSelectedBooksList($selectedBookList),
            'title' => 'Selected Books',
            'subTitle' => 'Overview',
        ];

        return view('stock/stockbooksList', $data);
    }
   public function submitdetails()
    {
        if (!session()->get('user_id')) {
            return redirect()->to(base_url('adminv4'));
        }
        $StockModel = new StockModel();
 
        $book_id = $this->request->getPost('book_id');
        $qty = $this->request->getPost('quantity');
        $updated_user_id = session()->get('user_id');
        $last_update_date = date('Y-m-d H:i:s');
        // $validate_user_id = session()->get('user_id');
        // $last_validated_date = date('Y-m-d H:i:s');

        $result = $StockModel->submitDetails($book_id, $qty, $updated_user_id, $last_update_date);

        echo $result;
    }
    
    public function stockentrydetails()
    {
        $book_id = $this->request->getGet('book_id'); 

        if (empty($book_id)) {
            return redirect()->to('stock/stockdashboard')->with('error', 'Invalid request!');
        }

        $StockModel = new StockModel();

        $data = [
            'book_id' => $book_id,
            'book_details' => $StockModel->getBookDetails($book_id),
            'author_transaction' => $StockModel->getAuthorTransaction($book_id),
            'stock_ledger' => $StockModel->getStockLedger($book_id),
            'stock_user_details' => $StockModel->getStockUserDetails($book_id), 
            'title' => 'Stock Entry Details',
            'subTitle' => 'Overview',
        ];

        return view('stock/stockEntryDetailsView', $data);
    }
    public function validateStock()
    {
        if (!session()->get('user_id')) {
            return redirect()->to(base_url('adminv4'))->with('error', 'Please login first.');
        }

        $book_id = $this->request->getPost('book_id');
        $user_id = session()->get('user_id');
        $validate_date = date('Y-m-d H:i:s');

        if (empty($book_id)) {
            return redirect()->back()->with('error', 'Book ID is missing.');
        }

        $StockModel = new StockModel();
        $updated = $StockModel->updateValidationInfo($book_id, $user_id, $validate_date);

        if ($updated) {
            return redirect()->to('stock/addstock')->with('message', 'Stock validated successfully!');
        } else {
            return redirect()->back()->with('error', 'Validation failed.');
        }

        if (empty($book_id)) {
            return redirect()->to('stock/stockdashboard')->with('error', 'Invalid request!');
        }

        $StockModel = new StockModel();

        $data = [
            'book_id' => $book_id,
            'book_details' => $StockModel->getBookDetails($book_id),
            'author_transaction' => $StockModel->getAuthorTransaction($book_id),
            'stock_ledger' => $StockModel->getStockLedger($book_id),
            'title' => 'Stock Entry Details',
            'subTitle' => 'Overview',
        ];

        return view('stock/stockEntryDetailsView', $data);
    }
    function otherdistribution(){

		$data =[
            'title' => 'Other Distribution',
            'subTitle' => 'Overview',
            'other_distribution' => $this->StockModel->getOtherDistributionDetails(),
        ];

        return view('stock/otherDistribution', $data);
    }
    public function saveotherdistribution()
    {
        $orderData = [
            'order_id'    => time(),
            'order_date'  => date('Y-m-d H:i:s'),
            'book_id'     => $this->request->getPost('book_id'),
            'type'        => $this->request->getPost('type'),
            'purpose'     => $this->request->getPost('purpose'),
            'quantity'    => $this->request->getPost('quantity')
        ];

        $this->StockModel->insertOtherDistribution($orderData);

        return redirect()->back()->with('success', 'Data saved successfully.');
    }


    public function UpdatevalidateStock($bookId)
    {
       
        $StockModel = new StockModel();

        // Check login
        if (!session()->get('user_id')) {
            return redirect()
                ->to(base_url('adminv4'))
                ->with('error', 'Please login first.');
        }

        $book_id = $bookId;
        $user_id = session()->get('user_id');
        $validate_date = date('Y-m-d H:i:s');

        $updated = $StockModel->updateValidationInfo($book_id, $user_id, $validate_date);

        if ($updated) {
            session()->setFlashdata('message', 'Validated successfully!');
        } else {
            session()->setFlashdata('error', 'Validation failed! Please try again.');
        }

        return redirect()->to(base_url('stock/getstockdetails'));

    }
    public function getmismatchstock(){

        $StockModel = new StockModel();
        $data = [
            'mismatch_details' => $StockModel->getMismatchStockDetails(),
            'title' => 'Mismatch Stock',
            'subTitle' => 'Overview',
        ];

        return view('stock/mismatchStockViewDetails', $data);
    }
        
    
}