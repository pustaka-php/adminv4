<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
             <div class="page-title row">
                <div class="col">
                <h6 class="text-center">Lost / Excess Books Status Dashboard</h6>
                </div>
            </div>
        <br>
        <table class="table zero-config">
            <thead>
				<tr> 
					<th>S.No</th>
					<th>Book Id</th>
					<th>Title</th>
					<th>Author Name</th>
					<th>Stock In Hand</th>
					<th>Qty Details</th>
					<th>Action</th>
					<th>Download</th>
					<th>Ledger</th>
				</tr>
            </thead>
            <tbody style="font-weight: normal;">
                <?php $i=1;
                  foreach($lost_excess['in_progress'] as $lost_excess_book ) { 
				?>
					<tr>
						<td><?php echo $i++; ?></td>
						<td><?php echo $lost_excess_book['book_id']; ?></td>
						<td><?php echo $lost_excess_book['book_title']; ?></td>
						<td><?php echo $lost_excess_book['author_name']; ?></td>
						<td><input type="hidden" id="stock_in_hand" value="<?php echo $lost_excess_book['stock_in_hand']; ?>"><?php echo $lost_excess_book['stock_in_hand']; ?></td>
						<td>
							Ledger: <?= $lost_excess_book['qty'] ?><br>

							Fair / Store: 
							<?= 
								$lost_excess_book['bookfair'] +
								$lost_excess_book['bookfair2'] +
								$lost_excess_book['bookfair3'] +
								$lost_excess_book['bookfair4'] +
								$lost_excess_book['bookfair5']
							?><br>

							<?php if (!empty($lost_excess_book['excess_qty']) && $lost_excess_book['excess_qty'] > 0) { ?>
								<span style="color:#008000;">Excess: <?= $lost_excess_book['excess_qty'] ?></span><br>
							<?php } ?>

							<?php if (!empty($lost_excess_book['lost_qty']) && $lost_excess_book['lost_qty'] > 0) { ?>
								<span style="color:#ff0000;">Lost: <?= $lost_excess_book['lost_qty'] ?></span><br>
							<?php } ?>
						</td>
						<td>
							<a href="<?php echo base_url()."stock/printexcesslostone/" . $lost_excess_book['book_id'] ?>" 
							class="btn rounded-pill btn-success-100 text-success-600 radius-8 px-10 py-4"
							style="font-size: 10px; font-weight: bold;">
							Print One
							</a>
							<br><br>
							<a href="<?php echo base_url()."stock/printexcesslostall/" . $lost_excess_book['book_id'] ?>" 
							class="btn rounded-pill btn-danger-100 text-warning-600 radius-8 px-10 py-4"
							style="font-size: 11px; font-weight: bold;">
							Print All
							</a>
						</td>

						<td>
							<?php if ($lost_excess_book['lost_qty'] > 0) { ?>
								<div class="row">
                                    <div class="col-3">
                                        <a href="<?=('https://pustaka-indesign.s3.ap-south-1.amazonaws.com/' .$lost_excess_book['book_id'].'/'.$lost_excess_book['url_name'].'-cover.pdf') ?>"   class="bs-tooltip" title="<?php echo 'Cover'?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                                        </a> 
                                        </div>
                                        <div class="col-3">
                                        <a href="<?=('https://pustaka-indesign.s3.ap-south-1.amazonaws.com/' .$lost_excess_book['book_id'].'/'.$lost_excess_book['url_name'].'-content.pdf') ?>"  class="bs-tooltip" title="<?php echo 'Content'?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                        </a> 
                                        </div>
                                        <div class="col-3">
                                        <a href="<?=('https://pustaka-indesign.s3.ap-south-1.amazonaws.com/' .$lost_excess_book['book_id'].'/'.$lost_excess_book['url_name'].'-content-single.pdf') ?>"  class="bs-tooltip" title="<?php echo 'Single Content'?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-minus"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="9" y1="15" x2="15" y2="15"></line></svg>
                                        </a> 
                                    </div>
                                </div>
							<?php } ?>
						</td>
						<td>
							<a href="<?php echo base_url()."paperback/paperbackledgerbooksdetails/".$lost_excess_book['book_id']; ?>" class="btn btn-outline-lilac-600 radius-8 px-14 py-6" target="_blank">View</a>
						</td>
					</tr>
				<?php } ?>
             </tbody>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>


