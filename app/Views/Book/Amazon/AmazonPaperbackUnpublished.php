<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <?php 
        foreach ($amazon as $langName => $books): 
        ?>
            <div class="table-responsive">
                <table class="table table-hover zero-config mt-5" style="height: 300px;">
                    <thead class="table-light">
                        <tr>
                            <th>Book ID</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Paperback Cost</th>
                            <th>Paperback Activated at</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($books)): ?>
                            <?php foreach ($books as $book): ?>
                                <tr>
                                    <td><?= esc($book['book_id']) ?></td>
                                    <td><?= esc($book['book_title']) ?></td>
                                    <td><?= esc($book['author_name']) ?></td>
                                    <td>
                                        <?= $book['paper_back_inr'] ? '₹' . number_format($book['paper_back_inr'], 2) : '-' ?>
                                    </td>

                                    <td>
                                        <?= $book['paperback_activate_at'] 
                                            ? date('d-m-Y', strtotime($book['paperback_activate_at'])) 
                                            : '-' ?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No unpublished books in <?= ucfirst($langName) ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>

    </div>
</div>

<?= $this->endSection(); ?>
