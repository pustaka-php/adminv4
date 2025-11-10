<?php

namespace App\Controllers;

use App\Models\ProspectiveManagementModel;
use CodeIgniter\Controller;
use Config\Database;

class ProspectiveManagement extends Controller
{
    protected $prospectiveModel;

    public function __construct()
    {
        $this->prospectiveModel = new ProspectiveManagementModel();
    }

    public function dashboard()
    {
        $model = new \App\Models\ProspectiveManagementModel();
        $dashboardData = [
            'prospectCounts' => $model->getProspectCounts(),
            'planCounts'     => $model->getPlanCounts(),
            'paymentSummary' => $model->getPaymentSummary(),
        ];
        $data = [
            'title'           => '',
            'prospectCounts'  => $dashboardData['prospectCounts'],
            'planCounts'      => $dashboardData['planCounts'],
            'paymentSummary'  => $dashboardData['paymentSummary'],
        ];
        return view('ProspectiveManagement/PMdashboard', $data);
    }
    public function addProspect()
    {
        $data = [
            'title' => ''
        ];
        return view('ProspectiveManagement/addProspect', $data);
    }

    public function saveProspect()
    {
        $request = $this->request;
        $model   = new ProspectiveManagementModel();

        $data = [
            'name'                => $request->getPost('name'),
            'phone'               => $request->getPost('phone'),
            'email'               => $request->getPost('email'),
            'source_of_reference' => $request->getPost('source_of_reference'),
            'author_status'       => $request->getPost('author_status'),
            'no_of_title'         => $request->getPost('no_of_title'),
            'titles'              => $request->getPost('titles'),
            'recommended_plan'    => $request->getPost('recommended_plan'),
            'payment_status'      => $request->getPost('payment_status'),
            'payment_amount'      => $request->getPost('payment_amount'),
            'payment_date'        => $request->getPost('payment_date'),
            'payment_description' => $request->getPost('payment_description'),
            'email_sent_flag'     => $request->getPost('email_sent_flag'),
            'initial_call_flag'   => $request->getPost('initial_call_flag'),
            'email_sent_date'     => $request->getPost('email_sent_date'),
            'initial_call_date'   => $request->getPost('initial_call_date'),
            'created_at'          => date('Y-m-d H:i:s'),
            'prospectors_status'  => 0,
        ];

        try {
            $prospectorId = $model->saveProspectData($data);

            if ($prospectorId) {
                $remarks            = trim($request->getPost('remarks'));
                $paymentDescription = trim($request->getPost('payment_description'));
                $now = date('Y-m-d H:i:s');

                $remarkData = [
                    'prospectors_id' => $prospectorId,
                    'created_by'          => session()->get('username') ?? 'System',
                ];

                if (!empty($remarks) && empty($paymentDescription)) {
                    $remarkData['remarks'] = $remarks;
                    $remarkData['create_date'] = $now;
                } elseif (empty($remarks) && !empty($paymentDescription)) {
                    $remarkData['payment_description'] = $paymentDescription;
                    $remarkData['des_date'] = $now;
                } elseif (!empty($remarks) && !empty($paymentDescription)) {
                    $remarkData['remarks'] = $remarks;
                    $remarkData['payment_description'] = $paymentDescription;
                    $remarkData['create_date'] = $now;
                    $remarkData['des_date'] = $now;
                }

                if (isset($remarkData['remarks']) || isset($remarkData['payment_description'])) {
                    $model->saveProspectRemark($remarkData);
                }
            }

            return $this->response->setJSON([
                'success' => (bool) $prospectorId,
                'message' => $prospectorId
                    ? 'Prospect added successfully!'
                    : 'Database insertion failed.'
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Save Prospect Error: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ]);
        }
    }
    public function planDetails()
    {
        $data = [
            'title' => ''
        ];
        return view('ProspectiveManagement/planDetails', $data);
    }
    public function inProgress()
    {
        $data = [
            'title' => '',
            'prospects' => $this->prospectiveModel->getAllProspects()
        ];
        return view('ProspectiveManagement/inProgress', $data);
    }
   public function edit($id)
    {
        $model = new \App\Models\ProspectiveManagementModel();
        $prospect = $model->getProspectById($id);

        if (!$prospect) {
            return redirect()
                ->to(base_url('prospectivemanagement/dashboard'))
                ->with('error', 'Prospect not found.');
        }
        $payment_status_list = [
            'Paid',
            'Partial',
        ];
        $prospect['remark'] = '';
        $prospect['payment_description'] = '';

        $data = [
            'title'                => '',
            'prospect'             => $prospect,
            'payment_status_list'  => $payment_status_list,
        ];

        return view('prospectivemanagement/Edit', $data);
    }

