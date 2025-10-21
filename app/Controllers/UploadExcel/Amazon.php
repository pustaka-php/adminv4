<?php

namespace App\Controllers\UploadExcel;
use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Config\Database;

class Amazon extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
        helper(['form', 'url', 'file', 'email', 'html', 'cookie']);
    }

    public function uploadBooks()
    {
        ini_set('max_execution_time', 600);
        ini_set('memory_limit', '1024M');
        $file_name = "21-oct-25.xlsx";
       $inputFileName = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'ExcelUpload' . DIRECTORY_SEPARATOR. 'amazon' . DIRECTORY_SEPARATOR . $file_name;


        try {
            // Load spreadsheet
            $spreadsheet = IOFactory::load($inputFileName);
            $sheet = $spreadsheet->getActiveSheet();
            $cellCollection = $sheet->getCellCollection();

            $arr_data = [];
            $header = [];
            foreach ($cellCollection as $cell) {
                $column = $sheet->getCell($cell)->getColumn();
                $row    = $sheet->getCell($cell)->getRow();
                $value  = (string) $sheet->getCell($cell)->getValue();

                if ($row == 1) {
                    $header[$row][$column] = $value;
                } else {
                    $arr_data[$row][$column] = $value;
                }
            }
        } catch (\Exception $e) {
            log_message("error", $e->getMessage());
            return $this->response->setStatusCode(500)->setBody("Error: " . $e->getMessage());
        }

        try {
            echo "Excel Rows: " . count($arr_data) . "<br/>";

            $columns = array(
                'A','B','C','D','E','F','G','H','I','J','K','L','M',
                'N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
                'AA','AB','AC','AD'
            );

            for ($j = 2; $j < count($arr_data) + 2; $j++) {
                $reference_id = $arr_data[$j][$columns[0]] ?? '';
                $title        = $arr_data[$j][$columns[1]] ?? '';
                $authors      = $arr_data[$j][$columns[2]] ?? '';
                $language     = $arr_data[$j][$columns[3]] ?? '';
                $rel_date     = $arr_data[$j][$columns[4]] ?? '';

                // release date
                $release_date = null;
                $release_date_flag = !empty($rel_date);
                if ($release_date_flag) {
                    $rel_date = \DateTime::createFromFormat('Ymd', $rel_date);
                    $release_date = $rel_date ? $rel_date->format('Y-m-d') : null;
                }

                // publishing date
                $pub_date = $arr_data[$j][$columns[5]] ?? '';
                $publishing_date = null;
                if (!empty($pub_date)) {
                    $pub_date = \DateTime::createFromFormat('Ymd', $pub_date);
                    $publishing_date = $pub_date ? $pub_date->format('Y-m-d') : null;
                }

                if (!$release_date_flag) {
                    $release_date = $publishing_date;
                }

                $asin = $arr_data[$j][$columns[6]] ?? '';

                // Extract ISBN logic
                $isbn_id = substr($reference_id, 0, 3);
                $isbn_lang_id = null;
                $isbn_author_id = null;
                $isbn_book_id = null;
                $copyright_owner = null;

                if ($isbn_id === '658') {
                    $isbn_lang_id   = ltrim(substr($reference_id, 3, 2), '0');
                    $isbn_author_id = ltrim(substr($reference_id, 5, 3), '0');
                    $isbn_book_id   = ltrim(substr($reference_id, 8, 5), '0');

                    $book_details = $this->db->table('book_tbl')
                        ->where('book_id', $isbn_book_id)
                        ->where('author_name', $isbn_author_id)
                        ->get()
                        ->getRowArray();

                    $copyright_owner = $book_details['copyright_owner'] ?? null;
                } else {
                    $sql_stmt = "SELECT * FROM book_tbl WHERE REPLACE(isbn_number,'-','') = " . $this->db->escape($reference_id);
                    $book_details = $this->db->query($sql_stmt)->getRowArray();

                    $isbn_lang_id   = $book_details['language'] ?? null;
                    $isbn_author_id = $book_details['author_name'] ?? null;
                    $isbn_book_id   = $book_details['book_id'] ?? null;
                    $copyright_owner = $book_details['copyright_owner'] ?? null;
                }

                // Status
                $status = 1;

                // Skip if exists
                $existing = $this->db->table('amazon_books')
                    ->where('reference_id', $reference_id)
                    ->get()
                    ->getRowArray();

                if ($existing) {
                    continue;
                }

                $insert_data = [
                    'reference_id'    => $reference_id,
                    'title'           => $title,
                    'author'          => $authors,
                    'language'        => $language,
                    'release_date'    => $release_date,
                    'publishing_date' => $publishing_date,
                    'asin'            => $asin,
                    'book_id'         => $isbn_book_id,
                    'author_id'       => $isbn_author_id,
                    'copyright_owner' => $copyright_owner,
                    'language_id'     => $isbn_lang_id,
                    'status'          => $status
                ];

                echo "<pre>";
                print_r($insert_data);
                echo "--------------------------------<br/>";

                $this->db->table('amazon_books')->insert($insert_data);
            }

            echo "<br/>Excel Books Count: " . count($arr_data);
        } catch (\Exception $e) {
            log_message("error", $e->getMessage());
            return $this->response->setStatusCode(500)->setBody("Error: " . $e->getMessage());
        }
    }
    public function amazon_excel()
    {
        $bookModel = new BookModel();
        $authorModel = new AuthorModel();
        $genreModel = new GenreModel();

        $langcode = [
            1 => "TAM",
            4 => "MAL",
            5 => "ENG"
        ];

        $bookIds = explode(',', $this->request->getPost('book_ids'));
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $i = 1;

        foreach ($bookIds as $bk) {
            $bk_result = $bookModel->where('book_id', $bk)->first();
            if (!$bk_result) continue;

            // Generate ISBN
            if (!empty($bk_result['isbn_number'])) {
                $ebook_isbn = str_replace('-', '', $bk_result['isbn_number']);
            } else {
                $lang_num = str_pad($bk_result['language'], 2, '0', STR_PAD_LEFT);
                $auth_num = str_pad($bk_result['author_name'], 3, '0', STR_PAD_LEFT);
                $bk_num = str_pad($bk_result['book_id'], 5, '0', STR_PAD_LEFT);
                $ebook_isbn = 658 . $lang_num . $auth_num . $bk_num;
            }

            // Author and Genre details
            $auth_result = $authorModel->where('author_id', $bk_result['author_name'])->first();
            $gen_result = $genreModel->where('genre_id', $bk_result['genre_id'])->first();

            $short_description = !empty($bk_result['description'])
                ? $bk_result['description']
                : ($auth_result['description'] ?? '');

            $sheet->setCellValue('A' . $i, '');
            $sheet->setCellValueExplicit('B' . $i, $ebook_isbn, DataType::TYPE_STRING);
            $sheet->setCellValue('C' . $i, '');
            $sheet->setCellValue('D' . $i, '');
            $sheet->setCellValue('E' . $i, '');
            $sheet->setCellValue('F' . $i, 'Pustaka Digital Media');
            $sheet->setCellValue('G' . $i, $bk_result['book_title']);
            $sheet->setCellValue('H' . $i, $auth_result['author_name'] ?? '');
            $sheet->setCellValue('I' . $i, '');
            $sheet->setCellValue('J' . $i, '');
            $sheet->setCellValue('K' . $i, '');
            $sheet->setCellValue('N' . $i, $langcode[$bk_result['language']] ?? '');
            $sheet->setCellValue('O' . $i, '');
            $sheet->setCellValue('P' . $i, date('Ymd'));
            $sheet->setCellValue('Q' . $i, $short_description);
            $sheet->setCellValue('R' . $i, $gen_result['bisac_code'] ?? '');

            $i++;
        }

        foreach (range('A', 'R') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'amazon-' . date('Ymd') . '.xls';

        if (ob_get_length()) ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xls($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function amazon_price_excel()
    {
        $bookModel = new BookModel();

        $bookIds = explode(',', $this->request->getPost('book_ids'));
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $i = 1;

        foreach ($bookIds as $bk) {
            $bk_result = $bookModel->where('book_id', $bk)->first();
            if (!$bk_result) continue;

            // Generate ISBN
            if (!empty($bk_result['isbn_number'])) {
                $ebook_isbn = str_replace('-', '', $bk_result['isbn_number']);
            } else {
                $lang_num = str_pad($bk_result['language'], 2, '0', STR_PAD_LEFT);
                $auth_num = str_pad($bk_result['author_name'], 3, '0', STR_PAD_LEFT);
                $bk_num = str_pad($bk_result['book_id'], 5, '0', STR_PAD_LEFT);
                $ebook_isbn = 658 . $lang_num . $auth_num . $bk_num;
            }

            // Row 1 - USD
            $sheet->setCellValueExplicit('A' . $i, $ebook_isbn, DataType::TYPE_STRING);
            $sheet->setCellValue('B' . $i, $bk_result['book_cost_international']);
            $sheet->setCellValue('C' . $i, 'USD');

            // Row 2 - INR
            $i2 = $i + 1;
            $sheet->setCellValueExplicit('A' . $i2, $ebook_isbn, DataType::TYPE_STRING);
            $priceINR = ($bk_result['cost'] >= 49) ? $bk_result['cost'] : 49;
            $sheet->setCellValue('B' . $i2, $priceINR);
            $sheet->setCellValue('C' . $i2, 'INR');

            $i += 2;
        }

        foreach (range('A', 'C') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'amazon-pricing-' . date('Ymd') . '.xls';

        if (ob_get_length()) ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xls($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
