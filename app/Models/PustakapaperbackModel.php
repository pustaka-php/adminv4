<?php

namespace App\Models;

use CodeIgniter\Model;

class PustakapaperbackModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    // ONLINE ORDERS 
    public function onlineProgressBooks()
    {
        $sql = "SELECT 
                    author_tbl.author_name as author_name,
                    pod_order.order_id as online_order_id,
                    book_tbl.book_title,
                    pod_order.user_id,
                    pod_order_details.book_id,
                    pod_order_details.quantity,
                    pod_order_details.order_date,
                    paperback_stock.quantity as qty,
                    paperback_stock.stock_in_hand,
                    paperback_stock.bookfair,
                    paperback_stock.bookfair2,
                    paperback_stock.bookfair3,
                    paperback_stock.bookfair4,
                    paperback_stock.bookfair5,
                    paperback_stock.lost_qty,
                    users_tbl.username,
                    users_tbl.city
                FROM 
                    pod_order
                JOIN users_tbl ON pod_order.user_id = users_tbl.user_id
                JOIN pod_order_details ON pod_order.user_id = pod_order_details.user_id
                    AND pod_order.order_id = pod_order_details.order_id
                JOIN book_tbl ON pod_order_details.book_id = book_tbl.book_id 
                JOIN author_tbl ON book_tbl.author_name = author_tbl.author_id 
                LEFT JOIN paperback_stock ON paperback_stock.book_id = pod_order_details.book_id 
                WHERE pod_order.user_id != 0 
                    AND pod_order_details.status = 0
                ORDER BY pod_order_details.order_date ASC";

        $query = $this->db->query($sql);
        $data['in_progress'] = $query->getResultArray();

        $sql = "SELECT 
                    author_tbl.author_name as author_name,
                    pod_order.order_id as online_order_id,
                    book_tbl.book_title,
                    pod_order.user_id,
                    pod_order_details.book_id,
                    pod_order_details.quantity,
                    pod_order_details.order_date,
                    pod_order_details.ship_date,
                    pod_order_details.tracking_url,
                    paperback_stock.stock_in_hand as total_quantity,
                    paperback_stock.bookfair,
                    users_tbl.username,
                    users_tbl.city
                FROM pod_order
                JOIN users_tbl ON pod_order.user_id = users_tbl.user_id
                JOIN pod_order_details ON pod_order.user_id = pod_order_details.user_id
                    AND pod_order.order_id = pod_order_details.order_id
                JOIN book_tbl ON pod_order_details.book_id = book_tbl.book_id 
                JOIN author_tbl ON book_tbl.author_name = author_tbl.author_id 
                LEFT JOIN paperback_stock ON paperback_stock.book_id = pod_order_details.book_id 
                WHERE pod_order.user_id != 0 
                    AND pod_order_details.status = 1
                    AND pod_order_details.ship_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                ORDER BY pod_order_details.order_date DESC";
        $query = $this->db->query($sql);
        $data['completed'] = $query->getResultArray();

        $sql = "SELECT 
                    author_tbl.author_name as author_name,
                    pod_order.order_id as online_order_id,
                    book_tbl.book_title,
                    pod_order.user_id,
                    pod_order_details.book_id,
                    pod_order_details.quantity,
                    pod_order_details.order_date,
                    pod_order_details.date,
                    paperback_stock.stock_in_hand as total_quantity,
                    paperback_stock.bookfair,
                    users_tbl.username,
                    users_tbl.city
                FROM pod_order
                JOIN users_tbl ON pod_order.user_id = users_tbl.user_id
                JOIN pod_order_details ON pod_order.user_id = pod_order_details.user_id
                    AND pod_order.order_id = pod_order_details.order_id
                JOIN book_tbl ON pod_order_details.book_id = book_tbl.book_id 
                JOIN author_tbl ON book_tbl.author_name = author_tbl.author_id 
                LEFT JOIN paperback_stock ON paperback_stock.book_id = pod_order_details.book_id 
                WHERE pod_order.user_id != 0 
                    AND pod_order_details.status = 2
                ORDER BY pod_order_details.date DESC";
        $query = $this->db->query($sql);
        $data['cancel'] = $query->getResultArray();

        $sql = "SELECT 
                    author_tbl.author_name as author_name,
                    pod_order.order_id as online_order_id,
                    book_tbl.book_title,
                    pod_order.user_id,
                    pod_order_details.book_id,
                    pod_order_details.quantity,
                    pod_order_details.order_date,
                    pod_order_details.ship_date,
                    pod_order_details.tracking_url,
                    paperback_stock.stock_in_hand as total_quantity,
                    paperback_stock.bookfair,
                    users_tbl.username,
                    users_tbl.city
                FROM pod_order
                JOIN users_tbl ON pod_order.user_id = users_tbl.user_id
                JOIN pod_order_details ON pod_order.user_id = pod_order_details.user_id
                    AND pod_order.order_id = pod_order_details.order_id
                JOIN book_tbl ON pod_order_details.book_id = book_tbl.book_id 
                JOIN author_tbl ON book_tbl.author_name = author_tbl.author_id 
                LEFT JOIN paperback_stock ON paperback_stock.book_id = pod_order_details.book_id 
                WHERE pod_order.user_id != 0 
                    AND pod_order_details.status = 1
                ORDER BY pod_order_details.order_date DESC";
        $query = $this->db->query($sql);
        $data['completed_all'] = $query->getResultArray();

        return $data;
    }

    // MARK SHIPPED 
    public function onlineMarkShipped()
    {
        $request = service('request');
        $book_id = $request->getPost('book_id');
        $online_order_id = $request->getPost('order_id');
        $tracking_id = $request->getPost('tracking_id');
        $tracking_url = $request->getPost('tracking_url');

        $select_online_order_id = "SELECT quantity FROM pod_order_details WHERE book_id = ? AND order_id = ?";
        $tmp = $this->db->query($select_online_order_id, [$book_id, $online_order_id]);
        $record = $tmp->getRowArray();

        $qty = $record['quantity'];

        $update_sql = "UPDATE paperback_stock SET quantity = quantity - ?, stock_in_hand = stock_in_hand - ? WHERE book_id = ?";
        $this->db->query($update_sql, [$qty, $qty, $book_id]);

        $update_data = [
            "status" => 1,
            "ship_date" => date('Y-m-d H:i:s'),
            "tracking_id" => $tracking_id,
            "tracking_url" => $tracking_url,
        ];
        $builder = $this->db->table('pod_order_details');
        $builder->where(['order_id' => $online_order_id, 'book_id' => $book_id]);
        $builder->update($update_data);

        // insert into ledger
        $stock_sql = "SELECT pod_order_details.*, book_tbl.*, pod_order_details.quantity as quantity,
                      paperback_stock.quantity as current_stock
                      FROM pod_order_details, book_tbl, paperback_stock
                      WHERE pod_order_details.book_id = book_tbl.book_id
                      AND paperback_stock.book_id = pod_order_details.book_id
                      AND book_tbl.book_id = ? AND pod_order_details.order_id = ?";
        $temp = $this->db->query($stock_sql, [$book_id, $online_order_id]);
        $stock = $temp->getRowArray();

        $stock_data = [
            'book_id' => $book_id,
            'order_id' => $stock['order_id'],
            'author_id' => $stock['author_name'],
            'copyright_owner' => $stock['paper_back_copyright_owner'],
            'description' => "Online Sales",
            'channel_type' => "ONL",
            'stock_out' => $stock['quantity'],
            'transaction_date' => date('Y-m-d H:i:s'),
        ];
        $this->db->table('pustaka_paperback_stock_ledger')->insert($stock_data);

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    // MARK CANCEL 
    public function onlineMarkCancel()
    {
        $request = service('request');
        $online_order_id = $request->getPost('online_order_id');
        $book_id = $request->getPost('book_id');

        $update_data = [
            "status" => 2,
            "date" => date('Y-m-d'),
        ];
        $builder = $this->db->table('pod_order_details');
        $builder->where(['order_id' => $online_order_id, 'book_id' => $book_id]);
        $builder->update($update_data);

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    // ORDER SHIP
    public function onlineOrdership($online_order_id, $book_id)
    {
        $sql = "SELECT * 
                FROM pod_order_details 
                WHERE order_id = ? AND book_id = ?";
        $query = $this->db->query($sql, [$online_order_id, $book_id]);
        return $query->getRowArray();
    }

    //  BULK ORDERS 
    public function getOnlinebulkOrdersdetails($bulk_order_id)
    {
        $sql = "SELECT 
                    author_tbl.author_name as author_name,
                    pod_order.order_id as online_order_id,
                    book_tbl.book_title,
                    pod_order.user_id,
                    pod_order_details.book_id,
                    pod_order_details.quantity,
                    pod_order_details.order_date,
                    paperback_stock.quantity as qty,
                    paperback_stock.stock_in_hand,
                    paperback_stock.bookfair,
                    paperback_stock.bookfair2,
                    paperback_stock.bookfair3,
                    paperback_stock.bookfair4,
                    paperback_stock.bookfair5,
                    paperback_stock.lost_qty,
                    users_tbl.username,
                    users_tbl.city,
                    pod_order_details.price
                FROM pod_order
                JOIN users_tbl ON pod_order.user_id = users_tbl.user_id
                JOIN pod_order_details ON pod_order.user_id = pod_order_details.user_id
                    AND pod_order.order_id = pod_order_details.order_id
                JOIN book_tbl ON pod_order_details.book_id = book_tbl.book_id 
                JOIN author_tbl ON book_tbl.author_name = author_tbl.author_id 
                LEFT JOIN paperback_stock ON paperback_stock.book_id = pod_order_details.book_id 
                WHERE pod_order.user_id != 0 
                    AND pod_order_details.status = 0
                    AND pod_order.order_id = ?";
        $query = $this->db->query($sql, [$bulk_order_id]);
        return $query->getResultArray();
    }

    public function onlineBulkOrdershipment($online_order_id, $book_ids, $tracking_id, $tracking_url)
    {
        foreach ($book_ids as $book_id) {
            $select_offline_order_id = "SELECT quantity FROM pod_order_details WHERE book_id = ? AND order_id = ?";
            $tmp = $this->db->query($select_offline_order_id, [$book_id, $online_order_id]);

            if ($tmp->getNumRows() == 0) {
                continue;
            }

            $record = $tmp->getRowArray();
            $qty = $record['quantity'];

            $update_sql = "UPDATE paperback_stock SET quantity = quantity - ?, stock_in_hand = stock_in_hand - ? WHERE book_id = ?";
            $this->db->query($update_sql, [$qty, $qty, $book_id]);

            $update_data = [
                "status" => 1,
                "tracking_id" => $tracking_id,
                "tracking_url" => $tracking_url,
                "ship_date" => date('Y-m-d'),
            ];
            $this->db->table('pod_order_details')->where(['order_id' => $online_order_id, 'book_id' => $book_id])->update($update_data);

            $stock_sql = "SELECT pod_order_details.*, book_tbl.*, pod_order_details.quantity as quantity,
                          paperback_stock.quantity as current_stock
                          FROM pod_order_details, book_tbl, paperback_stock
                          WHERE pod_order_details.book_id = book_tbl.book_id
                          AND paperback_stock.book_id = pod_order_details.book_id
                          AND book_tbl.book_id = ? AND pod_order_details.order_id = ?";
            $temp = $this->db->query($stock_sql, [$book_id, $online_order_id]);

            if ($temp->getNumRows() == 0) {
                continue;
            }

            $stock = $temp->getRowArray();

            $stock_data = [
                'book_id' => $stock['book_id'],
                'order_id' => $stock['order_id'],
                'author_id' => $stock['author_name'],
                'copyright_owner' => $stock['paper_back_copyright_owner'],
                'description' => "Online Sales",
                'channel_type' => "ONL",
                'stock_out' => $stock['quantity'],
                'transaction_date' => date('Y-m-d H:i:s'),
            ];
            $this->db->table('pustaka_paperback_stock_ledger')->insert($stock_data);
        }

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }
    public function onlineOrderdetails($order_id)
    {
        // Get order + user info
        $sql = "SELECT 
                    users_tbl.username,
                    user_address.*,
                    pod_order.order_id,
                    pod_order.shipping_charges,
                    pod_order_details.order_date,
                    pod_order_details.tracking_url,
                    pod_order_details.tracking_id,
                    pod_order_details.ship_date
                FROM 
                    users_tbl
                JOIN user_address ON user_address.user_id = users_tbl.user_id
                JOIN pod_order ON pod_order.user_id = users_tbl.user_id
                JOIN pod_order_details ON pod_order_details.order_id = pod_order.order_id
                WHERE 
                    pod_order.order_id = ?";
        $query = $this->db->query($sql, [$order_id]);
        $data['details'] = $query->getRowArray();

        // Get books in the order
        $sql = "SELECT 
                    pod_order_details.*, 
                    book_tbl.book_title, 
                    author_tbl.author_name, 
                    book_tbl.paper_back_inr,
                    paperback_stock.stock_in_hand AS total_quantity,
                    paperback_stock.bookfair
                FROM 
                    pod_order
                JOIN pod_order_details ON pod_order_details.order_id = pod_order.order_id
                JOIN book_tbl ON book_tbl.book_id = pod_order_details.book_id
                JOIN author_tbl ON author_tbl.author_id = book_tbl.author_name
                LEFT JOIN paperback_stock ON paperback_stock.book_id = book_tbl.book_id
                WHERE 
                    pod_order.order_id = ?";
        $query = $this->db->query($sql, [$order_id]);
        $data['list'] = $query->getResultArray();

        return $data;
    }
    // Offline orders
    public function offlinePaperbackBooks()
    {
        $sql = "SELECT book_tbl.book_id, book_tbl.book_title, book_tbl.regional_book_title,
                    book_tbl.paper_back_pages as number_of_page, book_tbl.paper_back_inr, 
                    author_tbl.author_name
                FROM book_tbl, author_tbl 
                WHERE author_tbl.author_id = book_tbl.author_name
                AND book_tbl.paper_back_flag = 1";

        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function offlineSelectedBooksList($selected_book_list)
    {
        $sql = "SELECT 
                    book_tbl.book_id AS bookID, 
                    book_tbl.book_title, 
                    book_tbl.regional_book_title,
                    book_tbl.paper_back_readiness_flag,
                    book_tbl.paper_back_pages as number_of_page, 
                    book_tbl.paper_back_inr, 
                    author_tbl.author_name, 
                    author_tbl.author_id,
                    paperback_stock.*,
                    (SELECT SUM(quantity) FROM pustaka_paperback_books WHERE book_id = book_tbl.book_id AND completed_flag = 0) AS Qty,
                    CASE 
                        WHEN indesign_processing.book_id = book_tbl.book_id AND indesign_processing.completed_flag = 0 THEN 'In Processing'
                        ELSE 'Not Processing'
                    END AS indesign_status
                FROM 
                    book_tbl
                JOIN 
                    author_tbl ON author_tbl.author_id = book_tbl.author_name
                LEFT JOIN 
                    paperback_stock ON paperback_stock.book_id = book_tbl.book_id
                LEFT JOIN 
                    indesign_processing ON indesign_processing.book_id = book_tbl.book_id
                WHERE 
                    book_tbl.paper_back_flag = 1
                    AND book_tbl.book_id IN ($selected_book_list)";

        $query = $this->db->query($sql);
                
        return $query->getResultArray();   
    }
    
    public function offlineOrderbooksDetailsSubmit()
    {
        $request = \Config\Services::request(); 
        $num_of_books = $request->getPost('num_of_books');
        
        
        $order_id = time();
        $data = [
            'order_id'       => $order_id,
            'customer_name'  => trim($request->getPost('customer_name')),
            'payment_type'   => trim($request->getPost('payment_type')),
            'payment_status' => trim($request->getPost('payment_status')),
            'courier_charges'=> trim($request->getPost('courier_charges')),
            'address'        => trim($request->getPost('address')),
            'mobile_no'      => trim($request->getPost('mobile_no')),
            'ship_date'      => $request->getPost('ship_date'),
            'order_date'     => date('Y-m-d H:i:s'),
            'city'           => trim($request->getPost('city')),
        ];
        $this->db->table('pustaka_offline_orders')->insert($data);

        for ($i = 0; $i < $num_of_books; $i++) {
            $tmp  = 'book_id' . $i;
            $tmp1 = 'bk_qty' . $i;
            $tmp2 = 'book_dis' . $i;
            $tmp3 = 'tot_amt' . $i;

            $book_id  = $request->getPost($tmp);
            $book_qty = $request->getPost($tmp1);
            $book_dis = $request->getPost($tmp2);
            $tot_amt  = $request->getPost($tmp3);
             
            $data = [
                'offline_order_id' => $order_id,
                'book_id'          => $book_id,
                'quantity'         => $book_qty,
                'discount'         => $book_dis,
                'total_amount'     => $tot_amt,
                'ship_date'        => $request->getPost('ship_date'),
            ];

            $this->db->table('pustaka_offline_orders_details')->insert($data);
        }
    }

     public function offlineProgressBooks()
    {
        $data = [];

        // ---------------- IN PROGRESS ----------------
        $sql = "SELECT
                    author_tbl.author_name as author_name,
                    pustaka_offline_orders_details.quantity,
                    pustaka_offline_orders_details.ship_date,
                    pustaka_offline_orders_details.offline_order_id,
                    book_tbl.book_id,
                    book_tbl.book_title,
                    paperback_stock.quantity as qty,
                    paperback_stock.stock_in_hand,
                    paperback_stock.bookfair,
                    paperback_stock.bookfair2,
                    paperback_stock.bookfair3,
                    paperback_stock.bookfair4,
                    paperback_stock.bookfair5,
                    paperback_stock.lost_qty,
                    pustaka_offline_orders.*
                FROM
                    pustaka_offline_orders_details
                JOIN pustaka_offline_orders 
                    ON pustaka_offline_orders_details.offline_order_id=pustaka_offline_orders.order_id
                JOIN book_tbl 
                    ON pustaka_offline_orders_details.book_id = book_tbl.book_id
                JOIN author_tbl 
                    ON book_tbl.author_name = author_tbl.author_id
                LEFT JOIN paperback_stock 
                    ON paperback_stock.book_id = book_tbl.book_id
                WHERE pustaka_offline_orders_details.ship_status = 0
                ORDER BY pustaka_offline_orders_details.ship_date ASC";

        $query = $this->db->query($sql);
        $data['in_progress'] = $query->getResultArray();


        // ---------------- COMPLETED ----------------
        $sql = "SELECT
                    author_tbl.author_name AS author_name,
                    pustaka_offline_orders_details.quantity,
                    pustaka_offline_orders_details.ship_date AS shipped_date,
                    pustaka_offline_orders_details.offline_order_id,
                    pustaka_offline_orders_details.tracking_url AS url,
                    book_tbl.book_id,
                    book_tbl.book_title,
                    paperback_stock.stock_in_hand AS total_quantity,
                    paperback_stock.bookfair,
                    pustaka_offline_orders.*,
                    pustaka_offline_orders_details.ship_status
                FROM
                    pustaka_offline_orders_details
                JOIN pustaka_offline_orders 
                    ON pustaka_offline_orders_details.offline_order_id = pustaka_offline_orders.order_id
                JOIN book_tbl 
                    ON pustaka_offline_orders_details.book_id = book_tbl.book_id
                JOIN author_tbl 
                    ON book_tbl.author_name = author_tbl.author_id 
                LEFT JOIN paperback_stock 
                    ON paperback_stock.book_id = book_tbl.book_id
                WHERE
                    (pustaka_offline_orders_details.ship_status = 1 
                     AND pustaka_offline_orders_details.ship_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY))
                    OR (pustaka_offline_orders_details.ship_status = 1 
                        AND pustaka_offline_orders.payment_status = 'Pending')
                ORDER BY pustaka_offline_orders_details.ship_date DESC";

        $query = $this->db->query($sql);
        $data['completed'] = $query->getResultArray();


        // ---------------- CANCEL ----------------
        $sql = "SELECT
                    author_tbl.author_name as author_name,
                    pustaka_offline_orders_details.quantity,
                    pustaka_offline_orders_details.date,
                    pustaka_offline_orders_details.offline_order_id,
                    book_tbl.book_id,
                    book_tbl.book_title,
                    paperback_stock.stock_in_hand as total_quantity,
                    paperback_stock.bookfair,
                    pustaka_offline_orders.*
                FROM
                    pustaka_offline_orders_details
                JOIN pustaka_offline_orders 
                    ON pustaka_offline_orders_details.offline_order_id=pustaka_offline_orders.order_id
                JOIN book_tbl 
                    ON pustaka_offline_orders_details.book_id = book_tbl.book_id
                JOIN author_tbl 
                    ON book_tbl.author_name = author_tbl.author_id
                LEFT JOIN paperback_stock 
                    ON paperback_stock.book_id = book_tbl.book_id
                WHERE pustaka_offline_orders_details.ship_status = 2
                ORDER BY pustaka_offline_orders_details.date DESC";

        $query = $this->db->query($sql);
        $data['cancel'] = $query->getResultArray();


        // ---------------- RETURN ----------------
        $sql = "SELECT
                    author_tbl.author_name as author_name,
                    pustaka_offline_orders_details.quantity,
                    pustaka_offline_orders_details.date,
                    pustaka_offline_orders_details.offline_order_id,
                    book_tbl.book_id,
                    book_tbl.book_title,
                    paperback_stock.stock_in_hand as total_quantity,
                    paperback_stock.bookfair,
                    pustaka_offline_orders.*
                FROM
                    pustaka_offline_orders_details
                JOIN pustaka_offline_orders 
                    ON pustaka_offline_orders_details.offline_order_id=pustaka_offline_orders.order_id
                JOIN book_tbl 
                    ON pustaka_offline_orders_details.book_id = book_tbl.book_id
                JOIN author_tbl 
                    ON book_tbl.author_name = author_tbl.author_id
                LEFT JOIN paperback_stock 
                    ON paperback_stock.book_id = book_tbl.book_id
                WHERE pustaka_offline_orders_details.ship_status = 3
                ORDER BY pustaka_offline_orders_details.date DESC";

        $query = $this->db->query($sql);
        $data['return'] = $query->getResultArray();


        // ---------------- COMPLETED ALL ----------------
        $sql = "SELECT
                    author_tbl.author_name as author_name,
                    pustaka_offline_orders_details.quantity,
                    pustaka_offline_orders_details.ship_date as shipped_date,
                    pustaka_offline_orders_details.offline_order_id,
                    pustaka_offline_orders_details.tracking_url as url,
                    book_tbl.book_id,
                    book_tbl.book_title,
                    paperback_stock.stock_in_hand as total_quantity,
                    paperback_stock.bookfair,
                    pustaka_offline_orders.*
                FROM
                    pustaka_offline_orders_details
                JOIN pustaka_offline_orders 
                    ON pustaka_offline_orders_details.offline_order_id=pustaka_offline_orders.order_id
                JOIN book_tbl 
                    ON pustaka_offline_orders_details.book_id = book_tbl.book_id
                JOIN author_tbl 
                    ON book_tbl.author_name = author_tbl.author_id
                LEFT JOIN paperback_stock 
                    ON paperback_stock.book_id = book_tbl.book_id
                WHERE pustaka_offline_orders_details.ship_status = 1
                ORDER BY pustaka_offline_orders_details.ship_date DESC";

        $query = $this->db->query($sql);
        $data['completed_all'] = $query->getResultArray();

        return $data;
    }
    public function offlineOrderShip($offline_order_id, $book_id)
    {
        $sql = "SELECT * 
                FROM pustaka_offline_orders_details 
                WHERE offline_order_id = ? AND book_id = ?";
        $query = $this->db->query($sql, [$offline_order_id, $book_id]);
        return $query->getRowArray();
    }

    function offlineMarkShipped()
    {
        $request = \Config\Services::request();
        $offline_order_id = $request->getPost('offline_order_id');
        $book_id = $request->getPost('book_id');
        $tracking_id = $request->getPost('tracking_id');
        $tracking_url = $request->getPost('tracking_url');

        $select_offline_order_id = "SELECT quantity from pustaka_offline_orders_details WHERE book_id = $book_id AND offline_order_id = $offline_order_id";
        $tmp = $this->db->query($select_offline_order_id);
        $record = $tmp->getResultArray()[0];

        $qty = $record['quantity'];

        $update_sql = "UPDATE paperback_stock set quantity = quantity - " . $qty . ",stock_in_hand = stock_in_hand - " . $qty . " where book_id = " . $book_id;
        $tmp = $this->db->query($update_sql);

        $update_data = array(
            "ship_status" => 1,
            "tracking_id" => $tracking_id,
            "tracking_url" => $tracking_url,
            "ship_date" => date('Y-m-d'), //shipped date 
        );
        $this->db->table('pustaka_offline_orders_details')
            ->where(array('offline_order_id' => $offline_order_id, 'book_id' => $book_id))
            ->update($update_data);

        // inserting the record into pustaka_paperback_stock_ledger table 
        $stock_sql = "SELECT pustaka_offline_orders_details.*,book_tbl.* ,pustaka_offline_orders_details.quantity as quantity,
                    paperback_stock.quantity as current_stock
                    from pustaka_offline_orders_details,book_tbl,paperback_stock
                    where pustaka_offline_orders_details.book_id=book_tbl.book_id
                    and paperback_stock.book_id=pustaka_offline_orders_details.book_id
                    and book_tbl.book_id = " . $book_id . " AND pustaka_offline_orders_details.offline_order_id = '" . $offline_order_id . "'";
        $temp = $this->db->query($stock_sql);
        $stock = $temp->getResultArray()[0];

        $book_id = $stock['book_id'];
        $offline_order_id = $stock['offline_order_id'];
        $author_id = $stock['author_name'];
        $copyright_owner = $stock['paper_back_copyright_owner'];
        $description = "Offline Sales";
        $channel_type = "OFF";
        $stock_out = $stock['quantity'];

        $stock_data = array(
            'book_id' => $book_id,
            "order_id" => $offline_order_id,
            "author_id" => $author_id,
            "copyright_owner" => $copyright_owner,
            "description" => $description,
            "channel_type" => $channel_type,
            "stock_out" => $stock_out,
            'transaction_date' => date('Y-m-d H:i:s'),
        );
        $this->db->table('pustaka_paperback_stock_ledger')->insert($stock_data);

        if ($this->db->affectedRows() > 0)
            return 1;
        else
            return 0;
    }

    function offlineMarkCancel()
    {
        $request = \Config\Services::request();
        $update_data = array(
            "ship_status" => 2,
            "date" => date('Y-m-d'),
        );
        $offline_order_id = $request->getPost('offline_order_id');
        $book_id = $request->getPost('book_id');

        $this->db->table('pustaka_offline_orders_details')
            ->where(array('offline_order_id' => $offline_order_id, 'book_id' => $book_id))
            ->update($update_data);

        if ($this->db->affectedRows() > 0)
            return 1;
        else
            return 0;
    }

    function offlineMarkPay()
    {
        $request = \Config\Services::request();
        $offline_order_id = $request->getPost('offline_order_id');

        $update_data = array(
            "payment_status" => trim('Paid'),
        );

        $this->db->table('pustaka_offline_orders')
            ->where(array('order_id' => $offline_order_id))
            ->update($update_data);

        if ($this->db->affectedRows() > 0)
            return 1;
        else
            return 0;
    }

    function offlineMarkReturn()
    {
        $request = \Config\Services::request();
        $offline_order_id = $request->getPost('offline_order_id');
        $book_id = $request->getPost('book_id');

        $select_offline_order_id = "SELECT quantity from pustaka_offline_orders_details WHERE book_id = $book_id AND offline_order_id = $offline_order_id";
        $tmp = $this->db->query($select_offline_order_id);
        $record = $tmp->getResultArray()[0];

        $qty = $record['quantity'];

        $update_sql = "UPDATE paperback_stock set quantity = quantity + " . $qty . ",stock_in_hand = stock_in_hand + " . $qty . " where book_id = " . $book_id;
        $tmp = $this->db->query($update_sql);

        $update_data = array(
            "ship_status" => 3,
            "date" => date('Y-m-d'),
        );
        $this->db->table('pustaka_offline_orders_details')
            ->where(array('offline_order_id' => $offline_order_id, 'book_id' => $book_id))
            ->update($update_data);

        // inserting the record into pustaka_paperback_stock_ledger table 
        $stock_sql = "SELECT pustaka_offline_orders_details.*,book_tbl.* ,pustaka_offline_orders_details.quantity as quantity,
                    paperback_stock.quantity as current_stock
                    from pustaka_offline_orders_details,book_tbl,paperback_stock
                    where pustaka_offline_orders_details.book_id=book_tbl.book_id
                    and paperback_stock.book_id=pustaka_offline_orders_details.book_id
                    and book_tbl.book_id = " . $book_id . " AND pustaka_offline_orders_details.offline_order_id = '" . $offline_order_id . "'";
        $temp = $this->db->query($stock_sql);
        $stock = $temp->getResultArray()[0];

        $book_id = $stock['book_id'];
        $offline_order_id = $stock['offline_order_id'];
        $author_id = $stock['author_name'];
        $copyright_owner = $stock['paper_back_copyright_owner'];
        $description = "Offline Return";
        $channel_type = "OFF";
        $stock_in = $stock['quantity'];
        $current_stock = $stock['current_stock'];

        $stock_data = array(
            'book_id' => $book_id,
            "order_id" => $offline_order_id,
            "author_id" => $author_id,
            "copyright_owner" => $copyright_owner,
            "description" => $description,
            "stock_in" => $stock_in,
            "channel_type" => $channel_type,
            'transaction_date' => date('Y-m-d H:i:s'),
        );
        $this->db->table('pustaka_paperback_stock_ledger')->insert($stock_data);

        if ($this->db->affectedRows() > 0)
            return 1;
        else
            return 0;
    }

    public function offlineOrderDetails($order_id)
    {
        // First query
        $sql = "SELECT pustaka_offline_orders.*,
                    pustaka_offline_orders_details.tracking_id,
                    pustaka_offline_orders_details.tracking_url
                FROM pustaka_offline_orders
                JOIN pustaka_offline_orders_details 
                    ON pustaka_offline_orders_details.offline_order_id = pustaka_offline_orders.order_id
                WHERE order_id = ?";
        $query = $this->db->query($sql, [$order_id]);
        $data['details'] = $query->getResultArray()[0] ?? [];

        // Second query
        $sql = "SELECT pustaka_offline_orders_details.*,
                    book_tbl.book_title,
                    author_tbl.author_name,
                    book_tbl.paper_back_inr,
                    book_tbl.paper_back_isbn,
                    pustaka_offline_orders.courier_charges
                FROM pustaka_offline_orders
                JOIN pustaka_offline_orders_details 
                    ON pustaka_offline_orders.order_id = pustaka_offline_orders_details.offline_order_id
                JOIN book_tbl 
                    ON book_tbl.book_id = pustaka_offline_orders_details.book_id
                JOIN author_tbl 
                    ON author_tbl.author_id = book_tbl.author_name
                WHERE pustaka_offline_orders.order_id = ?";
        $query = $this->db->query($sql, [$order_id]);
        $data['list'] = $query->getResultArray();

        return $data;
    }

    public function getBulkOrdersDetails($bulk_order_id)
    {
        $sql = "SELECT
                    author_tbl.author_name as author_name,
                    pustaka_offline_orders_details.*,
                    book_tbl.book_id,
                    book_tbl.book_title,
                    paperback_stock.quantity as qty,
                    paperback_stock.stock_in_hand,
                    paperback_stock.bookfair,
                    paperback_stock.bookfair2,
                    paperback_stock.bookfair3,
                    paperback_stock.bookfair4,
                    paperback_stock.bookfair5,
                    paperback_stock.lost_qty,
                    pustaka_offline_orders.*
                FROM
                    pustaka_offline_orders_details
                JOIN
                    pustaka_offline_orders ON pustaka_offline_orders_details.offline_order_id = pustaka_offline_orders.order_id
                JOIN
                    book_tbl ON pustaka_offline_orders_details.book_id = book_tbl.book_id
                JOIN
                    author_tbl ON book_tbl.author_name = author_tbl.author_id
                LEFT JOIN
                    paperback_stock ON paperback_stock.book_id = book_tbl.book_id
                WHERE
                    pustaka_offline_orders_details.ship_status = 0 
                    AND pustaka_offline_orders_details.offline_order_id = ?
                ORDER BY
                    pustaka_offline_orders_details.ship_date ASC";

        $query = $this->db->query($sql, [$bulk_order_id]);
        return $query->getResultArray();
    }
     public function bulkOrderShipment($offline_order_id, $book_ids, $tracking_id, $tracking_url)
    {
        foreach ($book_ids as $book_id) {
            // Fetch the quantity for the given book_id and offline_order_id
            $select_sql = "SELECT quantity FROM pustaka_offline_orders_details 
                           WHERE book_id = ? AND offline_order_id = ?";
            $tmp = $this->db->query($select_sql, [$book_id, $offline_order_id]);

            if ($tmp->getNumRows() == 0) {
                continue; // Skip if no record found
            }

            $record = $tmp->getRowArray();
            $qty = $record['quantity'];

            // Update the paperback_stock table
            $update_sql = "UPDATE paperback_stock 
                           SET quantity = quantity - ?, stock_in_hand = stock_in_hand - ? 
                           WHERE book_id = ?";
            $this->db->query($update_sql, [$qty, $qty, $book_id]);

            // Update the shipment details in pustaka_offline_orders_details table
            $update_data = [
                "ship_status"   => 1,
                "tracking_id"   => $tracking_id,
                "tracking_url"  => $tracking_url,
                "ship_date"     => date('Y-m-d'),
            ];

            $this->db->table('pustaka_offline_orders_details')
                     ->where(['offline_order_id' => $offline_order_id, 'book_id' => $book_id])
                     ->update($update_data);

            // Fetching data to insert into pustaka_paperback_stock_ledger table
            $stock_sql = "SELECT pod.*, book_tbl.*, 
                                 pod.quantity as quantity,
                                 paperback_stock.quantity as current_stock
                          FROM pustaka_offline_orders_details pod
                          JOIN book_tbl ON pod.book_id = book_tbl.book_id
                          JOIN paperback_stock ON paperback_stock.book_id = pod.book_id
                          WHERE book_tbl.book_id = ? AND pod.offline_order_id = ?";
            $temp = $this->db->query($stock_sql, [$book_id, $offline_order_id]);

            if ($temp->getNumRows() == 0) {
                continue; // Skip if no record found
            }

            $stock = $temp->getRowArray();

            // Prepare data for the ledger
            $stock_data = [
                'book_id'        => $stock['book_id'],
                'order_id'       => $stock['offline_order_id'],
                'author_id'      => $stock['author_name'],
                'copyright_owner'=> $stock['paper_back_copyright_owner'],
                'description'    => "Offline Sales",
                'channel_type'   => "OFF",
                'stock_out'      => $stock['quantity'],
                'transaction_date' => date('Y-m-d H:i:s'),
            ];

            // Insert data into the ledger
            $this->db->table('pustaka_paperback_stock_ledger')->insert($stock_data);
        }

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }
    public function paperbackLedgerDetails()
    {
        $uri = service('uri');
        $db = \Config\Database::connect();

        $book_id = $uri->getSegment(3);

        $sql = "SELECT 
                    book_tbl.book_id,
                    book_tbl.book_title,
                    book_tbl.regional_book_title,
                    book_tbl.paper_back_inr,
                    book_tbl.paper_back_copyright_owner,
                    author_tbl.author_name,
                    author_tbl.author_id,
                    paperback_stock.*
                FROM 
                    book_tbl
                JOIN 
                    author_tbl ON book_tbl.author_name = author_tbl.author_id
                LEFT JOIN 
                    paperback_stock ON book_tbl.book_id = paperback_stock.book_id
                WHERE 
                    book_tbl.book_id = $book_id";
        $query = $db->query($sql);
        $data['books'] = $query->getResultArray()[0] ?? [];

        $sql = "SELECT 
                    pustaka_paperback_stock_ledger.transaction_date,
                    pustaka_paperback_stock_ledger.*
                FROM 
                    pustaka_paperback_stock_ledger
                WHERE 
                    pustaka_paperback_stock_ledger.book_id = $book_id
                ORDER BY 
                    pustaka_paperback_stock_ledger.transaction_date ASC";
        $query = $db->query($sql);
        $data['list'] = $query->getResultArray();

        $sql = "SELECT 
                    author_transaction.order_date,
                    author_transaction.book_final_royalty_value_inr,
                    author_transaction.comments
                FROM 
                    author_transaction
                WHERE 
                    author_transaction.book_id = $book_id 
                    AND author_transaction.order_type = 15
                ORDER BY 
                    author_transaction.order_date ASC";
        $query = $db->query($sql);
        $data['author'] = $query->getResultArray();

        $sql = "SELECT 
                    author_transaction.order_date,
                    author_transaction.order_id,
                    author_transaction.book_final_royalty_value_inr,
                    author_transaction.comments,
                    author_transaction.order_type,
                    CASE 
                        WHEN author_transaction.order_type = 7 THEN 'Online'
                        WHEN author_transaction.order_type = 9 THEN 'Book Fair'
                        WHEN author_transaction.order_type = 10 THEN 'Offline'
                        WHEN author_transaction.order_type = 11 THEN 'Amazon'
                        WHEN author_transaction.order_type = 12 THEN 'Flipkart'
                        WHEN author_transaction.order_type = 14 THEN 'Book Seller'
                    END AS channel
                FROM 
                    author_transaction
                WHERE 
                    author_transaction.book_id = $book_id
                    AND author_transaction.order_type IN (7, 9, 10, 11, 12, 14) 
                ORDER BY 
                    author_transaction.order_date ASC";
        $query = $db->query($sql);
        $data['old_details'] = $query->getResultArray();

        $sql = "SELECT 
                    author_transaction.order_date,
                    author_transaction.order_id,
                    author_transaction.comments,
                    author_transaction.order_type,
                    pod_bookfair.*
                FROM 
                    author_transaction
                JOIN 
                    pod_bookfair ON pod_bookfair.order_id = author_transaction.order_id
                WHERE 
                    pod_bookfair.book_id = $book_id";
        $query = $db->query($sql);
        $data['book_fair'] = $query->getResultArray();

        return $data;
    }
    public function getBooksStock($book_id)
    {
        $db = db_connect(); 
        $sql = "SELECT book_tbl.*, author_tbl.author_name, author_tbl.author_id
                FROM book_tbl, author_tbl
                WHERE book_tbl.author_name = author_tbl.author_id
                AND book_tbl.book_id = ?";

        $query = $db->query($sql, [$book_id]);
        return $query->getRowArray(); 
    }
    public function updateQuantity()
    {
        $updateData = [
            'book_id'     => $this->request->getPost('book_id'),
            'quantity'    => $this->request->getPost('quantity'),
            'order_id'    => time(),
            'order_date'  => date('Y-m-d H:i:s'),
        ];

        $builder = $this->db->table('pustaka_paperback_books');
        $builder->insert($updateData);

        if ($this->db->affectedRows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    public function getInitiatePrintStatus()
    {
        // Not Started
        $sql = "SELECT pustaka_paperback_books.*, book_tbl.book_title, author_tbl.author_name
                FROM pustaka_paperback_books, book_tbl, author_tbl
                WHERE author_tbl.author_id = book_tbl.author_name
                AND pustaka_paperback_books.book_id = book_tbl.book_id
                AND pustaka_paperback_books.start_flag = 0
                ORDER BY pustaka_paperback_books.order_date ASC";
        $query = $this->db->query($sql);
        $data['book_not_start'] = $query->getResultArray();

        // In Progress
        $sql = "SELECT 
                    pustaka_paperback_books.*, 
                    pustaka_paperback_books.book_id AS book_ID,
                    book_tbl.book_title, 
                    book_tbl.url_name, 
                    author_tbl.author_name,
                    indesign_processing.re_completed_flag,
                    indesign_processing.rework_flag
                FROM 
                    pustaka_paperback_books
                JOIN 
                    book_tbl ON pustaka_paperback_books.book_id = book_tbl.book_id
                JOIN 
                    author_tbl ON author_tbl.author_id = book_tbl.author_name
                LEFT JOIN 
                    indesign_processing ON pustaka_paperback_books.book_id = indesign_processing.book_id
                WHERE 
                    pustaka_paperback_books.start_flag = 1 
                    AND pustaka_paperback_books.completed_flag = 0
                ORDER BY 
                    pustaka_paperback_books.order_date ASC";
        $query = $this->db->query($sql);
        $data['in_progress'] = $query->getResultArray();

        // Completed (last 30 days)
        $sql = "SELECT
                    pustaka_paperback_books.*,
                    book_tbl.book_title,
                    author_tbl.author_name
                FROM
                    pustaka_paperback_books,
                    book_tbl,
                    author_tbl
                WHERE
                    author_tbl.author_id = book_tbl.author_name
                    AND pustaka_paperback_books.book_id = book_tbl.book_id
                    AND pustaka_paperback_books.start_flag = 1
                    AND pustaka_paperback_books.completed_flag = 1
                    AND pustaka_paperback_books.completed_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                ORDER BY
                    pustaka_paperback_books.completed_date DESC";
        $query = $this->db->query($sql);
        $data['completed'] = $query->getResultArray();

        // All Completed
        $sql = "SELECT
                    pustaka_paperback_books.*,
                    book_tbl.book_title,
                    author_tbl.author_name
                FROM
                    pustaka_paperback_books,
                    book_tbl,
                    author_tbl
                WHERE
                    author_tbl.author_id = book_tbl.author_name
                    AND pustaka_paperback_books.book_id = book_tbl.book_id
                    AND pustaka_paperback_books.start_flag = 1
                    AND pustaka_paperback_books.completed_flag = 1
                ORDER BY
                    pustaka_paperback_books.completed_date DESC";
        $query = $this->db->query($sql);
        $data['completed_all'] = $query->getResultArray();

        return $data;
    }
    public function getPaperbackBooks()
    {
        $db = db_connect();
        $sql = "SELECT book_tbl.book_id, book_tbl.book_title, book_tbl.regional_book_title,
                    book_tbl.paper_back_pages AS number_of_page, book_tbl.paper_back_inr, author_tbl.author_name
                FROM book_tbl, author_tbl 
                WHERE author_tbl.author_id = book_tbl.author_name
                AND book_tbl.paper_back_flag = 1";
        
        $query = $db->query($sql);
        $data['paperback_book'] = $query->getResultArray();
        return $data;
    }
    public function getPaperbackSelectedBooksList($selected_book_list)
    {
        $db = db_connect();
        $sql = "SELECT 
                    book_tbl.book_id,
                    book_tbl.book_title,
                    book_tbl.regional_book_title,
                    book_tbl.paper_back_pages AS number_of_page,
                    book_tbl.paper_back_inr,
                    author_tbl.author_name,
                    (SELECT SUM(quantity) 
                    FROM pustaka_paperback_books 
                    WHERE book_id = book_tbl.book_id 
                    AND completed_flag = 0) AS Qty
                FROM 
                    book_tbl
                JOIN 
                    author_tbl ON author_tbl.author_id = book_tbl.author_name
                WHERE 
                    book_tbl.paper_back_flag = 1
                    AND book_tbl.book_id IN ($selected_book_list)";

        $query = $db->query($sql);

        return $query->getResultArray();
    }
    public function uploadQuantityList()
    {
        

        $type = $_POST['type'];
        $num_of_books = $_POST['num_of_books'];

        $book_ids = array();
        $book_qtys = array();
        $bk_purposes = array();

        for ($i = 1; $i <= $num_of_books; $i++) {
            $tmp = 'book_id' . $i;
            $tmp1 = 'bk_qty' . $i;
            $book_ids[$i] = $_POST[$tmp];
            $book_qtys[$i] = $_POST[$tmp1];
        }

        if ($type == 'Initiate_print') {
            for ($i = 1; $i <= $num_of_books; $i++) {
                if ($book_qtys[$i] > 0) {
                    $data = array(
                        'book_id' => $book_ids[$i],
                        'quantity' => $book_qtys[$i],
                        'order_id' => time(),
                        'order_date' => date('Y-m-d H:i:s'),
                    );
                    $db->table('pustaka_paperback_books')->insert($data);
                }
            }
        } elseif ($type == 'Free_books') {
            for ($i = 1; $i <= $num_of_books; $i++) {
                $tmp2 = 'bk_purpose' . $i;
                $bk_purposes[$i] = $_POST[$tmp2];
            }
            for ($i = 1; $i <= $num_of_books; $i++) {
                if ($book_qtys[$i] > 0) {
                    $data = array(
                        'book_id' => $book_ids[$i],
                        'quantity' => $book_qtys[$i],
                        'purpose' => $bk_purposes[$i],
                        'order_id' => time(),
                        'order_date' => date('Y-m-d H:i:s'),
                        'type' => $_POST['print_type'],
                    );
                    $db->table('free_books_paperback')->insert($data);
                }
            }
        }

        if ($db->affectedRows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    public function editInitiatePrint()
    {
        $id = service('uri')->getSegment(3);

        $sql = "SELECT pustaka_paperback_books.*, book_tbl.book_title 
                FROM book_tbl, pustaka_paperback_books 
                WHERE book_tbl.book_id = pustaka_paperback_books.book_id 
                AND pustaka_paperback_books.id = $id";

        $query = $db->query($sql);

        return $query->getResultArray()[0];
    }
    public function editQuantity()
    {
        $id = $_POST['id'];
        $update_data = array(
            'id' => $_POST['id'],
            'quantity' => $_POST['quantity'],
        );

        $db->table('pustaka_paperback_books')
        ->where('id', $id)
        ->update($update_data);

        if ($db->affectedRows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    public function deleteInitiatePrint()
    {
        $id = $_POST['id'];
        $update_data = array(
            'id' => $_POST['id'],
        );

        $db->table('pustaka_paperback_books')
        ->where('id', $id)
        ->delete($update_data);

        if ($db->affectedRows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    public function markStart()
    {
        $id   = $this->request->getPost('id');
        $type = $this->request->getPost('type');

        if ($type == 'Initiate_print') {
            $update_data = ["start_flag" => 1];
            $this->db->table('pustaka_paperback_books')->where('id', $id)->update($update_data);
        } else if ($type == 'Free_books') {
            $update_data = ["start_flag" => 1];
            $this->db->table('free_books_paperback')->where('id', $id)->update($update_data);
        }

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function markCoverComplete()
    {
        $id   = $this->request->getPost('id');
        $type = $this->request->getPost('type');

        if ($type == 'Initiate_print') {
            $update_data = ["cover_flag" => 1];
            $this->db->table('pustaka_paperback_books')->where('id', $id)->update($update_data);
        } else if ($type == 'Free_books') {
            $update_data = ["cover_flag" => 1];
            $this->db->table('free_books_paperback')->where('id', $id)->update($update_data);
        }

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function markContentComplete()
    {
        $id   = $this->request->getPost('id');
        $type = $this->request->getPost('type');

        if ($type == 'Initiate_print') {
            $update_data = ["content_flag" => 1];
            $this->db->table('pustaka_paperback_books')->where('id', $id)->update($update_data);
        } else if ($type == 'Free_books') {
            $update_data = ["content_flag" => 1];
            $this->db->table('free_books_paperback')->where('id', $id)->update($update_data);
        }

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function markLaminationComplete()
    {
        $id   = $this->request->getPost('id');
        $type = $this->request->getPost('type');

        if ($type == 'Initiate_print') {
            $update_data = ["lamination_flag" => 1];
            $this->db->table('pustaka_paperback_books')->where('id', $id)->update($update_data);
        } else if ($type == 'Free_books') {
            $update_data = ["lamination_flag" => 1];
            $this->db->table('free_books_paperback')->where('id', $id)->update($update_data);
        }

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function markBindingComplete()
    {
        $id   = $this->request->getPost('id');
        $type = $this->request->getPost('type');

        if ($type == 'Initiate_print') {
            $update_data = ["binding_flag" => 1];
            $this->db->table('pustaka_paperback_books')->where('id', $id)->update($update_data);
        } else if ($type == 'Free_books') {
            $update_data = ["binding_flag" => 1];
            $this->db->table('free_books_paperback')->where('id', $id)->update($update_data);
        }

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function markFinalcutComplete()
    {
        $id   = $this->request->getPost('id');
        $type = $this->request->getPost('type');

        if ($type == 'Initiate_print') {
            $update_data = ["finalcut_flag" => 1];
            $this->db->table('pustaka_paperback_books')->where('id', $id)->update($update_data);
        } else if ($type == 'Free_books') {
            $update_data = ["finalcut_flag" => 1];
            $this->db->table('free_books_paperback')->where('id', $id)->update($update_data);
        }

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function markQcComplete()
    {
        $id   = $this->request->getPost('id');
        $type = $this->request->getPost('type');

        if ($type == 'Initiate_print') {
            $update_data = ["qc_flag" => 1];
            $this->db->table('pustaka_paperback_books')->where('id', $id)->update($update_data);
        } else if ($type == 'Free_books') {
            $update_data = ["qc_flag" => 1];
            $this->db->table('free_books_paperback')->where('id', $id)->update($update_data);
        }

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function markCompleted()
    {
        $id = $this->request->getPost('id');

        $select_quantity = "SELECT quantity, order_id, book_id FROM pustaka_paperback_books WHERE id=".$id;
        $tmp    = $this->db->query($select_quantity);
        $record = $tmp->getResultArray()[0];

        $qty     = $record['quantity'];
        $book_id = $record['book_id'];

        $update_data = [
            "cover_flag"      => 1,
            "content_flag"    => 1,
            "lamination_flag" => 1,
            "binding_flag"    => 1,
            "finalcut_flag"   => 1,
            "qc_flag"         => 1,
            "completed_flag"  => 1,
            "completed_date"  => date('Y-m-d H:i:s')
        ];

        $this->db->table('pustaka_paperback_books')->where('id', $id)->update($update_data);

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

}
