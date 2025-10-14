<?php

namespace App\Controllers;

use App\Models\PustakapaperbackModel;
use App\Models\PodModel;



class Paperback extends BaseController
{
    protected $PustakapaperbackModel;
    protected $PodModel;

    public function __construct()
    {
        $this->PustakapaperbackModel = new PustakapaperbackModel();
        $this->podModel = new PodModel();
    }

    public function OrdersDashboard(){

        $data['title'] = '';
        $data['subTitle'] = '';
        $data['dashboard'] = $this->podModel->getPODDashboardData();
        $data['pending_books']=$this->podModel->getPendingBooksData();
        $data['stock'] = $this->PustakapaperbackModel->getPaperbackStockDetails();	
		$data['pending'] = $this->PustakapaperbackModel->totalPendingBooks();	
		$data['orders'] = $this->PustakapaperbackModel->totalPendingOrders();
        $data['orders_dashboard'] = $this->PustakapaperbackModel->ordersDashboardData();
        
        // echo "<pre>";
        // print_r($data['orders_dashboard']);

        return view('printorders/orderDashboard',$data);
    }

    // online orders
    public function onlineorderbooksstatus()
    {
        $data['online_orderbooks'] = $this->PustakapaperbackModel->onlineProgressBooks();
        $data['online_summary'] = $this->PustakapaperbackModel->onlineSummary();
        $data['title'] = '';
        $data['subTitle'] = '';
        return view('printorders/online/orderbooksStatusview', $data);
    }

    public function onlinemarkshipped()
    {
        $result = $this->PustakapaperbackModel->onlineMarkShipped();
        return $result;
    }

    public function onlinemarkcancel()
    {
        $result = $this->PustakapaperbackModel->onlineMarkCancel();
        return $result;
    }

    public function onlinetrackingdetails()
    {
        $result = $this->PustakapaperbackModel->onlinetrackingdetails();
        return $result;
    }

    public function onlineordership($online_order_id, $book_id)
    {
        $data['orderbooks'] = $this->PustakapaperbackModel->onlineOrdership($online_order_id, $book_id);
        $data['details'] = $this->PustakapaperbackModel->onlineOrderdetails($online_order_id);
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('printorders/online/onlineOrderShip', $data);
    }

    public function onlineorderdetails($order_id)
    {
        $data['order_id'] =$order_id;
        $data['orderbooks'] = $this->PustakapaperbackModel->onlineOrderdetails($order_id);
        $data['title'] = '';
        $data['subTitle'] = '';
        return view('printorders/online/orderDetailsView', $data);
    }

    public function totalonlineordercompleted()
    {
        $data['online_orderbooks'] = $this->PustakapaperbackModel->onlineProgressBooks();
        $data['title'] = '';
        $data['subTitle'] = '';
        return view('printorders/online/onlineOrderCompleted', $data);
    }

    public function onlinebulkordersship($bulk_order_id)
    {
        $data['order_id']   = $bulk_order_id;
        $data['bulk_order'] = $this->PustakapaperbackModel->getOnlinebulkOrdersdetails($bulk_order_id);
        $data['title']      = '';
        $data['subTitle']   = '';
        return view('printorders/online/bulkOrdersShipView', $data);
    }
    public function bulkonlineordershipmentcompleted()
    {
        $order_id     = $this->request->getPost('order_id');
        $book_ids     = json_decode($this->request->getPost('book_ids'), true);
        $tracking_id  = $this->request->getPost('tracking_id');
        $tracking_url = $this->request->getPost('tracking_url');

        $result = $this->PustakapaperbackModel->onlineBulkOrdershipment($order_id, $book_ids, $tracking_id, $tracking_url);
        return $result;
    }
    function paperbackledgerbooksdetails()
    {
        $uri = service('uri');
        $data['book_id'] = $uri->getSegment(3);

        // $data['book_id'] = $book_id;
        $data['details'] = $this->PustakapaperbackModel->paperbackLedgerDetails();
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('printorders/paperbackledger/paperbackBooksDetails', $data);
    }

    //offline//
    public function offlineorderbooksdashboard()
    {
        $data['paperback_books'] = $this->PustakapaperbackModel->offlinePaperbackBooks();
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('printorders/offline/offlineOrderBooksDashboard', $data);
    }

