<?php

namespace App\Models;

use CodeIgniter\Model;

class PodModel extends Model
{
    protected $table = '';



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

        $pod_pending_invoice_sql = "SELECT pod_publisher.publisher_name, pod_publisher.igst_flag, pod_publisher_books.* FROM pod_publisher_books, pod_publisher  
									WHERE  pod_publisher_books.invoice_flag = 0 
									and pod_publisher_books.publisher_id = pod_publisher.id";
		$pod_pending_invoice_query = $this->db->query($pod_pending_invoice_sql);
		$data['pending_invoice_list'] = $pod_pending_invoice_query->getResultArray();

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
     
    function GetPublisherInvoiceReport()
    {
        $pod_total_invoice_sql = "SELECT pod_publisher.publisher_name,
                                        pod_publisher_books.publisher_id, 
                                        SUM(pod_publisher_books.invoice_value) AS amt 
                                FROM pod_publisher_books, pod_publisher 
                                WHERE pod_publisher_books.publisher_id = pod_publisher.id 
                                    AND pod_publisher_books.invoice_flag=1 
                                GROUP BY pod_publisher_books.publisher_id";
        $pod_total_invoice_query = $this->db->query($pod_total_invoice_sql)->getResultArray();

        $pod_total_invoices = [];

        foreach ($pod_total_invoice_query as $total_invoice) {
            $tmp['publisher_name']       = $total_invoice['publisher_name'];
            $tmp['total_invoice_amount'] = number_format($total_invoice['amt'], 2);
            $tmp['pending_amount']       = 0;
            $tmp['paid_amount']          = 0;
            $publisher_id                = $total_invoice['publisher_id'];
            $pod_total_invoices[$publisher_id] = $tmp;
        }

        // Pending invoices
        $pod_pending_invoice_sql = "SELECT pod_publisher.publisher_name,
                                        pod_publisher_books.publisher_id, 
                                        SUM(pod_publisher_books.invoice_value) AS amt1
                                    FROM pod_publisher_books, pod_publisher 
                                    WHERE pod_publisher_books.publisher_id = pod_publisher.id 
                                    AND pod_publisher_books.invoice_flag=1
                                    AND pod_publisher_books.payment_flag=0 
                                    GROUP BY pod_publisher_books.publisher_id";
        $pod_pending_invoice_query = $this->db->query($pod_pending_invoice_sql)->getResultArray();

        foreach ($pod_pending_invoice_query as $pending_invoice) {
            $publisher_id = $pending_invoice['publisher_id'];
            if (isset($pod_total_invoices[$publisher_id])) {
                $tmp = $pod_total_invoices[$publisher_id];
                $tmp['pending_amount'] = number_format($pending_invoice['amt1'], 2);
                $pod_total_invoices[$publisher_id] = $tmp;
            }
        }

        // Paid invoices
        $pod_paid_invoice_sql = "SELECT pod_publisher.publisher_name,
                                        pod_publisher_books.publisher_id, 
                                        SUM(pod_publisher_books.invoice_value) AS amt2
                                FROM pod_publisher_books, pod_publisher
                                WHERE pod_publisher_books.publisher_id = pod_publisher.id 
                                AND pod_publisher_books.invoice_flag=1 
                                AND pod_publisher_books.payment_flag=1 
                                GROUP BY pod_publisher_books.publisher_id";
        $pod_paid_invoice_query = $this->db->query($pod_paid_invoice_sql)->getResultArray();

        foreach ($pod_paid_invoice_query as $paid_invoice) {
            $publisher_id = $paid_invoice['publisher_id'];
            if (isset($pod_total_invoices[$publisher_id])) {
                $tmp = $pod_total_invoices[$publisher_id];
                $tmp['paid_amount'] = number_format($paid_invoice['amt2'], 2);
                $pod_total_invoices[$publisher_id] = $tmp;
            }
        }

        return $pod_total_invoices;
    }

    
    function GetMonthlyTotalInvoice()
    {
        //  Total invoices month-wise
        $monthly_total_invoice_sql = "SELECT 
                                        DATE_FORMAT(invoice_date,'%M %Y') AS month_name,
                                        DATE_FORMAT(invoice_date,'%Y-%m') AS month_order, 
                                        SUM(pod_publisher_books.invoice_value) AS total_amount
                                    FROM pod_publisher_books
                                    INNER JOIN pod_publisher ON pod_publisher_books.publisher_id = pod_publisher.id
                                    WHERE pod_publisher_books.invoice_flag = 1
                                    GROUP BY YEAR(invoice_date), MONTH(invoice_date)
                                    ORDER BY YEAR(invoice_date) DESC, MONTH(invoice_date) DESC";
        $monthly_total_invoice_query = $this->db->query($monthly_total_invoice_sql)->getResultArray();

        $monthly_total_invoices = [];

        foreach ($monthly_total_invoice_query as $monthly_total) {
            $tmp['month_name']             = $monthly_total['month_name'];
            $tmp['monthly_total_amount']   = number_format($monthly_total['total_amount'], 2);
            $tmp['monthly_pending_amount'] = 0;
            $tmp['monthly_paid_amount']    = 0;
            $month_key                     = $monthly_total['month_order']; // use YYYY-MM as key
            $monthly_total_invoices[$month_key] = $tmp;
        }

        //  Pending invoices month-wise
        $monthly_pending_invoice_sql = "SELECT 
                                            DATE_FORMAT(invoice_date,'%M %Y') AS month_name,
                                            DATE_FORMAT(invoice_date,'%Y-%m') AS month_order,
                                            SUM(pod_publisher_books.invoice_value) AS pending_amount
                                        FROM pod_publisher_books
                                        INNER JOIN pod_publisher ON pod_publisher_books.publisher_id = pod_publisher.id
                                        WHERE pod_publisher_books.invoice_flag=1
                                        AND pod_publisher_books.payment_flag=0 
                                        GROUP BY YEAR(invoice_date), MONTH(invoice_date)
                                        ORDER BY YEAR(invoice_date) DESC, MONTH(invoice_date) DESC";
        $monthly_pending_invoice_query = $this->db->query($monthly_pending_invoice_sql)->getResultArray();

        foreach ($monthly_pending_invoice_query as $monthly_pending) {
            $month_key = $monthly_pending['month_order'];
            if (isset($monthly_total_invoices[$month_key])) {
                $tmp = $monthly_total_invoices[$month_key];
                $tmp['monthly_pending_amount'] = number_format($monthly_pending['pending_amount'], 2);
                $monthly_total_invoices[$month_key] = $tmp;
            }
        }

        //  Paid invoices month-wise
        $monthly_paid_invoice_sql = "SELECT 
                                        DATE_FORMAT(invoice_date,'%M %Y') AS month_name,
                                        DATE_FORMAT(invoice_date,'%Y-%m') AS month_order, 
                                        SUM(pod_publisher_books.invoice_value) AS paid
                                    FROM pod_publisher_books
                                    INNER JOIN pod_publisher ON pod_publisher_books.publisher_id = pod_publisher.id
                                    WHERE pod_publisher_books.invoice_flag=1 
                                    AND pod_publisher_books.payment_flag=1  
                                    GROUP BY YEAR(invoice_date), MONTH(invoice_date)
                                    ORDER BY YEAR(invoice_date) DESC, MONTH(invoice_date) DESC";
        $monthly_paid_invoice_query = $this->db->query($monthly_paid_invoice_sql)->getResultArray();

        foreach ($monthly_paid_invoice_query as $monthly_paid) {
            $month_key = $monthly_paid['month_order'];
            if (isset($monthly_total_invoices[$month_key])) {
                $tmp = $monthly_total_invoices[$month_key];
                $tmp['monthly_paid_amount'] = number_format($monthly_paid['paid'], 2);
                $monthly_total_invoices[$month_key] = $tmp;
            }
        }

        return $monthly_total_invoices;
    }

