<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">

   <a href="<?= base_url('tppublisher') ?>" 
           class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    <div class="d-flex justify-content-end mb-3">
        <a href="<?= base_url('tppublisher/tpsalesadd') ?>" class="btn btn-info radius-8 px-20 py-11 text-sm">
            ADD SALES
        </a>
    </div>

  <div class="row g-4 mb-4">
    <!-- Total Sales -->
    <div class="col-md-6">
        <div class="card p-3 shadow-2 radius-8 h-100 bg-gradient-end-2">
            <div class="d-flex align-items-center gap-3 mb-2">
                <span class="w-48 h-48 bg-info-100 rounded-circle d-flex justify-content-center align-items-center">
                    <iconify-icon icon="mdi:book-open-page-variant" width="24" height="24" style="color:blue;"></iconify-icon>
                </span>

                <div>
                    <h6 class="fw-semibold mb-1"><?= ($publisher_data['total_sales'] ?? 0); ?></h6>
                    <span class="fw-medium text-secondary-light text-sm">Total Sales</span>
                </div>
            </div>
            <div class="d-flex gap-3 flex-wrap text-secondary-light fw-medium text-sm">
              <div class="d-grid" style="grid-template-columns: repeat(2, 1fr); gap: 8px;">
                    <div style="border-right: 1px solid #ccc; padding-right: 4px;">
                        <span><?= $publisher_data['qty_pustaka'] ?? 0 ?> Pustaka</span>
                    </div>
                    <div style="padding-left: 4px;">
                        <span><?= $publisher_data['qty_amazon'] ?? 0 ?> Amazon</span>
                    </div>
                    <div style="border-right: 1px solid #ccc; padding-right: 4px;">
                        <span><?= $publisher_data['qty_bookfair'] ?? 0 ?> Book Fair</span>
                    </div>
                    <div style="padding-left: 4px;">
                        <span><?= $publisher_data['qty_other'] ?? 0 ?> Others</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
    <!-- Card: Total Amount -->
<div class="col-md-6">
    <div class="card p-3 shadow-2 radius-8 h-100 bg-gradient-end-3">
        <div class="d-flex align-items-center gap-3 mb-3">
            <span class="w-48 h-48 bg-info-100 rounded-circle d-flex justify-content-center align-items-center">
                <iconify-icon icon="mdi:currency-inr" width="24" height="24" style="color:blue;"></iconify-icon>
            </span>
            <div>
                <h6 class="fw-semibold mb-1"><?= indian_format($salesSummary['total_author_amount'] ?? 0, 2); ?></h6>
                <span class="fw-medium text-secondary-light text-sm">To Pay</span>
            </div>
        </div>
       <div class="text-sm text-secondary-light d-flex flex-wrap gap-2 mb-1">
         <span>Total Amount: <?= indian_format($salesSummary['total_amount'] ?? 0, 2); ?></span>
    <span>|</span>
     <span>Discount: <?= indian_format($salesSummary['total_discount'] ?? 0, 2); ?></span>   
</div>
<div class="text-sm text-secondary-light d-flex flex-wrap gap-2">
    <span>Paid: <?= indian_format($salesSummary['paid_author_amount'] ?? 0, 2); ?></span>
    <span>|</span>
    <span>Pending: <?= indian_format($salesSummary['pending_author_amount'] ?? 0, 2); ?></span>
</div>

    </div>
</div>

