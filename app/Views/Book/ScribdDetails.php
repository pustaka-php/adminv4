<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <!-- Language Cards Row -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5 g-4">
            <?php 
                $languages = [
                    'tamil' => ['label' => 'Tamil', 'gradient' => 'bg-gradient-start-1'],
                    'kannada' => ['label' => 'Kannada', 'gradient' => 'bg-gradient-start-2'],
                    'telugu' => ['label' => 'Telugu', 'gradient' => 'bg-gradient-start-3'],
                    'malayalam' => ['label' => 'Malayalam', 'gradient' => 'bg-gradient-start-4'],
                    'english' => ['label' => 'English', 'gradient' => 'bg-gradient-start-5']
                ];

                foreach ($languages as $key => $lang):
                    $published   = $scribd['scr_' . $key . '_cnt'] ?? 0;
                    $unpublished = $scribd['scr_' . $key . '_unpub_cnt'] ?? 0;
            ?>
            <div class="col">
                <div class="card shadow-none border <?= $lang['gradient']; ?> h-100 text-white">
                    <div class="card-body text-center d-flex flex-column justify-content-center gap-2">
                        <h5 class="fw-bold"><?= $lang['label']; ?></h5>

                        <!-- Published -->
                        <p class="mb-1">
                            <a href="<?= base_url('adminv3/scribd_published_'.$key); ?>">
                                Published: <?= $published; ?>
                            </a>
                        </p>

                        <!-- Unpublished -->
                        <p class="mb-0">
                            <a href="<?= base_url('adminv3/scribd_unpublished_'.$key); ?>">
                                Unpublished: <?= $unpublished; ?>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Excel Download Form -->
        <div class="row mt-5">
            <div class="col-md-8">
                <div class="card shadow-sm p-4">
                    <form action="<?= base_url('scribd/scribd_excel'); ?>" method="post">
                        <label for="book_ids" class="form-label">Book IDs (comma separated):</label>
                        <textarea class="form-control mb-3" id="book_ids" name="book_ids" rows="3"></textarea>
                        <button type="submit" class="btn rounded-pill btn-info-600 radius-8 px-20 py-11">
                            Download Excel
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection(); ?>
