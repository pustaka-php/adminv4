<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
	<div class="layout-px-spacing">
		<div class="page-header">
			<div class="page-title">
			</div>
		</div>
		<div class="page-title row">
                <div class="col">
                 <h6 class="text-center">Paperback Books List </h6>
                </div>
                <div class="col-3">
                   	<a href="paperbackledgerstockdetails" class="btn btn-success mb-2 mr-2">Download Stock Excel</a>
                </div>
            </div>
		<table class="zero-config table table-hover mt-3">
        	<thead>
                <th>S.No</th>
				<th>Book ID</th>
				<th>Title</th>
				<th>Regional Title</th>
				<th>Author</th>
				<th >InDesign readiness</th>
				<th class="text-center">Actions</th>
			</thead>
			<tbody>
				<?php 
				$i=1;
				foreach($paperback_books as $books) {?>
					<tr>
						<td><?php echo $i++; ?></td>
						<td><?php echo $books['book_id'] ?></a></td>
						<td><?php echo $books['book_title'] ?></a></td>
						<td><?php echo $books['regional_book_title'] ?></td>
						<td><?php echo $books['author_name'] ?></td>
						<td><b><?php
						if ($books['paper_back_readiness_flag'] == 1) {
							echo '<span style="color: green;">Ready</span>';
						} else {
							echo '<span style="color: Red;">Not Ready</span>';
						}
						?></b>
						</td>
						<td class="text-center">
							<a href="<?php echo base_url()."stock/paperbackledgerbooksdetails/".$books['book_id']; ?>" 
								class="btn btn-small btn-lilac-100 text-lilac-600 rounded-pill"
								target="_blank">
								View
							</a>

						</td>
					</tr>
				<?php } ?>	
			</tbody>
		</table>
	<br><br>
</div>
<?= $this->endSection(); ?>