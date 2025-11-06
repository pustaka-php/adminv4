<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">
    <div class="d-flex align-items-center mb-3">
        <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
            <iconify-icon icon="mdi:cash-fast" class="fs-4 text-primary"></iconify-icon>
        </div>
        <h5 class="fw-bold mb-0 text-primary">Enter Payment Details</h5>
    </div>

    <form action="<?= base_url('prospectivemanagement/savePayment/' . $prospect['id']); ?>" method="post">
        <div class="card mb-3">
            <div class="card-header bg-light fw-semibold py-2">Titles & Payment Information</div>
            <div class="card-body py-3">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">No. of Titles</label>
                        <input type="number" name="no_of_title" class="form-control" value="<?= esc($prospect['no_of_title'] ?? ''); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="titles" class="form-control" value="<?= esc($prospect['titles'] ?? ''); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Payment Status</label>
                        <select name="payment_status" class="form-select" required>
                            <option value="">-- Select --</option>
                            <?php foreach (['paid', 'pending', 'partial'] as $status): ?>
                                <option value="<?= $status; ?>" <?= ($prospect['payment_status'] == $status) ? 'selected' : ''; ?>>
                                    <?= ucfirst($status); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Payment Amount (₹)</label>
                        <input type="number" name="payment_amount" class="form-control" value="<?= esc($prospect['payment_amount'] ?? ''); ?>" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Payment Date</label>
                        <input type="date" name="payment_date" class="form-control" value="<?= esc($prospect['payment_date'] ?? ''); ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Payment Description</label>
                        <textarea name="payment_description" class="form-control" rows="2"><?= esc($prospect['payment_description'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-success rounded-pill px-4">
                Save Payment
            </button>
            <a href="<?= base_url('prospectivemanagement/dashboard'); ?>" class="btn btn-outline-secondary rounded-pill ms-2">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection(); ?>
