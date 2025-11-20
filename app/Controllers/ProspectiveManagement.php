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
          $this->db = Database::connect();
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
            'recommended_plan'    => $request->getPost('recommended_plan'),
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
    // public function planDetails()
    // {
    //     $data = [
    //         'title' => ''
    //     ];
    //     return view('ProspectiveManagement/planDetails', $data);
    // }
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

        return view('ProspectiveManagement/Edit', $data);
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

        return view('ProspectiveManagement/editinprogress', $data);
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
    $model = new \App\Models\ProspectiveManagementModel();

    $data['prospect'] = $model->getProspectById($id);
    if (!$data['prospect']) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException("Prospect not found");
    }
    $data['plans'] = $model->getProspectorPaidPartialPlans($id);
    $data['generalRemarks'] = $model->getProspectorGeneralRemarks($id);
    $data['title'] = "";

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
    $db = \Config\Database::connect();

    // ✅ Get plan summary from prospectors_book_details based on plan_name
    $data['plans'] = $db->table('prospectors_book_details b')
        ->select('b.plan_name,
                  COUNT(DISTINCT b.title) AS total_titles,
                  SUM(b.payment_amount) AS total_amount')
        ->join('prospectors_details p', 'p.id = b.prospector_id', 'left')
        ->where('p.prospectors_status', 1)
        ->where('b.plan_name !=', '')
        ->groupBy('b.plan_name')
        ->orderBy('total_amount', 'DESC')
        ->get()
        ->getResultArray();

    $data['title'] = '';
    return view('ProspectiveManagement/plansSummary', $data);
}



   public function viewPlan($planName)
{
    $db = \Config\Database::connect();

    $data['planName'] = urldecode($planName);

    // ✅ Subquery to get latest entry per (prospector_id + title)
    $subquery = $db->table('prospectors_book_details')
        ->select('prospector_id, title, MAX(create_date) AS latest_date')
        ->groupBy('prospector_id, title');

    // ✅ Main query
    $data['prospects'] = $db->table('prospectors_book_details b')
        ->select('b.*, p.id AS prospect_id, p.name, p.phone, p.email, p.author_status')
        ->join('(' . $subquery->getCompiledSelect() . ') latest',
            'latest.prospector_id = b.prospector_id 
             AND latest.title = b.title 
             AND latest.latest_date = b.create_date',
            'inner')
        ->join('prospectors_details p', 'p.id = b.prospector_id', 'left')
        ->where('b.plan_name', $data['planName'])
        ->where('p.prospectors_status', 1)
        ->orderBy('b.create_date', 'DESC')
        ->get()
        ->getResultArray();

    $data['title'] = '';

    return view('ProspectiveManagement/planSubscribers', $data);
}


  public function paymentDetails()
{
    $db = \Config\Database::connect();

    //  Subquery to get latest create_date for each title of each prospector
    $subquery = $db->table('prospectors_book_details')
        ->select('MAX(create_date) as latest_date, prospector_id, title')
        ->groupBy('prospector_id, title');

    //  Main query joins to get all latest book entries (per title per prospector)
    $builder = $db->table('prospectors_book_details b')
        ->select('b.*, p.name, p.phone, p.email, p.author_status, p.recommended_plan')
        ->join('prospectors_details p', 'p.id = b.prospector_id', 'left')
        ->join('(' . $subquery->getCompiledSelect() . ') latest',
            'latest.prospector_id = b.prospector_id
             AND latest.title = b.title
             AND latest.latest_date = b.create_date',
            'inner')
        ->where('p.prospectors_status', 1)
        ->whereIn('b.payment_status', ['paid', 'partial'])
        ->orderBy('b.create_date', 'DESC');

    $data['prospects'] = $builder->get()->getResultArray();
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
    public function addBook()
    {
        $db = \Config\Database::connect();

        // Fetch all active prospectors (prospectors_status = 1)
        $prospectors = $db->table('prospectors_details')
            ->select('id, name')
            ->where('prospectors_status', 1)
            ->orderBy('name', 'ASC')
            ->get()
            ->getResultArray();

        $data = [
            'prospectors' => $prospectors,
            'title'       => '',
        ];

        return view('ProspectiveManagement/addBook', $data);
    }

    public function saveBookDetails()
    {
        $request = service('request');
        $db = \Config\Database::connect();

        $prospector_id       = $request->getPost('prospector_id');
        $plan_name           = $request->getPost('plan_name');
        $title               = $request->getPost('title');
        $payment_status      = $request->getPost('payment_status');
        $payment_amount      = $request->getPost('payment_amount');
        $payment_description = $request->getPost('payment_description');
        $payment_date        = $request->getPost('payment_date');
        $remarks             = $request->getPost('remarks');

        // Insert into prospectors_book_details table
        $create_date = date('Y-m-d H:i:s');
        $bookData = [
            'prospector_id'       => $prospector_id,
            'title'               => $title,
            'plan_name'           => $plan_name,
            'payment_status'      => $payment_status,
            'payment_amount'      => $payment_amount,
            'payment_date'        => $payment_date,
            'create_date'         => $create_date
        ];
        $db->table('prospectors_book_details')->insert($bookData);

        // Insert into prospectors_remark_details table
        $remarkData = [
            'prospectors_id'      => $prospector_id,
            'title'               => $title,
            'payment_description' => $payment_description,
            'remarks'             => $remarks,
            'des_date'            => date('Y-m-d H:i:s'),
            'created_by'          => session()->get('username') ?? 'System',
        ];
        $db->table('prospectors_remark_details')->insert($remarkData);

        return redirect()->to(base_url('prospectivemanagement'))
            ->with('success', 'Book details added successfully!');
    }
    public function editBook($prospector_id = null, $id = null)
{
    if (!$prospector_id || !$id) {
        return redirect()->to(base_url('prospectivemanagement/dashboard'))
                         ->with('error', 'Invalid request.');
    }

    $book = $this->prospectiveModel->getBookByProspectorAndId($prospector_id, $id);

    if (empty($book)) {
        return redirect()->to(base_url('prospectivemanagement/dashboard'))
                         ->with('error', 'Book not found.');
    }

    // Fetch remarks for this book (using title)
    $remarks = $this->prospectiveModel->getRemarksByProspectorAndTitle($prospector_id, $book['title']);

    $data = [
        'book' => $book,
        'remarks' => $remarks,
        'title'  => '',
    ];

    return view('ProspectiveManagement/editBook', $data);
}


public function updateBook($prospector_id = null, $id = null)
{
    if (!$prospector_id || !$id) {
        return redirect()->to(base_url('prospectivemanagement/dashboard'))
                         ->with('error', 'Invalid request.');
    }

    $request = $this->request;
    $db = \Config\Database::connect();

    // Fetch the existing book row
    $book = $this->prospectiveModel->getBookByProspectorAndId($prospector_id, $id);

    if (!$book) {
        return redirect()->to(base_url('prospectivemanagement/dashboard'))
                         ->with('error', 'Book record not found.');
    }

    $oldTitle = $book['title'];
    $newTitle = trim($request->getPost('title')) ?: $oldTitle;
    $oldAmount = $book['payment_amount'] ?? 0;
    $postedAmount = (float)($request->getPost('payment_amount') ?? 0);
    $newAmount = $oldAmount + $postedAmount;
    $newPlan = $request->getPost('plan_name');
    $paymentStatus = $request->getPost('payment_status');
    $paymentDate = $request->getPost('payment_date') ?: date('Y-m-d');
    $remarksText = trim($request->getPost('remarks'));
    $paymentDescription = trim($request->getPost('payment_description'));

    // --- Update book details ---
    $db->table('prospectors_book_details')
       ->where('id', $id)
       ->update([
           'title' => $newTitle,
           'plan_name' => $newPlan,
           'payment_status' => $paymentStatus,
           'payment_amount' => $newAmount,
           'payment_date' => $paymentDate,
           'update_date' => date('Y-m-d H:i:s'),
       ]);

    // --- Update remarks table title if changed ---
    if ($oldTitle != $newTitle) {
        $db->table('prospectors_remark_details')
           ->where('prospectors_id', $prospector_id)
           ->where('title', $oldTitle)
           ->update(['title' => $newTitle]);
    }

    // --- Insert new remark log if needed ---
    $finalRemark = '';
    $finalPayDesc = $paymentDescription;
    $changeMessages = [];

    if (!empty($remarksText)) {
        $finalRemark = $remarksText;
    }

    if ($postedAmount > 0) {
        $changeMessages[] = "Amount Added: ₹{$postedAmount} (Total Paid: ₹{$newAmount})";
    }

    if (!empty($book['payment_status']) && $book['payment_status'] != $paymentStatus) {
        $changeMessages[] = "Payment Status: {$book['payment_status']} → {$paymentStatus}";
        $statusChangeText = "Payment Status changed: {$book['payment_status']} → {$paymentStatus}";
        $finalRemark = !empty($finalRemark) ? $finalRemark . ' | ' . $statusChangeText : $statusChangeText;
    }

    if (!empty($book['plan_name']) && $book['plan_name'] != $newPlan) {
        $planChangeText = "Plan changed: {$book['plan_name']} → {$newPlan}";
        $finalRemark = !empty($finalRemark) ? $finalRemark . ' | ' . $planChangeText : $planChangeText;
    }

    if (!empty($changeMessages)) {
        $combinedChanges = implode(' | ', $changeMessages);
        $finalPayDesc = $paymentDescription
            ? $paymentDescription . ' | ' . $combinedChanges
            : $combinedChanges;
    }

    if (!empty($finalRemark) || !empty($finalPayDesc)) {
        $db->table('prospectors_remark_details')->insert([
            'prospectors_id' => $prospector_id,
            'title' => $newTitle,
            'remarks' => $finalRemark ?: null,
            'payment_description' => $finalPayDesc ?: null,
            'create_date' => date('Y-m-d H:i:s'),
            'des_date' => !empty($finalPayDesc) ? date('Y-m-d H:i:s') : null,
            'created_by' => session()->get('username') ?? 'System',
        ]);
    }

    return redirect()->to(base_url('prospectivemanagement/editbook/' . $prospector_id . '/' . $id))
                     ->with('success', 'Book details and remarks updated successfully.');
}

    public function viewBook($prospector_id = null, $id = null)
{
    if (!$prospector_id || !$id) {
        return redirect()->to(base_url('prospectivemanagement/dashboard'))
                        ->with('error', 'Invalid request.');
    }

    $model = new \App\Models\ProspectiveManagementModel();

    //  Fetch the plan using prospector_id + plan id
    $plans = $model->getPlansByProspectorAndId($prospector_id, $id);

    if (empty($plans)) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException("No plans found for this prospector.");
    }

    //  Get the title from the fetched plan
    $title = $plans[0]['title'];

    //  Fetch remarks using prospector_id + title
    $remarks = $model->getRemarksByProspectorAndTitle($prospector_id, $title);

    // Add prospect name to each plan
    $prospect_name = $model->getProspectNameById($prospector_id);
    foreach ($plans as &$plan) {
        $plan['prospect_name'] = $prospect_name;
    }

    $data['plans'] = $plans;
    $data['remarks'] = $remarks;
    $data['title'] = $title;

    return view('ProspectiveManagement/viewBookDetails', $data);
}

}