<div id="content" class="main-content">
	<div class="layout-px-spacing">
		<div class="page-header">
			<div class="page-title">
				<h3>POD Author Order -Quantity, Billing, Shipping</h3>
			</div>
		</div>
		<div class="form-container outer">
			<div class="form-form">
				<div class="form-form-wrap">
					<div class="form-container">
						<div class="form-content">

							<form class="text-left" action="<?php echo base_url().'pustaka_paperback/author_orderbooks_submit'?>" method="POST">
								<div class="form">
									<label class="mt-4">Author ID</label>&nbsp;<input type="text" value="<?php echo $author_id; ?>" name="author_id">
									<label class="mt-4">Number of books</label>&nbsp;<input type="text" value="<?php echo count($pod_selected_books_data); ?>" name="num_of_books">
									<label class="mt-4">Selected Books</label>&nbsp;<input type="text" value="<?php echo $pod_selected_book_id; ?>" name="selected_bk_list">
						
									 <table class="mt-4 table table-hover">
										<thead class="thead-dark">
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
													<td><a href="<?php echo $this->config->item('pustaka_url').'/home/ebook/'.$pod_selected_books_data[$i]['language_name'].'/'.$pod_selected_books_data[$i]['url_name'] ?>"><?php echo $pod_selected_books_data[$i]['book_title'] ?></a></td>
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
									<br>
									<br>
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
											<h4 class="mt-3">Billing Address</h4>
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
											<h4 class="mt-4">Shipping Address</h4>
											<br><label for="same_billing">Same as billing address</label> <input id="same_billing" name="same_billing" type="checkbox" onclick="validate()" />
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
				<a href="<?php echo base_url()."pustaka_paperback/dashboard" ?>" class="btn btn-danger">Cancel</a>
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
    var same_billing = document.getElementById('same_billing');
    if (same_billing.checked){
		document.getElementById('ship_name').value = bill_name.value;
		document.getElementById('ship_addr').value = bill_addr.value;
		document.getElementById('ship_mobile').value = bill_mobile.value;
		document.getElementById('ship_email').value = bill_email.value;
        // alert("checked") ;
    }else{
        // alert("You didn't check it! Let me check it for you.")
    }
}
</script>

