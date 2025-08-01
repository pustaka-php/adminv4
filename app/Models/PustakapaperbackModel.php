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

    public function getPaperbackstockDetails()
    {
        $data = [];

        // Count total books
        $query1 = $this->db->query("SELECT COUNT(*) AS books_cnt FROM paperback_stock");
        $data['books_cnt'] = $query1->getRowArray();

        // Sum total quantity
        $query2 = $this->db->query("SELECT SUM(quantity) AS quantity_cnt FROM paperback_stock");
        $data['quantity_cnt'] = $query2->getRowArray();

        // Full stock data
        $sql = "SELECT 
                paperback_stock.book_id AS id,
                book_title AS title,
                quantity AS qty,
                paperback_stock.bookfair,
                paperback_stock.bookfair2,
                paperback_stock.bookfair3,
                paperback_stock.bookfair4,
                paperback_stock.bookfair5,
                paperback_stock.lost_qty,
                paperback_stock.stock_in_hand,
                author_tbl.author_name
            FROM 
                paperback_stock
            JOIN 
                book_tbl ON paperback_stock.book_id = book_tbl.book_id
            JOIN 
                author_tbl ON author_tbl.author_id = book_tbl.author_name";

        $query3 = $this->db->query($sql);
        $data['stock_data'] = $query3->getResultArray();

        return $data;
    }
    public function totalPendingBooks()
    {
        $sql = "SELECT 
                author_name,
                order_id,
                channel,
                customer_name,
                quantity,
                ship_date,
                order_date,
                book_id,
                book_title,
                qty, 
                stock_in_hand,
                bookfair,
                lost_qty
            FROM (
                SELECT 
                    a.author_name,
                    o.amazon_order_id AS order_id,
                    'Amazon' AS channel,
                    '' AS customer_name,
                    o.quantity,
                    o.ship_date,
                    o.order_date,
                    b.book_id,
                    b.book_title,
                    ps.quantity AS qty,
                    ps.stock_in_hand,
                    (ps.bookfair + ps.bookfair2 + ps.bookfair3 + ps.bookfair4 + ps.bookfair5) AS bookfair,
                    ps.lost_qty
                FROM amazon_paperback_orders o
                JOIN book_tbl b ON o.book_id = b.book_id
                JOIN author_tbl a ON b.author_name = a.author_id
                LEFT JOIN paperback_stock ps ON ps.book_id = b.book_id 
                WHERE o.ship_status = 0

                UNION ALL

                SELECT 
                    a.author_name,
                    f.flipkart_order_id AS order_id,
                    'Flipkart' AS channel,
                    '' AS customer_name,
                    f.quantity,
                    f.ship_date,
                    f.order_date,
                    b.book_id,
                    b.book_title,
                    ps.quantity AS qty,
                    ps.stock_in_hand,
                    (ps.bookfair + ps.bookfair2 + ps.bookfair3 + ps.bookfair4 + ps.bookfair5) AS bookfair,
                    ps.lost_qty
                FROM flipkart_paperback_orders f
                JOIN book_tbl b ON f.book_id = b.book_id
                JOIN author_tbl a ON b.author_name = a.author_id
                LEFT JOIN paperback_stock ps ON ps.book_id = b.book_id 
                WHERE f.ship_status = 0

                UNION ALL

                SELECT 
                    a.author_name,
                    d.offline_order_id AS order_id,
                    'Offline' AS channel,
                    o.customer_name AS customer_name,
                    d.quantity,
                    o.ship_date,
                    o.order_date,
                    b.book_id,
                    b.book_title,
                    ps.quantity AS qty,
                    ps.stock_in_hand,
                    (ps.bookfair + ps.bookfair2 + ps.bookfair3 + ps.bookfair4 + ps.bookfair5) AS bookfair,
                    ps.lost_qty
                FROM pustaka_offline_orders_details d
                JOIN pustaka_offline_orders o ON d.offline_order_id = o.order_id
                JOIN book_tbl b ON d.book_id = b.book_id
                JOIN author_tbl a ON b.author_name = a.author_id
                LEFT JOIN paperback_stock ps ON ps.book_id = b.book_id 
                WHERE d.ship_status = 0

                UNION ALL

                SELECT 
                    a.author_name,
                    p.order_id AS order_id,
                    'Online' AS channel,
                    u.username AS customer_name,
                    pd.quantity,
                    NULL AS ship_date,
                    pd.order_date,
                    pd.book_id,
                    b.book_title,
                    ps.quantity AS qty,
                    ps.stock_in_hand,
                    (ps.bookfair + ps.bookfair2 + ps.bookfair3 + ps.bookfair4 + ps.bookfair5) AS bookfair,
                    ps.lost_qty
                FROM pod_order p
                JOIN pod_order_details pd ON p.user_id = pd.user_id AND p.order_id = pd.order_id
                JOIN book_tbl b ON pd.book_id = b.book_id
                JOIN users_tbl u ON p.user_id = u.user_id
                JOIN author_tbl a ON b.author_name = a.author_id
                LEFT JOIN paperback_stock ps ON ps.book_id = pd.book_id 
                WHERE p.user_id != 0 AND pd.status = 0
            ) AS combined_orders
            ORDER BY ship_date ASC";

        $query = $this->db->query($sql);
        return $query->getResultArray();
    }
    public function totalPendingOrders()
    {
        $sql = "(SELECT 
                pod_author_order.order_id AS order_id,
                author_tbl.author_name COLLATE utf8_general_ci AS customer_name,
                pod_author_order.order_date AS order_date,
                'Author Order' AS channel,
                (SELECT COUNT(book_id) FROM pod_author_order_details WHERE pod_author_order.order_id = pod_author_order_details.order_id) AS no_of_title,
                pod_author_order.invoice_number COLLATE utf8_general_ci AS invoice_number,
                pod_author_order.ship_date AS ship_date
            FROM 
                pod_author_order
            JOIN 
                pod_author_order_details ON pod_author_order.order_id = pod_author_order_details.order_id
            JOIN 
                author_tbl ON pod_author_order_details.author_id = author_tbl.author_id
            WHERE 
                pod_author_order_details.completed_flag = 1 
                AND pod_author_order.order_status = 0
            GROUP BY 
                pod_author_order.order_id )
            UNION ALL 
            (SELECT
                pod_bookshop_order.order_id AS order_id,
                pod_bookshop.bookshop_name COLLATE utf8_general_ci AS customer_name,
                pod_bookshop_order.order_date AS order_date,
                'Bookshop Order' AS channel,
                (SELECT COUNT(book_id) FROM pod_bookshop_order_details WHERE pod_bookshop_order_details.order_id = pod_bookshop_order.order_id) AS no_of_title,
                pod_bookshop_order.invoice_no COLLATE utf8_general_ci AS invoice_number,
                pod_bookshop_order.ship_date AS ship_date
            FROM
                pod_bookshop_order
            JOIN
                pod_bookshop ON pod_bookshop_order.bookshop_id = pod_bookshop.bookshop_id
            WHERE
                pod_bookshop_order.status = 0
            )
            ORDER BY 
                ship_date ASC";

        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

}
