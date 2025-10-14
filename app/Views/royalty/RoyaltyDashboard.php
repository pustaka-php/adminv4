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
                                <button class="nav-link fw-semibold text-secondary-light rounded-pill px-20 py-6 border border-neutral-300 active" id="pills-button-all-tab" data-bs-toggle="pill" data-bs-target="#pills-button-all" type="button" role="tab" aria-controls="pills-button-all" aria-selected="false" tabindex="-1">Over All</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold text-secondary-light rounded-pill px-20 py-6 border border-neutral-300" id="pills-button-art-tab" data-bs-toggle="pill" data-bs-target="#pills-button-art" type="button" role="tab" aria-controls="pills-button-art" aria-selected="false" tabindex="-1">To Pay</button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="pills-tab-threeContent">
                        <div class="tab-pane fade show active" id="pills-button-all" role="tabpanel" aria-labelledby="pills-button-all-tab" tabindex="0">
                            <div class="row g-3">
                                <div class="col-xxl-3 col-sm-6 col-xs-6">
                                    <div class="nft-card bg-base radius-16 overflow-hidden">
                                        <!-- <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img1.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div> -->
                                        <div class="p-10">
                                            <h6 class="text-md fw-bold text-primary-light">Ebook</h6>
                                            <div class="d-flex align-items-center gap-8">
                                                <img src="<?= base_url('assets/images/nft/nft-user-img1.png') ?>" class="w-28-px h-28-px rounded-circle object-fit-cover" alt="">
                                                <span class="text-sm text-secondary-light fw-medium">Watson Kristin</span>
                                            </div>
                                            <div class="mt-10 d-flex align-items-center justify-content-between gap-8 flex-wrap">
                                                <span class="text-sm text-secondary-light fw-medium">Price:
                                                    <span class="text-sm text-primary-light fw-semibold">1.44 ETH</span>
                                                </span>
                                                <span class="text-sm fw-semibold text-primary-600">$4,224.96</span>
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
                                        <!-- <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img2.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div> -->
                                        <div class="p-10">
                                            <h6 class="text-md fw-bold text-primary-light">Paperback</h6>
                                            <div class="d-flex align-items-center gap-8">
                                                <img src="<?= base_url('assets/images/nft/nft-user-img2.png') ?>" class="w-28-px h-28-px rounded-circle object-fit-cover" alt="">
                                                <span class="text-sm text-secondary-light fw-medium">Watson Kristin</span>
                                            </div>
                                            <div class="mt-10 d-flex align-items-center justify-content-between gap-8 flex-wrap">
                                                <span class="text-sm text-secondary-light fw-medium">Price:
                                                    <span class="text-sm text-primary-light fw-semibold">1.44 ETH</span>
                                                </span>
                                                <span class="text-sm fw-semibold text-primary-600">$4,224.96</span>
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
                                        <!-- <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img3.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div> -->
                                        <div class="p-10">
                                            <h6 class="text-md fw-bold text-primary-light">Audio book</h6>
                                            <div class="d-flex align-items-center gap-8">
                                                <img src="<?= base_url('assets/images/nft/nft-user-img3.png') ?>" class="w-28-px h-28-px rounded-circle object-fit-cover" alt="">
                                                <span class="text-sm text-secondary-light fw-medium">Watson Kristin</span>
                                            </div>
                                            <div class="mt-10 d-flex align-items-center justify-content-between gap-8 flex-wrap">
                                                <span class="text-sm text-secondary-light fw-medium">Price:
                                                    <span class="text-sm text-primary-light fw-semibold">1.44 ETH</span>
                                                </span>
                                                <span class="text-sm fw-semibold text-primary-600">$4,224.96</span>
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
                                        <!-- <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img4.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div> -->
                                        <div class="p-10">
                                            <h6 class="text-md fw-bold text-primary-light">Total</h6>
                                            <div class="d-flex align-items-center gap-8">
                                                <img src="<?= base_url('assets/images/nft/nft-user-img4.png') ?>" class="w-28-px h-28-px rounded-circle object-fit-cover" alt="">
                                                <span class="text-sm text-secondary-light fw-medium">Watson Kristin</span>
                                            </div>
                                            <div class="mt-10 d-flex align-items-center justify-content-between gap-8 flex-wrap">
                                                <span class="text-sm text-secondary-light fw-medium">Price:
                                                    <span class="text-sm text-primary-light fw-semibold">1.44 ETH</span>
                                                </span>
                                                <span class="text-sm fw-semibold text-primary-600">$4,224.96</span>
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
                        <div class="tab-pane fade" id="pills-button-art" role="tabpanel" aria-labelledby="pills-button-art-tab" tabindex="0">
                            <div class="row g-3">
                                <div class="col-xxl-3 col-sm-6 col-xs-6">
                                    <div class="nft-card bg-base radius-16 overflow-hidden">
                                        <!-- <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img1.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div> -->
                                        <div class="p-10">
                                            <h6 class="text-md fw-bold text-primary-light">Fantastic Alien</h6>
                                            <div class="d-flex align-items-center gap-8">
                                                <img src="<?= base_url('assets/images/nft/nft-user-img1.png') ?>" class="w-28-px h-28-px rounded-circle object-fit-cover" alt="">
                                                <span class="text-sm text-secondary-light fw-medium">Watson Kristin</span>
                                            </div>
                                            <div class="mt-10 d-flex align-items-center justify-content-between gap-8 flex-wrap">
                                                <span class="text-sm text-secondary-light fw-medium">Price:
                                                    <span class="text-sm text-primary-light fw-semibold">1.44 ETH</span>
                                                </span>
                                                <span class="text-sm fw-semibold text-primary-600">$4,224.96</span>
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
                                        <!-- <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img2.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div> -->
                                        <div class="p-10">
                                            <h6 class="text-md fw-bold text-primary-light">New Figures</h6>
                                            <div class="d-flex align-items-center gap-8">
                                                <img src="<?= base_url('assets/images/nft/nft-user-img2.png') ?>" class="w-28-px h-28-px rounded-circle object-fit-cover" alt="">
                                                <span class="text-sm text-secondary-light fw-medium">Watson Kristin</span>
                                            </div>
                                            <div class="mt-10 d-flex align-items-center justify-content-between gap-8 flex-wrap">
                                                <span class="text-sm text-secondary-light fw-medium">Price:
                                                    <span class="text-sm text-primary-light fw-semibold">1.44 ETH</span>
                                                </span>
                                                <span class="text-sm fw-semibold text-primary-600">$4,224.96</span>
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
                                        <!-- <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img3.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div> -->
                                        <div class="p-10">
                                            <h6 class="text-md fw-bold text-primary-light">New Figures</h6>
                                            <div class="d-flex align-items-center gap-8">
                                                <img src="<?= base_url('assets/images/nft/nft-user-img3.png') ?>" class="w-28-px h-28-px rounded-circle object-fit-cover" alt="">
                                                <span class="text-sm text-secondary-light fw-medium">Watson Kristin</span>
                                            </div>
                                            <div class="mt-10 d-flex align-items-center justify-content-between gap-8 flex-wrap">
                                                <span class="text-sm text-secondary-light fw-medium">Price:
                                                    <span class="text-sm text-primary-light fw-semibold">1.44 ETH</span>
                                                </span>
                                                <span class="text-sm fw-semibold text-primary-600">$4,224.96</span>
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
                                        <!-- <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img4.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div> -->
                                        <div class="p-10">
                                            <h6 class="text-md fw-bold text-primary-light">New Figures</h6>
                                            <div class="d-flex align-items-center gap-8">
                                                <img src="<?= base_url('assets/images/nft/nft-user-img4.png') ?>" class="w-28-px h-28-px rounded-circle object-fit-cover" alt="">
                                                <span class="text-sm text-secondary-light fw-medium">Watson Kristin</span>
                                            </div>
                                            <div class="mt-10 d-flex align-items-center justify-content-between gap-8 flex-wrap">
                                                <span class="text-sm text-secondary-light fw-medium">Price:
                                                    <span class="text-sm text-primary-light fw-semibold">1.44 ETH</span>
                                                </span>
                                                <span class="text-sm fw-semibold text-primary-600">$4,224.96</span>
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