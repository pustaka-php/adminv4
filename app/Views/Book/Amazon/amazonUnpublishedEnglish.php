<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid py-4">
    <div class="layout-px-spacing">

        <!-- Table Card -->
        <div class="card shadow-sm radius-8 border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10">
                        <thead>
                            <tr>
                                <th>Book ID</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($amazon['amz_eng_book_id'])): ?>
                                <?php for ($i = 0; $i < count($amazon['amz_eng_book_id']); $i++): ?>
                                    <tr>
                                        <td><?= esc($amazon['amz_eng_book_id'][$i]) ?></td>
                                        <td><?= esc($amazon['amz_eng_book_title'][$i]) ?></td>
                                        <td><?= esc($amazon['amz_eng_book_author_name'][$i]) ?></td>
                                        <td>
                                            <?= esc(pathinfo($amazon['amz_eng_book_epub_url'][$i], PATHINFO_EXTENSION)) ?>
                                        </td>
                                    </tr>
                                <?php endfor; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No records found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection(); ?>
