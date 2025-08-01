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
                    WHERE copyright_owner = ? AND status = 'R'

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
                    AND order_date BETWEEN '2025-01-01' AND '2025-03-31'
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
                FROM pustaka.google_transactions
                WHERE copyright_owner = ? AND type_of_book = 3 AND status = 'O'

                UNION ALL

                SELECT 'Storytel', SUM(final_royalty_value)
                FROM storytel_transactions
                WHERE copyright_owner = ? AND type_of_book = 3 AND status = 'O'

                UNION ALL

                SELECT 'KukuFM', SUM(final_royalty_value)
                FROM pustaka.kukufm_transactions
                WHERE copyright_owner = ? AND status = 'O'

                UNION ALL

                SELECT 'YouTube', SUM(final_royalty_value)
                FROM pustaka.youtube_transaction
                WHERE copyright_owner = ? AND status = 'O'

                UNION ALL

                SELECT 'Pustaka', SUM(book_final_royalty_value_inr)
                FROM author_transaction
                WHERE copyright_owner = ?
                AND pay_status = 'O'
                AND order_type IN (3,4,5,6)
                AND order_date BETWEEN '2025-01-01' AND '2025-03-31'
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
                            AND order_date BETWEEN '2025-01-01' AND '2025-03-31'
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
    
    // public function getEbookDetails()
    // {
    //     $combined_data = [];
        
    //     $platforms = [
    //         'amazon' => "SELECT DATE_FORMAT(original_invoice_date, '%M-%Y') AS month_year, SUM(final_royalty_value) AS royalty, SUM(inr_value) AS revenue FROM amazon_transactions WHERE status='O' GROUP BY DATE_FORMAT(original_invoice_date, '%Y-%m')",
    //         'overdrive' => "SELECT DATE_FORMAT(transaction_date, '%M-%Y') AS month_year, SUM(final_royalty_value) AS royalty, SUM(inr_value) AS revenue FROM overdrive_transactions WHERE type_of_book=1 AND status='O' GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')",
    //         'scribd' => "SELECT DATE_FORMAT(Payout_month, '%M-%Y') AS month_year, SUM(converted_inr) AS royalty, SUM(converted_inr_full) AS revenue FROM scribd_transaction WHERE status='O' GROUP BY DATE_FORMAT(Payout_month, '%Y-%m')",
    //         'pratilipi' => "SELECT DATE_FORMAT(transaction_date, '%M-%Y') AS month_year, SUM(final_royalty_value) AS royalty, SUM(earning) AS revenue FROM pratilipi_transactions WHERE type_of_book=1 AND status='O' GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')",
    //         'google' => "SELECT DATE_FORMAT(transaction_date, '%M-%Y') AS month_year, SUM(final_royalty_value) AS royalty, SUM(inr_value) AS revenue FROM google_transactions WHERE type_of_book=1 AND status='O' GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')",
    //         'storytel' => "SELECT DATE_FORMAT(transaction_date, '%M-%Y') AS month_year, SUM(final_royalty_value) AS royalty, SUM(remuneration_inr) AS revenue FROM storytel_transactions WHERE type_of_book=1 AND status='O' GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')",
    //         'pustaka' => "SELECT DATE_FORMAT(order_date, '%M-%Y') AS month_year, ROUND(SUM(book_final_royalty_value_inr + converted_book_final_royalty_value_inr), 2) AS royalty FROM author_transaction WHERE order_type=1 AND pay_status='O' GROUP BY DATE_FORMAT(order_date, '%Y-%m')",
    //         'kobo' => "SELECT DATE_FORMAT(transaction_date, '%M-%Y') AS month_year, SUM(paid_inr) AS royalty, SUM(net_due) AS revenue FROM kobo_transaction WHERE status='O' GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')"
    //     ];

    //     foreach ($platforms as $channel => $sql) {
    //         $results = $this->db->query($sql)->getResultArray();
    //         foreach ($results as $row) {
    //             $monthYear = $row['month_year'];
    //             $combined_data[$monthYear][$channel] = [
    //                 'revenue' => isset($row['revenue']) ? (float) $row['revenue'] : 0,
    //                 'royalty' => isset($row['royalty']) ? (float) $row['royalty'] : 0
    //             ];
    //         }
    //     }

    //     return $combined_data;
    // }

    // public function getAudioBookDetails()
    // {
    //     $combined_data = [];

    //     $platforms = [
    //         'audible' => "SELECT DATE_FORMAT(transaction_date, '%M-%Y') AS month_year, SUM(final_royalty_value) AS royalty, SUM(total_net_sales) AS revenue FROM audible_transactions WHERE status='O' GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')",
    //         'pustaka' => "SELECT DATE_FORMAT(order_date, '%M-%Y') AS month_year, ROUND(SUM(book_final_royalty_value_inr + converted_book_final_royalty_value_inr), 2) AS royalty FROM author_transaction WHERE pay_status='O' AND order_type IN (3,4,5,6) GROUP BY DATE_FORMAT(order_date, '%Y-%m')",
    //         'overdrive' => "SELECT DATE_FORMAT(transaction_date, '%M-%Y') AS month_year, SUM(final_royalty_value) AS royalty, SUM(inr_value) AS revenue FROM overdrive_transactions WHERE type_of_book=3 AND status='O' GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')",
    //         'pratilipi' => "SELECT DATE_FORMAT(transaction_date, '%M-%Y') AS month_year, SUM(final_royalty_value) AS royalty, SUM(earning) AS revenue FROM pratilipi_transactions WHERE type_of_book=3 AND status='O' GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')",
    //         'google' => "SELECT DATE_FORMAT(transaction_date, '%M-%Y') AS month_year, SUM(final_royalty_value) AS royalty, SUM(inr_value) AS revenue FROM google_transactions WHERE type_of_book=3 AND status='O' GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')",
    //         'storytel' => "SELECT DATE_FORMAT(transaction_date, '%M-%Y') AS month_year, SUM(final_royalty_value) AS royalty, SUM(remuneration_inr) AS revenue FROM storytel_transactions WHERE type_of_book=3 AND status='O' GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')",
    //         'kukufm' => "SELECT DATE_FORMAT(transaction_date, '%M-%Y') AS month_year, SUM(final_royalty_value) AS royalty, SUM(rev_share_amount) AS revenue FROM kukufm_transactions WHERE status='O' GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')",
    //         'youtube' => "SELECT DATE_FORMAT(transaction_date, '%M-%Y') AS month_year, ROUND(SUM(final_royalty_value),2) AS royalty, ROUND(SUM(pustaka_earnings),2) AS revenue FROM youtube_transaction WHERE status='O' GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')"
    //     ];

    //     foreach ($platforms as $channel => $sql) {
    //         $results = $this->db->query($sql)->getResultArray();
    //         foreach ($results as $row) {
    //             $monthYear = $row['month_year'];
    //             $combined_data[$monthYear][$channel] = [
    //                 'revenue' => isset($row['revenue']) ? (float) $row['revenue'] : 0,
    //                 'royalty' => isset($row['royalty']) ? (float) $row['royalty'] : 0
    //             ];
    //         }
    //     }

    //     return $combined_data;
    // }
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


}
