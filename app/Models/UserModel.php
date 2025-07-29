<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
         $this->db = \Config\Database::connect();
    }

    // public function getDashboardData()
    // {
    //     $builder = $this->db->table('users_tbl');

    //     $builder->select("
    //         DATE(created_at) AS login_date,
    //         CASE
    //             WHEN email IS NOT NULL AND email != '' AND channel IS NOT NULL AND channel != '' THEN 'email_with_google'
    //             WHEN email IS NOT NULL AND email != '' AND (channel IS NULL OR channel = '') AND (otp IS NULL OR otp = '') THEN 'email_with_password'
    //             WHEN phone IS NOT NULL AND phone != '' AND otp IS NOT NULL AND otp != '' THEN 'mobile_with_otp'
    //             ELSE 'other'
    //         END AS login_type,
    //         COUNT(*) AS login_count
    //     ", false);

    //     $builder->where("created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)", null, false);
    //     $builder->groupBy(['login_date', 'login_type']);
    //     $builder->orderBy('login_date', 'DESC');

    //     $query = $builder->get();
    //     return $query->getResultArray();
    // }
    public function getUserDashboardData(): array
{
    $db = \Config\Database::connect();
    $result = [];

    // 1. User registration count per year (modified to group by year only)
    $builder = $db->table('users_tbl');
    $builder->select("COUNT(*) as cnt, YEAR(created_at) as year");
    $builder->groupBy("YEAR(created_at)");
    $builder->orderBy("year", "ASC");
    $query = $builder->get()->getResultArray();

    $user_registration_cnt = [];
    $years = [];
    foreach ($query as $row) {
        $user_registration_cnt[] = (int)$row['cnt'];
        $years[] = (string)$row['year'];
    }

    // Ensure we have at least the current year if no data exists
    if (empty($years)) {
        $currentYear = date('Y');
        $years = [$currentYear];
        $user_registration_cnt = [0];
    }

    $result['user_registration_cnt'] = $user_registration_cnt;
    $result['year'] = $years;

    // 2. Monthly registration (current month)
    $monthlyCount = $db->table('users_tbl')
        ->where('MONTH(created_at)', date('m'))
        ->where('YEAR(created_at)', date('Y'))
        ->countAllResults();
    $result['monthly_registration'] = $monthlyCount;

    // 3. Weekly registration (last 7 days)
    $weeklyCount = $db->table('users_tbl')
        ->where('created_at >=', date('Y-m-d 00:00:00', strtotime('-7 days')))
        ->countAllResults();
    $result['weekly_registration'] = $weeklyCount;

    // 4. Total registration
    $result['total_registration'] = $db->table('users_tbl')->countAllResults();

    // 5. Login users in last 7 days
    $sevenDaysAgo = date('Y-m-d 00:00:00', strtotime('-7 days'));
    $result['login_users'] = $db->table('users_tbl')
        ->select('user_id, username, email, phone, channel, user_type, otp, created_at')
        ->where('created_at >=', $sevenDaysAgo)
        ->orderBy('created_at', 'DESC')
        ->get()
        ->getResultArray();

    // 6. Login summary (simplified)
    $result['login_summary'] = $db->table('users_tbl')
        ->select("
            DATE(created_at) AS login_date,
            CASE 
                WHEN channel IS NOT NULL THEN 'email_with_google'
                WHEN email IS NOT NULL AND otp IS NULL THEN 'email_with_password'
                WHEN phone IS NOT NULL THEN 'mobile_with_otp'
                ELSE 'other'
            END AS login_type,
            COUNT(*) AS login_count", false)
        ->where('created_at >=', $sevenDaysAgo)
        ->groupBy(['login_date', 'login_type'])
        ->orderBy('login_date', 'DESC')
        ->get()
        ->getResultArray();

    // 7-10. Various user counts
    $result['users_with_address'] = $db->table('user_address')
        ->where("TRIM(shipping_address1) !=", "")
        ->countAllResults();

    $result['users_with_phone'] = $db->table('user_address')
        ->where("TRIM(billing_mobile_no) !=", "")
        ->countAllResults();

    $result['users_with_otp'] = $db->table('users_tbl')
        ->where("TRIM(otp) !=", "")
        ->countAllResults();

    $result['users_with_google'] = $db->table('users_tbl')
        ->where("TRIM(channel) !=", "")
        ->countAllResults();

    return $result;
}

public function getUserDetails($identifier)
{
    $db = \Config\Database::connect();

    // Detect whether identifier is email, phone or user_id
    $pos = strpos($identifier, '@');
    if ($pos === false) {
        if (preg_match('/^[0-9]{10}$/', $identifier)) {
            $sql = "SELECT username, email, user_id, user_type, otp, phone, password, channel, DATE_FORMAT(created_at, '%d-%m-%y') as date 
                    FROM users_tbl WHERE phone = ?";
        } else {
            $sql = "SELECT username, email, user_id, user_type, otp, phone, password, channel, DATE_FORMAT(created_at, '%d-%m-%y') as date 
                    FROM users_tbl WHERE user_id = ?";
        }
    }       else {
        $sql = "SELECT username, email, user_id, user_type, otp, phone, password, channel, DATE_FORMAT(created_at, '%d-%m-%y') as date 
                FROM users_tbl WHERE email = ?";
    }

    $query = $db->query($sql, [$identifier]);
    $tmp = $query->getResult();

    if ($query->getNumRows() == 0) {
        return [
            'user_name' => "--",
            'user_email' => "--",
            'user_id' => "--",
            'user_type' => "--",
            'user_join_date' => "--",
            'channel' => "--",
            'phone' => "--",
            // return empty arrays for other data for consistency
            'subscriptions' => [],
            'purchased_books' => [],
            'purchased_paperbacks' => [],
            'wallet_detail' => [],
            'transaction_detail' => [],
            'free_books' => [],
            'author_books' => [],
            'guest_books' => [],
        ];
    }

    $user = $tmp[0]; // object containing user data
    $userId = $user->user_id;

    // Determine login channel
    $channel = '';
    if (strlen($user->channel) == 0 || $user->channel == '1') {  
        if (strlen($user->phone) > 0 && strlen($user->otp) > 0 && $user->email == '' && $user->password == '') {
            $channel = 'Mobile/OTP'; 
        } elseif ($user->phone == '' && $user->otp == '' && strlen($user->email) > 0 && $user->password == '4732210395731ca375874a1e7c8f62f6') {
            $channel = 'Email/Password (default)';  
        } elseif ($user->phone == '' && $user->otp == '' && strlen($user->email) > 0 && $user->password != '4732210395731ca375874a1e7c8f62f6') {
            $channel = 'Email/Password (custom)';  
        } elseif (strlen($user->phone) > 0 && $user->otp == '' && strlen($user->email) > 0 && $user->password != '4732210395731ca375874a1e7c8f62f6') {
            $channel = 'Email/Password (custom)';  
        } elseif (strlen($user->phone) > 0 && strlen($user->otp) > 0 && strlen($user->email) > 0 && $user->password != '4732210395731ca375874a1e7c8f62f6') {
            $channel = 'Both (custom)';  
        } elseif (strlen($user->phone) > 0 && strlen($user->otp) > 0 && strlen($user->email) > 0 && $user->password == '4732210395731ca375874a1e7c8f62f6') {
            $channel = 'Both (default)';  
        } elseif (strlen($user->phone) > 0 && strlen($user->otp) > 0 && strlen($user->email) > 0) {
            $channel = 'Both (google)'; 
        } else {
            $channel = $user->channel;
        }
    } else {
        $channel = 'Email/Google';
    }

    $result = [
        'user_name' => $user->username,
        'user_email' => $user->email,
        'user_id' => $user->user_id,
        'user_type' => $user->user_type,
        'user_join_date' => $user->date,
        'phone' => $user->phone,
        'channel' => $channel,
    ];

    $sql = "SELECT 
		  subscription.order_id, 
		  DATE_FORMAT(subscription.date_inserted, '%Y-%m-%d') AS date, 
		  DATE_FORMAT(subscription.end_date, '%Y-%m-%d') AS end_date, 
		  subscription.total_books_applicable,
		  subscription.plan_type, 
		  plan_tbl.plan_name,
		  `order`.net_total  
	  FROM 
		  subscription
	  JOIN 
		  plan_tbl ON subscription.subscription_id = plan_tbl.plan_id
	  JOIN 
		  `order` ON subscription.order_id = `order`.order_id
	  WHERE 
		  subscription.user_id = ".$result['user_id'];	  
      	$query = $db->query($sql);
		$i = 0;
		$subscriptions = array();
    	foreach ($query->getResultArray() as $row)
    	{
			$subscription['date_subscribed'] = $row['date'];
			$subscription['end_subscribed'] = $row['end_date'];
			$subscription['total_books'] = $row['total_books_applicable'];
      		$subscription['order_id'] = $row['order_id']; 
			$subscription['plan_name'] = $row['plan_name'];
			$subscription['net_total'] = $row['net_total'];
			$subscription['plan_type'] = $row['plan_type'];

			
			$sql_book = "SELECT order_book_details.book_id, book_tbl.book_title, author_tbl.author_name, order_book_details.order_date 
             FROM order_book_details, book_tbl, author_tbl 
             WHERE author_tbl.author_id = order_book_details.author_id 
             AND book_tbl.book_id = order_book_details.book_id 
             AND order_id = ".$row['order_id'];

$query = $db->query($sql_book);

$j = 0;
$books = array();

foreach ($query->getResultArray() as $row)
{
    $book['book_id'] = $row['book_id'];
    $book['book_name'] = $row['book_title'];
    $book['author_name'] = $row['author_name'];
    $book['order_date'] = $row['order_date'];
    $books[$j] = $book;
    $j++;
}

$subscription['books'] = $books;
$subscriptions[$i] = $subscription;
$i++;
        }
        $result['subscriptions'] = $subscriptions;

		//purchased books
		$sql = "SELECT book_tbl.book_title, DATE_FORMAT(order_book_details.date_created, '%d-%m-%y') as date
						from book_tbl, order_book_details 
						where order_book_details.book_id = book_tbl.book_id 
						and order_book_details.order_type = 2 
						and order_book_details.user_id = ".$result['user_id'];
		$query = $db->query($sql);
		$i = 0;
		$purchased_books = array();
        foreach ($query->getResultArray() as $row)
        {
          	$purchased_book['purchased_book_title'] = $row['book_title'];
		  	$purchased_book['date_purchased'] = $row['date'];
		  	$purchased_books[$i] = $purchased_book;
          	$i++;
		}
		$result['purchased_books'] = $purchased_books;

		//purchased Paperback
		$sql = "SELECT book_tbl.book_title,pod_order_details.order_date, pod_order_details.book_id,pod_order_details.price,pod_order_details.quantity,
				pod_order.order_id,pod_order.tracking_id,pod_order.tracking_url
				FROM pod_order_details,book_tbl ,pod_order
				where pod_order_details.book_id=book_tbl.book_id and pod_order.order_id=pod_order_details.order_id
				and pod_order_details.user_id=".$result['user_id'];
		$query = $db->query($sql);
		$i = 0;
		$purchased_paperbacks = array();
		foreach ($query->getResultArray() as $row)
		{
  			$purchased_paperback['purchased_paperback_title'] = $row['book_title'];
  			$purchased_paperback['purchased_date'] = $row['order_date'];
  			$purchased_paperback['order_id'] = $row['order_id'];
  			$purchased_paperback['tracking_id'] = $row['tracking_id'];
  			$purchased_paperback['tracking_url'] = $row['tracking_url'];
			$purchased_paperback['book_id'] = $row['book_id'];
			$purchased_paperback['price'] = $row['price'];
			$purchased_paperback['quantity'] = $row['quantity'];
  			$purchased_paperbacks[$i] = $purchased_paperback;
  			$i++;
		}
		$result['purchased_paperbacks'] = $purchased_paperbacks;

		//wallet details
		$sql = "SELECT user_wallet.balance_inr as INR,user_wallet.balance_usd as USD,
			user_wallet.user_id as id,users_tbl.username as user
			FROM users_tbl,user_wallet where users_tbl.user_id = user_wallet.user_id 
			and user_wallet.user_id=".$result['user_id'];
		$query = $this->db->query($sql);
		$i = 0;
		$wallet_detail = array();
		foreach ($query->getResultArray() as $row)
		{
			$wallet['balance_inr'] = $row['INR'];
			$wallet['balance_usd'] = $row['USD'];
			$wallet_detail[$i] = $wallet;
			$i++;
		}
		$result['wallet_detail'] = $wallet_detail;

		$sql = "SELECT user_wallet_transaction.currency,user_wallet_transaction.date,user_wallet_transaction.amount, 
		        wallet_transaction_type.transaction_value 
				from user_wallet_transaction, wallet_transaction_type 
				where user_wallet_transaction.transaction_type=wallet_transaction_type.transaction_type 
				and user_wallet_transaction.user_id=".$result['user_id'];
		$query = $db->query($sql);
		$i = 0;
		$transaction_detail = array();
        foreach ($query->getResultArray() as $row)
        {
          $transaction['currency'] = $row['currency'];
		  $transaction['amount'] = $row['amount'];
		  $transaction['date'] = $row['date'];
		  $transaction['transaction_value'] = $row['transaction_value'];
		  $transaction_detail[$i] = $transaction;
          $i++;
		}
		$result['transaction_detail'] = $transaction_detail;

		//free books
		$sql = "SELECT book_tbl.book_title, DATE_FORMAT(free_book_subscription.date_subscribed, '%d-%m-%y') as date 
						from book_tbl, free_book_subscription 
						where free_book_subscription.book_id = book_tbl.book_id 
						and free_book_subscription.user_id = ".$result['user_id'];
		$query = $db->query($sql);
        $i = 0;
        $free_books = array();
        foreach ($query->getResultArray() as $row)
        {
          $free_book['free_book_title'] = $row['book_title'];
		  $free_book['date'] = $row['date'];
		  $free_books[$i] = $free_book;
          $i++;
		}
		$result['free_books'] = $free_books;
        
        //author gift books
        $sql = "SELECT author_tbl.author_name, book_tbl.book_title, DATE_FORMAT(author_gift_books.date, '%d-%m-%y') as date 
                        from author_tbl, author_gift_books, book_tbl
                        where author_gift_books.author_id = author_tbl.author_id 
                        and author_gift_books.book_id = book_tbl.book_id
						and author_gift_books.user_id = ".$result['user_id'];
        $query = $this->db->query($sql);
		$i = 0;
		$author_books = array();
        foreach ($query->getResultArray() as $row)
        {
          $author_book['author_name'] = $row['author_name'];
          $author_book['book_title'] = $row['book_title'];
		  $author_book['gift_date'] = $row['date'];
		  $author_books[$i] = $author_book;
		  $i++;
		}
		$result['author_books'] = $author_books;

        //devices
        $sql = "SELECT device_id1, device_info1, device_id2, device_info2, device_id3, device_info3 
                        FROM user_devices 
                        WHERE  user_id = ".$result['user_id'];
        $query = $db->query($sql);
        $tmp = $query->getResult();
		if (isset($tmp[0]->device_id1))
			$result['device_id1'] = $tmp[0]->device_id1;
		else
			$result['device_id1'] = "";
		if (isset($tmp[0]->device_info1))
			$result['device_info1'] = $tmp[0]->device_info1;
		else
			$result['device_info1'] = "";
		if (isset($tmp[0]->device_id2))
			$result['device_id2'] = $tmp[0]->device_id2;
		else
			$result['device_id2'] = "";
		if (isset($tmp[0]->device_info2))
			$result['device_info2'] = $tmp[0]->device_info2;
		else
			$result['device_info2'] = "";
		if (isset($tmp[0]->device_id3))
			$result['device_id3'] = $tmp[0]->device_id3;
		else
			$result['device_id3'] = "";
		if (isset($tmp[0]->device_info3))
			$result['device_info3'] = $tmp[0]->device_info3;
		else
			$result['device_info3'] = "";

        return $result;

	}

}

