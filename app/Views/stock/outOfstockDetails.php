<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>
<div class="card basic-data-table">
    <div class="card-header">
        <h5 class="card-title mb-0 text-center">Out of Stock Details</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table bordered-table mb-0" id="stockOutTable" data-page-length='7'>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Author ID</th>
                        <th>Author Name</th>
                        <th>Book ID</th>
                        <th style="width: 200px;">Book Title</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($stockout_details['stockout'])): ?>
                        <?php $i = 1; foreach ($stockout_details['stockout'] as $item): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= esc($item['author_id']) ?></td>
                                <td><?= esc($item['author_name']) ?></td>
                                <td><?= esc($item['book_id']) ?></td>
                                <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= esc($item['book_title']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No out-of-stock books found.</td>
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
            new DataTable('#stockOutTable');
        });
    </script>
<?= $this->endSection(); ?>
