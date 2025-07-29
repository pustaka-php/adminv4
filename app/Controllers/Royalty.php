<?php

namespace App\Controllers;

use App\Models\RoyaltyModel;
use CodeIgniter\Controller;

class Royalty extends Controller
{
    protected $royaltyModel;
    protected $helpers = ['form', 'url', 'file', 'email', 'html', 'cookie', 'string'];

    public function __construct()
    {
        helper($this->helpers);

        $this->royaltyModel = new RoyaltyModel();
        session();
    }

    public function royaltyconsolidation()
    {
        $data['title'] = 'Royalty Consolidation';
        $data['subTitle'] = 'Outstanding Royalty Summary';
        $data['royalty'] = $this->royaltyModel->getRoyaltyConsolidatedData();

        return view('royalty/royaltyconsolidationView', $data);
    }

    public function paynow()
    {
        $copyright_owner = $this->request->getPost('copyright_owner');

        if ($copyright_owner) {
            $builder = $this->royaltyModel->db->table('royalty_consolidation');
            $builder->where('copyright_owner', $copyright_owner);
            $builder->where('pay_status', 'O');
            $builder->update(['pay_status' => 'P']);
            
            session()->setFlashdata('message', 'Payment updated successfully.');
        } else {
            session()->setFlashdata('error', 'Invalid Request.');
        }

        return redirect()->to(base_url('royalty/royaltyconsolidation'));
    }
    public function getroyaltybreakup($copyright_owner)
    {
        $data['title'] = 'Royalty breakup';
        $data['subTitle'] = 'Breakup Royalty Summary';
        $data['ebook_details'] = $this->royaltyModel->getebookbreakupDetails($copyright_owner);
        $data['audiobook_details'] = $this->royaltyModel->getaudiobreakupDetails($copyright_owner);
        $data['paperback_details'] = $this->royaltyModel->getpaperbackDetails($copyright_owner);
        $data['author_id'] = $copyright_owner;


        return view('royalty/royaltybreakupview', $data);
        
    }
    public function transactiondetails()
    {
        $data = [];
        $data['title'] = 'Transaction Details';
        $data['subTitle'] = '';

        $bookType = $this->request->getGet('book_type');
        $year = $this->request->getGet('year');
        $months = $this->request->getGet('months'); 

        $transactions = [];

        if ($bookType && $year && is_array($months)) {
            
            if ($bookType === 'ebook') {
                $allData = $this->royaltyModel->getEbookDetails();
            } else {
                $allData = $this->royaltyModel->getAudioBookDetails();
            }

            
            foreach ($months as $month) {
                $month = (int) $month;
                $monthName = date('F', mktime(0, 0, 0, $month, 10)); 
                $key = "{$monthName}-{$year}"; 

                if (isset($allData[$key])) {
                    $monthData = $allData[$key];

                    foreach ($monthData as $channel => $value) {
                        $transactions[$key][$channel] = [
                            'revenue' => isset($value['revenue']) ? (float) $value['revenue'] : 0,
                            'royalty' => isset($value['royalty']) ? (float) $value['royalty'] : 0
                        ];
                    }
                }
            }
        }

        $data['transactions'] = $transactions;

        return view('royalty/transactionDetails', $data);
    }


}

