<?php

namespace App\Controllers;

use App\Models\EbookModel;
use App\Models\AudiobookModel;
use App\Models\PaperbackModel;

class Book extends BaseController
{
    protected $ebookModel;
    protected $audiobookModel;
    protected $paperbackModel;

    public function __construct()
    {
        $this->ebookModel      = new EbookModel();
        $this->audiobookModel  = new AudiobookModel();
        $this->paperbackModel  = new PaperbackModel();

        helper(['url']);
        session();
    }

    public function bookDashboard()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/adminv4/index');
        }

        $data = [
            'title'                      => 'Book Dashboard',
            'subTitle'                   => 'Monthly statistics and book overview',
            'dashboard_data'             => $this->ebookModel->getBookDashboardData(),
            'book_statistics'            => $this->ebookModel->getBookDashboardMonthlyStatistics(),
            'dashboard_curr_month_data' => $this->ebookModel->getBookDashboardCurrMonthData(),
            'dashboard_prev_month_data' => $this->ebookModel->getBookDashboardPrevMonthData(),
            'dashboard'                  => $this->audiobookModel->getBookDashboardData(),
        ];

        return view('Book/BookDashboard', $data);
    }

    public function getEbooksStatus()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/adminv4/index');
        }

        $data = [
            'title'                      => 'E-Book Status Overview',
            'subTitle'                   => 'Detailed status of all eBooks',
            'in_progress_dashboard_data' => $this->ebookModel->getInProgressDashboardData(),
            'ebooks_data'                => $this->ebookModel->getEbooksStatusDetails(),
        ];

        return view('Book/EbookStatusView', $data);
    }

    public function Ebooks()
    {
        $data = [
            'title'    => 'All E-Books',
            'subTitle' => 'List of uploaded and active eBooks',
            'e_books'  => $this->ebookModel->getEbookData(),
        ];

        return view('Book/Ebooks', $data);
    }

    public function audioBookDashboard()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/adminv4/index');
        }

        $data = [
            'title'                     => 'Audio Books Dashboard',
            'subTitle'                  => 'Overview of Audiobook Activities',
            'audio_books_dashboard_data' => $this->audiobookModel->getAudioBookDashboardData(),
        ];

        return view('Book/AudiobookDashboard', $data);
    }

    public function podBooksDashboard()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/adminv4/index');
        }

        $data = [
            'title'     => 'POD Books Dashboard',
            'subTitle'  => 'InDesign Processing Overview',
            'books'     => $this->paperbackModel->podIndesignProcessing(),
            'count'     => $this->paperbackModel->indesignProcessingCount(),
        ];

        return view('Book/PodbookDashboard', $data);
    }
}
