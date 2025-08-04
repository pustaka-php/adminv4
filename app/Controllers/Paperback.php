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
        return view('printorders/orderbooksStatusview', $data);
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

        return view('printorders/onlineOrderShip', $data);
    }

    public function onlineorderdetails()
    {
        $data['orderbooks'] = $this->PustakapaperbackModel->onlineOrderdetails();
        $data['title'] = '';
        $data['subTitle'] = '';
        return view('printorders/orderDetailsView', $data);
    }

    public function totalonlineordercompleted()
    {
        $data['online_orderbooks'] = $this->PustakapaperbackModel->onlineProgressBooks();
        $data['title'] = '';
        $data['subTitle'] = '';
        return view('printorders/onlineOrderCompleted', $data);
    }

    public function onlinebulkordersship($bulk_order_id)
    {
        $data['order_id']   = $bulk_order_id;
        $data['bulk_order'] = $this->PustakapaperbackModel->getOnlinebulkOrdersdetails($bulk_order_id);
        $data['title']      = '';
        $data['subTitle']   = '';
        return view('printorders/bulkOrdersShipView', $data);
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
    function paperbackledgerbooksdetails(){
		
		$data['details'] = $this->PustakapaperbackModel->paperbackLedgerDetails();
		
		return view('printorders/paperbackBooksDetails',$data);
        
	}
}
