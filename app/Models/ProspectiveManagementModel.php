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

    // Save remark and flag info
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

    if (!$old) {
        return false;
    }

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
        'payment_description' => $request->getPost('payment_description'),
        'email_sent_flag'     => $request->getPost('email_sent_flag'),
        'initial_call_flag'   => $request->getPost('initial_call_flag'),
        'email_sent_date'     => $request->getPost('email_sent_date'),
        'initial_call_date'   => $request->getPost('initial_call_date'),
        'prospectors_status'  => $request->getPost('prospectors_status') ?? 0,
    ];

    $data['last_update_date'] = date('Y-m-d H:i:s');

    $hasChanges = false;
    foreach ($data as $key => $value) {
        $oldVal = array_key_exists($key, $old) ? $old[$key] : null;
        if ((string)$oldVal !== (string)$value) {
            $hasChanges = true;
            break;
        }
    }

    //Update only if something changed
    if ($hasChanges) {
        $builder->where('id', $id)->update($data);
    }

    //Collect remarks and descriptions
    $remarks = trim($request->getPost('remarks'));
    $payment_description = trim($request->getPost('payment_description'));

    $finalRemark = '';
    $finalPayDesc = '';
    $createDate = null;
    $desDate = null;

    // --- PLAN CHANGE CHECK ---
if ($old['recommended_plan'] != $data['recommended_plan']) {
    $planChangeText = "Plan: {$old['recommended_plan']} → {$data['recommended_plan']}";
    $finalRemark = !empty($remarks)
        ? $remarks . ' | ' . $planChangeText
        : $planChangeText;
    $createDate = date('Y-m-d H:i:s');
} elseif (!empty($remarks)) {
    $finalRemark = $remarks;
    $createDate = date('Y-m-d H:i:s');
}

// --- PAYMENT CHANGES ---
$changeMessages = [];

// Payment amount change
if ($old['payment_amount'] != $data['payment_amount']) {
    $changeMessages[] = "Amt: ₹{$old['payment_amount']} → ₹{$data['payment_amount']}";
}

// Payment status change
if ($old['payment_status'] != $data['payment_status']) {
    $changeMessages[] = "Status: {$old['payment_status']} → {$data['payment_status']}";
}

// Combine payment_description + changes
if (!empty($changeMessages)) {
    $combinedChanges = implode(' | ', $changeMessages);
    $finalPayDesc = !empty($payment_description)
        ? $payment_description . ' | ' . $combinedChanges
        : $combinedChanges;
    $desDate = date('Y-m-d H:i:s');
} elseif (!empty($payment_description)) {
    $finalPayDesc = $payment_description;
    $desDate = date('Y-m-d H:i:s');
}
    //Only insert if something new exists
    if (!empty($finalRemark) || !empty($finalPayDesc)) {
        $remarkData = [
            'prospectors_id'      => $id,
            'remarks'             => $finalRemark ?: null,
            'payment_description' => $finalPayDesc ?: null,
            'create_date'         => $createDate,
            'des_date'            => $desDate,
            'created_by'          => session()->get('username') ?? 'System',
        ];

        $db->table('prospectors_remark_details')->insert($remarkData);
    }

    return $hasChanges ? true : 0;
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

    foreach ($plans as $plan) {
        $count = $db->table('prospectors_details')
            ->where('recommended_plan', $plan)
            ->where('prospectors_status', 1) 
            ->countAllResults();

        $result[$plan] = $count;
        $total += $count;
    }

    $result['totalPlans'] = $total;

    return $result;
}

public function getPaymentSummary()
{
    $db = \Config\Database::connect();

    $data = [];

    // Total Revenue (Closed Prospects Only)
    $data['totalRevenue'] = $db->table('prospectors_details')
        ->selectSum('payment_amount')
        ->where('prospectors_status', 1)
        ->get()
        ->getRow()
        ->payment_amount ?? 0;

    // Paid
    $data['paidTotal'] = $db->table('prospectors_details')
        ->selectSum('payment_amount')
        ->where('payment_status', 'paid')
        ->where('prospectors_status', 1)
        ->get()
        ->getRow()
        ->payment_amount ?? 0;

    // Pending
    $data['pendingTotal'] = $db->table('prospectors_details')
        ->selectSum('payment_amount')
        ->where('payment_status', 'pending')
        ->where('prospectors_status', 1)
        ->get()
        ->getRow()
        ->payment_amount ?? 0;

    // Partial
    $data['partialTotal'] = $db->table('prospectors_details')
        ->selectSum('payment_amount')
        ->where('payment_status', 'partial')
        ->where('prospectors_status', 1)
        ->get()
        ->getRow()
        ->payment_amount ?? 0;

    return $data;
}


}
