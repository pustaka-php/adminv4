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
                $english_books  = $google['scr_english_book_id'] ?? [];
                $titles         = $google['scr_english_book_title'] ?? [];
                $authors        = $google['scr_english_book_author_name'] ?? [];
                $epubs          = $google['scr_english_book_epub_url'] ?? [];

                if (!empty($english_books)):
                    foreach($english_books as $i => $book_id):
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
                        <td colspan="5" class="text-center">No unpublished english books found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

  </div>
</div>

<?= $this->endSection(); ?>
