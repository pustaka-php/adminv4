<?= $this->extend('layout/layout1'); ?>



<?= $this->section('content'); ?>
<div class="row g-4">
     <div class="mb-3 text-end">
        <a href="<?= base_url('tppublisherdashboard/tppublishercreateorder') ?>" 
           class="btn btn-primary rounded-pill px-6">
            <i class="bi bi-plus-lg"></i> Create New Order
        </a>
         <a href="<?= base_url('tppublisherdashboard/tpstockledgerdetails') ?>" 
           class="btn btn-primary rounded-pill px-6">
            <i class="bi bi-plus-lg"></i> Book Ledger Summary
        </a>
    </div>

    <!-- Titles Card -->
    <div class="col-xxl-3 col-sm-6">
        <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-1">
            <div class="card-body p-0 d-flex flex-column justify-content-between h-100">
                <div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="w-64-px h-64-px radius-16 bg-base-50 d-flex justify-content-center align-items-center me-20">
                            <span class="w-40-px h-40-px bg-primary-600 text-white d-flex justify-content-center align-items-center radius-8">
                                <iconify-icon icon="mdi:book" class="icon"></iconify-icon>
                            </span>
                        </div>
                        <div>
                            <h6 class="fw-semibold mb-1">
                                <!-- <?= $publisher_data['active_book_cnt'] + $publisher_data['inactive_book_cnt'] + $publisher_data['pending_book_cnt']; ?> -->
                            </h6>
                            <h6 class="fw-semibold mb-1">Titles</h6>
                        </div>
                    </div>
                    <div class="d-flex gap-2 flex-wrap mb-3">
                        <span class="fw-medium text-secondary-light text-sm"><?= $publisher_data['active_book_cnt']; ?> Active</span>
                        <span class="fw-medium text-secondary-light text-sm">|</span>
                        <span class="fw-medium text-secondary-light text-sm"><?= $publisher_data['inactive_book_cnt']; ?> Inactive</span>
                        <span class="fw-medium text-secondary-light text-sm">|</span>
                        <span class="fw-medium text-secondary-light text-sm"><?= $publisher_data['pending_book_cnt']; ?> Hold</span>
                    </div>
                </div>
                <div class="mt-auto">
                    <a href="<?= base_url('tppublisherdashboard/viewpublisherbooks') ?>" class="btn btn-sm btn-light text-primary fw-semibold">View Details</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Card -->
    <div class="col-xxl-3 col-sm-6">
        <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-2">
            <div class="card-body p-0 d-flex flex-column justify-content-between h-100">
                <div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="w-64-px h-64-px radius-16 bg-base-50 d-flex justify-content-center align-items-center me-20">
                            <span class="w-40-px h-40-px bg-purple text-white d-flex justify-content-center align-items-center radius-8">
                                <iconify-icon icon="mdi:clipboard-list-outline" class="icon"></iconify-icon>
                            </span>
                        </div>
                        <div>
                            <!-- <h6 class="fw-semibold mb-1"><?= $publisher_data['order_count']; ?></h6> -->
                            <h6 class="fw-semibold mb-1">Orders</h6>
                        </div>
                    </div>
                    <div class="d-flex gap-2 flex-wrap mb-3">
                        <span class="fw-medium text-secondary-light text-sm"><?= $publisher_data['order_pending_count']; ?> Pending</span>
                        <span class="fw-medium text-secondary-light text-sm">|</span>
                        <span class="fw-medium text-secondary-light text-sm"><?= $publisher_data['order_completed_count']; ?> Completed</span>
                    </div>
                </div>
                <div class="mt-auto">
                    <a href="<?= base_url('tppublisherdashboard/tppublisherorderdetails') ?>" class="btn btn-sm btn-light text-primary fw-semibold">View Details</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Quantity Card -->
    <!-- dynamic values fetch -->
    <div class="col-xxl-3 col-sm-6">
        <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-5">
            <div class="card-body p-0 d-flex flex-column justify-content-between h-100">
                <div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="w-64-px h-64-px radius-16 bg-base-50 d-flex justify-content-center align-items-center me-20">
                            <span class="w-40-px h-40-px bg-red text-white d-flex justify-content-center align-items-center radius-8">
                                <iconify-icon icon="mdi:cart-outline" class="icon"></iconify-icon>
                            </span>
                        </div>
                        <div>
                            <h6 class="fw-semibold mb-1">
                                <!-- <?= $publisher_data['qty_pustaka'] + $publisher_data['qty_amazon'] + $publisher_data['qty_bookfair'] + $publisher_data['qty_other']; ?> -->
                            </h6>
                            <h6 class="fw-semibold mb-1">Sales </h6>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mb-2 flex-wrap">
                        <span class="fw-medium text-secondary-light text-sm"><?= $publisher_data['qty_pustaka']; ?> Pustaka</span>
                        <span class="fw-medium text-secondary-light text-sm">|</span>
                        <span class="fw-medium text-secondary-light text-sm"><?= $publisher_data['qty_amazon']; ?> Amazon</span>
                    </div>
                    <div class="d-flex gap-2 flex-wrap mb-3">
                        <span class="fw-medium text-secondary-light text-sm"><?= $publisher_data['qty_bookfair']; ?> Book Fair</span>
                        <span class="fw-medium text-secondary-light text-sm">|</span>
                        <span class="fw-medium text-secondary-light text-sm"><?= $publisher_data['qty_other']; ?> Other</span>
                    </div>
                </div>
                <div class="mt-auto">
                    <a href="<?= base_url('tppublisherdashboard/tpsalesdetails') ?>" class="btn btn-sm btn-light text-primary fw-semibold">View Details</a>
                </div>
            </div>
        </div>
    </div>


    <!-- Payment Details Card -->
    <div class="col-xxl-3 col-sm-6">
        <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-4">
            <div class="card-body p-0 d-flex flex-column justify-content-between h-100">
                <div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="w-64-px h-64-px radius-16 bg-base-50 d-flex justify-content-center align-items-center me-20">
                            <span class="w-40-px h-40-px bg-success-main text-white d-flex justify-content-center align-items-center radius-8">
                                <iconify-icon icon="mdi:currency-inr" class="icon"></iconify-icon>
                            </span>
                        </div>
                        <div>
                            <h6 class="fw-semibold mb-1">Payments</h6>
                        </div>
                    </div>
                    <div class="d-flex gap-2 flex-wrap mb-3">
                        <span class="fw-medium text-secondary-light text-sm">
                           To Pay: <?= indian_format($publisher_data['total_royalty'], 2); ?> <br> <small>(Handling Charges)</small>                           
                        </span>
                        <span class="fw-medium text-secondary-light text-sm">
                            To Receive: <?= indian_format($publisher_data['total_author_amount'], 2); ?> <br> <small>(By Sales)</small>
                        </span>
                    </div>
                </div>
                <div class="mt-auto">
                    <a href="<?= base_url('tppublisherdashboard/handlingandpay') ?>" class="btn btn-sm btn-light text-primary fw-semibold">View Details</a>
                </div>
            </div>
        </div>
    </div>
    <br>
    <span class="mb-3 fw-bold fs-4">In Progress Orders</span>
    <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10"> 
        <thead>
            <tr>
                <th>Sl No</th>
                <th>Order ID</th>
                <th>Order Date</th>
               
                <th>No Of Units</th>
                <th>No Of Titles</th>
                <th>Ship Date</th>
                 <th>Contact Person</th>
                 <th>City</th>
                 <th>mobile</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)) : ?>
                <?php foreach ($orders as $i => $o): ?>
                    <tr>
                        <td><?= esc($i + 1) ?></td>
                        <td><?= esc($o['order_id'] ?? '-') ?></td>
                        <td><?= !empty($o['order_date']) ? date('d-m-y', strtotime($o['order_date'])) : '-' ?></td>
                        
                        <td><?= esc($o['total_qty'] ?? 0) ?></td>
                        <td><?= esc($o['total_books'] ?? '-') ?></td>
                        <td><?= !empty($o['ship_date']) ? date('d-m-y', strtotime($o['ship_date'])) : '-' ?></td>
                         <td><?= esc($o['contact_person'] ?? '-') ?></td>
                        <td><?= esc($o['city'] ?? '-') ?></td>
                        <td><?= esc($o['mobile'] ?? '-') ?></td>
                        <td>
                            <a href="<?= base_url('tppublisherdashboard/tporderfulldetails/' . $o['order_id']) ?>" 
                            class="btn btn-sm btn-success-600 rounded-pill">
                                View
                            </a>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="8" class="text-center">No Pending Orders</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <span class="mb-3 fw-bold fs-4">Pending Orders</span>
