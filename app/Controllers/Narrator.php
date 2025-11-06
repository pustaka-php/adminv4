<?php

namespace App\Controllers;

use App\Models\NarratorModel;

class Narrator extends BaseController
{
    protected $narratorModel;
    protected $session;

    public function __construct()
    {
        $this->narratorModel = new NarratorModel();
        $this->session = session();
        helper(['form', 'url', 'file', 'email', 'html', 'cookie', 'string']);
    }

    public function narratorDashboard()
    {
        if (!$this->session->has('user_id')) {
            return redirect()->to('/adminv4/index');
        }

        $data['dashboard_data'] = $this->narratorModel->getNarratorDashboardData();
        $data['title'] = "Narrator Dashboard";
        $data['subTitle'] = "Overview of all narrators and their activities";

        return view('Narrator/NarratorDashboard', $data);
    }

    public function addNarratorView()
    {
        if (!$this->session->has('user_id')) {
            return redirect()->to('/adminv4/index');
        }

        $data['title'] = "Add Narrator";
        $data['subTitle'] = "Fill the details to add a new narrator";

        return view('Narrator/AddNarrator', $data);
    }
    public function editNarratorView($user_id = null)
    {
        if (!$this->session->has('user_id')) {
            return redirect()->to('/adminv4/index');
        }

        $data['narrator_data'] = $this->narratorModel->getEditNarratorData($user_id);

        if (!empty($data['narrator_data']['user_id'])) {
            $data['narrator_books_list'] = $this->narratorModel->getNarratorBooksList($data['narrator_data']['user_id']);
        }

        $data['title'] = "";
        $data['subTitle'] = "Update narrator information and book assignments";

        return view('Narrator/EditNarrator', $data);
    }
    public function addNarratorPost()
    {
        $result = $this->narratorModel->addNarrator($this->request);
        return $this->response->setJSON($result);
    }

    public function editNarratorPost()
    {
        $result = $this->narratorModel->editNarrator($this->request);
        return $this->response->setJSON($result);
    }

    public function addBook()
    {
        $result = $this->narratorModel->addBook($this->request);
        return $this->response->setJSON($result);
    }
}
