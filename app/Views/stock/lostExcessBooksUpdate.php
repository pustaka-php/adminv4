<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
             <div class="page-title row">
                <div class="col">
                <h3>Lost / Excess Books Status Dashboard</h3>
                </div>
            </div>
        <br>
        <table class="table zero-config">
            <thead>
				<tr> 
					<th style="border: 1px solid grey; width: 5%">S.No</th>
					<th style="border: 1px solid grey; width: 5%">Book Id</th>
					<th style="border: 1px solid grey">Title</th>
					<th style="border: 1px solid grey">Author Name</th>
					<th style="border: 1px solid grey">Stock In Hand</th>
					<th style="border: 1px solid grey">Qty Details</th>
					<th style="border: 1px solid grey">Action</th>
					<th style="border: 1px solid grey">Download</th>
					<th style="border: 1px solid grey">Ledger</th>
				</tr>
            </thead>
            <tbody style="font-weight: 800;">
                <?php $i=1;
                  foreach($lost_excess['in_progress'] as $lost_excess_book ) { 
				?>
					<tr>
						<td style="border: 1px solid grey"><?php echo $i++; ?></td>
						<td style="border: 1px solid grey"><?php echo $lost_excess_book['book_id']; ?></td>
						<td style="border: 1px solid grey"><?php echo $lost_excess_book['book_title']; ?></td>
						<td style="border: 1px solid grey"><?php echo $lost_excess_book['author_name']; ?></td>
						<td style="border: 1px solid grey" ><input type="hidden" id="stock_in_hand" value="<?php echo $lost_excess_book['stock_in_hand']; ?>"><?php echo $lost_excess_book['stock_in_hand']; ?></td>
						<td style="border: 1px solid grey">
							Ledger: <?php echo $lost_excess_book['qty'] ?><br>
							Fair / Store: <?php echo ($lost_excess_book['bookfair']+$lost_excess_book['bookfair2']+$lost_excess_book['bookfair3']+$lost_excess_book['bookfair4']+$lost_excess_book['bookfair5']) ?><br>
							<?php if ($lost_excess_book['lost_qty'] < 0) { ?>
								<span style="color:#008000;">Excess: <?php echo abs($lost_excess_book['lost_qty']) ?></span><br>
							<?php } elseif ($lost_excess_book['lost_qty'] > 0) { ?>
								<span style="color:#ff0000;">Lost: <?php echo $lost_excess_book['lost_qty'] ?><br></span>
							<?php } ?>
						</td>
						<td style="border: 1px solid grey">
							<a href="<?php echo base_url()."pustaka_paperback/print_excess_lost_one/" . $lost_excess_book['book_id'] ?>" class="btn-sm btn-success mb-2 mr-2">Print One</a><br><br><a href="<?php echo base_url()."pustaka_paperback/print_excess_lost_all/" . $lost_excess_book['book_id'] ?>" class="btn-sm btn-warning mb-2 mr-2">Print All</a>
						</td>
						<td style="border: 1px solid grey">
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
						<td style="border: 1px solid grey">
							<a href="<?php echo base_url()."pustaka_paperback/paperback_ledger_books_details/".$lost_excess_book['book_id']; ?>" class="btn btn-info mb-1 mr-1" target="_blank">View</a>
						</td>
					</tr>
				<?php } ?>
             </tbody>
        </table>

    </div>
</div>


