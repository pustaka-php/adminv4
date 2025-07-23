<?php
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use CodeIgniter\HTTP\ResponseInterface;


class PratilipiTransactions extends BaseController
{
    public function upload_transactions()
{
    $file_name = "Q1_2025.xlsx";
    $inputFileName = WRITEPATH . 'uploads/pratilipi_reports/' . $file_name; // Adjust path accordingly
    $transaction_date = "2025-03-31";

    try {
        $spreadsheet = IOFactory::load($inputFileName);
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestDataRow();
        $highestColumn = $worksheet->getHighestDataColumn();

        $arr_data = [];
        $header = [];
        $cell_count = 1;

        foreach ($worksheet->getCellCollection() as $cell) {
            $column = $cell->getColumn();
            $row = $cell->getRow();
            $value = (string)$cell->getValue();

            if ($row == 1) {
                $header[$row][$column] = $value;
                $cell_count++;
            } else {
                $arr_data[$row][$column] = $value;
            }
        }

        echo count($arr_data);

        $column_name = range('A', 'Z');
        $column_name = array_merge($column_name, ['AA', 'AB', 'AC', 'AD']);

        $db = \Config\Database::connect();

        for ($j = 2; $j < count($arr_data) + 2; $j++) {
            $author_name = $arr_data[$j][$column_name[0]] ?? null;
            $user_id = $arr_data[$j][$column_name[1]] ?? null;
            $currency = "INR";
            $earning = $arr_data[$j][$column_name[7]] ?? 0;

            $author_query = $db->table('author_tbl')
                ->where('author_name', $author_name)
                ->get();

            $author_details = $author_query->getRowArray();

            if (!$author_details) {
                log_message('error', "Author not found: " . $author_name);
                continue;
            }

            $copyright_owner = $author_details['copyright_owner'];
            $author_id = $author_details['author_id'];
            $final_royalty_value = $earning * 0.5;

            $insert_data = [
                'user_id' => $user_id,
                'earning' => $earning,
                'currency' => $currency,
                'author_name' => $author_name,
                'copyright_owner' => $copyright_owner,
                'author_id' => $author_id,
                'final_royalty_value' => $final_royalty_value,
                'type_of_book' => 1,
                'transaction_date' => $transaction_date,
                'status' => 'O'
            ];

            echo "<pre>";
            print_r($insert_data);
            echo "--------------------------------\n";

            $db->table('pratilipi_transactions')->insert($insert_data);
            echo "data inserted\n";
        }

        echo "Total rows: " . count($arr_data);
    } catch (\Exception $e) {
        log_message('error', $e->getMessage());
        return $this->response->setStatusCode(500)->setBody($e->getMessage());
    }
}
}
    