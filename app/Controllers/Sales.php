<?php

namespace App\Controllers;

use App\Models\SalesModel;
use CodeIgniter\Controller;

class Sales extends BaseController
{
    protected $salesmodel;

    public function __construct()
    {
        helper(['form', 'url', 'file', 'email', 'html', 'cookie', 'string']);
        $this->salesmodel = new SalesModel();
    }

    public function salesdashboard()
    {
        $data['total'] = $this->salesmodel->salesDashboardDetails();
        $data['channelwise'] = $this->salesmodel->channelwisesales();
        $data['pustaka'] = $this->salesmodel->paperbackDetails();
        $data['pod'] = $this->salesmodel->podsalesDetails();
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('sales/newsalesDashboard', $data);
    }

    public function salesreports()
    {
        $this->salesmodel = new \App\Models\SalesModel();
        $data['over_all'] = $this->salesmodel->getOverallSales();
        $data['channelwise'] = $this->salesmodel->channelwisesales();
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('sales/salesdetails', $data);
    }

    // public function ebookSales()
    // {
    //     $data['ebook'] = $this->salesmodel->ebooksalesDetails();

    //     echo view('header');
    //     echo view('sidebar');
    //     echo view('sales/ebookSalesDetails', $data);
    //     echo view('footer');
    // }

    // public function audiobookSales()
    // {
    //     $data['audiobook'] = $this->salesmodel->audiobookSalesDetails();

    //     echo view('header');
    //     echo view('sidebar');
    //     echo view('sales/audiobookSalesDetails', $data);
    //     echo view('footer');
    // }

    // public function paperbackSales()
    // {
    //     $data['pustaka'] = $this->salesmodel->paperbackDetails();

    //     echo view('header');
    //     echo view('sidebar');
    //     echo view('sales/paperbackSalesDetails', $data);
    //     echo view('footer');
    // }
}
