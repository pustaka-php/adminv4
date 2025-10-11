<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<form method="post" 
      action="<?= ($actionType === 'validate') ? base_url('stock/mismatchvalidate') : base_url('stock/mismatchsubmit') ?>" 
      id="mismatchForm">

    <input type="hidden" name="redirect_url" value="<?= base_url('stock/getmismatchstock') ?>">

    <div class="row g-4">
        <?php foreach ($stocks as $row): ?>
            <?php
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

            <!-- Actual Stock -->
            <div class="col-xxl-6 col-md-6">
                <div class="card h-100 radius-12 bg-gradient-purple text-start">
                    <div class="card-body p-24">
                        <h6 class="mb-8">Actual Stock</h6>
                        <?php foreach ($row as $col => $val): ?>
                            <div class="d-flex align-items-center mb-3" style="gap: 25px;">
                                <label style="width: 200px; font-weight: bold;">
                                   <?= esc($col) ?>:
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

            <!-- Mismatch Stock -->
            <div class="col-xxl-6 col-md-6">
                <div class="card h-100 radius-12 bg-gradient-success text-start">
                    <div class="card-body p-24">
                        <h6 class="mb-8">
                            <?= ($actionType === 'validate') ? 'Validate Mismatch Stock' : 'Enter Mismatch Stock' ?>
                        </h6>

                        <?php foreach ($row as $col => $val): ?>
                            <?php if (strtolower($col) == 'last_update' || strtolower($col) == 'last_update_date') continue; ?>

                            <div class="d-flex align-items-center mb-3" style="gap: 10px;">
                                <label style="width: 200px; font-weight: bold;"><?= esc($col) ?>:</label>

                                <?php if ($col == 'book_id'): ?>
                                    <span><?= esc($val) ?></span>
                                <?php else: ?>
                                    <?php
                                        $inputVal = isset($mismatchRow[$col]) ? $mismatchRow[$col] : '';
                                    ?>
                                    <input type="text" 
                                           name="mismatch[<?= esc($col) ?>][]" 
                                           value="<?= esc($inputVal) ?>" 
                                           class="form-control" 
                                           style="max-width: 200px;"
                                           <?= ($actionType === 'validate') ? 'readonly' : '' ?>>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>

                        <!-- 🗒 Comment box -->
                        <div class="mt-4">
                            <label style="font-weight: bold;">Comment / Remarks:</label>
                            <textarea name="comments[]" 
                                      class="form-control mt-2" 
                                      rows="3" 
                                      placeholder="<?= ($actionType === 'validate') ? 'Add validation remarks...' : 'Add mismatch remarks...' ?>"><?= isset($mismatchRow['comments']) ? esc($mismatchRow['comments']) : '' ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="mt-4 text-center">
        <?php if ($actionType === 'validate'): ?>
            <?php if (session()->get('user_type') == 4): ?>
                <button type="submit" class="btn btn-success btn-lg">Validate</button>
            <?php else: ?>
                <button type="button" class="btn btn-success btn-lg" disabled title="Not allowed">Validate</button>
            <?php endif; ?>
        <?php else: ?>
            <button type="submit" class="btn btn-primary btn-lg">Mismatch Update</button>
        <?php endif; ?>
        <button type="button" class="btn btn-secondary btn-lg" onclick="history.back()">Back</button>
    </div>
</form>

<script>
document.getElementById('mismatchForm').addEventListener('keydown', function(event) {
    if (event.key === "Enter" && event.target.tagName === "INPUT") {
        event.preventDefault();
    }
});
</script>

<?= $this->endSection(); ?>
