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
<div class="card basic-data-table">
    <div class="row"> 
        <!-- Orders Summary Table -->
        <div class="col-md-6">
            <div class="card mb-4 h-100">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h5 class="card-title mb-0">Online Orders Summary</h5>
                </div>
                <br><br>
                <div class="card-body">
                    <table class="table colored-row-table mb-0">
                        <thead>
                            <tr>
                                <th class="bg-base">Status</th>
                                <th class="bg-base">Total Orders</th>
                                <th class="bg-base">Total Titles</th>
                                <th class="bg-base">Total MRP</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="bg-primary-light">In Progress</td>
                                <td class="bg-primary-light">
                                    <?= $online_summary['in_progress'][0]['total_orders'] ?? 0 ?>
                                </td>
                                <td class="bg-primary-light">
                                    <?= $online_summary['in_progress'][0]['total_titles'] ?? 0 ?>
                                </td>
                                <td class="bg-primary-light">
                                    <?= formatIndianCurrency($online_summary['in_progress'][0]['total_mrp'] ?? 0) ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-success-focus">Completed</td>
                                <td class="bg-success-focus">
                                    <?= $online_summary['completed'][0]['total_orders'] ?? 0 ?>
                                </td>
                                <td class="bg-success-focus">
                                    <?= $online_summary['completed'][0]['total_titles'] ?? 0 ?>
                                </td>
                                <td class="bg-success-focus">
                                    <?= formatIndianCurrency($online_summary['completed'][0]['total_mrp'] ?? 0) ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-danger-focus">Cancelled</td>
                                <td class="bg-danger-focus">
                                    <?= $online_summary['cancelled'][0]['total_orders'] ?? 0 ?>
                                </td>
                                <td class="bg-danger-focus">
                                    <?= $online_summary['cancelled'][0]['total_titles'] ?? 0 ?>
                                </td>
                                <td class="bg-danger-focus">
                                    <?= formatIndianCurrency($online_summary['cancelled'][0]['total_mrp'] ?? 0) ?>
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
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="text-lg fw-semibold mb-0">Online Orders Month-wise</h6>
                </div>
                <div class="card-body p-24">
                    <div id="onlineOrdersChart"></div>
                </div>
            </div>
        </div>
    </div>
    <br><br><br><br>
    <div class="card-body">
        <div class="table-responsive">

            <!-- In Progress Orders Table -->
            <h6 class="text-center"><u>Online: In progress Orders</u></h6>
            <div class="row mb-3">
                <div class="col-8"></div>
                <div class="col">
                    <input type="text" class="form-control text-dark" id="bulk_order_id" name="bulk_order_id" placeholder="Enter Order ID">
                </div>
                <div class="col-2">
                    <a href="#" onclick="bulk_orders(event)" class="btn btn-primary btn-lg mb-2 mr-2">For Bulk Orders</a>
                </div>
            </div>
            <table class="zero-config table table-hover mt-4">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">S.No</th>
                        <th style="width: 100px; text-align: center;">Order ID</th>
                        <th style="width: 80px; text-align: center;">Book ID</th>
                        <th style="width: 15%;">Title</th>
                        <th style="width: 60px; text-align: center;">Copies</th>
                        <th style="width: 15%;">Author</th>
                        <th style="width: 100px; text-align: center;">Order Date</th>
                        <th style="width: 100px; text-align: center;">Stock In Hand</th>
                        <th style="width: 15%;">Qty Details</th>
                        <th style="width: 120px; text-align: center;">Stock State</th>
                        <th style="width: 120px; text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal;">
                    <?php $i=1;
                        foreach ($online_orderbooks['in_progress'] as $order_books){?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('paperback/onlineorderdetails/' . $order_books['online_order_id']) ?>" target="_blank">
                                        <?= $order_books['online_order_id']; ?>
                                    </a>
                                    <br>
                                    (<?= $order_books['username']; ?>)<br>
                                    <?= $order_books['city']; ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('paperback/paperbackledgerbooksdetails/' .$order_books['book_id']) ?>" target="_blank">
                                        <?= $order_books['book_id'] ?>
                                    </a>
                                </td>
                                <td><?= $order_books['book_title'] ?></td>
                                <td class="text-center"><?= $order_books['quantity'] ?> </td>
                                <td><?= $order_books['author_name'] ?></td>
                                <td class="text-center"><?= date('d-m-Y',strtotime($order_books['order_date']))?> </td>
                                <td class="text-center"><?= $order_books['stock_in_hand'] ?> </td>
                                <td>
                                    Ledger: <?= $order_books['qty'] ?><br>
                                    Fair / Store: <?= ($order_books['bookfair']+$order_books['bookfair2']+$order_books['bookfair3']+$order_books['bookfair4']+$order_books['bookfair5']) ?><br>
                                    <?php if ($order_books['lost_qty'] < 0) { ?>
                                        <span class="text-success">Excess: <?= abs($order_books['lost_qty']) ?></span><br>
                                    <?php } elseif ($order_books['lost_qty'] > 0) { ?>
                                        <span class="text-danger">Lost: <?= $order_books['lost_qty'] ?><br></span>
                                    <?php } ?>
                                </td>
                                <?php
                                    $stockStatus = $order_books['quantity'] <= ($order_books['stock_in_hand']+$order_books['lost_qty']) ? 'IN STOCK' : 'OUT OF STOCK';
                                    $recommendationStatus = "";
                                    
                                    if ($order_books['quantity'] <= ($order_books['stock_in_hand']+$order_books['lost_qty'])) {
                                        $stockStatus = "IN STOCK";
                                        if ($order_books['quantity'] <= $order_books['stock_in_hand']) {
                                            $recommendationStatus ="";
                                        } else {
                                            $recommendationStatus = "Print using <span class='text-danger'>LOST</span> Qty! No Initiate to Print";
                                        }
                                    } else {
                                        $stockStatus = "OUT OF STOCK";
                                        if ($order_books['quantity'] <= $order_books['stock_in_hand']) {
                                            $recommendationStatus = "Print using <span class='text-success'>EXCESS</span> Qty! Initiate Print Also";
                                        }
                                    }
                                ?>
                                <td class="text-center">
                                    <?= $stockStatus ?>
                                    <br><span class="text-primary">
                                    <?php if (!($stockStatus == 'OUT OF STOCK' && $recommendationStatus == '')) {
                                        echo $recommendationStatus;
                                    } ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                <?php if (($stockStatus == 'OUT OF STOCK') && ($recommendationStatus == '')) { ?>
                                    <a href="<?= base_url('paperback/paperbackprintstatus') ?>" 
                                    class="btn btn-lilac-600 radius-8" target="_blank" 
                                    style="padding: 4px 10px; font-size: 12px;">
                                    Status
                                    </a>
                                    <br><br> 
                                    <a href="<?= base_url('paperback/initiateprintdashboard/' . $order_books['book_id']) ?>" 
                                    class="btn btn-warning" target="_blank" 
                                    style="padding: 4px 10px; font-size: 12px;">
                                    Print
                                    </a>
                                <?php } else { ?>
                                    <a href="<?= base_url('paperback/onlineordership/' . $order_books['online_order_id'] . '/' . $order_books['book_id']); ?>" 
                                    class="btn btn-success mb-2 mr-2" target="_blank" 
                                    style="padding: 4px 10px; font-size: 12px;">
                                    Ship
                                    </a>
                                    <br><br> 
                                    <a href="" onclick="mark_cancel('<?= $order_books['online_order_id'] ?>','<?= $order_books['book_id'] ?>')" 
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

            <!-- Completed Orders -->
            <br><br>
            <center>
                <h6 class="text-center"><u>Online: Completed Orders</u>
                    <a href="<?= base_url(); ?>paperback/totalonlineordercompleted" class="bs-tooltip" title="View all Completed Books" target=_blank>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="blue" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                            <polyline points="15 3 21 3 21 9"></polyline>
                            <line x1="10" y1="14" x2="21" y2="3"></line>
                        </svg>
                    </a>
                </h6>
                <h6 class="text-center">(Shows for 30 days from date of shipment)</h6>
            </center>

            <table class="table table-hover table-success mb-4 zero-config">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">S.No</th>
                        <th style="width: 100px; text-align: center;">Order ID</th>
                        <th style="width: 100px; text-align: center;">Order Date</th>
                        <th style="width: 80px; text-align: center;">Book ID</th>
                        <th style="width: 20%;">Title</th>
                        <th style="width: 15%;">Author</th>
                        <th style="width: 100px; text-align: center;">Shipped Date</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal;">
                    <?php $i=1;
                        foreach ($online_orderbooks['completed'] as $order_books){?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('paperback/onlineorderdetails/' . $order_books['online_order_id']) ?>" target="_blank">
                                        <?= $order_books['online_order_id']; ?>
                                    </a>
                                    <br>
                                    (<?= $order_books['username']; ?>) 
                                    <br><br>
                                    <a href="<?= $order_books['tracking_url']; ?>" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck">
                                            <rect x="1" y="3" width="15" height="13"></rect>
                                            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                            <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                            <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                        </svg>
                                    </a>  
                                </td>
                                <td class="text-center"><?= date('d-m-Y',strtotime($order_books['order_date']))?> </td>
                                <td class="text-center">
                                    <a href="<?= base_url('paperback/paperbackledgerbooksdetails/' .$order_books['book_id']) ?>" target="_blank">
                                        <?= $order_books['book_id'] ?>
                                    </a>
                                </td>
                                <td><?= $order_books['book_title'] ?></td>
                                <td><?= $order_books['author_name'] ?></td>
                                <td class="text-center"><?= date('d-m-Y',strtotime($order_books['ship_date']))?> </td>
                            </tr>
                    <?php }?>
                </tbody>
            </table>

            <!-- Cancel Orders -->
            <br>
            <h6 class="text-center"><u>Online: Cancel Orders</u></h6>
            <div class="table-responsive" style="overflow-x:hidden;">
                <table class="table table-hover zero-config mb-4">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">S.No</th>
                            <th style="width: 100px; text-align: center;">Order Date</th>
                            <th style="width: 100px; text-align: center;">Order ID</th>
                            <th style="width: 80px; text-align: center;">Book ID</th>
                            <th style="width: 20%;">Title</th>
                            <th style="width: 15%;">Author</th>
                            <th style="width: 100px; text-align: center;">Cancel Date</th>
                        </tr>
                    </thead>
                    <tbody style="font-weight: normal;">
                        <?php $i=1;
                            foreach ($online_orderbooks['cancel'] as $order_books){?>
                                <tr>
                                    <td class="text-center"><?= $i++; ?></td>
                                    <td class="text-center"><?= date('d-m-Y',strtotime($order_books['order_date']))?> </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('paperback/onlineorderdetails/' . $order_books['online_order_id']) ?>" target="_blank">
                                            <?= $order_books['online_order_id']; ?>
                                        </a>
                                        <br>
                                        (<?= $order_books['username']; ?>)
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('paperback/paperbackledgerbooksdetails/' .$order_books['book_id']) ?>" target="_blank">
                                            <?= $order_books['book_id'] ?>
                                        </a>
                                    </td>
                                    <td><?= $order_books['book_title'] ?></td>
                                    <td><?= $order_books['author_name'] ?></td> 
                                    <td class="text-center">
                                        <?php if ($order_books['date']== NULL) {
                                            echo '';
                                        } else {
                                            echo date('d-m-Y', strtotime($order_books['date'])); 
                                        }?>
                                    </td>
                                </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const chartData = <?= json_encode($online_summary['chart']); ?>;
        const months = chartData.map(item => item.order_month);
        const totalTitles = chartData.map(item => parseInt(item.total_titles));
        const totalMRP = chartData.map(item => parseInt(item.total_mrp));

        // Chart Config
        var options = {
            chart: {
                type: 'bar',
                height: 420,
                toolbar: { show: false }
            },
            series: [
                { name: "Total Titles", data: totalTitles },
                { name: "Total MRP", data: totalMRP }
            ],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '40%',   // adjust bar thickness
                    endingShape: 'rounded'
                }
            },
            xaxis: {
                categories: months,
                labels: {
                    rotate: -45,
                    style: { fontSize: '12px' }
                }
            },
            yaxis: [
                    {
                        title: { text: "" },
                        labels: {
                            formatter: function (val) { return val.toLocaleString(); }
                        }
                    },
                    {
                        opposite: true,
                        title: { text: "" },
                        labels: {
                            formatter: function (val) {
                                return "₹" + val.toLocaleString();
                            }
                        }
                    }
                ],
            dataLabels: { enabled: false },
            colors: ['#1E90FF', '#13b413ff'], 
            tooltip: {
                shared: true,
                intersect: false,
                y: { formatter: val => val.toLocaleString() }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'center'
            },
            grid: {
                padding: { bottom: 20 }
            }
        };

        var chart = new ApexCharts(document.querySelector("#onlineOrdersChart"), options);
        chart.render();

        // Base URL for AJAX
        var base_url = window.location.origin;

        // Cancel Order
        window.mark_cancel = function(online_order_id, book_id) {
            $.ajax({
                url: base_url + 'paperback/onlinemarkcancel',
                type: 'POST',
                data: { "online_order_id": online_order_id, "book_id": book_id },
                success: function(data) {
                    if (data == 1) {
                        alert("Shipping Cancelled!!");
                    } else {
                        alert("Unknown error!! Check again!");
                    }
                }
            });
        }

        // Bulk Orders
        window.bulk_orders = function(event) {
            event.preventDefault();
            var bulkOrderId = document.getElementById('bulk_order_id').value;
            if (bulkOrderId) {
                var url = "<?= base_url('paperback/onlinebulkordersship/') ?>" + encodeURIComponent(bulkOrderId);
                window.location.href = url;
            } else {
                alert("Please enter a Bulk Order ID.");
            }
        }

        // Initialize DataTables
        new DataTable('.zero-config');
    });
</script>
<?= $this->endSection(); ?>

