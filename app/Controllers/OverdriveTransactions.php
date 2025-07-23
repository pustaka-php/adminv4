
<?php
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use CodeIgniter\Controller;

class OverdriveTransactions extends BaseController
{
  
public function upload_transactions()
{
    $file_name = "Overdrive_SalesDetail_Mar2025.xlsx";
    $exchange_rate = 65;
    $inputFileName = WRITEPATH . 'overdrive_reports/' . $file_name;

    try {
        $spreadsheet = IOFactory::load($inputFileName);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        $header = $rows[0];
        $arr_data = array_slice($rows, 1); // skip header

        $db = \Config\Database::connect();
        $column_name = range('A', 'V');

        foreach ($arr_data as $index => $row) {
            if (empty($row[0])) continue;

            $transaction_date = Date::excelToDateTimeObject($row[0])->format('Y-m-d');
            $overdrive_id = (string) $row[1];
            $isbn = (string) $row[2];
            $title = (string) $row[3];
            $subtitle = (string) $row[4];
            $author = (string) $row[5];
            $retailer = (string) $row[6];
            $country_of_sale = (string) $row[7];
            $format = (string) $row[8];
            $srp_usd = (float) $row[9];
            $discount = (float) $row[10];
            $amt_owed_usd = (float) $row[11];

            // Fetch overdrive book info
            $od_book = $db->table('overdrive_books')->where('overdrive_id', $overdrive_id)->get()->getRowArray();
            if (!$od_book) continue;

            $author_id = $od_book['author_id'];
            $book_id = $od_book['book_id'];
            $copyright_owner = $od_book['copyright_owner'];
            $isbn = $od_book['isbn'];

            // Fetch book details
            $book = $db->table('book_tbl')->where('book_id', $book_id)->get()->getRowArray();
            if (!$book) continue;

            $royalty_percentage = $book['royalty'];
            $language_id = $book['language'];
            $type_of_book = $book['type_of_book'];

            // Fetch author details
            $author_info = $db->table('author_tbl')->where('author_id', $author_id)->get()->getRowArray();
            if (!$author_info) continue;

            $author_type = $author_info['author_type'];
            $user_id = $author_info['user_id'];

            $inr_value = $amt_owed_usd * $exchange_rate;

            $final_royalty_value = ($author_type == 1)
                ? $inr_value * ($royalty_percentage / 100)
                : $inr_value;

            $insert_data = [
                'transaction_date' => $transaction_date,
                'overdrive_id' => $overdrive_id,
                'isbn' => $isbn,
                'title' => $title,
                'subtitle' => $subtitle,
                'author' => $author,
                'retailer' => $retailer,
                'country_of_sale' => $country_of_sale,
                'format' => $format,
                'srp_usd' => $srp_usd,
                'discount' => $discount,
                'amt_owed_usd' => $amt_owed_usd,
                'book_id' => $book_id,
                'author_id' => $author_id,
                'language_id' => $language_id,
                'exchange_rate' => $exchange_rate,
                'inr_value' => $inr_value,
                'final_royalty_value' => $final_royalty_value,
                'user_id' => $user_id,
                'copyright_owner' => $copyright_owner,
                'type_of_book' => $type_of_book,
                'status' => 'O'
            ];

            echo "<pre>";
            print_r($insert_data);

            $db->table('overdrive_transactions')->insert($insert_data);
        }

        echo "<br><br>Total Rows Processed: " . count($arr_data);
    } catch (\Throwable $e) {
        log_message("error", $e->getMessage());
        return $this->response->setStatusCode(500)->setBody($e->getMessage());
    }
}
}