    public function updateProspect($id)
    {
        $request = service('request');
        $model   = new \App\Models\ProspectiveManagementModel();

        $result = $model->updateProspectFromPost($id, $request);
        if ($request->isAJAX()) {
            if ($result === true) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Prospect updated successfully.'
                ]);
            } elseif ($result === 0) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No changes detected.'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Prospect not found or update failed.'
                ]);
            }
        }
        if ($result) {
            return redirect()
                ->to(base_url('prospectivemanagement/dashboard'))
                ->with('success', 'Prospect updated successfully.');
        } else {
            return redirect()
                ->back()
                ->with('info', 'No changes detected.');
        }
    }
     public function editinprogress($id)
    {
        $model = new \App\Models\ProspectiveManagementModel();
        $prospect = $model->getProspectById($id);

        if (!$prospect) {
            return redirect()
                ->to(base_url('prospectivemanagement/dashboard'))
                ->with('error', 'Prospect not found.');
        }
        $payment_status_list = [
            'Paid',
            'Partial',
        ];
        $prospect['remark'] = '';
        $prospect['payment_description'] = '';

        $data = [
            'title'                => '',
            'prospect'             => $prospect,
            'payment_status_list'  => $payment_status_list,
        ];

        return view('prospectivemanagement/editInprogress', $data);
    }
    public function updateInprogress($id)
    {
        $request = service('request');
        $model   = new \App\Models\ProspectiveManagementModel();

        $result = $model->updateInprogressFromPost($id, $request);
        if ($request->isAJAX()) {
            if ($result === true) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Prospect updated successfully.'
                ]);
            } elseif ($result === 0) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No changes detected.'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Prospect not found or update failed.'
                ]);
            }
        }
        if ($result) {
            return redirect()
                ->to(base_url('prospectivemanagement/dashboard'))
                ->with('success', 'Prospect updated successfully.');
        } else {
            return redirect()
                ->back()
                ->with('info', 'No changes detected.');
        }
    }
    public function deny($id = null)
    {
        if (!$id) {
            return redirect()->back()->with('error', 'Invalid prospect ID.');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('prospectors_details');
        $updated = $builder->where('id', $id)
                        ->update(['prospectors_status' => 2]);

        if ($updated) {
            return redirect()->back()->with('success', 'Prospect marked as Denied successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update prospect status.');
        }
    }
    public function closed()
    {
        $model = new ProspectiveManagementModel();
        $data['title'] = '';
        $data['prospects'] = $model->getProspectsByStatus(1); // only closed

        return view('ProspectiveManagement/closed', $data);
    }
    public function inprogres($id = null)
    {
        if (!$id) {
            return redirect()->back()->with('error', 'Invalid prospect ID.');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('prospectors_details');
        $updated = $builder->where('id', $id)
                        ->update(['prospectors_status' => 0]);

        if ($updated) {
            return redirect()->back()->with('success', 'Prospect marked as Denied successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update prospect status.');
        }
    }
    public function denied()
    {
        $model = new \App\Models\ProspectiveManagementModel();
        $data['prospects'] = $model->getDeniedProspects();
        $data['title'] = '';

        return view('ProspectiveManagement/denied', $data);
    }
    public function view($id)
    {
        $model = new ProspectiveManagementModel();
        // Get main prospect details
        $data['prospect'] = $model->getProspectById($id);
        $data['title'] = '';

        if (!$data['prospect']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Prospect with ID $id not found");
        }
        // Get related remarks
        $data['remarks'] = $model->getRemarksByProspectId($id);

        return view('ProspectiveManagement/viewDetails', $data);
    }
    public function close($id = null)
    {
        if (!$id) {
            return redirect()->back()->with('error', 'Invalid prospect ID.');
        }
        $db = \Config\Database::connect();
        $builder = $db->table('prospectors_details');

        // Update status to 1 (closed)
        $updated = $builder->where('id', $id)
                        ->update(['prospectors_status' => 1]);

        if ($updated) {
            return redirect()->back()->with('success', 'Prospect marked as Closed successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update prospect status.');
        }
    }
    public function plansSummary()
    {
        $model = new ProspectiveManagementModel();

        // Only active prospectors (prospectors_status = 1)
        $data['plans'] = $model->db->table('prospectors_details')
                                ->select('recommended_plan,
                                            COUNT(id) AS total_subscribers,
                                            SUM(payment_amount) AS total_amount')
                                ->where('recommended_plan !=', '')
                                ->where('prospectors_status', 1)
                                ->groupBy('recommended_plan')
                                ->get()
                                ->getResultArray();

        $data['title'] = '';
        return view('ProspectiveManagement/plansSummary', $data);
    }
    public function viewPlan($planName)
    {
        $model = new ProspectiveManagementModel();

        // Fetch all active prospects who selected this specific plan
        $data['planName'] = $planName;
        $data['prospects'] = $model->db->table('prospectors_details')
                                    ->where('recommended_plan', $planName)
                                    ->where('prospectors_status', 1)
                                    ->orderBy('created_at', 'DESC')
                                    ->get()
                                    ->getResultArray();

        $data['title'] = '';
        return view('ProspectiveManagement/planSubscribers', $data);
    }
    public function paymentDetails()
    {
        $db = Database::connect();
        $table = 'prospectors_details';

        $data['prospects'] = $db->table($table)
            ->select('*') 
            ->whereIn('payment_status', ['paid', 'partial'])
            ->where('prospectors_status', 1)
            ->orderBy('payment_date', 'DESC')
            ->get()
            ->getResultArray();

        $data['title'] = '';
        return view('ProspectiveManagement/paymentDetails', $data);
    }
    public function closeInprogress($id)
    {
        $db = Database::connect();
        $table = 'prospectors_details';
        $prospect = $db->table($table)->where('id', $id)->get()->getRowArray();

        if (!$prospect) {
            return redirect()->back()->with('error', 'Prospect not found.');
        }
        if (!empty($prospect['payment_status']) && !empty($prospect['payment_amount'])) {
            // Update status to Closed
            $db->table($table)
                ->where('id', $id)
                ->update(['prospectors_status' => '1']);

            return redirect()->back()->with('success', 'Prospect marked as Closed successfully.');
        } else {
            $data['prospect'] = $prospect;
            $data['title'] = '';
            return view('ProspectiveManagement/payment', $data);
        }
    }
    public function savePayment($id)
    {
        $db = \Config\Database::connect();
        $table = 'prospectors_details';
        $now = date('Y-m-d H:i:s');
        $data = [
            'no_of_title'         => $this->request->getPost('no_of_title'),
            'titles'              => $this->request->getPost('titles'),
            'payment_status'      => $this->request->getPost('payment_status'),
            'payment_amount'      => $this->request->getPost('payment_amount'),
            'payment_date'        => $this->request->getPost('payment_date'),
            'payment_description' => $this->request->getPost('payment_description'),
            
        ];

        $db->table($table)->where('id', $id)->update($data);
        $db->table($table)->where('id', $id)->update(['prospectors_status' => '1']);
        $remarkData = [
            'prospectors_id'      => $id,
            'payment_description' => $this->request->getPost('payment_description'),
            'des_date'            => $now,
            'created_by'          => session()->get('username') ?? 'System',
        ];

        $db->table('prospectors_remark_details')->insert($remarkData);

        return redirect()
            ->to(base_url('prospectivemanagement/dashboard'))
            ->with('success', 'Payment details saved, prospect marked as Closed, and remark added.');
    }

}