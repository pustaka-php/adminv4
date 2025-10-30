<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-title row">
                <div class="col"></div>
                <div class="col-3">
                    <a href="<?= base_url('paperback/bookshopordersdashboard'); ?>" class="btn btn-info mb-2 mr-2">
                        Create New Bookshop Orders
                    </a>
                </div>
            </div>
        </div>

        <br><br>

        <!-- Bookshop Summary + Month-wise Chart -->
        <div class="card basic-data-table">
            <div class="row">
                <!-- Bookshop Orders Summary Table -->
                <div class="col-md-5 mb-3"> <!-- reduced from col-md-6 -->
                    <div class="card mb-3 h-100">
                        <div class="card-header border-bottom bg-base py-12 px-20">
                            <h6 class="card-title mb-0">Bookshop Order Summary</h6>
                        </div>
                        <div class="card-body p-3">
                            <table class="table table-sm table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Total Orders</th>
                                        <th>Total Titles</th>
                                        <th>Total MRP</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="bg-primary-light">In Progress</td>
                                        <td class="bg-primary-light">
                                            <?= $bookshop_summary['in_progress'][0]['total_orders'] ?? 0 ?>
                                        </td>
                                        <td class="bg-primary-light">
                                            <?= $bookshop_summary['in_progress'][0]['total_titles'] ?? 0 ?>
                                        </td>
                                        <td class="bg-primary-light">
                                            <?= $bookshop_summary['in_progress'][0]['total_mrp'] ?? 0 ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-success-focus">Completed (Last 30 Days / Pending Payment)</td>
                                        <td class="bg-success-focus">
                                            <?= $bookshop_summary['completed'][0]['total_orders'] ?? 0 ?>
                                        </td>
                                        <td class="bg-success-focus">
                                            <?= $bookshop_summary['completed'][0]['total_titles'] ?? 0 ?>
                                        </td>
                                        <td class="bg-success-focus">
                                            <?= $bookshop_summary['completed'][0]['total_mrp'] ?? 0 ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-info-focus">Completed (All Time)</td>
                                        <td class="bg-info-focus">
                                            <?= $bookshop_summary['completed_all'][0]['total_orders'] ?? 0 ?>
                                        </td>
                                        <td class="bg-info-focus">
                                            <?= $bookshop_summary['completed_all'][0]['total_titles'] ?? 0 ?>
                                        </td>
                                        <td class="bg-info-focus">
                                            <?= $bookshop_summary['completed_all'][0]['total_mrp'] ?? 0 ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-danger-light">Cancelled</td>
                                        <td class="bg-danger-light">
                                            <?= $bookshop_summary['cancel'][0]['total_orders'] ?? 0 ?>
                                        </td>
                                        <td class="bg-danger-light">
                                            <?= $bookshop_summary['cancel'][0]['total_titles'] ?? 0 ?>
                                        </td>
                                        <td class="bg-danger-light">
                                            <?= $bookshop_summary['cancel'][0]['total_mrp'] ?? 0 ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Month-wise Orders Chart -->
                <div class="col-md-7 mb-4"> <!-- adjusted from col-md-6 to col-md-7 -->
                    <div class="card h-100 p-0 ms-3">
                        <div class="card-header border-bottom bg-base py-16 px-24">
                            <h6 class="text-lg fw-semibold mb-0">Bookshop Orders Month-wise</h6>
                        </div>
                        <div class="card-body p-24">
                            <div id="bookshopChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br><br>

        <!-- In Progress Orders -->
        <h6 class="text-center">Bookshop: In Progress Orders</h6>
        <br>
        <table class="table zero-config">
            <thead>
                <tr>
                    <th>S.NO</th>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Buyer's Order No</th>
                    <th>No. of Titles</th>
                    <th>Ship Date</th>
                    <th>Payment Details</th>
                    <th>Invoice</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody style="font-weight: normal;">
                <?php $i = 1; foreach ($bookshop_status['in_progress'] as $order_books) { ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td>
                            <a href="<?= base_url('paperback/bookshoporderdetails/' . $order_books['order_id']); ?>" target="_blank">
                                <?= $order_books['order_id']; ?>
                            </a>
                            <br>(<?= $order_books['bookshop_name']; ?>)
                            <br><?= $order_books['city']; ?>
                        </td>
                        <td><?= date('d-m-Y', strtotime($order_books['order_date'])); ?></td>
                        <td><?= $order_books['vendor_po_order_number']; ?></td>
                        <td><?= $order_books['tot_book']; ?></td>
                        <td><?= date('d-m-Y', strtotime($order_books['ship_date'])); ?></td>
                        <td><?= $order_books['payment_type'] . ' - ' . $order_books['payment_status']; ?></td>
                        <td class="text-center">
                            <?php if (empty($order_books['invoice_no'])) { ?>
                                <a href="<?= base_url('paperback/createbookshoporder/' . $order_books['order_id']); ?>" 
                                   class="btn btn-primary btn-sm" target="_blank">Create Invoice</a>
                            <?php } else { ?>
                                <?= $order_books['invoice_no']; ?>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if (empty($order_books['invoice_no'])) { ?>
                                <a href="" class="btn btn-warning mb-2 mr-2" target="_blank" 
                                style="padding: 4px 10px; font-size: 12px;" disabled>Ship</a>
                                <a href="" onclick="mark_cancel(<?php echo $order_books['order_id']; ?>)" 
                                class="btn btn-danger mb-2 mr-2" 
                                style="padding: 4px 10px; font-size: 12px;">Cancel</a>
                            <?php } else { ?>
                                <a href="<?= base_url('paperback/bookshopordership/' . $order_books['order_id']); ?>" 
                                class="btn btn-warning mb-2 mr-2" target="_blank"
                                style="padding: 4px 10px; font-size: 12px;">Ship</a>
                                <a href="#" onclick="mark_cancel(<?= $order_books['order_id']; ?>)" 
                                    class="btn btn-danger mb-2 mr-2" 
                                    style="padding: 4px 10px; font-size: 12px;">Cancel</a>


                            <?php } ?>
                        </td>

                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <br><br><br>

        <!-- Completed Orders -->
        <h6 class="text-center"><u>Bookshop: Completed Orders & Pending Payment</u>
        <a href="<?php echo base_url(); ?>paperback/totalbookshopordercompleted" class="bs-tooltip " title="<?php echo 'View all Completed Books'?>"target=_blank style="margin-left:6px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="blue" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                        <polyline points="15 3 21 3 21 9"></polyline>
                        <line x1="10" y1="14" x2="21" y2="3"></line>
                    </svg>
                </a></h6>
        <h6 class="text-center">(Shows for 30 days from date of shipment)</h6>
        <table class="table table-hover mb-4 zero-config">
            <thead>
                <tr>
                    <th>S.NO</th>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Invoice Number</th>
                    <th>Buyer's Order No</th>
                    <th>No. of Titles</th>
                    <th>Ship Date</th>
                    <th>Payment Details</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody style="font-weight: normal;">
                <?php $i = 1; foreach ($bookshop_status['completed'] as $order_books) { ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td>
                            <a href="<?= base_url('paperback/bookshoporderdetails/' . $order_books['order_id']); ?>" target="_blank">
                                <?= $order_books['order_id']; ?>
                            </a>
                            <br>(<?= $order_books['bookshop_name']; ?>)
                            <br><?= $order_books['city']; ?>
                        </td>
                        <td><?= date('d-m-Y', strtotime($order_books['order_date'])); ?></td>
                        <td><?= $order_books['invoice_no']; ?></td>
                        <td><?= $order_books['vendor_po_order_number']; ?></td>
                        <td><?= $order_books['tot_book']; ?></td>
                        <td><?= date('d-m-Y', strtotime($order_books['ship_date'])); ?></td>
                        <td>
                            <?php 
                                $payment_status = trim($order_books['payment_status']); 
                                echo $order_books['payment_type'] . ' - ' . $payment_status; 

                                if (stripos($payment_status, 'Pending') !== false) { 
                            ?>
                                <a href="" 
                                onclick="mark_pay('<?php echo $order_books['order_id']; ?>')" 
                                class="btn btn-sm btn-primary" 
                                style="padding:2px 6px; font-size:12px; margin-left:5px;">
                                    Mark Paid
                                </a>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="<?= base_url('paperback/bookshoporderdetails/' . $order_books['order_id']); ?>" 
                                class="btn btn-info btn-sm mb-2 mr-2">View</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <br><br>

        <!-- Cancelled Orders -->
        <h6 class="text-center">Bookshop: Cancelled Orders</h6>
        <table class="table table-hover mb-4 zero-config">
            <thead>
                <tr>
                    <th>S.NO</th>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Buyer's Order No</th>
                    <th>No. of Titles</th>
                    <th>Ship Date</th>
                </tr>
            </thead>
            <tbody style="font-weight: normal;">
                <?php $i = 1; foreach ($bookshop_status['cancel'] as $order_books) { ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td>
                            <a href="<?= base_url('paperback/offlineorderdetails/' . $order_books['order_id']); ?>" target="_blank">
                                <?= $order_books['order_id']; ?>
                            </a>
                            <br>(<?= $order_books['bookshop_name']; ?>)
                            <br><?= $order_books['city']; ?>
                        </td>
                        <td><?= date('d-m-Y', strtotime($order_books['order_date'])); ?></td>
                        <td><?= $order_books['vendor_po_order_number']; ?></td>
                        <td><?= $order_books['tot_book']; ?></td>
                        <td><?= date('d-m-Y', strtotime($order_books['ship_date'])); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
</div>
<?= $this->endSection(); ?>
<!-- Chart Script -->
<?= $this->section('script'); ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const chartData = <?= json_encode($bookshop_summary['chart']); ?>;
    const months = chartData.map(item => item.order_month);
    const totalTitles = chartData.map(item => parseInt(item.total_titles));
    const totalMrp = chartData.map(item => parseInt(item.total_mrp));

        var options = {
        chart: {
            type: 'bar',
            height: 400,
            stacked: false,
            toolbar: { show: false }
        },
        series: [
            { name: "Total Titles", type: 'column', data: totalTitles },
            { name: "Total MRP", type: 'column', data: totalMrp }
        ],
        plotOptions: {
            bar: { horizontal: false, columnWidth: '40%', endingShape: 'rounded' }
        },
        xaxis: { categories: months, title: { text: 'Order Month' } },
        yaxis: [
            {
                title: { text: " " },
                labels: { formatter: val => val.toLocaleString() }
            },
            {
                opposite: true,
                title: { text: "" },
                labels: { formatter: val => val.toLocaleString() }
            }
        ],
        dataLabels: { enabled: false },
        colors: ['#1E90FF', '#28a745'],
        tooltip: {
            shared: true, intersect: false,
            y: { formatter: val => val.toLocaleString() }
        },
        legend: { position: 'top', horizontalAlign: 'center' }
    };


    var chart = new ApexCharts(document.querySelector("#bookshopChart"), options);
    chart.render();
});
</script>
<script type="text/javascript">

    var base_url = "<?= base_url() ?>";

    function mark_cancel(order_id) {
    $.ajax({
        url: base_url + 'paperback/bookshopmarkcancel',
        type: "POST",
        data: { 
            order_id: order_id,
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
        },
        dataType: 'JSON',
        success: function(response) {
            if (response.status == 1) {
                alert("Order Cancelled Successfully!");
                location.reload();
            } else {
                alert("Failed to cancel order. Please try again.");
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert("AJAX Error: " + error);
        }
    });
}


    function mark_pay(order_id) {
        $.ajax({
            url: base_url + 'paperback/bookshopmarkpay',
            type: "POST",
            data: { 
                "order_id": order_id,
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            },
            dataType: 'json',
            success: function(response) {
                if (response.status == 1) {
                    alert("Payment Received!");
                    location.reload();
                } else {
                    alert("Unknown error! Please try again.");
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                alert("AJAX Error: " + error);
            }
        });
    }
</script>
<?= $this->endSection(); ?>
