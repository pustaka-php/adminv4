<?php

namespace App\Models;

use CodeIgniter\Model;

class ProspectiveManagementModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }
       public function saveProspectData($data)
    {
        $this->db->table('prospectors_details')->insert($data);
        return $this->db->insertID(); 
    }

    public function saveProspectRemark($remarkData)
    {
        return $this->db->table('prospectors_remark_details')->insert($remarkData);
    }
    public function getAllProspects()
    {
        return $this->db->table('prospectors_details')
                        ->where('prospectors_status', 0) 
                        ->orderBy('id', 'DESC')
                        ->get()
                        ->getResultArray();
    }
    // Get one prospect by ID (fetch only)
    public function getProspectById($id)
    {
        return $this->db->table('prospectors_details')
                        ->where('id', $id)
                        ->get()
                        ->getRowArray();
    }
    public function updateProspectFromPost($id, $request)
{
    $db      = \Config\Database::connect();
    $builder = $db->table('prospectors_details');
    $old     = $builder->where('id', $id)->get()->getRowArray();

    if (!$old) return false;

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
        'last_update_date'    => date('Y-m-d H:i:s'),
    ];

    // Detect changes
    $hasChanges = false;
    foreach ($data as $key => $value) {
        $oldVal = $old[$key] ?? null;
        if ((string)$oldVal !== (string)$value) {
            $hasChanges = true;
            break;
        }
    }

    // Update only if changed
    if ($hasChanges) {
        $builder->where('id', $id)->update($data);
    }

    // Remarks logging
    $remarks = trim($request->getPost('remarks'));
    $finalRemark = '';
    $createDate = null;

    // Plan change check
    if ($old['recommended_plan'] != $data['recommended_plan']) {
        $planChangeText = "Plan: {$old['recommended_plan']} → {$data['recommended_plan']}";
        $finalRemark = $remarks ? $remarks . ' | ' . $planChangeText : $planChangeText;
        $createDate = date('Y-m-d H:i:s');
    } elseif (!empty($remarks)) {
        $finalRemark = $remarks;
        $createDate = date('Y-m-d H:i:s');
    }

    // Insert remark if applicable
    if (!empty($finalRemark)) {
        $remarkData = [
            'prospectors_id' => $id,
            'title'          => $old['title'] ?? null,
            'remarks'        => $finalRemark,
            'create_date'    => $createDate,
            'created_by'     => session()->get('username') ?? 'System',
        ];
        $db->table('prospectors_remark_details')->insert($remarkData);
    }

    return $hasChanges ? true : 0;
}


   public function updateInprogressFromPost($id, $request)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('prospectors_details');

        $old = $builder->where('id', $id)->get()->getRowArray();
        if (!$old) return false;

        // --- PROSPECT STATUS ---
        $postedStatus = $request->getPost('prospectors_status');
        if ($postedStatus == 1) {
            $statusText = 'Accepted & Closed';
            $prospectors_status = 1;
        } elseif ($postedStatus == 2) {
            $statusText = 'Rejected & Denied';
            $prospectors_status = 2;
        } else {
            $statusText = 'Pending';
            $prospectors_status = 0;
        }

        // --- MAIN TABLE DATA ---
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
            'prospectors_status'  => $prospectors_status,
            'last_update_date'    => date('Y-m-d H:i:s'),
        ];

        // --- DETECT CHANGES ---
        $hasChanges = false;
        foreach ($data as $key => $value) {
            $oldVal = $old[$key] ?? null;
            if ((string)$oldVal !== (string)$value) {
                $hasChanges = true;
                break;
            }
        }

        // --- UPDATE MAIN TABLE ---
        if ($hasChanges) {
            $builder->where('id', $id)->update($data);
        }

        // --- REMARKS LOGGING ---
        $remarks = trim($request->getPost('remarks'));
        $finalRemark = '';
        $createDate = null;

        // --- PLAN CHANGE ---
        if ($old['recommended_plan'] != $data['recommended_plan']) {
            $planChangeText = "Plan: {$old['recommended_plan']} → {$data['recommended_plan']}";
            $finalRemark = $remarks ? $remarks . ' | ' . $planChangeText : $planChangeText;
            $createDate = date('Y-m-d H:i:s');
        } elseif (!empty($remarks)) {
            $finalRemark = $remarks;
            $createDate = date('Y-m-d H:i:s');
        }

        // --- INSERT REMARK ---
        if (!empty($finalRemark)) {
            $remarkData = [
                'prospectors_id' => $id,
                'title'          => $old['title'] ?? null,
                'remarks'        => $finalRemark,
                'create_date'    => $createDate,
                'created_by'     => session()->get('username') ?? 'System',
            ];
            $db->table('prospectors_remark_details')->insert($remarkData);
        }

        return $hasChanges;
    }
    public function updateProspectStatus($id, $status)
    {
        return $this->db->table('prospectors_details')
                        ->where('id', $id)
                        ->update(['prospectors_status' => $status, 'last_update_date' => date('Y-m-d H:i:s')]);
    }
    public function getProspectsByStatus($status)
    {
        return $this->db->table('prospectors_details')
                        ->where('prospectors_status', $status)
                        ->orderBy('id', 'DESC')
                        ->get()
                        ->getResultArray();
    }
    public function getDeniedProspects()
    {
        return $this->db->table('prospectors_details')
                        ->where('prospectors_status', 2)
                        ->orderBy('id', 'DESC')
                        ->get()
                        ->getResultArray();
    }

    public function getRemarksByProspectId($prospectId)
    {
        return $this->db->table('prospectors_remark_details')
            ->where('prospectors_id', $prospectId)
            ->groupStart()
                ->groupStart()
                    ->where('remarks IS NOT NULL')
                    ->where('remarks !=', '')
                ->groupEnd()
                ->orGroupStart()
                    ->where('payment_description IS NOT NULL')
                    ->where('payment_description !=', '')
                ->groupEnd()
            ->groupEnd()
            ->orderBy('create_date', 'DESC')
            ->get()
            ->getResultArray();
    }
    public function getProspectCounts()
    {
        $db = \Config\Database::connect();

        $today = date('Y-m-d');
        $month = date('m');

        $data = [];

        // In Progress (status = 0)
        $data['inProgressCount'] = $db->table('prospectors_details')
            ->where('prospectors_status', 0)
            ->countAllResults();

        // Closed (status = 1)
        $data['closedCount'] = $db->table('prospectors_details')
            ->where('prospectors_status', 1)
            ->countAllResults();

        // Denied (status = 2)
        $data['deniedCount'] = $db->table('prospectors_details')
            ->where('prospectors_status', 2)
            ->countAllResults();

        //Today counts
        $data['todayInProgress'] = $db->table('prospectors_details')
            ->where('DATE(created_at)', $today)
            ->countAllResults();

        //This month counts
        $data['monthInProgress'] = $db->table('prospectors_details')
            ->where('prospectors_status', 0)
            ->where('MONTH(created_at)', $month)
            ->countAllResults();
        return $data;
    }

    public function getPlanCounts()
{
    $db = \Config\Database::connect();
    $plans = ['Silver', 'Gold', 'Platinum', 'Silver++', 'Rhodium', 'Pearl', 'Sapphire'];

    $result = [];
    $total = 0;

    // Subquery to get latest create_date for each (prospector_id + title)
    $subquery = $db->table('prospectors_book_details')
        ->select('MAX(create_date) as latest_date, prospector_id, title')
        ->groupBy('prospector_id, title');

    // Join latest entry to main book details
    $baseQuery = $db->table('prospectors_book_details b')
        ->join('(' . $subquery->getCompiledSelect() . ') latest',
            'latest.prospector_id = b.prospector_id 
             AND latest.title = b.title 
             AND latest.latest_date = b.create_date',
            'inner')
        ->join('prospectors_details p', 'p.id = b.prospector_id', 'left')
        ->where('p.prospectors_status', 1);

    // Loop through plans and count occurrences
    foreach ($plans as $plan) {
        $builder = clone $baseQuery;
        $count = $builder->where('b.plan_name', $plan)->countAllResults();
        $result[$plan] = $count;
        $total += $count;
    }

    $result['totalPlans'] = $total;

    return $result;
}
   public function getPaymentSummary()
{
    $db = \Config\Database::connect();

    // Subquery – Get latest record per (prospector_id + title)
    $subquery = $db->table('prospectors_book_details')
        ->select('prospector_id, title, MAX(create_date) AS latest_date')
        ->groupBy('prospector_id, title');

    //  Join to get only those latest entries
    $builder = $db->table('prospectors_book_details b')
        ->select('b.prospector_id, b.title, b.payment_status, b.payment_amount, b.create_date')
        ->join('(' . $subquery->getCompiledSelect() . ') latest',
            'latest.prospector_id = b.prospector_id 
             AND latest.title = b.title 
             AND latest.latest_date = b.create_date',
            'inner')
        ->join('prospectors_details p', 'p.id = b.prospector_id', 'left')
        ->where('p.prospectors_status', 1) // closed/active prospects only
        ->orderBy('b.create_date', 'DESC');

    $records = $builder->get()->getResultArray();

    //  Initialize counters
    $totalCount = $paidCount = $partialCount = 0;
    $totalRevenue = $paidTotal = $partialTotal = 0.0;

    // Loop through latest records only
    foreach ($records as $row) {
        $amount = (float)($row['payment_amount'] ?? 0);
        $status = strtolower(trim($row['payment_status'] ?? ''));

        // Count total titles
        $totalCount++;
        $totalRevenue += $amount;

        if ($status === 'paid') {
            $paidCount++;
            $paidTotal += $amount;
        } elseif ($status === 'partial') {
            $partialCount++;
            $partialTotal += $amount;
        }
    }

    // Return summary array
    return [
        'totalCount'    => $totalCount,
        'totalRevenue'  => $totalRevenue,
        'paidCount'     => $paidCount,
        'paidTotal'     => $paidTotal,
        'partialCount'  => $partialCount,
        'partialTotal'  => $partialTotal,
    ];
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
    ];

    return view('prospectivemanagement/add_book', $data);
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

    // Insert into prospectors_book_details table
    $bookData = [
        'prospector_id'       => $prospector_id,
        'plan_name'           => $plan_name,
        'title'               => $title,
        'payment_status'      => $payment_status,
        'payment_amount'      => $payment_amount,
        'payment_date'        => $payment_date,
    ];
    $db->table('prospectors_book_details')->insert($bookData);

    // Insert into prospectors_remark_details table
    $remarkData = [
        'prospectors_id'      => $prospector_id,
        'payment_description' => $payment_description,
        'des_date'            => date('Y-m-d H:i:s'),
        'created_by'          => session()->get('username') ?? 'System',
    ];
    $db->table('prospectors_remark_details')->insert($remarkData);

    return redirect()->to(base_url('prospectivemanagement'))
        ->with('success', 'Book details added successfully!');
}

    // Get book/plan/payment details (title, plan, amount, status)
   public function getProspectorPaidPartialPlans($prospectorId)
{
    $builder = $this->db->table('prospectors_book_details');

    // Subquery to get latest id per title for paid/partial
    $subQuery = $this->db->table('prospectors_book_details')
        ->select('MAX(id) as max_id')
        ->where('prospector_id', $prospectorId)
        ->groupStart()
            ->whereIn('LOWER(payment_status)', ['paid', 'partial'])
        ->groupEnd()
        ->groupBy('title');

    $builder->select('id, prospector_id, title, plan_name, payment_status, payment_amount, payment_date, create_date'); // include prospector_id
    $builder->where('prospector_id', $prospectorId)
            ->whereIn('id', $subQuery);

    $builder->orderBy('create_date', 'DESC'); 
    $query = $builder->get();

    $result = $query->getResultArray();

    // Add readable payment status
    foreach ($result as &$row) {
        $status = strtolower($row['payment_status'] ?? '');
        if ($status === 'paid') {
            $row['payment_status_text'] = 'Fully Paid';
        } elseif ($status === 'partial') {
            $row['payment_status_text'] = 'Partial Payment';
        } else {
            $row['payment_status_text'] = 'Unpaid';
        }
    }

    return $result;
}

