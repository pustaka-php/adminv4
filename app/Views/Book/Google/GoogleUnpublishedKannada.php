<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
  <div class="layout-px-spacing">

    <div class="mt-3">
        <table class="table table-hover zero-config mt-5" style="height: 300px;">
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
                $kannada_books  = $google['scr_kannada_book_id'] ?? [];
                $titles         = $google['scr_kannada_book_title'] ?? [];
                $authors        = $google['scr_kannada_book_author_name'] ?? [];
                $epubs          = $google['scr_kannada_book_epub_url'] ?? [];

                if (!empty($kannada_books)):
                    foreach($kannada_books as $i => $book_id):
                        $file_ext = !empty($epubs[$i]) ? pathinfo($epubs[$i], PATHINFO_EXTENSION) : '-';
                ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($book_id); ?></td>
                        <td><?= esc($titles[$i] ?? ''); ?></td>
                        <td><?= esc($authors[$i] ?? ''); ?></td>
                        <td><?= $file_ext; ?></td>
                    </tr>
                <?php 
                    endforeach;
                else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No unpublished Kannada books found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

  </div>
</div>

<?= $this->endSection(); ?>
