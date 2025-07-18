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
        $this->db = \Config\Database::connect(); // ✅ Make sure to store it in a property
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
            b.book_title,
            b.initiate_to_print,
            b.sku_no,
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
        }

        // ✅ Show print button if out of stock and printing is allowed
        $order['show_print_button'] = ($order['book_status'] === 'Out of Stock' && $order['initiate_to_print'] == 1);
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
public function getBooks($status = null)
{
    $builder = $this->db->table('tp_publisher_bookdetails pab');
    $builder->select('pab.*, pad.author_name, pad.status as author_status, pd.publisher_name');
    $builder->join('tp_publisher_author_details pad', 'pab.author_id = pad.author_id', 'left');
    $builder->join('tp_publisher_details pd', 'pab.publisher_id = pd.publisher_id', 'left');

    if (!is_null($status)) {
        $builder->where('pab.status', $status);
    }

    return $builder->get()->getResultArray();
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

    $builder = $db->table('tp_publisher_book_stock_ledger l');
    $builder->select('
        l.book_id, 
        pd.publisher_name,
        ad.author_name,
        bd.book_title,
        SUM(l.stock_out) as total_stock_out,
        SUM(s.book_quantity) as total_stock_in
    ');
    $builder->join('tp_publisher_book_stock s', 's.author_id = l.author_id AND s.book_id = l.book_id', 'left');
    $builder->join('tp_publisher_details pd', 'pd.publisher_id = l.publisher_id', 'left');
    $builder->join('tp_publisher_author_details ad', 'ad.author_id = l.author_id', 'left');
    $builder->join('tp_publisher_bookdetails bd', 'bd.book_id = l.book_id', 'left');

    $builder->groupBy('l.book_id');

    $query = $builder->get();
    return $query->getResult();
}
 public function TpbookAddStock($data)
    {
        $builder = $this->db->table('tp_publisher_book_stock');
        return $builder->insert($data);
    }

    public function getBooksByAuthor($author_id)
    {
        $builder = $this->db->table('tp_publisher_bookdetails');
        $builder->where('author_id', $author_id);
        $builder->orderBy('book_title', 'ASC');
        return $builder->get()->getResult();
    }  
}
