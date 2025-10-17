<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <!-- Upload Button -->
        <div class="row mt-4">
            <div class="col-md-12 text-end">
                <a href="<?= base_url('amazon/uploadbooks'); ?>" target="_blank" 
                    class="btn btn-outline-info-600 radius-8 px-20 py-11">
                    <i class="fas fa-upload me-2"></i> Upload Books
                </a>
            </div>
        </div>

        <!-- Language Wise Summary -->
        <div class="row mt-4">
            <div class="col-12 mb-3">
                <h6 class="fw-bold text-center">Language Wise Summary</h6>
            </div>

            <!-- Tamil -->
            <div class="col-md-4">
                <div class="card shadow-none border bg-gradient-start-1 h-100 p-4 text-center">
                    <i class="fas fa-book-open fa-3x mb-3"></i>
                    <h6 class="mb-3">Tamil</h6>
                    <p>Published: <span class="badge bg-light text-dark fs-6"><?= $amazon['amz_tml_cnt']; ?></span></p>
                    <p>
                        <a href="<?= base_url('book/amazonunpublishedtamil'); ?>" target="_blank">
                            Unpublished: <span class="badge bg-light text-red fs-6"><?= $amazon['amz_tml_unpub_cnt']; ?></span>
                        </a>
                    </p>
                </div>
            </div>

            <!-- Malayalam -->
            <div class="col-md-4">
                <div class="card shadow-none border bg-gradient-start-2 h-100 p-4 text-center">
                    <i class="fas fa-book-reader fa-3x mb-3"></i>
                    <h6 class="mb-3">Malayalam</h6>
                    <p>Published: <span class="badge bg-light text-dark fs-6"><?= $amazon['amz_mlylm_cnt']; ?></span></p>
                    <p>
                        <a href="<?= base_url('book/amazonunpublishedmalayalam'); ?>" target="_blank">
                            Unpublished: <span class="badge bg-light text-red fs-6"><?= $amazon['amz_mlylm_unpub_cnt']; ?></span>
                        </a>
                    </p>
                </div>
            </div>

            <!-- English -->
            <div class="col-md-4">
                <div class="card shadow-none border bg-gradient-start-3 h-100 p-4 text-center">
                    <i class="fas fa-language fa-3x mb-3"></i>
                    <h6 class="mb-3">English</h6>
                    <p>Published: <span class="badge bg-light text-dark fs-6"><?= $amazon['amz_eng_cnt']; ?></span></p>
                    <p>
                        <a href="<?= base_url('book/amazonunpublishedenglish'); ?>" target="_blank">
                            Unpublished: <span class="badge bg-light text-red fs-6"><?= $amazon['amz_eng_unpub_cnt']; ?></span>
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Amazon Books Count -->
        <div class="row mt-5">
            <div class="col-12 mb-3">
                <h6 class="fw-bold text-center">Amazon Books Count</h6>
            </div>

            <!-- Total Books -->
            <div class="col-md-4">
                <div class="card shadow-none border bg-gradient-start-4 h-100 p-4 text-center">
                    <i class="fas fa-layer-group fa-2x mb-2"></i>
                    <p class="card-title text-center">
                        <span class="fw-bold text-primary">
                            <i class="fas fa-book-open me-2"></i> Total Books
                        </span>
                    </p><br>
                    <h5><?= $amazon_books['total_books'][0]['total_books']; ?></h5>
                </div>
            </div>

            <!-- Books by Language -->
            <div class="col-md-4">
                <div class="card shadow-none border bg-gradient-start-5 h-100 p-4">
                    <i class="fas fa-globe fa-2x mb-2 d-block text-center"></i>
                    <p class="card-title text-center">
                        <span class="fw-bold text-primary">
                            <i class="fas fa-book-open me-2"></i> Books by Language
                        </span>
                    </p>
                    <?php foreach ($amazon_books['lan_total'] as $lang) { ?>
                        <p class="mb-1"><strong><?= $lang['language']; ?>:</strong> <?= $lang['book_count']; ?></p>
                    <?php } ?>
                </div>
            </div>

            <!-- Kindle Unlimited -->
            <div class="col-md-4">
                <div class="card shadow-none border bg-gradient-start-1 h-100 p-4">
                    <i class="fas fa-kindle fa-2x mb-2 d-block text-center"></i>
                   <p class="card-title text-center">
                        <span class="fw-bold text-primary">
                            <i class="fas fa-book-open me-2"></i> Kindle Unlimited
                        </span>
                    </p>
                    <p class="mb-1"><strong>Total:</strong> <?= $amazon_books['enb_total'][0]['ku_enabled_count']; ?></p>
                    <p class="mb-1"><strong>US:</strong> <?= $amazon_books['enb_total'][0]['ku_us_enabled_count']; ?></p>
                    <p class="mb-1"><strong>UK:</strong> <?= $amazon_books['enb_total'][0]['ku_uk_enabled_count']; ?></p>
                </div>
            </div>
        </div>
        <br>

        <!-- Excel Download -->
<div class="row gx-4 gy-4">
        <div class="col-12">
            <div class="card shadow-none border bg-info-light h-100">
                <div class="card-body p-20">

            <!-- Book Excel -->
            <form action="<?= base_url('book/download_amazon_excel'); ?>" method="post">
                <label class="fw-bold">Book IDs (comma separated):</label>
                <textarea class="form-control" name="book_ids" rows="3"></textarea><br>
                <button type="submit" class="btn rounded-pill btn-success-600 radius-8 px-20 py-11">
                    <i class="fas fa-file-excel me-2"></i> Download Excel
                </button>
            </form>
            <br>

            <!-- Price Excel -->
            <form action="<?= base_url('book/amazon_price_excel'); ?>" method="post" class="mt-4">
                <label class="fw-bold">Book IDs (comma separated):</label>
                <textarea class="form-control" name="book_ids" rows="3"></textarea><br>
                <button type="submit" class="btn rounded-pill btn-lilac-600 radius-8 px-20 py-11">
                    <i class="fas fa-tags me-2"></i> Download Price Excel
                </button>
            </form>

        </div>
    </div>
</div>


    </div>
</div>

<?= $this->endSection(); ?>
