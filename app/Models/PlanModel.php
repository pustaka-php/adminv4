<?php

namespace App\Models;

use CodeIgniter\Model;

class PlanModel extends Model
{
    protected $table = 'plan_tbl';
    protected $primaryKey = 'plan_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'plan_name',
        'amount',
        'duration',
        'description',
        'status',
    ];

    public function getUserplans()
    {
        return $this->where('status', 1)->findAll();
    }
    
     public function getDashboardData()
{
    $db = \Config\Database::connect();

    // MAIN SUBSCRIPTION SUMMARY QUERY
    $sql = "
        SELECT 
            tp.label AS time_period,

            -- INR Amount
            IFNULL(SUM(CASE WHEN o.currency = 'INR' THEN o.amount ELSE 0 END), 0) AS inr_amount,

            -- USD Amount
            IFNULL(SUM(CASE WHEN o.currency = 'USD' THEN o.amount ELSE 0 END), 0) AS usd_amount,

            -- Quarterly count
            IFNULL(SUM(CASE WHEN s.subscription_id = 202201 THEN 1 ELSE 0 END), 0) AS quarterly,

            -- Annual count
            IFNULL(SUM(CASE WHEN s.subscription_id = 202202 THEN 1 ELSE 0 END), 0) AS annual,

            -- Audiobook count
            IFNULL(SUM(CASE WHEN s.subscription_id = 202203 THEN 1 ELSE 0 END), 0) AS audiobooks

        FROM (
            SELECT 'Today' AS label, CURDATE() AS start_date, CURDATE() AS end_date
            UNION ALL
            SELECT 'Last 7 Days', CURDATE() - INTERVAL 6 DAY, CURDATE()
            UNION ALL
            SELECT 'Current Month', DATE_FORMAT(CURDATE(), '%Y-%m-01'), CURDATE()
            UNION ALL
            SELECT 'Previous Month', 
                   DATE_FORMAT(CURDATE() - INTERVAL 1 MONTH, '%Y-%m-01'),
                   LAST_DAY(CURDATE() - INTERVAL 1 MONTH)
        ) AS tp

        LEFT JOIN subscription s 
            ON DATE(s.start_date) BETWEEN tp.start_date AND tp.end_date
            AND s.status = 1
            AND s.subscription_id IN (202201, 202202, 202203)

        LEFT JOIN `order` o 
            ON o.order_id = s.order_id
            AND o.cart_type = 1

        GROUP BY tp.label
        ORDER BY FIELD(tp.label, 'Today', 'Last 7 Days', 'Current Month', 'Previous Month')
    ";

    $subscriptionsSummary = $db->query($sql)->getResultArray();

    // WALLET SUMMARY QUERY
    $walletSql = "
        SELECT 
            IFNULL(SUM(CASE WHEN currency = 'INR' THEN amount ELSE 0 END), 0) AS balance_inr,
            IFNULL(SUM(CASE WHEN currency = 'USD' THEN amount ELSE 0 END), 0) AS balance_usd
        FROM user_wallet_transaction
        WHERE transaction_type = 1
    ";

    $walletTotal = $db->query($walletSql)->getRowArray();

    return [
        'subscriptions_summary' => $subscriptionsSummary,
        'wallet_total' => $walletTotal
    ];
}

