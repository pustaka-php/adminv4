<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>
<div class="container py-4">
    <div class="card">
        <div class="card-body table-responsive">
            <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>SKU No</th>
                        <th>Book Title</th>
                        <th>MRP</th>
                        <th>ISBN</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($books)) : ?>
                        <?php $i = 1; foreach ($books as $book): ?>
                            <tr>
                                <td><?= $i++ ?></td> 
                                <td><?= esc($book['sku_no']) ?></td>
                                <td><?= esc($book['book_title']) ?></td>
                                <td>₹<?= esc($book['mrp']) ?></td>
                                <td><?= esc($book['isbn']) ?></td>
                                <td>
                                    <a href="<?= site_url('tppublisherdashboard/tpbookfulldetails/'.$book['book_id']) ?>" 
                                       class="btn btn-success-600 text-success-100 radius-8 px-14 py-6 text-sm">
                                        View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center">No books found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
