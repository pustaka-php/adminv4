<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">

    <!-- Handling Charges Section -->
    <div class="card mb-4">
        <div class="card-header fw-bold fs-4">Pustaka - Handling Charges </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10"> 
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Order ID</th>
                            <th>Author Name</th>
                            <th>Ship Date</th>
                            <th>Order Value (₹)</th>
                            <th>Handling charges (₹)</th>
                            <th>Courier Charges (₹)</th>
                            <th>To Pay (₹)</th>
                            <th>Payment Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($handlingCharges)): ?>
                            <?php foreach ($handlingCharges as $i => $row): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($row['order_id']) ?></td>
                                   
                                    <td><?= esc($row['author_name']) ?></td>
                                    <td><?= !empty($row['ship_date']) ? date('d-M-Y', strtotime($row['ship_date'])) : '-' ?></td>
                                    <td>₹<?= number_format($row['sub_total'], 2) ?></td>
                                    <td>₹<?= number_format($row['royalty'], 2) ?></td>
                                    <td>₹<?= number_format($row['courier_charges'], 2) ?></td>
                                    <td>₹<?= number_format(($row['courier_charges'] + $row['royalty']), 2) ?></td>
                                    <td>
                                        <?php if (strtolower($row['payment_status']) === 'paid'): ?>
                                            <span class="badge bg-success">Paid</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning"><?= ucfirst(esc($row['payment_status'] ?? 'Pending')) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= site_url('tppublisherdashboard/tporderfulldetails/' . rawurlencode($row['order_id'])) ?>" 
                                           class="btn btn-info btn-sm">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center">No data found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>

    <!-- Sales Section -->
<div class="card-header fw-bold fs-4">To Pay - Publisher</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sl No</th>
            <th>Create Date</th>
            <th>Sales Channel</th>
            <th>Qty</th>
            <th>Total Amount</th>
            <th>Discount</th>
            <th>To Pay</th>
            <th>Paid Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($sales)): ?>
            <?php foreach ($sales as $i => $row): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= esc($row['create_date']); ?></td>
                <td><?= esc($row['sales_channel']); ?></td>
                <td><?= esc($row['total_qty']); ?></td>
                <td>₹<?= number_format($row['total_amount'], 2) ?></td>
                <td>₹<?= number_format($row['total_discount'], 2) ?></td>
                <td>₹<?= number_format($row['total_author_amount'], 2) ?></td>
                <td>
                    <?= $row['paid_status'] == 'paid' 
                        ? '<span class="badge bg-success">Paid</span>' 
                        : '<span class="badge bg-warning">Unpaid</span>'; ?>
                </td>
                <td>
                    <a href="<?= site_url('tppublisherdashboard/tpsalesfull/' 
                            . rawurlencode($row['create_date']) . '/' 
                            . rawurlencode($row['sales_channel'])) ?>" 
                       class="btn btn-info btn-sm">
                        View
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="9" class="text-center">No sales found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</div>

<?= $this->endSection(); ?>
