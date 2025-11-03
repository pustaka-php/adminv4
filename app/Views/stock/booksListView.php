<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
	<div class="layout-px-spacing">
		<div class="page-header">
			<div class="page-title">
			</div>
		</div>
		<div class="page-header">
			<div class="page-title">
				<h6 class="text-center">Pustaka Paperback - Books List Selection</h6>
			</div>
		</div>
		<table class="zero-config table table-hover mt-3">
        	<thead>
                <th>S.No</th>
				<th>Book ID</th>
				<th>Title</th>
				<th>Regional Title</th>
				<th>Author</th>
				<th>Pustaka Paperback Cost</th>
				<th>PaperBack Pages</th>
				<th class="text-center">Actions</th>
			</thead>
			<tbody>
            <?php 
			$i=1;
			foreach($paperback_books['paperback_book'] as $orders) {?>
						<tr>
						            <td><?php echo $i++; ?></td>
									<td><?php echo $orders['book_id'] ?></a></td>
									<td><?php echo $orders['book_title'] ?></a></td>
									<td><?php echo $orders['regional_book_title'] ?></td>
									<td><?php echo $orders['author_name'] ?></td>
									<td><?php echo $orders['paper_back_inr'] ?></td>
									<td><?php echo $orders['number_of_page']?></td>
									<td class="text-center">
									<input type="button" onclick="AddToBookList(<?php echo $orders['book_id']; ?>)" value="Add">
									</td>
							</tr>
					<?php } ?>	
			</tbody>
		</table>
		<br><br>
		<div class="form-container outer">
			<div class="form-form">
				<div class="form-form-wrap">
					<div class="form-container">
						<div class="form-content">
							<form class="text-left" action="<?php echo base_url().'pustaka_paperback/free_books_list'?>" method="POST">
								<div class="form">
									<div id="email-field" class="field-wrapper input">
										<label for="email">Selected Books:</label>
										<input id="selected_book_list" name="selected_book_list" class="form-control" placeholder="Selected Book Lists" required>
									</div>
									<br>
									<div class="row">
										<div class="col">
											 <label class="">Default No.of.copies</label>
               								 <input class="form-control" name="num_copies" id="num_copies" type="number" required/> 
										</div>
										<div class="col">
											<label for="email">Enter Purpose:</label>
											<input id="purpose" name="purpose" class="form-control" placeholder="Enter the Purpose" required>
										</div>
										<div class="col-3">
											<label class="mt-3">Type</label>
											<div class="form-check">
												<input type="radio" id="authors_free" name="type" class="form-check-input" value="Authors Free" checked required>
												<label class="form-check-label" for="authors_free">Authors Free</label>
											</div>
											<div class="form-check">
												<input type="radio" id="book_procurement" name="type" class="form-check-input" value="Book Procurement" required>
												<label class="form-check-label" for="book_procurement">Book Procurement</label>
											</div>
											<div class="form-check">
												<input type="radio" id="award" name="type" class="form-check-input" value="Award" required>
												<label class="form-check-label" for="award">Award</label>
											</div>
											<div class="form-check">
												<input type="radio" id="media" name="type" class="form-check-input" value="Media" required>
												<label class="form-check-label" for="media">Media </label>
											</div>
											<div class="form-check">
												<input type="radio" id="others" name="type" class="form-check-input" value="Others" required>
												<label class="form-check-label" for="others">Others</label>
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
		</div>
		<div class="page-header">
			<div class="page-title">
				<br>
				<a href="<?php echo base_url()."pustaka_paperback/dashboard" ?>" class="btn btn-danger">Cancel</a>
				<br><br>
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