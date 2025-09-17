<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
  <div class="layout-px-spacing">
    <div class="mt-3">

        <table class="table table-hover zero-config mt-4">
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
                    // Correct key from model
                    $malayalamBooks = $pratilipi['prat_mlylm_unpublished'] ?? [];

                    if (!empty($malayalamBooks)):
                        foreach ($malayalamBooks as $book):
                            $file_ext = !empty($book['epub_url']) 
                                ? pathinfo($book['epub_url'], PATHINFO_EXTENSION) 
                                : '';
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
                        <td colspan="4" class="text-center">No unpublished Malayalam books found.</td>
                    </tr>
                    <?php endif; ?>

            </tbody>
        </table>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>
