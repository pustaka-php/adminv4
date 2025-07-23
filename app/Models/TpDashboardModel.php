<?php

namespace App\Models;

use CodeIgniter\Model;

class TpDashboardModel extends Model
{
    protected $table = 'tp_publisher_bookdetails';

    public function gettpPublishersDetails($publisher_id)
{
    $builder = $this->db->table('tp_publisher_bookdetails');
    $builder->select('tp_publisher_bookdetails.book_id,
                      tp_publisher_bookdetails.sku_no,
                      tp_publisher_bookdetails.publisher_id,
                      tp_publisher_bookdetails.book_title,
                      tp_publisher_bookdetails.author_id,
                      tp_publisher_bookdetails.mrp,
                      tp_publisher_book_stock.book_quantity,
                      tp_publisher_book_stock.stock_in_hand,
                      SUM(tp_publisher_book_stock_ledger.stock_out) as stock_out');
                      
    $builder->join('tp_publisher_book_stock', 'tp_publisher_bookdetails.book_id = tp_publisher_book_stock.book_id', 'left');
    $builder->join('tp_publisher_book_stock_ledger', 'tp_publisher_bookdetails.book_id = tp_publisher_book_stock_ledger.book_id', 'left');
    $builder->where('tp_publisher_bookdetails.publisher_id', $publisher_id);
    $builder->groupBy('tp_publisher_bookdetails.book_id');

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
            tp_publisher_bookdetails.pustaka_price AS paper_back_inr,
            tp_publisher_author_details.author_name
        ');
        $builder->join('tp_publisher_author_details', 'tp_publisher_author_details.author_id = tp_publisher_bookdetails.author_id');
        $builder->whereIn('tp_publisher_bookdetails.book_id', $selected_book_list);

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
        'tp_publisher_bookdetails.mrp AS price',
        'tp_publisher_author_details.author_name',
        'tp_publisher_book_stock.stock_in_hand',
    ]);

    $builder->join('tp_publisher_author_details', 'tp_publisher_author_details.author_id = tp_publisher_bookdetails.author_id');
    $builder->join('tp_publisher_book_stock', 'tp_publisher_book_stock.book_id = tp_publisher_bookdetails.book_id', 'left');
    $builder->whereIn('tp_publisher_bookdetails.book_id', $selected_book_list);

    $query = $builder->get();
    return $query->getResultArray();
}

    public function tppublisherOrderSubmit($user_id, $author_id, $publisher_id, $num_of_books, $selected_book_list, $address, $mobile, $ship_date)
{
    $request = service('request');
    $order_id = time();
    $order_date = date('Y-m-d H:i:s');

    $grand_total = 0;

    $mainOrder = [
        'order_id'     => $order_id,
        'author_id'    => $author_id,
        'publisher_id' => $publisher_id,
        'ship_date'    => $ship_date,
        'order_date'   => $order_date,
        'status'       => 0,
        'address'      => trim($address),
        'mobile'       => trim($mobile),
        'sub_total'    => 0,
        'royalty'      => 0,
        'payment_status' => 'pending',
    ];

    $this->db->table('tp_publisher_order')->insert($mainOrder);

    for ($i = 0; $i < $num_of_books; $i++) {
        $book_id  = $request->getPost('book_id' . $i);
        $quantity = (int) $request->getPost('bk_qty' . $i);

        if ($quantity <= 0) continue;

        $bookData = $this->db->table('tp_publisher_bookdetails')
            ->select('mrp')
            ->where('book_id', $book_id)
            ->get()
            ->getRow();

        $mrp = $bookData ? (float)$bookData->mrp : 0;
        $price = $quantity * $mrp;
        $grand_total += $price;

        $orderDetail = [
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
        ];

        $this->db->table('tp_publisher_order_details')->insert($orderDetail);
    }

    // Calculate royalty
    $royalty = 0;
    if ($grand_total >= 1 && $grand_total <= 500) {
        $royalty = 25;
    } elseif ($grand_total <= 2000) {
        $royalty = $grand_total * 0.10;
    } elseif ($grand_total <= 4000) {
        $royalty = $grand_total * 0.08;
    } else {
        $royalty = $grand_total * 0.05;
    }

    // Update the original order with sub_total and royalty
    $this->db->table('tp_publisher_order')
        ->where('order_id', $order_id)
        ->update([
            'sub_total'      => $grand_total,
            'royalty'        => $royalty,
            'payment_status' => 'pending'
        ]);

    return true;
}
public function getPublisherOrders()
{
    $orders = $this->db->table('tp_publisher_order_details od')
        ->select('
            od.order_id,
            od.book_id,
            od.quantity,
            od.price,
            od.order_date,
            od.ship_date,
            od.ship_status,
            o.status,
            o.address,
            o.mobile,
            b.sku_no,
            b.book_title,
            b.initiate_to_print,
            ad.author_name,
            p.publisher_name,
            bs.stock_in_hand
        ')
        ->join('tp_publisher_order o', 'o.order_id = od.order_id', 'left')
        ->join('tp_publisher_bookdetails b', 'b.book_id = od.book_id', 'left')
        ->join('tp_publisher_author_details ad', 'ad.author_id = o.author_id', 'left')
        ->join('tp_publisher_details p', 'p.publisher_id = o.publisher_id', 'left')
        ->join('tp_publisher_book_stock bs', 'bs.book_id = od.book_id', 'left')
        ->orderBy('od.order_id', 'DESC')
        ->get()
        ->getResultArray();

    foreach ($orders as &$order) {
        if (isset($order['stock_in_hand']) && $order['stock_in_hand'] > 0) {
            $order['book_status'] = 'In Stock';
        } else {
            $order['book_status'] = 'Out of Stock';
            $order['can_print'] = ($order['initiate_to_print'] == 1);
        }
    }

    return $orders;
}
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
}