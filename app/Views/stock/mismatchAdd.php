<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<form method="post" action="<?= base_url('stock/mismatchsubmit') ?>" id="mismatchForm">
    <div class="row g-4">
        <?php foreach ($stocks as $row): ?>
            <?php
                // find mismatch log for this book_id
                $mismatchRow = [];
                if (!empty($mismatchLog)) {
                    foreach ($mismatchLog as $log) {
                        if ($log['book_id'] == $row['book_id']) {
                            $mismatchRow = $log;
                            break;
                        }
                    }
                }
            ?>

            <!-- Actual Stock Card -->
            <div class="col-xxl-6 col-md-6">
                <div class="card h-100 radius-12 bg-gradient-purple text-start">
                    <div class="card-body p-24">
                        <h6 class="mb-8">Actual Stock</h6>
                        <?php foreach ($row as $col => $val): ?>
                            <div class="d-flex align-items-center mb-3" style="gap: 25px;">
                                <label style="width: 200px; font-weight: bold;">
                                   <?= $col ?>:
                                </label>
                                <span><?= esc($val) ?></span>
                                <?php if ($col == 'book_id'): ?>
                                    <input type="hidden" name="book_id[]" value="<?= esc($val) ?>">
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Mismatch Stock Card -->
            <div class="col-xxl-6 col-md-6">
                <div class="card h-100 radius-12 bg-gradient-success text-start">
                    <div class="card-body p-24">
                        <h6 class="mb-8">Enter Mismatch Stock</h6>
                        <?php foreach ($row as $col => $val): ?>
                            <?php if (strtolower($col) == 'last_update' || strtolower($col) == 'last_update_date'): ?>
                                <?php continue; ?>
                            <?php endif; ?>

                            <div class="d-flex align-items-center mb-3" style="gap: 10px;">
                                <label style="width: 200px; font-weight: bold;">
                                    <?= $col ?>:
                                </label>

                                <?php if ($col == 'book_id'): ?>
                                    <span><?= esc($val) ?></span>
                                <?php else: ?>
                                    <?php
                                        // if mismatch log exists, use that, else empty
                                        $inputVal = isset($mismatchRow[$col]) ? $mismatchRow[$col] : '';
                                    ?>
                                    <input type="text" 
                                           name="mismatch[<?= $col ?>][]" 
                                           value="<?= esc($inputVal) ?>" 
                                           class="form-control form-control" 
                                           style="max-width: 200px;">
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary btn-lg">Save Changes</button>
        <button type="button" class="btn btn-secondary btn-lg" onclick="history.back()">Back</button>
    </div>
</form>

<!-- Disable Enter key submit -->
<script>
document.getElementById('mismatchForm').addEventListener('keydown', function(event) {
    if (event.key === "Enter" && event.target.tagName === "INPUT") {
        event.preventDefault(); // stop default submit
        return false;
    }
});
</script>

<?= $this->endSection(); ?>
