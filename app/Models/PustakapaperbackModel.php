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
    // amazon
    public function getAmazonPaperbackOrder()
    {
        $amazon_paperback_sql = "SELECT book_tbl.url_name as url, amazon_paperback_books.*, book_tbl.*, author_tbl.* 
                                FROM amazon_paperback_books, book_tbl, author_tbl
                                WHERE amazon_paperback_books.book_id = book_tbl.book_id 
                                AND amazon_paperback_books.author_id = author_tbl.author_id";
        $amazon_paperback_query = $this->db->query($amazon_paperback_sql);
        return $amazon_paperback_query->getResultArray();
    }

    public function getAmazonSelectedBooksList($selected_book_list)
    {
        $sql = "SELECT book_tbl.url_name as url, amazon_paperback_books.*, book_tbl.*, author_tbl.*
                FROM amazon_paperback_books, book_tbl, author_tbl 
                WHERE amazon_paperback_books.book_id = book_tbl.book_id
                AND amazon_paperback_books.author_id = author_tbl.author_id 
                AND amazon_paperback_books.book_id IN ($selected_book_list)";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getAmazonStockDetails($selected_book_list)
    {
        $sql = "SELECT
                    book_tbl.book_id AS bookID,
                    book_tbl.url_name AS url,
                    amazon_paperback_books.*,
                    book_tbl.*,
                    author_tbl.*,
                    paperback_stock.*,
                    (SELECT SUM(quantity) FROM pustaka_paperback_books 
                        WHERE book_id = book_tbl.book_id AND completed_flag = 0) AS Qty
                FROM amazon_paperback_books
                LEFT JOIN book_tbl ON amazon_paperback_books.book_id = book_tbl.book_id
                LEFT JOIN author_tbl ON amazon_paperback_books.author_id = author_tbl.author_id
                LEFT JOIN paperback_stock ON amazon_paperback_books.book_id = paperback_stock.book_id
                WHERE amazon_paperback_books.book_id IN ($selected_book_list)";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function amazonOrderbooksDetailsSubmit($num_of_books)
    {
        $j = 0;
        $book_ids = [];
        $book_qtys = [];

        for ($i = 1; $i <= $num_of_books; $i++) {
            $tmp = 'book_id' . $j;
            $tmp1 = 'quantity_details' . $j++;
            $book_ids[$i] = $_POST[$tmp];
            $book_qtys[$i] = $_POST[$tmp1];
        }

        for ($i = 1; $i <= $num_of_books; $i++) {
            $data = [
                'book_id' => $book_ids[$i],
                'quantity' => $book_qtys[$i],
                'amazon_order_id' => trim($_POST['order_id']),
                'shipping_type' => trim($_POST['ship_type']),
                'ship_date' => $_POST['ship_date'],
                'order_date' => date('Y-m-d H:i:s'),
            ];

            $builder = $this->db->table('amazon_paperback_orders');
            $builder->insert($data);
        }
    }

    public function amazonInProgressBooks()
    {
        $data = [];

        $sql = "SELECT 
                    author_tbl.author_name AS author_name,
                    amazon_paperback_orders.amazon_order_id,
                    amazon_paperback_orders.quantity,
                    amazon_paperback_orders.ship_date,
                    book_tbl.book_id,
                    book_tbl.book_title,
                    paperback_stock.quantity AS qty,
                    paperback_stock.stock_in_hand,
                    paperback_stock.bookfair,
                    paperback_stock.bookfair2,
                    paperback_stock.bookfair3,
                    paperback_stock.bookfair4,
                    paperback_stock.bookfair5,
                    paperback_stock.lost_qty
                FROM amazon_paperback_orders
                JOIN book_tbl ON amazon_paperback_orders.book_id = book_tbl.book_id
                JOIN author_tbl ON book_tbl.author_name = author_tbl.author_id
                LEFT JOIN paperback_stock ON paperback_stock.book_id = book_tbl.book_id
                WHERE amazon_paperback_orders.ship_status = 0
                ORDER BY amazon_paperback_orders.ship_date ASC";
        $query = $this->db->query($sql);
        $data['in_progress'] = $query->getResultArray();

        $sql = "SELECT 
                    author_tbl.author_name AS author_name,
                    amazon_paperback_orders.amazon_order_id,
                    amazon_paperback_orders.quantity,
                    amazon_paperback_orders.ship_date,
                    book_tbl.book_id,
                    book_tbl.book_title,
                    paperback_stock.stock_in_hand AS total_quantity,
                    paperback_stock.bookfair
                FROM amazon_paperback_orders
                JOIN book_tbl ON amazon_paperback_orders.book_id = book_tbl.book_id
                JOIN author_tbl ON book_tbl.author_name = author_tbl.author_id
                LEFT JOIN paperback_stock ON paperback_stock.book_id = book_tbl.book_id
                WHERE amazon_paperback_orders.ship_status = 1
                  AND amazon_paperback_orders.ship_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                ORDER BY amazon_paperback_orders.ship_date DESC";
        $query = $this->db->query($sql);
        $data['completed'] = $query->getResultArray();

        $sql = "SELECT 
                    author_tbl.author_name AS author_name,
                    amazon_paperback_orders.amazon_order_id,
                    amazon_paperback_orders.quantity,
                    amazon_paperback_orders.date,
                    book_tbl.book_id,
                    book_tbl.book_title,
                    paperback_stock.stock_in_hand AS total_quantity,
                    paperback_stock.bookfair
                FROM amazon_paperback_orders
                JOIN book_tbl ON amazon_paperback_orders.book_id = book_tbl.book_id
                JOIN author_tbl ON book_tbl.author_name = author_tbl.author_id
                LEFT JOIN paperback_stock ON paperback_stock.book_id = book_tbl.book_id
                WHERE amazon_paperback_orders.ship_status = 2
                ORDER BY amazon_paperback_orders.date DESC";
        $query = $this->db->query($sql);
        $data['cancel'] = $query->getResultArray();

        $sql = "SELECT 
                    author_tbl.author_name AS author_name,
                    amazon_paperback_orders.amazon_order_id,
                    amazon_paperback_orders.quantity,
                    amazon_paperback_orders.date,
                    book_tbl.book_id,
                    book_tbl.book_title,
                    paperback_stock.stock_in_hand AS total_quantity,
                    paperback_stock.bookfair
                FROM amazon_paperback_orders
                JOIN book_tbl ON amazon_paperback_orders.book_id = book_tbl.book_id
                JOIN author_tbl ON book_tbl.author_name = author_tbl.author_id
                LEFT JOIN paperback_stock ON paperback_stock.book_id = book_tbl.book_id
                WHERE amazon_paperback_orders.ship_status = 3
                ORDER BY amazon_paperback_orders.date DESC";
        $query = $this->db->query($sql);
        $data['return'] = $query->getResultArray();

        $sql = "SELECT 
                    author_tbl.author_name AS author_name,
                    amazon_paperback_orders.amazon_order_id,
                    amazon_paperback_orders.quantity,
                    amazon_paperback_orders.ship_date,
                    book_tbl.book_id,
                    book_tbl.book_title,
                    paperback_stock.stock_in_hand AS total_quantity,
                    paperback_stock.bookfair
                FROM amazon_paperback_orders
                JOIN book_tbl ON amazon_paperback_orders.book_id = book_tbl.book_id
                JOIN author_tbl ON book_tbl.author_name = author_tbl.author_id
                LEFT JOIN paperback_stock ON paperback_stock.book_id = book_tbl.book_id
                WHERE amazon_paperback_orders.ship_status = 1
                ORDER BY amazon_paperback_orders.ship_date DESC";
        $query = $this->db->query($sql);
        $data['completed_all'] = $query->getResultArray();

        return $data;
    }

    public function markShipped()
    {
        $amazon_order_id = $_POST['amazon_order_id'];
        $book_id = $_POST['book_id'];

        $select_amazon_order_id = "SELECT quantity FROM amazon_paperback_orders  
                                   WHERE book_id = $book_id 
                                   AND amazon_order_id = '$amazon_order_id'";
        $tmp = $this->db->query($select_amazon_order_id);
        $record = $tmp->getResultArray()[0];
        $qty = $record['quantity'];

        $update_sql = "UPDATE paperback_stock 
                       SET quantity = quantity - $qty,
                           stock_in_hand = stock_in_hand - $qty 
                       WHERE book_id = $book_id";
        $this->db->query($update_sql);

        $builder = $this->db->table('amazon_paperback_orders');
        $builder->where(['amazon_order_id' => $amazon_order_id, 'book_id' => $book_id])
                ->update(['ship_status' => 1]);

        $stock_sql = "SELECT amazon_paperback_orders.*, book_tbl.*, amazon_paperback_orders.quantity AS quantity,
                             paperback_stock.quantity AS current_stock
                      FROM amazon_paperback_orders, book_tbl, paperback_stock
                      WHERE amazon_paperback_orders.book_id = book_tbl.book_id
                      AND paperback_stock.book_id = amazon_paperback_orders.book_id
                      AND book_tbl.book_id = $book_id 
                      AND amazon_paperback_orders.amazon_order_id = '$amazon_order_id'";
        $temp = $this->db->query($stock_sql);
        $stock = $temp->getResultArray()[0];

        $stock_data = [
            'book_id' => $stock['book_id'],
            'order_id' => $stock['amazon_order_id'],
            'author_id' => $stock['author_name'],
            'copyright_owner' => $stock['paper_back_copyright_owner'],
            'description' => "Amazon Sales",
            'channel_type' => "AMZ",
            'stock_out' => $stock['quantity'],
            'transaction_date' => date('Y-m-d H:i:s'),
        ];
        $this->db->table('pustaka_paperback_stock_ledger')->insert($stock_data);

        return $this->db->affectedRows() > 0 ? 1 : 0;
    }

    public function markCancel()
    {
        $update_data = [
            "ship_status" => 2,
            "date" => date('Y-m-d'),
        ];
        $amazon_order_id = $_POST['amazon_order_id'];
        $book_id = $_POST['book_id'];

        $this->db->table('amazon_paperback_orders')
                 ->where(['amazon_order_id' => $amazon_order_id, 'book_id' => $book_id])
                 ->update($update_data);

        return $this->db->affectedRows() > 0 ? 1 : 0;
    }

    public function markReturn()
    {
        $amazon_order_id = $_POST['amazon_order_id'];
        $book_id = $_POST['book_id'];

        $select_amazon_order_id = "SELECT quantity FROM amazon_paperback_orders  
                                   WHERE book_id = $book_id 
                                   AND amazon_order_id = '$amazon_order_id'";
        $tmp = $this->db->query($select_amazon_order_id);
        $record = $tmp->getResultArray()[0];
        $qty = $record['quantity'];

        $update_sql = "UPDATE paperback_stock 
                       SET quantity = quantity + $qty,
                           stock_in_hand = stock_in_hand + $qty 
                       WHERE book_id = $book_id";
        $this->db->query($update_sql);

        $update_data = [
            "ship_status" => 3,
            "date" => date('Y-m-d'),
        ];
        $this->db->table('amazon_paperback_orders')
                 ->where(['amazon_order_id' => $amazon_order_id, 'book_id' => $book_id])
                 ->update($update_data);

        $stock_sql = "SELECT amazon_paperback_orders.*, book_tbl.*, amazon_paperback_orders.quantity AS quantity,
                             paperback_stock.quantity AS current_stock
                      FROM amazon_paperback_orders, book_tbl, paperback_stock
                      WHERE amazon_paperback_orders.book_id = book_tbl.book_id
                      AND paperback_stock.book_id = amazon_paperback_orders.book_id
                      AND book_tbl.book_id = $book_id 
                      AND amazon_paperback_orders.amazon_order_id = '$amazon_order_id'";
        $temp = $this->db->query($stock_sql);
        $stock = $temp->getResultArray()[0];

        $stock_data = [
            'book_id' => $stock['book_id'],
            'order_id' => $stock['amazon_order_id'],
            'author_id' => $stock['author_name'],
            'copyright_owner' => $stock['paper_back_copyright_owner'],
            'description' => "Amazon Return",
            'stock_in' => $stock['quantity'],
            'channel_type' => "AMZ",
            'transaction_date' => date('Y-m-d H:i:s'),
        ];
        $this->db->table('pustaka_paperback_stock_ledger')->insert($stock_data);

        return $this->db->affectedRows() > 0 ? 1 : 0;
    }
    public function amazonOrderDetails($order_id)
    {
        $db = \Config\Database::connect();

        // First query: Single order
        $sql1 = "SELECT * FROM amazon_paperback_orders WHERE amazon_order_id = ?";
        $query1 = $db->query($sql1, [$order_id]);
        $order = $query1->getResultArray()[0] ?? [];

        // Second query: Order with joins
        $sql2 = "SELECT amazon_paperback_orders.*, book_tbl.book_title,
                        author_tbl.author_name, book_tbl.paper_back_inr, book_tbl.regional_book_title
                 FROM amazon_paperback_orders, book_tbl, author_tbl
                 WHERE book_tbl.book_id = amazon_paperback_orders.book_id
                 AND author_tbl.author_id = book_tbl.author_name
                 AND amazon_paperback_orders.amazon_order_id = ?";
        $query2 = $db->query($sql2, [$order_id]);
        $details = $query2->getResultArray();

        return [
            'order'   => $order,
            'details' => $details
        ];
    }
    //authors order//
    public function getAuthorList()
    {
        $sql = "SELECT DISTINCT(author_tbl.author_name), author_tbl.author_id
                FROM book_tbl, author_tbl 
                WHERE book_tbl.status=1 
                AND book_tbl.paper_back_flag=1 
                AND book_tbl.author_name=author_tbl.author_id 
                AND book_tbl.type_of_book=1"; 
        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function getAuthorBooksList($authorId)
    {
        $sql = "SELECT book_tbl.book_id, book_tbl.book_title, book_tbl.regional_book_title,
                    author_tbl.author_name, book_tbl.language AS language_name, book_tbl.url_name, 
                    CASE 
                        WHEN book_tbl.status = 0 THEN 'Inactive'
                        WHEN book_tbl.status = 1 THEN 'Active'
                        WHEN book_tbl.status = 2 THEN 'CANCELLED'
                        ELSE 'Invalid'
                    END AS bk_status, 
                    book_tbl.paper_back_inr, book_tbl.paper_back_pages, book_tbl.paper_back_weight 
                FROM book_tbl, author_tbl 
                WHERE book_tbl.author_name=$authorId 
                AND book_tbl.paper_back_flag=1 
                AND book_tbl.paper_back_inr>0 
                AND book_tbl.author_name=author_tbl.author_id"; 
        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function getSelectedBooksList($selectedBookList)
    {
        $sql = "SELECT book_tbl.book_id, book_tbl.book_title, book_tbl.regional_book_title,
                    author_tbl.author_name, book_tbl.language AS language_name, book_tbl.url_name, 
                    CASE 
                        WHEN book_tbl.status = 0 THEN 'Inactive'
                        WHEN book_tbl.status = 1 THEN 'Active'
                        WHEN book_tbl.status = 2 THEN 'CANCELLED'
                        ELSE 'Invalid'
                    END AS bk_status, 
                    book_tbl.paper_back_inr, book_tbl.paper_back_pages, book_tbl.paper_back_weight, 
                    book_tbl.paper_back_copyright_owner   
                FROM book_tbl, author_tbl 
                WHERE book_tbl.paper_back_flag=1 
                AND book_tbl.author_name=author_tbl.author_id 
                AND book_tbl.paper_back_inr>0 
                AND book_tbl.book_id IN ($selectedBookList)"; 
        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function getAuthorAddress($authorId)
    {
        $sql = "SELECT * FROM author_tbl WHERE author_tbl.author_id=$authorId LIMIT 1"; 
        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function authorOrderBooksDetailsSubmit()
    {
        $numOfBooks = $_POST['num_of_books'];
        $orderId = time();

        $data = [
            'order_id' => $orderId,
            'author_id' => $_POST['author_id'],
            'user_id' => $_POST['user_id'],
            'ship_date' => $_POST['ship_date'],
            'order_date' => date('Y-m-d H:i:s'),
            'order_status' => 0,
            'payment_status' => trim($_POST['payment_status']),
            'billing_name' => trim($_POST['bill_name']),
            'billing_address' => trim($_POST['bill_addr']),
            'bill_mobile' => trim($_POST['bill_mobile']),
            'bill_email' => trim($_POST['bill_email']),
            'ship_name' => trim($_POST['ship_name']),
            'ship_address' => trim($_POST['ship_addr']),
            'ship_mobile' => trim($_POST['ship_mobile']),
            'ship_email' => trim($_POST['ship_email']),
            'sub_total' => $_POST['sub_total'],
        ];
        $this->db->table('pod_author_order')->insert($data);

        for ($i = 0; $i < $numOfBooks; $i++) {
            $bookId = $_POST['bk_id' . $i];
            $bookQty = $_POST['bk_qty' . $i];
            $bookDis = $_POST['bk_discount' . $i];
            $totAmt  = $_POST['tot_amt' . $i];

            $data = [
                'order_id' => $orderId,
                'user_id' => $_POST['user_id'],
                'author_id' => $_POST['author_id'],
                'book_id' => $bookId,
                'quantity' => $bookQty,
                'discount' => $bookDis,
                'price' => $totAmt,
                'ship_date' => $_POST['ship_date'],
                'order_date' => date('Y-m-d H:i:s'),
            ];

            $this->db->table('pod_author_order_details')->insert($data);
        }
    }

    public function getAuthorOrderDetails()
    {
        $sql="SELECT pod_author_order_details.*, author_tbl.author_name, book_tbl.book_title
              FROM pod_author_order_details
              LEFT JOIN author_tbl ON author_tbl.author_id=pod_author_order_details.author_id
              JOIN book_tbl ON pod_author_order_details.book_id=book_tbl.book_id
              WHERE pod_author_order_details.status=0 AND pod_author_order_details.start_flag=0 
              ORDER BY pod_author_order_details.ship_date DESC";
        $query = $this->db->query($sql);
        $data['books'] = $query->getResultArray();

        $sql="SELECT pod_author_order_details.*, author_tbl.author_name, book_tbl.book_title, book_tbl.url_name, indesign_processing.rework_flag
              FROM pod_author_order_details
              LEFT JOIN author_tbl ON author_tbl.author_id=pod_author_order_details.author_id
              JOIN book_tbl ON pod_author_order_details.book_id=book_tbl.book_id
              LEFT JOIN indesign_processing ON pod_author_order_details.book_id=indesign_processing.book_id
              WHERE pod_author_order_details.start_flag=1 AND pod_author_order_details.completed_flag=0 
              ORDER BY pod_author_order_details.ship_date DESC";
        $query = $this->db->query($sql);
        $data['start_books'] = $query->getResultArray();

        return $data;
    }

    public function authorOrderMarkStart()
    {
        $orderId = $_POST['order_id'];
        $bookId = $_POST['book_id'];

        $updateData = ["start_flag" => 1];
        $this->db->table('pod_author_order_details')
                 ->where(['order_id' => $orderId, 'book_id' => $bookId])
                 ->update($updateData);

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function markFilesReadyCompleted()
    {
        $orderId = $_POST['order_id'];
        $bookId = $_POST['book_id'];

        $updateData = ["files_ready_flag" => 1];
        $this->db->table('pod_author_order_details')
                 ->where(['order_id' => $orderId, 'book_id' => $bookId])
                 ->update($updateData);

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function markCoverCompleted()
    {
        $orderId = $_POST['order_id'];
        $bookId = $_POST['book_id'];

        $updateData = ["cover_flag" => 1];
        $this->db->table('pod_author_order_details')
                 ->where(['order_id' => $orderId, 'book_id' => $bookId])
                 ->update($updateData);

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function markContentCompleted()
    {
        $orderId = $_POST['order_id'];
        $bookId = $_POST['book_id'];

        $updateData = ["content_flag" => 1];
        $this->db->table('pod_author_order_details')
                 ->where(['order_id' => $orderId, 'book_id' => $bookId])
                 ->update($updateData);

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function markLaminationCompleted()
    {
        $orderId = $_POST['order_id'];
        $bookId = $_POST['book_id'];

        $updateData = ["lamination_flag" => 1];
        $this->db->table('pod_author_order_details')
                 ->where(['order_id' => $orderId, 'book_id' => $bookId])
                 ->update($updateData);

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function markBindingCompleted()
    {
        $orderId = $_POST['order_id'];
        $bookId = $_POST['book_id'];

        $updateData = ["binding_flag" => 1];
        $this->db->table('pod_author_order_details')
                 ->where(['order_id' => $orderId, 'book_id' => $bookId])
                 ->update($updateData);

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function markFinalcutCompleted()
    {
        $orderId = $_POST['order_id'];
        $bookId = $_POST['book_id'];

        $updateData = ["finalcut_flag" => 1];
        $this->db->table('pod_author_order_details')
                 ->where(['order_id' => $orderId, 'book_id' => $bookId])
                 ->update($updateData);

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function markQcCompleted()
    {
        $orderId = $_POST['order_id'];
        $bookId = $_POST['book_id'];

        $updateData = ["qc_flag" => 1];
        $this->db->table('pod_author_order_details')
                 ->where(['order_id' => $orderId, 'book_id' => $bookId])
                 ->update($updateData);

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function authorOrderMarkCompleted()
    {
        $orderId = $_POST['order_id'];
        $bookId = $_POST['book_id'];

        $updateData = [
            "files_ready_flag" => 1,
            "cover_flag" => 1,
            "content_flag" => 1,
            "lamination_flag" => 1,
            "binding_flag" => 1,
            "finalcut_flag" => 1,
            "qc_flag" => 1,
            "completed_flag" => 1,
            "status" => 1
        ];
        $this->db->table('pod_author_order_details')
                 ->where(['order_id' => $orderId, 'book_id' => $bookId])
                 ->update($updateData);

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function authorInProgressOrder()
    {
        $sql="SELECT pod_author_order.*, author_tbl.author_name,
                     COUNT(pod_author_order_details.book_id) AS comp_cnt,
                     (SELECT COUNT(pod_author_order_details.book_id) 
                      FROM pod_author_order_details 
                      WHERE pod_author_order.order_id=pod_author_order_details.order_id) AS tot_book
              FROM pod_author_order
              JOIN pod_author_order_details ON pod_author_order.order_id=pod_author_order_details.order_id
              JOIN author_tbl ON pod_author_order_details.author_id=author_tbl.author_id
              WHERE pod_author_order_details.completed_flag=1 AND pod_author_order.order_status=0
              GROUP BY pod_author_order.order_id 
              ORDER BY pod_author_order.ship_date DESC";
        $query = $this->db->query($sql);
        $data['in_progress'] = $query->getResultArray();

        $sql="SELECT pod_author_order.*, author_tbl.author_name,
                     COUNT(pod_author_order_details.book_id) AS comp_cnt,
                     (SELECT COUNT(pod_author_order_details.book_id) 
                      FROM pod_author_order_details 
                      WHERE pod_author_order.order_id=pod_author_order_details.order_id) AS tot_book
              FROM pod_author_order
              JOIN pod_author_order_details ON pod_author_order.order_id=pod_author_order_details.order_id
              JOIN author_tbl ON pod_author_order_details.author_id=author_tbl.author_id
              WHERE (pod_author_order_details.completed_flag=1 AND pod_author_order.order_status=1 
                     AND pod_author_order.ship_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY))
                 OR (pod_author_order_details.completed_flag=1 AND pod_author_order.order_status=1 
                     AND pod_author_order.payment_status='Pending')
              GROUP BY pod_author_order.order_id 
              ORDER BY pod_author_order.ship_date DESC";
        $query = $this->db->query($sql);
        $data['completed'] = $query->getResultArray();

        $sql="SELECT pod_author_order.*, author_tbl.author_name,
                     COUNT(pod_author_order_details.book_id) AS comp_cnt,
                     (SELECT COUNT(pod_author_order_details.book_id) 
                      FROM pod_author_order_details 
                      WHERE pod_author_order.order_id=pod_author_order_details.order_id) AS tot_book
              FROM pod_author_order
              JOIN pod_author_order_details ON pod_author_order.order_id=pod_author_order_details.order_id
              JOIN author_tbl ON pod_author_order_details.author_id=author_tbl.author_id
              WHERE pod_author_order_details.completed_flag=1 AND pod_author_order.order_status=1
              GROUP BY pod_author_order.order_id 
              ORDER BY pod_author_order.ship_date DESC";
        $query = $this->db->query($sql);
        $data['completed_all'] = $query->getResultArray();

        $sqlDetail="SELECT pod_author_order.order_id, pod_author_order.user_id, pod_author_order.author_id, 
                           pod_author_order_details.book_id, pod_author_order_details.quantity, pod_author_order.tracking_id,
                           pod_author_order.tracking_url, pod_author_order_details.ship_date, 
                           author_tbl.author_name, book_tbl.book_title, pod_author_order_details.price, pod_author_order_details.discount
                    FROM pod_author_order, pod_author_order_details, book_tbl, author_tbl
                    WHERE pod_author_order_details.completed_flag=1 
                      AND pod_author_order.order_status=1 
                      AND pod_author_order.order_id=pod_author_order_details.order_id 
                      AND pod_author_order_details.author_id=author_tbl.author_id 
                      AND pod_author_order_details.book_id=book_tbl.book_id
                    ORDER BY pod_author_order.order_id DESC";
        $queryDetail = $this->db->query($sqlDetail);
        $data['completed_all_detail'] = $queryDetail->getResultArray();

        return $data;
    }

    public function authorInvoiceDetails()
    {
        $orderId = service('uri')->getSegment(3);
        $sql="SELECT * FROM pod_author_order WHERE order_id=$orderId";
        $query = $this->db->query($sql);
        $data['invoice'] = $query->getResultArray()[0];

        return $data;
    }

    public function createInvoice()
    {
        $orderId = $_POST['order_id'];
        $updateData = [
            "invoice_flag" => 1,
            "invoice_number" => $_POST['invoice_number'],
            "sub_total" => $_POST['sub_total'],
            "shipping_charges" => $_POST['shipping_charges'],
            "net_total" => $_POST['net_total'],
        ];

        $this->db->table('pod_author_order')
                 ->where('order_id', $orderId)
                 ->update($updateData);

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function authorMarkCancel()
    {
        $orderId = $_POST['order_id'];
        $updateData = ["order_status" => 2];

        $this->db->table('pod_author_order')
                 ->where('order_id', $orderId)
                 ->update($updateData);

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function authorOrderShip()
    {
        $orderId = service('uri')->getSegment(3);
        $sql = "SELECT * FROM pod_author_order WHERE order_id=$orderId";
        $query = $this->db->query($sql);

        return $query->getResultArray()[0];
    }

    public function authorOrderDetails()
    {
        $orderId = service('uri')->getSegment(3);

        $sql = "SELECT pod_author_order_details.*, author_tbl.author_name, book_tbl.book_title, pod_author_order.*
                FROM pod_author_order_details
                LEFT JOIN author_tbl ON author_tbl.author_id=pod_author_order_details.author_id
                JOIN book_tbl ON pod_author_order_details.book_id=book_tbl.book_id
                JOIN pod_author_order ON pod_author_order.order_id=pod_author_order_details.order_id
                WHERE pod_author_order_details.order_id=$orderId";
        $query = $this->db->query($sql);
        $data['order'] = $query->getResultArray()[0];

        $sql = "SELECT pod_author_order_details.*, pod_author_order_details.discount AS dis, author_tbl.author_name,
                       book_tbl.book_title, pod_author_order.*, book_tbl.paper_back_inr
                FROM pod_author_order_details
                LEFT JOIN author_tbl ON author_tbl.author_id=pod_author_order_details.author_id
                JOIN book_tbl ON pod_author_order_details.book_id=book_tbl.book_id
                JOIN pod_author_order ON pod_author_order.order_id=pod_author_order_details.order_id
                WHERE pod_author_order_details.order_id=$orderId";
        $query = $this->db->query($sql);
        $data['books'] = $query->getResultArray();

        return $data;
    }

    public function authorMarkShipped()
    {
        $orderId = $_POST['order_id'];
        $trackingId = $_POST['tracking_id'];
        $trackingUrl = $_POST['tracking_url'];

        $updateData = [
            "order_status" => 1,
            "tracking_id" => $trackingId,
            "tracking_url" => $trackingUrl,
        ];

        $this->db->table('pod_author_order')
                 ->where('order_id', $orderId)
                 ->update($updateData);

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function authorMarkPay()
    {
        $orderId = $_POST['order_id'];
        $updateData = ["payment_status" => 'Paid'];

        $this->db->table('pod_author_order')
                 ->where('order_id', $orderId)
                 ->update($updateData);

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }
    public function amazonSummary()
    {
        $sql = "SELECT 
                    DATE_FORMAT(apo.ship_date, '%Y-%m') AS order_month,
                    COUNT(DISTINCT b.book_id) AS total_titles,
                    SUM(apo.quantity * b.cost) AS total_mrp
                FROM amazon_paperback_orders apo
                JOIN book_tbl b ON apo.book_id = b.book_id
                GROUP BY DATE_FORMAT(apo.ship_date, '%Y-%m')
                ORDER BY order_month ASC";   
        $query = $this->db->query($sql);
        $data['chart'] = $query->getResultArray();

        // individual summaries
        $sql0="SELECT COUNT(*) AS completed_orders, COUNT(DISTINCT b.book_id) AS total_titles 
            FROM amazon_paperback_orders apo
            JOIN book_tbl b ON apo.book_id = b.book_id
            WHERE apo.ship_status = 0";
        $query0 = $this->db->query($sql0);
        $data['in_progress'] = $query0->getResultArray();

        $sql1="SELECT COUNT(*) AS completed_orders, COUNT(DISTINCT b.book_id) AS total_titles 
            FROM amazon_paperback_orders apo
            JOIN book_tbl b ON apo.book_id = b.book_id
            WHERE apo.ship_status = 1";
        $query1 = $this->db->query($sql1);
        $data['completed'] = $query1->getResultArray();

        $sql2="SELECT COUNT(*) AS cancel_orders, COUNT(DISTINCT b.book_id) AS total_titles 
            FROM amazon_paperback_orders apo
            JOIN book_tbl b ON apo.book_id = b.book_id
            WHERE apo.ship_status = 2";
        $query2 = $this->db->query($sql2);
        $data['cancelled'] = $query2->getResultArray();

        $sql3="SELECT COUNT(*) AS return_orders, COUNT(DISTINCT b.book_id) AS total_titles 
            FROM amazon_paperback_orders apo
            JOIN book_tbl b ON apo.book_id = b.book_id
            WHERE apo.ship_status = 3";
        $query3 = $this->db->query($sql3);
        $data['return'] = $query3->getResultArray();

        return $data;
    }
    public function onlineSummary()
    {
        // Chart summary (monthly orders + titles)
        $sql = "SELECT 
                    DATE_FORMAT(pod_order_details.order_date, '%Y-%m') AS order_month,
                    COUNT(DISTINCT pod_order.order_id) AS total_orders,
                    COUNT(DISTINCT pod_order_details.book_id) AS total_titles,
                    SUM(pod_order_details.quantity * book_tbl.cost) AS total_mrp
                FROM pod_order
                JOIN pod_order_details 
                    ON pod_order.user_id = pod_order_details.user_id
                    AND pod_order.order_id = pod_order_details.order_id
                JOIN book_tbl 
                    ON pod_order_details.book_id = book_tbl.book_id
                JOIN author_tbl 
                    ON book_tbl.author_name = author_tbl.author_id
                WHERE pod_order.user_id != 0
                GROUP BY DATE_FORMAT(pod_order_details.order_date, '%Y-%m')
                ORDER BY order_month ASC";   

        $query = $this->db->query($sql);
        $data['chart'] = $query->getResultArray();

        // In Progress
        $sql0 = "SELECT 
                    COUNT(DISTINCT pod_order.order_id) AS total_orders, 
                    COUNT(DISTINCT pod_order_details.book_id) AS total_titles,
                    SUM(pod_order_details.quantity *pod_order_details.price) AS total_mrp
                FROM pod_order
                JOIN pod_order_details 
                    ON pod_order.user_id = pod_order_details.user_id
                    AND pod_order.order_id = pod_order_details.order_id
                JOIN book_tbl ON pod_order_details.book_id = book_tbl.book_id
                WHERE pod_order.user_id != 0 AND pod_order_details.status = 0";
        $query0 = $this->db->query($sql0);
        $data['in_progress'] = $query0->getResultArray();

        // Completed
        $sql1 = "SELECT 
                    COUNT(DISTINCT pod_order.order_id) AS total_orders, 
                    COUNT(DISTINCT pod_order_details.book_id) AS total_titles,
                    SUM(pod_order_details.quantity *pod_order_details.price) AS total_mrp
                FROM pod_order
                JOIN pod_order_details 
                    ON pod_order.user_id = pod_order_details.user_id
                    AND pod_order.order_id = pod_order_details.order_id
                JOIN book_tbl ON pod_order_details.book_id = book_tbl.book_id
                WHERE pod_order.user_id != 0 AND pod_order_details.status = 1";
        $query1 = $this->db->query($sql1);
        $data['completed'] = $query1->getResultArray();

        // Cancelled
        $sql2 = "SELECT 
                    COUNT(DISTINCT pod_order.order_id) AS total_orders, 
                    COUNT(DISTINCT pod_order_details.book_id) AS total_titles,
                    SUM(pod_order_details.quantity *pod_order_details.price) AS total_mrp
                FROM pod_order
                JOIN pod_order_details 
                    ON pod_order.user_id = pod_order_details.user_id
                    AND pod_order.order_id = pod_order_details.order_id
                JOIN book_tbl ON pod_order_details.book_id = book_tbl.book_id
                WHERE pod_order.user_id != 0 AND pod_order_details.status = 2";
        $query2 = $this->db->query($sql2);
        $data['cancelled'] = $query2->getResultArray();

        return $data;
    }
    public function offlineSummary()
    {

        // ---------------- CHART SUMMARY (monthly orders + titles) ----------------
        $sql = "SELECT 
                    DATE_FORMAT(pustaka_offline_orders_details.ship_date, '%Y-%m') AS order_month,
                    COUNT(DISTINCT pustaka_offline_orders.order_id) AS total_orders,
                    COUNT(DISTINCT pustaka_offline_orders_details.book_id) AS total_titles,
                    SUM(pustaka_offline_orders_details.quantity * book_tbl.cost) AS total_mrp
                FROM pustaka_offline_orders
                JOIN pustaka_offline_orders_details 
                    ON pustaka_offline_orders.order_id = pustaka_offline_orders_details.offline_order_id
                JOIN book_tbl 
                    ON pustaka_offline_orders_details.book_id = book_tbl.book_id
                JOIN author_tbl 
                    ON book_tbl.author_name = author_tbl.author_id
                GROUP BY DATE_FORMAT(pustaka_offline_orders_details.ship_date, '%Y-%m')
                ORDER BY order_month ASC";
        $query = $this->db->query($sql);
        $data['chart'] = $query->getResultArray();


        // ---------------- IN PROGRESS ----------------
        $sql0 = "SELECT 
                    COUNT(DISTINCT pustaka_offline_orders.order_id) AS total_orders,
                    COUNT(DISTINCT pustaka_offline_orders_details.book_id) AS total_titles,
                    SUM(pustaka_offline_orders_details.quantity * book_tbl.cost) AS total_mrp
                FROM pustaka_offline_orders
                JOIN 
                    pustaka_offline_orders_details ON pustaka_offline_orders.order_id = pustaka_offline_orders_details.offline_order_id
                JOIN 
					book_tbl ON book_tbl.book_id = pustaka_offline_orders_details.book_id
                WHERE 
                    pustaka_offline_orders_details.ship_status = 0";

        $query0 = $this->db->query($sql0);
        $data['in_progress'] = $query0->getResultArray();


        // ---------------- COMPLETED (last 30 days OR pending payment) ----------------
        $sql1 = "SELECT 
                    COUNT(DISTINCT pustaka_offline_orders.order_id) AS total_orders,
                    COUNT(DISTINCT pustaka_offline_orders_details.book_id) AS total_titles,
                    SUM(pustaka_offline_orders_details.quantity * book_tbl.cost) AS total_mrp
                FROM pustaka_offline_orders
                JOIN pustaka_offline_orders_details 
                    ON pustaka_offline_orders.order_id = pustaka_offline_orders_details.offline_order_id
                JOIN 
					book_tbl ON book_tbl.book_id = pustaka_offline_orders_details.book_id
                WHERE (pustaka_offline_orders_details.ship_status = 1 
                    AND pustaka_offline_orders_details.ship_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY))
                OR (pustaka_offline_orders_details.ship_status = 1 
                    AND pustaka_offline_orders.payment_status = 'Pending')";
        $query1 = $this->db->query($sql1);
        $data['completed'] = $query1->getResultArray();


        // ---------------- CANCELLED ----------------
        $sql2 = "SELECT 
                    COUNT(DISTINCT pustaka_offline_orders.order_id) AS total_orders,
                    COUNT(DISTINCT pustaka_offline_orders_details.book_id) AS total_titles,
                    SUM(pustaka_offline_orders_details.quantity * book_tbl.cost) AS total_mrp
                FROM pustaka_offline_orders
                JOIN pustaka_offline_orders_details 
                    ON pustaka_offline_orders.order_id = pustaka_offline_orders_details.offline_order_id
                JOIN 
					book_tbl ON book_tbl.book_id = pustaka_offline_orders_details.book_id

                WHERE pustaka_offline_orders_details.ship_status = 2";
        $query2 = $this->db->query($sql2);
        $data['cancel'] = $query2->getResultArray();


        // ---------------- RETURN ----------------
        $sql3 = "SELECT 
                    COUNT(DISTINCT pustaka_offline_orders.order_id) AS total_orders,
                    COUNT(DISTINCT pustaka_offline_orders_details.book_id) AS total_titles,
                    SUM(pustaka_offline_orders_details.quantity * book_tbl.cost) AS total_mrp
                FROM pustaka_offline_orders
                JOIN pustaka_offline_orders_details 
                    ON pustaka_offline_orders.order_id = pustaka_offline_orders_details.offline_order_id
                JOIN 
					book_tbl ON book_tbl.book_id = pustaka_offline_orders_details.book_id

                WHERE pustaka_offline_orders_details.ship_status = 3";
        $query3 = $this->db->query($sql3);
        $data['return'] = $query3->getResultArray();


        // ---------------- COMPLETED ALL ----------------
        $sql4 = "SELECT 
                    COUNT(DISTINCT pustaka_offline_orders.order_id) AS total_orders,
                    COUNT(DISTINCT pustaka_offline_orders_details.book_id) AS total_titles,
                    SUM(pustaka_offline_orders_details.quantity * book_tbl.cost) AS total_mrp
                FROM pustaka_offline_orders
                JOIN pustaka_offline_orders_details 
                    ON pustaka_offline_orders.order_id = pustaka_offline_orders_details.offline_order_id
                JOIN
					book_tbl ON book_tbl.book_id = pustaka_offline_orders_details.book_id
                WHERE pustaka_offline_orders_details.ship_status = 1";
        $query4 = $this->db->query($sql4);
        $data['completed_all'] = $query4->getResultArray();


        return $data;
    }
    public function authorSummary()
    {
        $data = [];
        
        // Chart Data
        $sql_chart="SELECT 
                        DATE_FORMAT(pao.ship_date, '%Y-%m') AS order_month,
                        COUNT(DISTINCT pod.book_id) AS total_titles,
                        SUM(pod.quantity * b.cost) AS total_mrp
                    FROM 
                        pod_author_order pao
                    JOIN 
                        pod_author_order_details pod ON pao.order_id = pod.order_id
                    JOIN 
                        book_tbl b ON pod.book_id = b.book_id
                    WHERE 
                        pod.completed_flag = 1
                    GROUP BY 
                        DATE_FORMAT(pao.ship_date, '%Y-%m')
                    ORDER BY 
                        order_month ASC";

        $query = $this->db->query($sql_chart);
        $data['chart'] = $query->getResultArray();

        // In-progress (order_status = 0)
        $sql_inprogress = "SELECT 
                                COUNT(DISTINCT pao.order_id) AS total_orders, 
                                COUNT(DISTINCT pod.book_id) AS total_titles
                        FROM pod_author_order pao
                        JOIN pod_author_order_details pod ON pao.order_id = pod.order_id
                        WHERE pod.completed_flag = 1 AND pao.order_status = 0";
        $query = $this->db->query($sql_inprogress);
        $data['in_progress'] = $query->getRowArray();

        // Completed (last 30 days or pending payment)
        $sql_completed = "SELECT 
                                COUNT(DISTINCT pao.order_id) AS total_orders, 
                                COUNT(DISTINCT pod.book_id) AS total_titles
                        FROM pod_author_order pao
                        JOIN pod_author_order_details pod ON pao.order_id = pod.order_id
                        WHERE pod.completed_flag = 1 
                            AND pao.order_status = 1 
                            AND (pao.ship_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) 
                                OR pao.payment_status = 'Pending')";
        $query = $this->db->query($sql_completed);
        $data['completed'] = $query->getRowArray();

        // Completed All (all time completed orders)
        $sql_completed_all = "SELECT 
                                COUNT(DISTINCT pao.order_id) AS total_orders, 
                                COUNT(DISTINCT pod.book_id) AS total_titles
                            FROM pod_author_order pao
                            JOIN pod_author_order_details pod ON pao.order_id = pod.order_id
                            WHERE pod.completed_flag = 1 AND pao.order_status = 1";
        $query = $this->db->query($sql_completed_all);
        $data['completed_all'] = $query->getRowArray();

        // Completed All Detail (book level details count)
        $sql_completed_all_detail = "SELECT 
                                        COUNT(*) AS total_items
                                    FROM pod_author_order pao
                                    JOIN pod_author_order_details pod ON pao.order_id = pod.order_id
                                    JOIN book_tbl b ON pod.book_id = b.book_id
                                    WHERE pod.completed_flag = 1 AND pao.order_status = 1";
        $query = $this->db->query($sql_completed_all_detail);
        $data['completed_all_detail'] = $query->getRowArray();

        return $data;
    }
    //Bookshop Orders
    public function getBookshopOrdersDetails()
    {
        return $this->db->table('pod_bookshop')
            ->where('status', 1)
            ->get()
            ->getResultArray();
    }

    public function submitBookshopOrders(array $post)
    {
        $num_of_books = $post['num_of_books'];
        $order_id = time();

        $insert_data = [
            'bookshop_id' => $post['bookshop_id'],
            'order_id' => $order_id,
            'order_date' => date('Y-m-d H:i:s'),
            'preferred_transport' => $post['preferred_transport'],
            'preferred_transport_name' => $post['preferred_transport_name'],
            'transport_payment' => $post['transport_payment'],
            'ship_date' => $post['ship_date'],
            'ship_address' => $post['ship_address'],
            'payment_type' => $post['payment_type'],
            'payment_status' => $post['payment_status'],
            'vendor_po_order_number' => $post['vendor_po_order_number']
        ];

        $this->db->table('pod_bookshop_order')->insert($insert_data);

        for ($i = 1; $i <= $num_of_books; $i++) {
            $book_id = $post['book_id' . $i];
            $book_qty = $post['bk_qty' . $i];
            $book_dis = $post['bk_dis' . $i];
            $tot_amt = $post['tot_amt' . $i];
            $bk_inr = $post['bk_inr' . $i];

            $data = [
                'bookshop_id' => $post['bookshop_id'],
                'order_id' => $order_id,
                'order_date' => date('Y-m-d H:i:s'),
                'book_id' => $book_id,
                'book_price' => $bk_inr,
                'discount' => $book_dis,
                'quantity' => $book_qty,
                'total_amount' => $tot_amt,
                'ship_status' => 0,
            ];

            $this->db->table('pod_bookshop_order_details')->insert($data);
        }

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function bookshopProgressBooks()
    {
        $data = [];

        // In-progress orders
        $sql = "SELECT
                    pod_bookshop_order.*,
                    pod_bookshop.*,
                    (SELECT COUNT(order_id) FROM pod_bookshop_order_details 
                     WHERE pod_bookshop_order_details.order_id = pod_bookshop_order.order_id) as tot_book
                FROM pod_bookshop_order
                JOIN pod_bookshop ON pod_bookshop_order.bookshop_id=pod_bookshop.bookshop_id
                WHERE pod_bookshop_order.status = 0
                ORDER BY pod_bookshop_order.ship_date ASC";
        $data['in_progress'] = $this->db->query($sql)->getResultArray();

        // Completed (last 30 days or pending payment)
        $sql = "SELECT
                    pod_bookshop_order.*,
                    pod_bookshop.*,
                    (SELECT COUNT(order_id) FROM pod_bookshop_order_details 
                     WHERE pod_bookshop_order_details.order_id = pod_bookshop_order.order_id) as tot_book
                FROM pod_bookshop_order
                JOIN pod_bookshop ON pod_bookshop_order.bookshop_id=pod_bookshop.bookshop_id
                WHERE (pod_bookshop_order.status = 1 AND pod_bookshop_order.ship_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY))
                   OR (pod_bookshop_order.status = 1 AND pod_bookshop_order.payment_status = 'Pending')
                ORDER BY pod_bookshop_order.ship_date ASC";
        $data['completed'] = $this->db->query($sql)->getResultArray();

        // Cancelled
        $sql = "SELECT
                    pod_bookshop_order.*,
                    pod_bookshop.*,
                    (SELECT COUNT(order_id) FROM pod_bookshop_order_details 
                     WHERE pod_bookshop_order_details.order_id = pod_bookshop_order.order_id) as tot_book
                FROM pod_bookshop_order
                JOIN pod_bookshop ON pod_bookshop_order.bookshop_id=pod_bookshop.bookshop_id
                WHERE pod_bookshop_order.status = 2
                ORDER BY pod_bookshop_order.ship_date ASC";
        $data['cancel'] = $this->db->query($sql)->getResultArray();

        // All completed
        $sql = "SELECT
                    pod_bookshop_order.*,
                    pod_bookshop.*,
                    (SELECT COUNT(order_id) FROM pod_bookshop_order_details 
                     WHERE pod_bookshop_order_details.order_id = pod_bookshop_order.order_id) as tot_book
                FROM pod_bookshop_order
                JOIN pod_bookshop ON pod_bookshop_order.bookshop_id=pod_bookshop.bookshop_id
                WHERE pod_bookshop_order.status = 1
                ORDER BY pod_bookshop_order.ship_date ASC";
        $data['completed_all'] = $this->db->query($sql)->getResultArray();

        return $data;
    }

    public function bookshopOrderShip($order_id)
    {
        $sql = "SELECT pod_bookshop_order_details.*,pod_bookshop_order.*,
                (SELECT COUNT(order_id) FROM pod_bookshop_order_details 
                 WHERE pod_bookshop_order_details.order_id = pod_bookshop_order.order_id) as tot_book
                FROM pod_bookshop_order_details ,pod_bookshop_order
                WHERE pod_bookshop_order.order_id = pod_bookshop_order_details.order_id 
                AND pod_bookshop_order_details.order_id = ?";
        $data['details'] = $this->db->query($sql, [$order_id])->getRowArray();

        $sql = "SELECT pod_bookshop_order_details.book_id,pod_bookshop_order_details.quantity,book_tbl.book_title,
                    paperback_stock.quantity as qty, paperback_stock.stock_in_hand, paperback_stock.bookfair, paperback_stock.bookfair2, paperback_stock.bookfair3,
                    paperback_stock.bookfair4, paperback_stock.bookfair5, paperback_stock.lost_qty
                FROM pod_bookshop_order_details
                JOIN pod_bookshop_order ON pod_bookshop_order.order_id = pod_bookshop_order_details.order_id
                JOIN book_tbl ON pod_bookshop_order_details.book_id = book_tbl.book_id
                JOIN paperback_stock ON pod_bookshop_order_details.book_id = paperback_stock.book_id
                WHERE pod_bookshop_order_details.order_id = ?";
        $data['list'] = $this->db->query($sql, [$order_id])->getResultArray();

        return $data;
    }

    public function bookshopMarkShipped(array $post)
    {
        $order_id = $post['order_id'];
        $tracking_id = $post['tracking_id'];
        $tracking_url = $post['tracking_url'];

        $books_details = $this->db->table('pod_bookshop_order_details')
            ->select('book_id')
            ->where('order_id', $order_id)
            ->get()->getResultArray();

        foreach ($books_details as $books) {
            $bookID = $books['book_id'];

            $record = $this->db->table('pod_bookshop_order_details')
                ->select('quantity')
                ->where(['book_id' => $bookID, 'order_id' => $order_id])
                ->get()->getRowArray();

            $qty = $record['quantity'];

            // update stock
            $this->db->query("UPDATE paperback_stock 
                              SET quantity = quantity - ?, stock_in_hand = stock_in_hand - ? 
                              WHERE book_id = ?", [$qty, $qty, $bookID]);

            // mark shipped in details
            $this->db->table('pod_bookshop_order_details')
                ->where(['order_id' => $order_id, 'book_id' => $bookID])
                ->update([
                    "ship_status" => 1,
                    "shipped_date" => date('Y-m-d'),
                ]);

            // update order
            $this->db->table('pod_bookshop_order')
                ->where('order_id', $order_id)
                ->update([
                    "tracking_id" => $tracking_id,
                    "tracking_url" => $tracking_url,
                    "actual_ship_date" => date('Y-m-d'),
                    "status" => 1,
                ]);

            // ledger insert
            $stock_sql = "SELECT pod_bookshop_order_details.*,
                            book_tbl.*,
                            pod_bookshop.bookshop_name,
                            pod_bookshop_order_details.quantity as quantity,
                            paperback_stock.quantity as current_stock
                          FROM pod_bookshop_order_details
                          JOIN book_tbl ON pod_bookshop_order_details.book_id=book_tbl.book_id
                          JOIN pod_bookshop ON pod_bookshop.bookshop_id = pod_bookshop_order_details.bookshop_id
                          JOIN paperback_stock ON paperback_stock.book_id=pod_bookshop_order_details.book_id
                          WHERE book_tbl.book_id = ? AND pod_bookshop_order_details.order_id = ?";
            $stock = $this->db->query($stock_sql, [$bookID, $order_id])->getRowArray();

            $stock_data = [
                'book_id' => $stock['book_id'],
                'order_id' => $stock['order_id'],
                'author_id' => $stock['author_name'],
                'copyright_owner' => $stock['paper_back_copyright_owner'],
                'description' => "Bookshop Sales - " . $stock['bookshop_name'],
                'channel_type' => "BKS",
                'stock_out' => $stock['quantity'],
                'transaction_date' => date('Y-m-d H:i:s'),
            ];
            $this->db->table('pustaka_paperback_stock_ledger')->insert($stock_data);
        }

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function bookshopMarkCancel(array $post)
    {
        $order_id = $post['order_id'];
        $book_id = $post['book_id'];

        $this->db->table('pod_bookshop_order_details')
            ->where(['order_id' => $order_id, 'book_id' => $book_id])
            ->update([
                "ship_status" => 2,
                "date" => date('Y-m-d'),
            ]);

        $this->db->table('pod_bookshop_order')
            ->where('order_id', $order_id)
            ->update([
                "status" => 2,
            ]);

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function bookshopMarkPay($order_id)
    {
        $this->db->table('pod_bookshop_order')
            ->where('order_id', $order_id)
            ->update(["payment_status" => 'Paid']);

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function bookshopOrderDetails($order_id)
    {
        $sql = "SELECT pod_bookshop_order.*,pod_bookshop.bookshop_name,pod_bookshop.contact_person_name,pod_bookshop.mobile
                FROM pod_bookshop_order 
                JOIN pod_bookshop ON pod_bookshop_order.bookshop_id = pod_bookshop.bookshop_id
                WHERE pod_bookshop_order.order_id = ?";
        $data['details'] = $this->db->query($sql, [$order_id])->getRowArray();

        $sql = "SELECT pod_bookshop_order_details.*, book_tbl.book_title, author_tbl.author_name,
                       book_tbl.paper_back_isbn, pod_bookshop_order.transport_payment,
                       paperback_stock.quantity as qty, paperback_stock.stock_in_hand,
                       paperback_stock.bookfair, paperback_stock.bookfair2, paperback_stock.bookfair3,
                       paperback_stock.bookfair4, paperback_stock.bookfair5, paperback_stock.lost_qty
                FROM pod_bookshop_order
                JOIN pod_bookshop_order_details ON pod_bookshop_order.order_id = pod_bookshop_order_details.order_id
                JOIN book_tbl ON book_tbl.book_id = pod_bookshop_order_details.book_id
                JOIN author_tbl ON author_tbl.author_id = book_tbl.author_name
                LEFT JOIN paperback_stock ON paperback_stock.book_id = book_tbl.book_id
                WHERE pod_bookshop_order.order_id = ?";
        $data['list'] = $this->db->query($sql, [$order_id])->getResultArray();

        return $data;
    }

    public function bookshopInvoiceDetails($order_id)
    {
        $sql = "SELECT pod_bookshop_order.*, pod_order_details.tot_book_count, pod_order_details.net_total
                FROM pod_bookshop_order
                JOIN (
                    SELECT order_id, COUNT(order_id) as tot_book_count, SUM(total_amount) as net_total
                    FROM pod_bookshop_order_details
                    GROUP BY order_id
                ) as pod_order_details
                ON pod_bookshop_order.order_id = pod_order_details.order_id
                WHERE pod_bookshop_order.order_id = ?";
        return ['invoice' => $this->db->query($sql, [$order_id])->getRowArray()];
    }

    public function createBookshopInvoice(array $post)
    {
        $order_id = $post['order_id'];
        $this->db->table('pod_bookshop_order')
            ->where('order_id', $order_id)
            ->update(['invoice_no' => $post['invoice_number']]);

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

    public function addBookshop(array $post)
    {
        $update_data = [
            'bookshop_name' => $post['bookshopName'],
            'contact_person_name' => $post['contactPerson'],
            'email_id' => $post['email'],
            'mobile' => $post['mobile'],
            'address' => $post['address'],
            'city' => $post['city'],
            'pincode' => $post['pincode'],
            'preferred_transport' => $post['preferredTransport'],
            'preferred_transport_name' => $post['preferredTransportName'],
            'status' => 1,
        ];

        $this->db->table('pod_bookshop')->insert($update_data);

        return ($this->db->affectedRows() > 0) ? 1 : 0;
    }

}

