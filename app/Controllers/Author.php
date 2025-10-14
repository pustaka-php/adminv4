<?php

namespace App\Controllers;

use App\Models\AuthorModel;
use CodeIgniter\Controller;
use App\Controllers\BaseController;

class Author extends BaseController
{
    protected $authorModel;
    protected $helpers = ['form', 'url', 'file', 'email', 'html', 'cookie', 'string'];

    public function __construct()
    {
        helper($this->helpers);

        $this->authorModel = new AuthorModel();
        session();
    }


    public function authordashboard()
    {
        if (!$this->session->get('user_id')) {
            return redirect()->to('/adminv4/index');
        }

        $data['royalty_author_launches'] = $this->authorModel->getRoyaltyDistribution();
        $data['free_author_launches'] = $this->authorModel->getFreeDistribution();
        $data['magpub_author_launches'] = $this->authorModel->getMagpubDistribution();
        $data['authors_count'] = $this->authorModel->getDashboardData();
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('author/authorsDashboard', $data);
    }
    public function addauthor()
    {
        if (!session()->has('user_id'))
            return redirect()->to('/adminv4/index');

        $uri = $this->request->getUri();
        $author_type = $uri->getSegment(3);
        $data['author_type'] = $author_type;
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('author/addAuthorView', $data);
    }
    public function royaltyauthordashboard()
    {
        $session = session();
        if (!$session->has('user_id')) {
            return redirect()->to('/adminv4/index');
        }
        $data['get_language_wise_author_count'] = $this->authorModel->getRoyaltyDashboardData();
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('author/royaltyAuthorsDashboard', $data);
    }
    public function freeauthordashboard()
    {
        $session = session();

        if (!$session->has('user_id')) {
            return redirect()->to('/adminv4/index');
        }

        $data['get_language_wise_author_count'] = $this->authorModel->getFreeDashboardData();
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('author/freeAuthorsDashboard', $data);
    }
    public function magpubauthordashboard()
    {
        $session = session();

        if (!$session->has('user_id')) {
            return redirect()->to('/adminv4/index');
        }

        $data['get_language_wise_author_count'] = $this->authorModel->getMagpubDashboardData();
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('author/magpubAuthorsDashboard', $data);
    }
    public function manageauthors()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/adminv4/index');
        }
        $data['authors_metadata'] = $this->authorModel->getAuthorsMetadata();
        $data['title'] = '';
        $data['subTitle'] = '';

        return view('author/manageAuthors', $data);
    }

    public function addauthorpost()
    {
        $result = $this->authorModel->addAuthor($this->request->getPost());
        return $this->response->setJSON(['status' => $result]);

    }

}
