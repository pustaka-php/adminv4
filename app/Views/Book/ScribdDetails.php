<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
  <div class="layout-px-spacing">

    <div class="page-header mb-4">
      <div class="page-title">
        <h3>Scribd Details</h3>
      </div>
    </div>

    <!-- Language Cards -->
    <div class="row g-3 text-center">
      <?php 
        $languages = [
          'tamil' => ['label' => 'Tamil', 'published' => 'scr_tml_cnt', 'unpublished' => 'scr_tml_unpub_cnt'],
          'kannada' => ['label' => 'Kannada', 'published' => 'scr_kan_cnt', 'unpublished' => 'scr_kan_unpub_cnt'],
          'telugu' => ['label' => 'Telugu', 'published' => 'scr_tel_cnt', 'unpublished' => 'scr_tel_unpub_cnt'],
          'malayalam' => ['label' => 'Malayalam', 'published' => 'scr_mlylm_cnt', 'unpublished' => 'scr_mlylm_unpub_cnt'],
          'english' => ['label' => 'English', 'published' => 'scr_eng_cnt', 'unpublished' => 'scr_eng_unpub_cnt']
        ];

        foreach($languages as $key => $lang):
      ?>
      <div class="col-md-4 col-lg-3">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h5 class="card-title"><?= $lang['label']; ?></h5>
            <p class="mb-2">
              <a href="<?= base_url('adminv3/scribd_published_'.$key); ?>" class="text-success text-decoration-none">
                Published: <?= $scribd[$lang['published']]; ?>
              </a>
            </p>
            <p>
              <a href="<?= base_url('adminv3/scribd_unpublished_'.$key); ?>" class="text-danger text-decoration-none">
                Unpublished: <?= $scribd[$lang['unpublished']]; ?>
              </a>
            </p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Excel Download Form -->
    <div class="row mt-5">
      <div class="col-md-8 mx-auto">
        <div class="card shadow-sm p-4">
          <form action="<?= base_url('scribd/scribd_excel'); ?>" method="post">
            <label for="book_ids" class="form-label">Book IDs (comma separated):</label>
            <textarea class="form-control mb-3" id="book_ids" name="book_ids" rows="3"></textarea>
            <button type="submit" class="btn btn-outline-secondary btn-lg w-100">Download Excel</button>
          </form>
        </div>
      </div>
    </div>

  </div>
</div>

<?= $this->endSection(); ?>
