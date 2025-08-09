<?php

namespace App\Controllers;

use App\Models\PustakapaperbackModel;

class Paperback extends BaseController
{
    protected $PustakapaperbackModel;

    public function __construct()
    {
        $this->PustakapaperbackModel = new PustakapaperbackModel();
    }

    // online orders
    public function onlineorderbooksstatus()
    {
        $data['online_orderbooks'] = $this->PustakapaperbackModel->onlineProgressBooks();
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

}
