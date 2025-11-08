<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<div id="content" class="main-content">
	    <div class="d-flex justify-content-end mb-3">
			<a href="<?= base_url('paperback/offlineorderbooksstatus'); ?>" 
			class="btn btn-outline-secondary btn-sm d-flex align-items-center shadow-sm">
				<iconify-icon icon="mdi:arrow-left" class="me-1 fs-5"></iconify-icon> Back
			</a>
		</div>
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
		<br><br>
		<table class="zero-config table table-hover mt-1">
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
				$i = 1;
				foreach($paperback_books as $orders) { ?>
					<tr>
						<td><?php echo $i++; ?></td>
						<td><?php echo $orders['book_id']; ?></td>
						<td><?php echo $orders['book_title']; ?></td>
						<td><?php echo $orders['regional_book_title']; ?></td>
						<td><?php echo $orders['author_name']; ?></td>
						<td><?php echo $orders['paper_back_inr']; ?></td>
						<td><?php echo $orders['number_of_page']; ?></td>
						<td class="text-center">
							<div style="display: flex; gap: 6px; justify-content: center;">
								<input type="button" 
									onclick="AddToBookList(<?php echo $orders['book_id']; ?>)" 
									value="Add" 
									class="btn radius-8 px-10 py-2" 
									style="font-size: 12px; background-color: #0d6efd; color: white; border: none;" />

								<?php if($orders['paper_back_inr'] == 0): ?>
									<a href="<?php echo base_url()."book/edit_book/".$orders['book_id'] ?>" 
									class="btn btn-success radius-8 px-10 py-2" 
									style="font-size: 12px;" 
									target="_blank">Edit</a>
								<?php endif; ?>
							</div>
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
							<form class="text-left" action="<?php echo base_url().'paperback/offlineorderbookslist'?>" method="POST">
								<div class="form">
									<div id="email-field" class="field-wrapper input">
										<label for="email">Selected Books:</label>
										<input id="selected_book_list" name="selected_book_list" class="form-control" placeholder="Selected Book Lists" required>
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
				<a href="<?php echo base_url()."orders/ordersdashboard" ?>" class="btn btn-danger">Cancel</a>
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