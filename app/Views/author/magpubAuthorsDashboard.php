<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header text-center">
            <h6 class="text-center">Magazine/Publisher Author Dashboard (Author Type: 3)</h6><br>
        </div>

        <div class="container-fluid mt-4">
            <div class="row gy-4">

                <?php 
    
                $bg_classes = ['bg-gradient-end-1', 'bg-gradient-end-2', 'bg-gradient-end-3', 'bg-gradient-end-4', 'bg-gradient-end-5', 'bg-gradient-end-6'];

                for ($i = 0; $i < count($get_language_wise_author_count['lang_name']); $i++):
                    $lang = $get_language_wise_author_count['lang_name'][$i];
                    $count = $get_language_wise_author_count['author_cnt'][$i];
                    $bg_class = $bg_classes[$i % count($bg_classes)];
                ?>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                    <a target="_blank" href="<?= base_url()."author/manageauthors/magpub/".strtolower($lang) ?>" class="text-decoration-none">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 <?= $bg_class ?>">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center gap-2 mb-8">
                                    <span class="w-48-px h-48-px bg-primary-600 text-white d-flex justify-content-center align-items-center rounded-circle">
                                        <iconify-icon icon="mdi:book-account" class="icon"></iconify-icon>
                                    </span>
                                    <div>
                                        <span class="text-secondary-light text-sm fw-medium"><?= ucfirst($lang) ?> Authors</span>
                                        <h6 class="fw-semibold"><?= $count ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endfor; ?>
                <?php 
                $zero_langs = ['Telugu', 'Malayalam', 'English']; 
                $existing_langs = array_map('strtolower', $get_language_wise_author_count['lang_name']);
                $idx = 0;
                foreach($zero_langs as $lang):
                    if (!in_array(strtolower($lang), $existing_langs)):
                        $bg_class = $bg_classes[($i + $idx) % count($bg_classes)];
                ?>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                    <a href="#" class="text-decoration-none">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 <?= $bg_class ?>">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center gap-2 mb-8">
                                    <span class="w-48-px h-48-px bg-secondary text-white d-flex justify-content-center align-items-center rounded-circle">
                                        <iconify-icon icon="mdi:book-account" class="icon"></iconify-icon>
                                    </span>
                                    <div>
                                        <span class="text-secondary-light text-sm fw-medium"><?= $lang ?> Authors</span>
                                        <h6 class="fw-semibold">0</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php 
                    endif;
                    $idx++;
                endforeach; 
                ?>

                <!-- Inactive Authors -->
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                    <a target="_blank" href="<?= base_url()."author/manageauthors/magpub/inactive" ?>" class="text-decoration-none">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-4">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center gap-2 mb-8">
                                    <span class="w-48-px h-48-px bg-warning text-white d-flex justify-content-center align-items-center rounded-circle">
                                        <iconify-icon icon="mdi:account-off" class="icon"></iconify-icon>
                                    </span>
                                    <div>
                                        <span class="text-secondary-light text-sm fw-medium">Inactive Authors</span>
                                        <h6 class="fw-semibold"><?= $get_language_wise_author_count['inactive_cnt'] ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Cancelled Authors -->
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                    <a target="_blank" href="<?= base_url()."author/manageauthors/magpub/cancelled" ?>" class="text-decoration-none">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-4">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center gap-2 mb-8">
                                    <span class="w-48-px h-48-px bg-danger text-white d-flex justify-content-center align-items-center rounded-circle">
                                        <iconify-icon icon="mdi:account-off" class="icon"></iconify-icon>
                                    </span>
                                    <div>
                                        <span class="text-secondary-light text-sm fw-medium">Cancelled Authors</span>
                                        <h6 class="fw-semibold"><?= $get_language_wise_author_count['cancelled_cnt'] ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
