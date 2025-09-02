<?php

namespace App\Models;

use CodeIgniter\Model;

class PodModel extends Model
{

    public function getPODDashboardData(){

        $pod_publisher_sql = "SELECT 
                                COUNT(*) AS total,
                                SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) AS active,
                                SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) AS inactive
                            FROM pod_publisher";
        $pod_publisher_query = $this->db->query($pod_publisher_sql);
        $data['publisher'] = $pod_publisher_query->getResultArray()[0]; 

        $pod_orders_sql = "SELECT 
                                COUNT(*) AS total,
                                SUM(CASE WHEN delivery_flag = 1 THEN 1 ELSE 0 END) AS completed,
                                SUM(CASE WHEN delivery_flag = 0 THEN 1 ELSE 0 END) AS pending
                            FROM pod_publisher_books";
        $pod_orders_query = $this->db->query($pod_orders_sql);
        $data['orders'] = $pod_orders_query->getResultArray()[0]; 

        $pod_invoice_sql = "SELECT 
                                COUNT(*) AS total,
                                SUM(CASE WHEN invoice_flag = 1 THEN 1 ELSE 0 END) AS completed,
                                SUM(CASE WHEN invoice_flag = 0 THEN 1 ELSE 0 END) AS pending
                            FROM pod_publisher_books";
        $pod_invoice_query = $this->db->query($pod_invoice_sql);
        $data['invoice'] = $pod_invoice_query->getResultArray()[0]; 

         $pod_full_sql = "SELECT 
                                COUNT(*) AS total,
                                SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) AS completed,
                                SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) AS pending
                            FROM pod_indesign";
        $pod_full_query = $this->db->query($pod_full_sql);
        $data['pod'] = $pod_full_query->getResultArray()[0];

        return $data;
    }

    public function getPODPublishers()
    {

        $pod_publisher_sql = "SELECT * FROM pod_publisher WHERE status=1";
        $pod_publisher_query = $this->db->query($pod_publisher_sql);
        $data['publisher'] = $pod_publisher_query->getResultArray(); //  fixed

    
        $sql = "SELECT * FROM pod_publisher WHERE status=1";
        $query = $this->db->query($sql);
        $result = $query->getResultArray(); //  fixed

        $data['publisher_details'] = $result[0] ?? null; // avoid undefined index

        return $data;
    }

    public function PodpublisherSubmit($publisher_data)
    {
        $db = db_connect();

        if ($db->table('pod_publisher')->insert($publisher_data)) {
            return ['status' => 'success'];
        }
        return ['status' => 'error'];
    }

    public function getPODInvoiceData(){

        $pod_pending_sql = "SELECT count(*) as pending_invoice,
                            sum(invoice_value) as pending_total 
                            FROM pod_publisher_books where  invoice_flag=0";
        $pod_pending_query = $this->db->query($pod_pending_sql);
        $data['pending'] = $pod_pending_query->getResultArray()[0]; 

        $pod_raised_sql = "SELECT count(*) as raised_invoice,sum(invoice_value) as raised_total 
                           FROM pod_publisher_books 
                           where qc_flag=1 and invoice_flag=1 and payment_flag=0";
        $pod_raised_query = $this->db->query($pod_raised_sql);
        $data['raised'] = $pod_raised_query->getResultArray()[0]; 

        $pod_paid_sql = "SELECT count(*) paid_invoice,
                         sum(invoice_value) as paid_total 
                         FROM pod_publisher_books where payment_flag=1";
        $pod_paid_query = $this->db->query($pod_paid_sql);
        $data['paid'] = $pod_paid_query->getResultArray()[0]; 

        return $data;
    }

    function GetTotalSummary(){

		$pod_totalinvoice_sql = "SELECT sum(pod_publisher_books.invoice_value) as total_invoice
										FROM pod_publisher_books, pod_publisher 
										WHERE pod_publisher_books.publisher_id = pod_publisher.id 
										and pod_publisher_books.invoice_flag=1";
		$pod_totalinvoice_query = $this->db->query($pod_totalinvoice_sql);
		$tmp =$pod_totalinvoice_query->getResultArray()[0];
		$data['TotalInvoice']=number_format($tmp['total_invoice'],2);

		$pod_totalpaid_sql = "SELECT  sum(pod_publisher_books.invoice_value) as total_paid
							FROM pod_publisher_books, pod_publisher
							WHERE pod_publisher_books.publisher_id = pod_publisher.id 
							and pod_publisher_books.invoice_flag=1 and pod_publisher_books.payment_flag=1";
		$pod_totalpaid_query = $this->db->query($pod_totalpaid_sql);
		$tmp=$pod_totalpaid_query->getResultArray()[0];
		$data['TotalPaid'] =number_format($tmp['total_paid'],2);

		$pod_totalpending_sql = "SELECT sum(pod_publisher_books.invoice_value) as total_pending
								FROM pod_publisher_books, pod_publisher
								WHERE pod_publisher_books.publisher_id =pod_publisher.id 
								and pod_publisher_books.invoice_flag=1
								and pod_publisher_books.payment_flag=0";
		$pod_totalpending_query = $this->db->query($pod_totalpending_sql);
		$tmp =$pod_totalpending_query->getResultArray()[0];
		$data['TotalPending'] = number_format($tmp['total_pending'],2);

        $pod_totalamount_sql = "SELECT 
                                    SUM(cgst) AS total_cgst,
                                    SUM(sgst) AS total_sgst,
                                    SUM(igst) AS total_igst
                                FROM pod_publisher_books";

        $pod_totalamount_query = $this->db->query($pod_totalamount_sql);
        $result = $pod_totalamount_query->getRowArray(); 
       
        $data['cgst'] = $result['total_cgst'] ?? 0;
        $data['sgst'] = $result['total_sgst'] ?? 0;
        $data['igst'] = $result['total_igst'] ?? 0;


        return $data;	
	}



}
