<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-title row">
                <div class="col">
                    <h6>Bookshop Orders Status Dashboard</h6>
                </div>
                <div class="col-3">
                    <a href="<?= base_url('paperback/bookshopordersdashboard'); ?>" class="btn btn-info mb-2 mr-2">
                        Create New Bookshop Orders
                    </a>
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
                                <button class="btn btn-warning mb-2 mr-2" disabled>Ship</button>
                                <a href="javascript:void(0)" onclick="mark_cancel('<?= $order_books['order_id']; ?>')" 
                                   class="btn btn-danger mb-2 mr-2">Cancel</a>
                            <?php } else { ?>
                                <a href="<?= base_url('paperback/bookshopordership/' . $order_books['order_id']); ?>" 
                                   class="btn btn-warning mb-2 mr-2" target="_blank">Ship</a>
                                <a href="javascript:void(0)" onclick="mark_cancel('<?= $order_books['order_id']; ?>')" 
                                   class="btn btn-danger mb-2 mr-2">Cancel</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <br><br><br>

        <!-- Completed Orders -->
        <h6 class="text-center">Bookshop: Completed Orders & Pending Payment</h6>
        <a href="<?= base_url('paperback/totalbookshopordercompleted'); ?>" class="bs-tooltip" 
           title="View all Completed Books" target="_blank">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                 viewBox="0 0 24 24" fill="none" stroke="blue" stroke-width="2" 
                 stroke-linecap="round" stroke-linejoin="round" 
                 class="feather feather-external-link">
                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                <polyline points="15 3 21 3 21 9"></polyline>
                <line x1="10" y1="14" x2="21" y2="3"></line>
            </svg>
        </a>
        <h6 class="text-center">(Shows for 30 days from date of shipment)</h6>

        <table class="table table-hover table-success mb-4 zero-config">
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
                            <?= $order_books['payment_type'] . ' - ' . $order_books['payment_status']; ?>
                            <br>
                            <?php if ($order_books['payment_status'] == 'Pending') { ?>
                                <a href="javascript:void(0)" onclick="mark_pay('<?= $order_books['order_id']; ?>')" 
                                   class="btn-sm btn-primary mb-2 mr-2">Mark Paid</a>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="<?= base_url('paperback/bookshoporderdetails/' . $order_books['order_id']); ?>" 
                               class="btn btn-info mb-2 mr-2">View</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <br><br>

        <!-- Cancelled Orders -->
        <h6 class="text-center">Bookshop: Cancelled Orders</h6>
        <table class="table table-hover table-danger mb-4 zero-config">
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

<script type="text/javascript">
    function mark_cancel(order_id) {
        $.ajax({
            url: "<?= base_url('paperback/bookshopmarkcancel'); ?>",
            type: "POST",
            data: { order_id: order_id },
            success: function(data) {
                if (data == 1) {
                    alert("Shipping Cancelled!");
                    location.reload();
                } else {
                    alert("Unknown error! Please try again.");
                }
            }
        });
    }

    function mark_pay(order_id) {
        $.ajax({
            url: "<?= base_url('paperback/bookshopmarkpay'); ?>",
            type: "POST",
            data: { order_id: order_id },
            success: function(data) {
                if (data == 1) {
                    alert("Payment Received!");
                    location.reload();
                } else {
                    alert("Unknown error! Please try again.");
                }
            }
        });
    }
</script>

<?= $this->endSection(); ?>
