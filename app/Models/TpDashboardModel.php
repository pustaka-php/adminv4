<?php

namespace App\Models;

use CodeIgniter\Model;

class TpDashboardModel extends Model
{
    protected $table = 'tp_publisher_bookdetails';
     public function countData($publisher_id): array
    {
        $data = [];

        $bookTbl = $this->db->table('tp_publisher_bookdetails');

        // Active books count
        $data['active_book_cnt'] = $bookTbl->where('publisher_id', $publisher_id)
                                           ->where('status', 1)
                                           ->countAllResults();

        // Inactive books count
        $data['inactive_book_cnt'] = $this->db->table('tp_publisher_bookdetails')
                                              ->where('publisher_id', $publisher_id)
                                              ->where('status', 0)
                                              ->countAllResults();

        // Pending books count
        $data['pending_book_cnt'] = $this->db->table('tp_publisher_bookdetails')
                                             ->where('publisher_id', $publisher_id)
                                             ->where('status', 2)
                                             ->countAllResults();

       $orderCount = $this->db->table('tp_publisher_order')
                       ->where('publisher_id', $publisher_id)
                       ->countAllResults();
        $data['order_count'] = $orderCount;

        $pendingOrders = $this->db->table('tp_publisher_order')
                          ->where('publisher_id', $publisher_id)
                          ->where('status', 0)
                          ->countAllResults();
        $data['order_pending_count'] = $pendingOrders;

        // ✅ Count of orders with status = 1
        $completedOrders = $this->db->table('tp_publisher_order')
                                    ->where('publisher_id', $publisher_id)
                                    ->where('status', 1)
                                    ->countAllResults();
        $data['order_completed_count'] = $completedOrders;
        $salesTbl = $this->db->table('tp_publisher_sales');

        $data['qty_pustaka'] = $this->db->table('tp_publisher_sales')
                                    ->select("COUNT(DISTINCT create_date) as total_qty", false)
                                    ->where('channel_type', 'PUS')
                                    ->get()
                                    ->getRow()->total_qty ?? 0;

        $data['qty_amazon'] = $this->db->table('tp_publisher_sales')
                                    ->select("COUNT(DISTINCT create_date) as total_qty", false)
                                    ->where('publisher_id', $publisher_id)
                                    ->where('channel_type', 'AMZ')
                                    ->get()
                                    ->getRow()->total_qty ?? 0;


   $data['qty_bookfair'] = $this->db->table('tp_publisher_sales')
                                    ->select("COUNT(DISTINCT create_date) as total_qty", false)
                                    ->where('publisher_id', $publisher_id)
                                    ->like('channel_type', 'BFR')
                                    ->get()
                                    ->getRow()->total_qty ?? 0;

    $data['qty_other'] = $this->db->table('tp_publisher_sales')
                                    ->select("COUNT(DISTINCT create_date) as total_qty", false)
                                    ->where('publisher_id', $publisher_id)
                                    ->where('channel_type', 'OTH')
                                    ->get()
                                    ->getRow()->total_qty ?? 0;
    // Total Royalty from Orders (Pustaka -> Publisher)
    $data['total_royalty'] = $this->db->table('tp_publisher_order')
                                  ->selectSum('royalty')
                                  ->where('publisher_id', $publisher_id)
                                  ->get()
                                  ->getRow()->royalty ?? 0;

// Total Author Payment from Sales (Pustaka -> Author)
$data['total_author_amount'] = $this->db->table('tp_publisher_sales')
                                        ->selectSum('author_amount')
                                        ->where('publisher_id', $publisher_id)
                                        ->get()
                                        ->getRow()->author_amount ?? 0;

        return $data;
    }

