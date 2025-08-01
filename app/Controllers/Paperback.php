<?php

namespace App\Controllers;
use App\Models\PustakapaperbackModel;


class Paperback extends BaseController
{
    
    protected $pustakapaperbackModel;

    public function __construct()
    {
        helper(['form', 'url', 'file', 'email', 'html', 'cookie', 'string']);    
        $this->pustakapaperbackModel = new PustakapaperbackModel();
        
    }

    public function dashboard()
    {
        $data = [
            'stock'    => $this->pustakapaperbackModel->getPaperbackstockDetails(),
            'pending'  => $this->pustakapaperbackModel->totalPendingBooks(),
            'orders'   => $this->pustakapaperbackModel->totalPendingOrders(),
            'title'    => '',
            'subTitle' => ''
        ];    

        return view('printorders/paperbackOrderdashboardView', $data);
    }

}
