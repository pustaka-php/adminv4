<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 

<?php
// ---------------------------------------
// CREATE SUMMARY (Publisher-wise totals)
// ---------------------------------------
$summary = [];

foreach ($details as $row) {
    $pub = $row['publisher_name'];

    if (!isset($summary[$pub])) {
        $summary[$pub] = [
            'books'  => 0,
            'amount' => 0
        ];
    }

    $summary[$pub]['books'] += 1;
    $summary[$pub]['amount'] += floatval($row['amount']);
}
?>

<div class="d-flex flex-column gap-32 mt-32">

    <!-- Header + Back Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center justify-content-center">
            <h5 class="fw-bold mb-0 text-center">
                <?= esc($details[0]['month_name'] ?? '') ?> - <?= count($details) ?> Pending Invoice Books
            </h5>
        </div>
        <a href="<?= base_url('pod/invoice'); ?>" class="btn btn-outline-secondary btn-sm d-flex align-items-center shadow-sm">
            <iconify-icon icon="mdi:arrow-left" class="me-1 fs-5"></iconify-icon> Back
        </a>
    </div>

    <!-- ============================
         SUMMARY TABLE (NEW)
    ============================= -->
    <div class="d-flex justify-content-center mb-4">
    <div class="col-xl-6 col-lg-7 col-md-8 col-sm-10 col-12">
        <div class="widget-two">
            <div class="widget-content">
                <h6 class="fw-bold mb-3 text-center">Summary</h6>

                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>Publisher Name</th>
                            <th>Total Books</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($summary as $publisher => $row): ?>
                            <tr>
                                <td><?= $publisher ?></td>
                                <td><?= $row['books'] ?></td>
                                <td><?= indian_format($row['amount'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

    <!-- ============================
         MAIN TABLE (YOUR ORIGINAL)
    ============================= -->
    <div class="col-xl-12 col-lg-10 col-md-10 col-sm-10 col-12 layout-spacing">
        <div class="widget-two">
            <div class="widget-content">				
                <div class="table-responsive">
                    <table class="table zero-config">
                        <thead>
                            <tr>
                                <th><div class="th-content">S.NO</div></th>
                                <th><div class="th-content">Publisher Name</div></th>
                                <th><div class="th-content">Book Title</div></th>
                                <th><div class="th-content">Invoice Number</div></th>
                                <th><div class="th-content">Amount</div></th>
                                <th><div class="th-content">Invoice Date</div></th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php  
                            $i=1;
                            foreach ($details as $monthly_invoice) {
                        ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><p><?= $monthly_invoice['publisher_name']; ?></p></td>
                                <td><p><?= $monthly_invoice['book_title']; ?></p></td>
                                <td><p><?= $monthly_invoice['invoice_number']; ?></p></td>
                                <td><p><?= $monthly_invoice['amount']; ?></p></td>
                                <td><p><?= date("d-m-Y", strtotime($monthly_invoice['invoice_date'])); ?></p></td>
                            </tr>
                        <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>
