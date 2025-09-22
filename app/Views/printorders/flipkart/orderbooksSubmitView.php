<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 

<div class="d-flex justify-content-center align-items-center min-vh-100">
  <div class="card radius-12 bg-gradient-purple shadow-lg" style="width: 450px; padding: 48px;">
    <div class="card-body text-center">

      <div class="w-80-px h-80-px d-inline-flex align-items-center justify-content-center bg-lilac-600 text-white mb-4 radius-12 mx-auto">
        <i class="checkmark display-4 mb-0">✓</i>
      </div>

      <h3 class="mb-3 fw-bold">Success</h3>
      <p class="card-text mb-4 fs-5 text-secondary-light">Order Successfully submitted !!!</p>
      <br><br>

      <div class="d-flex flex-column gap-3">
        <a href="<?= base_url() . 'paperback/paperbackflipkartorder' ?>" class="btn btn-success btn-lg">Order Again</a>
        <a href="<?= base_url() . 'orders/ordersdashboard' ?>" class="btn btn-success btn-lg">Cancel</a>
      </div>

    </div>
  </div>
</div>

<?= $this->endSection(); ?>
