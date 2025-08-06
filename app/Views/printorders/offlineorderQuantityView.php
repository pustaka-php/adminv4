<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<div id="content" class="main-content">
	<div class="layout-px-spacing">
		<div class="page-header">
			<div class="page-title">
				<h6>Offline Paparback Ordered Books List</h6>
                <br>
			</div>
		</div>
		<br>
		<div class="form-container outer">
			<div class="form-form">
				<div class="form-form-wrap">
					<div class="form-container">
						<div class="form-content">
							<form class="" action="<?php echo base_url().'paperback/offlineorderbookssubmit'?>" method="POST">
								<div class="form">
											<input type="hidden" value="<?php echo count($offline_paperback_stock); ?>" name="num_of_books">
											<input type="hidden" value="<?php echo $offline_selected_book_id; ?>" name="selected_book_list">
											<input type="hidden" name="ship_date" value=" <?php echo $ship_date; ?>" name="ship_date">
											<input type="hidden" name="courier_charges" value=" <?php echo $courier_charges; ?>" name="courier_charges">
											<input type="hidden" name="payment_type" value=" <?php echo $payment_type; ?>" name="payment_type">
											<input type="hidden" name="payment_status" value=" <?php echo $payment_status; ?>" name="payment_status">
											<input type="hidden" name="customer_name" value=" <?php echo $customer_name; ?>" name="customer_name">
											<input type="hidden" name="address" value=" <?php echo $address; ?>" name="address">
											<input type="hidden" name="mobile_no" value=" <?php echo $mobile_no; ?>" name="mobile_no">
											<input type="hidden" name="city" value=" <?php echo $city; ?>" name="city">
						
						
										<table class="zero-config table table-hover mt-4"> 
                								<thead>
													<th>S.No</th>
													<th>Book ID</th>
													<th>Title</th>
													<th>Author Name</th>
													<th>quantity</th>
													<th>Stock Status</th>
													<th>In progress</th>
													<th>Stock In Hand</th>
												</thead>
													<tbody>
														<?php 
														$i = 1;
														$j = 0;
														
														foreach ($offline_paperback_stock as $orders) {
															$quantity_details = $book_qtys[$j];
															$book_discount = $book_dis[$j];
															$total_amount = $tot_amt[$j];
															?>
															<tr>
																<td><?php echo $i++; ?></td>
																<td>
																	<input type="text" class="form-control" value="<?php echo $orders['bookID'] ?>" name="book_id<?php echo $j; ?>">
																</td>
																<td><?php echo $orders['book_title'] ?></td>
																<td><?php echo $orders['author_name'] ?></td>

																<td><input type="hidden" name="bk_qty<?php echo $j; ?>" value="<?php echo $quantity_details; ?>"><?php echo $quantity_details ?></td>
																<input type="hidden" name="book_dis<?php echo $j; ?>" value="<?php echo $book_discount; ?>">
															    <input type="hidden" name="tot_amt<?php echo $j; ?>" value="<?php echo $total_amount; ?>">
																<?php
																$stockStatus = $quantity_details <= $orders['stock_in_hand'] ? 'IN STOCK' : 'OUT OF STOCK';
																?>
																<td>
																	<?php echo $stockStatus; ?><br>
																	<?php if ($orders['paper_back_readiness_flag'] == 1) { ?>
																		<?php if ($stockStatus == 'OUT OF STOCK') { ?>
																			<a href="<?php echo base_url() . "pustaka_paperback/initiate_print_dashboard/" . $orders['bookID']; ?>" class="btn btn-warning mb-1 mr-1" target="_blank">Initiate Print</a>
																		<?php } ?> 
																	<?php } else { ?>
																		<a href="<?php echo base_url() . "pod_paperback/initiate_indesign_dashboard/" . $orders['bookID']; ?>" class="btn btn-info mb-1 mr-1" target="_blank">Initiate Indesign</a>
																	<?php } ?>	
																</td>
																<td>
																	<?php if ($orders['paper_back_readiness_flag'] == 1) { ?>
																		<?php if ($stockStatus == 'OUT OF STOCK') { ?>
																			<?php echo $orders['Qty'] ?>
																		<?php } ?> 
																	<?php } else { ?>
																		<?php echo $orders['indesign_status'] ?>
																	<?php } ?>	
																</td>
																<td><center><?php echo $orders['stock_in_hand'] ?></center></td>
															</tr>	
															<?php
															$j++;
														} ?>	
												</tbody>
										</table>
									    <br>
									<div class="d-sm-flex justify-content-between">
										<div class="field-wrapper">
											<button style="background-color: #77B748 !important; border-color: #77B748 !important;" type="submit" class="btn btn-primary" value="">Submit</button>
											<a href="<?php echo base_url()."paperback/offlineorderbooksdashboard"  ?>" class="btn btn-danger">Cancel</a>
										</div>
									</div>
								</div>
							</form>
						</div>                    
					</div>
				</div>
			</div>
		</div>
	</div>
	<br><br>
</div>
<?= $this->endSection(); ?>