    // Order List
    public function offlineorderbookslist()
    {
        if (!session()->has('user_id')) {
            return redirect()->to(base_url('adminv4'));
        }

        $selected_book_list = $this->request->getPost('selected_book_list');

        $data['offline_selected_book_id']   = $selected_book_list;
        $data['offline_selected_books_data'] = $this->PustakapaperbackModel->offlineSelectedBooksList($selected_book_list);
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('printorders/offline/offlineOrderbooksList', $data);
    }

    // Stock / Quantity View
    public function offlineorderstock()
    {
        if (!session()->has('user_id')) {
            return redirect()->to(base_url('adminv4'));
        }

        $num_of_books      = $this->request->getPost('num_of_books');
        $selected_book_list = $this->request->getPost('selected_book_list');

        $ship_date       = $this->request->getPost('ship_date');
        $courier_charges = $this->request->getPost('courier_charges');
        $payment_type    = $this->request->getPost('payment_type');
        $payment_status  = $this->request->getPost('payment_status');
        $customer_name   = $this->request->getPost('customer_name');
        $address         = $this->request->getPost('address');
        $mobile_no       = $this->request->getPost('mobile_no');
        $city            = $this->request->getPost('city');

        $book_ids  = [];
        $book_qtys = [];
        $book_dis  = [];
        $tot_amt   = [];

        for ($i = 1; $i <= $num_of_books; $i++) {
            $book_ids[]  = $this->request->getPost('book_id' . $i);
            $book_qtys[] = $this->request->getPost('bk_qty' . $i);
            $book_dis[]  = $this->request->getPost('bk_dis' . $i);
            $tot_amt[]   = $this->request->getPost('tot_amt' . $i);
        }

        $data['offline_selected_book_id'] = $selected_book_list;
        $data['offline_paperback_stock']  = $this->PustakapaperbackModel->offlineSelectedBooksList($selected_book_list);
        $data['book_qtys']   = $book_qtys;
        $data['book_dis']    = $book_dis;
        $data['tot_amt']     = $tot_amt;
        $data['ship_date']   = $ship_date;
        $data['courier_charges'] = $courier_charges;
        $data['payment_type']    = $payment_type;
        $data['payment_status']  = $payment_status;
        $data['customer_name']   = $customer_name;
        $data['address']         = $address;
        $data['mobile_no']       = $mobile_no;
        $data['city']            = $city;
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('printorders/offline/offlineorderQuantityView', $data);
    }

    // Submit Order
    public function offlineorderbookssubmit()
    {
        $result = $this->PustakapaperbackModel->offlineOrderbooksDetailsSubmit();

        $data['title'] = '';
        $data['subTitle'] = '';

        return view('printorders/offline/offlineOrderbooksSubmitView', $data);
    }

    // Orders In Progress
    public function offlineorderbooksstatus()
    {
        $data['offline_orderbooks'] = $this->PustakapaperbackModel->offlineProgressBooks();
        $data['offline_summary'] = $this->PustakapaperbackModel->offlineSummary();
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('printorders/offline/offlineOrderbooksStatusView', $data);
    }

    // Order Details
    public function offlineorderdetails($order_id)
    {
        $data['order_id']   = $order_id;
        $data['orderbooks'] = $this->PustakapaperbackModel->offlineOrderDetails($order_id);
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('printorders/offline/offlineOrderDetailsView', $data);
    }

    // Mark Shipped
    public function offlinemarkshipped()
    {
        $result=$this->PustakapaperbackModel->offlineMarkShipped();
        echo $result;
        exit;
    }

    // Mark Cancel
    public function offlinemarkcancel()
    {
        $result=$this->PustakapaperbackModel->offlineMarkCancel();
        echo $result;
        exit;
    }

    // Mark Paid
    public function offlinemarkpay()
    {
        $result = $this->PustakapaperbackModel->offlineMarkPay();
        echo $result;
        exit;
    }

    // Mark Return
    public function offlinemarkreturn()
    {
        $result = $this->PustakapaperbackModel->offlineMarkReturn();
        echo $result; 
        exit;  
    }

