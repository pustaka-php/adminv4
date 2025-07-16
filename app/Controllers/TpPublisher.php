<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TpPublisherModel; 


class TpPublisher extends BaseController
{

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->TpPublisherModel = new TpPublisherModel();
        helper('url');
        $this->session = session();
    }

    
   public function tppublisherDashboard()
{
    $data = [
        'title' => 'TpPublisher',
        'subTitle' => 'Dashboard',
        'publisher_data' => $this->TpPublisherModel->countData(),
        'orders' => $this->TpPublisherModel->getPublisherOrders(),
        'payments' => $this->TpPublisherModel->tpPublisherOrderPayment(), 
    ];

    return view('tppublisher/tppublisherdashboard', $data);
}
    public function tpPublisherDetails()
{
    $model = new TpPublisherModel();
    $publishers = $model->tpPublisherDetails(); 

    $data = [
        'title' => 'TpPublisher',
        'subTitle' => 'Publisher Details',
        'publishers' => $publishers 
    ];

    return view('tppublisher/tppublisherdetails', $data); 
}
public function setpublisherstatus()
{
    $publisherId = $this->request->getPost('publisher_id');
    $status = $this->request->getPost('status');

    $model = new \App\Models\TpPublisherModel();

    if ($status == 1) {
        $result = $model->activePublishers($publisherId);
    } else {
        $result = $model->inactivePublishers($publisherId);
    }

    return $this->response->setJSON([
        'success' => $result == 1
    ]);
}
    public function tpPublisherView()
        {
            return view('tppublisher/tpPublisherAdd', [
        'title' => 'Publishers',
        'subTitle' => 'Add Publisher'
    ]);
        }

    public function tpPublisherAdd()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request']);
        }

        $rules = [
            'publisher_name' => 'required|min_length[3]',
            'contact_person' => 'required',
            'email_id'       => 'required|valid_email',
            'mobile'         => 'required|numeric|min_length[10]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'error'    => true,
                'messages' => $this->validator->getErrors()
            ]);
        }

        $model = new TpPublisherModel();
        $insertedId = $model->tpPublisherAdd();

        if ($insertedId) {
            return $this->response->setJSON([
                'success'    => true,
                'message'    => 'Publisher added successfully!',
                'insert_id'  => $insertedId
            ]);
        }

        return $this->response->setJSON([
            'error'   => true,
            'message' => 'Insert failed!'
        ]);
    }
    // Controller: TpPublisher.php

    public function tpAuthorDetails()
    {
        $authors_data = $this->TpPublisherModel->tpAuthorDetails();

        $data = [
            'title'           => 'TpAuthor',
            'subTitle'        => 'Dashboard',
            'active_authors'   => $authors_data['active'] ?? [],
            'inactive_authors' => $authors_data['inactive'] ?? [],
        ];

        // 👇 Make sure this matches the actual file name
        return view('tppublisher/tpauthordetails', $data);
    }
    public function tpAuthorAddDetails()
{
    $model = new TpPublisherModel();
    $data = [
        'title'             => 'Add Author',
        'subTitle'          => 'New Author Add',
        'publisher_details' => $model->getTpAuthor()
    ];

    return view('tppublisher/tpauthoradd', $data);
}
    public function tpAuthoradd()
    {
        if (!session()->get('user_id')) {
            return $this->response->setJSON(['status' => 'unauthorized']);
        }

        $postData = $this->request->getPost();

        if (empty($postData['publisher_id']) || empty($postData['author_name'])) {
            return $this->response->setJSON([
                'status'  => 'validation_error',
                'message' => 'Publisher ID and Author Name are required.'
            ]);
        }

        $model  = new TpPublisherModel();
        $result = $model->tpAuthorsAdd($postData);

        return $this->response->setJSON([
            'status'  => $result ? 'success' : 'error',
            'message' => $result ? 'Author added.' : 'Insert failed.'
        ]);
    }


 
}