<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title row">
                <div class="col">
                <h6 class="text-center">Author Order - Completed</h6>
                </div>
                <div class="col-3">
                    <a href="authorlistdetails" class="btn btn-info mb-2 mr-2">Create New Author Orders</a>
                </div>
            </div>
        </div>
		<h6 class="text-center"><u>Order Details</u></h6>
        <table class="table table-hover mb-4 zero-config">
                <thead class="thead-dark">
                    <tr>
                        <th style="border: 1px solid grey">S.NO</th>
                        <th style="border: 1px solid grey">Order id</th>
                        <th style="border: 1px solid grey">Author Name</th>
                        <th style="border: 1px solid grey">No.of Title</th>
                        <th style="border: 1px solid grey">Invoice Amount</th>
                        <th style="border: 1px solid grey">Ship Date</th>
                        <th style="border: 1px solid grey">Payment Status</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal;">
                    <?php $i = 1;
                    foreach ($orders['completed_all'] as $book) { ?>
                        <tr>
                            <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                            <td style="border: 1px solid grey">
                            <a href="<?= base_url('paperback/authororderdetails/' . $book['order_id']) ?>" target="_blank">
                                <?php echo $book['order_id']; ?>
                            </a>
                            <br>
                            <a href="<?php echo $book['tracking_url']; ?>" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck">
                                    <rect x="1" y="3" width="15" height="13"></rect>
                                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                </svg>
                            </a>
                              
                            </td>
                            <td style="border: 1px solid grey"><?php echo $book['author_name']; ?></td>
                            <td style="border: 1px solid grey"><?php echo $book['tot_book']; ?></td>
                            <td style="border: 1px solid grey"><?php echo '₹' .$book['net_total']; ?></td>
                            <td style="border: 1px solid grey"><?php echo date('d-m-Y', strtotime($book['ship_date'])) ?></td>
                            <td style="border: 1px solid grey"><?php echo $book['payment_status']; ?>
                            <?php $payment_status=$book['payment_status'];?>
                            <?php if ($payment_status =='Pending') { ?>
                                    <a href="" onclick="mark_pay('<?php echo $book['order_id'] ?>')" class="btn-sm btn-primary mb-2 mr-2">Mark Paid</a>
                                <?php } ?>
                            </td>
                    <?php } ?>
                </tbody>
            </table>
			<br><br>
			<h6 class="text-center"><u>Book Details</u></h6>
			<table class="table table-hover mb-8 zero-config">
                <thead>
                    <tr>
                        <th style="border: 1px solid grey">S.No</th>
                        <th style="border: 1px solid grey">Order id</th>
						<th style="border: 1px solid grey;width:20">Author Name</th>
                        <th style="border: 1px solid grey">Book id</th>
                        <th style="border: 1px solid grey;width:20">Book Title</th>
						<th style="border: 1px solid grey">Qty</th>
                        <th style="border: 1px solid grey">Total Cost</th>
                        <th style="border: 1px solid grey">Discount %</th>
                        <th style="border: 1px solid grey">Ship Date</th>
						<th style="border: 1px solid grey;width:30">Tracking</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal;">
                    <?php $i = 1;
                    foreach ($orders['completed_all_detail'] as $book_detail) { ?>
                        <tr>
                            <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                            <td style="border: 1px solid grey">
								<a href="<?= base_url('paperback/authororderdetails/' . $book_detail['order_id']) ?>" target="_blank">
									<?php echo $book_detail['order_id']; ?>
								</a>
								<br>
								<a href="<?php echo $book_detail['tracking_url']; ?>" target="_blank">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck">
										<rect x="1" y="3" width="15" height="13"></rect>
										<polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
										<circle cx="5.5" cy="18.5" r="2.5"></circle>
										<circle cx="18.5" cy="18.5" r="2.5"></circle>
									</svg>
								</a>
                            </td>
							<td style="border: 1px solid grey;width:20"><?php echo $book_detail['author_name']; ?></td>
                            <td style="border: 1px solid grey;width:20"><?php echo $book_detail['book_id']; ?></td>
                            <td style="border: 1px solid grey;width:20"><?php echo $book_detail['book_title']; ?></td>
                            <td style="border: 1px solid grey"><?php echo $book_detail['quantity']; ?></td>
                            <td style="border: 1px solid grey"><?php echo '₹' .$book_detail['price']; ?></td>
                            <td style="border: 1px solid grey"><?php echo $book_detail['discount'] . '%'; ?></td>
                            <td style="border: 1px solid grey"><?php echo date('d-m-Y', strtotime($book_detail['ship_date'])) ?></td>
                            <td style="border: 1px solid grey;width:20"><?php echo $book_detail['tracking_url'] . '<br>' . $book_detail['tracking_id']; ?></td>
                    <?php } ?>
                </tbody>
            </table>
    </div>
</div>
<?= $this->endSection(); ?>