<?= $this->extend('layout/layout1'); ?>


<?= $this->section('content'); ?> 
    <div class="row gy-4">
        <div class="col-xxl-12">
            <div class="row gy-4">
                <div class="col-12">
                    <div class="mb-16 mt-8 d-flex flex-wrap justify-content-between gap-16">
                        <h6 class="mb-0"></h6>
                        <ul class="nav button-tab nav-pills mb-16 gap-12" id="pills-tab-three" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold text-secondary-light rounded-pill px-20 py-6 border border-neutral-300 " id="pills-button-all-tab" data-bs-toggle="pill" data-bs-target="#pills-button-all" type="button" role="tab" aria-controls="pills-button-all" aria-selected="false" tabindex="-1">Over All</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold text-secondary-light rounded-pill px-20 py-6 border border-neutral-300 active" id="pills-button-art-tab" data-bs-toggle="pill" data-bs-target="#pills-button-art" type="button" role="tab" aria-controls="pills-button-art" aria-selected="false" tabindex="-1">To Pay</button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="pills-tab-threeContent">
                        <div class="tab-pane fade " id="pills-button-all" role="tabpanel" aria-labelledby="pills-button-all-tab" tabindex="0">
                            <div class="row g-3">
                                <div class="col-xxl-3 col-sm-6 col-xs-6">
                                    <div class="nft-card bg-base radius-16 overflow-hidden">
                                        <div class="p-10">
                                            <h6 class="text fw-bold text-primary-light">Ebook</h6>
                                            <div class="d-flex align-items-center gap-8">
                                               <div class="w-50-px h-50-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
                                                        <iconify-icon icon="ri:user-3-line" class="text-white text-2xl mb-0"></iconify-icon>
                                                    </div>
                                                     <span class="text-md text-secondary-light fw-medium"><?= $overall['pending']['ebooks_count'] ?></span>
                                            </div>
                                            <div class="mt-10 d-flex align-items-center justify-content-between gap-8 flex-wrap">
                                                <span class="text-md text-secondary-light fw-medium">paid:
                                                    <span class="text-md text-primary-light fw-semibold"><?= indian_format($overall['paid']['ebook_paid']); ?></span>
                                                </span>
                                                <span class="text-md fw-semibold text-primary-600"><?= indian_format($overall['pending']['ebook_pending']); ?></span>
                                            </div>
                                            <div class="d-flex align-items-center flex-wrap mt-12 gap-8">
                                                <a  href="#" class="btn rounded-pill border text-neutral-500 border-neutral-500 radius-8 px-12 py-6 bg-hover-neutral-500 text-hover-white flex-grow-1">History</a>
                                                <a  href="#" class="btn rounded-pill btn-primary-600 radius-8 px-12 py-6 flex-grow-1">Buy Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-sm-6 col-xs-6">
                                    <div class="nft-card bg-base radius-16 overflow-hidden">
                                         <div class="p-10">
                                            <h6 class="text fw-bold text-primary-light">Audio Book</h6>
                                            <div class="d-flex align-items-center gap-8">
                                                 <div class="w-50-px h-50-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
                                                        <iconify-icon icon="ri:user-3-line" class="text-white text-2xl mb-0"></iconify-icon>
                                                    </div>
                                                <span class="text-md text-secondary-light fw-medium"><?= $overall['pending']['audiobooks_count'] ?></span>
                                            </div>
                                            <div class="mt-10 d-flex align-items-center justify-content-between gap-8 flex-wrap">
                                                <span class="text-md text-secondary-light fw-medium">Price:
                                                    <span class="text-md text-primary-light fw-semibold"><?= indian_format($overall['paid']['audiobook_paid']); ?></span>
                                                </span>
                                                <span class="text-md fw-semibold text-primary-600"><?= indian_format($overall['pending']['audiobook_pending']); ?></span>
                                            </div>
                                            <div class="d-flex align-items-center flex-wrap mt-12 gap-8">
                                                <a  href="#" class="btn rounded-pill border text-neutral-500 border-neutral-500 radius-8 px-12 py-6 bg-hover-neutral-500 text-hover-white flex-grow-1">History</a>
                                                <a  href="#" class="btn rounded-pill btn-primary-600 radius-8 px-12 py-6 flex-grow-1">Buy Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-sm-6 col-xs-6">
                                    <div class="nft-card bg-base radius-16 overflow-hidden">
                                        <div class="p-10">
                                            <h6 class="text fw-bold text-primary-light">Paperback</h6>
                                            <div class="d-flex align-items-center gap-8">
                                                <div class="w-50-px h-50-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
                                                        <iconify-icon icon="ri:user-3-line" class="text-white text-2xl mb-0"></iconify-icon>
                                                    </div>
                                                     <span class="text-md text-secondary-light fw-medium"><?= $overall['pending']['paperbacks_count'] ?></span>
                                            </div>
                                            <div class="mt-10 d-flex align-items-center justify-content-between gap-8 flex-wrap">
                                                <span class="text-md text-secondary-light fw-medium">Price:
                                                    <span class="text-md text-primary-light fw-semibold"><?= indian_format($overall['paid']['paperback_paid']); ?></span>
                                                </span>
                                                <span class="text-md fw-semibold text-primary-600"><?= indian_format($overall['pending']['paperback_pending']);?></span>
                                            </div>
                                            <div class="d-flex align-items-center flex-wrap mt-12 gap-8">
                                                <a  href="#" class="btn rounded-pill border text-neutral-500 border-neutral-500 radius-8 px-12 py-6 bg-hover-neutral-500 text-hover-white flex-grow-1">History</a>
                                                <a  href="#" class="btn rounded-pill btn-primary-600 radius-8 px-12 py-6 flex-grow-1">Buy Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-sm-6 col-xs-6">
                                    <div class="nft-card bg-base radius-16 overflow-hidden">
                                       <div class="p-10">
                                            <h5 class="text fw-bold text-primary-light">Total</h5>
                                            <div class="d-flex align-items-center gap-8">
                                                    <div class="w-50-px h-50-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
                                                        <iconify-icon icon="ri:user-3-line" class="text-white text-2xl mb-0"></iconify-icon>
                                                    </div>
                                                    <span class="text-md text-secondary-light fw-medium"><?= $overall['pending']['total_publishers'] ?></span>
                                            </div>
                                            <div class="mt-10 d-flex align-items-center justify-content-between gap-8 flex-wrap">
                                                <span class="text-md text-secondary-light fw-medium">Price:
                                                    <span class="text-md text-primary-light fw-semibold"><?= indian_format($overall['paid']['total_paid']); ?></span>
                                                </span>
                                                <span class="text-md fw-semibold text-primary-600"><?= indian_format($overall['pending']['total_pending']); ?></span>
                                            </div>
                                            <div class="d-flex align-items-center flex-wrap mt-12 gap-8">
                                                <a  href="#" class="btn rounded-pill border text-neutral-500 border-neutral-500 radius-8 px-12 py-6 bg-hover-neutral-500 text-hover-white flex-grow-1">History</a>
                                                <a  href="#" class="btn rounded-pill btn-primary-600 radius-8 px-12 py-6 flex-grow-1">Buy Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="pills-button-art" role="tabpanel" aria-labelledby="pills-button-art-tab" tabindex="0">
                            <div class="row g-3">
                                <div class="col-xxl-3 col-sm-6 col-xs-6">
                                    <div class="nft-card bg-base radius-16 overflow-hidden">
                                          <div class="p-10">
                                            <h6 class="text fw-bold text-primary-light">Ebooks</h6>
                                            <div class="d-flex align-items-center gap-8">
                                               <div class="w-50-px h-50-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
                                                        <iconify-icon icon="ri:user-3-line" class="text-white text-2xl mb-0"></iconify-icon>
                                                    </div>
                                                      <span class="text-md text-secondary-light fw-medium"><?= $quarterly['pending']['ebooks_count'] ?></span>
                                            </div>
                                            <div class="mt-10 d-flex align-items-center justify-content-between gap-8 flex-wrap">
                                                <span class="text-md text-secondary-light fw-medium">Price:
                                                    <span class="text-md text-primary-light fw-semibold"><?= indian_format($quarterly['paid']['ebook_paid']); ?></span>
                                                </span>
                                                <span class="text-md fw-semibold text-primary-600"><?= indian_format($quarterly['pending']['ebook_pending']); ?></span>
                                            </div>
                                            <div class="d-flex align-items-center flex-wrap mt-12 gap-8">
                                                <a  href="#" class="btn rounded-pill border text-neutral-500 border-neutral-500 radius-8 px-12 py-6 bg-hover-neutral-500 text-hover-white flex-grow-1">History</a>
                                                <a  href="#" class="btn rounded-pill btn-primary-600 radius-8 px-12 py-6 flex-grow-1">Buy Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-sm-6 col-xs-6">
                                    <div class="nft-card bg-base radius-16 overflow-hidden">
                                        <div class="p-10">
                                            <h6 class="text fw-bold text-primary-light">Audiobooks</h6>
                                            <div class="d-flex align-items-center gap-8">
                                               <div class="w-50-px h-50-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
                                                        <iconify-icon icon="ri:user-3-line" class="text-white text-2xl mb-0"></iconify-icon>
                                                    </div>
                                                     <span class="text-md text-secondary-light fw-medium"><?= $quarterly['pending']['audiobooks_count'] ?></span>
                                            </div>
                                            <div class="mt-10 d-flex align-items-center justify-content-between gap-8 flex-wrap">
                                                <span class="text-md text-secondary-light fw-medium">Price:
                                                    <span class="text-md text-primary-light fw-semibold"><?= indian_format($quarterly['paid']['audiobook_paid']); ?></span>
                                                </span>
                                                <span class="text-md fw-semibold text-primary-600"><?= indian_format($quarterly['pending']['audiobook_pending']); ?></span>
                                            </div>
                                            <div class="d-flex align-items-center flex-wrap mt-12 gap-8">
                                                <a  href="#" class="btn rounded-pill border text-neutral-500 border-neutral-500 radius-8 px-12 py-6 bg-hover-neutral-500 text-hover-white flex-grow-1">History</a>
                                                <a  href="#" class="btn rounded-pill btn-primary-600 radius-8 px-12 py-6 flex-grow-1">Buy Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-sm-6 col-xs-6">
                                    <div class="nft-card bg-base radius-16 overflow-hidden">
                                        <div class="p-10">
                                            <h6 class="text fw-bold text-primary-light">Paperback</h6>
                                            <div class="d-flex align-items-center gap-8">
                                               <div class="w-50-px h-50-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
                                                        <iconify-icon icon="ri:user-3-line" class="text-white text-2xl mb-0"></iconify-icon>
                                                    </div>
                                                    <span class="text-md text-secondary-light fw-medium"><?= $quarterly['pending']['paperbacks_count'] ?></span>
                                            </div>
                                            <div class="mt-10 d-flex align-items-center justify-content-between gap-8 flex-wrap">
                                                <span class="text-md text-secondary-light fw-medium">Price:
                                                    <span class="text-md text-primary-light fw-semibold"><?= indian_format($quarterly['paid']['paperback_paid']); ?></span>
                                                </span>
                                                <span class="text-md fw-semibold text-primary-600"><?= indian_format($quarterly['pending']['paperback_pending']); ?></span>
                                            </div>
                                            <div class="d-flex align-items-center flex-wrap mt-12 gap-8">
                                                <a  href="#" class="btn rounded-pill border text-neutral-500 border-neutral-500 radius-8 px-12 py-6 bg-hover-neutral-500 text-hover-white flex-grow-1">History</a>
                                                <a  href="#" class="btn rounded-pill btn-primary-600 radius-8 px-12 py-6 flex-grow-1">Buy Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-sm-6 col-xs-6">
                                    <div class="nft-card bg-base radius-16 overflow-hidden">
                                          <div class="p-10">
                                            <h6 class="text fw-bold text-primary-light">Total</h6>
                                            <div class="d-flex align-items-center gap-8">
                                              <div class="w-50-px h-50-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
                                                        <iconify-icon icon="ri:user-3-line" class="text-white text-2xl mb-0"></iconify-icon>
                                                    </div>
                                                      <span class="text-md text-secondary-light fw-medium"><?= $quarterly['pending']['total_publishers'] ?></span>
                                            </div>
                                            <div class="mt-10 d-flex align-items-center justify-content-between gap-8 flex-wrap">
                                                <span class="text-md text-secondary-light fw-medium">Price:
                                                    <span class="text-md text-primary-light fw-semibold"><?= indian_format($quarterly['paid']['total_paid']); ?></span>
                                                </span>
                                                <span class="text-md fw-semibold text-primary-600"><?= indian_format($quarterly['pending']['total_pending']); ?></span>
                                            </div>
                                            <div class="d-flex align-items-center flex-wrap mt-12 gap-8">
                                                <a  href="#" class="btn rounded-pill border text-neutral-500 border-neutral-500 radius-8 px-12 py-6 bg-hover-neutral-500 text-hover-white flex-grow-1">History</a>
                                                <a  href="#" class="btn rounded-pill btn-primary-600 radius-8 px-12 py-6 flex-grow-1">Buy Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-xxl-2">
           
        </div>
    </div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
  
<?= $this->endSection(); ?>