public function getProspectorGeneralRemarks($prospectorId)
{
    return $this->db->table('prospectors_remark_details')
        ->select('payment_description, remarks, created_by, create_date')
        ->where('prospectors_id', $prospectorId)
        ->groupStart()
            ->where('title', '')
            ->orWhere('title IS NULL')
        ->groupEnd()
        ->orderBy('create_date', 'DESC')
        ->get()
        ->getResultArray();
}

 public function getBookByProspectorAndId($prospector_id, $id)
{
    return $this->db->table('prospectors_book_details')
                    ->where('prospector_id', $prospector_id)
                    ->where('id', $id)
                    ->get()
                    ->getRowArray();
}

    public function updateBookByTitle($title, $data)
{
    $db = \Config\Database::connect(); // manually connect
    return $db->table('prospectors_book_details')
              ->where('title', $title)
              ->insert($data);
}
    public function insertRemarkDetails($data)
    {
        return $this->db->table('prospectors_remark_details')->insert($data);
    }
    public function getProspectByBookTitle($title)
{
    return $this->db->table('prospectors_book_details b')
        ->select('p.id, p.name')
        ->join('prospectors_details p', 'p.id = b.prospector_id', 'left')
        ->where('b.title', $title)
        ->get()
        ->getRowArray();
}
public function getPlansByProspectorAndId($prospector_id, $id)
{
    $builder = $this->db->table('prospectors_book_details');
    $builder->select('id, prospector_id, title, plan_name, payment_status, payment_amount, payment_date, create_date');
    $builder->where('prospector_id', $prospector_id);
    $builder->where('id', $id);
    $builder->groupStart()
            ->whereIn('LOWER(payment_status)', ['paid', 'partial'])
            ->groupEnd();
    $builder->orderBy('create_date', 'DESC');

    $plans = $builder->get()->getResultArray();

    foreach ($plans as &$plan) {
        $status = strtolower($plan['payment_status'] ?? '');
        if ($status === 'paid') {
            $plan['payment_status_text'] = 'Fully Paid';
        } elseif ($status === 'partial') {
            $plan['payment_status_text'] = 'Partial Payment';
        } else {
            $plan['payment_status_text'] = 'Unpaid';
        }
    }

    return $plans;
}

public function getRemarksByProspectorAndTitle($prospectorId, $title)
{
    $builder = $this->db->table('prospectors_remark_details');
    $builder->select('payment_description, des_date, remarks, create_date, created_by');
    $builder->where('prospectors_id', $prospectorId);
    $builder->where('title', $title);

    return $builder->get()->getResultArray();
}

public function getProspectNameById($prospectorId)
{
    $sql = "SELECT name FROM prospectors_details WHERE id = ?";
    $query = $this->db->query($sql, [$prospectorId]);
    $result = $query->getRowArray();

    return $result['name'] ?? 'N/A';
}


}
