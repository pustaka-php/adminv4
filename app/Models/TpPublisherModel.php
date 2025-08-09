<?php

namespace App\Models;

use CodeIgniter\Model;

class TpPublisherModel extends Model
{
    protected $table         = 'tp_publisher_details';
    protected $primaryKey    = 'publisher_id';
    protected $allowedFields = [
        'publisher_name', 'contact_person', 'address', 'mobile', 'email_id',
        'publisher_logo', 'status', 'created_at',
        'bank_acc_no', 'bank_acc_name', 'bank_acc_ifsc', 'bank_acc_type'
    ];

    protected $useTimestamps = false;

    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        helper('date');
    }

    public function countData(): array
    {
        $data = [];

        // Publishers (Using model's default table)
        $data['active_publisher_cnt'] = $this->where('status', 1)->countAllResults(false);
        $data['inactive_publisher_cnt'] = $this->where('status', 0)->countAllResults(false);

        // Authors
        $authorTbl = $this->db->table('tp_publisher_author_details');
        $data['active_author_cnt'] = $authorTbl->where('status', 1)->countAllResults(false);

        $authorTbl = $this->db->table('tp_publisher_author_details');
        $data['inactive_author_cnt'] = $authorTbl->where('status', 0)->countAllResults(false);

        // Books
        $bookTbl = $this->db->table('tp_publisher_bookdetails');
        $data['active_book_cnt'] = $bookTbl->where('status', 1)->countAllResults(false);

        $bookTbl = $this->db->table('tp_publisher_bookdetails');
        $data['inactive_book_cnt'] = $bookTbl->where('status', 0)->countAllResults(false);

        $bookTbl = $this->db->table('tp_publisher_bookdetails');
        $data['pending_book_cnt'] = $bookTbl->where('status', 2)->countAllResults(false);

       $result = $this->db->table('tp_publisher_book_stock')
        ->selectSum('book_quantity')
        ->get()
        ->getRow();

        $data['tot_stock_count'] = $result->book_quantity ?? 0;

        $result = $this->db->table('tp_publisher_book_stock')
            ->selectSum('stock_in_hand')
            ->get()
            ->getRow();

        $data['stock_in_hand'] = $result->stock_in_hand ?? 0;
         $result = $this->db->table('tp_publisher_book_stock_ledger')
            ->selectSum('stock_out')
            ->get()
            ->getRow();

        $data['stock_out'] = $result->stock_out ?? 0;

        $result = $this->db->table('tp_publisher_sales')
            ->selectSum('total_amount')
            ->get()
            ->getRow();
        $data['total_amount'] = $result->total_amount ?? 0;

        $result = $this->db->table('tp_publisher_sales')
            ->selectSum('qty')
            ->get()
            ->getRow();
        $data['qty'] = $result->qty ?? 0;

        $result = $this->db->query("SELECT COUNT(DISTINCT order_id) AS total_orders FROM tp_publisher_sales")
            ->getRow();
        $data['order'] = $result->total_orders ?? 0;

        

            return $data;
    }
     public function tpPublisherDetails()
    {
        $publishers = $this->findAll();

        $result = [
            'active' => [],
            'inactive' => []
        ];

        foreach ($publishers as $publisher) {
            if ($publisher['status'] == 1) {
                $result['active'][] = $publisher;
            } else {
                $result['inactive'][] = $publisher;
            }
        }

        return $result;
    }
    public function inactivePublishers($publisherId)
    {
        $db = \Config\Database::connect();
        $builder = $db->query("
            UPDATE tp_publisher_details pd
            LEFT JOIN tp_publisher_author_details pad ON pd.publisher_id = pad.publisher_id
            LEFT JOIN tp_publisher_bookdetails pabd ON pad.publisher_id = pabd.publisher_id
            SET pd.status = 0, pad.status = 0, pabd.status = 0
            WHERE pd.publisher_id = ?
        ", [$publisherId]);

        return $builder ? 1 : 0;
    }

    public function activePublishers($publisherId)
    {
        $db = \Config\Database::connect();
        $builder = $db->query("
            UPDATE tp_publisher_details pd
            LEFT JOIN tp_publisher_author_details pad ON pd.publisher_id = pad.publisher_id
            LEFT JOIN tp_publisher_bookdetails pabd ON pad.publisher_id = pabd.publisher_id
            SET pd.status = 1, pad.status = 1, pabd.status = 1
            WHERE pd.publisher_id = ?
        ", [$publisherId]);

        return $builder ? 1 : 0;
    }
   public function getPublisherOrders($shipStatus = null, $orderStatus = null)
{
    $builder = $this->db->table('tp_publisher_order');
    $builder->select("
        tp_publisher_order.*,
        tp_publisher_order_details.ship_status,
        tp_publisher_order_details.book_id,
        tp_publisher_author_details.author_name,
        COUNT(tp_publisher_order_details.book_id) AS total_books,
        SUM(tp_publisher_order_details.quantity) AS total_qty,
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
    $builder->orderBy('tp_publisher_order.ship_date', 'DESC');

    $orders = $builder->get()->getResultArray();

    foreach ($orders as &$order) {
        if (isset($order['stock_in_hand']) && $order['stock_in_hand'] > 0) {
            $order['book_status'] = 'In Stock';
        } else {
            $order['book_status'] = 'Out of Stock';
        }

        // Show print button if out of stock and printing is allowed
        $order['show_print_button'] = (
            $order['book_status'] === 'Out of Stock' && 
            isset($order['initiate_to_print']) && 
            $order['initiate_to_print'] == 1
        );
    }

    return $orders;
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
public function tpPublisherAdd()
    {
        $request = \Config\Services::request();

        $data = [
            'publisher_name'   => $request->getPost('publisher_name'),
            'contact_person'   => $request->getPost('contact_person'),
            'address'          => $request->getPost('address'),
            'mobile'           => $request->getPost('mobile'),
            'email_id'         => $request->getPost('email_id'),
            'publisher_logo'   => $request->getPost('publisher_logo'),
            'status'           => 1,
            'created_at'       => date('Y-m-d H:i:s'),
        ];

        if (
            $request->getPost('bank_acc_no') &&
            $request->getPost('bank_acc_name') &&
            $request->getPost('bank_acc_ifsc') &&
            $request->getPost('bank_acc_type')
        ) {
            $data['bank_acc_no']   = $request->getPost('bank_acc_no');
            $data['bank_acc_name'] = $request->getPost('bank_acc_name');
            $data['bank_acc_ifsc'] = $request->getPost('bank_acc_ifsc');
            $data['bank_acc_type'] = $request->getPost('bank_acc_type');
        }

        $this->insert($data);
        return $this->getInsertID(); // Return inserted ID
    }
    public function tpAuthorDetails(): array
{
    $sql = "SELECT pad.*, pd.publisher_name, pd.status AS publisher_status 
            FROM tp_publisher_author_details pad
            JOIN tp_publisher_details pd ON pd.publisher_id = pad.publisher_id";
    
    $query = $this->db->query($sql);
    $authors = $query->getResultArray();

    $result = [
        'active' => [],
        'inactive' => []
    ];

    foreach ($authors as $author) {
        $record = [
            'publisher_name'   => $author['publisher_name'],
            'author_id'        => $author['author_id'],
            'author_name'      => $author['author_name'],
            'mobile'           => $author['mobile'],
            'email_id'         => $author['email_id'] ?? '',
            'author_image'     => $author['author_image'] ?? '',
            'author_status'    => $author['status'],
            'publisher_status' => $author['publisher_status'],
        ];

        // Author is active only if both author and publisher are active
        if ((int)$author['status'] === 1 && (int)$author['publisher_status'] === 1) {
            $result['active'][] = $record;
        } else {
            $result['inactive'][] = $record;
        }
    }

    return $result;
}
public function tpPublisherEdit($publisher_id)
    {
        return $this->where('publisher_id', $publisher_id)->first();
    }
   public function tpPublisherEditPost($publisherId, $request)
    {
        $data = [
            'publisher_name'   => $request->getPost('publisher_name'),
            'contact_person'   => $request->getPost('contact_person'),
            'address'          => $request->getPost('address'),
            'mobile'           => $request->getPost('mobile'),
            'email_id'         => $request->getPost('email_id'),
            'bank_acc_no'      => $request->getPost('bank_acc_no'),
            'bank_acc_name'    => $request->getPost('bank_acc_name'),
            'bank_acc_ifsc'    => $request->getPost('bank_acc_ifsc'),
            'bank_acc_type'    => $request->getPost('bank_acc_type'),
            'publisher_logo'   => $request->getPost('publisher_logo'),
            'status'           => 1
        ];

        return $this->update($publisherId, $data);
    }
 public function getTpAuthor()
    {
        return $this->orderBy('publisher_id', 'ASC')->findAll();
    }
 public function tpAuthorsAdd(array $postData): bool
    {
        $authorData = [
            'publisher_id'       => $postData['publisher_id'] ?? null,
            'author_id'          => $postData['author_id'] ?? null,
            'author_name'        => trim($postData['author_name'] ?? ''),
            'mobile'             => trim($postData['mobile'] ?? ''),
            'email_id'           => trim($postData['email_id'] ?? ''),
            'author_discription' => trim($postData['author_discription'] ?? ''),
            'author_image'       => trim($postData['author_image'] ?? ''),
            'status'             => 1,
            'created_at'         => date('Y-m-d H:i:s'),
        ];

        $builder = $this->db->table('tp_publisher_author_details');
        $builder->insert($authorData);
        return $this->db->affectedRows() > 0;
    }

public function activateAuthorWithBooks($authorId)
{
    $db = \Config\Database::connect();
    $db->transStart();

    // 1. Update author status to active
    $db->table('tp_publisher_author_details')
        ->where('author_id', $authorId)
        ->update(['status' => 1]);

    // 2. Update all their books to active
    $db->table('tp_publisher_bookdetails')
        ->where('author_id', $authorId)
        ->update(['status' => 1]);

    $db->transComplete();
    return $db->transStatus();
}

public function deactivateAuthorWithBooks($authorId)
{
    $db = \Config\Database::connect();
    $db->transStart();

    // 1. Update author status to inactive
    $db->table('tp_publisher_author_details')
        ->where('author_id', $authorId)
        ->update(['status' => 0]);

    // 2. Update all their books to inactive
    $db->table('tp_publisher_bookdetails')
        ->where('author_id', $authorId)
        ->update(['status' => 0]);

    $db->transComplete();
    return $db->transStatus();
}

function tpAuthorView($author_id)
{
    // Get author details with publisher name
    $author_sql = "SELECT pad.*, pd.publisher_name 
                   FROM tp_publisher_author_details pad 
                   JOIN tp_publisher_details pd ON pad.publisher_id = pd.publisher_id 
                   WHERE pad.author_id = ?";
    $author_query = $this->db->query($author_sql, [$author_id]);
    $author_details = $author_query->getRowArray();

    // Get book count using query builder properly
    $book_count_query = $this->db
        ->table('tp_publisher_bookdetails')
        ->select('COUNT(DISTINCT book_id) as book_count')
        ->where('author_id', $author_id)
        ->get();
    $book_count = $book_count_query->getRowArray()['book_count'];

    // Get publishers
    $publisher_sql = "SELECT pd.* 
                      FROM tp_publisher_details pd 
                      JOIN tp_publisher_author_details pad ON pd.publisher_id = pad.publisher_id 
                      WHERE pad.author_id = ?";
    $publisher_query = $this->db->query($publisher_sql, [$author_id]);
    $publishers = $publisher_query->getResultArray();

    // Get books
    $book_sql = "SELECT pab.*
                 FROM tp_publisher_bookdetails pab 
                 WHERE pab.author_id = ?";
    $books_query = $this->db->query($book_sql, [$author_id]);
    $books = $books_query->getResultArray();

    // Combine all data
    return [
        'author_details' => $author_details,
        'book_count' => $book_count,
        'publishers' => $publishers,
        'books' => $books
    ];
}
public function getAuthorList(): array
{
    return $this->db
        ->table('tp_publisher_author_details')
        ->orderBy('author_name', 'ASC')
        ->get()
        ->getResultArray();
}
 public function get_common_data($type)
    {
        switch ($type) {
            case 'types':
                $table = 'book_types';
                $order_by = 'type_name';
                break;
            case 'languages':
                $table = 'language_tbl';
                $order_by = 'language_name';
                break;
            case 'genres':
                $table = 'genre_details_tbl';
                $order_by = 'genre_name';
                break;
            case 'authors':
                $table = 'tp_publisher_author_details';
                $order_by = 'author_name';
                break;
            case 'publishers':
                $table = 'tp_publisher_details';
                $order_by = 'publisher_name';
                break;
            default:
                return [];
        }

       return $this->db->table($table)
                ->orderBy($order_by)
                ->get()
                ->getResult();
    }
    public function getAuthorAndPublishers(int $author_id): array
{
    $author = $this->db->table('tp_publisher_author_details')
                       ->where('author_id', $author_id)
                       ->get()
                       ->getRowArray();

    $publishers = $this->db->table('tp_publisher_details')
                           ->orderBy('publisher_id')
                           ->get()
                           ->getResultArray();

    return [
        'author'     => $author,
        'publishers' => $publishers,
    ];
}

public function updateAuthor($author_id, $data)
{
    $this->db->table('tp_publisher_author_details')
             ->where('author_id', $author_id)
             ->update($data);

    return $this->db->affectedRows() > 0;
}
    public function tpBookAdd(array $postData): bool
    {
        $bookData = [
            'publisher_id'         => $postData['publisher_id'] ?? null,
            'author_id'            => $postData['author_id'] ?? null,
            'book_id'              => $postData['book_id'] ?? null,
            'sku_no'               => trim($postData['sku_no'] ?? ''),
            'book_title'           => trim($postData['book_title'] ?? ''),
            'book_regional_title'  => trim($postData['book_regional_title'] ?? ''),
            'book_url'             => trim($postData['book_url'] ?? ''),
            'initiate_to_print'    => !empty($postData['initiate_to_print']) ? 1 : 0,
            'book_genre'           => trim($postData['book_genre'] ?? ''),
            'type_name'            => trim($postData['type_name'] ?? ''),
            'language'             => trim($postData['language'] ?? ''),
            'book_description'     => trim($postData['book_description'] ?? ''),
            'no_of_pages'          => $postData['no_of_pages'] ?? null,
            'mrp'                  => $postData['mrp'] ?? null,
            'pustaka_price'        => $postData['pustaka_price'] ?? null,
            'isbn'                 => trim($postData['isbn'] ?? ''),
            'discount'             => $postData['discount'] ?? null,
            'status'               => 1,
            'created_at'           => date('Y-m-d H:i:s'),
        ];

        $builder = $this->db->table('tp_publisher_bookdetails');
        $builder->insert($bookData);

        return $this->db->affectedRows() > 0;
    }
    public function updateBookStatus(int $book_id, int $status): bool
{
    return $this->db->table('tp_publisher_bookdetails')
        ->where('book_id', $book_id)
        ->update(['status' => $status]);
}
   public function getStockDetails()
{
    $db = \Config\Database::connect();

    $builder = $db->table('tp_publisher_book_stock s');
        $builder->select('
            s.stock_in_hand,
            s.book_id, 
            pd.publisher_name,
            ad.author_name,
            bd.book_title
        ');
        $builder->join('tp_publisher_book_stock_ledger l', 'l.book_id = s.book_id AND l.author_id = s.author_id', 'left');
        $builder->join('tp_publisher_details pd', 'pd.publisher_id = l.publisher_id', 'left');
        $builder->join('tp_publisher_author_details ad', 'ad.author_id = s.author_id', 'left');
        $builder->join('tp_publisher_bookdetails bd', 'bd.book_id = s.book_id', 'left');
        $builder->groupBy('s.book_id');


    $query = $builder->get();
    return $query->getResult();

    }
public function TpbookAddStock($data)
{
    $db = \Config\Database::connect();

    // Use $data array instead of accessing request inside the model
    $bookId = $data['book_id'];
    $authorId = $data['author_id'];
    $bookQuantity = (int)$data['book_quantity'];

    // Check if stock already exists
    $stockData = $db->table('tp_publisher_book_stock')
                    ->where('book_id', $bookId)
                    ->get()
                    ->getRowArray();

    if ($stockData) {
        //  Update existing stock
        $db->table('tp_publisher_book_stock')
            ->where('book_id', $bookId)
            ->set('book_quantity', "book_quantity + {$bookQuantity}", false)
            ->set('stock_in_hand', "stock_in_hand + {$bookQuantity}", false)
            ->update();

        $description = "Stock added to Inventory";
        $channelType = "STK";
    } else {
        //  Insert new stock
        $bookData = [
            'author_id'        => $authorId,
            'book_id'          => $bookId,
            'book_quantity'    => $bookQuantity,
            'stock_in_hand'    => $bookQuantity,
            'last_update_date' => date("Y-m-d H:i:s")
        ];
        $db->table('tp_publisher_book_stock')->insert($bookData);

        $description = "Opening Stock";
        $channelType = "OST";
    }

    //  Fetch publisher_id for ledger
    $query = $db->query("
        SELECT pab.publisher_id, pab.author_id, pab.book_id
        FROM tp_publisher_bookdetails pab
        WHERE pab.book_id = ?", [$bookId]);

    $stock = $query->getRowArray();

    if (!empty($stock)) {
        $ledgerData = [
            'publisher_id'     => $stock['publisher_id'],
            'author_id'        => $stock['author_id'],
            'book_id'          => $stock['book_id'],
            'description'      => $description,
            'channel_type'     => $channelType,
            'stock_in'         => $bookQuantity,
            'transaction_date' => date('Y-m-d H:i:s'),
        ];
        $db->table('tp_publisher_book_stock_ledger')->insert($ledgerData);
    }

    //  Return status
    return $db->affectedRows() > 0
        ? ['status' => 1]
        : ['status' => 0];
}

public function getBooksByAuthor($author_id)
    {
        $builder = $this->db->table('tp_publisher_bookdetails');
        $builder->where('author_id', $author_id);
        $builder->orderBy('book_title', 'ASC');
        return $builder->get()->getResult();
    }

    public function getBooksAndAuthors()
    {
        // Books
        $bookBuilder = $this->db->table('tp_publisher_bookdetails');
        $bookBuilder->orderBy('book_title', 'ASC');
        $books = $bookBuilder->get()->getResult();

        // Authors with publishers
        $authorBuilder = $this->db->table('tp_publisher_author_details');
        $authorBuilder->select('tp_publisher_author_details.*, tp_publisher_details.publisher_name');
        $authorBuilder->join('tp_publisher_details', 'tp_publisher_author_details.publisher_id = tp_publisher_details.publisher_id');
        $authorBuilder->orderBy('tp_publisher_author_details.author_name', 'ASC');
        $authorBuilder->orderBy('tp_publisher_details.publisher_name', 'ASC');
        $authors = $authorBuilder->get()->getResult();

        return [
            'books' => $books,
            'authors' => $authors
        ];
    }
    public function markShipped(array $data)
{
    $order_id = $data['order_id'] ?? '';
    $book_id = (int)($data['book_id'] ?? 0);
    $courier_charges = floatval($data['courier_charges'] ?? 0);

    if (!$order_id || !$book_id) {
        log_message('error', 'Missing order_id or book_id.');
        return false;
    }

    // Get quantity
    $qtyRow = $this->db->table('tp_publisher_order_details')
        ->select('quantity')
        ->where(['order_id' => $order_id, 'book_id' => $book_id])
        ->get()
        ->getRowArray();

    if (!$qtyRow) return false;

    $qty = (int)$qtyRow['quantity'];

    $this->db->transStart();

    // 1. Decrease stock
    $this->db->table('tp_publisher_book_stock')
        ->where('book_id', $book_id)
        ->set('stock_in_hand', "stock_in_hand - {$qty}", false)
        ->update();

    // 2. Update order details
    $this->db->table('tp_publisher_order_details')
        ->where(['order_id' => $order_id, 'book_id' => $book_id])
        ->update([
            'ship_date' => date('Y-m-d H:i:s'),
            'ship_status' => 1
        ]);

    // 3. Update main order status + courier_charges
    $order = $this->db->table('tp_publisher_order')
        ->select('sub_total, royalty')
        ->where('order_id', $order_id)
        ->get()
        ->getRowArray();

    $sub_total = floatval($order['sub_total'] ?? 0);
    $royalty   = floatval($order['royalty'] ?? 0);
    $net_total = $sub_total + $royalty + $courier_charges;

    $this->db->table('tp_publisher_order')
        ->where('order_id', $order_id)
        ->update([
            'status'         => 1,
            'courier_charges' => $courier_charges,
            'net_total'      => $net_total,
        ]);

    // 4. Stock ledger (optional)
    $stock = $this->db->table('tp_publisher_order o')
        ->select('o.order_id, b.book_id, b.author_id, b.publisher_id')
        ->join('tp_publisher_order_details od', 'o.order_id = od.order_id')
        ->join('tp_publisher_bookdetails b', 'od.book_id = b.book_id')
        ->where([
            'o.order_id' => $order_id,
            'od.book_id' => $book_id,
        ])
        ->get()
        ->getRowArray();

    if ($stock) {
        $ledgerData = [
            'book_id'          => $stock['book_id'],
            'order_id'         => $stock['order_id'],
            'author_id'        => $stock['author_id'],
            'publisher_id'     => $stock['publisher_id'],
            'description'      => 'Publisher Sales',
            'channel_type'     => 'PUB',
            'stock_out'        => $qty,
            'transaction_date' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('tp_publisher_book_stock_ledger')->insert($ledgerData);
    }

    $this->db->transComplete();

    return $this->db->transStatus();
}

public function markCancel(array $data)
{
    $order_id = $data['order_id'] ?? '';
    $book_id = (int)($data['book_id'] ?? 0);

    if (!$order_id || !$book_id) {
        log_message('error', 'Missing order_id or book_id for cancellation.');
        return false;
    }
    $this->db->transStart();

    // Mark the overall order as cancelled (status = 2)
    $this->db->table('tp_publisher_order')
        ->where(['order_id' => $order_id])
        ->update(['status' => 2]);

    // Update specific book's ship_status to 2 (Cancelled), with date
    $this->db->table('tp_publisher_order_details')
        ->where(['order_id' => $order_id, 'book_id' => $book_id])
        ->update([
            'ship_date'   => date('Y-m-d H:i:s'),
            'ship_status' => 2
        ]);

    $this->db->transComplete();

    if ($this->db->transStatus() === false) {
        log_message('error', "Transaction failed during cancellation of order_id=$order_id, book_id=$book_id");
        return false;
    }

    log_message('debug', "Order $order_id with book_id=$book_id marked as cancelled successfully.");
    return true;
}
    public function markReturn(array $data)
    {
        $order_id = $data['order_id'] ?? '';
        $book_id = (int)($data['book_id'] ?? 0);

        if (!$order_id || !$book_id) return false;

        $qtyRow = $this->db->table('tp_publisher_order_details')
            ->select('quantity')
            ->where(['order_id' => $order_id, 'book_id' => $book_id])
            ->get()
            ->getRowArray();

        if (!$qtyRow) return false;

        $qty = (int)$qtyRow['quantity'];

        $this->db->transStart();

        $this->db->table('tp_publisher_book_stock')
            ->where('book_id', $book_id)
            // ->set('book_quantity', "book_quantity + $qty", false)
            ->set('stock_in_hand', "stock_in_hand + $qty", false)
            ->update();

        $this->db->table('tp_publisher_order')
            ->where(['order_id' => $order_id])
            ->update(['status' => 3]);

        $this->db->table('tp_publisher_order_details')
            ->where(['order_id' => $order_id, 'book_id' => $book_id])
            ->update([
                'ship_date' => date('Y-m-d H:i:s'),
                'ship_status' => 3
            ]);

        $this->db->transComplete();

        return $this->db->transStatus();
    }
    public function getPublisherDetails($publisher_id)
    {
        $result = [];

        $publisher_sql = "SELECT * FROM tp_publisher_details WHERE publisher_id = ?";
        $publisher_query = $this->db->query($publisher_sql, [$publisher_id]);
        $publisher_data = $publisher_query->getRowArray();
        $result['publishers_data'][] = $publisher_data;

        $author_sql = "SELECT pad.*, pd.publisher_id 
            FROM tp_publisher_author_details pad 
            JOIN tp_publisher_details pd ON pd.publisher_id = pad.publisher_id 
            WHERE pad.publisher_id = ?";
        $author_query = $this->db->query($author_sql, [$publisher_id]);
        $result['authors_data'] = $author_query->getResultArray();

        $result['author_count'] = $this->db
            ->table('tp_publisher_author_details')
            ->selectCount('author_id', 'author_count')
            ->where('publisher_id', $publisher_id)
            ->get()->getRow('author_count');

        $result['book_count'] = $this->db
            ->table('tp_publisher_bookdetails')
            ->selectCount('book_id', 'book_count')
            ->where('publisher_id', $publisher_id)
            ->get()->getRow('book_count');

        $book_sql = "SELECT pab.*, pad.author_name
            FROM tp_publisher_bookdetails pab 
            JOIN tp_publisher_author_details pad ON pab.author_id = pad.author_id 
            JOIN tp_publisher_details pd ON pab.publisher_id = pd.publisher_id
            WHERE pab.publisher_id = ?";
        $books_query = $this->db->query($book_sql, [$publisher_id]);
        $result['publishers_books_data'] = $books_query->getResultArray();

        $statuses = [
            'active_count_data'    => 1,
            'inactive_count_data'  => 0,
            'pending_count_data'   => 2,
            'active_book_data'     => 1,
            'inactive_book_data'   => 0,
            'pending_book_data'    => 2,
        ];

        foreach ($statuses as $key => $status) {
        $table = str_contains($key, 'book') ? 'tp_publisher_bookdetails' : 'tp_publisher_author_details';
        $query = $this->db->table($table)
            ->selectCount('*', 'cnt')
            ->where('publisher_id', $publisher_id)
            ->where('status', $status)
            ->get();
    
    $row = $query->getRowArray();
    $result[$key] = [$key => $row['cnt'] ?? 0];
        }

        return $result;
    }
    public function getBooks($status = null)
    {
        $builder = $this->db->table('tp_publisher_bookdetails pab');
        $builder->select('pab.*, pad.author_name, pad.status as author_status, pd.publisher_name');
        $builder->join('tp_publisher_author_details pad', 'pab.author_id = pad.author_id');
        $builder->join('tp_publisher_details pd', 'pab.publisher_id = pd.publisher_id');

        if (!is_null($status)) {
            $builder->where('pab.status', $status);
        }

        return $builder->get()->getResultArray();
    }
    public function getFullBookData($book_id)
    {
        $builder = $this->db->table('tp_publisher_bookdetails pab');
        $builder->select('
            pab.*, 
            pad.author_name, pad.author_id, pad.mobile AS author_mobile, pad.email_id AS author_email, 
            pad.author_discription, pad.author_image, pad.created_at AS author_created_at, pad.status AS author_status,
            pd.publisher_id, pd.publisher_name, pd.contact_person, pd.address, pd.mobile, pd.email_id, pd.status AS publisher_status
        ');
        $builder->join('tp_publisher_author_details pad', 'pab.author_id = pad.author_id');
        $builder->join('tp_publisher_details pd', 'pab.publisher_id = pd.publisher_id');
        $builder->where('pab.book_id', $book_id);
        $query = $builder->get();

        $result = [];

        if ($query->getNumRows() > 0) {
            $row = $query->getRowArray();

            $result['books_data'][] = [
                'book_id'             => $row['book_id'],
                'sku_no'              => $row['sku_no'],
                'book_title'          => $row['book_title'],
                'book_regional_title' => $row['book_regional_title'],
                'language'            => $row['language'],
                'no_of_pages'         => $row['no_of_pages'],
                'mrp'                 => $row['mrp'],
                'pustaka_price'       => $row['pustaka_price'],
                'isbn'                => $row['isbn'],
                'status'              => $row['status'],
                'publisher_name'      => $row['publisher_name'],
                'author_name'         => $row['author_name']
            ];

            $result['authors_data'][] = [
                'author_id'          => $row['author_id'],
                'author_name'        => $row['author_name'],
                'mobile'             => $row['author_mobile'],
                'email_id'           => $row['author_email'],
                'author_discription' => $row['author_discription'],
                'author_image'       => $row['author_image'],
                'created_at'         => $row['author_created_at'],
                'status'             => $row['author_status']
            ];

            $result['publishers_data'][] = [
                'publisher_id'   => $row['publisher_id'],
                'publisher_name' => $row['publisher_name'],
                'contact_person' => $row['contact_person'],
                'address'        => $row['address'],
                'mobile'         => $row['mobile'],
                'email_id'       => $row['email_id'],
                'status'         => $row['publisher_status']
            ];
        } else {
            $result['books_data'] = [];
            $result['authors_data'] = [];
            $result['publishers_data'] = [];
        }

        $langQuery = $this->db->table('language_tbl')->orderBy('language_name')->get();
        $result['languages'] = $langQuery->getResultArray();

        return $result;
    }
        public function getEditBooks($book_id = null)
    {
        $builder = $this->db->table('tp_publisher_bookdetails');
        $builder->orderBy('book_title');

        if ($book_id !== null) {
            $builder->where('book_id', $book_id);
            $query = $builder->get(1); 
            return $query->getRowArray(); 
        }

        $query = $builder->get();
        return $query->getResultArray(); 
    }
    public function editBookPost($book_id)
{
    $request = service('request');

    $update_data = [
        'publisher_id'        => $request->getPost('publisher_id'),
        'author_id'           => $request->getPost('author_id'),
        'book_title'          => $request->getPost('book_title'),
        'book_regional_title' => $request->getPost('book_regional_title'),
        'book_url'            => $request->getPost('book_url'),
        'initiate_to_print'   => $request->getPost('initiate_to_print') ? 1 : 0,
        'book_genre'          => $request->getPost('book_genre'),
        'type_name'           => $request->getPost('type_name'),
        'language'            => $request->getPost('language'),
        'book_description'    => $request->getPost('book_description'),
        'no_of_pages'         => $request->getPost('no_of_pages'),
        'mrp'                 => $request->getPost('mrp'),
        'pustaka_price'       => $request->getPost('pustaka_price'),
        'isbn'                => $request->getPost('isbn'),
        'discount'            => $request->getPost('discount'),
        'amazon_link'         => $request->getPost('amazon_link'),
        'amazon_asin'         => $request->getPost('amazon_asin'),
    ];

    $builder = $this->db->table('tp_publisher_bookdetails');
    $builder->where('book_id', $book_id);
    $builder->update($update_data);

    if ($this->db->affectedRows() > 0) {
        return 1;
    } else {
        return 0;
    }
}
public function tpBookSalesData()
{
    $db = \Config\Database::connect(); 

    $builder = $db->table('tp_publisher_sales s');
    $builder->select('
        b.book_title,
        s.sales_channel,
        s.paid_status,
        SUM(s.qty) AS total_qty,
        SUM(s.total_amount) AS total_amount,
        COUNT(DISTINCT s.order_id) AS total_orders
    ');
    $builder->join('tp_publisher_bookdetails b', 's.publisher_id = b.publisher_id AND s.book_id = b.book_id');
    $builder->groupBy(['b.book_title', 's.sales_channel', 's.paid_status']);
    $builder->orderBy('b.book_title');

    return $builder->get()->getResult();
}
public function getAlltpBookDetails()
{
    $builder = $this->db->table('tp_publisher_bookdetails');
    $builder->select('
        tp_publisher_bookdetails.book_id,
        tp_publisher_bookdetails.publisher_id,
        tp_publisher_details.publisher_name,
        tp_publisher_bookdetails.sku_no,
        tp_publisher_bookdetails.book_title,
        tp_publisher_bookdetails.author_id,
        tp_publisher_bookdetails.mrp,
        tp_publisher_book_stock.book_quantity,
        tp_publisher_book_stock.stock_in_hand,
        SUM(tp_publisher_book_stock_ledger.stock_out) as stock_out
    ');

    $builder->join('tp_publisher_book_stock', 'tp_publisher_bookdetails.book_id = tp_publisher_book_stock.book_id', 'left');
    $builder->join('tp_publisher_book_stock_ledger', 'tp_publisher_bookdetails.book_id = tp_publisher_book_stock_ledger.book_id', 'left');
    $builder->join('tp_publisher_details', 'tp_publisher_bookdetails.publisher_id = tp_publisher_details.publisher_id', 'left');

    $builder->groupBy('tp_publisher_bookdetails.book_id');

    $query = $builder->get();

    return $query->getNumRows() > 0 ? $query->getResultArray() : [];
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
        $builder->whereIn('tp_publisher_bookdetails.sku_no', $selected_book_list);

        $query = $builder->get();
        return $query->getResultArray();
    }
    public function tppublisherOrderPost($selected_book_list)
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
        'tp_publisher_bookdetails.author_id',
        'tp_publisher_bookdetails.publisher_id',
        'tp_publisher_author_details.author_name',
        'tp_publisher_book_stock.stock_in_hand',
    ]);

    $builder->join('tp_publisher_author_details', 'tp_publisher_author_details.author_id = tp_publisher_bookdetails.author_id');
    $builder->join('tp_publisher_book_stock', 'tp_publisher_book_stock.book_id = tp_publisher_bookdetails.book_id', 'left');
    $builder->whereIn('tp_publisher_bookdetails.sku_no', $selected_book_list);

    return $builder->get()->getResultArray();
}
public function getPublisherAndAuthorId()
{
    $builder = $this->db->table('tp_publisher_details as p');
    $builder->select('p.publisher_id, a.author_id');
    $builder->join('tp_publisher_author_details as a', 'p.publisher_id = a.publisher_id');
    $result = $builder->get()->getRowArray();

    return $result ?: null;
}
}