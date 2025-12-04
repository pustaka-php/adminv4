<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<?php 
$Book_id = $book_id;
$totalStockIn = 0;
$totalStockOut = 0;
$totalStock = 0; 
foreach ($details['list'] as $books_details) {
    $totalStockIn += $books_details['stock_in'];
    $totalStockOut += $books_details['stock_out'];
    $totalStock += $books_details['stock_in'] - $books_details['stock_out'];
}
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="card-deck">

            <!-- Book Details Card -->
            <div class="card h-100 radius-12 bg-gradient-primary text-center">
                <div class="card-body p-24">
                    <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-primary-600 text-white mb-16 radius-12">
                        <iconify-icon icon="ri:book-fill" class="h5 mb-0"></iconify-icon>
                    </div>
                    <h6 class="mb-8">Book Details</h6>
                    <table class="table">
                        <tr><td><strong>Book Id</strong></td><td>: <?= $Book_id ?></td></tr>
                        <tr><td><strong>Book Title</strong></td><td>: <?= $details['books']['book_title'] ?></td></tr>
                        <tr><td><strong>Regional Title</strong></td><td>: <?= $details['books']['regional_book_title'] ?></td></tr>
                        <tr><td><strong>Book Price</strong></td><td>: <?= $details['books']['paper_back_inr'] ?></td></tr>
                        <tr><td><strong>Author Id</strong></td><td>: <?= $details['books']['author_id'] ?></td></tr>
                        <tr><td><strong>Author Name</strong></td><td>: <?= $details['books']['author_name'] ?></td></tr>
                        <tr><td><strong>Copyright Owner</strong></td><td>: <?= $details['books']['paper_back_copyright_owner'] ?></td></tr>
                    </table>
                </div>
            </div>

            <!-- Stock Details Card -->
            <div class="card h-100 radius-12 bg-gradient-primary text-center">
                <div class="card-body p-24">
                    <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-primary-600 text-white mb-16 radius-12">
                        <iconify-icon icon="ri:stock-fill" class="h5 mb-0"></iconify-icon>
                    </div>
                    <h6 class="mb-8">Stock Details</h6>
                    <p class="card-text mb-8 text-secondary-light">(From paperback_stock Table)</p>
                    <table class="table">
                        <tr>
                            <?php if ($details['books']['quantity'] == $details['books']['bookfair'] + $details['books']['stock_in_hand']) { ?>
                                <td><strong>Total Quantity:</strong></td>
                                <td><b style="color: green;"><?= $details['books']['quantity']; ?></b></td>
                            <?php } else { ?>
                                <td><strong>Total Quantity:</strong></td>
                                <td><?= $details['books']['quantity']; ?></td>
                            <?php } ?>
                        </tr>
                        <tr><td><strong>Book Fair / Store:</strong></td><td><?= $details['books']['bookfair']+$details['books']['bookfair2']+$details['books']['bookfair3']+$details['books']['bookfair4']+$details['books']['bookfair5'] ?></td></tr>
                        <tr><td><strong>Lost Qty:</strong></td><td><?= $details['books']['lost_qty'] ?></td></tr>
                        <tr><td><strong>Excess Qty:</strong></td><td><?= $details['books']['excess_qty'] ?></td></tr>
                        <tr><td><strong>Current Stock:</strong></td><td><?= $details['books']['stock_in_hand'] ?></td></tr>
                        <tr><td colspan="2" class="text-center text-primary">(From pustaka_paperback_stock_ledger Table)</td></tr>
                        <tr><td><strong>Total Stock In:</strong></td><td><?= $totalStockIn ?></td></tr>
                        <tr><td><strong>Total Stock Out:</strong></td><td><?= $totalStockOut ?></td></tr>
                        <tr><td><strong>Available Stock:</strong></td><td><?= $totalStock ?></td></tr>
                    </table>
                    <?php
                        if ($details['books']['quantity'] == $totalStock) {
                            echo '<div class="alert alert-success"><strong>Matched!</strong> Total Quantity is equal to Available Stock.</div>';
                        } else if ($details['books']['quantity'] > $totalStock) {
                            echo '<div class="alert alert-danger"><strong>Mismatch!</strong> Total Quantity is greater than Available Stock.</div>';
                        } else {
                            echo '<div class="alert alert-danger"><strong>Mismatch!</strong> Total Quantity is less than Available Stock.</div>';
                        }
                    ?>
                </div>
            </div>
        </div>

        <br>

        <!-- Book Fair / Store Distribution -->
        <div class="card h-100 radius-12 bg-gradient-primary text-center mb-3">
            <div class="card-body p-24">
                <h6 class="mb-8">Book Fair / Store Distribution</h6>
                <table class="table">
                    <tr>
                        <th>Book Fair</th><th>Book Fair 2</th><th>Book Fair 3</th><th>Book Fair 4</th><th>Book Fair 5</th>
                    </tr>
                    <tr>
                        <td><?= $details['books']['bookfair'] ?></td>
                        <td><?= $details['books']['bookfair2'] ?></td>
                        <td><?= $details['books']['bookfair3'] ?></td>
                        <td><?= $details['books']['bookfair4'] ?></td>
                        <td><?= $details['books']['bookfair5'] ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Book Stock Ledger -->
        <div class="card h-100 radius-12 bg-gradient-primary text-center mb-3">
            <div class="card-body p-24">
                <h6 class="mb-8">Book Stock Ledger</h6>
                <table class="table table-bordered mb-4 zero-config">
                    <thead>
                        <tr>
                            <th>S.No</th><th>Order ID</th><th>Copyright Owner</th>
                            <th>Channel Type</th><th>Description</th>
                            <th>Stock In</th><th>Stock Out</th><th>Transaction Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = 1;
                            foreach ($details['list'] as $books_details) {
                                $totalStockIn += $books_details['stock_in'];
                                $totalStockOut += $books_details['stock_out'];
                        ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $books_details['order_id'] ?></td>
                                <td><?= $books_details['copyright_owner'] ?></td>
                                <td><?= $books_details['channel_type'] ?></td>
                                <td><?= $books_details['description'] ?></td>
                                <td><?= $books_details['stock_in'] ?></td>
                                <td><?= $books_details['stock_out'] ?></td>
                                <td><?= date('d-m-Y', strtotime($books_details['transaction_date'])) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Author Transaction -->
        <div class="card h-100 radius-12 bg-gradient-primary text-center mb-3">
            <div class="card-body p-24">
                <h6 class="mb-8">Author Transaction</h6>
                <table class="table table-bordered mb-4 zero-config">
                    <thead>
                        <tr>
                            <th>S.No</th><th>Order Date</th><th>Royalty Value</th><th>Comments</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($details['author'] as $books_details) { ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= date('d-m-Y', strtotime($books_details['order_date'])) ?></td>
                                <td><?= $books_details['book_final_royalty_value_inr'] ?></td>
                                <td><?= $books_details['comments'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Author Transaction (Before Sep 30) -->
        <div class="card h-100 radius-12 bg-gradient-primary text-center mb-3">
            <div class="card-body p-24">
                <h6 class="mb-8">Author Transaction (Before Sep 30)</h6>
                <table class="table table-bordered mb-4 zero-config">
                    <thead>
                        <tr>
                            <th>S.No</th><th>Order Date</th><th>Channel</th><th>Royalty Value</th><th>Comments</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($details['old_details'] as $books_details) { ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= date('d-m-Y', strtotime($books_details['order_date'])) ?></td>
                                <td><?= $books_details['channel'] ?></td>
                                <td><?= $books_details['book_final_royalty_value_inr'] ?></td>
                                <td><?= $books_details['comments'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Book Fair Details -->
        <div class="card h-100 radius-12 bg-gradient-primary text-center mb-3">
            <div class="card-body p-24">
                <h6 class="mb-8">Book Fair Details</h6>
                <table class="table table-bordered mb-4 zero-config">
                    <thead>
                        <tr>
                            <th>S.No</th><th>Order Date</th><th>Price</th><th>Quantity</th><th>Royalty Value</th><th>Comments</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($details['book_fair'] as $books_details) { ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= date('d-m-Y', strtotime($books_details['order_date'])) ?></td>
                                <td><?= $books_details['price'] ?></td>
                                <td><?= $books_details['quantity'] ?></td>
                                <td><?= $books_details['final_royalty_value'] ?></td>
                                <td><?= $books_details['comments'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection(); ?>