<table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10">
    <thead>
        <tr>
            <th>#</th>
            <th>Order ID</th>
            <th>Order Date</th>
            <th>Order Value</th>
            <th>Handling</th>
            <th>Courier</th>
            <th>To Pay</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($pendingOrders)): $i = 1; foreach ($pendingOrders as $row): ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= esc($row['order_id']) ?></td>
            <td><?= date('d-m-y', strtotime($row['order_date'])) ?></td>
            <td><?= indian_format($row['sub_total'], 2) ?></td>
            <td><?= indian_format($row['royalty'], 2) ?></td>
            <td><?= indian_format($row['courier_charges'], 2) ?></td>
            <td><?= indian_format(($row['royalty'] + $row['courier_charges']), 2) ?></td>
            <td><span class="badge bg-warning">Pending</span></td>
            <td>
                <a href="<?= site_url('tppublisherdashboard/tporderfulldetails/' . rawurlencode($row['order_id'])) ?>" 
                   class="btn btn-sm btn-success-600 rounded-pill">View</a>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="9" class="text-center">No Pending Orders</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<hr class="my-5">

<span class="mb-3 fw-bold fs-4">Pending Sales</span>
<table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10">
    <thead>
        <tr>
            <th>#</th>
             <th>Sales Date</th>
            <th>Channel</th>
            <th>Qty</th>
            <th>Total</th>
            <th>To Receive</th>
            <th>Discount</th>
            <th>Paid Status</th>
           
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($pendingSales)): $i = 1; foreach ($pendingSales as $sale): ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= date('d-m-y', strtotime($sale['create_date'])) ?></td>
            <td><?= ucfirst($sale['sales_channel']) ?></td>
            <td><?= esc($sale['total_qty']) ?></td>
            <td><?= indian_format($sale['total_order_value'], 2) ?></td>
            <td><?= indian_format($sale['total_author_amount'], 2) ?></td>
            <td><?= indian_format($sale['avg_discount'], 2) ?></td>
            <td><span class="badge bg-warning"><?= ucfirst($sale['paid_status']) ?></span></td>
            
             <td>
                                        <a href="<?= site_url('tppublisherdashboard/tpsalesfull/' 
                                            . rawurlencode($sale['create_date']) . '/' 
                                            . rawurlencode($sale['sales_channel'])) ?>" 
                                        class="btn btn-sm btn-success-600 rounded-pill">
                                            View
                                        </a>
                                    </td>
        </tr>
        <?php endforeach; else: ?>
        <tr>
            <td colspan="7" class="text-center">No Pending Sales</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>





</div>
<?= $this->endSection(); ?>