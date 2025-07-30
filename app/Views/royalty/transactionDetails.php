<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
<script>
    function printInvoice() {
        var printContents = document.getElementById("invoice").innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }

    function clearForm() {
        document.getElementById("filterForm").reset();
        window.location.href = "<?= base_url('royalty/transactiondetails') ?>";
    }
</script>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<div class="card">
    <div class="card-body">
        <h1 class="text-lg mb-2"><?= esc($title) ?></h1>
        <h3 class="text-md mb-4"><?= esc($subTitle) ?></h3>

        <form method="GET" action="<?= base_url('royalty/transactiondetails') ?>" class="mb-4" id="filterForm">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="book_type" class="form-label">Book Type</label>
                    <select name="book_type" id="book_type" class="form-select" required>
                        <option value="">--Select--</option>
                        <option value="ebook" <?= (isset($_GET['book_type']) && $_GET['book_type'] == 'ebook') ? 'selected' : '' ?>>Ebook</option>
                        <option value="audiobook" <?= (isset($_GET['book_type']) && $_GET['book_type'] == 'audiobook') ? 'selected' : '' ?>>Audiobook</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="year" class="form-label">Year</label>
                    <select name="year" id="year" class="form-select" required>
                        <option value="">--Select--</option>
                        <?php
                        $startYear = 2013;
                        $endYear = date('Y');
                        for ($y = $endYear; $y >= $startYear; $y--) {
                            $selected = (isset($_GET['year']) && $_GET['year'] == $y) ? 'selected' : '';
                            echo "<option value=\"$y\" $selected>$y</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="" <?= (!isset($_GET['status']) || $_GET['status'] === '') ? 'selected' : '' ?>>Overall</option>
                        <option value="O" <?= (isset($_GET['status']) && $_GET['status'] == 'O') ? 'selected' : '' ?>>Outstanding</option>
                        <option value="P" <?= (isset($_GET['status']) && $_GET['status'] == 'P') ? 'selected' : '' ?>>Paid</option>
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Months</label>
                    <div class="d-flex flex-wrap gap-2">
                        <?php
                        $selectedMonths = $_GET['months'] ?? [];
                        for ($m = 1; $m <= 12; $m++) {
                            $monthName = date('F', mktime(0, 0, 0, $m, 10));
                            $checked = in_array($m, $selectedMonths) ? 'checked' : '';
                            echo "<div class='form-check d-flex align-items-center'>
                                    <input class='form-check-input me-2' type='checkbox' name='months[]' id='month$m' value=\"$m\" $checked>
                                    <label class='form-check-label mb-0' for='month$m'>$monthName</label>
                                </div>";
                        }
                        ?>
                    </div>
                </div>
                <br>
               <div class="col-md-12 d-flex gap-2 justify-content-end mt-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <button type="button" class="btn btn-secondary" onclick="clearForm()">Clear</button>
                </div>
            </div>
        </form>

        <hr class="my-8">

        <div id="invoice">
            <?php if (empty($transactions)) : ?>
                <p class="text-danger">No data found for the selected filters.</p>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>MONTH</th>
                                <th>CHANNEL</th>
                                <th>REVENUE</th>
                                <th>ROYALTY</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $month => $channels) : ?>
                                <?php foreach ($channels as $channel => $values) : ?>
                                    <tr>
                                        <td><?= $month ?></td>
                                        <td><?= ucfirst($channel) ?></td>
                                        <td><?= number_format($values['revenue'], 2) ?></td>
                                        <td><?= number_format($values['royalty'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
           </div>
              <div class="mt-4 d-flex gap-4 justify-content-end">
            <button type="button" class="btn btn-danger d-flex align-items-center gap-2" onclick="printInvoice()">
                <iconify-icon icon="basil:printer-outline" class="text-xl"></iconify-icon>
                <span>Print</span>
            </button>
            <?php endif; ?>
        </div>

        

    </div>
</div>

<?= $this->endSection(); ?>
