<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>
<?php
    function formatIndianCurrency($amount) {
        $amount = (int)$amount;

        $formatted = '';
        $amountStr = (string)$amount;
        $lastThree = substr($amountStr, -3);
        $restUnits = substr($amountStr, 0, -3);

        if ($restUnits != '') {
            $restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);
            $formatted = $restUnits . "," . $lastThree;
        } else {
            $formatted = $lastThree;
        }

        return '₹' . $formatted;
    }
?> 
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title row">
                <div class="col">
                </div>
                <div class="col-3">
                    <a href="offlineorderbooksdashboard" class="btn btn-info mb-2 mr-2">Create New Offline Orders</a>
                </div>
            </div>
        </div>
        <br><br>
        <div class="card basic-data-table">
            <div class="row"> 
                <!-- Orders Summary Table -->
                <div class="col-md-6">
                    <div class="card mb-4 h-100">
                        <div class="card-header border-bottom bg-base" style="padding: 0.75rem 1.5rem;">
                            <h5 class="card-title mb-0">Offline Orders Summary</h5>
                        </div>
                        <br><br>
                        <div class="card-body" style="padding: 1rem;">
                            <table class="table colored-row-table mb-0" style="width: 90%; margin: auto; font-size: 0.85rem;">
                                <thead>
                                    <tr>
                                        <th class="bg-base" style="padding: 0.5rem 0.75rem;">Status</th>
                                        <th class="bg-base" style="padding: 0.5rem 0.75rem;">Total Orders</th>
                                        <th class="bg-base" style="padding: 0.5rem 0.75rem;">Total Titles</th>
                                        <th class="bg-base" style="padding: 0.5rem 0.75rem;">Total MRP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="bg-primary-light" style="padding: 0.5rem 0.75rem;">In Progress</td>
                                        <td class="bg-primary-light" style="padding: 0.5rem 0.75rem;">
                                            <?= $offline_summary['in_progress'][0]['total_orders'] ?? 0 ?>
                                        </td>
                                        <td class="bg-primary-light" style="padding: 0.5rem 0.75rem;">
                                            <?= $offline_summary['in_progress'][0]['total_titles'] ?? 0 ?>
                                        </td>
                                        <td class="bg-primary-light" style="padding: 0.5rem 0.75rem;">
                                            <?= formatIndianCurrency($offline_summary['in_progress'][0]['total_mrp'] ?? 0) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-success-focus" style="padding: 0.5rem 0.75rem;">(last 30 days / pending)</td>
                                        <td class="bg-success-focus" style="padding: 0.5rem 0.75rem;">
                                            <?= $offline_summary['completed'][0]['total_orders'] ?? 0 ?>
                                        </td>
                                        <td class="bg-success-focus" style="padding: 0.5rem 0.75rem;">
                                            <?= $offline_summary['completed'][0]['total_titles'] ?? 0 ?>
                                        </td>
                                        <td class="bg-success-focus" style="padding: 0.5rem 0.75rem;">
                                            <?= formatIndianCurrency($offline_summary['completed'][0]['total_mrp'] ?? 0) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-success-light" style="padding: 0.5rem 0.75rem;">Completed (All)</td>
                                        <td class="bg-success-light" style="padding: 0.5rem 0.75rem;">
                                            <?= $offline_summary['completed_all'][0]['total_orders'] ?? 0 ?>
                                        </td>
                                        <td class="bg-success-light" style="padding: 0.5rem 0.75rem;">
                                            <?= $offline_summary['completed_all'][0]['total_titles'] ?? 0 ?>
                                        </td>
                                        <td class="bg-success-light" style="padding: 0.5rem 0.75rem;">
                                            <?= formatIndianCurrency($offline_summary['completed_all'][0]['total_mrp'] ?? 0) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-danger-focus" style="padding: 0.5rem 0.75rem;">Cancelled</td>
                                        <td class="bg-danger-focus" style="padding: 0.5rem 0.75rem;">
                                            <?= $offline_summary['cancel'][0]['total_orders'] ?? 0 ?>
                                        </td>
                                        <td class="bg-danger-focus" style="padding: 0.5rem 0.75rem;">
                                            <?= $offline_summary['cancel'][0]['total_titles'] ?? 0 ?>
                                        </td>
                                        <td class="bg-danger-focus" style="padding: 0.5rem 0.75rem;">
                                            <?= formatIndianCurrency($offline_summary['cancel'][0]['total_mrp'] ?? 0) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-warning-light" style="padding: 0.5rem 0.75rem;">Return</td>
                                        <td class="bg-warning-light" style="padding: 0.5rem 0.75rem;">
                                            <?= $offline_summary['return'][0]['total_orders'] ?? 0 ?>
                                        </td>
                                        <td class="bg-warning-light" style="padding: 0.5rem 0.75rem;">
                                            <?= $offline_summary['return'][0]['total_titles'] ?? 0 ?>
                                        </td>
                                        <td class="bg-warning-light" style="padding: 0.5rem 0.75rem;">
                                            <?= formatIndianCurrency($offline_summary['return'][0]['total_mrp'] ?? 0) ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Month-wise Orders Chart -->
                <div class="col-md-6">
                    <div class="card h-100 p-0">
                        <div class="card-header border-bottom bg-base" style="padding: 0.75rem 1.5rem;">
                            <h6 class="text-lg fw-semibold mb-0">Offline Orders Month-wise</h6>
                        </div>
                        <div class="card-body" style="padding: 1.5rem;">
                            <div id="offlineOrdersChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br><br>
        <h6 class="text-center"><u>Offline: In progress Orders</u></h6>
        <div class="row">
            <div class="col-8">
                <!-- Content for the first column (8 columns wide) -->
            </div>
            <div class="col">
                <input type="text" class="form-control text-dark" id="bulk_order_id" name="bulk_order_id" placeholder="Enter Order ID">
            </div>
            <div class="col-2">
                <a href="#" onclick="bulk_orders(event)" class="btn btn-primary btn-lg mb-2 mr-2">For Bulk Orders</a>
            </div>
        </div>

           <br>
            <table class="zero-config table table-hover mt-4">
                <thead>
                        <tr>
                            <th>S.NO</th>
                            <th>Order id</th>
                            <th>Book ID</th>
                            <th>Title</th>
                            <th>Copies</th>
                            <th>Author name</th>
                            <th>Ship Date</th>
                            <th>Stock In Hand</th>
                            <th>Qty Details</th>
                            <th>Stock state</th>
                            <th>Payment Details</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody style="font-weight: normal;">
                        <?php $i=1;
                            foreach ($offline_orderbooks['in_progress'] as $order_books){?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td>
                                        <a href="<?= base_url('paperback/offlineorderdetails/' . $order_books['offline_order_id']) ?>" target="_blank">
                                          <?php echo $order_books['offline_order_id']; ?>
                                        </a> <br>
                                        <?php echo '(' . $order_books['customer_name'] . ')'; ?>
                                        <br> <?php echo $order_books['city']; ?>
                                    </td>
                                    <td><a href="<?= base_url('paperback/paperbackledgerbooksdetails/' .$order_books['book_id']) ?>" target="_blank"><?php echo $order_books['book_id'] ?></a></td>
                                    <td><?php echo $order_books['book_title'] ?></td>
                                    <td><?php echo $order_books['quantity'] ?> </td>
                                    <td><?php echo $order_books['author_name'] ?></td>
                                    <td><?php echo date('d-m-Y',strtotime($order_books['ship_date']))?> </td>
                                    <td><?php echo $order_books['stock_in_hand'] ?> </td>
                                    <td>
										Ledger: <?php echo $order_books['qty'] ?><br>
										Fair / Store: <?php echo ($order_books['bookfair']+$order_books['bookfair2']+$order_books['bookfair3']+$order_books['bookfair4']+$order_books['bookfair5']) ?><br>
										<?php if ($order_books['lost_qty'] < 0) { ?>
											<span style="color:#008000;">Excess: <?php echo abs($order_books['lost_qty']) ?></span><br>
										<?php } elseif ($order_books['lost_qty'] > 0) { ?>
											<span style="color:#ff0000;">Lost: <?php echo $order_books['lost_qty'] ?><br></span>
										<?php } ?>
									</td>
                                    <?php
                                    // $stockStatus = $order_books['quantity'] <= $order_books['total_quantity'] ? 'IN STOCK' : 'OUT OF STOCK';
																		
									$stockStatus = $order_books['quantity'] <= ($order_books['stock_in_hand']+$order_books['lost_qty']) ? 'IN STOCK' : 'OUT OF STOCK';
									$recommendationStatus = "";
									
									if ($order_books['quantity'] <= ($order_books['stock_in_hand']+$order_books['lost_qty']))
									{
										$stockStatus = "IN STOCK";
										// Stock is available; check whether it is from lost qty
										if ($order_books['quantity'] <= $order_books['stock_in_hand']) {
											$stockStatus = "IN STOCK";
											$recommendationStatus ="";
										} else {
											$stockStatus = "IN STOCK";
											$recommendationStatus = "Print using </span><span style='color:#ff0000;'>LOST</span><span style='color:#0000ff;'> Qty! No Initiate to Print";
										}
									} else {
										$stockStatus = "OUT OF STOCK";
										// Stock not available; Check whether it is from excess qty
										if ($order_books['quantity'] <= $order_books['stock_in_hand']) {
											$stockStatus = "OUT OF STOCK";
											$recommendationStatus = "Print using </span><span style='color:#008000;'>EXCESS</span><span style='color:#0000ff;'> Qty! Initiate Print Also";
										} else {
											$stockStatus = "OUT OF STOCK";
											$recommendationStatus ="";
										}
									}
									
                                    ?>
                                    <td>
										<?php echo $stockStatus ?>
										<br><span style="color:#0000ff;">
										<?php 
											if (($stockStatus == 'OUT OF STOCK') && ($recommendationStatus == '')) {
												// Nothing to be displayed 
											} else {
												echo $recommendationStatus;
											} 
										?></span>
									</td>
                                    <td> <?php echo $order_books['payment_type'].'-'.$order_books['payment_status'] ?></td>
                                    <td>
                                        <?php if (($stockStatus == 'OUT OF STOCK') && ($recommendationStatus == '')) { ?>
                                            <a href="<?php echo base_url() . "paperback/paperbackprintstatus" ?>" 
                                            class="btn btn-default" target="_blank" 
                                            style="background-color: purple; color: white; padding: 4px 10px; font-size: 12px;">
                                            Status
                                            </a>
                                            <br><br>
                                            <a href="<?php echo base_url() . "paperback/initiateprintdashboard/" . $order_books['book_id'] ?>" 
                                            class="btn btn-warning" target="_blank" 
                                            style="padding: 4px 10px; font-size: 12px;">
                                            Print
                                            </a>
                                        <?php } else { ?>
                                            <a href="<?= base_url('paperback/offlineordership/' . $order_books['offline_order_id'] . '/' . $order_books['book_id']); ?>" 
                                            class="btn btn-success mb-2 mr-2" target="_blank" 
                                            style="padding: 4px 10px; font-size: 12px;">
                                            Ship
                                            </a>
                                            <br><br>
                                            <a href="" onclick="mark_cancel('<?php echo $order_books['offline_order_id'] ?>','<?php echo $order_books['book_id'] ?>')" 
                                            class="btn btn-danger mb-2 mr-2" 
                                            style="padding: 4px 10px; font-size: 12px;">
                                            Cancel
                                            </a>
                                        <?php } ?>
                                    </td>

                                </tr>
                        <?php }?>
                    </tbody>
                </table>
                <br>
               <br>
               <br>
               <center><h6 class="text-center"><u>Offline: Completed Orders & Pending Payment</u>
               <a href="<?php echo base_url(); ?>paperback/totalofflineordercompleted" class="bs-tooltip " title="<?php echo 'View all Completed Books'?>"target=_blank>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="blue" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                        <polyline points="15 3 21 3 21 9"></polyline>
                        <line x1="10" y1="14" x2="21" y2="3"></line>
                    </svg>
                </a></h6>
                <h6 class="text-center">( Shows for 30 days from date of shipment )</h6></center>
                <table class="zero-config table table-hover mt-4">
                    <thead>
                        <tr>
                            <th>S.NO</th>
                            <th>Order id</th>
                            <th>Order Date</th>
                            <th>Book ID</th>
                            <th>Title</th>
                            <th>Author name</th>
                            <th>Shipped Date</th>
                            <th>Payment Details</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody style="font-weight: normal;">
                        <?php $i=1;
                            foreach ($offline_orderbooks['completed'] as $order_books){?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td>
                                        <a href="<?= base_url('paperback/offlineorderdetails/' . $order_books['offline_order_id']) ?>" target="_blank">
                                          <?php echo $order_books['offline_order_id']; ?>
                                        </a>
                                        <br>
                                        <?php echo '(' . $order_books['customer_name'] . ')'; ?> 
                                        <?php echo $order_books['city']; ?>
                                        <br><br>
                                        <a href="<?php echo $order_books['url']; ?>" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck">
                                                <rect x="1" y="3" width="15" height="13"></rect>
                                                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                            </svg>
                                        </a>
                                </td>
                                <td> 
                                <?php
                                if ($order_books['order_date']== NULL) {
                                    echo '';
                                } else {
                                    echo date('d-m-Y', strtotime($order_books['order_date'])); 
                                }?></td>
                                <td><a href="<?= base_url('paperback/paperbackledgerbooksdetails/' .$order_books['book_id']) ?>" target="_blank"><?php echo $order_books['book_id'] ?></a></td>
                                <td><?php echo $order_books['book_title'] ?></td>
                                <td><?php echo $order_books['author_name'] ?></td>
                                <td><?php echo date('d-m-Y',strtotime($order_books['shipped_date']))?> </td>
                                <td>
                                    <?= $order_books['payment_type'] . ' - ' . $order_books['payment_status'] ?>
                                    <?php 
                                        $payment_status = strtolower(trim($order_books['payment_status'] ?? '')); 
                                    ?>
                                    <br>
                                    <?php if ($payment_status === 'pending') { ?>
                                        <a href="#" 
                                        onclick="mark_pay('<?= $order_books['offline_order_id'] ?>')" 
                                        class="btn btn-info-600 radius-8 px-14 py-6 text-sm">
                                        Mark Paid
                                        </a>
                                    <?php } ?>
                                </td>
                                <td style="text-align: center;">
                                 <a href="" onclick="mark_return('<?php echo $order_books['offline_order_id'] ?>','<?php echo $order_books['book_id'] ?>')" class="btn btn-primary mb-2 mr-2">Return</a>
                                </td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
                <br>
                <br>
                <h6 class="text-center"><u>Offline: Cancel Orders</u></h6>
                <table class="zero-config table table-hover mt-4">
                <thead>
                            <tr>
                            <th>S.NO</th>
                            <th>Order id</th>
                            <th>Order Date</th>
                            <th>Book ID</th>
                            <th>title</th>
                            <th>Author name</th>
                            <th>Cancel Date</th>
                            </tr>
                       </thead>
                      <tbody style="font-weight: normal;">
                       <?php $i=1;
                        foreach ($offline_orderbooks['cancel'] as $order_books){?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td>
                                        <a href="<?= base_url('paperback/offlineorderdetails/' . $order_books['offline_order_id']) ?>" target="_blank">
                                          <?php echo $order_books['offline_order_id']; ?>
                                        </a> <br>
                                        <?php echo '(' . $order_books['customer_name'] . ')'; ?> 
                                        <?php echo $order_books['city']; ?>   
                                </td>
                                <td> <?php
                                if ($order_books['order_date']== NULL) {
                                    echo '';
                                } else {
                                    echo date('d-m-Y', strtotime($order_books['order_date'])); 
                                }?></td>
                                <td><a href="<?= base_url('paperback/paperbackledgerbooksdetails/' .$order_books['book_id']) ?>" target="_blank"><?php echo $order_books['book_id'] ?></a></td>
                                <td><?php echo $order_books['book_title'] ?></td>
                                <td><?php echo $order_books['author_name'] ?></td> 
                                <td> <?php
                                if ($order_books['date']== NULL) {
                                    echo '';
                                } else {
                                    echo date('d-m-Y', strtotime($order_books['date'])); 
                                }?></td>
                            </tr>
                    <?php }?>
                    </tbody>
                </table>
                <br>
                <h6 class="text-center"><u>Offline: Return Orders</u></h6>
                <table class="zero-config table table-hover mt-4">
                    <thead>
                        <tr>
                        <th>S.NO</th>
                        <th>Order id</th>
                        <th>Order Date</th>
                        <th>Book ID</th>
                        <th>title</th>
                        <th>Author name</th>
                        <th>Return Date</th>
                        </tr>
                    </thead>
                    <tbody style="font-weight: normal;">
                        <?php $i=1;
                            foreach ($offline_orderbooks['return'] as $order_books){?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td>
                                            <a href="<?= base_url('paperback/offlineorderdetails/' . $order_books['offline_order_id']) ?>" target="_blank">
                                                <?php echo $order_books['offline_order_id']; ?>
                                            </a> <br>
                                            <?php echo '(' . $order_books['customer_name'] . ')'; ?> 
                                            <?php echo $order_books['city']; ?>   
                                    </td>
                                    <td> <?php
                                    if ($order_books['order_date']== NULL) {
                                        echo '';
                                    } else {
                                        echo date('d-m-Y', strtotime($order_books['order_date'])); 
                                    }?></td>
                                    <td><a href="<?= base_url('paperback/paperbackledgerbooksdetails/' .$order_books['book_id']) ?>" target="_blank"><?php echo $order_books['book_id'] ?></a></td>
                                    <td><?php echo $order_books['book_title'] ?></td>
                                    <td><?php echo $order_books['author_name'] ?></td> 
                                    <td> <?php
                                    if ($order_books['date']== NULL) {
                                        echo '';
                                    } else {
                                        echo date('d-m-Y', strtotime($order_books['date'])); 
                                    }?></td>
                                </tr>
                        <?php }?>
                    </tbody>
                </table>
     <div> 
</div>
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const chartData = <?= json_encode($offline_summary['chart']); ?>;
    const months = chartData.map(item => item.order_month);
    const totalTitles = chartData.map(item => parseInt(item.total_titles));
    const totalMrp = chartData.map(item => parseFloat(item.total_mrp));

    var options = {
        chart: { type: 'bar', height: 400, stacked: false, toolbar: { show: false } },
        series: [
            { name: "Total Titles", type: 'column', data: totalTitles },
            { name: "Total MRP", type: 'column', data: totalMrp }
        ],
        plotOptions: { bar: { horizontal: false, columnWidth: '40%', endingShape: 'rounded' } },
        xaxis: { categories: months, title: { text: 'Order Month' } },
        yaxis: [
            {
                title: { text: "Total Titles" },
                min: 0,
                forceNiceScale: true,
                axisTicks: { show: true },
                axisBorder: { show: true },
                labels: { formatter: val => val.toLocaleString() }
            },
            {
                opposite: false,
                title: { text: "Total MRP (₹)" },
                min: 0,
                forceNiceScale: false,
                axisTicks: { show: false },
                axisBorder: { show: false },
                labels: { formatter: val => "₹" + val.toLocaleString() }
            }
        ],
        dataLabels: { enabled: false },
        colors: ['#5511e7ff', '#ef19ddff'],
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function(val, opts){
                    return opts.seriesIndex===1 ? "₹" + val.toLocaleString() : val.toLocaleString();
                }
            }
        },
        legend: { position: 'top', horizontalAlign: 'center' }
    };

    var chart = new ApexCharts(document.querySelector("#offlineOrdersChart"), options);
    chart.render();
});

