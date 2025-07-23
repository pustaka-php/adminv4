<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?> 
<script>
    const books = <?= json_encode($other_distribution['free']) ?>;
</script>
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="col-xl-12">
    <div class="card h-100 p-0">
        <div class="card-header border-bottom bg-base py-16 px-24">
            <h6 class="text-lg fw-semibold mb-0">Other Distribution</h6>
        </div>
        <div class="card-body p-24">
            <form method="post" action="<?= base_url('stock/other-distribution/save') ?>">
                <div class="row gy-4">

                    <!-- Book ID with datalist -->
                    <div class="col-lg-6 col-sm-12">
                        <div class="p-16 bg-info-50 radius-8 border-start-width-3-px border-info">
                            <label class="form-label fw-semibold">Book ID</label>
                            <input type="text" id="book_id" name="book_id" class="form-control" placeholder="Enter Book ID" list="book_id_list" autocomplete="off">
                            <datalist id="book_id_list">
                                <?php foreach ($other_distribution['free'] as $book): ?>
                                    <option value="<?= esc($book['book_id']) ?>"></option>
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                    </div>

                    <!-- Book Title with datalist -->
                    <div class="col-lg-6 col-sm-12">
                        <div class="p-16 bg-success-50 radius-8 border-start-width-3-px border-success-main">
                            <label class="form-label fw-semibold">Book Title</label>
                            <input type="text" id="book_title" name="book_title" class="form-control" placeholder="Enter Book Title" list="book_title_list" autocomplete="off">
                            <datalist id="book_title_list">
                                <?php foreach ($other_distribution['free'] as $book): ?>
                                    <option value="<?= esc($book['book_title']) ?>"></option>
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                    </div>

                    <!-- Type Dropdown -->
                    <div class="col-lg-6 col-sm-12">
                        <div class="p-16 bg-warning-50 radius-8 border-start-width-3-px border-warning-main">
                            <label class="form-label fw-semibold">Type</label>
                            <select name="type" id="type" class="form-select">
                                <option value="">-- Select Type --</option>
                                <option value="author_free_copy">Author Free Copy</option>
                                <option value="library_sample">Library Sample</option>
                                <option value="award_application">Award Application</option>
                                <option value="others">Others</option>
                            </select>
                        </div>
                    </div>

                    <!-- Purpose Dropdown (conditional) -->
                    <div class="col-lg-6 col-sm-12" id="purpose_container" style="display: none;">
                        <div class="p-16 bg-danger-50 radius-8 border-start-width-3-px border-danger-main">
                            <label class="form-label fw-semibold">Purpose</label>
                            <select name="purpose" class="form-select">
                                <option value="">-- Select Purpose --</option>
                                <option value="free_copy">Free Copy</option>
                                <option value="complimentary_copy">Complimentary Copy</option>
                                <option value="sample">Sample</option>
                                <option value="award_copy">Award Copy</option>
                            </select>
                        </div>
                    </div>
                    <!-- Quantity Input with Increment/Decrement -->
                    <!-- Quantity Input with Native Spinner -->
                    <div class="col-lg-6 col-sm-12">
                        <div class="p-16 bg-primary-50 radius-8 border-start-width-3-px border-primary-main">
                            <label class="form-label fw-semibold">Quantity</label>
                            <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1">
                        </div>
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="mt-24">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JS to show/hide purpose -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeDropdown = document.getElementById('type');
        const purposeContainer = document.getElementById('purpose_container');

        typeDropdown.addEventListener('change', function () {
            purposeContainer.style.display = this.value === 'others' ? 'block' : 'none';
        });
    });
    function changeQuantity(amount) {
        const qtyInput = document.getElementById('quantity');
        let current = parseInt(qtyInput.value) || 1;
        current += amount;
        if (current < 1) current = 1;
        qtyInput.value = current;
    }
</script>

<?= $this->endSection() ?>
