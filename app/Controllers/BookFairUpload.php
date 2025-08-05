<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use CodeIgniter\HTTP\ResponseInterface;
use App\Controllers\BaseController;
use DateTime;

class BookFairUpload extends BaseController
{

//  public function uploadItemwiseSale()
// {
//     ini_set('max_execution_time', 300);

//     $fileName = "CBE-BookFair-Final.xlsx";
//     $bookfairName = "CoimbatoreJuly2025";
//     $bookfairStartDate = "2024-07-18 00:00:00";
//     $bookfairEndDate = "2024-07-27 00:00:00";

//     $inputFileName = WRITEPATH . 'uploads/BookfairReports/' . $fileName;

//     try {
//         $spreadsheet = IOFactory::load($inputFileName);
//         $worksheet = $spreadsheet->getActiveSheet();
//         $data = $worksheet->toArray(null, true, true, true);

//         $columnName = range('A', 'M');
//         $db = \Config\Database::connect();

//         foreach ($data as $rowIndex => $rowData) {
//             if ($rowIndex <= 2) continue; // Skip header rows

//             $isbn     = trim((string) $rowData['A']);
//             $item     = $rowData['B'];
//             $quantity = (int) $rowData['C'];
//             $grossamt = $rowData['D'];
//             $sdamt    = $rowData['E'];
//             $cdamt    = $rowData['F'];
//             $taxable  = $rowData['G'];
//             $taxamt   = $rowData['H'];
//             $cessamt  = $rowData['I'];
//             $total    = $rowData['J'];
//             $profit   = $rowData['K'];
//             $pp       = $rowData['L'];
//             $itemid   = $rowData['M'];

//             // Check for existing record
//             $existing = $db->table('book_fair_item_wise_sale')
//                 ->where(['isbn' => $isbn, 'book_fair_name' => $bookfairName])
//                 ->get()
//                 ->getRowArray();

//             if ($existing) continue;

//             $insertData = [
//                 'item' => $item,
//                 'isbn' => $isbn,
//                 'quantity' => $quantity,
//                 'gross_amount' => $grossamt,
//                 'sd_amount' => $sdamt,
//                 'cd_amount' => $cdamt,
//                 'taxable' => $taxable,
//                 'tax_amount' => $taxamt,
//                 'cess_amount' => $cessamt,
//                 'total_amount' => $total,
//                 'profit_amount' => $profit,
//                 'profit_percentage' => $pp,
//                 'item_id' => $itemid,
//                 'book_fair_name' => $bookfairName,
//                 'book_fair_start_date' => $bookfairStartDate,
//                 'book_fair_end_date' => $bookfairEndDate,
//             ];

//             $db->table('book_fair_item_wise_sale')->insert($insertData);

//             // Normalize ISBN and update stock
//             $normalizedIsbn = preg_replace('/[^0-9]/', '', $isbn);

//             if ($normalizedIsbn !== '') {
//                 $book = $db->query("SELECT book_id, author_name, paper_back_copyright_owner 
//                                     FROM book_tbl 
//                                     WHERE REPLACE(paper_back_isbn, '-', '') = ?", [$normalizedIsbn])
//                            ->getRowArray();

//                 if ($book) {
//                     $bookId = $book['book_id'];
//                     $authorId = $book['author_name'];
//                     $copyrightOwner = $book['paper_back_copyright_owner'];

//                     // Update stock
//                     $db->query("UPDATE paperback_stock SET quantity = quantity - ?, bookfair = ? WHERE book_id = ?", [
//                         $quantity, 0, $bookId
//                     ]);

//                     $stock = $db->query("SELECT quantity FROM paperback_stock WHERE book_id = ?", [$bookId])
//                                 ->getRowArray();

//                     $stockInHand = $stock['quantity'] ?? 0;
//                     $db->query("UPDATE paperback_stock SET stock_in_hand = ? WHERE book_id = ?", [$stockInHand, $bookId]);

//                     // Ledger entry
//                     $stockData = [
//                         'book_id' => $bookId,
//                         'order_id' => time(),
//                         'author_id' => $authorId,
//                         'copyright_owner' => $copyrightOwner,
//                         'description' => $bookfairName,
//                         'channel_type' => 'BKF',
//                         'stock_out' => $quantity,
//                         'transaction_date' => date('Y-m-d H:i:s'),
//                     ];
//                     $db->table('pustaka_paperback_stock_ledger')->insert($stockData);

//                     echo "<pre>";
//                     print_r($insertData);
//                     print_r($stockData);
//                     echo "<br/>--------------------------------";
//                 }
//             }
//         }

//         echo 'Upload complete. Records inserted into `book_fair_item_wise_sale`: ' . (count($data) - 2);

//         // Insert unmatched ISBN records into other table
//         $sql = "INSERT INTO book_fair_other_item_wise_sale 
//                 (SELECT * FROM book_fair_item_wise_sale 
//                  WHERE isbn NOT IN (SELECT REPLACE(paper_back_isbn, '-', '') FROM book_tbl WHERE paper_back_isbn IS NOT NULL) 
//                  AND book_fair_name = ?)";
//         $db->query($sql, [$bookfairName]);
//         $otherCount = $db->affectedRows();

//         echo "<br><br>Inserted into `book_fair_other_item_wise_sale`: $otherCount";

//         log_message('info', "Upload completed: $otherCount unmatched ISBN records inserted.");
//     } catch (\Exception $e) {
//         log_message('error', 'Error uploading item-wise sale: ' . $e->getMessage());
//         return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
//                               ->setBody($e->getMessage());
//     }
// }



public function uploadItemwiseSale()
{
    ini_set('max_execution_time', 1200); // Increase timeout
    ini_set('memory_limit', '512M');    // Increase memory

    $fileName = "CBE-BookFair-Final.xlsx";
    $bookfairName = "CoimbatoreJuly2025";
    $bookfairStartDate = "2024-07-18 00:00:00";
    $bookfairEndDate = "2024-07-27 00:00:00";

    $inputFileName = WRITEPATH . 'uploads/BookfairReports/' . $fileName;

    try {
        $reader = IOFactory::createReaderForFile($inputFileName);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($inputFileName);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray(null, true, true, true);

        $db = \Config\Database::connect();

        $insertBatch = [];
        $ledgerBatch = [];
        $insertedRows = [];
        $skippedRows = [];

        foreach ($data as $rowIndex => $row) {
            if ($rowIndex <= 2) continue;

            $isbn     = trim((string) ($row['A'] ?? ''));
            $item     = $row['B'] ?? '';
            $quantity = (int) ($row['C'] ?? 0);
            $grossamt = $row['D'] ?? 0;
            $sdamt    = $row['E'] ?? 0;
            $cdamt    = $row['F'] ?? 0;
            $taxable  = $row['G'] ?? 0;
            $taxamt   = $row['H'] ?? 0;
            $cessamt  = $row['I'] ?? 0;
            $total    = $row['J'] ?? 0;
            $profit   = $row['K'] ?? 0;
            $pp       = $row['L'] ?? 0;
            $itemid   = $row['M'] ?? '';

            if ($isbn === '') continue;

            // Check duplicate
            $exists = $db->table('book_fair_item_wise_sale')
                ->where(['isbn' => $isbn, 'book_fair_name' => $bookfairName])
                ->countAllResults();

            if ($exists) {
                $skippedRows[] = $isbn;
                continue;
            }

            // Prepare insert
            $insertBatch[] = [
                'item' => $item,
                'isbn' => $isbn,
                'quantity' => $quantity,
                'gross_amount' => $grossamt,
                'sd_amount' => $sdamt,
                'cd_amount' => $cdamt,
                'taxable' => $taxable,
                'tax_amount' => $taxamt,
                'cess_amount' => $cessamt,
                'total_amount' => $total,
                'profit_amount' => $profit,
                'profit_percentage' => $pp,
                'item_id' => $itemid,
                'book_fair_name' => $bookfairName,
                'book_fair_start_date' => $bookfairStartDate,
                'book_fair_end_date' => $bookfairEndDate,
            ];
            $insertedRows[] = $isbn;

            // Process stock if book matched
            $normalizedIsbn = preg_replace('/[^0-9]/', '', $isbn);
            if ($normalizedIsbn !== '') {
                $book = $db->query("SELECT book_id, author_name, paper_back_copyright_owner
                    FROM book_tbl
                    WHERE REPLACE(paper_back_isbn, '-', '') = ?", [$normalizedIsbn])->getRowArray();

                if ($book) {
                    $bookId = $book['book_id'];
                    $authorId = $book['author_name'];
                    $ownerId = $book['paper_back_copyright_owner'];

                    $db->query("UPDATE paperback_stock SET quantity = quantity - ?, bookfair = 0 WHERE book_id = ?", [$quantity, $bookId]);

                    $stockInHand = $db->table('paperback_stock')->select('quantity')->where('book_id', $bookId)->get()->getRow('quantity') ?? 0;
                    $db->query("UPDATE paperback_stock SET stock_in_hand = ? WHERE book_id = ?", [$stockInHand, $bookId]);

                    $ledgerBatch[] = [
                        'book_id' => $bookId,
                        'order_id' => time(),
                        'author_id' => $authorId,
                        'copyright_owner' => $ownerId,
                        'description' => $bookfairName,
                        'channel_type' => 'BKF',
                        'stock_out' => $quantity,
                        'transaction_date' => date('Y-m-d H:i:s'),
                    ];
                }
            }
        }

        // Insert book_fair_item_wise_sale in chunks
        $chunkSize = 200;
        foreach (array_chunk($insertBatch, $chunkSize) as $chunk) {
            $db->table('book_fair_item_wise_sale')->insertBatch($chunk);
        }

        // Insert ledger in chunks
        foreach (array_chunk($ledgerBatch, $chunkSize) as $chunk) {
            $db->table('pustaka_paperback_stock_ledger')->insertBatch($chunk);
        }

        // Insert unmatched ISBNs using optimized LEFT JOIN
        $db->query("
            INSERT INTO book_fair_other_item_wise_sale
            SELECT bfs.*
            FROM book_fair_item_wise_sale bfs
            LEFT JOIN (
                SELECT REPLACE(paper_back_isbn, '-', '') AS clean_isbn FROM book_tbl WHERE paper_back_isbn IS NOT NULL
            ) bt ON REPLACE(bfs.isbn, '-', '') = bt.clean_isbn
            WHERE bt.clean_isbn IS NULL AND bfs.book_fair_name = ?
        ", [$bookfairName]);

        $unmatched = $db->affectedRows();

        // Save inserted and skipped to file (optional)
        file_put_contents(WRITEPATH . 'logs/inserted_isbns.log', implode("\n", $insertedRows));
        file_put_contents(WRITEPATH . 'logs/skipped_isbns.log', implode("\n", $skippedRows));

        echo "✅ Upload complete<br>";
        echo "✔️ Records inserted: " . count($insertedRows) . "<br>";
        echo "⛔ Skipped (already exist): " . count($skippedRows) . "<br>";
        echo "📦 Inserted into book_fair_other_item_wise_sale: $unmatched<br>";
        echo "📁 Logs saved in: <code>" . WRITEPATH . "logs/</code>";

    } catch (\Exception $e) {
        log_message('error', 'Upload Error: ' . $e->getMessage());
        return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                              ->setBody($e->getMessage());
    }
}




}