    // Tracking Details
    public function offlinetrackingdetails()
    {
        $result = $this->PustakapaperbackModel->offlineTrackingDetails();
        echo $result;
        exit;
    }

    // Ship Order
    public function offlineordership($offline_order_id = null, $book_id = null)
    {
        $data['orderbooks'] = $this->PustakapaperbackModel->offlineOrderShip($offline_order_id, $book_id);
        $data['details']    = $this->PustakapaperbackModel->offlineOrderDetails($offline_order_id);
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('printorders/offline/offlineOrderShip', $data);
    }


    // Completed Orders
    public function totalofflineordercompleted()
    {
        $data['offline_orderbooks'] = $this->PustakapaperbackModel->offlineProgressBooks();
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('printorders/offline/offlineTotalCompletedBooks', $data);
    }
    public function offlinebulkordersship($bulk_order_id)
    {    
        $data['order_id']   = $bulk_order_id;
        $data['bulk_order'] = $this->PustakapaperbackModel->getBulkOrdersDetails($bulk_order_id); 
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('printorders/offline/offlineBulkOrdersShipView', $data);
    }


	public function bulkordershipmentcompleted()
    {
        $order_id     = $this->request->getPost('order_id');
        $book_ids     = json_decode($this->request->getPost('book_ids'), true); 
        $tracking_id  = $this->request->getPost('tracking_id');
        $tracking_url = $this->request->getPost('tracking_url');

        $result = $this->PustakapaperbackModel->bulkOrderShipment($order_id, $book_ids, $tracking_id, $tracking_url);

        return $this->response->setJSON(['status' => $result]);
    }


   function initiateprintdashboard($book_id)
   {
        $data['book_id'] = $book_id;
		$data['initiate_print'] = $this->PustakapaperbackModel->getBooksStock($book_id);
        $data['title'] = '';
        $data['subTitle'] = '';
	
        return view('printorders/initiateprint/initiatePrintDashboard',$data);
        
	}
    function paperbackprintstatus()
	{
		$data['print'] = $this->PustakapaperbackModel->getInitiatePrintStatus();
        $data['title'] = '';
        $data['subTitle'] = '';

        // echo "<pre>";
		// print_r($data['amazon_summary']);

        return view('printorders/initiateprint/paperbackPrintStatusView',$data);
        
	}
    public function updatequantity() 
    {
        $book_id = $this->request->getPost('book_id');
        $quantity = $this->request->getPost('quantity');

        $result = $this->PustakapaperbackModel->updateQuantity($book_id, $quantity);
        echo $result;
    }
    public function initiateprintbooksdashboard()
    {
        $data['paperback_books'] = $this->PustakapaperbackModel->getPaperbackBooks();
        $data['title'] = '';
        $data['subTitle'] = '';
        return view('printorders/initiateprint/initiatePrintBooksDashboard', $data);
    }

    public function initiateprintbookslist()
    {

        $selected_book_list = $this->request->getPost('selected_book_list');

        log_message('debug', 'Selected Books list.... ' . $selected_book_list);

        $data['selected_book_id'] = $selected_book_list;
        $data['selected_books_data'] = $this->PustakapaperbackModel->getPaperbackSelectedBooksList($selected_book_list);
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('printorders/initiateprint/initiatePrintBooksList', $data);
    }

    public function uploadquantitylist()
    {
        $result = $this->PustakapaperbackModel->uploadQuantityList();
        return $this->response->setJSON(['status' => $result]);
    }
     public function editinitiateprint()
    {
        $data['initiate_print'] = $this->PustakapaperbackModel->editInitiatePrint();
        $data['title'] = '';
        $data['subTitle'] = '';
        return view('printorders/initiateprint/editInitiatePrintView', $data);
    }

    public function editquantity()
    {
        $result = $this->PustakapaperbackModel->editQuantity();

        return $this->response->setJSON([
            'status' => $result
        ]);
    }

    public function deleteinitiateprint()
    {
        $id = $this->request->getPost('id');
        $result = $this->PustakapaperbackModel->deleteInitiatePrint($id);
        return $this->response->setJSON([
            'status' => $result
        ]);
    }

