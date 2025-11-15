<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center mb-3">
            <iconify-icon icon="mdi:book-plus-outline" class="text-primary fs-4 me-2"></iconify-icon>
            <h6 class="fw-bold mb-0">Add Book Details</h6>
        </div>

        <a href="<?= base_url('prospectivemanagement'); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            <form method="post" action="<?= base_url('prospectivemanagement/savebookdetails'); ?>">

                <div class="row g-4">

                    <!-- Prospector -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Prospector Name</label>
                        <select class="form-select" name="prospector_id" required>
                            <option value="">Select Prospector</option>
                            <?php foreach ($prospectors as $p): ?>
                                <option value="<?= $p['id']; ?>"><?= esc($p['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                      <!-- Payment Amount -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Payment Amount</label>
                        <input type="number" class="form-control" name="payment_amount" step="0.01" placeholder="Enter Amount" required>
                    </div>

                    
                    <!-- Title -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Book Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Enter Book Title" required>
                    </div>

                    <!-- Payment Status -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Payment Status</label>
                        <select class="form-select" name="payment_status" required>
                            <option value="">Select Status</option>
                            <option value="Paid">Paid</option>
                            <option value="Partial">Partial</option>
                        </select>
                    </div>


                    <!-- Plan -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Plan Name</label>
                        <select class="form-select" name="plan_name" required>
                            <option value="">Select Plan</option>
                            <option>Silver</option>
                            <option>Gold</option>
                            <option>Platinum</option>
                            <option>Rhodium</option>
                            <option>Silver++</option>
                            <option>Pearl</option>
                            <option>Sapphire</option>
                        </select>
                    </div>

                    <!-- Payment Date -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Payment Date</label>
                        <input type="date" class="form-control" name="payment_date" required>
                    </div>

                    <!-- Payment Description -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">Payment Description</label>
                        <textarea class="form-control" name="payment_description" rows="3" placeholder="Enter Payment Description"></textarea>
                    </div>

                    <!-- Remarks -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">Remarks</label>
                        <textarea class="form-control" name="remarks" rows="3" placeholder="Enter Remarks (if any)"></textarea>
                    </div>

                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        Save
                    </button>
                    <a href="<?= base_url('prospectors/inprogress'); ?>" class="btn btn-danger px-4">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection(); ?>
