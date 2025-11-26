<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <h4 class="text-center mb-4">Bulk Stock Upload</h4>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <!-- Sample Upload Format Image -->
    <div class="text-center mb-4">
        <h6 class="fw-semibold mb-2">Sample Upload File Format</h6>

        <div class="border radius-12 overflow-hidden d-inline-block shadow-sm">
            <img src="<?= base_url('assets/images/bulk-stock-sample.png') ?>" 
                 alt="Sample Excel Format" 
                 class="img-fluid"
                 style="max-width: 600px;">
        </div>

        <p class="text-muted small mt-2 mb-0">
            Follow this format when uploading your Excel file.
        </p>
    </div>

    <div class="card shadow p-4">
        <form action="<?= base_url('stock/upload'); ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>

            <div class="mb-3">
                <label class="form-label">Upload Excel File (.xlsx)</label>
                <input type="file" name="excel_file" required class="form-control">
                <small class="text-muted">Columns Required: book_id, qty_add, qty_lost (optional)</small>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Upload & Process</button>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>
