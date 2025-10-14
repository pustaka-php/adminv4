<?php

namespace App\Models;

use CodeIgniter\Model;

class StockModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function getDashboardDetails()
    {
        $sql1 = "SELECT 
                        COUNT(book_id) AS total_titles, 
                        SUM(quantity) AS total_books, 
                        SUM(stock_in_hand) AS total_stock
                    FROM 
                        paperback_stock
                    WHERE 
                        book_id IN (
                            SELECT book_id 
                            FROM book_tbl 
                            WHERE paper_back_readiness_flag = 1 
                        )";
        $stockInData = $this->db->query($sql1)->getRow();

        $sql2 = "SELECT COUNT(*) AS out_of_stock, COUNT(book_id) AS out_of_stocks_titles, SUM(quantity) AS out_of_stocks_tot FROM paperback_stock WHERE stock_in_hand = 0";
        $outOfStockData = $this->db->query($sql2)->getRow();

        $sql3="SELECT COUNT(DISTINCT book_id) AS total_lost_titles,SUM(lost_qty) AS total_lost_books FROM paperback_stock WHERE lost_qty != 0";
        $lostBooks = $this->db->query($sql3)->getRow();
        
        $sql4="SELECT COUNT(book_id) AS total_title,SUM(bookfair + bookfair2 + bookfair3 + bookfair4 + bookfair5) AS total_books FROM paperback_stock WHERE (bookfair + bookfair2 + bookfair3 + bookfair4 + bookfair5) > 0";
        $outsideStocks = $this->db->query($sql4)->getRow();

        return [
            'stock_in_hand' => $stockInData,
            'out_of_stock'  => $outOfStockData,
            'lost_books'    => $lostBooks,
            'outside_stocks' => $outsideStocks
        ];
    }
    public function getStockDetails()
    {
         $sql="SELECT 
                author_tbl.author_id,
                author_tbl.author_name,
                paperback_stock.book_id,
                book_tbl.book_title,
                paperback_stock.quantity,
                paperback_stock.stock_in_hand,
                paperback_stock.lost_qty,
                paperback_stock.validated_flag,
                paperback_stock.last_validated_date,
                paperback_stock.mismatch_flag
            FROM
                paperback_stock
            JOIN
                book_tbl ON book_tbl.book_id = paperback_stock.book_id
            JOIN
                author_tbl ON author_tbl.author_id = book_tbl.author_name  
            ORDER BY 
                book_tbl.book_id asc";

        $query = $this->db->query($sql);
        $data['stock'] = $query->getResultArray();
        return $data;
    }
    public function getOutofstockdetails()
    {
        $sql="SELECT 
                author_tbl.author_id,
                author_tbl.author_name,
                paperback_stock.book_id,
                book_tbl.book_title,
                paperback_stock.stock_in_hand,
                paperback_stock.lost_qty
            FROM
                paperback_stock
            JOIN
                book_tbl ON book_tbl.book_id = paperback_stock.book_id
            JOIN
                author_tbl ON author_tbl.author_id = book_tbl.author_name
            WHERE 
                paperback_stock.stock_in_hand=0";

        $query = $this->db->query($sql);
        $data['stockout'] = $query->getResultArray();
        return $data;
    }
    public function getLostStockDetails()
    {
        $sql = "SELECT 
                author_tbl.author_id,
                author_tbl.author_name,
                paperback_stock.book_id,
                book_tbl.book_title,
                paperback_stock.stock_in_hand,
                paperback_stock.lost_qty
            FROM
                paperback_stock
            JOIN
                book_tbl ON book_tbl.book_id = paperback_stock.book_id
            JOIN
                author_tbl ON author_tbl.author_id = book_tbl.author_name
            WHERE 
                paperback_stock.lost_qty != 0";

        $query = $this->db->query($sql);
        $data['loststock'] = $query->getResultArray();
        return $data;
    }
    public function getOutsideStockDetails()
    {
        $sql = "SELECT 
                    author_tbl.author_id,
                    author_tbl.author_name,
                    paperback_stock.book_id,
                    book_tbl.book_title,
                    paperback_stock.stock_in_hand,
                    paperback_stock.lost_qty
                FROM 
                    paperback_stock
                JOIN 
                    book_tbl ON book_tbl.book_id = paperback_stock.book_id
                JOIN 
                    author_tbl ON author_tbl.author_id = book_tbl.author_name
                WHERE 
                    (paperback_stock.bookfair + paperback_stock.bookfair2 + paperback_stock.bookfair3 + paperback_stock.bookfair4 + paperback_stock.bookfair5) > 0";

        $query = $this->db->query($sql);
        $data['outside_stock'] = $query->getResultArray();
        return $data;
    }
    // protected $table = 'paperback_stock';     
    // protected $primaryKey = 'book_id';
    // protected $allowedFields = [
    //     'quantity', 'bookfair', 'bookfair2', 'bookfair3',
    //     'bookfair4', 'bookfair5', 'lost_qty', 'stock_in_hand'
    // ];
    public function getPaperbackBooks()
    {
        $sql = "SELECT 
                    book_tbl.book_id, 
                    book_tbl.book_title, 
                    book_tbl.regional_book_title,
                    book_tbl.copyright_owner,
                    book_tbl.author_name,
                    book_tbl.paper_back_pages AS number_of_page, 
                    book_tbl.paper_back_inr, 
                    author_tbl.author_name
                FROM 
                    book_tbl
                JOIN 
                    author_tbl ON author_tbl.author_id = book_tbl.author_name
                WHERE 
                    book_tbl.paper_back_readiness_flag = 1";

        $query = $this->db->query($sql);
        $data['details'] = $query->getResultArray();
        return $data;
    }
    public function getPaperbackSelectedBooksList($selectedBookList)
    {
        if (empty($selectedBookList)) {
            return [];
        }

        $bookIds = explode(',', $selectedBookList);
        $bookIds = array_map('trim', $bookIds);

        $builder = $this->db->table('book_tbl');
        $builder->select('
            book_tbl.book_id,
            book_tbl.book_title,
            book_tbl.copyright_owner,
            book_tbl.regional_book_title,
            book_tbl.paper_back_pages AS number_of_page,
            book_tbl.paper_back_inr,
            author_tbl.author_name,
            pustaka_paperback_books.id,
            (SELECT SUM(quantity) 
            FROM pustaka_paperback_books 
            WHERE book_id = book_tbl.book_id AND completed_flag = 0
            ) AS Qty
        ');
        $builder->join('author_tbl', 'author_tbl.author_id = book_tbl.author_name');
        $builder->join('pustaka_paperback_books', 'pustaka_paperback_books.book_id = book_tbl.book_id', 'left');
        $builder->where('book_tbl.paper_back_flag', 1);
        $builder->whereIn('book_tbl.book_id', $bookIds);
        $builder->groupBy('book_tbl.book_id');

        $query = $builder->get();

        return $query->getResultArray();
    }

    public function submitDetails($book_id, $qty)
    {

         if ( empty($book_id) || empty($qty)) {
            log_message('error', 'Missing data in submitDetails');
            return 0;
        }

        $order_id = time();

        $select_query = "SELECT * FROM paperback_stock WHERE book_id = " . (int)$book_id;
        $result = $this->db->query($select_query);

        if ($result->getNumRows() == 1) {
            $sql = "UPDATE paperback_stock SET quantity = quantity + $qty WHERE book_id = $book_id";
            $sql1 = "UPDATE paperback_stock SET stock_in_hand = stock_in_hand + $qty WHERE book_id = $book_id";
            $sql2 = "UPDATE paperback_stock SET last_update_date = NOW() WHERE book_id = $book_id";
            $sql3 = "UPDATE paperback_stock SET updated_user_id = " . session()->get('user_id') . " WHERE book_id = $book_id";
            $sql4 = "UPDATE paperback_stock SET validated_flag =0 WHERE book_id = $book_id";
            $this->db->query($sql);
            $this->db->query($sql1);
            $this->db->query($sql2);
            $this->db->query($sql3);
            $this->db->query($sql4);
        } else {
            $insert_data = [
                'book_id' => $book_id,
                'quantity' => $qty,
                'stock_in_hand' => $qty,
                'last_update_date' => date('Y-m-d H:i:s'),
                'updated_user_id'=>session()->get('user_id'),
                'validated_flag'=>0,
            ];
            $this->db->table('paperback_stock')->insert($insert_data);
        }

        // Get data for author_transaction
        $transaction_sql = "SELECT  * FROM  book_tbl WHERE book_id = $book_id";
        $tmp1 = $this->db->query($transaction_sql);
        $transaction = $tmp1->getRowArray();

        $royalty_value_inr = $transaction['paper_back_inr'] * $qty * 0.2;
        $comments = "Paperback royalty @ 20%, Per book cost: {$transaction['paper_back_inr']}; Qty: {$qty}";

        $transaction_data = [
            'book_id' => $transaction['book_id'],
            'order_id' => $order_id,
            'order_date' => date('Y-m-d H:i:s'),
            'author_id' => $transaction['author_name'],
            'order_type' => 15,
            'copyright_owner' => $transaction['paper_back_copyright_owner'],
            'currency' => 'INR',
            'book_final_royalty_value_inr' => $royalty_value_inr,
            'pay_status' => 'O',
            'comments' => $comments
        ];
        $this->db->table('author_transaction')->insert($transaction_data);

        // Insert into stock ledger
        $stock_sql = "SELECT  book_tbl.*, paperback_stock.quantity as current_stock
                    FROM  book_tbl 
                    JOIN paperback_stock ON paperback_stock.book_id = book_tbl.book_id
                    WHERE book_tbl.book_id = $book_id";
        $temp = $this->db->query($stock_sql);
        $stock = $temp->getRowArray();

        $stock_data = [
            'book_id' => $stock['book_id'],
            'order_id' => $order_id,
            'author_id' => $stock['author_name'],
            'copyright_owner' => $stock['paper_back_copyright_owner'],
            'description' => "Stock added to Inventory",
            'channel_type' => "STK",
            'stock_in' => $qty,
            'transaction_date' => date('Y-m-d H:i:s')
        ];
        $this->db->table('pustaka_paperback_stock_ledger')->insert($stock_data);

        if ($this->db->affectedRows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    public function getBookDetails($book_id)
    {
        $data = $this->db->table('paperback_stock')
            ->select('book_tbl.book_title, paperback_stock.book_id, paperback_stock.last_update_date, paperback_stock.quantity, paperback_stock.stock_in_hand')
            ->join('book_tbl', 'paperback_stock.book_id = book_tbl.book_id')
            ->where('paperback_stock.book_id', $book_id)
            ->get()
            ->getRowArray();

        return $data;
    }

    public function getAuthorTransaction($book_id)
    {
        return $this->db->table('author_transaction')
            ->select('
                author_transaction.id,
                author_transaction.book_id,
                book_tbl.book_title,
                author_transaction.order_date, 
                author_transaction.comments,
                paperback_stock.quantity,
                paperback_stock.stock_in_hand
            ')
            ->join('book_tbl', 'book_tbl.book_id = author_transaction.book_id')
            ->join('paperback_stock', 'paperback_stock.book_id = author_transaction.book_id')
            ->where('author_transaction.book_id', $book_id)
            ->where('DATE(author_transaction.order_date) = CURDATE()')  
            ->orderBy('author_transaction.id', 'DESC')
            ->get()
            ->getRowArray(); 
    }


    public function getStockLedger($book_id)
    {
        return $this->db->table('pustaka_paperback_stock_ledger')
            ->select('
                pustaka_paperback_stock_ledger.id,
                pustaka_paperback_stock_ledger.transaction_date,
                pustaka_paperback_stock_ledger.book_id,
                pustaka_paperback_stock_ledger.description,
                pustaka_paperback_stock_ledger.stock_in,
                pustaka_paperback_stock_ledger.current_stock AS quantity,
                pustaka_paperback_stock_ledger.channel_type,
                book_tbl.book_title
            ')
            ->join('book_tbl', 'book_tbl.book_id = pustaka_paperback_stock_ledger.book_id')
            ->where('pustaka_paperback_stock_ledger.book_id', $book_id)
            ->orderBy('pustaka_paperback_stock_ledger.id', 'DESC')
            ->get()
            ->getRowArray(); 

    }
    public function updateValidationInfo($book_id, $user_id, $validated_date)
    {
        if (empty($book_id) || empty($user_id)) {
            return false;
        }

        $builder = $this->db->table('paperback_stock');
        $builder->where('book_id', $book_id);

        return $builder->update([
            'validated_flag' => 1,
            'validated_user_id' => $user_id,
            'last_validated_date' => $validated_date
        ]);
    }

    public function getstockuserdetails($book_id)
    {
        $sql="SELECT 
                u1.username AS updated_by,
                u2.username AS validated_by,
                paperback_stock.updated_user_id,
                DATE_FORMAT(paperback_stock.last_update_date, '%d-%m-%Y %H:%i:%s') AS last_update_date,
                paperback_stock.validated_user_id,
                DATE_FORMAT(paperback_stock.last_validated_date, '%d-%m-%Y %H:%i:%s') AS last_validated_date
            FROM 
                paperback_stock
            JOIN 
                users_tbl u1 ON u1.user_id = paperback_stock.updated_user_id
            LEFT JOIN 
                users_tbl u2 ON u2.user_id = paperback_stock.validated_user_id
            WHERE 
                paperback_stock.book_id = $book_id";

        return $this->db->query($sql)->getResultArray();

    }
    public function getOtherDistributionDetails()
    {
        $sql = "SELECT 
                    book_tbl.book_id, 
                    book_tbl.book_title, 
                    book_tbl.regional_book_title,
                    book_tbl.copyright_owner,
                    book_tbl.author_name,
                    book_tbl.paper_back_pages AS number_of_page, 
                    book_tbl.paper_back_inr, 
                    author_tbl.author_name
                FROM 
                    book_tbl
                JOIN 
                    author_tbl ON author_tbl.author_id = book_tbl.author_name
                WHERE 
                    book_tbl.paper_back_flag = 1";

        $query = $this->db->query($sql);
        $data['free'] = $query->getResultArray();
        return $data;
    }

    public function getBookFairDetails()
    {
        $db = \Config\Database::connect();

        $query = $db->query("SELECT GROUP_CONCAT(CONCAT('s.', bookfair_name, ' AS `', retailer_name, '`')) AS dynamic_columns FROM bookfair_retailer_list");
        $row = $query->getRow();
        $dynamicColumns = $row->dynamic_columns ?? '';

        $selectFields = "s.id, s.book_id, s.quantity";
        if (!empty($dynamicColumns)) {
            $selectFields .= ", " . $dynamicColumns;
        }
        $selectFields .= ", s.lost_qty, s.stock_in_hand, s.last_update_date";

        $fullSQL = "SELECT $selectFields FROM paperback_stock s";

        $result = $db->query($fullSQL);

        return $result->getResultArray();  
    }

    public function insertOtherDistribution($data)
    {
        return $this->db->table('paperback_other_distribution')->insert($data);
    }

    public function getMismatchStockDetails()
    {
        $db = \Config\Database::connect();

        // mismatch stock details
        $sql = "SELECT 
                    author_tbl.author_id,
                    author_tbl.author_name,
                    book_tbl.book_id,
                    book_tbl.book_title,
                    paperback_stock.quantity,
                    paperback_stock.stock_in_hand
                FROM 
                    paperback_stock
                JOIN
                    book_tbl ON book_tbl.book_id = paperback_stock.book_id
                JOIN
                    author_tbl ON author_tbl.author_id = book_tbl.author_name
                WHERE
                    quantity != stock_in_hand";

        $query = $this->db->query($sql);
        $data['details'] = $query->getResultArray();
        $sql2 = "SELECT 
                    COUNT(CASE WHEN quantity != stock_in_hand THEN book_id END) AS mismatched_count,
                    SUM(CASE WHEN quantity != stock_in_hand THEN quantity END) AS total_quantity,
                    SUM(stock_in_hand) AS total_stock
                FROM paperback_stock";
        $query2 = $this->db->query($sql2);
        $data['mismatch_count'] = $query2->getRow()->mismatched_count;
        $data['total_quantity'] = $query2->getRow()->total_quantity;
        $data['total_stock'] = $query2->getRow()->total_stock;

         $mismatch_validate_sql = "SELECT 
                    author_tbl.author_id,
                    author_tbl.author_name,
                    book_tbl.book_id,
                    book_tbl.book_title,
                    paperback_stock.quantity,
                    paperback_stock.stock_in_hand
                FROM 
                    paperback_stock
                JOIN
                    book_tbl ON book_tbl.book_id = paperback_stock.book_id
                JOIN
                    author_tbl ON author_tbl.author_id = book_tbl.author_name
                WHERE
                   mismatch_flag = 1";

        $mismatch_validate_query = $this->db->query($mismatch_validate_sql);
        $data['validate'] = $mismatch_validate_query->getResultArray();
        return $data;
    }

    public function getBookfairNames($book_id)
    {
        $db = \Config\Database::connect();

        // Get valid mappings
       $retailers = $db->table('bookfair_retailer_list')
                ->select('bookfair_name, retailer_name')
                ->where('bookfair_name IS NOT NULL')
                ->where('bookfair_name !=', '')
                ->where('retailer_name IS NOT NULL')
                ->where('retailer_name !=', '')
                ->get()
                ->getResultArray();

            // Base fields
            $fields = "ps.book_id, ps.quantity, ps.lost_qty, ps.stock_in_hand";

            // Track aliases to avoid duplicates
            $aliases = [];

            foreach ($retailers as $r) {
                $alias = $r['retailer_name'];

                // Make alias unique if needed
                $i = 1;
                while (in_array($alias, $aliases)) {
                    $alias = $r['retailer_name'] . '_' . $i;
                    $i++;
                }
                $aliases[] = $alias;

                // Add dynamic bookfair column with unique alias
                $fields .= ", ps.`{$r['bookfair_name']}` AS `{$alias}`";
            }

            // Build SQL with query binding for safety
            $sql = "SELECT {$fields} FROM paperback_stock ps WHERE ps.book_id = ?";

            // Execute query
            $query = $db->query($sql, [(int)$book_id]);

            // Return result
            return $query->getResultArray();
    }

        public function getMismatchLog($book_id)
    {
        $db = \Config\Database::connect();

        $retailers = $db->table('bookfair_retailer_list')
            ->select('bookfair_name, retailer_name')
            ->where('bookfair_name IS NOT NULL')
            ->where('bookfair_name !=', '')
            ->where('retailer_name IS NOT NULL')
            ->where('retailer_name !=', '')
            ->get()
            ->getResultArray();

        $fields = "ml.book_id, ml.quantity, ml.lost_qty, ml.stock_in_hand,ml.comments";

         // Track aliases to avoid duplicates

        $aliases = [];
        foreach ($retailers as $r) {
            $alias = $r['retailer_name'];
            $i = 1;
            while (in_array($alias, $aliases)) {
                $alias = $r['retailer_name'] . '_' . $i;
                $i++;
            }
            $aliases[] = $alias;

            $fields .= ", ml.`{$r['bookfair_name']}` AS `{$alias}`";
        }

        $sql = "SELECT {$fields} 
                FROM mismatch_stock_log ml 
                WHERE ml.book_id = ? AND ml.approved_flag = 0";
        $query = $db->query($sql, [(int)$book_id]);

        return $query->getResultArray();
    }

    public function mismatchSubmit($book_id, $updates,$comments)
    {
        $db = \Config\Database::connect();

        $created_by = session()->get('user_id');
        $created_date = date('Y-m-d H:i:s');

        // Check if a row exists for this book_id with approved_flag = 0
        $existing = $db->table('mismatch_stock_log')
                    ->where('book_id', $book_id)
                    ->where('approved_flag', 0)
                    ->get()
                    ->getRow();

        $data = [
            'book_id' => $book_id,
            'approved_flag' => 0,
            'created_by' => $created_by,
            'created_date' => $created_date,
            'comments' => $comments
        ];

        foreach ($updates as $key => $value) {
            // Extract number if value is an array
            $val = is_array($value) ? $value[0] : $value;

            // Handle base fields directly
            if (in_array($key, ['quantity','lost_qty','stock_in_hand'])) {
                $data[$key] = $val;
            } else {
                // Map retailer name to column
                $map = $db->table('bookfair_retailer_list')
                        ->select('bookfair_name')
                        ->where('retailer_name', $key)
                        ->get()
                        ->getRow();

                if ($map && !empty($map->bookfair_name)) {
                    $data[$map->bookfair_name] = $val;
                }
            }
        }

        if ($existing) {
            // Update existing mismatch log row
            $db->table('mismatch_stock_log')
            ->where('book_id', $book_id)
            ->where('approved_flag', 0)
            ->set($data)
            ->update();
        } else {
            // Insert new mismatch log row
            $db->table('mismatch_stock_log')->insert($data);
        }

        //  Always update mismatch_flag in paperback_stock
        $db->table('paperback_stock')
        ->where('book_id', $book_id)
        ->set('mismatch_flag', 1)
        ->update();
    }

     public function mismatchvalidate($book_id, $updates, $comments)
    {
        $db = \Config\Database::connect();
        $builderLog = $db->table('mismatch_stock_log');
        $builderStock = $db->table('paperback_stock');

        // Step 1: Fetch the mismatch log row
        $mismatch = $builderLog
            ->where('book_id', $book_id)
            ->where('approved_flag', 0)
            ->get()
            ->getRowArray();

        if (!$mismatch) {
            return false; // no pending mismatch
        }

        // Step 2: Prepare data to update paperback_stock
        $updateData = [];

        // Basic stock fields
        $stockFields = ['quantity', 'lost_qty', 'stock_in_hand'];
        foreach ($stockFields as $field) {
            if (isset($updates[$field])) {
                $updateData[$field] = is_array($updates[$field]) ? $updates[$field][0] : $updates[$field];
            }
        }

        // Step 3: Map retailer fields dynamically
        $stockColumns = $db->getFieldNames('paperback_stock');
        foreach ($updates as $key => $val) {
            if (!in_array($key, $stockFields)) {
                $mapped = $db->table('bookfair_retailer_list')
                    ->select('bookfair_name')
                    ->where('retailer_name', $key)
                    ->get()
                    ->getRow();

                if ($mapped && in_array($mapped->bookfair_name, $stockColumns)) {
                    $updateData[$mapped->bookfair_name] = is_array($val) ? $val[0] : $val;
                }
            }
        }

        // Step 4: Update paperback_stock
        if (!empty($updateData)) {
            $builderStock
                ->where('book_id', $book_id)
                ->set($updateData)
                ->set('mismatch_flag', 0)
                ->set('validated_user_id', session()->get('user_id'))
                ->set('last_validated_date', date('Y-m-d H:i:s'))
                ->update();
        }

        // Step 5: Update mismatch_stock_log as approved
        $builderLog
            ->where('book_id', $book_id)
            ->where('approved_flag', 0)
            ->set([
                'approved_flag' => 1,
                'approved_date' => date('Y-m-d H:i:s'),
                'comments' => $comments,
                'approved_user_id' => session()->get('user_id')
            ])
            ->update();

        return true;
    }
    
    function mismatchstockcount()
    {
        $sql = "SELECT COUNT(*) AS count FROM paperback_stock WHERE mismatch_flag = 1";
        $query = $this->db->query($sql);
        $result = $query->getRow();
        return $result ? $result->count : 0;
    }
}