    public function totalinitiateprintcompleted()
    {
        $data['print'] = $this->PustakapaperbackModel->getInitiatePrintStatus();
        $data['title'] = '';
        $data['subTitle'] = '';
        return view('printorders/initiateprint/totalCompletedBooks', $data);
    }
    function markstart()
	{
		
        $id = $this->request->getPost('id');
        $type = $this->request->getPost('type');
        $result = $this->PustakapaperbackModel->markStart($id, $type);
        return $this->response->setJSON(['status' => $result]);
	}

	function markcovercomplete()
	{
        $id = $this->request->getPost('id');
        $type = $this->request->getPost('type');
        $result = $this->PustakapaperbackModel->markCoverComplete($id, $type);
        return $this->response->setJSON(['status' => $result]);
	}

	function markcontentcomplete()
	{
        $id = $this->request->getPost('id');
        $type = $this->request->getPost('type');
        $result = $this->PustakapaperbackModel->markContentComplete($id, $type);
        return $this->response->setJSON(['status' => $result]);
	}

	function marklaminationcomplete()
	{
        $id = $this->request->getPost('id');
        $type = $this->request->getPost('type');
        $result = $this->PustakapaperbackModel->markLaminationComplete($id, $type);
        return $this->response->setJSON(['status' => $result]);
	}

	function markbindingcomplete()
	{
        $id = $this->request->getPost('id');
        $type = $this->request->getPost('type');
        $result = $this->PustakapaperbackModel->markBindingComplete($id, $type);
        return $this->response->setJSON(['status' => $result]);

	}

	function markfinalcutcomplete()
	{
        $id = $this->request->getPost('id');
        $type = $this->request->getPost('type');
        $result = $this->PustakapaperbackModel->markFinalcutComplete($id, $type);
        return $this->response->setJSON(['status' => $result]);

	}

	function markqccomplete()
	{
        $id = $this->request->getPost('id');
        $type = $this->request->getPost('type');
        $result = $this->PustakapaperbackModel->markQcComplete($id, $type);
        return $this->response->setJSON(['status' => $result]);

	}

	function markcompleted()
	{
        $id = $this->request->getPost('id');
        $type = $this->request->getPost('type');
        $result = $this->PustakapaperbackModel->markCompleted($id, $type);
        return $this->response->setJSON(['status' => $result]);

	}
    //amazon order//
    public function paperbackamazonorder()
    {

        $data['amazon_order'] = $this->PustakapaperbackModel->getAmazonPaperbackOrder();
        $data['title'] = '';
        $data['subTitle'] = '';
        return view('printorders/amazon/paperbackOrderView', $data);
    }

    public function pustakaamazonorderbookslist()
    {

        $selected_book_list = $this->request->getPost('selected_book_list');

        log_message('debug', 'Selected Books list.... ' . $selected_book_list);
        $data['amazon_selected_book_id'] = $selected_book_list;
        $data['amazon_selected_books_data'] = $this->PustakapaperbackModel->getAmazonSelectedBooksList($selected_book_list);
        $data['title'] = '';
        $data['subTitle'] = '';


        return view('printorders/amazon/orderbooksList', $data);
    }

    public function pustakaamazonorderstock()
    {

        $num_of_books = $this->request->getPost('num_of_books');
        $selected_book_list = $this->request->getPost('selected_book_list');
        $ship_type = $this->request->getPost('shipping_type');
        $ship_date = $this->request->getPost('ship_date');
        $order_id = $this->request->getPost('order_id');

        $book_ids = [];
        $book_qtys = [];
        $j = 1;

        for ($i = 0; $i < $num_of_books; $i++) {
            $tmp = 'book_id' . $j;
            $tmp1 = 'bk_qty' . $j++;
            $book_ids[$i] = $this->request->getPost($tmp);
            $book_qtys[$i] = $this->request->getPost($tmp1);
        }

        $data['amazon_selected_book_id'] = $selected_book_list;
        $data['amazon_paperback_stock'] = $this->PustakapaperbackModel->getAmazonStockDetails($selected_book_list);
        $data['book_qtys'] = $book_qtys;
        $data['ship_type'] = $ship_type;
        $data['ship_date'] = $ship_date;
        $data['order_id'] = $order_id;
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('printorders/amazon/orderQuantityView', $data);
    }

