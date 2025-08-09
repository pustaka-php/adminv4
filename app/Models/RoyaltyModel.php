<?php

namespace App\Models;

use CodeIgniter\Model;

class RoyaltyModel extends Model
{
    protected $db;
    protected $table = 'publisher_tbl'; 
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect(); 
    }

    public function getRoyaltyConsolidatedData()
    {
        $result = [];
        $record = [];

        $sql = "SELECT 
                    publisher_tbl.publisher_name,
                    publisher_tbl.copyright_owner,
                    publisher_tbl.bonus_percentage,
                    publisher_tbl.tds_flag,
                    publisher_tbl.bank_acc_no,
                    publisher_tbl.email_id,
                    publisher_tbl.mobile,
                    publisher_tbl.ifsc_code,
                    publisher_tbl.bank_acc_name,
                    SUM(CASE WHEN type = 'ebook' THEN royalty ELSE 0 END) AS outstanding_ebooks,
                    SUM(CASE WHEN type = 'audiobook' THEN royalty ELSE 0 END) AS outstanding_audiobooks,
                    SUM(CASE WHEN type = 'paperback' THEN royalty ELSE 0 END) AS outstanding_paperbacks
                FROM 
                    publisher_tbl
                LEFT JOIN 
                    royalty_consolidation 
                    ON publisher_tbl.copyright_owner = royalty_consolidation.copyright_owner
                AND royalty_consolidation.pay_status = 'O' 
            GROUP BY 
                    publisher_tbl.copyright_owner, 
                    publisher_tbl.publisher_name,
                    publisher_tbl.bonus_percentage,
                    publisher_tbl.tds_flag,
                    publisher_tbl.bank_acc_no,
                    publisher_tbl.email_id,
                    publisher_tbl.mobile,
                    publisher_tbl.ifsc_code,
                    publisher_tbl.bank_acc_name";

        $query = $this->db->query($sql);

        foreach ($query->getResultArray() as $row) {
            $record['publisher_name'] = $row['publisher_name'];
            $copyright_owner = $row['copyright_owner'];
            $record['copyright_owner'] = $copyright_owner;

            $record['ebooks_outstanding'] = (float) $row['outstanding_ebooks'];
            $record['audiobooks_outstanding'] = (float) $row['outstanding_audiobooks'];
            $record['paperbacks_outstanding'] = (float) $row['outstanding_paperbacks'];

            $record['bonus_percentage'] = (float) $row['bonus_percentage'];
            $record['tds_flag'] = (int) $row['tds_flag'];

            $record['bonus_value'] = ($record['ebooks_outstanding'] + $record['audiobooks_outstanding']) * $record['bonus_percentage'] / 100;

            $record['bank_status'] = empty($row['bank_acc_no']) ? 'No' : 'Yes';

            $record['total_outstanding'] = $record['ebooks_outstanding']
                                        + $record['audiobooks_outstanding']
                                        + $record['paperbacks_outstanding']
                                        + $record['bonus_value'];

            $record['tds_value'] = ($record['tds_flag'] === 1)
                ? $record['total_outstanding'] * 0.10
                : 0;

            $record['total_after_tds'] = $record['total_outstanding'] - $record['tds_value'];

            $record['bank_acc_no'] = $row['bank_acc_no'];
            $record['email_id'] = $row['email_id'];
            $record['mobile'] = $row['mobile'];
            $record['ifsc_code'] = $row['ifsc_code'];
            $record['bank_acc_name'] = $row['bank_acc_name'];

            $result[$copyright_owner] = $record;
        }
            $total = array_column($result, 'total_outstanding');
            array_multisort($total, SORT_DESC, $result);

        return $result;
    }
    function getebookbreakupDetails($copyright_owner)
    {
        $sql = "WITH channel_transaction AS (
                    SELECT 'Amazon' AS channel, SUM(final_royalty_value) AS transaction_amount
                    FROM amazon_transactions
                    WHERE copyright_owner = ? AND status = 'O'

                    UNION ALL

                    SELECT 'OverDrive', SUM(final_royalty_value)
                    FROM overdrive_transactions
                    WHERE copyright_owner = ? AND type_of_book = 1 AND status = 'O'

                    UNION ALL

                    SELECT 'Scribd', SUM(converted_inr)
                    FROM scribd_transaction
                    WHERE copyright_owner = ? AND status = 'O'

                    UNION ALL

                    SELECT 'Pratilipi', SUM(final_royalty_value)
                    FROM pratilipi_transactions
                    WHERE copyright_owner = ? AND type_of_book = 1 AND status = 'O'

                    UNION ALL

                    SELECT 'Google', SUM(final_royalty_value)
                    FROM google_transactions
                    WHERE copyright_owner = ? AND type_of_book = 1 AND status = 'O'

                    UNION ALL

                    SELECT 'Storytel', SUM(final_royalty_value)
                    FROM storytel_transactions
                    WHERE copyright_owner = ? AND type_of_book = 1 AND status = 'O'

                    UNION ALL

                    SELECT 'Kobo', SUM(paid_inr)
                    FROM kobo_transaction
                    WHERE copyright_owner = ? AND status = 'O'

                    UNION ALL

                    SELECT 'Pustaka', SUM(book_final_royalty_value_inr)
                    FROM author_transaction
                    WHERE copyright_owner = ?
                    AND pay_status = 'O'
                    AND order_type = 1
                    AND order_date <= '2025-06-30'
                ),

                royalty_consolidation AS (
                    SELECT 
                        channel, 
                        SUM(royalty) AS consolidation_amount
                    FROM royalty_consolidation
                    WHERE 
                        copyright_owner = ?
                        AND pay_status = 'O'
                        AND type = 'ebook'
                    GROUP BY channel
                )

                SELECT 
                    COALESCE(rc.channel, ct.channel) AS channel,
                    rc.consolidation_amount,
                    ct.transaction_amount
                FROM royalty_consolidation rc
                LEFT JOIN channel_transaction ct ON rc.channel = ct.channel

                UNION

                SELECT 
                    COALESCE(rc.channel, ct.channel) AS channel,
                    rc.consolidation_amount,
                    ct.transaction_amount
                FROM royalty_consolidation rc
                RIGHT JOIN channel_transaction ct ON rc.channel = ct.channel

                ORDER BY channel";

        $query = $this->db->query($sql, [
            $copyright_owner, $copyright_owner, $copyright_owner,
            $copyright_owner, $copyright_owner, $copyright_owner,
            $copyright_owner, $copyright_owner, $copyright_owner
        ]);

        $result = $query->getResultArray();

        $final = [];
        foreach ($result as $row) {
            $key = strtolower($row['channel']); 
            $final[$key] = $row;
        }

        return $final;
    }

    public function getaudiobreakupDetails($copyright_owner)
    {
        $sql = "WITH channel_transaction AS (
                SELECT 'Audible' AS channel, SUM(final_royalty_value) AS transaction_amount
                FROM audible_transactions
                WHERE copyright_owner = ? AND status = 'O'

                UNION ALL

                SELECT 'OverDrive', SUM(final_royalty_value)
                FROM overdrive_transactions
                WHERE copyright_owner = ? AND type_of_book = 3 AND status = 'O'

                UNION ALL

                SELECT 'Pratilipi', SUM(final_royalty_value)
                FROM pratilipi_transactions
                WHERE copyright_owner = ? AND type_of_book = 3 AND status = 'O'

                UNION ALL

                SELECT 'Google', SUM(final_royalty_value)
                FROM google_transactions
                WHERE copyright_owner = ? AND type_of_book = 3 AND status = 'O'

                UNION ALL

                SELECT 'Storytel', SUM(final_royalty_value)
                FROM storytel_transactions
                WHERE copyright_owner = ? AND type_of_book = 3 AND status = 'O'

                UNION ALL

                SELECT 'KukuFM', SUM(final_royalty_value)
                FROM kukufm_transactions
                WHERE copyright_owner = ? AND status = 'O'

                UNION ALL

                SELECT 'YouTube', SUM(final_royalty_value)
                FROM youtube_transaction
                WHERE copyright_owner = ? AND status = 'O'

                UNION ALL

                SELECT 'Pustaka', SUM(book_final_royalty_value_inr)
                FROM author_transaction
                WHERE copyright_owner = ?
                AND pay_status = 'O'
                AND order_type IN (3,4,5,6)
                AND order_date <= '2025-06-30'
            ),

            royalty_consolidation_data AS (
                SELECT 
                    channel, 
                    SUM(royalty) AS consolidation_amount
                FROM 
                    royalty_consolidation
                WHERE 
                    copyright_owner = ?
                    AND pay_status = 'O'
                    AND type = 'audiobook'
                GROUP BY 
                    channel
            )

            SELECT 
                COALESCE(rc.channel, ct.channel) AS channel,
                rc.consolidation_amount,
                ct.transaction_amount
            FROM 
                royalty_consolidation_data rc
            LEFT JOIN 
                channel_transaction ct
                ON rc.channel = ct.channel

            UNION

            SELECT 
                COALESCE(rc.channel, ct.channel) AS channel,
                rc.consolidation_amount,
                ct.transaction_amount
            FROM 
                royalty_consolidation_data rc
            RIGHT JOIN 
                channel_transaction ct
                ON rc.channel = ct.channel

            ORDER BY channel";

        $query = $this->db->query($sql, [
            $copyright_owner, $copyright_owner, $copyright_owner,
            $copyright_owner, $copyright_owner, $copyright_owner,
            $copyright_owner, $copyright_owner,$copyright_owner
        ]);

        $result = $query->getResultArray();

        $final = [];
        foreach ($result as $row) {
            $key = ucfirst(strtolower($row['channel'])); 
            $final[$key] = $row;
        }

        return $final;
    }
    public function getpaperbackDetails($copyrightOwner)
    {
        $sql="SELECT 
                    r.channel,
                    SUM(r.royalty) AS consolidation_amount,
                    t.transaction_amount
                FROM 
                    royalty_consolidation r,
                    (
                        SELECT 
                            SUM(book_final_royalty_value_inr) AS transaction_amount
                        FROM 
                            author_transaction
                        WHERE 
                            copyright_owner = ?
                            AND pay_status = 'O'
                            AND order_type IN (9,10,11,12,13,14,15)
                            AND order_date <= '2025-06-30'
                    ) t
                WHERE 
                    r.copyright_owner = ?
                    AND r.pay_status = 'O'
                    AND r.type = 'paperback'
                GROUP BY 
                    r.channel
                ORDER BY 
                    r.channel";
        $query = $this->db->query($sql, [$copyrightOwner, $copyrightOwner]);
        $result = $query->getResultArray();
        $final = [];
        foreach ($result as $row) {
            $key = strtolower($row['channel']); 
            $final[$key] = [
                'channel' => $row['channel'],
                'consolidation_amount' => (float) $row['consolidation_amount'],
                'transaction_amount' => (float) $row['transaction_amount']
            ];
        
        }
        return $final;
    }
    public function getEbookDetails($status = '')
    {
        $combined_data = [];

        $whereStatus = $status ? "status='$status'" : '1=1';
        $whereStatusPustaka = $status ? "pay_status='$status'" : '1=1';

        $platforms = [
            'amazon' => "SELECT DATE_FORMAT(original_invoice_date, '%M-%Y') AS month_year, SUM(final_royalty_value) AS royalty, SUM(inr_value) AS revenue FROM amazon_transactions WHERE $whereStatus GROUP BY DATE_FORMAT(original_invoice_date, '%Y-%m')",
            'overdrive' => "SELECT DATE_FORMAT(transaction_date, '%M-%Y') AS month_year, SUM(final_royalty_value) AS royalty, SUM(inr_value) AS revenue FROM overdrive_transactions WHERE type_of_book=1 AND $whereStatus GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')",
            'scribd' => "SELECT DATE_FORMAT(Payout_month, '%M-%Y') AS month_year, SUM(converted_inr) AS royalty, SUM(converted_inr_full) AS revenue FROM scribd_transaction WHERE $whereStatus GROUP BY DATE_FORMAT(Payout_month, '%Y-%m')",
            'pratilipi' => "SELECT DATE_FORMAT(transaction_date, '%M-%Y') AS month_year, SUM(final_royalty_value) AS royalty, SUM(earning) AS revenue FROM pratilipi_transactions WHERE type_of_book=1 AND $whereStatus GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')",
            'google' => "SELECT DATE_FORMAT(transaction_date, '%M-%Y') AS month_year, SUM(final_royalty_value) AS royalty, SUM(inr_value) AS revenue FROM google_transactions WHERE type_of_book=1 AND $whereStatus GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')",
            'storytel' => "SELECT DATE_FORMAT(transaction_date, '%M-%Y') AS month_year, SUM(final_royalty_value) AS royalty, SUM(remuneration_inr) AS revenue FROM storytel_transactions WHERE type_of_book=1 AND $whereStatus GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')",
            'pustaka' => "SELECT DATE_FORMAT(order_date, '%M-%Y') AS month_year, ROUND(SUM(book_final_royalty_value_inr + converted_book_final_royalty_value_inr), 2) AS royalty FROM author_transaction WHERE order_type=1 AND $whereStatusPustaka GROUP BY DATE_FORMAT(order_date, '%Y-%m')",
            'kobo' => "SELECT DATE_FORMAT(transaction_date, '%M-%Y') AS month_year, SUM(paid_inr) AS royalty, SUM(net_due) AS revenue FROM kobo_transaction WHERE $whereStatus GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')"
        ];

        foreach ($platforms as $channel => $sql) {
            $results = $this->db->query($sql)->getResultArray();
            foreach ($results as $row) {
                $monthYear = $row['month_year'];
                $combined_data[$monthYear][$channel] = [
                    'revenue' => isset($row['revenue']) ? (float) $row['revenue'] : 0,
                    'royalty' => isset($row['royalty']) ? (float) $row['royalty'] : 0
                ];
            }
        }

        return $combined_data;
    }
    public function getAudioBookDetails($status = '')
    {
        $combined_data = [];

        $whereStatus = $status ? "status='$status'" : '1=1';
        $whereStatusPustaka = $status ? "pay_status='$status'" : '1=1';

        $platforms = [
            'audible' => "SELECT DATE_FORMAT(transaction_date, '%M-%Y') AS month_year, SUM(final_royalty_value) AS royalty, SUM(total_net_sales) AS revenue FROM audible_transactions WHERE $whereStatus GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')",
            'pustaka' => "SELECT DATE_FORMAT(order_date, '%M-%Y') AS month_year, ROUND(SUM(book_final_royalty_value_inr + converted_book_final_royalty_value_inr), 2) AS royalty FROM author_transaction WHERE $whereStatusPustaka AND order_type IN (3,4,5,6) GROUP BY DATE_FORMAT(order_date, '%Y-%m')",
            'overdrive' => "SELECT DATE_FORMAT(transaction_date, '%M-%Y') AS month_year, SUM(final_royalty_value) AS royalty, SUM(inr_value) AS revenue FROM overdrive_transactions WHERE type_of_book=3 AND $whereStatus GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')",
            'pratilipi' => "SELECT DATE_FORMAT(transaction_date, '%M-%Y') AS month_year, SUM(final_royalty_value) AS royalty, SUM(earning) AS revenue FROM pratilipi_transactions WHERE type_of_book=3 AND $whereStatus GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')",
            'google' => "SELECT DATE_FORMAT(transaction_date, '%M-%Y') AS month_year, SUM(final_royalty_value) AS royalty, SUM(inr_value) AS revenue FROM google_transactions WHERE type_of_book=3 AND $whereStatus GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')",
            'storytel' => "SELECT DATE_FORMAT(transaction_date, '%M-%Y') AS month_year, SUM(final_royalty_value) AS royalty, SUM(remuneration_inr) AS revenue FROM storytel_transactions WHERE type_of_book=3 AND $whereStatus GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')",
            'kukufm' => "SELECT DATE_FORMAT(transaction_date, '%M-%Y') AS month_year, SUM(final_royalty_value) AS royalty, SUM(rev_share_amount) AS revenue FROM kukufm_transactions WHERE $whereStatus GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')",
            'youtube' => "SELECT DATE_FORMAT(transaction_date, '%M-%Y') AS month_year, ROUND(SUM(final_royalty_value),2) AS royalty, ROUND(SUM(pustaka_earnings),2) AS revenue FROM youtube_transaction WHERE $whereStatus GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')"
        ];

        foreach ($platforms as $channel => $sql) {
            $results = $this->db->query($sql)->getResultArray();
            foreach ($results as $row) {
                $monthYear = $row['month_year'];
                $combined_data[$monthYear][$channel] = [
                    'revenue' => isset($row['revenue']) ? (float) $row['revenue'] : 0,
                    'royalty' => isset($row['royalty']) ? (float) $row['royalty'] : 0
                ];
            }
        }

        return $combined_data;
    }
    public function publisherDetails($copyright_owner)
    {
        $sql = "SELECT 
                    copyright_mapping.copyright_owner,
                    copyright_mapping.author_id,
                    publisher_tbl.publisher_name
                FROM 
                    copyright_mapping
                JOIN publisher_tbl 
                    ON copyright_mapping.copyright_owner = publisher_tbl.copyright_owner
                WHERE 
                  copyright_mapping.copyright_owner = $copyright_owner";

        $query = $this->db->query($sql, [$copyright_owner]);
        return $query->getResultArray();
    }

    public function getRoyaltyConsolidatedDataByCopyrightOwner($copyrightOwner)
    {
        $records = [];

        $sql = "SELECT 
                publisher_tbl.publisher_name,
                publisher_tbl.copyright_owner,
                publisher_tbl.bonus_percentage,
                publisher_tbl.tds_flag,
                publisher_tbl.bank_acc_no,
                publisher_tbl.email_id,
                publisher_tbl.mobile,
                publisher_tbl.ifsc_code,
                publisher_tbl.bank_acc_name,
                SUM(CASE WHEN type = 'ebook' THEN royalty ELSE 0 END) AS outstanding_ebooks,
                SUM(CASE WHEN type = 'audiobook' THEN royalty ELSE 0 END) AS outstanding_audiobooks,
                SUM(CASE WHEN type = 'paperback' THEN royalty ELSE 0 END) AS outstanding_paperbacks,

                SUM(CASE WHEN type = 'ebook' and channel='pustaka' THEN royalty ELSE 0 END) AS pustaka_ebooks,
                SUM(CASE WHEN type = 'ebook' and channel='amazon' THEN royalty ELSE 0 END) AS amazon_ebooks,
                SUM(CASE WHEN type = 'ebook' and channel='scribd' THEN royalty ELSE 0 END) AS scribd_ebooks,
                SUM(CASE WHEN type = 'ebook' and channel='overdrive' THEN royalty ELSE 0 END) AS overdrive_ebooks,
                SUM(CASE WHEN type = 'ebook' and channel='google' THEN royalty ELSE 0 END) AS google_ebooks,
                SUM(CASE WHEN type = 'ebook' and channel='storytel' THEN royalty ELSE 0 END) AS storytel_ebooks,
                SUM(CASE WHEN type = 'ebook' and channel='pratilipi' THEN royalty ELSE 0 END) AS pratilipi_ebooks,
                SUM(CASE WHEN type = 'ebook' and channel='kobo' THEN royalty ELSE 0 END) AS kobo_ebooks,

                SUM(CASE WHEN type = 'audiobook' and channel='pustaka' THEN royalty ELSE 0 END) AS pustaka_audiobooks,
                SUM(CASE WHEN type = 'audiobook' and channel='audible' THEN royalty ELSE 0 END) AS audible_audiobooks,
                SUM(CASE WHEN type = 'audiobook' and channel='overdrive' THEN royalty ELSE 0 END) AS overdrive_audiobooks,
                SUM(CASE WHEN type = 'audiobook' and channel='google' THEN royalty ELSE 0 END) AS google_audiobooks,
                SUM(CASE WHEN type = 'audiobook' and channel='storytel' THEN royalty ELSE 0 END) AS storytel_audiobooks,
                SUM(CASE WHEN type = 'audiobook' and channel='kukufm' THEN royalty ELSE 0 END) AS kukufm_audiobooks,
                SUM(CASE WHEN type = 'audiobook' and channel='youtube' THEN royalty ELSE 0 END) AS youtube_audiobooks,

                SUM(CASE WHEN type = 'paperback' and channel='pustaka' THEN royalty ELSE 0 END) AS paperback_amount

                FROM 
                publisher_tbl
                LEFT JOIN 
                royalty_consolidation 
                ON publisher_tbl.copyright_owner = royalty_consolidation.copyright_owner
                AND royalty_consolidation.pay_status = 'O'
                WHERE 
                publisher_tbl.copyright_owner = ?
                GROUP BY 
                publisher_tbl.copyright_owner, 
                publisher_tbl.publisher_name,
                publisher_tbl.bonus_percentage,
                publisher_tbl.tds_flag,
                publisher_tbl.bank_acc_no,
                publisher_tbl.email_id,
                publisher_tbl.mobile,
                publisher_tbl.ifsc_code,
                publisher_tbl.bank_acc_name";

        $query = $this->db->query($sql, [$copyrightOwner]);
        $result = $query->getResultArray();

        foreach ($result as $row) {
            $record = [];

            $record['publisher_name'] = $row['publisher_name'];
            $record['copyright_owner'] = $row['copyright_owner'];

            $record['ebooks_outstanding'] = (float) $row['outstanding_ebooks'];
            $record['audiobooks_outstanding'] = (float) $row['outstanding_audiobooks'];
            $record['paperbacks_outstanding'] = (float) $row['outstanding_paperbacks'];

            $record['bonus_percentage'] = (float) $row['bonus_percentage'];
            $record['tds_flag'] = (int) $row['tds_flag'];

            $record['bonus_value'] = ($record['ebooks_outstanding'] + $record['audiobooks_outstanding']) * $record['bonus_percentage'] / 100;

            $record['bank_status'] = empty($row['bank_acc_no']) ? 'No' : 'Yes';

            $record['total_outstanding'] = $record['ebooks_outstanding']
                                        + $record['audiobooks_outstanding']
                                        + $record['paperbacks_outstanding']
                                        + $record['bonus_value'];

            $record['tds_value'] = ($record['tds_flag'] === 1)
                ? $record['total_outstanding'] * 0.10
                : 0;

            $record['total_after_tds'] = $record['total_outstanding'] - $record['tds_value'];

            $record['bank_acc_no'] = $row['bank_acc_no'];
            $record['email_id'] = $row['email_id'];
            $record['mobile'] = $row['mobile'];
            $record['ifsc_code'] = $row['ifsc_code'];
            $record['bank_acc_name'] = $row['bank_acc_name'];

            // Add full channel/format breakdowns
            foreach ($row as $key => $value) {
                if (!isset($record[$key])) {
                    $record[$key] = (float) $value;
                }
            }

            $records[] = $record;
        }

        // Return just the first record as a flat associative array
        return $records[0] ?? [];
    }


    public function getSiteConfig()
    {
        $site_config_query = "SELECT * FROM site_config WHERE category = 'settlement'";
        $site_config_all = $this->db->query($site_config_query);
        
        $array = [];
        foreach ($site_config_all->getResultArray() as $row) {
            $key = $row['key'];
            $value = $row['value'];
            $array[$key] = $value;
        }

        return $array;
    }

    public function updateRoyaltySettlement($copyright_owner, $paynow_data, $site_config)
    {
        $time = strtotime($site_config['settlement_date']);
        $settlement_date = date('Y-m-d', $time);

        // Always use $time here, not $settlement_date
        $month = date('n', $time);  
        $year = date('Y', $time);

        $fy_start = ($month >= 4) ? $year : $year - 1;
        $fy_end = $fy_start + 1;
        $fy = $fy_start . '-' . $fy_end;

        $insert_data = [
            "copy_right_owner_id" => $copyright_owner,
            "settlement_date" => $settlement_date,
            "settlement_amount" => round($paynow_data['total_outstanding'], 2),
            "tds_amount" => round($paynow_data['tds_value'], 2),
            "payment_type" => $site_config['settlement_type'],
            "bank_transaction_details" => $site_config['settlement_bank_transaction'],
            "comments" => '',
            "pustaka_ebooks" => round($paynow_data['pustaka_ebooks'], 2),
            "pustaka_audiobooks" => round($paynow_data['pustaka_audiobooks'], 2),
            "pustaka_consolidated_paperback" => round($paynow_data['paperback_amount'], 2),
            "amazon" => round($paynow_data['amazon_ebooks'], 2),
            "kobo" => round($paynow_data['kobo_ebooks'], 2),
            "scribd" => round($paynow_data['scribd_ebooks'], 2),
            "google_ebooks" => round($paynow_data['google_ebooks'], 2),
            "google_audiobooks" => round($paynow_data['google_audiobooks'], 2),
            "overdrive_ebooks" => round($paynow_data['overdrive_ebooks'], 2),
            "overdrive_audiobooks" => round($paynow_data['overdrive_audiobooks'], 2),
            "storytel_ebooks" => round($paynow_data['storytel_ebooks'], 2),
            "pratilipi_ebooks" => round($paynow_data['pratilipi_ebooks'], 2),
            "storytel_audiobooks" => round($paynow_data['storytel_audiobooks'], 2),
            "audible" => round($paynow_data['audible_audiobooks'], 2),
            "kukufm_audiobooks"=> round($paynow_data['kukufm_audiobooks'], 2),
            "bonus_value" => round($paynow_data['bonus_value'], 2),
            "month" =>  $month ,
            "year" => $year,
            "fy" => $fy 
        ];

        $this->db->table('royalty_settlement')->insert($insert_data);

        return "Success";
    }

    public function markRoyaltyConsolidationToPaid($copyright_owner, $month_end)
    {
        $timestamp = strtotime($month_end); // Convert to timestamp
        $month = date('n', $timestamp);    
        $year = date('Y', $timestamp);   

        $success = $this->royaltyModel->db
            ->table('royalty_consolidation')
            ->where('copyright_owner', $copyright_owner)
            ->where('pay_status', 'O')
            ->where('month <=', $month)
            ->where('year', $year)
            ->update(['pay_status' => 'P']);

        return $success ? "Success" : "Failed";
    }


    public function markPustakaToPaid($copyright_owner,$month_end)
    {

        $month_end_sql = date('Y-m-d', strtotime(str_replace('-', '/', $month_end)));
         
        $success = $this->royaltyModel->db
            ->table('author_transaction')
            ->where('copyright_owner', $copyright_owner)
            ->where('pay_status', 'O')
            ->where('order_date <=', $month_end_sql)
            ->update(['pay_status' => 'P']);

        return $success ? "Success" : "Failed";
          

    }


    public function markAmazonToPaid($copyright_owner,$month_end)
    {

        $month_end_sql = date('Y-m-d', strtotime(str_replace('-', '/', $month_end)));
        
        $success = $this->royaltyModel->db
            ->table('amazon_transactions')
            ->where('copyright_owner', $copyright_owner)
            ->where('status', 'O')
            ->where('invoice_date <=', $month_end_sql)
            ->update(['status' => 'P']);

        return $success ? "Success" : "Failed";          

    }


}