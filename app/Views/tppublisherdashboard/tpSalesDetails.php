<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
               <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Sales Channel</th>
                            <th>Sales Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($sales)): ?>
                            <?php foreach ($sales as $i => $row): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($row['sales_channel']) ?></td>
                                    <td><?= esc($row['total_qty']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No sales data found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
