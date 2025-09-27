<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>
<div id="content" class="main-content">
	<div class="layout-px-spacing">
		<div class="page-header">
			<div class="page-title">
				<h6 class="text-center">POD Author Order - Quantity, Billing, Shipping</h6><br>
			</div>
		</div>
		<div class="form-container outer">
			<div class="form-form">
				<div class="form-form-wrap">
					<div class="form-container">
						<div class="form-content">

							<form class="text-left" action="<?php echo base_url().'paperback/authororderbookssubmit'?>" method="POST">
								<div class="form">
									<div class="col-xxl-4 col-sm-5" style="margin-left: 400px;">
										<div class="card h-100 radius-12 bg-gradient-purple">
											<div class="card-body p-24">
												<div class="text-start">
													<p><strong>Author ID:</strong> <?php echo $author_id; ?></p>
													<p><strong>Number of books:</strong> <?php echo count($pod_selected_books_data); ?></p>
													<p><strong>Selected Books:</strong> <?php echo $pod_selected_book_id; ?></p>
												</div>
											</div>
										</div>
									</div>


									<table class="mt-4 table table-hover zero-config">
										<thead>
											<th>S.no </th>
											<th>Book ID</th>
											<th>Title</th>
											<th>Regional Title</th>
											<th>Author</th>
											<th>Cost</th>
											<th>Paper Back Pages</th>
											<th class="text-center">Qty</th>
											<th class="text-center">Discount</th>
											<th>Final amount</th>
										</thead>
										<tbody>
											<?php  $j=1;
											$cnt = count($pod_selected_books_data);
											for ($i = 0; $i < count($pod_selected_books_data); $i++) { 
												?>
												<tr>
												   <td><?php echo $j++;?></td>
													<td>
														<input type="text" class="form-control" value="<?php echo $pod_selected_books_data[$i]['book_id'] ?>" name="bk_id<?php echo $i; ?>"readonly style="color: black;">
													</td>
													<td>
														<a href="<?= config('App')->pustaka_url . '/home/ebook/' . $pod_selected_books_data[$i]['language_name'] . '/' . $pod_selected_books_data[$i]['url_name'] ?>">
															<?= $pod_selected_books_data[$i]['book_title'] ?>
														</a>
													</td>
													<td><?php echo $pod_selected_books_data[$i]['regional_book_title'] ?></td>
													<td><?php echo $pod_selected_books_data[$i]['author_name'] ?></td>
													<td>
														<input type="text" class="form-control" value="<?php echo $pod_selected_books_data[$i]['paper_back_inr'] ?>" name="bk_inr<?php echo $i; ?>" id="bk_inr<?php echo $i; ?>" readonly onInput="calculateTotalAmount(<?php echo $cnt; ?>)">
													</td>
													<td><?php echo $pod_selected_books_data[$i]['paper_back_pages'] ?></td>
													<td class="text-center">
														<input type="text" class="form-control" placeholder="0" id="bk_qty<?php echo $i; ?>" name="bk_qty<?php echo $i; ?>" onInput="calculateTotalAmount(<?php echo $cnt; ?>)" required>
													</td>
													<td class="text-center">
														<input type="text" class="form-control" placeholder="0" id="bk_discount<?php echo $i; ?>" name="bk_discount<?php echo $i; ?>" value='50' onInput="calculateTotalAmount(<?php echo $cnt; ?>)">
													</td>
													<td>
														<input type="text" class="form-control" placeholder="0" id="tot_amt<?php echo $i; ?>" name="tot_amt<?php echo $i; ?>" readonly>
													</td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
									<div class="row">
										<div class="col-7">
										</div>
									   <div class="col-2">
									    <h6>Total amount:</h6>
								       </div>	
									   <div class="col-3">
									   <input type="text" id="sub_total" name="sub_total" class="form-control" readonly style="color: black;">
									   </div>		
									</div>
									<br><br><br>
									<div class="row">
										<div class="col-6">
											<label for="ship_date">Shipping Date</label>
											<input type="date" id="ship_date" name="ship_date" class="form-control" required>
										</div>
										<div class="col-3">
											<label>Payment Status</label>
											<div class="form-check">
												<input type="radio" id="pending" name="payment_status" class="form-check-input" value="Pending" checked required>
												<label class="form-check-label" for="pending">Pending</label>
											</div>
											<div class="form-check">
												<input type="radio" id="paid" name="payment_status" class="form-check-input" value="Paid" required>
												<label class="form-check-label" for="paid">Paid</label>
											</div>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-6">
											<h6 class="mt-3">Billing Address</h6>
											<br><br>
											<label class="mt-4">User ID</label>
											<input type="text" class="form-control" onInput="fill_url_title()" name="user_id" id="user_id" value="<?php echo $pod_author_addr_details[0]['copyright_owner'] ?>"/>
											<label class="mt-4">Name</label>
											<input type="text" class="form-control" onInput="fill_url_title()" name="bill_name" id="bill_name" value="<?php echo $pod_author_addr_details[0]['author_name'] ?>"/>
											<label class="mt-3">Address</label>   
                                            <textarea class="form-control" name="bill_addr" id="bill_addr" rows="4" cols="50"><?php echo $pod_author_addr_details[0]['address'] ?></textarea>
        									<label class="mt-3">Mobile</label>
											<input class="form-control" name="bill_mobile" id="bill_mobile" value="<?php echo $pod_author_addr_details[0]['mobile'] ?>"/>                         
											<label class="mt-3">Email</label>
											<input type="email" class="form-control" name="bill_email" id="bill_email" value="<?php echo $pod_author_addr_details[0]['email'] ?>"/>                         
										</div>
										<div class="col-6">
											<h6 class="mt-4">Shipping Address</h6>
											<br><button type="button" 
												id="same_billing" 
												name="same_billing" 
												class="btn rounded-pill btn-lilac-100 text-lilac-600 radius-8 px-20 py-11" 
												onclick="validate()">
												Same as billing address
											</button>
											<br><label class="mt-4">Name</label>
											<input type="text" class="form-control" onInput="fill_url_title()" name="ship_name" id="ship_name"/>
											<label class="mt-3">Address</label>
											<textarea class="form-control" name="ship_addr" id="ship_addr" rows="4" cols="50"></textarea>                                            
											<label class="mt-3">Mobile</label>
											<input class="form-control" name="ship_mobile" id="ship_mobile"/>                         
											<label class="mt-3">Email</label>
											<input type="email" class="form-control" name="ship_email" id="ship_email"/>  
										</div>
									</div>
									<br>
									<div class="d-sm-flex justify-content-between">
										<div class="field-wrapper">
											<button style="background-color: #77B748 !important; border-color: #77B748 !important;" type="submit" class="btn btn-primary" value="">Next</button>
										</div>
									</div>
								</div>
							</form>

						</div>                    
					</div>
				</div>
			</div>
			<div class="page-title">
				<br>
				<a href="<?php echo base_url()."orders/ordersdashboard" ?>" class="btn btn-danger">Cancel</a>
				<br><br>
			</div>
		</div>
	</div>
	<br><br>
</div>
<script type=text/javascript>
var base_url = window.location.origin ;
function AddToBookList(bk_id) {
		var existing_bk_list = document.getElementById('selected_bk_list').value;
		if (existing_bk_list)
			document.getElementById('selected_bk_list').value = bk_id + ',' + existing_bk_list;
		else
			document.getElementById('selected_bk_list').value = bk_id;
}


function calculateTotalAmount(cnt) {
    var totalSum = 0;
   
    for (var i = 0; i <= cnt; i++) {
        var bk_inr_tmp = "bk_inr" + i;
        var bk_qty_tmp = "bk_qty" + i;
        var bk_dis_tmp = "bk_discount" + i;
        var tot_amt_tmp = "tot_amt" + i;

        var bk_inr = document.getElementById(bk_inr_tmp).value;
        var bk_qty = document.getElementById(bk_qty_tmp).value;
        var bk_discount = document.getElementById(bk_dis_tmp).value;

        var tmp_tot = bk_inr * bk_qty;
        var tmp_dis = tmp_tot * bk_discount / 100;
        var tmp = tmp_tot - tmp_dis;

        document.getElementById(tot_amt_tmp).value = tmp;
    	totalSum += tmp;   
		
		document.getElementById('sub_total').value = totalSum;
    }
}


function validate(){
	let isChecked = false;
    const button = document.getElementById('same_billing');

    // Toggle state
    isChecked = !isChecked;

    // Optionally change button style to show active/inactive
    if (isChecked) {
        button.classList.add('active'); // You can define an .active style in CSS
        document.getElementById('ship_name').value = document.getElementById('bill_name').value;
        document.getElementById('ship_addr').value = document.getElementById('bill_addr').value;
        document.getElementById('ship_mobile').value = document.getElementById('bill_mobile').value;
        document.getElementById('ship_email').value = document.getElementById('bill_email').value;
    } else {
        button.classList.remove('active');
        // Optional: clear shipping fields
        document.getElementById('ship_name').value = '';
        document.getElementById('ship_addr').value = '';
        document.getElementById('ship_mobile').value = '';
        document.getElementById('ship_email').value = '';
    }
}
</script>
<?= $this->endSection(); ?>