<?= $this->extend('layout/layout1'); ?>
    <?= $this->section('script'); ?>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
        $.fn.dataTable.ext.errMode = 'none';
        new DataTable("#dataTable");
        new DataTable("#dataTablePayments");
    });
            </script>
    <?= $this->endSection(); ?>


<?= $this->section('content'); ?> 

<div class="row gy-4">
    
    <div class="col-xxxl-9">
        <div class="row gy-4 justify-content-center">

            <!-- Publisher Card -->
            <div class="col-xxl-4 col-xl-4 col-sm-6">
                <a href="<?= base_url('tppublisher/tppublisherdetails'); ?>" class="d-block h-100">
                    <div class="card p-3 shadow-2 radius-8 h-100 bg-gradient-end-6">
                        <div class="card-body p-0">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="w-48-px h-48-px bg-cyan-100 text-white d-flex justify-content-center align-items-center rounded-circle">
                                        <i class="ri-group-fill"></i>
                                    </span>
                                    <div>
                                        <h6 class="fw-semibold mb-2">
                                            <?= $publisher_data['active_publisher_cnt'] + $publisher_data['inactive_publisher_cnt']; ?>
                                        </h6>
                                        <span class="fw-medium text-secondary-light text-sm">Publishers</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <span class="fw-medium text-secondary-light text-sm"><?= $publisher_data['active_publisher_cnt']; ?></span>
                                <span class="fw-medium text-secondary-light text-sm">Active</span> 
                                <span class="fw-medium text-secondary-light text-sm">|</span> 
                                <span class="fw-medium text-secondary-light text-sm"><?= $publisher_data['inactive_publisher_cnt']; ?></span>
                                <span class="fw-medium text-secondary-light text-sm">Inactive</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Author Card -->
            <div class="col-xxl-4 col-xl-4 col-sm-6">
                <a href="<?= base_url('tppublisher/tpauthordetails'); ?>" class="d-block h-100">
                    <div class="card p-3 shadow-2 radius-8 h-100 bg-gradient-end-4">
                        <div class="card-body p-0">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="w-48-px h-48-px bg-lilac-100 text-white d-flex justify-content-center align-items-center rounded-circle">
                                        <i class="ri-group-fill"></i>
                                    </span>
                                    <div>
                                        <h6 class="fw-semibold mb-2"><?= $publisher_data['active_author_cnt'] + $publisher_data['inactive_author_cnt']; ?></h6>
                                        <span class="fw-medium text-secondary-light text-sm">Authors</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <span class="fw-medium text-secondary-light text-sm"><?= $publisher_data['active_author_cnt']; ?></span>
                                <span class="fw-medium text-secondary-light text-sm">Active</span> 
                                <span class="fw-medium text-secondary-light text-sm">|</span> 
                                <span class="fw-medium text-secondary-light text-sm"><?= $publisher_data['inactive_author_cnt']; ?></span>
                                <span class="fw-medium text-secondary-light text-sm">Inactive</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Book Card -->
            <div class="col-xxl-4 col-xl-4 col-sm-6">
                <a href="<?= base_url('tppublisher/tpbookdetails'); ?>" class="d-block h-100">
                    <div class="card p-3 shadow-2 radius-8 h-100 bg-gradient-end-1">
                        <div class="card-body p-0">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="w-48-px h-48-px bg-primary-100 text-white d-flex justify-content-center align-items-center rounded-circle">
                                        <iconify-icon icon="mdi:book" width="24" height="24"></iconify-icon>
                                    </span>
                                    <div>
                                        <h6 class="fw-semibold mb-2">
                                            <?= $publisher_data['active_book_cnt'] + $publisher_data['inactive_book_cnt'] + $publisher_data['pending_book_cnt']; ?>
                                        </h6>
                                        <span class="fw-medium text-secondary-light text-sm">Titles</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <span class="fw-medium text-secondary-light text-sm"><?= $publisher_data['active_book_cnt']; ?></span>
                                <span class="fw-medium text-secondary-light text-sm">Active</span> 
                                <span class="fw-medium text-secondary-light text-sm">|</span> 
                                <span class="fw-medium text-secondary-light text-sm"><?= $publisher_data['inactive_book_cnt']; ?></span>
                                <span class="fw-medium text-secondary-light text-sm">Inactive</span> 
                                <span class="fw-medium text-secondary-light text-sm">|</span>
                                <span class="fw-medium text-secondary-light text-sm"><?= $publisher_data['pending_book_cnt']; ?></span>
                                <span class="fw-medium text-secondary-light text-sm">Hold</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row gy-4 justify-content-center mt-2">
                <!-- Stock Ledger Card -->
    <div class="col-xxl-4 col-xl-4 col-sm-6">
        <a href="<?= base_url('tppublisher/tpstockledgerdetails'); ?>" class="d-block h-100">
            <div class="card p-3 shadow-2 radius-8 h-100 bg-gradient-end-4">
                <div class="card-body p-0">
                    <!-- Header -->
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="mb-0 w-48-px h-48-px bg-success-100 text-success-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                <iconify-icon icon="mdi:package-variant" width="24" height="24"></iconify-icon>
                            </span>
                            <div>
                                 <h6 class="fw-semibold mb-2">
                                            <?= $publisher_data['tot_stock_count']; ?>
                                        </h6>
                                <span class="fw-medium text-secondary-light text-sm">Stock Ledger</span>
                            </div>
                        </div>
                    </div>

                    <!-- Stock Totals -->
                    <div class="d-flex gap-2 mb-3">
                        <span class="fw-medium text-secondary-light text-sm"><?= $publisher_data['stock_in_hand']; ?></span>
                        <span class="fw-medium text-secondary-light text-sm">Stock In</span> 
                        <span class="fw-medium text-secondary-light text-sm">|</span> 
                        <span class="fw-medium text-secondary-light text-sm"><?= $publisher_data['stock_out']; ?></span>
                        <span class="fw-medium text-secondary-light text-sm">Stock Out</span> 
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Order Card -->
            <div class="col-xxl-4 col-xl-4 col-sm-6">
                <a href="<?= base_url('tppublisher/tppublisherorder'); ?>" class="d-block h-100">
                    <div class="card p-3 shadow-2 radius-8 h-100 bg-gradient-end-6">
                        <div class="card-body p-0">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="mb-0 w-48-px h-48-px bg-success-100 text-success-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                        <iconify-icon icon="mdi:package-variant" width="24" height="24"></iconify-icon>
                                    </span>
                                    <div>
                                        <h6 class="fw-semibold mb-2">
                                            <?= $publisher_data['total_orders_cnt']; ?>
                                        </h6>
                                        <span class="fw-medium text-secondary-light text-sm">Orders</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <span class="fw-medium text-secondary-light text-sm"><?= $publisher_data['shipped_orders_cnt']; ?></span>
                                <span class="fw-medium text-secondary-light text-sm">Shipped</span> 
                                <span class="fw-medium text-secondary-light text-sm">|</span> 
                                <span class="fw-medium text-secondary-light text-sm"><?= $publisher_data['pending_orders_cnt']; ?></span>
                                <span class="fw-medium text-secondary-light text-sm">In Progress</span> 
                            </div>
                        </div>
                    </div>
                </a>
            </div>


    <!-- Sales Card -->
            <div class="col-xxl-4 col-xl-4 col-sm-6">
                <a href="<?= base_url('tppublisher/tpsalesdetails'); ?>" class="d-block h-100">
                    <div class="card p-3 shadow-2 radius-8 h-100 bg-gradient-end-1">
                        <div class="card-body p-0">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="w-48-px h-48-px bg-warning-100 text-white d-flex justify-content-center align-items-center rounded-circle">
                                        <iconify-icon icon="mdi:cash-multiple" width="24" height="24"></iconify-icon>
                                    </span>
                                    <div>
                                        <h6 class="fw-semibold mb-2">
                                            <?= number_format($publisher_data['total_sales'] ?? 0); ?>
                                        </h6>
                                        <span class="fw-medium text-secondary-light text-sm">Sales</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <span class="fw-medium text-secondary-light text-sm"><?= $publisher_data['qty_pustaka'] ?? 0; ?></span>
                                <span class="fw-medium text-secondary-light text-sm">Pustaka</span>
                                <span class="fw-medium text-secondary-light text-sm">|</span> 
                                <span class="fw-medium text-secondary-light text-sm"><?= $publisher_data['qty_amazon'] ?? 0; ?></span>
                                <span class="fw-medium text-secondary-light text-sm">Amazon</span>
                                <span class="fw-medium text-secondary-light text-sm">|</span> 
                                <span class="fw-medium text-secondary-light text-sm"><?= $publisher_data['qty_bookfair'] ?? 0; ?></span>
                                <span class="fw-medium text-secondary-light text-sm">Book Fair</span>
                                <span class="fw-medium text-secondary-light text-sm">|</span> 
                                <span class="fw-medium text-secondary-light text-sm"><?= $publisher_data['qty_other'] ?? 0; ?></span>
                                <span class="fw-medium text-secondary-light text-sm">Others</span>  
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>



            <!-- Publishers Orders -->
            <div class="card basic-data-table mt-5">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0" style="font-size: 16px;">Tp Publisher Orders</h5>
            
                    <button type="button" class="btn btn-info-600 radius-8 px-20 py-11"
                        data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-custom-class="tooltip-success"
                        data-bs-title="Success Tooltip"
                        onclick="window.location.href='<?= base_url('tppublisher/tppublisherorder'); ?>'">
                        View Details
                    </button>
                </div>

            <div class="card-body">
                <!-- <table class="table bordered-table mb-0"  data-page-length="10" style="font-size: 13px;"> -->
                 <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10"> 
        <thead>
            <tr>
                <th>Sl No</th>
                <th>Order ID</th>
                <th>Author</th>
                <th>Quantity</th>
                <th>No Of Titles</th>
                <th>order Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
    <?php if (!empty($orders)) : ?>
        <?php 
        $hasPending = false; // To check if any pending orders exist
        foreach ($orders as $i => $o): 
            if ($o['ship_status'] == 0): // Pending check
                $hasPending = true;
        ?>
            <tr>
                <td><?= esc($i + 1) ?></td>
                <td>
                    <?= esc($o['order_id'] ?? '-') ?>
                    <a href="<?= base_url('tppublisher/tporderfulldetails/' . $o['order_id']) ?>" title="View Order Details" class="ms-2">
                        <iconify-icon icon="mdi:eye" style="color: black; font-size: 18px; vertical-align: middle;"></iconify-icon>
                    </a>
                </td>
                <td><?= esc($o['author_name'] ?? '-') ?></td>
                <td><?= esc($o['total_qty'] ?? 0) ?></td>
                <td><?= esc($o['total_books'] ?? '-') ?></td>
                <td><?= !empty($o['order_date']) ? date('d-M-Y', strtotime($o['ship_date'])) : '-' ?></td>
                <td>
                    <?php 
                        $statusText = [
                            0 => 'Pending',
                            1 => 'Shipped',
                            2 => 'Cancelled',
                            3 => 'Returned'
                        ];
                        echo esc($statusText[$o['ship_status']] ?? '-');
                    ?>
                </td>
                <td>
                    <button onclick="mark_ship('<?= esc($o['order_id']) ?>','<?= esc($o['book_id']) ?>')" class="btn btn-success btn-sm mb-1">Ship</button>
                                    <button onclick="mark_cancel('<?= esc($o['order_id']) ?>','<?= esc($o['book_id']) ?>')" class="btn btn-danger btn-sm mb-1">Cancel</button>
                    </td>
            </tr>
        <?php 
            endif; 
        endforeach;

        if (!$hasPending): // No pending orders
        ?>
            <tr><td colspan="7" class="text-center">No pending orders found.</td></tr>
        <?php endif; ?>
    <?php else: ?>
        <tr><td colspan="7" class="text-center">No in-progress orders found.</td></tr>
    <?php endif; ?>
