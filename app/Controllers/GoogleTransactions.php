<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class GoogleTransactions extends BaseController
{

  
public function uploadTransactions()
{
    $file_name = "GoogleEarningsReport_Apr2025.xlsx";
    $currency_exchange = 65;
    $inputFileName = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'google_reports' . DIRECTORY_SEPARATOR . $file_name;

    if (!file_exists($inputFileName)) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => "File not found: $inputFileName"
        ]);
    }

    try {
        $spreadsheet = IOFactory::load($inputFileName);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray(null, true, true, true);

        $arr_data = array_slice($rows, 1); // remove header
        $column_name = range('A', 'W'); // Columns A to W

        $db = \Config\Database::connect();

        // Book reference array
        $book_query = $db->query("SELECT book_tbl.book_id AS bk_id, author_tbl.author_type AS auth_type, author_tbl.user_id AS auth_user_id, book_tbl.royalty AS royalty_percentage, book_tbl.type_of_book AS type_of_bk, book_tbl.copyright_owner FROM book_tbl JOIN author_tbl ON book_tbl.author_name = author_tbl.author_id");

        $book_det_ref = [];
        foreach ($book_query->getResult() as $row) {
            $book_det_ref[$row->bk_id] = [
                $row->auth_type,
                $row->auth_user_id,
                $row->royalty_percentage,
                $row->type_of_bk,
                $row->copyright_owner
            ];
        }

        // Google book reference array
        $google_query = $db->query("SELECT identifier, book_id, author_id, language_id FROM google_books");
        $google_book_det = [];
        foreach ($google_query->getResult() as $row) {
            $google_book_det[$row->identifier] = [
                $row->book_id,
                $row->author_id,
                $row->language_id
            ];
        }

        $all_data = [];

        foreach ($arr_data as $index => $row) {
            $ear_date = $row['A'] ?? null;
            $trn_date = $row['B'] ?? null;

            if (empty($ear_date) || empty($trn_date)) continue;

            // Parse dates (string or Excel float)
            $earnings_date = is_numeric($ear_date)
                ? Date::excelToDateTimeObject($ear_date)->format('Y-m-d')
                : \DateTime::createFromFormat('d/m/y', $ear_date)?->format('Y-m-d');

            $transaction_date = is_numeric($trn_date)
                ? Date::excelToDateTimeObject($trn_date)->format('Y-m-d')
                : \DateTime::createFromFormat('d/m/y', $trn_date)?->format('Y-m-d');

            $primary_isbn = (string) ($row['H'] ?? '');
            $search_key = (strpos($primary_isbn, "978") === 0) ? "ISBN:" . $primary_isbn : $primary_isbn;

            $google_info = $google_book_det[$search_key] ?? [null, null, null];
            [$book_id, $author_id, $language_id] = $google_info;

            if (!$book_id || !isset($book_det_ref[$book_id])) continue;

            [$author_type, $user_id, $royalty_percentage, $type_of_book_ref, $copyright_owner] = $book_det_ref[$book_id];

            $earnings_amount = (float) ($row['U'] ?? 0);
            $currency_conversion_rate = !empty($row['V']) ? (float) $row['V'] : 1;

            $inr_value = $earnings_amount * $currency_exchange;
            $final_royalty_value = ($author_type == 1) ? $inr_value * ($royalty_percentage / 100) : $inr_value;

            $insert_data = [
                'earnings_date' => $earnings_date,
                'transaction_date' => $transaction_date,
                'unique_id' => $row['C'] ?? '',
                'product' => $row['D'] ?? '',
                'type' => $row['E'] ?? '',
                'preorder' => $row['F'] ?? '',
                'qty' => $row['G'] ?? '',
                'primary_isbn' => $primary_isbn,
                'imprint_name' => $row['I'] ?? '',
                'title' => $row['J'] ?? '',
                'author' => $row['K'] ?? '',
                'original_list_price_currency' => $row['K'] ?? '',
                'original_list_price' => (float) ($row['L'] ?? 0),
                'list_price_currency' => $row['M'] ?? '',
                'list_price_tax_inclusive' => (float) ($row['N'] ?? 0),
                'list_price_tax_exclusive' => (float) ($row['O'] ?? 0),
                'country_of_sale' => $row['P'] ?? '',
                'publisher_revenue_percentage' => (float) ($row['Q'] ?? 0),
                'publisher_revenue' => (float) ($row['R'] ?? 0),
                'earnings_currency' => $row['S'] ?? '',
                'earnings_amount' => $earnings_amount,
                'currency_conversion_rate' => $currency_conversion_rate,
                'line_of_business' => $row['W'] ?? '',
                'book_id' => $book_id,
                'author_id' => $author_id,
                'language_id' => $language_id,
                'currency_exchange' => $currency_exchange,
                'inr_value' => $inr_value,
                'final_royalty_value' => $final_royalty_value,
                'user_id' => $user_id,
                'copyright_owner' => $copyright_owner,
                'type_of_book' => $type_of_book_ref,
                'status' => 'O'
            ];

            // Uncomment to save to DB
            // $db->table('google_transactions')->insert($insert_data);

            $all_data[] = $insert_data;
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Transactions uploaded successfully',
            'count' => count($all_data),
            'data' => $all_data
        ]);
    } catch (\Throwable $e) {
        return $this->response->setStatusCode(500)->setJSON([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
}




    public function uploadBooks()
    {
        $fileName = 'full-catalogue-google.xlsx';
        $filePath = WRITEPATH . 'uploads/google_reports/' . $fileName;

        try {
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, true);

            $columnName = range('A', 'Z');
            foreach (range('AA', 'BB') as $extra) {
                $columnName[] = $extra;
            }

            foreach ($rows as $i => $row) {
                if ($i == 1) continue; // skip header

                $identifier = $row['A'];
                $existing = $this->db->table('google_books')
                    ->where('identifier', $identifier)
                    ->get()
                    ->getRow();

                if ($existing) {
                    echo "Book exists<br>";
                    continue;
                }

                $status = $row['B'];
                if (stripos($status, "Needs action") !== false) continue;

                $play_store_link = $row['C'] ?? null;
                $enable_for_sale = ($row['D'] ?? '') === 'Yes';

                $title = $row['E'];
                echo $identifier . " - " . $title . "<br>";

                $subtitle = $row['F'] ?? null;
                $book_format = $row['G'];

                if (stripos($book_format, "Unsupported - Unknown book") !== false) {
                    echo "Unsupported book<br>";
                    continue;
                }

                $related_identifier = $row['H'] ?? null;
                $contributor = $row['I'];
                $language = $row['J'];

                $publication_date = null;
                $str = null;
                if (!empty($row['K'])) {
                    $excelDate = $row['K'];
                    if (is_numeric($excelDate)) {
                        $dateTime = Date::excelToDateTimeObject($excelDate);
                        $publication_date = $dateTime->format('Y-m-d');
                        $str = $publication_date;
                    }
                }

                $page_count = $row['L'] ?? 0;
                $on_sale_date = $row['M'] ?? null;

                $inr_price = $row['N'] ?? 0;
                $inr_country = $row['O'] ?? null;

                $eur_price = $row['P'] ?? 0;
                $eur_country = $row['Q'] ?? null;

                $usd_price = $row['R'] ?? 0;
                $usd_country = $row['S'] ?? null;

                // Identifier normalization
                $identifier_to_check = $related_identifier ?: $identifier;
                $isbn = substr($identifier_to_check, 0, 13);

                if (stripos($identifier_to_check, "GGKEY") !== false ||
                    stripos($identifier_to_check, "ISBN") !== false ||
                    stripos($identifier_to_check, "PKEY") !== false) {
                    $tok = explode(":", $identifier_to_check);
                    $isbn = $tok[1] ?? $isbn;
                }

                if (substr($identifier_to_check, 0, 3) == '658') {
                    $isbn = substr($identifier_to_check, 0, 13);
                }

                $isbn_no = substr($isbn, 0, 13);
                $isbn_id = substr($isbn_no, 0, 3);

                $isbn_lang_id = null;
                $isbn_author_id = null;
                $isbn_book_id = null;

                if ($isbn_id == '658') {
                    $isbn_lang_id = ltrim(substr($isbn_no, 3, 2), '0');
                    $isbn_author_id = ltrim(substr($isbn_no, 5, 3), '0');
                    $isbn_book_id = ltrim(substr($isbn_no, 8, 5), '0');
                } elseif ($isbn_id == '978') {
                    $book = $this->db->table('book_tbl')
                        ->where("REPLACE(isbn_number, '-', '')", $isbn_no)
                        ->get()
                        ->getRowArray();

                    if ($book) {
                        $isbn_lang_id = $book['language'];
                        $isbn_author_id = $book['author_name'];
                        $isbn_book_id = $book['book_id'];
                    }
                }

                // Get copyright owner from book_tbl
                $copyright_owner = null;
                if ($isbn_book_id) {
                    $book = $this->db->table('book_tbl')
                        ->where('book_id', $isbn_book_id)
                        ->get()
                        ->getRowArray();

                    $copyright_owner = $book['copyright_owner'] ?? null;
                }

                $insertData = [
                    'identifier' => $identifier,
                    'status' => $status,
                    'play_store_link' => $play_store_link,
                    'enable_for_sale' => $enable_for_sale,
                    'title' => $title,
                    'subtitle' => $subtitle,
                    'book_format' => $book_format,
                    'related_identifier' => $related_identifier,
                    'contributor' => $contributor,
                    'language' => $language,
                    'publication_date' => $publication_date,
                    'page_count' => $page_count,
                    'inr_price_excluding_tax' => $inr_price,
                    'inr_countries_excluding_tax' => $inr_country,
                    'usd_price_excluding_tax' => $usd_price,
                    'usd_countries_excluding_tax' => $usd_country,
                    'eur_price_excluding_tax' => $eur_price,
                    'eur_countries_excluding_tax' => $eur_country,
                    'book_id' => $isbn_book_id,
                    'author_id' => $isbn_author_id,
                    'copyright_owner' => $copyright_owner,
                    'language_id' => $isbn_lang_id,
                    'publish_date' => $str
                ];

                // $this->db->table('google_books')->insert($insertData);
                echo $title . "<br>";
            }

            echo "Upload completed!";
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setStatusCode(500)->setBody($e->getMessage());
        }
    }

}
