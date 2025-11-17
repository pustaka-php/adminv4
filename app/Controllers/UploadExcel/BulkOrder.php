<?php

namespace App\Controllers\UploadExcel;

use App\Controllers\BaseController;
use App\Models\PustakapaperbackModel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use DateTime;
use Exception;


class BulkOrder extends BaseController
{
    protected $db;
    protected $PustakapaperbackModel;

    public function __construct()
    {
        $this->PustakapaperbackModel = new PustakapaperbackModel();
        $this->db = \Config\Database::connect();
    }

    public function uploadForm()
    {
        $data['title'] = '';
        $data['subTitle'] = '';
        return view('printorders/upload_form',$data);
    }

    public function processUpload()
    {
        helper(['form', 'url']);

        $file = $this->request->getFile('excel_file');
        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'Please upload a valid Excel file.');
        }

        $newName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads', $newName);
        $filePath = WRITEPATH . 'uploads/' . $newName;

        try {
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, true);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error reading Excel: ' . $e->getMessage());
        }

        $matched = [];
        $mismatched = [];

        foreach ($rows as $i => $row) {
            if ($i == 1) continue; // Skip header

            $book_id = trim($row['A'] ?? '');
            $excel_title = trim($row['B'] ?? '');
            $quantity = (int) ($row['C'] ?? 0);
            $discount = (float) ($row['D'] ?? 0);

            if (empty($book_id)) continue;

            // Get details from database
            $dbBook = $this->db->table('book_tbl')
                ->where('book_id', $book_id)
                ->get()
                ->getRowArray();

            if ($dbBook) {
                $db_title = trim($dbBook['book_title']);

                if (strcasecmp($excel_title, $db_title) === 0) {
                    //  Matched
                    $matched[] = [
                        'book_id' => $book_id,
                        'title' => $db_title,
                        'quantity' => $quantity,
                        'discount' => $discount,
                        'price' => $dbBook['paper_back_inr'] ?? 0,
                    ];
                } else {
                    //  Mismatch
                    $mismatched[] = [
                        'book_id' => $book_id,
                        'excel_title' => $excel_title,
                        'db_title' => $db_title,
                        'quantity' => $quantity,
                        'discount' => $discount
                    ];
                }
            } else {
                $mismatched[] = [
                    'book_id' => $book_id,
                    'excel_title' => $excel_title,
                    'db_title' => 'Not Found in DB',
                    'quantity' => $quantity,
                    'discount' => $discount
                ];
            }
        }

      
       session()->set('matched_books', $matched);
       session()->set('mismatched_books', $mismatched);

        $totalTitles = count($matched);

        return view('printorders/mismatch_summary', [
            'matched' => $matched,
            'mismatched' => $mismatched,
            'totalTitles'=> $totalTitles,
            'title' => '',
            'subTitle' => '',
        ]);
    }

     public function updateMatchedBooks()
    {
        $selected = $this->request->getPost('selected');
        $titles = $this->request->getPost('book_title');
        $quantities = $this->request->getPost('quantity');
        $discounts = $this->request->getPost('discount');

        // Get currently stored data from session
        $matched = session()->get('matched_books') ?? [];
        $mismatched = session()->get('mismatched_books') ?? [];

        if (!empty($selected)) {
            foreach ($selected as $bookId) {
                // Find that mismatched book
                foreach ($mismatched as $key => $book) {
                    if ($book['book_id'] == $bookId) {
                        // Move this to matched
                        $matched[] = [
                            'book_id'  => $book['book_id'],
                            'title'    => $titles[$bookId] ?? $book['db_title'],
                            'quantity' => $quantities[$bookId] ?? $book['quantity'],
                            'discount' => $discounts[$bookId] ?? $book['discount'],
                            'price'    => $book['price'] ?? 0,
                        ];

                        // Remove from mismatched
                        unset($mismatched[$key]);
                        break;
                    }
                }
            }
        }

        // Save updated data in session
        session()->set('matched_books', $matched);
        session()->set('mismatched_books', $mismatched);

        $totalTitles = count($matched);
        // Reload the same view
        return view('printorders/mismatch_summary', [
            'matched' => $matched,
            'mismatched' => $mismatched,
            'totalTitles'=> $totalTitles,
            'title' => '',
            'subTitle' => '',
        ]);
    }


    public function confirmBooks()
    {
        $matchedBooks = session()->get('matched_books');
        $bookshop = $this->PustakapaperbackModel->getBookshopOrdersDetails();
        // If no data found
        if (empty($matchedBooks)) {
            return "No matched books found!";
        }

        // Initialize totals
        $totalTitles = count($matchedBooks);
        $totalQty = 0;
        $totalAmount = 0;

        foreach ($matchedBooks as $item) {
            $qty = $item['quantity'];
            $price = $item['price'];
            $discount = $item['discount'];

            // Discounted price
            $discountedPrice = $price - ($price * ($discount / 100));

            // Amount for this row
            $lineAmount = $discountedPrice * $qty;

            $totalQty += $qty;
            $totalAmount += $lineAmount;
        }

        // Prepare data to send to view
        $data = [
            'matched' => $matchedBooks,
            'totalTitles'  => $totalTitles,
            'totalQty'     => $totalQty,
            'totalAmount'  => $totalAmount,
            'title' => '',
            'subTitle' => '',
            'bookshop' =>  $bookshop
        ];

        // echo "<pre>";
        // print_r($data);
         
        return view('printorders/Bulkorderview', $data);
    }
     
    public function saveOfflineOrder(){
        // echo "<pre>";
		// print_r($_POST);
        
        $postData = $this->request->getPost();
        $books    = json_decode($postData['books'], true);
        unset($postData['books']);

        // print_r($books);

        $result = $this->PustakapaperbackModel->saveOfflineBulkOrder($postData, $books);

        // // Set success flash message
        session()->setFlashdata('success', 
            'Offline bulk order saved successfully!! Order ID: ' . $result['order_id']
        );

        // Redirect back to upload form
        return redirect()->to(base_url('orders/uploadForm'));
    }

    public function saveBookshopOrder(){
      
        // echo "<pre>";
		// print_r($_POST);
        $postData = $this->request->getPost();
        $books    = json_decode($postData['books'], true);
        unset($postData['books']);

        // print_r($books);

        $result = $this->PustakapaperbackModel->saveBookshopBulkOrder($postData, $books);

        // // Set success flash message
        session()->setFlashdata('success', 
            'Bookshop bulk order saved successfully!! Order ID: ' . $result['order_id']
        );

        // Redirect back to upload form
        return redirect()->to(base_url('orders/uploadForm'));
    }


}