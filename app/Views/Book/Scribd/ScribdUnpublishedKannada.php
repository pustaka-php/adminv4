<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
  <div class="layout-px-spacing">

    <div class="mt-3">
        <table class="table table-hover zero-config mt-5" style="height: 300px;">
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
                // Safe arrays for unpublished kannada books
                $kannada_books  = $scribd['scribd_kannada_unpub_book_id'] ?? [];
                $titles       = $scribd['scribd_kannada_unpub_book_title'] ?? [];
                $authors      = $scribd['scribd_kannada_unpub_book_author_name'] ?? [];
                $epubs        = $scribd['scribd_kannada_unpub_book_epub_url'] ?? [];

                if (count($kannada_books) > 0):
                    for ($i = 0; $i < count($kannada_books); $i++):
                        $file_ext = !empty($epubs[$i]) ? substr($epubs[$i], strrpos($epubs[$i], '.') + 1) : '';
                ?>
                <tr>
                    <td><?= $kannada_books[$i]; ?></td>
                    <td><?= $titles[$i]; ?></td>
                    <td><?= $authors[$i]; ?></td>
                    <td><?= $file_ext; ?></td>
                </tr>
                <?php 
                    endfor;
                else: ?>
                <tr>
                    <td colspan="4" class="text-center">No unpublished kannada books found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

  </div>
</div>

<?= $this->endSection(); ?>
