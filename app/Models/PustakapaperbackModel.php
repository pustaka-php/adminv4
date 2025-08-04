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
}