    public function amazonorderbookssubmit()
    {
        $num_of_books = $this->request->getPost('num_of_books');
        $selected_book_list = $this->request->getPost('selected_book_list');

        $this->PustakapaperbackModel->amazonOrderbooksDetailsSubmit($num_of_books);
        $data['title'] = '';
        $data['subTitle'] = '';


        return view('printorders/amazon/orderbooksSubmitView', $data);
    }

    public function amazonorderbooksstatus()
    {
        $data['amazon_orderbooks'] = $this->PustakapaperbackModel->amazonInProgressBooks();
        $data['amazon_summary'] = $this->PustakapaperbackModel->amazonSummary();
        $data['title'] = '';
        $data['subTitle'] = '';

        // echo "<pre>";
		// print_r($data['amazon_summary']);

        return view('printorders/amazon/orderbooksStatusView', $data);
    }

    public function markshipped()
    {
        $result = $this->PustakapaperbackModel->markShipped();     
        echo $result;
    }

    public function markcancel()
    {
        $result = $this->PustakapaperbackModel->markCancel();
        echo $result;
    }

    public function markreturn()
    {
        $result = $this->PustakapaperbackModel->markReturn();
        echo $result;
    }

    public function amazonorderdetails($order_id)
    {
        $data['order_id'] = $order_id;
        $data['orderbooks'] = $this->PustakapaperbackModel->amazonOrderDetails($order_id);
        $data['title'] = '';
        $data['subTitle'] = '';
        return view('printorders/amazon/orderDetailsView', $data);
    }


    public function totalamazonordercompleted()
    {
        $data['amazon_orderbooks'] = $this->PustakapaperbackModel->amazonInProgressBooks();
        $data['title'] = '';
        $data['subTitle'] = '';
        return view('printorders/amazon/totalCompletedBooks', $data);
    }
    //author order//
    public function authororderbooks($author_id = null)
    {
        if (!$author_id) {
            $author_id = $this->request->uri->getSegment(3);
        }
        $data['pustaka_url'] = config('App')->pustaka_url;
        $data['pod_author_books_data'] = $this->PustakapaperbackModel->getAuthorBooksList($author_id);
        $data['author_id'] = $author_id;
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('printorders/author/orderBooksListView', $data);
    }
    public function authororderqtylist()
    {
        $selected_bk_list = $this->request->getPost('selected_bk_list');
        $author_id = $this->request->getPost('author_id');

        log_message('debug', 'Author Order: Selected Books list.... ' . $selected_bk_list);

        $data['pustaka_url'] = config('App')->pustaka_url;
        $data['author_id'] = $author_id;
        $data['title'] = '';
        $data['subTitle'] = '';
        $data['pod_selected_book_id'] = $selected_bk_list;
        $data['pod_selected_books_data'] = $this->PustakapaperbackModel->getSelectedBooksList($selected_bk_list);
        $data['pod_author_addr_details'] =$this->PustakapaperbackModel->getAuthorAddress($author_id);

        return view('printorders/author/orderSelectedBookList', $data);
    }
    public function authororderbookssubmit()
    { 
        $result = $this->PustakapaperbackModel->authorOrderBooksDetailsSubmit();
        $data['title'] = '';
        $data['subTitle'] = '';
        return view('printorders/author/orderbooksSubmitView', $data);
    }

    function authorlistdetails(){

		$data['orderbooks'] = $this->PustakapaperbackModel->getAuthorList();
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('printorders/author/authorListView',$data);
	}

    public function authororderbooksstatus()
    {
        $data['author_order'] = $this->PustakapaperbackModel->getAuthorOrderDetails();
        $data['orders'] = $this->PustakapaperbackModel->authorInProgressOrder();
        $data['summary'] = $this->PustakapaperbackModel->authorSummary();
        $data['title'] = '';
        $data['subTitle'] = '';

        // echo "<pre>";
		// print_r($data['summary']);

        return view('printorders/author/orderbooksStatusView', $data);
    }

    public function authorordermarkstart()
    {
        $orderId = $this->request->getPost('order_id');
        $bookId  = $this->request->getPost('book_id');
        $result = $this->PustakapaperbackModel->authorOrderMarkStart($orderId, $bookId);
        return $this->response->setJSON(['status' => $result]);
    }

