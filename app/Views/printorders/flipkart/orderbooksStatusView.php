<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title row">
                <div class="col">
                    <h6 class="text-center">Flipkart Paperback Status Dashboard</h6> 
                </div>
                <div class="col-3">
                    <a href="paperbackflipkartorder" class="btn btn-info mb-2 mr-2">Create New Flipkart Orders</a>
                </div>
            </div>
        </div>
        <br><br>
        <!-- Flipkart Summary + Chart -->
        <div class="card basic-data-table mb-4">
            <div class="row"> 
                <div class="col-md-6 mb-4">
                    <div class="card mb-4 h-100">
                        <div class="card-header border-bottom bg-base py-16 px-24"><br>
                            <h5 class="card-title mb-0">Flipkart Order Summary</h5>
                        </div>
                        <br><br>
                        <div class="card-body">
                            <table class="table colored-row-table mb-0" style="font-size: 10px; margin-bottom:0;">
                                <thead>
                                    <tr style="height:30px;">
                                        <th class="bg-base py-1 px-2">Status</th>
                                        <th class="bg-base py-1 px-2">Total Orders</th>
                                        <th class="bg-base py-1 px-2">Total Titles</th>
                                        <th class="bg-base py-1 px-2">Total MRP</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="bg-primary-light py-1 px-2">In Progress</td>
                                        <td class="bg-primary-light py-1 px-2"><?= $flipkart_summary['in_progress'][0]['total_orders'] ?? 0 ?></td>
                                        <td class="bg-primary-light py-1 px-2"><?= $flipkart_summary['in_progress'][0]['total_titles'] ?? 0 ?></td>
                                        <td class="bg-primary-light py-1 px-2">₹<?= number_format($flipkart_summary['in_progress'][0]['total_mrp'] ?? 0, 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-success-focus py-1 px-2">Completed (last 30 Days)</td>
                                        <td class="bg-success-focus py-1 px-2"><?= $flipkart_summary['completed'][0]['total_orders'] ?? 0 ?></td>
                                        <td class="bg-success-focus py-1 px-2"><?= $flipkart_summary['completed'][0]['total_titles'] ?? 0 ?></td>
                                        <td class="bg-success-focus py-1 px-2">₹<?= number_format($flipkart_summary['completed'][0]['total_mrp'] ?? 0, 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-info-focus py-1 px-2">Completed (All Time)</td>
                                        <td class="bg-info-focus py-1 px-2"><?= $flipkart_summary['completed_all'][0]['total_orders'] ?? 0 ?></td>
                                        <td class="bg-info-focus py-1 px-2"><?= $flipkart_summary['completed_all'][0]['total_titles'] ?? 0 ?></td>
                                        <td class="bg-info-focus py-1 px-2">₹<?= number_format($flipkart_summary['completed_all'][0]['total_mrp'] ?? 0, 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-danger-focus py-1 px-2">Cancelled</td>
                                        <td class="bg-danger-focus py-1 px-2"><?= $flipkart_summary['cancel'][0]['total_orders'] ?? 0 ?></td>
                                        <td class="bg-danger-focus py-1 px-2"><?= $flipkart_summary['cancel'][0]['total_titles'] ?? 0 ?></td>
                                        <td class="bg-danger-focus py-1 px-2">₹<?= number_format($flipkart_summary['cancel'][0]['total_mrp'] ?? 0, 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-warning-focus py-1 px-2">Returned</td>
                                        <td class="bg-warning-focus py-1 px-2"><?= $flipkart_summary['return'][0]['total_orders'] ?? 0 ?></td>
                                        <td class="bg-warning-focus py-1 px-2"><?= $flipkart_summary['return'][0]['total_titles'] ?? 0 ?></td>
                                        <td class="bg-warning-focus py-1 px-2">₹<?= number_format($flipkart_summary['return'][0]['total_mrp'] ?? 0, 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-secondary-focus py-1 px-2">Return Pending</td>
                                        <td class="bg-secondary-focus py-1 px-2"><?= $flipkart_summary['return_pending'][0]['total_orders'] ?? 0 ?></td>
                                        <td class="bg-secondary-focus py-1 px-2"><?= $flipkart_summary['return_pending'][0]['total_titles'] ?? 0 ?></td>
                                        <td class="bg-secondary-focus py-1 px-2">₹<?= number_format($flipkart_summary['return_pending'][0]['total_mrp'] ?? 0, 2) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Month-wise Orders Chart -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100 p-0 ms-3">
                        <div class="card-header border-bottom bg-base py-16 px-24">
                            <h6 class="text-lg fw-semibold mb-0">Flipkart Orders Month-wise</h6>
                        </div>
                        <div class="card-body p-24">
                            <div id="flipkartChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><br><br>
        <!-- In Progress Orders -->
        <h6 class="text-center"><u>Flipkart: In progress Orders</u></h6>
        <table class="table zero-config">
            <thead>
                <tr>
                    <th>S.NO</th>
                    <th>Order id</th>
                    <th>Book ID</th>
                    <th>title</th>
                    <th>Copies</th>
                    <th>Author name</th>
                    <th>Ship Date</th>
                    <th>stock in hand</th>
                    <th>BookFair stock</th>
                    <th>Stock state</th>
                    <th>Action </th>
                </tr>
            </thead>
            <tbody style="font-weight: normal;">
                <?php $i=1;
                foreach ($flipkart_orderbooks['in_progress'] as $order_books){ ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td>
                            <a href="<?= base_url('paperback/flipkartorderdetails/'.$order_books['flipkart_order_id']) ?>" target="_blank">
                                <?php echo $order_books['flipkart_order_id'] ?>
                            </a>
                        </td>
                        <td><?php echo $order_books['book_id'] ?></td>
                        <td><?php echo $order_books['book_title'] ?></td>
                        <td><?php echo $order_books['quantity'] ?></td>
                        <td><?php echo $order_books['author_name'] ?></td>
                        <td><?php echo date('d-m-Y', strtotime($order_books['ship_date'])) ?></td>
                        <td><?php echo $order_books['total_quantity'] ?></td>
                        <td><?php echo $order_books['bookfair'] ?></td>
                        <?php $stockStatus = $order_books['quantity'] <= $order_books['total_quantity'] ? 'IN STOCK' : 'OUT OF STOCK'; ?>
                        <td><?php echo $stockStatus ?></td>
                        <td style="text-align: center;">
                            <?php if ($stockStatus == 'OUT OF STOCK') { ?>
                                <a href="" class="btn btn-warning mb-2 mr-2" disabled>Ship</a>
                                <br><br> <a href="" onclick="mark_cancel('<?php echo $order_books['flipkart_order_id'] ?>','<?php echo $order_books['book_id'] ?>')" class="btn btn-danger mb-2 mr-2">Cancel</a>
                            <?php }else{?>
                                <a href="" onclick="mark_ship(event, '<?php echo $order_books['flipkart_order_id'] ?>', '<?php echo $order_books['book_id'] ?>')" class="btn btn-warning mb-2 mr-2">Ship</a>

                                <br><br> <a href="" onclick="mark_cancel('<?php echo $order_books['flipkart_order_id'] ?>', '<?php echo $order_books['book_id'] ?>')" class="btn btn-danger mb-2 mr-2">Cancel</a>
                            <?php }?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <br><br><br>

        <!-- Completed Orders -->
        <h6 class="text-center">
            <u>Flipkart: Completed Orders</u>
            <a href="<?php echo base_url(); ?>paperback/totalflipkartordercompleted" class="bs-tooltip" title="<?php echo 'View all Completed Books' ?>" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="blue" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link">
                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                    <polyline points="15 3 21 3 21 9"></polyline>
                    <line x1="10" y1="14" x2="21" y2="3"></line>
                </svg>
            </a>
        </h6>
        <h6 class="text-center">( Shows for 30 days from date of shipment )</h6>
        <table class="table table-hover table-success mb-4 zero-config">
            <thead>
                <tr>
                    <th>S.NO</th>
                    <th>Order id</th>
                    <th>Book ID</th>
                    <th>title</th>
                    <th>Author name</th>
                    <th>Shipped Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody style="font-weight: normal;">
                <?php $i=1;
                foreach ($flipkart_orderbooks['completed'] as $order_books){ ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td>
                            <a href="<?= base_url('paperback/flipkartorderdetails/'.$order_books['flipkart_order_id']) ?>" target="_blank">
                                <?php echo $order_books['flipkart_order_id'] ?>
                            </a>
                        </td>
                        <td><?php echo $order_books['book_id'] ?></td>
                        <td><?php echo $order_books['book_title'] ?></td>
                        <td><?php echo $order_books['author_name'] ?></td>
                        <td><?php echo date('d-m-Y', strtotime($order_books['ship_date'])) ?></td>
                        <td style="text-align: center;">
                            <a href="#" onclick="mark_return('<?php echo $order_books['flipkart_order_id'] ?>', '<?php echo $order_books['book_id'] ?>'); return false;" class="btn btn-primary mb-2 mr-2">Return</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <br><br>

        <!-- Cancel Orders -->
        <h6 class="text-center"><u>Flipkart: Cancel Orders</u></h6>
        <table class="table table-hover table-danger mb-4 zero-config">
            <thead>
                <tr>
                    <th>S.NO</th>
                    <th>Order id</th>
                    <th>Book ID</th>
                    <th>title</th>
                    <th>Author name</th>
                    <th>Cancel Date</th>  
                </tr>
            </thead>
            <tbody style="font-weight: normal;">
                <?php $i=1;
                foreach ($flipkart_orderbooks['cancel'] as $order_books){ ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td>
                            <a href="<?= base_url('paperback/flipkartorderdetails/'.$order_books['flipkart_order_id']) ?>" target="_blank">
                                <?php echo $order_books['flipkart_order_id'] ?>
                            </a>
                        </td>
                        <td><?php echo $order_books['book_id'] ?></td>
                        <td><?php echo $order_books['book_title'] ?></td>
                        <td><?php echo $order_books['author_name'] ?></td>
                        <td>
                            <?php 
                            echo $order_books['date'] == NULL ? "" : date('d-m-Y', strtotime($order_books['date']));
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <br><br>

        <!-- Return Orders -->
        <h6 class="text-center"><u>Flipkart: Return Orders</u></h6>
        <table class="table table-hover table-info mb-4 zero-config">
            <thead>
                <tr>
                    <th>S.NO</th>
                    <th>Order id</th>
                    <th>Book ID</th>
                    <th>title</th>
                    <th>Author name</th>
                    <th>Return Date</th> 
                </tr>
            </thead>
            <tbody style="font-weight: normal;">
                <?php $i=1;
                foreach ($flipkart_orderbooks['return'] as $order_books){ ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td>
                            <a href="<?= base_url('paperback/flipkartorderdetails/'.$order_books['flipkart_order_id']) ?>" target="_blank">
                                <?php echo $order_books['flipkart_order_id'] ?>
                            </a>
                        </td>
                        <td><?php echo $order_books['book_id'] ?></td>
                        <td><?php echo $order_books['book_title'] ?></td>
                        <td><?php echo $order_books['author_name'] ?></td>
                        <td>
                            <?php 
                            echo $order_books['date'] == NULL ? "" : date('d-m-Y', strtotime($order_books['date']));
                            ?>
                        </td>   
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div> 
</div>

<script type="text/javascript">
    var base_url = "<?= base_url() ?>";

    function mark_ship(event, flipkart_order_id, book_id){
        event.preventDefault(); 

        $.ajax({
            url: base_url + 'paperback/flipkartmarkshipped',
            type: 'POST',
            data: { 
                flipkart_order_id: flipkart_order_id,
                book_id: book_id,
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>' 
            },
            dataType : 'json',
            success: function(response) {
                if(response.status == '1'){  
                    alert("Completed Successfully!!");
                } else {
                    alert("Unknown error!! Check again!");
                }
            },
            error: function(xhr, status, error){
                alert("AJAX error: " + error);
            }
        });
    }


    function mark_cancel(flipkart_order_id, book_id){
        $.ajax({
            url: base_url + 'paperback/flipkartmarkcancel',
            type: 'POST',
            data:{ 
                flipkart_order_id,
                book_id,
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>' 
            },
            dataType: 'json',
            success: function(response){
                if(response.status == '1'){
                    alert("Shipping Cancelled!!");
                } else {
                    alert("Unknown error!! Check again!");
                }
            },
            error: function(xhr, status, error){
                alert("AJAX error: " + error);
            }
        });
    }

    function mark_return(flipkart_order_id, book_id){
        $.ajax({
            url: base_url + 'paperback/flipkartmarkreturn',
            type: 'POST',
            data: { flipkart_order_id, book_id },
            success: function(response){
                if(response.status == '1'){
                    alert("Restore Successfully!!");
                } else {
                    alert("Unknown error!! Check again!");
                }
            },
            error: function(xhr, status, error){
                alert("AJAX error: " + error);
            }
        });
    }

    // Flipkart Chart
    document.addEventListener("DOMContentLoaded", function() {
        const chartData = <?= json_encode($flipkart_summary['chart']); ?>;
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
                { title: { text: " " }, labels: { formatter: val => val.toLocaleString() } },
                { opposite: true, title: { text: " " }, labels: { formatter: val => "₹" + val.toLocaleString() } }
            ],
            dataLabels: { enabled: false },
            colors: ['#1E90FF', '#b8e31eff'],
            tooltip: {
                shared: true, intersect: false,
                y: { formatter: (val, opts) => opts.seriesIndex === 1 ? "₹" + val.toLocaleString() : val.toLocaleString() }
            },
            legend: { position: 'top', horizontalAlign: 'center' }
        };

        var chart = new ApexCharts(document.querySelector("#flipkartChart"), options);
        chart.render();
    });
</script>

<?= $this->endSection(); ?>
