<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>

<div id="content" class="main-content">
  <div class="layout-px-spacing">

    <div class="page-header mb-3">
      <div class="page-title">
        <h4>Amazon Unpublished Books - Malayalam</h4>
      </div>
    </div>

    <div class="card shadow-sm">
      <div class="card-body">
        <div class="table-responsive">
          <table class="zero-config table table-hover mt-4" id="dataTable" data-page-length="10">
            <thead class="table-dark">
              <tr>
                <th>Book ID</th>
                <th>Name</th>
                <th>Author</th>
                <th>Type</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($amazon['amz_mlylm_book_id'])): ?>
                <?php for ($i = 0; $i < sizeof($amazon['amz_mlylm_book_id']); $i++): ?>
                  <tr>
                    <td><?= esc($amazon['amz_mlylm_book_id'][$i]) ?></td>
                    <td><?= esc($amazon['amz_mlylm_book_title'][$i]) ?></td>
                    <td><?= esc($amazon['amz_mlylm_book_author_name'][$i]) ?></td>
                    <td><?= esc(substr($amazon['amz_mlylm_book_epub_url'][$i], strrpos($amazon['amz_mlylm_book_epub_url'][$i], '.')+1)) ?></td>
                  </tr>
                <?php endfor; ?>
              <?php else: ?>
                <tr>
                  <td colspan="4" class="text-center text-muted">No Malayalam Books Found</td>
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