    public function markfilesreadycompleted()
    {
        $orderId = $this->request->getPost('order_id');
        $bookId  = $this->request->getPost('book_id');
        $result = $this->PustakapaperbackModel->markFilesReadyCompleted($orderId, $bookId);
        return $this->response->setJSON(['status' => $result]);
    }

    public function markcovercompleted()
    {
        $orderId = $this->request->getPost('order_id');
        $bookId  = $this->request->getPost('book_id');
        $result = $this->PustakapaperbackModel->markCoverCompleted($orderId, $bookId);
        return $this->response->setJSON(['status' => $result]);
    }


    public function markcontentcompleted()
    {
        $orderId = $this->request->getPost('order_id');
        $bookId  = $this->request->getPost('book_id');
        $result = $this->PustakapaperbackModel->markContentCompleted($orderId, $bookId);
        return $this->response->setJSON(['status' => $result]);
    }

    public function marklaminationcompleted()
    {
        $orderId = $this->request->getPost('order_id');
        $bookId  = $this->request->getPost('book_id');
        $result = $this->PustakapaperbackModel->markLaminationCompleted($orderId, $bookId);
        return $this->response->setJSON(['status' => $result]);
    }

    public function markbindingcompleted()
    {
        $orderId = $this->request->getPost('order_id');
        $bookId  = $this->request->getPost('book_id');
        $result = $this->PustakapaperbackModel->markBindingCompleted($orderId, $bookId);
        return $this->response->setJSON(['status' => $result]);
    }

    public function markfinalcutcompleted()
    {
        $orderId = $this->request->getPost('order_id');
        $bookId  = $this->request->getPost('book_id');
        $result = $this->PustakapaperbackModel->markFinalCutCompleted($orderId, $bookId);
        return $this->response->setJSON(['status' => $result]);
    }

    public function markqccompleted()
    {
        $orderId = $this->request->getPost('order_id');
        $bookId  = $this->request->getPost('book_id');
        $result = $this->PustakapaperbackModel->markQcCompleted($orderId, $bookId);
        return $this->response->setJSON(['status' => $result]);
    }

    public function authorordermarkcompleted()
    {
        $orderId = $this->request->getPost('order_id');
        $bookId  = $this->request->getPost('book_id');
        $result = $this->PustakapaperbackModel->authorOrderMarkCompleted($orderId, $bookId);
        return $this->response->setJSON(['status' => $result]);
    }

    public function createauthorinvoice()
    {
        $data['author'] = $this->PustakapaperbackModel->authorInvoiceDetails();
        $data['title'] = '';
        $data['subTitle'] = '';
        return view('printorders/author/authorInvoiceView', $data);
    }

    public function createinvoice()
    {
        $result= $this->PustakapaperbackModel->createInvoice();
        return $this->response->setJSON(['status' => $result]);
    }

    public function authormarkcancel()
    {
        $orderId = $this->request->getPost('order_id');
        $result = $this->PustakapaperbackModel->authorMarkCancel($orderId);
        return $this->response->setJSON(['status' => $result]);
    }

    public function authorordership()
    {
        $data['orderbooks'] = $this->PustakapaperbackModel->authorOrderShip();
        $data['details'] = $this->PustakapaperbackModel->authorOrderDetails();
        $data['order_id'] = $this->request->getPost('order_id'); 
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('printorders/author/authorOrderShip', $data);
    }

    public function authormarkshipped()
    {
        $result = $this->PustakapaperbackModel->authorMarkShipped();
        return $this->response->setJSON(['status' => $result]);
    }

    public function authororderdetails()
    {
        $data['orderbooks'] = $this->PustakapaperbackModel->authorOrderDetails();
        $data['title'] = '';
        $data['subTitle'] = '';
        return view('printorders/author/authorOrderDetails', $data);
    }

    public function authormarkpay()
    {
        $orderId = $this->request->getPost('order_id');
        $result = $this->PustakapaperbackModel->authorMarkPay($orderId);
        return $this->response->setJSON(['status' => $result]);
    }

