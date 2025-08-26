<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid py-4">
    <div class="layout-px-spacing">

        <!-- Amazon Books Tabs -->
        <div class="col-12 mb-4">
            <div class="card p-0 overflow-hidden position-relative radius-12 h-100">
                <div class="card-body p-4">
                    <!-- Tabs -->
                    <ul class="nav nav-pills mb-4" id="amazon-tab" role="tablist">
                        <?php 
                        $languages = [
                            'tamil' => ['label' => 'TAMIL', 'published' => 'amz_tml_cnt', 'unpublished' => 'amz_tml_unpub_cnt'],
                            'malayalam' => ['label' => 'MALAYALAM', 'published' => 'amz_mlylm_cnt', 'unpublished' => 'amz_mlylm_unpub_cnt'],
                            'english' => ['label' => 'ENGLISH', 'published' => 'amz_eng_cnt', 'unpublished' => 'amz_eng_unpub_cnt']
                        ];
                        $first = true;
                        foreach ($languages as $key => $lang): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $first ? 'active' : ''; ?>" 
                                        id="<?= $key ?>-tab" 
                                        data-bs-toggle="pill" 
                                        data-bs-target="#<?= $key ?>-tab-pane" 
                                        type="button" role="tab" 
                                        aria-controls="<?= $key ?>-tab-pane" 
                                        aria-selected="<?= $first ? 'true' : 'false' ?>">
                                    <?= $lang['label'] ?>
                                </button>
                            </li>
                        <?php $first = false; endforeach; ?>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="amazon-tabContent">
                        <?php $first = true; foreach ($languages as $key => $lang): ?>
                            <div class="tab-pane fade <?= $first ? 'show active' : ''; ?>" id="<?= $key ?>-tab-pane" role="tabpanel" aria-labelledby="<?= $key ?>-tab">
                                <div class="row gy-3">
                                    <!-- Published Card -->
                                    <div class="col-md-6">
                                        <div class="card shadow-sm text-center p-2 bg-gradient-info text-light radius-8">
                                            <div class="card-body">
                                                <span class="d-inline-flex justify-content-center align-items-center rounded-circle bg-light text-primary mb-3" style="width:48px; height:48px;">
                                                    <i class="ri-book-2-fill fs-4"></i>
                                                </span>
                                                <h6 class="mb-2 fs-7">Published Books</h6>
                                                <h6 class="fw-bold"><?= $amazon[$lang['published']] ?></h6>
                                                <a href="<?= base_url("adminv3/amazon_published_{$key}") ?>" class="btn btn-neutral-900 text-base radius-8 px-14 py-6 text-sm">View Details</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Unpublished Card -->
                                    <div class="col-md-6">
                                        <div class="card shadow-sm text-center p-2 bg-gradient-info text-light radius-8">
                                            <div class="card-body">
                                                <span class="d-inline-flex justify-content-center align-items-center rounded-circle bg-light text-warning mb-3" style="width:48px; height:48px;">
                                                    <i class="ri-book-mark-fill fs-4"></i>
                                                </span>
                                                <h6 class="mb-2">Unpublished Books</h6>
                                                <h6 class="fw-bold"><?= $amazon[$lang['unpublished']] ?></h6>
                                                <a href="<?= base_url("adminv3/amazon_unpublished_{$key}") ?>" class="btn btn-neutral-900 text-base radius-8 px-14 py-6 text-sm">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php $first = false; endforeach; ?>
                    </div>

                </div>
            </div>
        </div>
        <br>

        <!-- Amazon Books Count & Actions -->
        <div class="row gx-4 gy-4">
            <!-- Left Column: Amazon Books Count -->
            <div class="col-md-6">
                <h6 class="text-center mb-3 fs-7">Amazon Books Count</h6>
                <div class="row gx-3 gy-3">
                    <!-- Total Books -->
                    <div class="col-12">
                        <div class="px-20 py-16 shadow-none radius-8 h-100 gradient-deep-1 left-line line-bg-primary position-relative overflow-hidden">
                            <div class="card-body p-2">
                                <span class="d-inline-flex justify-content-center align-items-center rounded-circle bg-light text-info mb-2" style="width:36px; height:36px;">
                                    <i class="ri-book-2-fill fs-5"></i>
                                </span>
                                <h6 class="mb-1 fs-7">Total Books</h6>
                                <h6 class="mb-0 fs-6"><?= $amazon_books['total_books'][0]['total_books']; ?></h6>
                            </div>
                        </div>
                    </div>

                    <!-- Books Count by Language -->
                    <div class="col-12">
                        <div class="px-20 py-16 shadow-none radius-8 h-100 gradient-deep-2 left-line line-bg-lilac position-relative overflow-hidden">
                            <div class="card-body p-2">
                                <span class="d-inline-flex justify-content-center align-items-center rounded-circle bg-light text-info mb-2" style="width:36px; height:36px;">
                                    <i class="ri-translate-2 fs-5"></i>
                                </span>
                                <h6 class="mb-1 fs-7">Books Counts by Language</h6>
                                <?php foreach ($amazon_books['lan_total'] as $lang) { ?>
                                    <h6 class="fs-6"><?= $lang['language']; ?>: <?= $lang['book_count']; ?></h6>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <!-- Kindle Unlimited -->
                    <div class="col-12">
                        <div class="px-20 py-16 shadow-none radius-8 h-100 gradient-deep-3 left-line line-bg-success position-relative overflow-hidden">
                            <div class="card-body p-2">
                                <span class="d-inline-flex justify-content-center align-items-center rounded-circle bg-light text-warning mb-2" style="width:36px; height:36px;">
                                    <i class="ri-star-fill fs-5"></i>
                                </span>
                                <h6 class="mb-1 fs-7">Kindle Unlimited</h6>
                                <h6 class="mb-1 fs-6">Total:</strong> <?= $amazon_books['enb_total'][0]['ku_enabled_count']; ?></h6>
                                <h6 class="mb-1">KU-US:</strong> <?= $amazon_books['enb_total'][0]['ku_us_enabled_count']; ?></h6>
                                <h6 class="mb-0">KU-UK:</strong> <?= $amazon_books['enb_total'][0]['ku_uk_enabled_count']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Upload / Download Actions -->
            <div class="col-md-6">
                <h5 class="text-center mb-3">Actions</h5>
                <div class="row gx-3 gy-3">
                    <!-- Upload Books -->
                    <div class="col-12">
                        <div class="card shadow-sm text-center p-2 bg-gradient-info text-light radius-8">
                            <div class="card-body p-2">
                                <span class="d-inline-flex justify-content-center align-items-center rounded-circle bg-light text-primary mb-2" style="width:36px; height:36px;">
                                    <i class="ri-upload-2-fill fs-5"></i>
                                </span>
                                <h6 class="mb-1">Upload Books</h6>
                                <a href="<?= base_url('amazon/upload_books') ?>" target="_blank" class="btn btn-light btn-sm mt-1">Go</a>
                            </div>
                        </div>
                    </div>

                    <!-- Download Excel -->
                    <div class="col-12">
                        <div class="card shadow-sm text-center p-2 bg-gradient-info text-light radius-8">
                            <div class="card-body p-2">
                                <span class="d-inline-flex justify-content-center align-items-center rounded-circle bg-light text-info mb-2" style="width:36px; height:36px;">
                                    <i class="ri-file-download-fill fs-5"></i>
                                </span>
                                <h6 class="mb-1">Download Excel</h6>
                                <form action="<?= base_url('amazon/amazon_excel') ?>" method="post">
                                    <textarea class="form-control mb-1" name="book_ids" rows="1" placeholder="Book IDs separated by comma"></textarea>
                                    <input type="submit" class="btn btn-light btn-sm" value="Download">
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Download Price Excel -->
                    <div class="col-12">
                        <div class="card shadow-sm text-center p-2 bg-gradient-warning text-light radius-8">
                            <div class="card-body p-2">
                                <span class="d-inline-flex justify-content-center align-items-center rounded-circle bg-light text-warning mb-2" style="width:36px; height:36px;">
                                    <i class="ri-file-text-fill fs-5"></i>
                                </span>
                                <h6 class="mb-1 fs-7">Download Price Excel</h6>
                                <form action="<?= base_url('amazon/amazon_price_excel') ?>" method="post">
                                    <textarea class="form-control mb-1" name="book_ids" rows="1" placeholder="Book IDs separated by comma"></textarea>
                                    <input type="submit" class="btn btn-light btn-sm" value="Download">
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection(); ?>
