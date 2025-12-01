<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<div id="content" class="main-content">
	<div class="layout-px-spacing">
		<div class="page-header">
			<div class="page-title">
				<h6 class="text-center">Amazon Paparback Selected Books List</h6>
				<a href="<?= base_url('paperback/paperbackamazonorder'); ?>" 
					class="btn btn-outline-secondary btn-sm float-end">
						← Back
				</a>
                <br><br>
			</div>
		</div>
		<div class="form-container outer">
			<div class="form-form">
				<div class="form-form-wrap">
					<div class="form-container">
						<div class="form-content">

							<form class="text-left" action="<?php echo base_url().'paperback/pustakaamazonorderstock'?>" method="POST">
								<div class="form">

								<input type="hidden" value="<?php echo count($amazon_selected_books_data); ?>" name="num_of_books">
                                <input type="hidden" value="<?php echo $amazon_selected_book_id; ?>" name="selected_book_list">

									<table class="table table-bordered mb-4">
										<thead>
                                        <th>S.No</th>
										<th>Book ID</th>
										<th>Title</th>
										<th>Regional Title</th>
										<th>Author</th>
										<th>Amazon price</th>
										<th>Pustaka Paperback Cost</th>
										<th>PaperBack Pages</th>
										<th >Quantity</th>
						
										</thead>
										<tbody>
										<?php
										 $i=1;
										 $j=1;
										
										 foreach($amazon_selected_books_data as $selected_books)  {?>
												<tr>
												  <td><?php echo $i++; ?></td>
												  <td>
														<input type="text" class="form-control" value="<?php echo $selected_books['book_id'] ?>" name="book_id<?php echo $j; ?>">
													</td>
													<td>
														<a href="<?= base_url('home/ebook/' . $selected_books['language'] . '/' . $selected_books['url']) ?>">
															<?= $selected_books['book_title'] ?>
														</a>
													</td>
													<td><?php echo $selected_books['regional_book_title'] ?></td>
													<td><?php echo $selected_books['author_name'] ?></td>
													<td><?php  echo $selected_books['price'] ?></td>
													<td><?php echo $selected_books['paper_back_inr'] ?></td>
													<td><?php echo $selected_books['number_of_page']?></td>
													<td class="text-center">
														<input type="text" class="form-control" placeholder="0" name="bk_qty<?php echo $j++; ?>"required>
													</td>
					
												</tr>
											<?php } ?>
											
										</tbody>
									</table>
									<br><br><br>
									<div >
										<label>Amazon Order ID</label>
										<input  type="text" id="order_id" name="order_id" class="form-control" placeholder="Order ID" required>
									</div>
									<br>
									<div class=row>
										 <div class=col>
											<label>Shipping Date</label>
										    <br><input type="Date" id="ship_date" name="ship_date" class="form-control" required>
										 </div>
										 <br>
										 <div class=col-5>
										   <label>Shipping Type</label>
											<div class="form-check">
												<input type="radio" id="easy_ship" name="shipping_type" class="form-check-input" value="Easy-Ship" checked required>
												<label class="form-check-label" for="easy_ship">Easy-Ship</label>
											</div>
											<div class="form-check">
												<input type="radio" id="self_ship" name="shipping_type" class="form-check-input" value="Self-Ship" required>
												<label class="form-check-label" for="self_ship">Self-Ship</label>
											</div>
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
				<a href="<?php echo base_url()."paperback/pustakaamazonorderstock"  ?>" class="btn btn-danger">Cancel</a>
				<br><br>
			</div>
		</div>
	</div>
	<br><br>
</div>
<script type="text/javascript">
    var base_url = window.location.origin ;
    function AddToBookList(book_id) {
		var existing_book_list = document.getElementById('selected_book_list').value;
		if (existing_book_list)
			document.getElementById('selected_book_list').value = book_id + ',' + existing_book_list;
		else
			document.getElementById('selected_book_list').value = book_id;
    }
</script>
<?= $this->endSection(); ?>