    public function totalauthorordercompleted()
    {
        $data['orders'] = $this->PustakapaperbackModel->authorInProgressOrder();
        $data['title'] = '';
        $data['subTitle'] = '';
        return view('printorders/author/totalCompletedOrders', $data);
    }
    //bookshop orders//
    public function bookshopordersdashboard()
    {
        $data['bookshop'] = $this->PustakapaperbackModel->getBookshopOrdersDetails();
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('printorders/bookshop/paperbackOrderView', $data);
    }

    public function bookshoporderbooks()
    {
        $selected_book_list = $this->request->getPost('book_ids');
        $data['selected_books_data'] = $this->PustakapaperbackModel->offlineSelectedBooksList($selected_book_list);
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('printorders/bookshop/orderBooksList', $data);
    }

    public function submitbookshoporders()
    {
        $postData = $this->request->getPost();
        $result = $this->PustakapaperbackModel->submitBookshopOrders($postData);
        return $this->response->setJSON($result);
        
    }
    
    public function bookshoporderbooksstatus()
    {
        $data['bookshop_status'] = $this->PustakapaperbackModel->bookshopProgressBooks();
        $data['bookshop_summary'] = $this->PustakapaperbackModel->bookshopSummary();
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('printorders/bookshop/orderbooksStatusView', $data);
    }

    public function bookshopordership($order_id)
    {

        $data['order_id'] = $order_id;
        $data['ship'] = $this->PustakapaperbackModel->bookshopOrderShip($order_id);
        $data['orderbooks'] = $this->PustakapaperbackModel->bookshopOrderDetails($order_id);
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('printorders/bookshop/bookshopOrderShip', $data);
    }

    public function bookshopmarkshipped()
    {
        $order_id= $this->request->getPost('order_id');
        $tracking_id= $this->request->getPost('tracking_id');
        $tracking_url= $this->request->getPost('tracking_url');
        $result = $this->PustakapaperbackModel->bookshopMarkShipped($order_id, $tracking_id, $tracking_url);
        return $this->response->setJSON(['status' => $result]);
    }

    public function bookshopmarkcancel()
    {
        $order_id= $this->request->getPost('order_id');
        $book_id= $this->request->getPost('book_id');
        $result = $this->PustakapaperbackModel->bookshopMarkCancel($order_id, $book_id);
        return $this->response->setJSON(['status' => $result]);
    }

    public function bookshopmarkpay()
    {
        $order_id= $this->request->getPost('order_id');
        $result = $this->PustakapaperbackModel->bookshopMarkPay($order_id);
        return $this->response->setJSON(['status' => $result]);
    }

    public function bookshoporderdetails($order_id)
    {
        $data['order_id'] = $order_id;
        $data['orderbooks'] = $this->PustakapaperbackModel->bookshopOrderDetails($order_id);
        $data['title'] = '';
        $data['subTitle'] = '';

        return  view('printorders/bookshop/orderDetailView', $data);
    }

    public function totalbookshopordercompleted()
    {
        $data['orderbooks'] = $this->PustakapaperbackModel->bookshopProgressBooks();
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('printorders/bookshop/totalCompletedBooks', $data);
    }

    public function createbookshoporder($order_id)
    {
        $data['order_id'] = $order_id;
        $data['bookshop'] = $this->PustakapaperbackModel->bookshopInvoiceDetails($order_id);
        $data['title'] = '';
        $data['subTitle'] = '';

        return  view('printorders/bookshop/bookshopInvoiceView', $data);
    }

    public function createbookshopinvoice()
    {
        $post = $this->request->getPost();
        $result = $this->PustakapaperbackModel->createBookshopInvoice($post);
        return $this->response->setJSON($result);
    }

    public function bookshopdetails()
    {
        
        $data['title'] = '';
        $data['subTitle'] = '';
        return view('printorders/bookshop/addBookshopDetails', $data);

    }
    public function addbookshop()
    {
        $post = $this->request->getPost();   
        $result = $this->PustakapaperbackModel->addBookshop($post);

        if ($result == 1) {
            return $this->response->setJSON([
                'status' => 1,
                'message' => 'Bookshop added successfully'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'message' => 'Failed to add bookshop'
            ]);
        }
    }
    //flipkart orders//
    public function paperbackflipkartorder()
    {
        $data['flipkart_order'] = $this->PustakapaperbackModel->getFlipkartPaperbackOrder();
        $data['title'] = '';
        $data['subTitle'] = '';
        return view('printorders/flipkart/paperbackOrderView', $data);
    }

