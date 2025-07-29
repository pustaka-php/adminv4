<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
<script>
    let table = new DataTable("#dataTable");
</script>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?> 

<div class="card basic-data-table">
    <div class="d-flex justify-content-end mb-2">
        <a href="<?= base_url('tppublisher/tpsalesadd') ?>"
           class="btn rounded-pill btn-info-600 radius-8 px-20 py-11 text-sm">
           ADD SALES
        </a>
    </div>
    <div class="card-body">
        <?php if (!empty($sales_data)): ?>
        <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10">
            <thead>
                <tr>
                    <th scope="col" class="text-sm">S.No</th>
                    <th scope="col" class="text-sm">Book Title</th>
                    <th scope="col" class="text-sm">Sales Channel</th>
                    <th scope="col" class="text-sm">Paid Status</th>
                    <th scope="col" class="text-end text-sm">Qty Sold</th>
                    <th scope="col" class="text-end text-sm">Total Amount</th>
                    <th scope="col" class="text-end text-sm">Orders</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sales_data as $index => $row): ?>
                <tr>
                    <td class="text-sm"><?= $index + 1; ?></td>
                    <td class="text-sm"><?= esc($row->book_title); ?></td>
                    <td class="text-sm"><?= esc(ucwords($row->sales_channel)); ?></td>
                    <td class="text-sm">
                        <?php
                            $status = $row->paid_status;
                            echo $status == 1 ? '<span class="badge bg-success text-white">Paid</span>' :
                                 ($status == 0 ? '<span class="badge bg-danger text-white">Unpaid</span>' :
                                 '<span class="badge bg-warning text-dark">Unknown</span>');
                        ?>
                    </td>
                    <td class="text-end text-sm"><?= esc($row->total_qty); ?></td>
                    <td class="text-end text-sm">₹<?= number_format($row->total_amount, 2); ?></td>
                    <td class="text-end text-sm"><?= esc($row->total_orders); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p class="text-muted text-sm">No sales data found.</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection(); ?>
