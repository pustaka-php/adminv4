<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">

    <!-- Title + Back Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <iconify-icon icon="mdi:book-edit-outline" class="text-warning me-2" style="font-size: 1.8rem;"></iconify-icon>
            <h4 class="fw-bold text-warning mb-0">
                Edit Book - <?= esc($book['title']); ?>
            </h4>
        </div>

        <a href="<?= base_url('prospectivemanagement/dashboard'); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fa fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <!-- Last Updated Info -->
    <?php if (!empty($book['create_date'])): ?>
    <div class="mb-3 text-muted small">
        Last Updated: <?= date('d-m-y', strtotime($book['create_date'])); ?>
    </div>
    <?php endif; ?>


    <!-- Edit Form -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-gradient-warning text-white py-3">
            <h6 class="mb-0 fw-semibold">
                <iconify-icon icon="mdi:book-open-variant" class="me-2 fs-5"></iconify-icon>
                Book Information
            </h6>
        </div>

        <div class="card-body">
           <form action="<?= base_url('prospectivemanagement/updatebook/' . $book['prospector_id'] . '/' . urlencode($book['title'])); ?>" method="post">
                <?= csrf_field(); ?>

                <div class="row gy-3">
                   <div class="col-md-6">
                        <label class="form-label fw-semibold">Book Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="<?= esc($book['title']); ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Plan Name</label>
                        <select class="form-select" name="plan_name" required>
                            <option value="">Select Plan</option>
                            <?php 
                            $plans = ['Silver', 'Gold', 'Platinum', 'Rhodium', 'Silver++', 'Pearl', 'Sapphire'];
                            foreach ($plans as $planOption): 
                            ?>
                                <option value="<?= esc($planOption) ?>" 
                                    <?= ($book['plan_name'] ?? '') === $planOption ? 'selected' : '' ?>>
                                    <?= esc($planOption) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Payment Status</label>
                        <select name="payment_status" class="form-select">
                            <?php
                            $statuses = ['Paid', 'Partial', 'Pending'];
                            $current = $book['payment_status'] ?? '';
                            foreach ($statuses as $status):
                            ?>
                                <option value="<?= $status ?>" <?= strcasecmp($current, $status) === 0 ? 'selected' : '' ?>>
                                    <?= $status ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Payment Amount (₹)</label>
                        <input type="number" name="payment_amount" step="0.01" class="form-control" value="">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Payment Date</label>
                        <input type="date" name="payment_date" class="form-control" value="<?= esc($book['payment_date']); ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Payment Description</label>
                        <textarea name="payment_description" class="form-control" rows="3"><?= esc($book['payment_description'] ?? ''); ?></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Remarks / Notes</label>
                        <textarea name="remarks" class="form-control" rows="3"><?= esc($book['remarks'] ?? ''); ?></textarea>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save me-1"></i> Save Changes
                    </button>
                    <a href="<?= base_url('prospectivemanagement/dashboard'); ?>" class="btn btn-secondary">
                        <i class="fa fa-times me-1"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
