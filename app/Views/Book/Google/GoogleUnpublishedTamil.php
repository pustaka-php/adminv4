<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
  <div class="layout-px-spacing">

    <div class="mt-3">
        <table class="table table-hover zero-config mt-5">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Book ID</th>
                    <th>Name</th>
                    <th>Author</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $tamil_books = $unpublishedBooks ?? [];

                if (!empty($tamil_books)):
                    foreach($tamil_books as $i => $book):
                        $file_ext = !empty($book['epub_url']) 
                            ? pathinfo($book['epub_url'], PATHINFO_EXTENSION) 
                            : '-';
                ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($book['book_id']); ?></td>
                        <td><?= esc($book['book_title']); ?></td>
                        <td><?= esc($book['author_name']); ?></td>
                        <td><?= $file_ext; ?></td>
                    </tr>
                <?php 
                    endforeach;
                else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No unpublished Tamil books found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

  </div>
</div>

<?= $this->endSection(); ?>
