<?php

namespace App\Controllers\Transactions;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\IOFactory;
use CodeIgniter\HTTP\ResponseInterface;

class YoutubeTransactions extends BaseController
{
    public function UploadTransactions()
    {
        $file_name = "youtube_transaction.xlsx";
        $inputFileName = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'transactions' . DIRECTORY_SEPARATOR . 'youtube_reports' . DIRECTORY_SEPARATOR . $file_name;

        if (!file_exists($inputFileName)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => "File not found: $inputFileName"
            ]);
        }

        try {
            $spreadsheet = IOFactory::load($inputFileName);
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestDataRow();

            $db = \Config\Database::connect();
            $all_data = [];
            $skipped_rows = [];

            for ($i = 2; $i <= $highestRow; $i++) {
                // Handle string date in format dd-mm-yyyy
                $excelDate = trim((string)$worksheet->getCell("A$i")->getValue());

                if (is_numeric($excelDate)) {
                    // Excel serial number
                    $transaction_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($excelDate)->format('Y-m-d');
                } else {
                    // Try to parse dd-mm-yyyy or other formats
                    $transaction_date_obj = \DateTime::createFromFormat('d-m-Y', $excelDate) ??
                                            \DateTime::createFromFormat('Y-m-d', $excelDate) ??
                                            \DateTime::createFromFormat('d/m/Y', $excelDate) ??
                                            \DateTime::createFromFormat('d-m-Y H:i') ??
                                            null;

                    $transaction_date = $transaction_date_obj ? $transaction_date_obj->format('Y-m-d') : null;
}

                $book_title = trim((string)$worksheet->getCell("B$i")->getValue());
                $author_name = trim((string)$worksheet->getCell("C$i")->getValue());
                $youtube_revenue = (float)$worksheet->getCell("D$i")->getValue();
                $royalty_percentage = (float)$worksheet->getCell("E$i")->getValue();
                $author_royalty_percentage = (float)$worksheet->getCell("G$i")->getValue();

                // Calculate values
                $pustaka_earnings = $youtube_revenue * ($royalty_percentage / 100);
                $final_royalty_value = $pustaka_earnings * ($author_royalty_percentage / 100);

                // Lookup in youtube_books table
                $youtube_book = $db->table('youtube_books')->where('book_title', $book_title)->get()->getRowArray();

                if (!$youtube_book) {
                    $skipped_rows[] = [
                        'row' => $i,
                        'reason' => 'Book not found in youtube_books table',
                        'book_title' => $book_title,
                    ];
                    continue;
                }

                $book_id = $youtube_book['book_id'];
                $author_id = $youtube_book['author_id'];
                $copyright_owner = $youtube_book['copyright_owner'];
                $language_id = $youtube_book['language_id'];

                $insert_data = [
                    'transaction_date' => $transaction_date,
                    'book_title' => $book_title,
                    'author_name' => $author_name,
                    'youtube_revenue' => $youtube_revenue,
                    'royalty_percentage' => $royalty_percentage,
                    'pustaka_earnings' => $pustaka_earnings,
                    'author_royalty_percentage' => $author_royalty_percentage,
                    'final_royalty_value' => $final_royalty_value,
                    'book_id' => $book_id,
                    'author_id' => $author_id,
                    'copyright_owner' => $copyright_owner,
                    'language_id' => $language_id,
                    'status' => 'O',
                ];

                $all_data[] = $insert_data;

                // Uncomment to insert into DB
                // $db->table('youtube_transaction')->insert($insert_data);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Transactions uploaded successfully',
                'skipped' => count($skipped_rows),
                'skipped_details' => $skipped_rows,
                'count' => count($all_data),
                'data' => $all_data,
            ]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
