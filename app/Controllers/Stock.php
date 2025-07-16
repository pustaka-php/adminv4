<?php

namespace App\Controllers;
use App\Models\StockModel; 

use App\Controllers\BaseController;

class Stock extends BaseController
{
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
        'title'     => 'Stock Details',
        'subTitle'  => 'Overview',
       ];

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
            'title'     => 'Outside Stock Details',
            'subTitle'  => 'Overview',
        ];

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
        $result = $this->StockModel->submitDetails();
        echo $result;
    }

}