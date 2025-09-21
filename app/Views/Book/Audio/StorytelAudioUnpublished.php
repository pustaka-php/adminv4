<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
  <div class="layout-px-spacing">

    <div class="mt-3">
      <table class="table table-hover zero-config mt-3">
        <thead>
          <tr>
            <th>#</th>
            <th>Book ID</th>
            <th>Book Title</th>
            <th>Author</th>
            <th>EPUB URL</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($books)): ?>
            <?php foreach ($books as $i => $book): ?>
              <tr>
                <td><?= $i + 1 ?></td>
                <td><?= esc($book['book_id']) ?></td>
                <td><?= esc($book['book_title']) ?></td>
                <td><?= esc($book['author_name']) ?></td>
                <td>
                  <?php if (!empty($book['epub_url'])): ?>
                    <a href="<?= esc($book['epub_url']) ?>" target="_blank">
                      <?= esc($book['epub_url']) ?>
                    </a>
                  <?php else: ?>
                    <span class="text-muted">-</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" class="text-center text-muted">
                No unpublished Storytel audiobooks found for this language.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>
</div>

<?= $this->endSection(); ?>
