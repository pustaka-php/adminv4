<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TpDashboardModel; 


class TpPublisherDashboard extends BaseController
{

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->TpDashboardModel = new TpDashboardModel();
        helper('url');
        $this->session = session();
    }
    public function tpPublisherDashboard()
{
    $session = session();
    $user_id   = $session->get('user_id');
    $user_type = $session->get('user_type');

    if (!$user_id) {
        return redirect()->to('/login');
    }

    if ($user_type == 4) {
        $data['details'] = $this->Tpdashboardmodel->getAlltpPublishersDetails();
    } else {
        $publisher_id = $this->Tpdashboardmodel->getPublisherIdFromUserId($user_id);

        if (!$publisher_id) {
            echo "No publisher found for user ID: $user_id";
            exit;
        }

        $data['details'] = $this->Tpdashboardmodel->gettpPublishersDetails($publisher_id);
    }

    $data['user_type'] = $user_type;

    return view('tppublisherdashboard/tppublisherdashboard', $data);
}

}
