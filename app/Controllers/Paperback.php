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
        return $this->PustakapaperbackModel->offlineMarkShipped();
    }

    // Mark Cancel
    public function offlinemarkcancel()
    {
        return $this->PustakapaperbackModel->offlineMarkCancel();
    }

    // Mark Paid
    public function offlinemarkpay()
    {
        return $this->PustakapaperbackModel->offlineMarkPay();
    }

    // Mark Return
    public function offlinemarkreturn()
    {
        return $this->PustakapaperbackModel->offlineMarkReturn();
    }

    // Tracking Details
    public function offlinetrackingdetails()
    {
        return $this->PustakapaperbackModel->offlineTrackingDetails();
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


	public function bulkordershipmentcompleted() {
		
		$order_id = $this->input->post('order_id');
		$book_ids = json_decode($this->input->post('book_ids'), true); 
		$tracking_id = $this->input->post('tracking_id');
		$tracking_url = $this->input->post('tracking_url');

		// log_message('debug', 'Order ID: ' . $order_id);
		// log_message('debug', 'Book IDs: ' . print_r($book_ids, true));
		// log_message('debug', 'Tracking ID: ' . $tracking_id);
		// log_message('debug', 'Tracking URL: ' . $tracking_url);

		$result = $this->PustakapaperbackModel->bulkOrderShipment($order_id, $book_ids, $tracking_id, $tracking_url);
		echo $result;
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

        return view('printorders/initiateprint/paperbackPrintStatusView',$data);
        
	}
    function updatequantity() 
    {
		
        $result = $this->PustakapaperbackModel->updateQuantity();
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
        if (!session()->has('user_id')) {
            return redirect()->to('../adminv4/');
        }

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
        return $this->response->setJSON($result);
    }
     public function editinitiateprint()
    {
        $data['initiate_print'] = $this->PustakapaperbackModel->editInitiatePrint();
        return view('printorders/initiateprint/editInitiatePrintView', $data);
    }

    public function editquantity()
    {
        $result = $this->PustakapaperbackModel->editQuantity();
        return $this->response->setJSON($result);
    }

    public function deleteinitiateprint()
    {
        $result = $this->PustakapaperbackModel->deleteInitiatePrint();
        return $this->response->setJSON($result);
    }

    public function totalinitiateprintcompleted()
    {
        $data['print'] = $this->PustakapaperbackModel->getInitiatePrintStatus();
        return view('printorders/initiateprint/totalCompletedBooks', $data);
    }
    function markstart()
	{
		//print_r($_POST);
        $result = $this->PustakapaperbackModel->markStart();
        echo $result;
	}

	function markcovercomplete()
	{
        $result = $this->PustakapaperbackModel->markCoverComplete();
        echo $result;
	}

	function markcontentcomplete()
	{
        $result = $this->PustakapaperbackModel->markContentComplete();
        echo $result;
	}

	function marklaminationcomplete()
	{
        $result = $this->PustakapaperbackModel->markLaminationComplete();
        echo $result;
	}

	function markbindingcomplete()
	{
        $result = $this->PustakapaperbackModel->markBindingComplete();
        echo $result;
	}

	function markfinalcutcomplete()
	{
        $result = $this->PustakapaperbackModel->markFinalcutComplete();
        echo $result;
	}

	function markqccomplete()
	{
        $result = $this->PustakapaperbackModel->markQcComplete();
        echo $result;
	}

	function markcompleted()
	{
        $result = $this->PustakapaperbackModel->markCompleted();
        echo $result;
	}
    //amazon order//
    public function paperbackamazonorder()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('../adminv4/');
        }

        $data['amazon_order'] = $this->PustakapaperbackModel->getAmazonPaperbackOrder();
        $data['title'] = '';
        $data['subTitle'] = '';
        return view('printorders/amazon/paperbackOrderView', $data);
    }

    public function pustakaamazonorderbookslist()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('../adminv3/');
        }

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
        if (!session()->has('user_id')) {
            return redirect()->to('../adminv4/');
        }

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
        return $this->response->setBody($result);
    }

    public function markcancel()
    {
        $result = $this->PustakapaperbackModel->markCancel();
        return $this->response->setBody($result);
    }

    public function markreturn()
    {
        $result = $this->PustakapaperbackModel->markReturn();
        return $this->response->setBody($result);
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

    //author orders//
    public function authororderbooks() {
		
		// initiate the POD Whatsapp Order process now by displaying books list
		// $author_id = $this->uri->segment(3);
		$data['pod_author_books_data'] = $this->PustakapaperbackModel->getAuthorBooksList($author_id);
		$data['author_id'] = $author_id;
        $data['title'] = '';
        $data['subTitle'] = '';
		// echo "<pre>";
		// print_r($data['pod_books_data']);
		return view('printorders/author/orderBooksListView', $data);
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
        return $this->response->setJSON($this->PustakapaperbackModel->authorOrderMarkStart());
    }

    public function markfilesreadycompleted()
    {
        return $this->response->setJSON($this->PustakapaperbackModel->markFilesReadyCompleted());
    }

    public function markcovercompleted()
    {
        return $this->response->setJSON($this->PustakapaperbackModel->markCoverCompleted());
    }

    public function markcontentcompleted()
    {
        return $this->response->setJSON($this->PustakapaperbackModel->markContentCompleted());
    }

    public function marklaminationcompleted()
    {
        return $this->response->setJSON($this->PustakapaperbackModel->markLaminationCompleted());
    }

    public function markbindingcompleted()
    {
        return $this->response->setJSON($this->PustakapaperbackModel->markBindingCompleted());
    }

    public function markfinalcutcompleted()
    {
        return $this->response->setJSON($this->PustakapaperbackModel->markFinalCutCompleted());
    }

    public function markqccompleted()
    {
        return $this->response->setJSON($this->PustakapaperbackModel->markQcCompleted());
    }

    public function authorordermarkcompleted()
    {
        return $this->response->setJSON($this->PustakapaperbackModel->authorOrderMarkCompleted());
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
        return $this->response->setJSON($this->PustakapaperbackModel->createInvoice());
    }

    public function authormarkcancel()
    {
        return $this->response->setJSON($this->PustakapaperbackModel->authorMarkCancel());
    }

    public function authorordership()
    {
        $data['orderbooks'] = $this->PustakapaperbackModel->authorOrderShip();
        $data['details'] = $this->PustakapaperbackModel->authorOrderDetails();
        $data['order_id'] = $this->request->getPost('order_id'); //['order_id']
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('printorders/author/authorOrderShip', $data);
    }

    public function authormarkshipped()
    {
        return $this->response->setJSON($this->PustakapaperbackModel->authorMarkShipped());
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
        return $this->response->setJSON($this->PustakapaperbackModel->authorMarkPay());
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
        $result = $this->PustakapaperbackModel->submitBookshopOrders();
        return $this->response->setJSON($result);
    }
    
    public function bookshoporderbooksstatus()
    {
        $data['bookshop_status'] = $this->PustakapaperbackModel->bookshopProgressBooks();
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
        $result = $this->PustakapaperbackModel->bookshopMarkShipped();
        return $this->response->setJSON($result);
    }

    public function bookshopmarkcancel()
    {
        $result = $this->PustakapaperbackModel->bookshopMarkCancel();
        return $this->response->setJSON($result);
    }

    public function bookshopmarkpay()
    {
        $result = $this->PustakapaperbackModel->bookshopMarkPay();
        return $this->response->setJSON($result);
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

}
