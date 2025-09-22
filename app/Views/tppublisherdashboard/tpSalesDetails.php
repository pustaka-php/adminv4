<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            
                    <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10"> 
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Create Date</th>
                            <th>Sales In</th>
                            <th>No of Units</th>
                            <th>Order Value (₹)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalQty = 0;
                        $totalAmount = 0;
                        $totalDiscount = 0;
                        $totalAuthor = 0;
                        ?>
                        <?php if (!empty($sales)): ?>
                            <?php foreach ($sales as $i => $row): ?>
                                <?php
                                    $totalQty += (float) ($row['total_qty'] ?? 0);
                                    $totalAmount += (float) ($row['total_amount'] ?? 0);
                                    $totalDiscount += (float) ($row['discount'] ?? 0);
                                    $totalAuthor += (float) ($row['author_amount'] ?? 0);
                                ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= !empty($row['create_date']) ? date('d-M-Y', strtotime($row['create_date'])) : '-' ?></td>
                                    <td><?= esc($row['sales_channel']) ?></td>
                                    <td><?= esc($row['total_qty']) ?></td>
                                    <td>₹<?= number_format($row['total_amount'], 2) ?></td>
                                    <td>₹<?= number_format($row['discount'], 2) ?></td>
                                    <td>₹<?= number_format($row['author_amount'], 2) ?></td>
                                     <td>
                                        <a href="<?= site_url('tppublisherdashboard/tpsalesfull/' 
                                            . rawurlencode($row['create_date']) . '/' 
                                            . rawurlencode($row['sales_channel'])) ?>" 
                                        class="btn btn-sm btn-success-600 rounded-pill">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <!-- Totals row -->
                            <tr class="fw-bold bg-light">
                                <td colspan="2" class="text-end">Total</td>
                                <td><?= $totalQty ?></td>
                                <td>₹<?= number_format($totalAmount, 2) ?></td>
                                <td>₹<?= number_format($totalDiscount, 2) ?></td>
                                <td>₹<?= number_format($totalAuthor, 2) ?></td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Sales Data Not Found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
       
    </div>
</div>

<?= $this->endSection(); ?>