function getwalletdetails(){

        $sql = "SELECT 
                    p.period,
                    COALESCE(SUM(CASE WHEN o.currency = 'INR' THEN o.net_total ELSE 0 END), 0) AS INR_amount,
                    COALESCE(SUM(CASE WHEN o.currency = 'USD' THEN o.net_total ELSE 0 END), 0) AS USD_amount
                FROM (
                    SELECT 'Today' AS period, CURRENT_DATE AS start_date, CURRENT_DATE AS end_date
                    UNION ALL
                    SELECT 'This Week', DATE_SUB(CURRENT_DATE, INTERVAL WEEKDAY(CURRENT_DATE) DAY), CURRENT_DATE
                    UNION ALL
                    SELECT 'Current Month', DATE_SUB(CURRENT_DATE, INTERVAL DAY(CURRENT_DATE) - 1 DAY), CURRENT_DATE
                    UNION ALL
                    SELECT 'Previous Month', 
                        DATE_SUB(DATE_SUB(CURRENT_DATE, INTERVAL DAY(CURRENT_DATE) DAY), INTERVAL 1 MONTH), 
                        DATE_SUB(CURRENT_DATE, INTERVAL DAY(CURRENT_DATE) DAY)
                ) p
                LEFT JOIN `order` o
                    ON DATE(o.date_created) BETWEEN p.start_date AND p.end_date 
                    AND o.cart_type = 4 
                    AND o.currency IN ('INR', 'USD')
                GROUP BY p.period
                ORDER BY FIELD(p.period, 'Today', 'This Week', 'Current Month', 'Previous Month')";

        $query = $this->db->query($sql);
        $data['recharge']= $query->getResultArray();
        
        
        $sql1 = "SELECT 
                    p.period,
                    COALESCE(SUM(CASE WHEN o.currency = 'INR' THEN o.net_total ELSE 0 END), 0) AS INR_amount,
                    COALESCE(SUM(CASE WHEN o.currency = 'USD' THEN o.net_total ELSE 0 END), 0) AS USD_amount
                FROM (
                    SELECT 'Today' AS period, CURRENT_DATE AS start_date, CURRENT_DATE AS end_date
                    UNION ALL
                    SELECT 'This Week', DATE_SUB(CURRENT_DATE, INTERVAL WEEKDAY(CURRENT_DATE) DAY), CURRENT_DATE
                    UNION ALL
                    SELECT 'Current Month', DATE_SUB(CURRENT_DATE, INTERVAL DAY(CURRENT_DATE) - 1 DAY), CURRENT_DATE
                    UNION ALL
                    SELECT 'Previous Month', 
                        DATE_SUB(DATE_SUB(CURRENT_DATE, INTERVAL DAY(CURRENT_DATE) DAY), INTERVAL 1 MONTH), 
                        DATE_SUB(CURRENT_DATE, INTERVAL DAY(CURRENT_DATE) DAY)
                ) p
                LEFT JOIN `order` o
                    ON DATE(o.date_created) BETWEEN p.start_date AND p.end_date 
                    AND o.cart_type = 2 
                    AND o.currency IN ('INR', 'USD')
                GROUP BY p.period
                ORDER BY FIELD(p.period, 'Today', 'This Week', 'Current Month', 'Previous Month')";

        $query = $this->db->query($sql1);
        $data['book_order']= $query->getResultArray();


        $sql2 = "SELECT 
                    p.period,
                    COALESCE(SUM(CASE WHEN o.currency = 'INR' THEN o.net_total ELSE 0 END), 0) AS INR_amount,
                    COALESCE(SUM(CASE WHEN o.currency = 'USD' THEN o.net_total ELSE 0 END), 0) AS USD_amount
                FROM (
                    SELECT 'Today' AS period, CURRENT_DATE AS start_date, CURRENT_DATE AS end_date
                    UNION ALL
                    SELECT 'This Week', DATE_SUB(CURRENT_DATE, INTERVAL WEEKDAY(CURRENT_DATE) DAY), CURRENT_DATE
                    UNION ALL
                    SELECT 'Current Month', DATE_SUB(CURRENT_DATE, INTERVAL DAY(CURRENT_DATE) - 1 DAY), CURRENT_DATE
                    UNION ALL
                    SELECT 'Previous Month', 
                        DATE_SUB(DATE_SUB(CURRENT_DATE, INTERVAL DAY(CURRENT_DATE) DAY), INTERVAL 1 MONTH), 
                        DATE_SUB(CURRENT_DATE, INTERVAL DAY(CURRENT_DATE) DAY)
                ) p
                LEFT JOIN `order` o
                    ON DATE(o.date_created) BETWEEN p.start_date AND p.end_date 
                    AND o.cart_type = 1 
                    AND o.currency IN ('INR', 'USD')
                GROUP BY p.period
                ORDER BY FIELD(p.period, 'Today', 'This Week', 'Current Month', 'Previous Month')";

        $query = $this->db->query($sql2);
        $data['subscription']= $query->getResultArray();
        return $data;   

    }
   
}