const csrfName = '<?= csrf_token() ?>';
const csrfHash = '<?= csrf_hash() ?>';
var base_url = "<?= base_url(); ?>";

function mark_cancel(offline_order_id, book_id){
    $.ajax({
        url: base_url + 'paperback/offlinemarkcancel',
        type: 'POST',
        data: { offline_order_id, book_id, [csrfName]: csrfHash },
        success: function(data){ data==1 ? alert("Shipping Cancel!!") : alert("Unknown error!!"); location.reload(); },
        error: function(xhr,status,error){ console.error("AJAX Error:", status,error); }
    });
}

function mark_pay(offline_order_id){
    $.ajax({
        url: base_url + 'paperback/offlinemarkpay',
        type: 'POST',
        data: { offline_order_id, [csrfName]: csrfHash },
        success: function(data){ data==1 ? alert("Payment Received!") : alert("Unknown error!!"); location.reload(); },
        error: function(xhr,status,error){ console.error("AJAX Error:", status,error); }
    });
}

function mark_return(offline_order_id, book_id){
    $.ajax({
        url: base_url + 'paperback/offlinemarkreturn',
        type: 'POST',
        data: { offline_order_id, book_id, [csrfName]: csrfHash },
        success: function(data){ data==1 ? alert("Restore Successfully!!") : alert("Unknown error!!"); location.reload(); },
        error: function(xhr,status,error){ console.error("AJAX Error:", status,error); }
    });
}

function bulk_orders(event){
    event.preventDefault();
    var bulkOrderId = document.getElementById('bulk_order_id').value;
    if(bulkOrderId){ window.location.href = base_url+'paperback/offlinebulkordersship/'+encodeURIComponent(bulkOrderId); }
    else alert("Please enter a Bulk Order ID.");
}
</script>
<?= $this->endSection(); ?>