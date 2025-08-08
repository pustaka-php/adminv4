<?= $this->extend('layout/layout1'); ?>



<?= $this->section('content'); ?>
<div class="row g-4">
     <div class="mb-3 text-end">
        <a href="<?= base_url('tppublisherdashboard/tppublishercreateorder') ?>" 
           class="btn btn-primary rounded-pill px-6">
            <i class="bi bi-plus-lg"></i> Create New Order
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
                                <?= $publisher_data['active_book_cnt'] + $publisher_data['inactive_book_cnt'] + $publisher_data['pending_book_cnt']; ?>
                            </h6>
                            <span class="fw-medium text-secondary-light text-sm">Titles</span>
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
                            <h6 class="fw-semibold mb-1"><?= $publisher_data['order_count']; ?></h6>
                            <span class="fw-medium text-secondary-light text-sm">Publisher Orders</span>
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
                                <?= $publisher_data['qty_pustaka'] + $publisher_data['qty_amazon'] + $publisher_data['qty_bookfair'] + $publisher_data['qty_other']; ?>
                            </h6>
                            <span class="fw-medium text-secondary-light text-sm">Total Sales Qty</span>
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
                        <span class="fw-medium text-secondary-light text-sm"><?= $publisher_data['qty_other']; ?> Others</span>
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
                            <h6 class="fw-semibold mb-1">Payment Details</h6>
                        </div>
                    </div>
                    <div class="d-flex gap-2 flex-wrap mb-3">
                        <span class="fw-medium text-secondary-light text-sm">
                            Handling Charges: ₹<?= number_format($publisher_data['total_royalty'], 2); ?>
                        </span>
                        <span class="fw-medium text-secondary-light text-sm">
                            Payment To Author: ₹<?= number_format($publisher_data['total_author_amount'], 2); ?>
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
                <th>Author</th>
                <th>Total Qty</th>
                <th>Total Books</th>
                <th>Ship Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)) : ?>
                <?php foreach ($orders as $i => $o): ?>
                    <tr>
                        <td><?= esc($i + 1) ?></td>
                        <td><?= esc($o['order_id'] ?? '-') ?></td>
                        <td><?= esc($o['author_name'] ?? '-') ?></td>
                        <td><?= esc($o['total_qty'] ?? 0) ?></td>
                        <td><?= esc($o['total_books'] ?? '-') ?></td>
                        <td><?= !empty($o['ship_date']) ? date('d-M-Y', strtotime($o['ship_date'])) : '-' ?></td>
                        <td>
                            <a href="<?= base_url('tppublisherdashboard/tporderfulldetails/' . $o['order_id']) ?>" 
                            class="btn btn-sm btn-success-600 rounded-pill">
                                View
                            </a>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7" class="text-center">No in-progress orders found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10"> 
    <thead>
        <tr>
            <th>Sl No</th>
            <th>Order ID</th>
            <th>Author Name</th>
            <th>Subtotal (₹)</th>
            <th>Handling charges (₹)</th>
            <th>Courier Charges (₹)</th>
            <th>Paid Status</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if (!empty($handlingCharges)) :
            $sl = 1;
            foreach ($handlingCharges as $row) :
                if (strtolower($row['payment_status']) === 'pending') : // Show only pending
        ?>
            <tr>
                <td><?= $sl++ ?></td>
                <td><?= esc($row['order_id']) ?></td>
                <td><?= esc($row['author_name']) ?></td>
                <td>₹<?= number_format($row['sub_total'], 2) ?></td>
                <td>₹<?= number_format($row['royalty'], 2) ?></td>
                <td>₹<?= number_format($row['courier_charges'], 2) ?></td>
                <td>
                    <span class="badge bg-danger"><?= ucfirst(esc($row['payment_status'])) ?></span>
                </td>
            </tr>
        <?php 
                endif;
            endforeach;

            // If no pending records found
            if ($sl === 1) :
        ?>
            <tr>
                <td colspan="7" class="text-center">No pending payments found.</td>
            </tr>
        <?php 
            endif;
        else :
        ?>
            <tr>
                <td colspan="7" class="text-center">No handling charges data found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>


</div>
<?= $this->endSection(); ?>