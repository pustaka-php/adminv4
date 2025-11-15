<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <h5 class="text-center">
            Lost / Excess Books Status Dashboard
        </h5>
        <br>
        <div class="d-flex justify-content-center align-items-center" style="min-height: 20vh;">
            <div class="p-16 bg-success-50 radius-8 border-start-width-3-px border-success-main border-top-0 border-end-0 border-bottom-0"
                style="max-width: 450px; width: 100%;">
                <h6 class="text-success mb-12 text-center">
                    <?php 
                        echo $lost_excess_update ?? $lost_excess_update_all ?? "No data"; 
                    ?>
                </h6>
            </div>
        </div>
        <div class="text-center">
            <a href="<?= base_url() . "stock/lostexcessbooksstatus/" ?>">
                <span class="badge text-sm fw-semibold bg-dark-danger-gradient px-20 py-9 radius-4 text-white">
                    Lost / Excess Books
                </span>
            </a>
            <a href="<?= base_url() . "stock/lostexcessbooksstatus/" ?>">
                <span class="badge text-sm fw-semibold bg-dark-dark-gradient px-20 py-9 radius-4 text-white"
                    style="display: inline-block; width: 150px; text-align: center;">
                    Back
                </span>
            </a>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