    public function pustakaflipkartorderbookslist()
    {

        $selected_book_list = $this->request->getPost('selected_book_list');
        log_message('debug', 'Selected Books list.... ' . $selected_book_list);

        $data['flipkart_selected_book_id'] = $selected_book_list;
        $data['flipkart_selected_books_data'] = $this->PustakapaperbackModel->getFlipkartSelectedBooksList($selected_book_list);
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('printorders/flipkart/orderbooksList', $data);
    }

    public function pustakaflipkartorderstock()
    {

        $num_of_books       = $this->request->getPost('num_of_books');
        $selected_book_list = $this->request->getPost('selected_book_list');
        $ship_date          = $this->request->getPost('ship_date');
        $order_id           = $this->request->getPost('order_id');

        $j = 1;
        $book_ids  = [];
        $book_qtys = [];

        for ($i = 0; $i < $num_of_books; $i++) {
            $tmp  = 'book_id' . $j;
            $tmp1 = 'bk_qty' . $j++;
            $book_ids[$i]  = $this->request->getPost($tmp);
            $book_qtys[$i] = $this->request->getPost($tmp1);
        }

        $data['flipkart_selected_book_id'] = $selected_book_list;
        $data['flipkart_paperback_stock']  = $this->PustakapaperbackModel->getFlipkartStockDetails($selected_book_list);
        $data['book_qtys'] = $book_qtys;
        $data['ship_date'] = $ship_date;
        $data['order_id']  = $order_id;
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('printorders/flipkart/orderQuantityView', $data);
    }

    public function flipkartorderbookssubmit()
    {
        $num_of_books       = $this->request->getPost('num_of_books');
        $selected_book_list = $this->request->getPost('selected_book_list');
        $data['title'] = '';
        $data['subTitle'] = '';
        $result = $this->PustakapaperbackModel->flipkartOrderbooksDetailsSubmit($num_of_books);

        return view('printorders/flipkart/orderbooksSubmitView', $data);
    }

    public function flipkartorderbooksstatus()
    {
        $data['flipkart_orderbooks'] = $this->PustakapaperbackModel->flipkartInprogressBooks();
        $data['flipkart_summary'] =$this->PustakapaperbackModel->flipkartSummary();
        $data['title'] = '';
        $data['subTitle'] = '';
        return view('printorders/flipkart/orderbooksStatusView', $data);
    }

    public function flipkartmarkshipped()
    {
        $flipkart_order_id = $_POST['flipkart_order_id'];
        $book_id = $_POST['book_id'];
        $result = $this->PustakapaperbackModel->flipkartMarkShipped($flipkart_order_id, $book_id);
        return $this->response->setJSON(['status' => $result]);
    }

    public function flipkartmarkcancel()
    {
        $flipkart_order_id = $_POST['flipkart_order_id'];
        $book_id = $_POST['book_id'];
        $result = $this->PustakapaperbackModel->flipkartMarkCancel($flipkart_order_id, $book_id);
        return $this->response->setJSON(['status' => $result]);
    }

    public function flipkartmarkreturn()
    {
        $flipkart_order_id = $_POST['flipkart_order_id'];
        $book_id = $_POST['book_id'];
        $result = $this->PustakapaperbackModel->flipkartMarkReturn($flipkart_order_id, $book_id);
        return $this->response->setJSON(['status' => $result]);
    }

    public function totalflipkartordercompleted()
    {
        $data['flipkart_orderbooks'] = $this->PustakapaperbackModel->flipkartInprogressBooks();
        $data['title'] = '';
        $data['subTitle'] = '';
        return view('printorders/flipkart/totalCompletedBooks', $data);
    }

    public function flipkartorderdetails($order_id)
    {
        $data['order_id'] = $order_id;
        $data['orderbooks'] = $this->PustakapaperbackModel->flipkartOrderDetails($order_id);
        $data['title'] = '';
        $data['subTitle'] = '';
        return view('printorders/flipkart/orderDetailsView', $data);
    }

    
}
