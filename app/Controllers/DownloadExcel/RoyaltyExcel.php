<?php

namespace App\Controllers\DownloadExcel;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

use App\Models\RoyaltyModel;

class RoyaltyExcel extends BaseController
{

    protected $royaltyModel;
    protected $helpers = ['form', 'url', 'file', 'email', 'html', 'cookie', 'string'];

    public function __construct()
    {
        helper($this->helpers);

        $this->royaltyModel = new RoyaltyModel();
        session();
    }

   public function downloadBankExcel()
    {
        $royaltyModel = new RoyaltyModel();
        $royaltyData = $royaltyModel->getRoyaltyConsolidatedData();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $currentDate = date('M Y');
        $i = 1;

        foreach ($royaltyData as $record) {
            if ($record['total_after_tds'] > 500 && $record['bank_status'] === "Yes") {
                $publisher_royalty = $record['publisher_name'] . " Author Royalty " . $currentDate;
                $pub_royalty = preg_replace('/[^A-Za-z0-9]/', '', $record['publisher_name']) . "AuthorRoyalty" . $currentDate;
                $pub_name_year = substr(preg_replace('/[^A-Za-z0-9]/', '', $record['publisher_name']), 0, 6) . date('MY');
                $pustaka_acc_no = "918020059111502";

                $sheet->setCellValue('A' . $i, "N");
                $sheet->setCellValue('B' . $i, number_format($record['total_after_tds'], 2, '.', ''));
                $sheet->setCellValue('C' . $i, date('d-m-Y'));
                $sheet->setCellValue('D' . $i, $record['bank_acc_name']);
                $sheet->setCellValueExplicit('E' . $i, $record['bank_acc_no'], DataType::TYPE_STRING);
                $sheet->setCellValue('F' . $i, $record['email_id']);
                $sheet->setCellValue('G' . $i, $publisher_royalty);
                $sheet->setCellValueExplicit('H' . $i, $pustaka_acc_no, DataType::TYPE_STRING);
                $sheet->setCellValue('I' . $i, $pub_name_year);
                $sheet->setCellValueExplicit('J' . $i, $record['ifsc_code'], DataType::TYPE_STRING);
                $sheet->setCellValue('K' . $i, "10");
                $sheet->setCellValue('L' . $i, $pub_royalty);
                $sheet->setCellValueExplicit('M' . $i, $record['mobile'], DataType::TYPE_STRING);

                $i++;
            }
        }

        foreach (range('A', 'M') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'bank-excel-' . $currentDate . '.xls';

        // Clear any previous output
        if (ob_get_length()) {
            ob_end_clean();
        }

        // Set HTTP headers for file download
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        // Write Excel to output
        $writer = new Xls($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
