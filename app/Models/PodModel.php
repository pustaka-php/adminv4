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
    // Get books of a publisher
    public function getBooksByPublisher($publisher_id)
    {
        return $this->db->table('pod_publisher_books')
                        ->where('publisher_id', $publisher_id)
                        ->orderBy('book_id', 'ASC')
                        ->get()
                        ->getResultArray();
    }

    public function PodpublisherSubmit($publisher_data)
    {
        $db = db_connect();

        if ($db->table('pod_publisher')->insert($publisher_data)) {
            return ['status' => 'success'];
        }
        return ['status' => 'error'];
    }
    public function getPublisherById($id)
    {
        return $this->db->table('pod_publisher')->where('id', $id)->get()->getRowArray();
    }

    public function updatePublisher($id, $data)
    {
        $db = db_connect();
        if ($db->table('pod_publisher')->where('id', $id)->update($data)) {
            return ['status' => 'success'];
        }
        return ['status' => 'error'];
    }
    public function getBookById($book_id)
    {
        return $this->db->table('pod_publisher_books')
                        ->where('book_id', $book_id)
                        ->get()
                        ->getRowArray();
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

    function getPodWork(){

		$sql="SELECT publisher_name,pod_book_id,book_title FROM pod_indesign where status=0 and start_flag=0";
		$query=$this->db->query($sql);
		$data['book_not_start'] =$query->getResultArray();

		$sql="SELECT pod_indesign.*,language_tbl.language_name
			FROM pod_indesign,language_tbl
			where pod_indesign.language =language_tbl.language_id
			and pod_indesign.status=0 and pod_indesign.start_flag=1";
		$query=$this->db->query($sql);
		$data['status_details'] =$query->getResultArray();

		$sql="SELECT pod_indesign.*,language_tbl.language_name
			FROM pod_indesign,language_tbl
			where pod_indesign.language =language_tbl.language_id
			and pod_indesign.status=1 and pod_indesign.start_flag=1";
		$query=$this->db->query($sql);
		$data['completed'] =$query->getResultArray();

        return $data;
	}
    // Add Publisher Book
    public function addPodBook()
    {
        $request = service('request');
        $post = $request->getPost();

        // Fetch Publisher details to determine IGST or SGST/CGST
        $publisherId = $post['publisher_id'];
        $podPublisherSql = "SELECT * FROM pod_publisher WHERE id = ?";
        $podPublisherQuery = $this->db->query($podPublisherSql, [$publisherId]);
        $podPublisher = $podPublisherQuery->getRowArray();

        // Extract form fields
        $num_pages_quote1 = $post['num_pages_quote1'];
        $num_pages_quote2 = $post['num_pages_quote2'];
        $cost_per_page1   = $post['cost_per_page1'];
        $cost_per_page2   = $post['cost_per_page2'];
        $fixed_charge_book = $post['fixed_charge_book'];
        $num_copies        = $post['num_copies'];
        $design_charges    = $post['design_charges'];
        $transport_charges = $post['transport_charges'];

        // Cost Calculations
        $book_cost1 = $num_pages_quote1 * $cost_per_page1;
        $book_cost2 = $num_pages_quote2 * $cost_per_page2;
        $book_cost  = $book_cost1 + $book_cost2 + $fixed_charge_book;
        $invoice_value = $book_cost * $num_copies + $design_charges;

        if ($transport_charges > 1000) {
            $invoice_value += $transport_charges;
        }

        $sub_total = $invoice_value / 1.12;
        $gst = $invoice_value - $sub_total;

        if (!empty($podPublisher) && $podPublisher['igst_flag'] == 1) {
            $igst = $gst;
            $sgst = 0;
            $cgst = 0;
        } else {
            $sgst = $gst / 2;
            $cgst = $sgst;
            $igst = 0;
        }

        if ($transport_charges < 1000) {
            $invoice_value += $transport_charges;
        }

        // Prepare data for insert
        $publisherBookData = [
            'publisher_id'        => $post['publisher_id'],
            'custom_publisher_name' => $post['custom_publisher_name'],
            'publisher_reference' => $post['publisher_reference'],
            'book_title'          => $post['book_title'],
            'total_num_pages'     => $post['total_num_pages'],
            'num_copies'          => $num_copies,
            'book_size'           => $post['book_size'],
            'cover_paper'         => $post['cover_paper'],
            'cover_gsm'           => $post['cover_gsm'],
            'content_paper'       => $post['content_paper'],
            'content_gsm'         => $post['content_gsm'],
            'content_colour'      => $post['content_colour'],
            'lamination_type'     => $post['lamination_type'],
            'binding_type'        => $post['binding_type'],
            'content_location'    => $post['content_location'],
            'num_pages_quote1'    => $num_pages_quote1,
            'cost_per_page1'      => $cost_per_page1,
            'num_pages_quote2'    => $num_pages_quote2,
            'cost_per_page2'      => $cost_per_page2,
            'fixed_charge_book'   => $fixed_charge_book,
            'delivery_date'       => $post['delivery_date'],
            'transport_charges'   => $transport_charges,
            'design_charges'      => $design_charges,
            'remarks'             => $post['remarks'],
            'ship_address'        => $post['ship_address'],
            'sub_total'           => $sub_total,
            'sgst'                => $sgst,
            'cgst'                => $cgst,
            'igst'                => $igst,
            'invoice_value'       => $invoice_value
        ];

        // Insert into database
        $builder = $this->db->table('pod_publisher_books');
        $builder->insert($publisherBookData);

        return 1;
    }
    public function editPublisherBookDetails($book_id)
{
    $db = \Config\Database::connect();

    // Get book and publisher details
    $pod_publisher_edit_sql = "
        SELECT * FROM pod_publisher_books 
        JOIN pod_publisher ON pod_publisher.id = pod_publisher_books.publisher_id 
        WHERE pod_publisher_books.book_id = " . (int)$book_id;

    $pod_publisher_edit_query = $db->query($pod_publisher_edit_sql);
    $data['pod_publisher_book'] = $pod_publisher_edit_query->getRowArray();

    // Get all active publishers
    $pod_publisher_sql = "SELECT * FROM pod_publisher WHERE status = 1";
    $pod_publisher_query = $db->query($pod_publisher_sql);
    $data['pod_publishers'] = $pod_publisher_query->getResultArray();

    return $data;
}
public function getBooksCompletedData()
    {
        $db = \Config\Database::connect();
        $data = [];

        // Total books
        $query = $db->query("SELECT COUNT(*) as cnt, SUM(num_copies) as copies_cnt FROM pod_publisher_books");
        $tmp = $query->getRowArray();
        $data['total_order_count'] = $tmp['cnt'];
        $data['total_copies_count'] = $tmp['copies_cnt'];

        // Completed books
        $query = $db->query("SELECT COUNT(*) as cnt, SUM(num_copies) as copies_cnt FROM pod_publisher_books WHERE delivery_flag=1");
        $tmp = $query->getRowArray();
        $data['completed_order_count'] = $tmp['cnt'];
        $data['completed_copies_count'] = $tmp['copies_cnt'];

        // Pending books
        $query = $db->query("SELECT COUNT(*) as cnt, SUM(num_copies) as copies_cnt FROM pod_publisher_books WHERE delivery_flag=0");
        $tmp = $query->getRowArray();
        $data['pending_order_count'] = $tmp['cnt'];
        $data['pending_copies_count'] = $tmp['copies_cnt'];

        // Percentages
        $data['completed_order_percentage'] = $data['completed_copies_count'] > 0 
            ? round($data['completed_copies_count'] / ($data['completed_copies_count'] + $data['pending_copies_count']) * 100, 2) 
            : 0;
        $data['pending_order_percentage'] = 100 - $data['completed_order_percentage'];

       $current_year = date('Y');
        $current_month = date('m');

        // Monthly delivery (June onwards, excluding current month)
        $monthly_sql = "
            SELECT 
                DATE_FORMAT(temp.trans_date, '%M %Y') AS month_name,
                SUM(del_num_bks) AS monthly_planned_delivery_books,
                SUM(act_del_num_bks) AS monthly_actual_delivery_books,
                SUM(del_num_pgs) AS monthly_planned_delivery_pages,
                SUM(act_del_num_pgs) AS monthly_actual_delivery_pages
            FROM (
                SELECT 
                    delivery_date AS trans_date,
                    num_copies AS del_num_bks,
                    0 AS act_del_num_bks,
                    total_num_pages * num_copies AS del_num_pgs,
                    0 AS act_del_num_pgs
                FROM pod_publisher_books
                WHERE delivery_date >= '{$current_year}-06-01' 
                    AND delivery_flag = 1
                    AND MONTH(delivery_date) < '{$current_month}'

                UNION ALL

                SELECT 
                    actual_delivery_date AS trans_date,
                    0 AS del_num_bks,
                    num_copies AS act_del_num_bks,
                    0 AS del_num_pgs,
                    total_num_pages * num_copies AS act_del_num_pgs
                FROM pod_publisher_books
                WHERE actual_delivery_date >= '{$current_year}-06-01' 
                    AND delivery_flag = 1
                    AND MONTH(actual_delivery_date) < '{$current_month}'
            ) temp
            GROUP BY DATE_FORMAT(temp.trans_date, '%Y-%m')
            ORDER BY MIN(temp.trans_date) ASC
        ";

        $query = $db->query($monthly_sql);
        $data['monthly_delivery'] = $query->getResultArray();

        // Daily delivery from first day of month
        $query = $db->query("SELECT LAST_DAY(NOW() - INTERVAL 1 MONTH) + INTERVAL 1 DAY AS first_day");
        $first_day = $query->getRow()->first_day;

        $daily_sql = "SELECT DATE_FORMAT(temp.trans_date, '%d %M %Y') AS daily_name,
                             SUM(act_del_num_bks) AS daily_actual_delivery_books,
                             SUM(act_del_num_pgs) AS daily_actual_delivery_pages
                      FROM (
                          SELECT actual_delivery_date AS trans_date, num_copies AS act_del_num_bks, 0 AS act_del_num_pgs
                          FROM pod_publisher_books WHERE actual_delivery_date >= '$first_day' AND delivery_flag=1
                          UNION ALL
                          SELECT actual_delivery_date, 0, total_num_pages*num_copies
                          FROM pod_publisher_books WHERE actual_delivery_date >= '$first_day' AND delivery_flag=1
                      ) temp
                      GROUP BY daily_name
                      ORDER BY temp.trans_date DESC";
        $query = $db->query($daily_sql);
        $data['daily_delivery'] = $query->getResultArray();

        // Publisher orders summary
        $publisher_sql = "SELECT pod_publisher.id AS publisher_id, pod_publisher.publisher_name, 
                                 SUM(pod_publisher_books.num_copies) AS num_copies, COUNT(*) AS num_orders
                          FROM pod_publisher_books
                          JOIN pod_publisher ON pod_publisher_books.publisher_id = pod_publisher.id
                          GROUP BY pod_publisher.id
                          ORDER BY num_copies DESC";
        $query = $db->query($publisher_sql);
        $publisher_orders = [];
        foreach ($query->getResultArray() as $row) {
            $publisher_orders[$row['publisher_id']] = [
                'publisher_name' => $row['publisher_name'],
                'num_copies_total' => $row['num_copies'],
                'num_orders_total' => $row['num_orders'],
                'num_orders_pending' => 0,
                'num_copies_pending' => 0
            ];
        }

        // Pending orders per publisher
        $pending_sql = "SELECT pod_publisher.id AS publisher_id, pod_publisher.publisher_name, 
                               SUM(pod_publisher_books.num_copies) AS num_copies, COUNT(*) AS num_orders
                        FROM pod_publisher_books
                        JOIN pod_publisher ON pod_publisher_books.publisher_id = pod_publisher.id
                        WHERE pod_publisher_books.delivery_flag = 0
                        GROUP BY pod_publisher.id
                        ORDER BY num_copies DESC";
        $query = $db->query($pending_sql);
        foreach ($query->getResultArray() as $row) {
            $publisher_id = $row['publisher_id'];
            if (isset($publisher_orders[$publisher_id])) {
                $publisher_orders[$publisher_id]['num_orders_pending'] = $row['num_orders'];
                $publisher_orders[$publisher_id]['num_copies_pending'] = $row['num_copies'];
            } else {
                $publisher_orders[$publisher_id] = [
                    'publisher_name' => $row['publisher_name'],
                    'num_copies_total' => 0,
                    'num_orders_total' => 0,
                    'num_orders_pending' => $row['num_orders'],
                    'num_copies_pending' => $row['num_copies'],
                ];
            }
        }
        $data['pod_publisher_orders'] = $publisher_orders;

        // Future orders
        $future_sql = "SELECT pod_publisher.publisher_name, pod_publisher_books.*
                       FROM pod_publisher_books
                       JOIN pod_publisher ON pod_publisher_books.publisher_id = pod_publisher.id
                       WHERE delivery_date > NOW()
                       ORDER BY delivery_date";
        $query = $db->query($future_sql);
        $data['future_orders'] = $query->getResultArray();

        // Publisher names
        $query = $db->query("SELECT publisher_name FROM pod_publisher");
        $publishers = array_map(fn($row) => $row['publisher_name'], $query->getResultArray());
        $data['publishers'] = $publishers;

        // Delivered pages & covers
        $query = $db->query("SELECT book_size, content_paper, SUM(total_num_pages*num_copies) AS total_pages 
                             FROM pod_publisher_books WHERE delivery_flag=1 GROUP BY book_size, content_paper");
        $data['pod_pages_delivered'] = $query->getResultArray();

        $query = $db->query("SELECT book_size, cover_paper, SUM(num_copies) AS total_covers 
                             FROM pod_publisher_books WHERE delivery_flag=1 GROUP BY book_size, cover_paper");
        $data['pod_covers_delivered'] = $query->getResultArray();

        // Pending pages & covers
        $query = $db->query("SELECT book_size, content_paper, SUM(total_num_pages*num_copies) AS total_pages 
                             FROM pod_publisher_books WHERE delivery_flag=0 GROUP BY book_size, content_paper");
        $data['pod_pages_pending'] = $query->getResultArray();

        $query = $db->query("SELECT book_size, cover_paper, SUM(num_copies) AS total_covers 
                             FROM pod_publisher_books WHERE delivery_flag=0 GROUP BY book_size, cover_paper");
        $data['pod_covers_pending'] = $query->getResultArray();

        return $data;
    }
    
public function getMonthDetails($month)
{
    $db = \Config\Database::connect();

    $sql = "SELECT book_title, num_copies, actual_delivery_date
            FROM pod_publisher_books
            WHERE DATE_FORMAT(actual_delivery_date, '%M %Y') = ?";
    $query = $db->query($sql, [$month]);

    return $query->getResultArray();
}
public function getPODPublisherBookDetails($book_id)
{
    return $this->db->table('pod_publisher_books')
                    ->where('book_id', $book_id)
                    ->get()
                    ->getRowArray();
}

public function getPODPublisherDetails($publisher_id)
{
    return $this->db->table('pod_publisher')
                    ->where('id', $publisher_id)
                    ->get()
                    ->getRowArray();
}
public function createInvoice($book_id, $invoice_number)
{
    $db = \Config\Database::connect();

    $builder = $db->table('pod_publisher_books');

    $builder->set('invoice_flag', 1);
    $builder->set('invoice_number', $invoice_number);
    $builder->set('invoice_date', date('Y-m-d H:i:s')); // current timestamp
    $builder->where('book_id', $book_id);
    $builder->update();

    if ($db->affectedRows() > 0) {
        return 1;
    } else {
        return 0;
    }
}
 // Get pending invoices grouped by publisher
    public function getPendingInvoices()
    {
        return $this->db->table('pod_publisher_books pb')
            ->select('pb.publisher_id, p.publisher_name, SUM(pb.invoice_value) as total_invoice_value, COUNT(pb.book_id) as total_books')
            ->join('pod_publisher p', 'p.id = pb.publisher_id', 'left')
            ->where('pb.invoice_flag', 0)
            ->groupBy('pb.publisher_id, p.publisher_name')
            ->get()
            ->getResultArray();
    }

    public function getRaisedInvoices()
{
    $builder = $this->db->table('pod_publisher_books b')
        ->select('b.publisher_id, p.publisher_name, COUNT(b.book_id) as total_books, SUM(b.invoice_value) as total_invoice_value')
        ->join('pod_publisher p', 'p.id = b.publisher_id')
        ->where('b.invoice_flag', 1)
        ->where('b.payment_flag', 0)
        ->groupBy('b.publisher_id');

    return $builder->get()->getResultArray();
}
    // Get details for a specific publisher
    public function getPendingInvoicesDetails($publisher_id)
    {
        return $this->db->table('pod_publisher_books pb')
            ->select('pb.*, p.publisher_name')
            ->join('pod_publisher p', 'p.id = pb.publisher_id', 'left')
            ->where('pb.invoice_flag', 0)
            ->where('pb.publisher_id', $publisher_id)
            ->get()
            ->getResultArray();
    }
        // Get books for raised invoices
        public function getRaisedInvoiceBooks($publisher_id)
        {
            return $this->db->table('pod_publisher_books')
                ->select('book_id, book_title, num_copies, invoice_value, invoice_number, invoice_date')
                ->where('publisher_id', $publisher_id)
                ->where('invoice_flag', 1)
                ->where('payment_flag', 0)
                ->get()
                ->getResultArray();
        }
        // Get all paid invoices for a publisher
        public function getPaidInvoices()
        {
            $builder = $this->db->table('pod_publisher_books b')
            ->select('b.publisher_id, p.publisher_name, COUNT(b.book_id) as total_books, SUM(b.invoice_value) as total_invoice_value')
            ->join('pod_publisher p', 'p.id = b.publisher_id')
            ->where('b.invoice_flag', 1)
            ->where('b.payment_flag', 1)
            ->groupBy('b.publisher_id');

        return $builder->get()->getResultArray();
}
public function getPaidInvoiceBooks($publisher_id)
        {
            return $this->db->table('pod_publisher_books')
                ->select('book_id, book_title, num_copies, invoice_value, invoice_number, invoice_date, payment_date')
                ->where('publisher_id', $publisher_id)
                ->where('invoice_flag', 1)
                ->where('payment_flag', 1)
                ->get()
                ->getResultArray();
        }
    
}
