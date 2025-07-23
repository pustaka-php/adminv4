<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class GoogleTransactions extends BaseController
{

    public function upload_transactions()
    {
        $file_name = "GoogleEarningsReport_Mar2025.xlsx";
        $currency_exchange = 65;
        $inputFileName = WRITEPATH . 'google_reports/' . $file_name;

        echo "Input File Name: " . $inputFileName . " <br><br>";

        try {
            $spreadsheet = IOFactory::load($inputFileName);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            $header = $rows[0];
            $arr_data = array_slice($rows, 1); // remove header row

            echo "File Extract completed!<br><br>";
            echo count($arr_data);

            $db = \Config\Database::connect();

            // Reference book data
            $book_ref_query = $db->query("SELECT book_tbl.book_id bk_id, author_tbl.author_type auth_type, author_tbl.user_id auth_user_id, book_tbl.royalty royalty_percentage, book_tbl.type_of_book type_of_bk, book_tbl.copyright_owner FROM book_tbl JOIN author_tbl ON book_tbl.author_name = author_tbl.author_id");
            $book_det_ref = [];

            foreach ($book_ref_query->getResult() as $row) {
                $book_det_ref[$row->bk_id] = [
                    $row->auth_type,
                    $row->auth_user_id,
                    $row->royalty_percentage,
                    $row->type_of_bk,
                    $row->copyright_owner
                ];
            }

            echo "Creating associative array for book table & author table - completed!<br><br>";

            // Reference google_books data
            $google_books_query = $db->query("SELECT identifier, book_id, author_id, language_id FROM google_books");
            $google_book_det = [];

            foreach ($google_books_query->getResult() as $row) {
                $google_book_det[$row->identifier] = [
                    $row->book_id,
                    $row->author_id,
                    $row->language_id
                ];
            }

            echo "Creating associative array for google book table - completed!<br><br>";

            foreach ($arr_data as $index => $row) {
                if (empty($row[0])) continue;

                $format = 'm/d/y';

                $earnings_date = Date::excelToDateTimeObject($row[0])->format('Y-m-d');
                $transaction_date = Date::excelToDateTimeObject($row[1])->format('Y-m-d');

                $unique_id = (string) $row[2];
                $product = (string) $row[3];
                $type = (string) $row[4];
                $preorder = (string) $row[5];
                $qty = (string) $row[6];
                $primary_isbn = (string) $row[7];
                $imprint_name = (string) $row[8];
                $title = (string) $row[9];
                $author = (string) $row[10];
                $original_list_price_currency = (string) $row[11];
                $original_list_price = (float) $row[12];
                $list_price_currency = (string) $row[13];
                $list_price_tax_inclusive = (float) $row[14];
                $list_price_tax_exclusive = (float) $row[15];
                $country_of_sale = (string) $row[16];
                $publisher_revenue_percentage = (float) $row[17];
                $publisher_revenue = (float) $row[18];
                $earnings_currency = (string) $row[19];
                $earnings_amount = (float) $row[20];
                $currency_conversion_rate = (!empty($row[21])) ? (float) $row[21] : 1;
                $line_of_business = (string) $row[22];

                $search_key = (strpos($primary_isbn, "978") === 0) ? "ISBN:" . $primary_isbn : $primary_isbn;

                echo "Search key (identifier): $search_key ($primary_isbn)<br><br>";

                $book_id = $google_book_det[$search_key][0] ?? null;
                $author_id = $google_book_det[$search_key][1] ?? null;
                $language_id = $google_book_det[$search_key][2] ?? null;

                echo "Retrieved Book ID, Author ID, Language ID: $book_id ||| $author_id ||| $language_id<br><br>";

                if (!$book_id || !isset($book_det_ref[$book_id])) {
                    echo "Skipping - book details not found<br><br>";
                    continue;
                }

                [$author_type, $user_id, $royalty_percentage, $type_of_book_ref, $copyright_owner] = $book_det_ref[$book_id];

                $inr_value = $earnings_amount * $currency_exchange;

                $final_royalty_value = ($author_type == 1) ?
                    $inr_value * ($royalty_percentage / 100) : $inr_value;

                $insert_data = [
                    'earnings_date' => $earnings_date,
                    'transaction_date' => $transaction_date,
                    'unique_id' => $unique_id,
                    'product' => $product,
                    'type' => $type,
                    'preorder' => $preorder,
                    'qty' => $qty,
                    'primary_isbn' => $primary_isbn,
                    'imprint_name' => $imprint_name,
                    'title' => $title,
                    'author' => $author,
                    'original_list_price_currency' => $original_list_price_currency,
                    'original_list_price' => $original_list_price,
                    'list_price_currency' => $list_price_currency,
                    'list_price_tax_inclusive' => $list_price_tax_inclusive,
                    'list_price_tax_exclusive' => $list_price_tax_exclusive,
                    'country_of_sale' => $country_of_sale,
                    'publisher_revenue_percentage' => $publisher_revenue_percentage,
                    'publisher_revenue' => $publisher_revenue,
                    'earnings_currency' => $earnings_currency,
                    'earnings_amount' => $earnings_amount,
                    'currency_conversion_rate' => $currency_conversion_rate,
                    'line_of_business' => $line_of_business,
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

                $db->table('google_transactions')->insert($insert_data);
                echo "(" . ($index + 2) . ") $author_id - $book_id<br>";
                echo "Inserted for $title with Value as INR $inr_value<br><br>";
            }

            echo count($arr_data);
        } catch (\Throwable $e) {
            log_message('error', $e->getMessage());
            return $this->response->setStatusCode(500)->setBody($e->getMessage());
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
