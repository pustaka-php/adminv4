<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">

    <!-- Handling Charges Section -->
    <div class="card mb-4">
        <div class="card-header fw-bold">Handling Charges - Pustaka</div>
        <div class="card-body p-0">
            <div class="table-responsive">
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
                        <?php if (!empty($handlingCharges)): ?>
                            <?php foreach ($handlingCharges as $i => $row): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($row['order_id']) ?></td>
                                    <td><?= esc($row['author_name']) ?></td>
                                    <td>₹<?= number_format($row['sub_total'], 2) ?></td>
                                    <td>₹<?= number_format($row['royalty'], 2) ?></td>
                                    <td>₹<?= number_format($row['courier_charges'], 2) ?></td>
                                    <td>
                                        <?php if (strtolower($row['payment_status']) === 'paid'): ?>
                                            <span class="badge bg-success">Paid</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger"><?= esc($row['payment_status']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No handling charges data found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>

    <!-- Pay to Author Section -->
    <div class="card">
        <div class="card-header fw-bold">Pay to Author - Sales</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10"> 
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Sales Channel</th>
                            <th>Author Name</th>
                            <th>Total Amount (₹)</th>
                            <th>Discount</th>
                            <th>Pay To Author (₹)</th>
                            <th>Paid Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($payAuthor)): ?>
                            <?php foreach ($payAuthor as $i => $row): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($row['sales_channel']) ?></td>
                                    <td><?= esc($row['author_name']) ?></td>
                                    <td>₹<?= number_format($row['total_amount'], 2) ?></td>
                                    <td><?= esc($row['discount']) ?></td>
                                    <td>₹<?= number_format($row['author_amount'], 2) ?></td>
                                    <td>
                                        <?php if (strtolower($row['paid_status']) === 'paid'): ?>
                                            <span class="badge bg-success">Paid</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger"><?= esc($row['paid_status']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No sales data found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>
