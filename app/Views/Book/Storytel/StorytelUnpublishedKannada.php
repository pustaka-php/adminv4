<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
  <div class="layout-px-spacing">
    <div class="mt-3">
        <table class="table table-hover zero-config mt-3" style="height: 300px;">
            <thead>
                <tr>
                    <th>Book ID</th>
                    <th>Name</th>
                    <th>Author</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $books = $storytel['scr_kannada_unpub_books'] ?? [];

                if (!empty($books)):
                    foreach ($books as $book):
                        $file_ext = !empty($book['epub_url']) ? pathinfo($book['epub_url'], PATHINFO_EXTENSION) : '';
                ?>
                <tr>
                    <td><?= esc($book['book_id']); ?></td>
                    <td><?= esc($book['book_title']); ?></td>
                    <td><?= esc($book['author_name']); ?></td>
                    <td><?= esc($file_ext); ?></td>
                </tr>
                <?php 
                    endforeach;
                else: ?>
                <tr>
                    <td colspan="4" class="text-center">No unpublished Kannada books found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>
