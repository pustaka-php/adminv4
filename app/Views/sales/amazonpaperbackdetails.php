
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Amazon Paperback Dashboard</h3>
            </div>
        </div>
        <br>
        <br>
        <?php 
            $total_earnings = $amazon_paperback_order['total_earnings'];
            $total_dedcuctions = $total_earnings['total_tds'] + 
                                    $total_earnings['total_trans_fees'] +
                                    $total_earnings['total_shipping_fees'];

            $other_pub_earnings = $amazon_paperback_order['other_pub_earnings'];
            $pustaka_bks_earnings = $amazon_paperback_order['pustaka_bks_earnings'];
            $other_transactions = $amazon_paperback_order['other_transactions'];
            $transfers = $amazon_paperback_order['transfers'];
            $safe_t = $amazon_paperback_order['safe'];
        ?>
        <div class="card-deck">
            <div class="card"style="background-color:powderblue;">
                    <div class="card-body">
                        <h4 class="card-title">Total Orders</h4>
                        <p class="card-text" style="font-size: 30px;"><?php echo $total_earnings['total_cnt']; ?></p>
                    </div>
                </div>
            <div class="card"style="background-color:powderblue;">
                <div class="card-body">
                    <h4 class="card-title">Total MRP Sales</h4>
                    <p class="card-text" style="font-size: 30px;"> ₹ <?php echo number_format($total_earnings['total_sales'], 2); ?></p>
                </div>
             </div>
             <div class="card">
                <div class="card-body"style="background-color:powderblue;">
                    <h4 class="card-title">Total Shipping Credits</h4>
                    <p class="card-text" style="font-size: 30px;"> ₹ <?php echo number_format($total_earnings['total_credits'], 2); ?></p>
                </div>
            </div>
            <div class="card">
                <div class="card-body"style="background-color:powderblue;">
                    <h4 class="card-title">Total Deductions</h4>
                    <p class="card-text" style="font-size: 30px;"> ₹ <?php echo number_format($total_dedcuctions,2); ?></p>
                </div>
            </div>
            <div class="card">
                <div class="card-body"style="background-color:powderblue;">
                    <h4 class="card-title">Total Earnings</h4>
                    <p class="card-text" style="font-size: 30px;"> ₹ <?php echo number_format($total_earnings['total_earnings'],2); ?></p>
                </div>
            </div>
        </div>
        <br>
        <h4>Summary </h4>
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
            <tbody style="font-weight: 800;">
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
            <tbody style="font-weight: 800;">
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
            <tbody style="font-weight: 800;">
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

        <h4 class="d-flex justify-content-center mt-5"> Expenditure (For Books)</h4>
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
            <tbody style="font-weight: 800;">
                <?php 
                    $i=1;
                    foreach($other_transactions as $other_transaction) {
                    ?>
                    <tr>
                        <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                        <td style="border: 1px solid grey"><?php echo $other_transaction['month_name']; ?></td>
                        <td style="border: 1px solid grey"> ₹ <?php echo number_format($other_transaction['tds'],2); ?></td>
                        <td style="border: 1px solid grey"> ₹ <?php echo number_format($other_transaction['selling_fees'],2); ?></td>
                        <td style="border: 1px solid grey"> ₹ <?php echo number_format($other_transaction['other_transaction_fees'],2); ?></td>
                        <td style="border: 1px solid grey"> ₹ <?php echo number_format($other_transaction['shipping_fees'],2); ?></td>
                
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <h4 class="d-flex justify-content-center mt-5"> Transfers (From Amazon)</h4>
        <table class="table table-hover table-light table-bordered zero-config">
            <thead class="thead-dark">
                <tr>
                    <th style="border: 1px solid grey">Sl. No.</th>
                    <th style="border: 1px solid grey">Month</th>
                    <th style="border: 1px solid grey">Amount Received</th>
                </tr>
            </thead>
            <tbody style="font-weight: 800;">
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
        
        <h4 class="d-flex justify-content-center mt-5"> Expenditure (For Account)</h4>
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
                        <h5 class="text-center">Top Selling Books</h5>
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
                                    <?php foreach($amazon_paperback_order['selling'] as $selling) { ?>
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
                        <h5 class="text-center">Top Return Books </h5>
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
                                <?php foreach($amazon_paperback_order['return'] as $selling) { ?>
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