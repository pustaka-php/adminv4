<?php

namespace App\Controllers;


use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use CodeIgniter\HTTP\ResponseInterface;
use App\Controllers\BaseController;
use DateTime;



class AmazonTransactions extends BaseController
{
    
    
 public function UploadTransactions()
{
    ini_set('max_execution_time', 300); // 5 minutes
    ini_set('memory_limit', '512M');

    $file_name = "Amazon Jun 2025-NL.xlsx";

    $inputFileName = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'amazon_reports' . DIRECTORY_SEPARATOR . 'june' . DIRECTORY_SEPARATOR . $file_name;

    if (!file_exists($inputFileName)) {
        return $this->response->setJSON(['error' => "File not found: $inputFileName"]);
    }

    try {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray(null, true, true, true);

        $db = \Config\Database::connect();
        $all_data = [];

        for ($j = 2; $j <= count($rows); $j++) {
            $row = $rows[$j];

            $in_date = $row['A'];
            if (is_numeric($in_date)) {
                $timestamp = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($in_date);
                $inv_date = DateTime::createFromFormat('Y-m-d', date('Y-m-d', $timestamp));
            } else {
                $inv_date = DateTime::createFromFormat('d/m/Y', $in_date);
            }

            $original_invoice_date = $inv_date ? $inv_date->format('Y-m-d') : null;
            $invoice_date = $inv_date ? (clone $inv_date)->modify('-1 day')->format('Y-m-d') : null;

            $asin = $row['B'];
            $physical_isbn10 = $row['C'];
            $physical_isbn13 = $row['D'];
            $digital_isbn = $row['E'];
            $title = $row['F'];
            $author = $row['G'];
            $units_purchased = (int) $row['J'];
            $units_refunded = (int) $row['K'];
            $net_units = (int) $row['L'];
            $net_units_mtd = (int) $row['M'];
            $adjustments_made = (int) $row['N'];
            $list_price = (float) $row['O'];
            $list_price_currency = $row['P'];
            $publisher_price = (float) $row['Q'];
            $publisher_price_currency = $row['R'];
            $discount_percentage = (int) $row['S'];
            $payment_amount = (float) $row['T'];
            $payment_currency = $row['U'];
            $program_type = $row['V'];

            $amazon_book = $db->table('amazon_books')->where('asin', $asin)->get()->getRowArray();
            if (!$amazon_book) continue;

            $language_id = $amazon_book['language_id'];
            $author_id = $amazon_book['author_id'];
            $book_id = $amazon_book['book_id'];
            $copyright_owner = $amazon_book['copyright_owner'];

            $book_details = $db->table('book_tbl')->where('book_id', $book_id)->get()->getRowArray();
            $royalty_raw = $book_details['royalty'] ?? 0;
            $royalty_percentage = floatval($royalty_raw);

            if (!is_numeric($royalty_raw)) {
                log_message('warning', "Non-numeric royalty value for book_id {$book_id}: " . json_encode($royalty_raw));
            }

            $author_details = $db->table('author_tbl')->where('author_id', $author_id)->get()->getRowArray();
            $author_type = $author_details['author_type'] ?? 1;

            // Currency Conversion
            if ($payment_currency == 'AUD') {
                $currency_exchange = 50;
            } else if ($payment_currency == 'USD') {
                $currency_exchange = 70;
            } else if ($payment_currency == 'GBP') {
                $currency_exchange = 100;
            } else if ($payment_currency == 'CAD') {
                $currency_exchange = 55;
            } else if ($payment_currency == 'EUR') {
                $currency_exchange = 85;
            } else if ($payment_currency == 'BRL') {
                $currency_exchange = 12;
            } else if ($payment_currency == 'JPY') {
                $currency_exchange = 0.5;
            } else {
                $currency_exchange = 0;
            }

            if ($payment_currency !== 'INR') {
                $inr_value = $payment_amount * $currency_exchange;
                $tax = round($inr_value * 0.15, 2);
            } else {
                $inr_value = $payment_amount;
                $tax = round($inr_value * 0.10, 2);
            }

            $inr_after_tax = round($inr_value - $tax, 2);
            $final_royalty_value = $author_type == 1
                ? round($inr_after_tax * ($royalty_percentage / 100), 2)
                : $inr_after_tax;

            $insert_data = [
                'invoice_date' => $invoice_date,
                'original_invoice_date' => $original_invoice_date,
                'asin' => $asin,
                'physical_isbn10' => $physical_isbn10,
                'physical_isbn13' => $physical_isbn13,
                'digital_isbn' => $digital_isbn,
                'title' => $title,
                'author' => $author,
                'units_purchased' => $units_purchased,
                'units_refunded' => $units_refunded,
                'net_units' => $net_units,
                'net_units_mtd' => $net_units_mtd,
                'adjustments_made' => $adjustments_made,
                'list_price' => $list_price,
                'list_price_currency' => $list_price_currency,
                'publisher_price' => $publisher_price,
                'publisher_price_currency' => $publisher_price_currency,
                'discount_percentage' => $discount_percentage,
                'payment_amount' => $payment_amount,
                'payment_currency' => $payment_currency,
                'program_type' => $program_type,
                'book_id' => $book_id,
                'author_id' => $author_id,
                'user_id' => $author_details['user_id'] ?? null,
                'copyright_owner' => $copyright_owner,
                'language_id' => $language_id,
                'currency_exchange' => $currency_exchange,
                'inr_value' => $inr_after_tax,
                'tax_value' => $tax,
                'final_royalty_value' => $final_royalty_value,
                'status' => 'O'
            ];

            $db->table('amazon_transactions')->insert($insert_data);
            $all_data[] = $insert_data;
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Transactions uploaded successfully',
            'count' => count($all_data),
            'data' => $all_data
        ]);
    } catch (\Throwable $e) {
        log_message('error', $e->getMessage());
        return $this->response->setStatusCode(500)->setJSON(['error' => $e->getMessage()]);
    }
}




    
    public function uploadbooks()
    {
        $file_name = "24-may-25.xlsx";
        $inputFileName = APPPATH . 'amazon_reports/' . $file_name;
        echo $inputFileName;

        try {
            // Load spreadsheet file
            $spreadsheet = IOFactory::load($inputFileName);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, true);

            $header = [];
            $arr_data = [];

            foreach ($rows as $rowIndex => $rowData) {
                if ($rowIndex == 1) {
                    $header = $rowData;
                } else {
                    $arr_data[$rowIndex] = $rowData;
                }
            }

            $db = \Config\Database::connect();

            $column_name = range('A', 'AD');
            $insertedCount = 0;

            foreach ($arr_data as $j => $data) {
                $reference_id = $data['A'] ?? '';
                $title = $data['B'] ?? '';
                $authors = $data['C'] ?? '';
                $language = $data['D'] ?? '';
                $rel_date = $data['E'] ?? '';
                $release_date_flag = !empty($rel_date);

                if ($release_date_flag) {
                    $rel_date_obj = \DateTime::createFromFormat('Ymd', $rel_date);
                    $release_date = $rel_date_obj ? $rel_date_obj->format('Y-m-d') : null;
                }

                $pub_date = $data['F'] ?? '';
                if (!empty($pub_date)) {
                    $pub_date_obj = \DateTime::createFromFormat('Ymd', $pub_date);
                    $publishing_date = $pub_date_obj ? $pub_date_obj->format('Y-m-d') : null;
                } else {
                    $publishing_date = null;
                }

                if (!$release_date_flag) {
                    $release_date = $publishing_date;
                }

                $asin = $data['G'] ?? '';
                $status = 1;

                // ISBN logic
                if (substr($reference_id, 0, 3) === '658') {
                    $isbn_lang_id = ltrim(substr($reference_id, 3, 2), '0');
                    $isbn_author_id = ltrim(substr($reference_id, 5, 3), '0');
                    $isbn_book_id = ltrim(substr($reference_id, 8, 5), '0');

                    $book_details = $db->table('book_tbl')
                        ->where('book_id', $isbn_book_id)
                        ->where('author_name', $isbn_author_id)
                        ->get()
                        ->getRowArray();

                    $copyright_owner = $book_details['copyright_owner'] ?? '';
                } else {
                    $ref_id_clean = str_replace('-', '', $reference_id);
                    $book_details_result = $db->query("SELECT * FROM book_tbl WHERE REPLACE(isbn_number,'-','') = ?", [$ref_id_clean])
                        ->getRowArray();

                    $isbn_lang_id = $book_details_result['language'] ?? '';
                    $isbn_author_id = $book_details_result['author_name'] ?? '';
                    $isbn_book_id = $book_details_result['book_id'] ?? '';
                    $copyright_owner = $book_details_result['copyright_owner'] ?? '';
                }

                // Check existing
                $existing = $db->table('amazon_books')
                    ->where('reference_id', $reference_id)
                    ->get()
                    ->getRowArray();

                if ($existing) {
                    continue;
                }

                $insert_data = [
                    'reference_id'     => $reference_id,
                    'title'            => $title,
                    'author'           => $authors,
                    'language'         => $language,
                    'release_date'     => $release_date,
                    'publishing_date'  => $publishing_date,
                    'asin'             => $asin,
                    'book_id'          => $isbn_book_id,
                    'author_id'        => $isbn_author_id,
                    'copyright_owner'  => $copyright_owner,
                    'language_id'      => $isbn_lang_id,
                    'status'           => $status
                ];

                echo "<pre>";
                print_r($insert_data);
                echo "<br>---------------------------<br>";

                $db->table('amazon_books')->insert($insert_data);
                $insertedCount++;
            }

            echo "<br/>Insert Books Count: " . $insertedCount;
            echo "<br/>Excel Books Count: " . count($arr_data);

        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            echo "Error: " . $e->getMessage();
        }
    }
}

