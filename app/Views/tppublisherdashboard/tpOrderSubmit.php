<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-xxl-5 col-md-8 col-sm-10">
        <div class="card radius-16 bg-gradient-purple text-center shadow-lg">
            <div class="card-body p-40">
                <div class="w-80-px h-80-px d-inline-flex align-items-center justify-content-center bg-lilac-600 text-white mb-24 radius-12 mx-auto">
                    <iconify-icon icon="clarity:success-standard-line" class="display-6 mb-0"></iconify-icon>
                </div>
                
                <h3 class="mb-16 text-success-600 fw-bold">Success</h3>
                <p class="card-text mb-32 text-secondary fs-5">Order successfully submitted!</p>
                
                <a href="<?= base_url('tppublisherdashboard/tppublisherdashboard') ?>" 
                   class="btn rounded-pill btn-outline-lilac-600 radius-8 px-32 py-12"
                   style="border-width: 2px; font-weight: 600;">
                   Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>