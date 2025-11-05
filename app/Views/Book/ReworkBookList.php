<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>

<div id="content" class="main-content">
	<div class="layout-px-spacing">
		<div class="page-header">
			<div class="page-title">
			</div>
		</div>
		<table class="zero-config table table-hover mt-3">
        	<thead class="thead-dark">
                <th>S.No</th>
				<th>Book ID</th>
				<th>Title</th>
				<th>Regional Title</th>
				<th>Author</th>
				<th>PaperBack Pages</th>
				<th class="text-center">Actions</th>
			</thead>
			<tbody>
            <?php 
			$i=1;
			foreach($rework as $books_data) {?>
					<tr>
						<td><?php echo $i++; ?></td>
						<td><?php echo $books_data['book_id'] ?></a></td>
						<td><?php echo $books_data['book_title'] ?></a></td>
						<td><?php echo $books_data['regional_book_title'] ?></td>
						<td><?php echo $books_data['author_name'] ?></td>
						<td><?php echo $books_data['number_of_page']?></td>
						<td class="text-center">
							<button type="button" class="btn btn-sm btn-success" 
									onclick="AddToBookList(<?= esc($books_data['book_id']) ?>)">
								Add
							</button>
						</td>
					</tr>
					<?php } ?>
			</tbody>
		</table>
		<div class="form-container outer">
			<div class="form-form">
				<div class="form-form-wrap">
					<div class="form-container">
						<div class="form-content">
							<form class="text-left" action="<?php echo base_url().'book/reworkselectedbooks'?>" method="POST">
								<div class="form">
									<div id="email-field" class="field-wrapper input">
										<label for="email">Selected Books:</label>
										<input id="selected_book_list" name="selected_book_list" class="form-control" placeholder="Selected Book Lists" required>
									</div>
									<br>
									<div class="d-sm-flex justify-content-between">
										<div class="field-wrapper">
											<button style="background-color: #77B748 !important; border-color: #77B748 !important;" type="submit" class="btn btn-primary" value="">Next</button>
											<a href="<?php echo base_url()."book/paperbackdashboard" ?>" class="btn btn-danger">Cancel</a>
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
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
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