     function getPendingBooksData(){
		$pod_books_not_started_sql = "SELECT pod_publisher.publisher_name, pod_publisher_books.book_id, 
									  pod_publisher_books.book_title, pod_publisher_books.delivery_date, pod_publisher_books.num_copies, pod_publisher_books.total_num_pages 
									  FROM pod_publisher_books, pod_publisher WHERE pod_publisher_books.start_flag=0 
									  and pod_publisher_books.publisher_id = pod_publisher.id";
      	$pod_books_not_started_query = $this->db->query($pod_books_not_started_sql);
		$data['books_not_started'] = $pod_books_not_started_query->getResultArray();
        $data['NotStarted'] = count($data['books_not_started']);


		$pod_books_pending_sql = "SELECT pod_publisher.publisher_name, pod_publisher_books.* FROM pod_publisher_books, pod_publisher 
								  WHERE pod_publisher_books.start_flag = 1
								  and pod_publisher_books.delivery_flag = 0
								  and pod_publisher_books.publisher_id = pod_publisher.id
								  order by pod_publisher_books.delivery_date";
		$pod_books_pending_query = $this->db->query($pod_books_pending_sql);
		$data['books_pending'] = $pod_books_pending_query->getResultArray();
        $data['PendingCount'] = count($data['books_pending']);


		$pod_completed_orders_sql = "SELECT pod_publisher.publisher_name, pod_publisher_books.* FROM pod_publisher_books, pod_publisher 
								  WHERE pod_publisher_books.start_flag = 1
								  and pod_publisher_books.delivery_flag = 1
								  and pod_publisher_books.publisher_id = pod_publisher.id
								  order by pod_publisher_books.delivery_date";
		$pod_completed_orders_query = $this->db->query($pod_completed_orders_sql);
		$data['completed_orders'] = $pod_completed_orders_query->getResultArray();

		$pod_start_flag_sql = "SELECT count(*) as cnt from pod_publisher_books where start_flag=0";
		$pod_start_flag_query = $this->db->query($pod_start_flag_sql);
		$tmp = $pod_start_flag_query->getResultArray();
		$data['start_flag_cnt'] = $tmp[0]['cnt'];

		$pod_files_ready_flag_sql = "SELECT count(*) as cnt from pod_publisher_books where start_flag=1 and files_ready_flag=0";
		$pod_files_ready_flag_query = $this->db->query($pod_files_ready_flag_sql);
		$tmp = $pod_files_ready_flag_query->getResultArray();
		$data['files_ready_flag_cnt'] = $tmp[0]['cnt']; 

        $pod_cover_flag_sql = "SELECT count(*) as cnt from pod_publisher_books where files_ready_flag=1 and cover_flag=0";
		$pod_cover_flag_query = $this->db->query($pod_cover_flag_sql);
		$tmp = $pod_cover_flag_query->getResultArray();
		$data['cover_flag_cnt'] = $tmp[0]['cnt']; 

		$pod_cover_copy_sql = "SELECT sum(num_copies) as copies FROM pod_publisher_books where files_ready_flag=1 and cover_flag=0";
		$pod_cover_copy_query = $this->db->query($pod_cover_copy_sql);
		$tmp = $pod_cover_copy_query->getResultArray();
		$data['cover_copy'] = $tmp[0]['copies']; 

		$pod_content_flag_sql = "SELECT count(*) as cnt from pod_publisher_books where files_ready_flag=1 and content_flag=0";
		$pod_content_flag_query = $this->db->query($pod_content_flag_sql);
		$tmp = $pod_content_flag_query->getResultArray();
		$data['content_flag_cnt'] = $tmp[0]['cnt']; 

        $pod_content_page_sql = "SELECT sum(total_num_pages * num_copies) as pages from pod_publisher_books where files_ready_flag=1 and content_flag=0";
		$pod_content_page_query = $this->db->query($pod_content_page_sql);
		$tmp = $pod_content_page_query->getResultArray();
		$data['content_page'] = $tmp[0]['pages']; 

		$pod_lamination_flag_sql = "SELECT count(*) as cnt from pod_publisher_books where cover_flag=1 and lamination_flag=0";
		$pod_lamination_flag_query = $this->db->query($pod_lamination_flag_sql);
		$tmp = $pod_lamination_flag_query->getResultArray();
		$data['lamination_flag_cnt'] = $tmp[0]['cnt'];  

		$pod_binding_flag_sql = "SELECT count(*) as cnt from pod_publisher_books where cover_flag=1 and content_flag=1 and binding_flag=0";
		$pod_binding_flag_query = $this->db->query($pod_binding_flag_sql);
		$tmp = $pod_binding_flag_query->getResultArray();
		$data['binding_flag_cnt'] = $tmp[0]['cnt'];

		$pod_finalcut_flag_sql = "SELECT count(*) as cnt from pod_publisher_books where binding_flag=1 and finalcut_flag=0";
		$pod_finalcut_flag_query = $this->db->query($pod_finalcut_flag_sql);
		$tmp = $pod_finalcut_flag_query->getResultArray();
		$data['finalcut_flag_cnt'] = $tmp[0]['cnt'];
		
		$pod_qc_flag_sql = "SELECT count(*) as cnt from pod_publisher_books where finalcut_flag=1 and qc_flag=0";
		$pod_qc_flag_query = $this->db->query($pod_qc_flag_sql);
		$tmp = $pod_qc_flag_query->getResultArray();
		$data['qc_flag_cnt'] = $tmp[0]['cnt'];
		 
		$pod_invoice_flag_sql = "SELECT count(*) as cnt from pod_publisher_books where invoice_flag=0";
		$pod_invoice_flag_query = $this->db->query($pod_invoice_flag_sql);
		$tmp = $pod_invoice_flag_query->getResultArray();
		$data['invoice_flag_cnt'] = $tmp[0]['cnt'];

		$pod_packing_flag_sql = "SELECT count(*) as cnt from pod_publisher_books where invoice_flag=1 and packing_flag=0";
		$pod_packing_flag_query = $this->db->query($pod_packing_flag_sql);
		$tmp = $pod_packing_flag_query->getResultArray();
		$data['packing_flag_cnt'] = $tmp[0]['cnt'];
		
		return $data;
	}


        public function markProcess($step, $book_id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('pod_publisher_books');

        $flagMap = [
            'start'               => 'start_flag',
            'filesready_complete' => 'files_ready_flag',
            'cover_complete'      => 'cover_flag',
            'content_complete'    => 'content_flag',
            'lamination_complete' => 'lamination_flag',
            'binding_complete'    => 'binding_flag',
            'finalcut_complete'   => 'finalcut_flag',
            'qc_complete'         => 'qc_flag',
            'packing_complete'    => 'packing_flag',
            'delivery_complete'   => 'delivery_flag',
        ];

        if (!array_key_exists($step, $flagMap)) {
            return false;
        }

        $data = [$flagMap[$step] => 1];

        if ($step === 'delivery_complete') {
            $data['actual_delivery_date'] = date('Y-m-d H:i:s');
        }

        return $builder->where('book_id', $book_id)->update($data);
    }







}
