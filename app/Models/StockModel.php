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
                        );";
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
        return $this->db->table('paperback_stock')
            ->select('
                author_tbl.author_id,
                author_tbl.author_name,
                paperback_stock.book_id,
                book_tbl.book_title,
                paperback_stock.stock_in_hand,
                paperback_stock.lost_qty
            ')
            ->join('book_tbl', 'book_tbl.book_id = paperback_stock.book_id')
            ->join('author_tbl', 'author_tbl.author_id = book_tbl.author_name')
            ->where('book_tbl.paper_back_readiness_flag', 1) 
            ->get()
            ->getResult();
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
    protected $table = 'paperback_stock';     
    protected $primaryKey = 'book_id';
    protected $allowedFields = [
        'quantity', 'bookfair', 'bookfair2', 'bookfair3',
        'bookfair4', 'bookfair5', 'lost_qty', 'stock_in_hand'
    ];
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
                    book_tbl.paper_back_flag = 1
                    AND book_tbl.book_id NOT IN (
                        SELECT book_id FROM paperback_stock
                    )";

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

     function submitDetails(){
       $book_id = $request->getPost('book_id');
       $qty = $request->getPost('quantity');

       $select_query = "SELECT * FROM paperback_stock where book_id=".$book_id;
       $result = $this->db->query($select_query);
       

        if($result->num_rows() == 1)
        {
            $sql = "UPDATE paperback_stock set quantity=quantity+".$qty." where book_id=".$book_id;
            $sql1 = "UPDATE paperback_stock set stock_in_hand=stock_in_hand+".$qty." where book_id=".$book_id;
            $this->db->query($sql);
            $this->db->query($sql1);
        }
        else
        {
            $insert_data = array (
                'book_id' => $book_id,
                'quantity' => $qty,
                'stock_in_hand'=>$qty,
                'last_update_date'=> date('Y-m-d H:i:s')
            );
            $this->db->insert("paperback_stock", $insert_data);
        }
        //Inserting record into author_transaction table for the royalty
  
        $transaction_sql="SELECT pustaka_paperback_books.*,book_tbl.* from pustaka_paperback_books,book_tbl
                          where pustaka_paperback_books.book_id=book_tbl.book_id 
                          and book_tbl.book_id = ".$book_id ." AND pustaka_paperback_books.id = '".$id."'";
        $tmp1 = $this->db->query($transaction_sql);
        $transaction = $tmp1->result_array()[0];

        $book_id=$transaction['book_id'];
        $order_id=$transaction['order_id'];
        $author_id=$transaction['author_name'];
        $copyright_owner=$transaction['paper_back_copyright_owner'];
        $royalty_value_inr = $transaction['paper_back_inr'] * $transaction['quantity'] * 0.2;
        $comments="Paperback royalty @ 20%, Per book cost: {$transaction['paper_back_inr']}; Qty: {$transaction['quantity']}";
        
        $transaction_data = array(
            'book_id' => $book_id,
            "order_id" => $order_id,
            "order_date" => date('Y-m-d H:i:s'),
            "author_id" => $author_id,
            "order_type" => 15,
            "copyright_owner" => $copyright_owner,
            "currency" =>'INR',
            "book_final_royalty_value_inr" =>$royalty_value_inr,
            "pay_status" => 'O',
            "comments" =>$comments
        );
        $this->db->insert('author_transaction', $transaction_data);

       // inserting the record into pustaka_paperback_stock_ledger table 

        $stock_sql="SELECT pustaka_paperback_books.*,book_tbl.* ,paperback_stock.quantity as current_stock,
                    pustaka_paperback_books.quantity as quantity 
                    from pustaka_paperback_books,book_tbl,paperback_stock
                    where pustaka_paperback_books.book_id=book_tbl.book_id
                    and paperback_stock.book_id=pustaka_paperback_books.book_id
                    and book_tbl.book_id = ".$book_id ." AND pustaka_paperback_books.id = '".$id."'";
        $temp = $this->db->query($stock_sql);
        $stock = $temp->result_array()[0];

        $book_id=$stock['book_id'];
        $order_id=$stock['order_id'];
        $author_id=$stock['author_name'];
        $copyright_owner=$stock['paper_back_copyright_owner'];
        $description="Stock added to Inventory";
        $channel_type="STK";
        $stock_in=$stock['quantity'];

       
        $stock_data = array(
            'book_id' => $book_id,
            "order_id" => $order_id,	
            "author_id" => $author_id,
            "copyright_owner" => $copyright_owner,
            "description" => $description,
            "channel_type" => $channel_type,
            "stock_in" => $stock_in,
            'transaction_date' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('pustaka_paperback_stock_ledger', $stock_data);
       

        if ($this->db->affected_rows() > 0) {
            return 1;
        }
        else {
            return 0;
        }
    }
}