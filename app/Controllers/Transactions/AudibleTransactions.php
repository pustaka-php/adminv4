<?php
namespace App\Controllers\Transactions;
use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AudibleTransactions extends BaseController
{
    public function uploadTransactions()
    {
        $file_name = "Audible_Q1_2025.xlsx";
        $inputFileName = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'audible_reports' . DIRECTORY_SEPARATOR . $file_name;

        if (!file_exists($inputFileName)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => "File not found: $inputFileName"
            ]);
    }

        try {
            $spreadsheet = IOFactory::load($inputFileName);
            $worksheet = $spreadsheet->getActiveSheet();
            $cell_collection = $worksheet->getCellCollection();

            $header = [];
            $arr_data = [];
            foreach ($cell_collection as $cell) {
                $column = $worksheet->getCell($cell)->getColumn();
                $row = $worksheet->getCell($cell)->getRow();
                $data_value = (string) $worksheet->getCell($cell)->getValue();

                if ($row == 1) {
                    $header[$row][$column] = $data_value;
                } else {
                    $arr_data[$row][$column] = $data_value;
                }
            }

            $db = \Config\Database::connect();
            $builder = $db->table('audible_transactions');
            $column_name = range('A', 'Z');
            $column_name = array_merge($column_name, ['AA', 'AB', 'AC', 'AD']);

            $sum = 0;
            for ($j = 3; $j <= count($arr_data) + 1; $j++) {
                $royalty_earner = $arr_data[$j][$column_name[0]] ?? '';
                $parent_product_id = $arr_data[$j][$column_name[1]] ?? '';
                $author = $arr_data[$j][$column_name[2]] ?? '';
                $name = $arr_data[$j][$column_name[3]] ?? '';
                $isbn = $arr_data[$j][$column_name[4]] ?? '';
                $provider_product_id = $arr_data[$j][$column_name[5]] ?? '';
                $transaction_type = $arr_data[$j][$column_name[6]] ?? '';
                $marketplace = $arr_data[$j][$column_name[7]] ?? '';
                $purchase_type = $arr_data[$j][$column_name[8]] ?? '';
                $offer = $arr_data[$j][$column_name[9]] ?? '';
                $royalty_rate = $arr_data[$j][$column_name[10]] ?? '';
                $additional_rule = $arr_data[$j][$column_name[11]] ?? '';
                $payee_split = $arr_data[$j][$column_name[12]] ?? '';
                $total_qty = $arr_data[$j][$column_name[13]] ?? 0;
                $total_net_sales = $arr_data[$j][$column_name[14]] ?? 0;
                $total_royalty = $arr_data[$j][$column_name[15]] ?? 0;
                $transaction_date = '2024-12-31';

                // Audible Book Lookup
                $audible_book = $db->table('audible_books')
                                   ->where('product_id', $parent_product_id)
                                   ->get()
                                   ->getRowArray();

                if (!$audible_book) {
                    continue;
                }

                $language_id = $audible_book['language_id'];
                $author_id = $audible_book['author_id'];
                $book_id = $audible_book['book_id'];
                $copyright_owner = $audible_book['copyright_owner'];

                // Book Details
                $book_details = $db->table('book_tbl')
                                   ->where('book_id', $book_id)
                                   ->get()
                                   ->getRowArray();
                $royalty_percentage = $book_details['royalty'] ?? 0;

                // Author Details
                $author_details = $db->table('author_tbl')
                                     ->where('author_id', $author_id)
                                     ->get()
                                     ->getRowArray();
                $author_type = $author_details['author_type'] ?? '';

                $final_royalty_value = $total_royalty * ($royalty_percentage / 100);

                $insert_data = [
                    'royalty_earner' => $royalty_earner,
                    'parent_product_id' => $parent_product_id,
                    'name' => $name,
                    'author' => $author,
                    'isbn' => $isbn,
                    'provider_product_id' => $provider_product_id,
                    'market_place' => $marketplace,
                    'offer' => $offer,
                    'royalty_rate' => $royalty_rate,
                    'alc_qty' => null,
                    'alc_net_sales' => null,
                    'alc_royalty' => null,
                    'al_qty' => null,
                    'al_net_sales' => null,
                    'al_royalty' => null,
                    'alop_qty' => null,
                    'alop_net_sales' => null,
                    'alop_royalty' => null,
                    'total_qty' => $total_qty,
                    'total_net_sales' => $total_net_sales,
                    'total_royalty' => $total_royalty,
                    'book_id' => $book_id,
                    'author_id' => $author_id,
                    'user_id' => $author_details['user_id'] ?? null,
                    'copyright_owner' => $copyright_owner,
                    'language_id' => $language_id,
                    'final_royalty_value' => $final_royalty_value,
                    'transaction_date' => $transaction_date,
                    'status' => 'O'
                ];

                // $builder->insert($insert_data);
                $sum += $total_net_sales;

                if ($final_royalty_value == 0) {
                    echo "<pre>";
                    print_r($insert_data);
                    echo "</pre>";
                }
            }

            echo "Total Net Sales: $sum";
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setStatusCode(500)->setBody($e->getMessage());
        }
    }
}
