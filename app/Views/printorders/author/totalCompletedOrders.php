<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title row">
                <div class="col">
                </div>
                <div class="col-3">
                    <a href="authorlistdetails" class="btn btn-info mb-2 mr-2">Create New Author Orders</a>
                </div>
            </div>
        </div>
		<h6 class="text-center"><u>Author Order Dashboard</u></h6>
        <table class="table table-hover mb-4 zero-config">
                <thead>
                    <tr>
                        <th>S.NO</th>
                        <th>Order id</th>
                        <th>Author Name</th>
                        <th>No.of Title</th>
                        <th>Invoice Amount</th>
                        <th>Ship Date</th>
                        <th>Payment Status</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal;">
                    <?php $i = 1;
                    foreach ($orders['completed_all'] as $book) { ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td>
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
                            <td><?php echo $book['author_name']; ?></td>
                            <td><?php echo $book['tot_book']; ?></td>
                            <td><?php echo '₹' .$book['net_total']; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($book['ship_date'])) ?></td>
                            <td><?php echo $book['payment_status']; ?>
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
                        <th>S.No</th>
                        <th>Order id</th>
						<th>Author Name</th>
                        <th>Book id</th>
                        <th>Book Title</th>
						<th>Qty</th>
                        <th>Total Cost</th>
                        <th>Discount %</th>
                        <th>Ship Date</th>
						<th>Tracking</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal;">
                    <?php $i = 1;
                    foreach ($orders['completed_all_detail'] as $book_detail) { ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td>
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
							<td><?php echo $book_detail['author_name']; ?></td>
                            <td><?php echo $book_detail['book_id']; ?></td>
                            <td><?php echo $book_detail['book_title']; ?></td>
                            <td><?php echo $book_detail['quantity']; ?></td>
                            <td><?php echo '₹' .$book_detail['price']; ?></td>
                            <td><?php echo $book_detail['discount'] . '%'; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($book_detail['ship_date'])) ?></td>
                            <td><?php echo $book_detail['tracking_url'] . '<br>' . $book_detail['tracking_id']; ?></td>
                    <?php } ?>
                </tbody>
            </table>
    </div>
</div>
<?= $this->endSection(); ?>