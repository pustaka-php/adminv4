<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">

    <?php if (!empty($ledgerData)): ?>
        <!-- Card View for Book Details -->
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title mb-3">Book Details</h5>
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <strong>Publisher:</strong> <?= esc($ledgerData[0]['publisher_name'] ?? 'N/A') ?>
                    </div>
                    <div class="col-md-3 mb-2">
                        <strong>Book Title:</strong> <?= esc($ledgerData[0]['book_title'] ?? 'N/A') ?>
                    </div>
                    <div class="col-md-3 mb-2">
                        <strong>SKU No:</strong> <?= esc($ledgerData[0]['sku_no'] ?? 'N/A') ?>
                    </div>
                    <div class="col-md-3 mb-2">
                        <strong>Description:</strong> <?= esc($ledgerData[0]['description'] ?? 'N/A') ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table View for Ledger Transactions -->
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title mb-3">Transaction Details</h5>
                <table class="table table-hover zero-config data-page-length=10">
                    <thead>
                        <tr>
                            <th>Transaction Date</th>
                            <th>Stock In</th>
                            <th>Stock Out</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ledgerData as $row): ?>
                            <tr>
                                <td><?= esc($row['transaction_date'] ?? 'N/A') ?></td>
                                <td><?= esc($row['stock_in'] ?? 0) ?></td>
                                <td><?= esc($row['stock_out'] ?? 0) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php else: ?>
        <p>No records found for this book and type.</p>
    <?php endif; ?>
</div>

<?= $this->endSection(); ?>
