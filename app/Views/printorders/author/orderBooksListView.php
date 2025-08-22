<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<div id="content" class="main-content">
	<div class="layout-px-spacing">
		<div class="page-header">
			<div class="page-title">
				<h3>POD Author Order - Books List Selection</h3>
			</div>
		</div>
		<div class="page-header">
			<div class="page-title">
				<h3 style="color:crimson;">Book will not be listed if the COST is not updated !!!</h3>
			</div>
		</div>
		<table class="zero-config table table-hover mt-4">
        	<thead>
				<th>ID</th>
				<th>Title</th>
				<th>Regional Title</th>
				<th>Author</th>
				<th>Cost</th>
				<th>Paper Back Pages</th>
				<th>Weight</th>
				<th class="text-center">Actions</th>
			</thead>
			<tbody>
				<?php for ($i = 0; $i < count($pod_author_books_data); $i++) { 
					?>
					<tr>
						<td><?php echo $pod_author_books_data[$i]['book_id'] ?></td>
						<td><a href="<?php echo $this->config->item('pustaka_url').'/home/ebook/'.$pod_author_books_data[$i]['language_name'].'/'.$pod_author_books_data[$i]['url_name'] ?>"><?php echo $pod_author_books_data[$i]['book_title'] ?></a></td>
						<td><?php echo $pod_author_books_data[$i]['regional_book_title'] ?></td>
						<td><?php echo $pod_author_books_data[$i]['author_name'] ?></td>
						<td><?php echo $pod_author_books_data[$i]['paper_back_inr'] ?></td>
						<td><?php echo $pod_author_books_data[$i]['paper_back_pages'] ?></td>
						<td><?php echo $pod_author_books_data[$i]['paper_back_weight'] ?></td>
						<td class="text-center">
							<input type="button" onclick="AddToBookList(<?php  echo $pod_author_books_data[$i]['book_id']; ?>)" value="Add">
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

							<form class="text-left" action="<?php echo base_url().'paperback/authororderqtylist'?>" method="POST">
								<div class="form">
									<label class="mt-4">Author ID</label>&nbsp;<input type="text" value="<?php echo $author_id; ?>" name="author_id">
									<div id="email-field" class="field-wrapper input">
										<label for="email">Selected Books:</label>
										<input id="selected_bk_list" name="selected_bk_list" class="form-control" placeholder="Selected Book Lists" required>
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
				<a href="<?php echo base_url()."pod/pod_dashboard" ?>" class="btn btn-danger">Cancel</a>
				<br><br>
			</div>
		</div>


	<br><br>
</div>
<script type="text/javascript">
    var base_url = window.location.origin;
    function AddToBookList(bk_id) {
		var existing_bk_list = document.getElementById('selected_bk_list').value;
		if (existing_bk_list)
			document.getElementById('selected_bk_list').value = bk_id + ',' + existing_bk_list;
		else
			document.getElementById('selected_bk_list').value = bk_id;
    }
</script>
<?= $this->endSection(); ?>