<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>

<!-- LOST STOCK TABLE -->
<div class="card basic-data-table mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Lost Stock Details</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="zero-config table table-hover mt-4"> 
                <thead>
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th style="width: 90px;">Book ID</th>
                        <th style="max-width: 200px;">Book Title</th>
                        <th style="max-width: 200px;">Author</th>
                        <th style="width: 30px;">Lost Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($loststock_details['loststock'])) : ?>
                        <?php $i = 1; foreach ($loststock_details['loststock'] as $row): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= esc($row['book_id']) ?></td>
                                <td title="<?= esc($row['book_title']) ?>">
                                    <?= esc($row['book_title']) ?>
                                </td>
                                <td title="<?= esc($row['author_name']) ?> - <?= esc($row['author_id']) ?>">
                                    <?= esc($row['author_name']) ?> - <?= esc($row['author_id']) ?>
                                </td>
                                <td style="text-align: center;"><?= esc($row['lost_qty']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center">No lost stock found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div><br>

<!-- EXCESS STOCK TABLE -->
<div class="card basic-data-table">
    <div class="card-header">
        <h5 class="card-title mb-0">Excess Stock Details</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="zero-config table table-hover mt-4"> 
                <thead>
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th style="width: 90px;">Book ID</th>
                        <th style="max-width: 200px;">Book Title</th>
                        <th style="max-width: 200px;">Author</th>
                        <th style="width: 30px;">Excess Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($loststock_details['excessstock'])) : ?>
                        <?php $i = 1; foreach ($loststock_details['excessstock'] as $row): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= esc($row['book_id']) ?></td>
                                <td title="<?= esc($row['book_title']) ?>">
                                    <?= esc($row['book_title']) ?>
                                </td>
                                <td title="<?= esc($row['author_name']) ?> - <?= esc($row['author_id']) ?>">
                                    <?= esc($row['author_name']) ?> - <?= esc($row['author_id']) ?>
                                </td>
                                <td style="text-align: center;"><?= esc($row['excess_qty']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center">No excess stock found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        new DataTable('.zero-config');
    });
</script>
<?= $this->endSection(); ?>
