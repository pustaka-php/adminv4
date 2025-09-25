<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<div id="content" class="main-content">
	<div class="layout-px-spacing">
		<div class="page-header">
			<div class="page-title">
				<h6 class="text-center">Amazon Paparback Ordered Books List</h6>
                <br>
			</div>
		</div>
		<div class="form-container outer">
			<div class="form-form">
				<div class="form-form-wrap">
					<div class="form-container">
						<div class="form-content">
							<form class="" action="<?php echo base_url().'paperback/amazonorderbookssubmit'?>" method="POST">
								<div class="form">
									<input type="hidden" value="<?php echo count($amazon_paperback_stock); ?>" name="num_of_books">
									<input type="hidden" value="<?php echo $amazon_selected_book_id; ?>" name="selected_book_list">
									<input type="hidden" name="ship_date" value=" <?php echo $ship_date; ?>" name="ship_date">
									<h6 class="text-center" style="color:blue;"><input type="hidden" name="order_id" value=" <?php echo $order_id; ?>"><b>Order ID: <?php echo $order_id; ?></b></h6>
									<h6 class="text-center" style="color:brown;"><input type="hidden" name="ship_type" value=" <?php echo $ship_type; ?>"><b>Shipping Type: <?php echo $ship_type; ?></b></h6>
									<br><br>
									<table class="table table-bordered mb-4 zero-config">
										<thead>
											<th>S.No</th>
											<th>Book ID</th>
											<th>Title</th>
											<th>Author Name</th>
											<th>quantity</th>
											<th>Stock Status</th>
											<th>In progress<th>
											<th>Stock In Hand</th>
										</thead>
											<tbody>
												<?php 
												$i = 1;
												$j = 0;
												foreach ($amazon_paperback_stock as $orders) {
													$quantity_details = $book_qtys[$j];
													?>
													<tr>
														<td><?php echo $i++; ?></td>
														<td>
															<input type="text" class="form-control" value="<?php echo $orders['bookID'] ?>" name="book_id<?php echo $j; ?>">
														</td>
														<td><?php echo $orders['book_title'] ?></td>
														<td><?php echo $orders['author_name'] ?></td>
														<td><input type="hidden" name="quantity_details<?php echo $j++; ?>" value="<?php echo  $quantity_details; ?>"><?php echo $quantity_details ?></td>
														<?php
														$stockStatus = $quantity_details <= $orders['stock_in_hand'] ? 'IN STOCK' : 'OUT OF STOCK';
														?>
														<td>
															<?php echo $stockStatus; ?><br>
															<?php if ($stockStatus == 'OUT OF STOCK') { ?>
																<a href="<?php echo base_url()."paperback/initiateprintdashboard/".$orders['book_id']; ?>" class="btn btn-warning mb-1 mr-1" target="_blank">Initiate Print</a>
															<?php } ?> 
														</td>
														<td><?php echo $orders['Qty'] ?></td>
														<td><?php echo $orders['stock_in_hand'] ?></td>
													</tr>
													<?php
												} ?>	
											</tbody>
									</table>
									<br>
									<div class="d-sm-flex justify-content-between">
										<div class="field-wrapper">
											<button style="background-color: #77B748 !important; border-color: #4864b7ff !important;" type="submit" class="btn btn-primary" value="">Submit</button>
											<a href="<?php echo base_url()."orders/ordersdashboard"  ?>" class="btn btn-danger">Cancel</a>
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