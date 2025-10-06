<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h5>Amazon Paperback Dashboard</h5>
            </div>
        </div>
        <br>
        <br>
        <?php 
            $total_earnings = $amazonpaperback['total_earnings'];
            $total_dedcuctions = $total_earnings['total_tds'] + 
                                    $total_earnings['total_trans_fees'] +
                                    $total_earnings['total_shipping_fees'];

            $other_pub_earnings = $amazonpaperback['other_pub_earnings'];
            $pustaka_bks_earnings = $amazonpaperback['pustaka_bks_earnings'];
            // $other_transactions = $amazonpaperback['other_transactions'];
            $transfers = $amazonpaperback['transfers'];
            // $safe_t = $amazonpaperback['safe'];
        ?>
        <div class="row row-cols-xxxl-5 row-cols-lg-3 row-cols-sm-2 row-cols-1 gy-4">
        <div class="col">
            <div class="card shadow-none border bg-gradient-start-1 h-100">
                <div class="card-body p-20">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <p class="fw-medium text-primary-light mb-1">Total Orders</p>
                            <h6 class="mb-0"><?php echo $total_earnings['total_cnt']; ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-none border bg-gradient-start-2 h-100">
                <div class="card-body p-20">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <p class="fw-medium text-primary-light mb-1">Total MRP Sales</p>
                            <h6 class="mb-0">₹ <?php echo number_format($total_earnings['total_sales'], 2); ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-none border bg-gradient-start-3 h-100">
                <div class="card-body p-20">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <p class="fw-medium text-primary-light mb-1">Total Shipping Credits</p>
                            <h6 class="mb-0">₹ <?php echo number_format($total_earnings['total_credits'], 2); ?></h6>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-none border bg-gradient-start-4 h-100">
                <div class="card-body p-20">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <p class="fw-medium text-primary-light mb-1">Total Deductions</p>
                            <h6 class="mb-0">₹ <?php echo number_format($total_dedcuctions,2); ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-none border bg-gradient-start-5 h-100">
                <div class="card-body p-20">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <p class="fw-medium text-primary-light mb-1">Total Earnings</p>
                            <h6 class="mb-0">₹ <?php echo number_format($total_earnings['total_earnings'],2); ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <br>
        <h6>Summary </h6>
        <table class="table mb-4 contextual-table">
            <thead>
            <tr class="table-warning">
                <th style="border: 1px solid grey">Category</th>
                <th style="border: 1px solid grey">Orders</th>
                <th style="border: 1px solid grey">MRP Sales</th>
                <th style="border: 1px solid grey">Shipping Credits</th>
                <th style="border: 1px solid grey">TDS</th>
                <th style="border: 1px solid grey">Selling Fees</th>
                <th style="border: 1px solid grey">Other Transaction Fees</th>
                <th style="border: 1px solid grey">Shipping Fees</th>
                <th style="border: 1px solid grey">Royalty</th>
                <th style="border: 1px solid grey">Total Earnings</th>
            </tr>
            </thead>
            <tbody>
            <tr class="table-info">
                <td style="border: 1px solid grey">Total</td>
                <td style="border: 1px solid grey"><?php echo $total_earnings['total_cnt'];?></td>
                <td style="border: 1px solid grey">₹<?php echo number_format($total_earnings['total_sales'],2);?></td>
                <td style="border: 1px solid grey">₹<?php echo number_format($total_earnings['total_credits'],2);?></td>
                <td style="border: 1px solid grey">₹<?php echo number_format($total_earnings['total_tds'],2);?></td>
                <td style="border: 1px solid grey">₹<?php echo number_format($total_earnings['total_selling_fees'],2);?></td>
                <td style="border: 1px solid grey">₹<?php echo number_format($total_earnings['total_trans_fees'],2);?></td>
                <td style="border: 1px solid grey">₹<?php echo number_format($total_earnings['total_shipping_fees'],2);?></td>
                <td style="border: 1px solid grey">₹<?php echo number_format($total_earnings['total_royalty_value'],2);?></td>
                <td style="border: 1px solid grey">₹<?php echo number_format($total_earnings['total_earnings'],2);?></td>            
            </tr>
            </tbody>
            <tbody>
            <tr class="table-danger">
                <td style="border: 1px solid grey">Pustaka Books</td>
                <td style="border: 1px solid grey">₹<?php echo $pustaka_bks_earnings['pustaka_bks_cnt'];?></td>
                <td style="border: 1px solid grey">₹<?php echo number_format($pustaka_bks_earnings['pustaka_bks_sales'],2);?></td>
                <td style="border: 1px solid grey">₹<?php echo number_format($pustaka_bks_earnings['pustaka_bks_credits'],2);?></td>
                <td style="border: 1px solid grey">₹<?php echo number_format($pustaka_bks_earnings['pustaka_bks_tds'],2);?></td>
                <td style="border: 1px solid grey">₹<?php echo number_format($pustaka_bks_earnings['pustaka_bks_selling_fees'],2);?></td>
                <td style="border: 1px solid grey">₹<?php echo number_format($pustaka_bks_earnings['pustaka_bks_trans_fees'],2);?></td>
                <td style="border: 1px solid grey">₹<?php echo number_format($pustaka_bks_earnings['pustaka_bks_shipping_fees'],2);?></td>
                <td style="border: 1px solid grey">₹<?php echo number_format($pustaka_bks_earnings['pustaka_bks_royalty_value'],2);?></td>
                <td style="border: 1px solid grey">₹<?php echo number_format($pustaka_bks_earnings['pustaka_bks_earnings'],2);?></td>            
            </tr>
            </tbody>
            <tbody>
            <tr class="table-primary">
                <td style="border: 1px solid grey">Othor Publishers</td>
                <td style="border: 1px solid grey">₹<?php echo $other_pub_earnings['other_pub_cnt'];?></td>
                <td style="border: 1px solid grey">₹<?php echo number_format($other_pub_earnings['other_pub_sales'],2);?></td>
                <td style="border: 1px solid grey">₹<?php echo number_format($other_pub_earnings['other_pub_credits'],2);?></td>
                <td style="border: 1px solid grey">₹<?php echo number_format($other_pub_earnings['other_pub_tds'],2);?></td>
                <td style="border: 1px solid grey">₹<?php echo number_format($other_pub_earnings['other_pub_selling_fees'],2);?></td>
                <td style="border: 1px solid grey">₹<?php echo number_format($other_pub_earnings['other_pub_trans_fees'],2);?></td>
                <td style="border: 1px solid grey">₹<?php echo number_format($other_pub_earnings['other_pub_shipping_fees'],2);?></td>
                <td style="border: 1px solid grey">₹<?php echo number_format($other_pub_earnings['other_pub_royalty_value'],2);?></td>
                <td style="border: 1px solid grey">₹<?php echo number_format($other_pub_earnings['other_pub_earnings'],2);?></td>            
            </tr>
            </tbody>
        </table>
        <br>

        <h6 class="d-flex justify-content-center mt-5"> Expenditure (For Books)</h6>
        <table class="table table-hover table-light table-bordered zero-config">
            <thead class="thead-dark">
            <tr>
                <th style="border: 1px solid grey">S.NO</div></th>
                <th style="border: 1px solid grey">Month</th>
                <th style="border: 1px solid grey">TDS</th>
                <th style="border: 1px solid grey">Selling Fees</th>
                <th style="border: 1px solid grey">Other Transcation Fees</th>
                <th style="border: 1px solid grey">Shipping Fees</th>
            </tr>
            </thead>
            <!--  -->
        </table>
        <h6 class="d-flex justify-content-center mt-5"> Transfers (From Amazon)</h6>
        <table class="table table-hover table-light table-bordered zero-config">
            <thead class="thead-dark">
                <tr>
                    <th style="border: 1px solid grey">Sl. No.</th>
                    <th style="border: 1px solid grey">Month</th>
                    <th style="border: 1px solid grey">Amount Received</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                $i=1;
                foreach($transfers as $transfer) {
                ?>
                <tr>
                    <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                    <td style="border: 1px solid grey"><?php echo $transfer['month_name']; ?></td>
                    <td style="border: 1px solid grey"><?php echo number_format( $transfer['transfer_amazon'],2); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <h6 class="d-flex justify-content-center mt-5"> Expenditure (For Account)</h6>
        <table class="table table-hover table-light table-bordered zero-config">
            <thead class="thead-dark">
                <tr>
                    <th style="border: 1px solid grey">Month</th>
                    <th style="border: 1px solid grey">Service fee</th>
                    <th style="border: 1px solid grey">Transfer</th>
                    <th style="border: 1px solid grey">SAFE-T Reimbursement</th>
                    <th style="border: 1px solid grey">Cancellation</th>
                    <th style="border: 1px solid grey">Refund</th>
                </tr>
            </thead>
        </table>
        <br>
        <br> 
        <div class="row">
        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-three">
                    <br>
                    <div class="widget-heading">
                        <h6 class="text-center">Top Selling Books</h6>
                    </div>

                    <div class="widget-content">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><div class="th-content">BookId</div></th>
                                        <th><div class="th-content th-heading">Title</div></th>
                                        <th><div class="th-content th-heading">Count</div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($amazonpaperback['selling'] as $selling) { ?>
                                        <tr>
                                            <td><div class="td-content"><?php echo $selling['sku']?></div></td>
                                            <td><div class="td-content "><span><?php echo $selling['description']?></span></div></td>
                                            <td><div class="td-content text-center"><span><?php echo $selling['sales_count']?></span></div></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
                    
            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-three">
                    <br>
                    <div class="widget-heading">
                        <h6 class="text-center">Top Return Books </h6>
                    </div>
                    <div class="widget-content">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><div class="th-content">BookId</div></th>
                                        <th><div class="th-content th-heading">Title</div></th>
                                        <th><div class="th-content th-heading">count</div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($amazonpaperback['return'] as $selling) { ?>
                                        <tr>
                                            <td><div class="td-content"><?php echo $selling['sku']?></div></td>
                                            <td><div class="td-content "><span><?php echo $selling['description']?></span></div></td>
                                            <td><div class="td-content text-center"><span><?php echo $selling['return_count']?></span></div></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>