</tbody>

    </table>
            </div>
        </div>


<!-- Payments Table -->
            <div class="card basic-data-table mt-5"> 
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Tp Publisher Payments</h5>
                    <button type="button" class="btn btn-info-600 radius-8 px-20 py-11"
                onclick="window.location.href='<?= base_url('tppublisher/tppublisherorderpayment'); ?>'">
                View Payments
            </button>
                </div>
            <div class="card-body">
                <!-- <table class="table bordered-table mb-0" id="dataTablePayments" style="font-size: 14px;"> -->
                     <table class="zero-config table table-hover mt-4" id="dataTablePayments"> 
                    <thead>
                        <tr>
                            <th>S.L</th>
                            <th>Order Id</th>
                            <th>Publisher</th>
                            <th>Total</th>
                            <th>Handling Charges</th>
                            <th>Courier</th>
                            
                            <th>Payment Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($payments as $i => $p): ?>
                            <?php
                                $royalty_courier_total = $p['royalty'] + $p['courier_charges'];
                            ?>
                            <tr>
                                <td><?= esc($i + 1) ?></td>
                               <td>
                                    <div class="d-flex align-items-center">
                                        <span><?= esc($p['order_id'] ?? '-') ?></span>
                                        <a href="<?= base_url('tppublisher/tporderfulldetails/' . $p['order_id']) ?>" 
                                        title="View Order Details" 
                                        class="ms-2 d-inline-flex align-items-center">
                                            <iconify-icon icon="mdi:eye" 
                                                        style="color: black; font-size: 18px; vertical-align: middle;"></iconify-icon>
                                        </a>
                                    </div>
                                </td>


                                <td><?= esc($p['publisher_name']) ?></td>
                                <td>₹<?= number_format($p['sub_total'], 2) ?></td>
                                <td>₹<?= number_format($p['royalty'], 2) ?></td>
                                <td>₹<?= number_format($p['courier_charges'], 2) ?></td>
                                <td>
                                    <?php
                                        $status = trim(strtolower((string)$p['payment_status']));
                                        echo ($status === '1' || $status === 'paid')
                                            ? '<span>Paid</span>'
                                            : '<span>Pending</span>';
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
</div>
<?= $this->endSection(); ?>
 <?= $this->section('script'); ?>

    <script>
        $(function () {
            $.fn.dataTable.ext.errMode = 'none';
        });

        const csrfName = '<?= csrf_token() ?>';
        const csrfHash = '<?= csrf_hash() ?>';

        function mark_ship(order_id, book_id) {
            if (!confirm("Mark this order as shipped?")) return;

            let courier_charges = 0;
            if (confirm("Do you want to add a courier charge?")) {
                let input = prompt("Enter courier charge:");
                if (input === null) return;
                courier_charges = parseFloat(input);
                if (isNaN(courier_charges)) {
                    alert("Invalid courier charge.");
                    return;
                }
            }

            $.post("<?= base_url('tppublisher/markShipped') ?>", {
                order_id,
                book_id,
                courier_charges,
                [csrfName]: csrfHash
            }, function (response) {
                alert(response.message || "Action completed.");
                if (response.status === 'success') location.reload();
            }, 'json').fail(function (xhr) {
                alert("AJAX error: " + xhr.statusText);
            });
        }

        function mark_cancel(order_id, book_id) {
            if (!confirm("Cancel this order?")) return;

            $.post("<?= base_url('tppublisher/markCancel') ?>", {
                order_id,
                book_id,
                [csrfName]: csrfHash
            }, function (response) {
                alert(response.message);
                if (response.status === 'success') location.reload();
            }, 'json').fail(function (xhr) {
                alert("Cancel failed: " + xhr.statusText);
            });
        }
        </script>
    <?= $this->endSection(); ?>