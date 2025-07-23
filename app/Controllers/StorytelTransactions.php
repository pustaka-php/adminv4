<?php
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use CodeIgniter\HTTP\ResponseInterface;


class StorytelTransactions extends BaseController
{
    public function upload_transactions()
{
    $file_name = "Q1_2025_royalty_report.xlsx";
    $exchange_rate = 7.5;
    $inputFileName = WRITEPATH . 'storytel_reports/' . $file_name;

    try {
        $spreadsheet = IOFactory::load($inputFileName);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);
        $format = 'm/d/Y';

        $arr_data = [];
        $header = [];
        foreach ($rows as $row => $columns) {
            foreach ($columns as $column => $value) {
                $cell = $sheet->getCell($column . $row);
                if (Date::isDateTime($cell)) {
                    $value = date($format, Date::excelToTimestamp($value));
                } else {
                    $value = (string) $value;
                }

                if ($row == 1) {
                    $header[$row][$column] = $value;
                } else {
                    $arr_data[$row][$column] = $value;
                }
            }
        }

        $column_name = range('A', 'V');
        echo count($arr_data);

        $db = \Config\Database::connect();

        for ($j = 2; $j < count($arr_data) + 2; $j++) {
            $author = $arr_data[$j]['A'] ?? '';
            $ebook_title = $arr_data[$j]['B'] ?? '';
            $isbn = $arr_data[$j]['C'] ?? '';
            $pool = $arr_data[$j]['D'] ?? '';
            $country = $arr_data[$j]['E'] ?? '';
            $price_model = $arr_data[$j]['F'] ?? '';
            $no_of_units = $arr_data[$j]['G'] ?? '';
            $net_receipts_per_hour_local = $arr_data[$j]['H'] ?? '';
            $ecb_exchange_rate = $arr_data[$j]['I'] ?? '';
            $net_receipts_per_hour_sek = $arr_data[$j]['J'] ?? '';
            $book_length_in_hours = $arr_data[$j]['K'] ?? '';
            $price_per_unit = $arr_data[$j]['L'] ?? '';
            $remuneration_sek = $arr_data[$j]['M'] ?? '';
            $remuneration_inr = $remuneration_sek * $exchange_rate;
            $publisher = $arr_data[$j]['O'] ?? '';
            $imprint = $arr_data[$j]['P'] ?? '';
            $consumption_dates = $arr_data[$j]['Q'] ?? '';
            $transaction_date = '2025-03-31'; // Hardcoded fallback

            $bookQuery = $db->table('storytel_books')->where('isbn', $isbn)->get();
            $storytel_book = $bookQuery->getRowArray();

            if (!$storytel_book) {
                echo "Book Not Found: " . $ebook_title . "<br/>";
                continue;
            }

            $author_id = $storytel_book['author_id'];
            $book_id = $storytel_book['book_id'];

            $book_details = $db->table('book_tbl')->where('book_id', $book_id)->get()->getRowArray();
            $copyright_owner = $book_details['copyright_owner'] ?? '';
            $royalty_percentage = $book_details['royalty'] ?? 0;
            $type_of_book = $book_details['type_of_book'] ?? '';
            $language_id = $book_details['language'] ?? '';

            $author_details = $db->table('author_tbl')->where('author_id', $author_id)->get()->getRowArray();
            $author_type = $author_details['author_type'] ?? 0;
            $user_id = $author_details['user_id'] ?? '';

            $final_royalty_value = ($author_type == 1) 
                ? $remuneration_inr * ($royalty_percentage / 100)
                : $remuneration_inr;

            $insert_data = [
                'author' => $author,
                'title' => $ebook_title,
                'isbn' => $isbn,
                'country' => $country,
                'price_model' => $price_model,
                'no_of_units' => $no_of_units,
                'net_receipts_per_hour_local' => $net_receipts_per_hour_local,
                'ecb_exchange_rate' => $ecb_exchange_rate,
                'net_receipts_per_hour_inr' => $net_receipts_per_hour_sek,
                'book_length_in_hours' => $book_length_in_hours,
                'price_per_unit' => $price_per_unit,
                'remuneration_eur' => $remuneration_sek,
                'remuneration_inr' => $remuneration_inr,
                'publisher' => $publisher,
                'imprint' => $imprint,
                'consumption_dates' => $consumption_dates,
                'book_type' => 'ebook',
                'book_id' => $book_id,
                'author_id' => $author_id,
                'language_id' => $language_id,
                'final_royalty_value' => $final_royalty_value,
                'transaction_date' => $transaction_date,
                'copyright_owner' => $copyright_owner,
                'user_id' => $user_id,
                'type_of_book' => $type_of_book,
                'status' => 'O',
            ];

            echo "<pre>"; print_r($insert_data); echo "</pre><br/>";
            $db->table('storytel_transactions')->insert($insert_data);
        }

        echo count($arr_data);
    } catch (\Exception $e) {
        log_message('error', $e->getMessage());
        return redirect()->back()->with('error', 'Upload failed: ' . $e->getMessage());
    }
}
public function upload_audio_transactions()
{
    $file_name = "Q4_2024_royalty_report.xlsx";
    $exchange_rate = 7.1;
    $inputFileName = WRITEPATH . 'uploads/storytel_reports/' . $file_name;

    $sum = 0;
    $bom = 0;

    try {
        $spreadsheet = IOFactory::load($inputFileName);
        $sheet = $spreadsheet->getActiveSheet();
        $cell_collection = $sheet->getCellCollection();
        $format = 'm/d/Y';

        $header = [];
        $arr_data = [];

        foreach ($cell_collection as $cellAddress) {
            $cell = $sheet->getCell($cellAddress);
            $column = $cell->getColumn();
            $row = $cell->getRow();
            $data_value = $cell->getValue();

            if (Date::isDateTime($cell)) {
                $data_value = date($format, Date::excelToTimestamp($data_value));
            } else {
                $data_value = (string) $data_value;
            }

            if ($row == 1) {
                $header[$row][$column] = $data_value;
            } else {
                $arr_data[$row][$column] = $data_value;
            }
        }

        echo count($arr_data);

        $db = \Config\Database::connect();
        $column_name = range('A', 'V');

        for ($j = 2; $j < count($arr_data) + 2; $j++) {
            $author = $arr_data[$j][$column_name[0]] ?? '';
            $ebook_title = $arr_data[$j][$column_name[1]] ?? '';
            $isbn = $arr_data[$j][$column_name[2]] ?? '';
            $country = $arr_data[$j][$column_name[4]] ?? '';
            $price_model = $arr_data[$j][$column_name[5]] ?? '';
            $no_of_units = $arr_data[$j][$column_name[6]] ?? 0;
            $net_receipts_per_hour_local = $arr_data[$j][$column_name[7]] ?? 0;
            $ecb_exchange_rate = $arr_data[$j][$column_name[8]] ?? 0;
            $net_receipts_per_hour_sek = $arr_data[$j][$column_name[9]] ?? 0;
            $book_length_in_hours = $arr_data[$j][$column_name[10]] ?? 0;
            $price_per_unit = $arr_data[$j][$column_name[11]] ?? 0;
            $remuneration_sek = $arr_data[$j][$column_name[12]] ?? 0;
            $remuneration_inr = $remuneration_sek * $exchange_rate;
            $publisher = $arr_data[$j][$column_name[14]] ?? '';
            $imprint = $arr_data[$j][$column_name[15]] ?? '';
            $consumption_dates = $arr_data[$j][$column_name[16]] ?? '';
            $transaction_date = '2024-12-31';

            // Get Storytel Book Info
            $book = $db->table('storytel_books')->where('isbn', $isbn)->get()->getRowArray();
            if (!$book) {
                echo "Book Not Found: " . $ebook_title . "<br/>";
                continue;
            }

            $author_id = $book['author_id'];
            $book_id = $book['book_id'];

            // Get Book Details
            $book_details = $db->table('book_tbl')->where('book_id', $book_id)->get()->getRowArray();
            $royalty_percentage = $book_details['royalty'] ?? 0;
            $copyright_owner = $book_details['copyright_owner'] ?? 0;
            $type_of_book = $book_details['type_of_book'] ?? '';
            $language_id = $book_details['language'] ?? 0;

            // Get Author Info
            $author_details = $db->table('author_tbl')->where('author_id', $author_id)->get()->getRowArray();
            $author_type = $author_details['author_type'] ?? 0;
            $user_id = $author_details['user_id'] ?? 0;

            $final_royalty_value = $author_type == 1
                ? $remuneration_inr * ($royalty_percentage / 100)
                : $remuneration_inr;

            $insert_data = [
                'author' => $author,
                'title' => $ebook_title,
                'isbn' => $isbn,
                'country' => $country,
                'price_model' => $price_model,
                'no_of_units' => $no_of_units,
                'net_receipts_per_hour_local' => $net_receipts_per_hour_local,
                'ecb_exchange_rate' => $ecb_exchange_rate,
                'net_receipts_per_hour_inr' => $net_receipts_per_hour_sek,
                'book_length_in_hours' => $book_length_in_hours,
                'price_per_unit' => $price_per_unit,
                'remuneration_eur' => $remuneration_sek,
                'remuneration_inr' => $remuneration_inr,
                'publisher' => $publisher,
                'imprint' => $imprint,
                'consumption_dates' => $consumption_dates,
                'book_type' => 'audiobook',
                'book_id' => $book_id,
                'author_id' => $author_id,
                'language_id' => $language_id,
                'final_royalty_value' => $final_royalty_value,
                'transaction_date' => $transaction_date,
                'copyright_owner' => $copyright_owner,
                'user_id' => $user_id,
                'type_of_book' => $type_of_book,
                'status' => 'O',
            ];

            echo "<pre>";
            print_r($insert_data);
            echo "<br/>";

            $db->table('storytel_transactions')->insert($insert_data);
        }
    } catch (\Throwable $e) {
        log_message('error', $e->getMessage());
        return show_error($e->getMessage());
    }
}
}