</div>

    <!-- Tabs -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <ul class="nav nav-tabs" id="publisherTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#sales" role="tab">Sales</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#payments" role="tab">Payments</a>
                </li>
            </ul>

            <div class="tab-content p-3" id="publisherTabsContent">

                <!-- Sales Tab -->
                <div class="tab-pane fade show active" id="sales" role="tabpanel">
                    <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Sales Channel</th>
                                <th>No of Units</th>
                                <th>Total (₹)</th>
                                <th>Discount (₹)</th>
                                <th>To Pay (₹)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalQty = $totalAmount = $totalDiscount = $totalAuthor = 0;
                            ?>
                            <?php if (!empty($salespay)): ?>
                                <?php foreach ($paymentpay as $i => $row): ?>
                                    <?php
                                        $totalQty += (float)($row['total_qty'] ?? 0);
                                        $totalAmount += (float)($row['total_amount'] ?? 0);
                                        $totalDiscount += (float)($row['total_discount'] ?? 0);
                                        $totalAuthor += (float)($row['total_author_amount'] ?? 0);
                                    ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= esc($row['sales_channel']) ?></td>
                                        <td><?= number_format((int)$row['total_qty']) ?></td>
                                        <td><?= indian_format($row['total_amount'], 2) ?></td>
                                        <td><?= indian_format($row['total_discount'], 2) ?></td>
                                        <td><?= indian_format($row['total_author_amount'], 2) ?></td>
                                        <td>
                                            <a href="<?= site_url('tppublisher/tpsalesfull/' . rawurlencode($row['create_date']) . '/' . rawurlencode($row['sales_channel'])) ?>" 
                                               class="btn btn-info btn-sm radius-8 px-14 py-6 text-sm">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="fw-bold bg-light">
                                    <td colspan="2" class="text-end">Total</td>
                                    <td><?= $totalQty ?></td>
                                    <td><?= indian_format($totalAmount, 2) ?></td>
                                    <td><?= indian_format($totalDiscount, 2) ?></td>
                                    <td><?= indian_format($totalAuthor, 2) ?></td>
                                    <td></td>
                                </tr>
                            <?php else: ?>
                                <tr><td colspan="7" class="text-center">No sales found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Payments Tab -->
                <div class="tab-pane fade" id="payments" role="tabpanel">
                    <!-- Pending Payments -->
                    <h5>UnPaid Payments</h5>
                    <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10">
                        <thead>
                            <tr>
                                <th>Create Date</th>
                                <th>Sales Channel</th>
                                <th>Qty</th>
                               <th>Total (₹)</th>
                                <th>Discount (₹)</th>
                                <th>To Pay (₹)</th>
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $hasUnpaid = false; ?>
                            <?php foreach ($paymentpay as $row): ?>
                                <?php if (($row['paid_status'] ?? '') === 'pending'): ?>
                                    <?php $hasUnpaid = true; ?>
                                    <tr id="salesRow<?= esc($row['create_date'] . '_' . $row['sales_channel']) ?>">
                                        <td><?= date('d-m-y', strtotime($row['create_date'])) ?></td>
                                        <td><?= esc($row['sales_channel']) ?></td>
                                        <td><?= indian_format($row['total_qty'], 0) ?></td>
                                        <td><?= indian_format($row['total_amount'], 2); ?></td>
                                        <td><?= indian_format($row['total_discount'], 2); ?></td>
                                        <td><?= indian_format($row['total_author_amount'], 2); ?></td>
                                        <td><span class="badge bg-warning">Pending</span></td>
                                        <td>
                                            <a class="btn btn-info btn-sm radius-8 px-12 py-4 text-sm"
                                               href="<?= site_url('tppublisher/tpsalesfull/' . rawurlencode($row['create_date']) . '/' . rawurlencode($row['sales_channel'])) ?>">
                                                Details
                                            </a>
                                            <button type="button" class="btn btn-success btn-sm radius-8 px-12 py-4 text-sm"
                                                onclick="markSalesPaid('<?= esc($row['create_date']) ?>','<?= esc($row['sales_channel']) ?>')">
                                                Paid
                                            </button>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?php if (!$hasUnpaid): ?>
                                <tr><td colspan="8" class="text-center text-muted">No unpaid sales found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <!-- Paid Payments -->
                    <h5 class="mt-5">Paid Payments</h5>
                    <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10">
                        <thead>
                            <tr>
                                <th>Create Date</th>
                                <th>Sales Channel</th>
                                <th>Qty</th>
                                <th>Total (₹)</th>
                                <th>Discount (₹)</th>
                                <th>To Pay (₹)</th>
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $hasPaid = false; ?>
                            <?php foreach ($paymentpay as $row): ?>
                                <?php if (($row['paid_status'] ?? '') === 'paid'): ?>
                                    <?php $hasPaid = true; ?>
                                    <tr>
                                        <td><?= date('d-m-y', strtotime($row['create_date'])) ?></td>
                                        <td><?= esc($row['sales_channel']) ?></td>
                                        <td><?= indian_format($row['total_qty'], 0) ?></td>
                                        <td><?= indian_format($row['total_amount'], 2); ?></td>
                                        <td><?= indian_format($row['total_discount'], 2); ?></td>
                                        <td><?= indian_format($row['total_author_amount'], 2); ?></td>
                                        <td><span class="badge bg-success">Paid</span></td>
                                        <td>
                                            <a class="btn btn-info btn-sm radius-8 px-12 py-4 text-sm"
                                               href="<?= site_url('tppublisher/tpsalesfull/' . rawurlencode($row['create_date']) . '/' . rawurlencode($row['sales_channel'])) ?>">
                                               Details
                                            </a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?php if (!$hasPaid): ?>
                                <tr><td colspan="8" class="text-center text-muted">No paid sales found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>


<!-- AJAX Mark Paid -->
<script>
    const csrfName = '<?= csrf_token() ?>';
    const csrfHash = '<?= csrf_hash() ?>';
    function markSalesPaid(create_date, sales_channel) {
        if (!confirm('Mark this sale as Paid?')) return;

        $.post("<?= base_url('tppublisher/tpsalespaid') ?>", {
            create_date: create_date,
            sales_channel: sales_channel,
            [csrfName]: csrfHash
        }, function(response) {
            if (response.status === 'success') {
                alert(response.message || 'Paid Successfully.');
                location.reload();
            } else {
                alert(response.message || 'Failed to mark as Paid.');
            }
        }, 'json').fail(function(xhr) {
            alert('AJAX error: ' + xhr.statusText);
        });
    }
    
</script>

<?= $this->endSection(); ?>
