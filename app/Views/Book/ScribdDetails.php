<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
  <div class="row">

    <!-- Language Cards Section -->
    <div class="col-12 mb-4">
      <div class="row">
        <?php 
        $languages = [
          'tamil' => ['label' => 'Tamil', 'published' => 'scr_tml_cnt', 'unpublished' => 'scr_tml_unpub_cnt', 'color' => 'success'],
          'kannada' => ['label' => 'Kannada', 'published' => 'scr_kan_cnt', 'unpublished' => 'scr_kan_unpub_cnt', 'color' => 'warning'],
          'telugu' => ['label' => 'Telugu', 'published' => 'scr_tel_cnt', 'unpublished' => 'scr_tel_unpub_cnt', 'color' => 'info'],
          'malayalam' => ['label' => 'Malayalam', 'published' => 'scr_mlylm_cnt', 'unpublished' => 'scr_mlylm_unpub_cnt', 'color' => 'primary'],
          'english' => ['label' => 'English', 'published' => 'scr_eng_cnt', 'unpublished' => 'scr_eng_unpub_cnt', 'color' => 'danger']
        ];
        
        foreach ($languages as $key => $lang): ?>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-3">
          <div class="card h-100">
            <div class="card-header text-center py-3">
                <h6 class="mb-0"><?= $lang['label'] ?></h6>
            </div>
            <div class="card-body text-center py-3">
              <div class="d-flex justify-content-around mb-3">
                <div class="px-2">
                  <a href="<?php echo base_url(); ?>adminv3/scribd_published_<?= $key ?>" class="text-decoration-none">
                    <h4 class="text-<?= $lang['color'] ?> mb-0"><?= $scribd[$lang['published']] ?></h4>
                    <small class="text-muted">Published</small>
                  </a>
                </div>
                <div class="border-start px-2">
                  <a href="<?php echo base_url(); ?>adminv3/scribd_unpublished_<?= $key ?>" class="text-decoration-none">
                    <h4 class="text-<?= $lang['color'] ?> mb-0"><?= $scribd[$lang['unpublished']] ?></h4>
                    <small class="text-muted">Unpublished</small>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Excel Download Section -->
    <div class="col-lg-8 mb-4">
      <div class="card">
        <div class="card-header py-3">
          <h5 class="mb-0">Download Excel Report</h5>
        </div>
        <div class="card-body">
          <form action="<?php echo base_url(); ?>scribd/scribd_excel/" method="post">
            <div class="form-group mb-3">
              <label for="book_ids" class="form-label">Enter Book IDs (separated by commas):</label>
              <textarea class="form-control" id="book_ids" name="book_ids" rows="3" placeholder="12345, 67890, 54321"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">
              <i class="ri-download-line me-1"></i> Download Excel
            </button>
          </form>
        </div>
      </div>
    </div>
    
    <!-- Stats Summary Card -->
    <div class="col-lg-4 mb-4">
      <div class="card">
        <div class="card-header py-3">
          <h5 class="mb-0">Summary</h5>
        </div>
        <div class="card-body">
          <?php
          $total_published = 0;
          $total_unpublished = 0;
          
          foreach ($languages as $lang) {
            $total_published += $scribd[$lang['published']];
            $total_unpublished += $scribd[$lang['unpublished']];
          }
          ?>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Total Published:</span>
            <span class="fw-bold"><?= $total_published ?></span>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Total Unpublished:</span>
            <span class="fw-bold"><?= $total_unpublished ?></span>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Total Books:</span>
            <span class="fw-bold text-primary"><?= $total_published + $total_unpublished ?></span>
          </div>
          <hr>
          <div class="text-center">
            <a href="<?php echo base_url(); ?>adminv3/scribd_all_books" class="btn btn-outline-primary btn-sm">
              <i class="ri-database-2-line me-1"></i> View All Books
            </a>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?= $this->endSection(); ?>