    public function getBooksByPublisher($publisher_id)
{
    $db = db_connect();

    return $db->table('tp_publisher_bookdetails b')
        ->select("
            b.book_id, 
            b.sku_no, 
            b.book_title, 
            b.mrp, 
            b.isbn,
            COALESCE(s.stock_in_hand, 0) - COALESCE(SUM(CASE WHEN o.ship_status = 0 THEN o.quantity ELSE 0 END), 0) AS stock_in_hand
        ")
        ->join('tp_publisher_book_stock s', 's.book_id = b.book_id', 'left')
        ->join('tp_publisher_order_details o', 'o.book_id = b.book_id', 'left')
        ->where('b.publisher_id', $publisher_id)
        ->groupBy('b.book_id, b.sku_no, b.book_title, b.mrp, b.isbn, s.stock_in_hand')
        ->orderBy('b.sku_no', 'ASC')
        ->get()
        ->getResultArray();
}



    public function getStockOutSummary($publisher_id)
{
    $builder = $this->db->table('tp_publisher_book_stock_ledger');

    $builder->select([
        'SUM(CASE WHEN channel_type = "pub" THEN stock_out ELSE 0 END) AS pub_stock_out',
        'SUM(CASE WHEN channel_type != "pub" THEN stock_out ELSE 0 END) AS other_stock_out'
    ]);

    $builder->where('publisher_id', $publisher_id);

    return $builder->get()->getRowArray();
}

   public function gettpPublishersDetails($publisher_id)
{
    $builder = $this->db->table('tp_publisher_bookdetails b');

    $builder->select("
        b.book_id,
        b.sku_no,
        b.publisher_id,
        b.book_title,
        b.author_id,
        b.mrp,
        COALESCE(s.stock_in_hand, 0) AS stock_in_hand,
        (
            SELECT COALESCE(SUM(od.quantity), 0)
            FROM tp_publisher_order_details od
            WHERE od.book_id = b.book_id
              AND od.ship_status = 0
        ) AS pending_qty,
        (
            COALESCE(s.stock_in_hand, 0)
            - COALESCE((
                SELECT SUM(od.quantity)
                FROM tp_publisher_order_details od
                WHERE od.book_id = b.book_id
                  AND od.ship_status = 0
            ), 0)
        ) AS available_stock
    ");

    $builder->join('tp_publisher_book_stock s', 's.book_id = b.book_id', 'left');
    $builder->where('b.publisher_id', $publisher_id);
    $builder->groupBy('b.book_id, b.sku_no, b.publisher_id, b.book_title, b.author_id, b.mrp, s.stock_in_hand');

    $query = $builder->get();

    return $query->getNumRows() > 0 ? $query->getResultArray() : [];
}

    public function getAlltpPublishersDetails()
{
    $builder = $this->db->table('tp_publisher_bookdetails');
    $builder->select('tp_publisher_bookdetails.book_id,
                      tp_publisher_bookdetails.publisher_id,
                      tp_publisher_bookdetails.book_title,
                      tp_publisher_bookdetails.author_id,
                      tp_publisher_bookdetails.mrp,
                      tp_publisher_book_stock.book_quantity,
                      tp_publisher_book_stock.stock_in_hand,
                      tp_publisher_book_stock_ledger.stock_out,
                      tp_publisher_book_stock_ledger.channel_type');

    $builder->join('tp_publisher_book_stock', 'tp_publisher_bookdetails.book_id = tp_publisher_book_stock.book_id', 'left');
    $builder->join('tp_publisher_book_stock_ledger', 'tp_publisher_bookdetails.book_id = tp_publisher_book_stock_ledger.book_id', 'left');

    $query = $builder->get();

    return $query->getNumRows() > 0 ? $query->getResultArray() : [];
}


    public function getPublisherIdFromUserId($user_id)
    {
        $builder = $this->db->table('tp_publisher_details'); 
        $builder->select('publisher_id');
        $builder->where('user_id', $user_id);
        $query = $builder->get();

        if ($query->getNumRows() == 1) {
            return $query->getRow()->publisher_id;
        }
        return false;
    }
    public function tppublisherSelectedBooks($selected_book_list)
{
    $db = \Config\Database::connect();

    if (!is_array($selected_book_list)) {
        $selected_book_list = explode(',', $selected_book_list);
    }

    $builder = $db->table('tp_publisher_bookdetails');
    $builder->select('
        tp_publisher_bookdetails.book_id,
        tp_publisher_bookdetails.sku_no,
        tp_publisher_bookdetails.publisher_id,
        tp_publisher_bookdetails.author_id,
        tp_publisher_bookdetails.book_title,
        tp_publisher_bookdetails.book_regional_title as regional_book_title,
        tp_publisher_bookdetails.no_of_pages AS number_of_page,
        tp_publisher_bookdetails.mrp AS price,
        tp_publisher_bookdetails.isbn,
        tp_publisher_bookdetails.pustaka_price AS paper_back_inr,
        tp_publisher_author_details.author_name,
        (tp_publisher_book_stock.stock_in_hand - IFNULL(shipped.total_qty, 0)) AS stock_in_hand
    ');
    $builder->join('tp_publisher_author_details', 'tp_publisher_author_details.author_id = tp_publisher_bookdetails.author_id');
    $builder->join('tp_publisher_book_stock', 'tp_publisher_book_stock.book_id = tp_publisher_bookdetails.book_id', 'left');

    // join to calculate shipped qty with ship_status = 'O'
    $builder->join(
        '(SELECT book_id, SUM(quantity) AS total_qty
          FROM tp_publisher_order_details
          WHERE ship_status = "O"
          GROUP BY book_id) AS shipped',
        'shipped.book_id = tp_publisher_bookdetails.book_id',
        'left'
    );

    $builder->whereIn('tp_publisher_bookdetails.sku_no', $selected_book_list);

    $query = $builder->get();
    return $query->getResultArray();
}

     public function getPublisherAndAuthorId($user_id)
{
    $builder = $this->db->table('tp_publisher_details as p');
    $builder->select('p.publisher_id, a.author_id');
    $builder->join('tp_publisher_author_details as a', 'p.publisher_id = a.publisher_id');
    $builder->where('p.user_id', $user_id);
    $result = $builder->get()->getRowArray();

    return $result ?: null;
}
public function tppublisherOrderStock($selected_book_list)
{
    $db = \Config\Database::connect();

    if (!is_array($selected_book_list)) {
        $selected_book_list = explode(',', $selected_book_list);
    }

    $builder = $db->table('tp_publisher_bookdetails');

    $builder->select([
        'tp_publisher_bookdetails.book_id',
        'tp_publisher_bookdetails.sku_no',
        'tp_publisher_bookdetails.book_title',
        'tp_publisher_bookdetails.no_of_pages AS number_of_page',
        'tp_publisher_bookdetails.isbn',
        'tp_publisher_bookdetails.mrp AS price',
        'tp_publisher_author_details.author_name',
        'tp_publisher_book_stock.stock_in_hand',
    ]);

    $builder->join('tp_publisher_author_details', 'tp_publisher_author_details.author_id = tp_publisher_bookdetails.author_id');
    $builder->join('tp_publisher_book_stock', 'tp_publisher_book_stock.book_id = tp_publisher_bookdetails.book_id', 'left');
    $builder->whereIn('tp_publisher_bookdetails.sku_no', $selected_book_list);

    $query = $builder->get();
    return $query->getResultArray();
}

    public function tppublisherOrderSubmit(
    $user_id, $author_id, $publisher_id, $book_ids, $quantities,
    $address, $mobile, $ship_date, $transport, $comments
) {
    $order_id   = time();
    $order_date = date('Y-m-d H:i:s');
    $grand_total = 0;

    // Insert base order first (without totals)
    $this->db->table('tp_publisher_order')->insert([
        'order_id'      => $order_id,
        'author_id'     => $author_id,
        'publisher_id'  => $publisher_id,
        'ship_date'     => $ship_date,
        'order_date'    => $order_date,
        'status'        => 0,
        'address'       => trim($address),
        'mobile'        => trim($mobile),
        'sub_total'     => 0,
        'royalty'       => 0,
        'payment_status'=> 'pending',
        'transport'     => trim($transport),
        'comments'       => trim($comments),
    ]);

    // Loop through books
    foreach ($book_ids as $index => $book_id) {
        $quantity = (int)($quantities[$index] ?? 0);
        if ($quantity <= 0) continue;

        $bookData = $this->db->table('tp_publisher_bookdetails')
            ->select('mrp')
            ->where('book_id', $book_id)
            ->get()
            ->getRow();

        $mrp   = $bookData ? (float)$bookData->mrp : 0;
        $price = $quantity * $mrp;
        $grand_total += $price;

        $this->db->table('tp_publisher_order_details')->insert([
            'order_id'     => $order_id,
            'user_id'      => $user_id,
            'publisher_id' => $publisher_id,
            'author_id'    => $author_id,
            'book_id'      => $book_id,
            'quantity'     => $quantity,
            'price'        => $price,
            'ship_date'    => $ship_date,
            'order_date'   => $order_date,
            'ship_status'  => 0,
        ]);
    }

    // Calculate royalty
    if ($grand_total <= 500) {
        $royalty = 25;
    } elseif ($grand_total <= 2000) {
        $royalty = ceil(($grand_total * 0.10) / 10) * 10;
    } elseif ($grand_total <= 4000) {
        $royalty = ceil(($grand_total * 0.08) / 10) * 10;
    } else {
        $royalty = ceil(($grand_total * 0.05) / 10) * 10;
    }

    // Update order totals
    $this->db->table('tp_publisher_order')
        ->where('order_id', $order_id)
        ->update([
            'sub_total'      => $grand_total,
            'royalty'        => $royalty,
            'payment_status' => 'pending',
        ]);

    return $order_id;
}


// public function getPublisherOrders()
// {
//     $builder = $this->db->table('tp_publisher_order_details');
//     $builder->select('
//         tp_publisher_order_details.*,
//         tp_publisher_author_details.author_name,
//         tp_publisher_bookdetails.book_title
//     ');
//     $builder->join('tp_publisher_author_details', 'tp_publisher_author_details.author_id = tp_publisher_order_details.author_id', 'left');
//     $builder->join('tp_publisher_bookdetails', 'tp_publisher_order_details.book_id = tp_publisher_bookdetails.book_id');
//     $builder->where('tp_publisher_order_details.ship_status', 0);
//     $builder->orderBy('tp_publisher_order_details.ship_date', 'DESC');

//     $query = $builder->get();
//     return ['books' => $query->getResultArray()];
// }
public function getPublisherProcessOrders()
{
    $sql = "SELECT 
                tp_publisher_order.*,
                tp_publisher_author_details.author_name,
                SUM(tp_publisher_order_details.quantity) AS total_quantity,
                COUNT(tp_publisher_order_details.book_id) AS comp_cnt,
                (
                    SELECT COUNT(d.book_id)
                    FROM tp_publisher_order_details d
                    WHERE d.order_id = tp_publisher_order.order_id
                ) AS tot_book
            FROM 
                tp_publisher_order
            JOIN 
                tp_publisher_order_details ON tp_publisher_order.order_id = tp_publisher_order_details.order_id
            JOIN 
                tp_publisher_author_details ON tp_publisher_order_details.author_id = tp_publisher_author_details.author_id
            WHERE 
                tp_publisher_order_details.ship_status = 0 
                AND tp_publisher_order.status = 0
            GROUP BY 
                tp_publisher_order.order_id
            ORDER BY 
                tp_publisher_order.ship_date DESC";

    $query = $this->db->query($sql);
   return $query->getResultArray();// Return flat array
}
public function getPublisherOrdersByStatus($shipStatus, $orderStatus = null)
{
    $builder = $this->db->table('tp_publisher_order');
    $builder->select("
        tp_publisher_order.*,
        tp_publisher_author_details.author_name,
        COUNT(tp_publisher_order_details.book_id) AS total_books,
        SUM(tp_publisher_order_details.quantity) AS total_qty
    ");
    $builder->join(
        'tp_publisher_order_details',
        'tp_publisher_order.order_id = tp_publisher_order_details.order_id'
    );
    $builder->join(
        'tp_publisher_author_details',
        'tp_publisher_order_details.author_id = tp_publisher_author_details.author_id'
    );

    if ($shipStatus !== null) {
        $builder->where('tp_publisher_order_details.ship_status', $shipStatus);
    }
    if ($orderStatus !== null) {
        $builder->where('tp_publisher_order.status', $orderStatus);
    }

    $builder->groupBy('tp_publisher_order.order_id');
    $builder->orderBy('tp_publisher_order.order_date', 'DESC');

    return $builder->get()->getResultArray();
}
public function tpOrderFullDetails($order_id)
    {
        // Main order info
        $order = $this->db->table('tp_publisher_order_details')
            ->select('
                tp_publisher_order_details.*,
                tp_publisher_author_details.author_name,
                tp_publisher_bookdetails.book_title,
                tp_publisher_bookdetails.sku_no,
                tp_publisher_order.*
            ')
            ->join('tp_publisher_author_details', 'tp_publisher_author_details.author_id = tp_publisher_order_details.author_id', 'left')
            ->join('tp_publisher_bookdetails', 'tp_publisher_bookdetails.book_id = tp_publisher_order_details.book_id')
            ->join('tp_publisher_order', 'tp_publisher_order.order_id = tp_publisher_order_details.order_id')
            ->where('tp_publisher_order_details.order_id', $order_id)
            ->get()
            ->getResultArray();

        // Books info
        $books = $this->db->table('tp_publisher_order_details')
            ->select('
                tp_publisher_order_details.*,
                tp_publisher_author_details.author_name,
                tp_publisher_bookdetails.book_title,
                tp_publisher_bookdetails.sku_no,
                tp_publisher_bookdetails.isbn,
                tp_publisher_bookdetails.no_of_pages,
                tp_publisher_order.*,
                tp_publisher_bookdetails.mrp
            ')
            ->join('tp_publisher_author_details', 'tp_publisher_author_details.author_id = tp_publisher_order_details.author_id', 'left')
            ->join('tp_publisher_bookdetails', 'tp_publisher_bookdetails.book_id = tp_publisher_order_details.book_id')
            ->join('tp_publisher_order', 'tp_publisher_order.order_id = tp_publisher_order_details.order_id')
            ->where('tp_publisher_order_details.order_id', $order_id)
            ->get()
            ->getResultArray();

        return [
            'order' => !empty($order) ? $order[0] : [],
            'books' => $books
        ];
    }
    public function tpSalesDetails()
{
    return $this->db->table('tp_publisher_sales')
        ->select('sales_channel, create_date, SUM(qty) as total_qty, SUM(total_amount) as total_amount, SUM(discount) as discount, SUM(author_amount) as author_amount')
        ->groupBy(['sales_channel', 'create_date'])
        ->orderBy('sales_channel', 'ASC')
        ->orderBy('create_date', 'DESC')
        ->get()
        ->getResultArray();
}
 public function getHandlingCharges()
    {
        return $this->db->table('tp_publisher_order o')
            ->select('o.order_id, o.order_date, a.author_name, o.sub_total, o.royalty, o.courier_charges, o.payment_status, o.ship_date')
            ->join('tp_publisher_author_details a', 'a.author_id = o.author_id', 'left')
            ->orderBy('o.order_id', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getPayToAuthor()
{
    return $this->db->table('tp_publisher_sales s')
        ->select("
            s.sales_channel, 
            a.author_name,
            SUM(s.total_amount) AS total_amount,
            '40%' AS discount,
            (SUM(s.total_amount) * 0.60) AS author_amount,
            SUM(s.qty) AS tot_qty,
            s.paid_status
        ")
        ->join('tp_publisher_author_details a', 'a.author_id = s.author_id', 'left')
        ->groupBy('s.sales_channel, a.author_name, s.paid_status')
        ->orderBy('s.sales_channel', 'ASC')
        ->get()
        ->getResultArray();
}


// public function getPublisherOrders()
// {
//     $orders = $this->db->table('tp_publisher_order_details od')
//         ->select('
//             od.order_id,
//             od.book_id,
//             od.quantity,
//             od.price,
//             od.order_date,
//             od.ship_date,
//             od.ship_status,
//             o.status,
//             o.address,
//             o.mobile,
//             b.sku_no,
//             b.book_title,
//             b.initiate_to_print,
//             ad.author_name,
//             p.publisher_name,
//             bs.stock_in_hand
//         ')
//         ->join('tp_publisher_order o', 'o.order_id = od.order_id', 'left')
//         ->join('tp_publisher_bookdetails b', 'b.book_id = od.book_id', 'left')
//         ->join('tp_publisher_author_details ad', 'ad.author_id = o.author_id', 'left')
//         ->join('tp_publisher_details p', 'p.publisher_id = o.publisher_id', 'left')
//         ->join('tp_publisher_book_stock bs', 'bs.book_id = od.book_id', 'left')
//         ->orderBy('od.order_id', 'DESC')
//         ->get()
//         ->getResultArray();

//     foreach ($orders as &$order) {
//         if (isset($order['stock_in_hand']) && $order['stock_in_hand'] > 0) {
//             $order['book_status'] = 'In Stock';
//         } else {
//             $order['book_status'] = 'Out of Stock';
//             $order['can_print'] = ($order['initiate_to_print'] == 1);
//         }
//     }

//     return $orders;
// }
    public function tpPublisherOrderPayment($publisher_id = null)
{
    $builder = $this->db->table('tp_publisher_order o');
$builder->select('
    o.order_id,
    o.order_date,
    o.ship_date,
    o.payment_status,
    o.sub_total,
    o.courier_charges,
    o.royalty,
    p.publisher_name,
    od.ship_status
');

// Join order details table as 'od'
$builder->join('tp_publisher_order_details od', 'od.order_id = o.order_id', 'left');
$builder->join('tp_publisher_details p', 'p.publisher_id = o.publisher_id', 'left');

// Filter only shipped items
$builder->where('od.ship_status', 1);

// Sort by latest order
$builder->orderBy('o.order_id', 'DESC');

$result = $builder->get()->getResultArray();
return $result;
}
 public function getGroupedSales()
{
    return $this->db->table('tp_publisher_sales')
        ->select("
            DATE(create_date) as create_date,
            sales_channel,
            SUM(qty) as total_qty,
            SUM(total_amount) as total_amount,
            SUM(discount) as total_discount,
            SUM(author_amount) as total_author_amount,
            IF(paid_status='paid','paid','pending') as paid_status
        ")
        ->groupBy('DATE(create_date), sales_channel')
        ->orderBy('create_date', 'DESC')
        ->get()
        ->getResultArray();
}

    public function getOrderDetailsByDateChannel($create_date, $sales_channel)
{
    return $this->db->table('tp_publisher_sales')
        ->where('create_date', $create_date)
        ->where('sales_channel', $sales_channel)
        ->get()
        ->getResultArray();
}
 // Full details for a given date+time
   public function getFullDetails($createDate, $salesChannel)
{
    $createDate   = trim($createDate);
    $salesChannel = trim($salesChannel);

    return $this->db->table('tp_publisher_sales s')
        ->select('s.*, b.book_title, b.sku_no, b.mrp as price, a.author_name')
        ->join('tp_publisher_bookdetails b', 'b.book_id = s.book_id', 'left')
        ->join('tp_publisher_author_details a', 'a.author_id = s.author_id', 'left')
        ->where('s.sales_channel', $salesChannel)
        ->where('s.create_date >=', $createDate . ' 00:00:00')
        ->where('s.create_date <=', $createDate . ' 23:59:59')
        ->orderBy('s.create_date', 'ASC')
        ->get()
        ->getResultArray();
}
// full details

public function getBookFullDetails($bookId)
{
    return $this->db->table('tp_publisher_bookdetails b')
        ->select('b.book_id, b.sku_no, b.book_title, b.book_regional_title, 
                  b.book_genre, b.language, b.no_of_pages, b.book_description, 
                  b.mrp, b.isbn, p.publisher_name, a.author_name')
        ->join('tp_publisher_details p', 'p.publisher_id = b.publisher_id', 'left')
        ->join('tp_publisher_author_details a', 'a.author_id = b.author_id', 'left')
        ->where('b.book_id', $bookId)
        ->get()
        ->getRowArray();
}
public function getAllBooks()
{
    return $this->db->table('tp_publisher_bookdetails b')
        ->select('b.book_id, b.sku_no, b.book_title, b.mrp, b.isbn') // <-- book_id added
        ->get()
        ->getResultArray();
}

}