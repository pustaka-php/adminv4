<?php

namespace App\Controllers;

use App\Models\PodModel;

class Pod extends BaseController
{
    protected $podModel;

        public function __construct()
    {
        helper(['form', 'url', 'file', 'email', 'html', 'cookie', 'text']);
        $this->podModel = new PodModel();
    }

    public function publisherDashboard()
    {
        $data['publisher_data'] = $this->podModel->getPODPublishers();
        $data['title'] = 'POD Publisher List';

        return view('pod/publisherDashboard', $data);
    }

     public function publisherAdd()
    {
       
        $data['title'] = 'Add New Publisher';

        return view('pod/publisherAdd', $data);
        // echo "print";
    }

    public function PodpublisherSubmit()
    {
        $publisher_data = [
            "publisher_name"      => $this->request->getPost('publisher_name'),
            "address"             => $this->request->getPost('address'),
            "city"                => $this->request->getPost('publisher_city'),
            "contact_person"      => $this->request->getPost('publisher_contact'),
            "contact_mobile"      => $this->request->getPost('publisher_mobile'),
            "cover_reqs"          => $this->request->getPost('cover_reqs'),
            "content_reqs"        => $this->request->getPost('content_reqs'),
            "other_reqs"          => $this->request->getPost('other_reqs'),
            "preferred_transport" => $this->request->getPost('preferred_transport'),
            "rejection_remarks"   => $this->request->getPost('rejection_remarks'),
            "status"              => 1
        ];

        $result = $this->podModel->PodpublisherSubmit($publisher_data);

        return $this->response->setJSON($result);
    }

     public function PodDashboard()
    {
       
        $data['title'] = '';
        $data['dashboard'] = $this->podModel->getPODDashboardData();
        $data['pending_books']=$this->podModel->getPendingBooksData();

        // echo "<pre>";
        // print_r( $data);

        return view('pod/podDashboard', $data);
        
    }
 
    public function PodInvoice(){

        $data['title'] = '';
        $data['invoice'] = $this->podModel->getPODInvoiceData();
        $data['summary'] = $this->podModel->GetTotalSummary();
        $data['publisher']= $this->podModel->GetPublisherInvoiceReport();
        $data['month']=$this->podModel->GetMonthlyTotalInvoice();

        // echo "<pre>";
        // print_r( $data['month']);

        return view('pod/podInvoice', $data);
    }

    public function EndToEndPod()
    {
        $data['title'] = '';
        $data['pod'] = $this->podModel->getPodWork();

        return view('pod/EndToEndPoddashboard', $data);
    }
}