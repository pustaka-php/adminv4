<?php

namespace App\Controllers;
use App\Models\StockModel; 
use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class Stock extends BaseController
{
    protected $StockModel;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->StockModel = new StockModel();
        helper('url');
        $this->session = session();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'subTitle' => 'Investment',
        ];
        return view('stock/stockDashboard', $data);
    }
    public function stockdashboard()
    {
          

        $data = [
            'details' => $this->StockModel->getDashboardDetails(),
            'title'     => 'Stock Dashboard',
            'subTitle'  => 'Overview',
        ];

        // ob_start();
        // echo "<pre>";
        // print_r($data['details']);
        // echo "</pre>";
        // return ob_get_clean();

        return view('stock/stockDashboard', $data); 
    }
    public function getstockdetails()
    {
        $mismatch_count = $this->stockModel->mismatchstockcount();
        $this->session->set('mismatch_count', $mismatch_count);


       
       $data= [
        'stock_details' => $this->StockModel->getStockDetails(),
        'stock_data' => $this->StockModel->getBookFairDetails(),
        'mismatch_stock' => $this->StockModel->getMismatchStockDetails(),
        'title'     => 'Stock Details',
        'subTitle'  => 'Overview',
       ];
        //    echo"<pre>";
        //   print_r($data);
       return view('stock/stockDetails', $data);
        
    }
    public function outofstockdetails()
    {
          

        $data= [
            'stockout_details' => $this->StockModel->getOutofstockdetails(),
            'title'     => 'Out of Stock Details',
            'subTitle'  => 'Overview',
        ];

        return view('stock/outOfstockDetails', $data);

    }
    public function loststockdetails()
    {
          

        $data= [
            'loststock_details' => $this->StockModel->getLostStockDetails(),
            'title'     => 'Lost Stock Details',
            'subTitle'  => 'Overview',
        ];

        return view('stock/lostStockDetails', $data);
    }
    public function outsidestockdetails()
    {
          

        $data= [

            'outsidestock_details' => $this->StockModel->getOutsideStockDetails(),
            'stock_data' => $this->StockModel->getBookFairDetails(),
            'title'     => 'Outside Stock Details',
            'subTitle'  => 'Overview',
        ];
        //   echo"<pre>";

        // print_r($data);
    
        return view('stock/outSidestockDetails', $data);
    }
    public function addstock()
    {
         

       $data = [    
           'paperback_books' => $this->StockModel->getPaperbackBooks(),
           'title'     => 'Add Stock',
           'subTitle'  => 'Overview',
       ];

        // ob_start();
        // echo "<pre>";
        // print_r($data['paperback_books']);
        // echo "</pre>";
        // return ob_get_clean();

        return view('stock/addStock', $data);
    }
    public function bookslist()
    {
        $selectedBookList = $this->request->getPost('selected_book_list') ?: $this->request->getGet('selected_book_list');

        log_message('debug', 'Selected Books list: ' . $selectedBookList);

          

        $data = [
            'selected_book_id' => $selectedBookList,
            'selected_books_data' => $this->StockModel->getPaperbackSelectedBooksList($selectedBookList),
            'title' => 'Selected Books',
            'subTitle' => 'Overview',
        ];

        return view('stock/stockbooksList', $data);
    }
   public function submitdetails()
    {
        if (!session()->get('user_id')) {
            return redirect()->to(base_url('adminv4'));
        }
          
 
        $book_id = $this->request->getPost('book_id');
        $qty = $this->request->getPost('quantity');
        $updated_user_id = session()->get('user_id');
        $last_update_date = date('Y-m-d H:i:s');
        // $validate_user_id = session()->get('user_id');
        // $last_validated_date = date('Y-m-d H:i:s');

        $result = $this->StockModel->submitDetails($book_id, $qty, $updated_user_id, $last_update_date);

        echo $result;
    }
    
    public function stockentrydetails()
    {
        $book_id = $this->request->getGet('book_id'); 

        if (empty($book_id)) {
            return redirect()->to('stock/stockdashboard')->with('error', 'Invalid request!');
        }

          

        $data = [
            'book_id' => $book_id,
            'book_details' => $this->StockModel->getBookDetails($book_id),
            'author_transaction' => $this->StockModel->getAuthorTransaction($book_id),
            'stock_ledger' => $this->StockModel->getStockLedger($book_id),
            'stock_user_details' => $this->StockModel->getStockUserDetails($book_id), 
            'title' => 'Stock Entry Details',
            'subTitle' => 'Overview',
        ];

        return view('stock/stockEntryDetailsView', $data);
    }
    public function validateStock()
    {
        if (!session()->get('user_id')) {
            return redirect()->to(base_url('adminv4'))->with('error', 'Please login first.');
        }

        $book_id = $this->request->getPost('book_id');
        $user_id = session()->get('user_id');
        $validate_date = date('Y-m-d H:i:s');

        if (empty($book_id)) {
            return redirect()->back()->with('error', 'Book ID is missing.');
        }

          
        $updated = $this->StockModel->updateValidationInfo($book_id, $user_id, $validate_date);

        if ($updated) {
            return redirect()->to('stock/addstock')->with('message', 'Stock validated successfully!');
        } else {
            return redirect()->back()->with('error', 'Validation failed.');
        }

        if (empty($book_id)) {
            return redirect()->to('stock/stockdashboard')->with('error', 'Invalid request!');
        }

          

        $data = [
            'book_id' => $book_id,
            'book_details' => $this->StockModel->getBookDetails($book_id),
            'author_transaction' => $this->StockModel->getAuthorTransaction($book_id),
            'stock_ledger' => $this->StockModel->getStockLedger($book_id),
            'title' => 'Stock Entry Details',
            'subTitle' => 'Overview',
        ];

        return view('stock/stockEntryDetailsView', $data);
    }
    function otherdistribution(){

		$data =[
            'title' => 'Other Distribution',
            'subTitle' => 'Overview',
            'other_distribution' => $this->StockModel->getOtherDistributionDetails(),
        ];

        return view('stock/otherDistribution', $data);
    }
    public function saveotherdistribution()
    {
        $orderData = [
            'order_id'    => time(),
            'order_date'  => date('Y-m-d H:i:s'),
            'book_id'     => $this->request->getPost('book_id'),
            'type'        => $this->request->getPost('type'),
            'purpose'     => $this->request->getPost('purpose'),
            'quantity'    => $this->request->getPost('quantity')
        ];

        $this->StockModel->insertOtherDistribution($orderData);

        return redirect()->back()->with('success', 'Data saved successfully.');
    }


    public function UpdatevalidateStock($bookId)
    {
       
        // Check login
        if (!session()->get('user_id')) {
            return redirect()
                ->to(base_url('adminv4'))
                ->with('error', 'Please login first.');
        }

        $book_id = $bookId;
        $user_id = session()->get('user_id');
        $validate_date = date('Y-m-d H:i:s');

        $updated = $this->StockModel->updateValidationInfo($book_id, $user_id, $validate_date);

        if ($updated) {
            session()->setFlashdata('message', 'Validated successfully!');
        } else {
            session()->setFlashdata('error', 'Validation failed! Please try again.');
        }

        return redirect()->to(base_url('stock/getstockdetails'));

    }

    public function getmismatchstock(){

        $mismatch_count = $this->stockModel->mismatchstockcount();
        $this->session->set('mismatch_count', $mismatch_count);

          
        $data = [
            'mismatch_details' => $this->StockModel->getMismatchStockDetails(),
            'title' => '',
            'subTitle' => 'Overview',
        ];

        return view('stock/mismatchStockViewDetails', $data);
    }
        
    public function mismatchupdate()
    {
        // Get book_id from POST
        $bookId = $this->request->getPost('book_id');
        $actionType = $this->request->getPost('action_type') ?: 'add'; // default to 'add' if not provided

        $stocks      = $this->StockModel->getBookfairNames($bookId);
        $mismatchLog = $this->StockModel->getMismatchLog($bookId);



         $data = [
            'stocks'      => $stocks,
            'mismatchLog' => $mismatchLog,
            'actionType'  => $actionType,
            'title' => '',
            'subTitle' => '',
        ];
        // echo "<pre>";
        // print_r( $data);


        return view('stock/mismatchAdd', $data);
    }

    public function mismatchSubmit()
    {
        $post = $this->request->getPost();
        $comments = $this->request->getPost('comments');

        // book_id is array → get first element
        $book_id = is_array($post['book_id']) ? $post['book_id'][0] : $post['book_id'];

        // Only mismatch fields send to model
        $updates = $post['mismatch'];

        $this->StockModel->mismatchSubmit($book_id, $updates,$comments);

        $mismatch_count = $this->stockModel->mismatchstockcount();
        $this->session->set('mismatch_count', $mismatch_count);



        return redirect()->to('stock/getstockdetails');
    }

    public function mismatchvalidate()
    {
        $post = $this->request->getPost();
        $comments = $this->request->getPost('comment');

    
        // book_id is array → get first element
        $book_id = is_array($post['book_id']) ? $post['book_id'][0] : $post['book_id'];

        // Only mismatch fields send to model
        $updates = $post['mismatch'];

        $this->StockModel->mismatchvalidate($book_id, $updates, $comments);
        
        $mismatch_count = $this->stockModel->mismatchstockcount();
        $this->session->set('mismatch_count', $mismatch_count);

        return redirect()->to('stock/getmismatchstock');
    }
    public function paperbackledgerbooks()
    {
        $data = [
            'title' => '',
            'subTitle' => '',
            'paperback_books' => $this->StockModel->paperbackLedgerBooks(),
        ];

        return view('Stock/paperbackBooksList', $data);
    }
    function paperbackledgerbooksdetails(){

        $book_id = $this->request->getUri()->getSegment(3);
        $data = [
            'title' => '',
            'subTitle' => '',
            'details' => $this->StockModel->paperbackLedgerDetails($book_id),
            'book_id'  => $book_id
        ];
        return view('Stock/paperbackBooksDetails', $data);
	}
    public function paperbackledgerstockdetails()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->setActiveSheetIndex(0);

        $db = \Config\Database::connect();

        $sql = "SELECT book_tbl.book_id, book_tbl.book_title, author_tbl.author_name, book_tbl.paper_back_isbn, 
                        book_tbl.paper_back_inr, language_tbl.language_name, genre_details_tbl.genre_name, 
                        SUM(pustaka_paperback_stock_ledger.stock_in) as stock_in, 
                        SUM(pustaka_paperback_stock_ledger.stock_out) as stock_out, 
                        SUM(pustaka_paperback_stock_ledger.stock_in) - SUM(pustaka_paperback_stock_ledger.stock_out) as current_stock
                FROM book_tbl 
                JOIN author_tbl ON author_tbl.author_id = book_tbl.author_name AND book_tbl.paper_back_readiness_flag = 1
                JOIN language_tbl ON language_tbl.language_id = book_tbl.language
                JOIN genre_details_tbl on genre_details_tbl.genre_id = book_tbl.genre_id 
                JOIN pustaka_paperback_stock_ledger on pustaka_paperback_stock_ledger.book_id = book_tbl.book_id
                GROUP BY book_tbl.book_id";

        $query = $db->query($sql);
        $records = $query->getResultArray();
        $i = 1;

        if (!empty($records)) {
            $headers = [
                'A' => 'Book ID',
                'B' => 'Book Title',
                'C' => 'Author Name',
                'D' => 'ISBN',
                'E' => 'Language',
                'F' => 'Genre',
                'G' => 'MRP',
                'H' => 'Stock In',
                'I' => 'Stock Out',
                'J' => 'Current Stock',
            ];

            foreach ($headers as $column => $header) {
                $sheet->setCellValue($column . '1', $header);
            }

            $i++;
        }

        foreach ($records as $record) {
            $sheet->setCellValue('A' . $i, $record['book_id']);
            $sheet->setCellValue('B' . $i, $record['book_title']);
            $sheet->setCellValue('C' . $i, $record['author_name']);
            $sheet->setCellValue('D' . $i, $record['paper_back_isbn']);
            $sheet->setCellValue('E' . $i, $record['language_name']);
            $sheet->setCellValue('F' . $i, $record['genre_name']);
            $sheet->setCellValue('G' . $i, $record['paper_back_inr']);
            $sheet->setCellValue('H' . $i, $record['stock_in']);
            $sheet->setCellValue('I' . $i, $record['stock_out']);
            $sheet->setCellValue('J' . $i, $record['current_stock']);
            $i++;
        }

        $filename = 'stock_list_' . date('Y-m-d') . '.xls';

        // Output headers for browser download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xls($spreadsheet);
        $writer->save('php://output');
        exit;
    }
    public function freebooksstatus()
    {
        $data = [
            'title' => '',
            'subTitle' => '',
            'print'=>$this->StockModel->getFreeBooksStatus(),    
        ];

        return view('stock/freeBooksStatusView', $data);
    }
     //free book Initiate Print
    public function markstart()
    {
        $result = $this->StockModel->markStart();
        return $this->response->setJSON($result);
    }

    public function markcovercomplete()
    {
        $result = $this->StockModel->markCoverComplete();
        return $this->response->setJSON($result);
    }

    public function markcontentcomplete()
    {
        $result = $this->StockModel->markContentComplete();
        return $this->response->setJSON($result);
    }

    public function marklaminationcomplete()
    {
        $result = $this->StockModel->markLaminationComplete();
        return $this->response->setJSON($result);
    }

    public function markbindingcomplete()
    {
        $result = $this->StockModel->markBindingComplete();
        return $this->response->setJSON($result);
    }

    public function markfinalcutcomplete()
    {
        $result = $this->StockModel->markFinalCutComplete();
        return $this->response->setJSON($result);
    }

    public function markqccomplete()
    {
        $result = $this->StockModel->markQCComplete();
        return $this->response->setJSON($result);
    }

    public function markcompleted()
    {
        $result = $this->StockModel->markCompleted();
        return $this->response->setJSON($result);
    }


}