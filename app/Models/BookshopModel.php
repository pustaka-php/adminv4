<?php

namespace App\Models;

use CodeIgniter\Model;

class BookshopModel extends Model
{
    public function getDashboardData()
    {
        // Step 1: Bookshop status summary
        $builder = $this->db->table('pod_bookshop');
        $builder->select('status, COUNT(*) as cnt');
        $builder->groupBy('status');
        
        $statusResults = $builder->get()->getResultArray();

        $bookshopStatus = [
            'total_bookshop' => 0,
            'active_bookshop' => 0,
            'pending_bookshop' => 0,
            'inactive_bookshop' => 0
        ];

        foreach ($statusResults as $row) {
            $bookshopStatus['total_bookshop'] += $row['cnt'];
            if ($row['status'] == 1) {
                $bookshopStatus['active_bookshop'] = $row['cnt'];
            } elseif ($row['status'] == 0) {
                $bookshopStatus['pending_bookshop'] = $row['cnt'];
            } elseif ($row['status'] == 2) {
                $bookshopStatus['inactive_bookshop'] = $row['cnt'];
            }
        }

        // Step 2: Bookshop sales data
        $sql = "SELECT 
                    pod_bookshop.bookshop_name,
                    CEIL(SUM(pod_bookshop_order_details.total_amount)) AS total_amount
                FROM 
                    pod_bookshop_order_details
                JOIN
                    pod_bookshop ON pod_bookshop.bookshop_id = pod_bookshop_order_details.bookshop_id
                GROUP BY 
                    pod_bookshop.bookshop_name
                ORDER BY 
                    pod_bookshop.bookshop_id";

        $query = $this->db->query($sql);

        $bookshopSales = [];
        foreach ($query->getResultArray() as $row) {
            $bookshopSales[] = [
                'bookshop_name' => $row['bookshop_name'],
                'total_amount' => $row['total_amount']
            ];
        }

        // Final structured result
        return [
            'bookshop_status' => $bookshopStatus,
            'bookshop_sales' => $bookshopSales
        ];
    }
}
