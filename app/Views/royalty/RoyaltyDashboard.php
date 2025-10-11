<?= $this->extend('layout/layout1'); ?>


<?= $this->section('content'); ?> 
    <div class="row gy-4">
        <div class="col-xxl-8">
            <div class="row gy-4">


                <div class="col-12">
                    <h6 class="mb-16">Trending Bids</h6>
                    <div class="row gy-4">
                        <!-- Dashboard Widget Start -->
                        <div class="col-lg-4 col-sm-6">
                            <div class="card px-24 py-16 shadow-none radius-12 border h-100 bg-gradient-start-3">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                        <div class="d-flex align-items-center flex-wrap gap-16">
                                            <span class="mb-0 w-40-px h-40-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                                <iconify-icon icon="flowbite:users-group-solid" class="icon"></iconify-icon>
                                            </span>

                                            <div class="flex-grow-1">
                                                <h6 class="fw-semibold mb-0">24,000</h6>
                                                <span class="fw-medium text-secondary-light text-md">Artworks</span>
                                                <p class="text-sm mb-0 d-flex align-items-center flex-wrap gap-12 mt-12">
                                                    <span class="bg-success-focus px-6 py-2 rounded-2 fw-medium text-success-main text-sm d-flex align-items-center gap-8">
                                                        +168.001%
                                                        <i class="ri-arrow-up-line"></i>
                                                    </span> This week
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Dashboard Widget End -->

                        <!-- Dashboard Widget Start -->
                        <div class="col-lg-4 col-sm-6">
                            <div class="card px-24 py-16 shadow-none radius-12 border h-100 bg-gradient-start-5">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                        <div class="d-flex align-items-center flex-wrap gap-16">
                                            <span class="mb-0 w-40-px h-40-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                                <iconify-icon icon="flowbite:users-group-solid" class="icon"></iconify-icon>
                                            </span>

                                            <div class="flex-grow-1">
                                                <h6 class="fw-semibold mb-0">82,000</h6>
                                                <span class="fw-medium text-secondary-light text-md">Auction</span>
                                                <p class="text-sm mb-0 d-flex align-items-center flex-wrap gap-12 mt-12">
                                                    <span class="bg-danger-focus px-6 py-2 rounded-2 fw-medium text-danger-main text-sm d-flex align-items-center gap-8">
                                                        +168.001%
                                                        <i class="ri-arrow-down-line"></i>
                                                    </span> This week
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Dashboard Widget End -->

                        <!-- Dashboard Widget Start -->
                        <div class="col-lg-4 col-sm-6">
                            <div class="card px-24 py-16 shadow-none radius-12 border h-100 bg-gradient-start-2">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                        <div class="d-flex align-items-center flex-wrap gap-16">
                                            <span class="mb-0 w-40-px h-40-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                                <iconify-icon icon="flowbite:users-group-solid" class="icon"></iconify-icon>
                                            </span>

                                            <div class="flex-grow-1">
                                                <h6 class="fw-semibold mb-0">800</h6>
                                                <span class="fw-medium text-secondary-light text-md">Creators</span>
                                                <p class="text-sm mb-0 d-flex align-items-center flex-wrap gap-12 mt-12">
                                                    <span class="bg-success-focus px-6 py-2 rounded-2 fw-medium text-success-main text-sm d-flex align-items-center gap-8">
                                                        +168.001%
                                                        <i class="ri-arrow-up-line"></i>
                                                    </span> This week
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Dashboard Widget End -->
                    </div>
                </div>

                <div class="col-12">
                    <div class="mb-16 mt-8 d-flex flex-wrap justify-content-between gap-16">
                        <h6 class="mb-0">Trending NFTs</h6>
                        <ul class="nav button-tab nav-pills mb-16 gap-12" id="pills-tab-three" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold text-secondary-light rounded-pill px-20 py-6 border border-neutral-300 active" id="pills-button-all-tab" data-bs-toggle="pill" data-bs-target="#pills-button-all" type="button" role="tab" aria-controls="pills-button-all" aria-selected="false" tabindex="-1">All</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold text-secondary-light rounded-pill px-20 py-6 border border-neutral-300" id="pills-button-art-tab" data-bs-toggle="pill" data-bs-target="#pills-button-art" type="button" role="tab" aria-controls="pills-button-art" aria-selected="false" tabindex="-1">Art</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold text-secondary-light rounded-pill px-20 py-6 border border-neutral-300" id="pills-button-music-tab" data-bs-toggle="pill" data-bs-target="#pills-button-music" type="button" role="tab" aria-controls="pills-button-music" aria-selected="false" tabindex="-1">Music</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold text-secondary-light rounded-pill px-20 py-6 border border-neutral-300" id="pills-button-utility-tab" data-bs-toggle="pill" data-bs-target="#pills-button-utility" type="button" role="tab" aria-controls="pills-button-utility" aria-selected="true">Utility</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold text-secondary-light rounded-pill px-20 py-6 border border-neutral-300" id="pills-button-fashion-tab" data-bs-toggle="pill" data-bs-target="#pills-button-fashion" type="button" role="tab" aria-controls="pills-button-fashion" aria-selected="true">Fashion</button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="pills-tab-threeContent">
                        <div class="tab-pane fade show active" id="pills-button-all" role="tabpanel" aria-labelledby="pills-button-all-tab" tabindex="0">
                            <div class="row g-3">
                                <div class="col-xxl-3 col-sm-6 col-xs-6">
                                    <div class="nft-card bg-base radius-16 overflow-hidden">
                                        <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img1.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div>
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
                                        <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img2.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div>
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
                                        <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img3.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div>
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
                                        <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img4.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div>
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
                        <div class="tab-pane fade" id="pills-button-art" role="tabpanel" aria-labelledby="pills-button-art-tab" tabindex="0">
                            <div class="row g-3">
                                <div class="col-xxl-3 col-sm-6 col-xs-6">
                                    <div class="nft-card bg-base radius-16 overflow-hidden">
                                        <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img1.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div>
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
                                        <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img2.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div>
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
                                        <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img3.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div>
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
                                        <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img4.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div>
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
                        <div class="tab-pane fade" id="pills-button-music" role="tabpanel" aria-labelledby="pills-button-music-tab" tabindex="0">
                            <div class="row g-3">
                                <div class="col-xxl-3 col-sm-6 col-xs-6">
                                    <div class="nft-card bg-base radius-16 overflow-hidden">
                                        <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img1.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div>
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
                                        <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img2.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div>
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
                                        <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img3.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div>
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
                                        <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img4.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div>
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
                        <div class="tab-pane fade" id="pills-button-utility" role="tabpanel" aria-labelledby="pills-button-utility-tab" tabindex="0">
                            <div class="row g-3">
                                <div class="col-xxl-3 col-sm-6 col-xs-6">
                                    <div class="nft-card bg-base radius-16 overflow-hidden">
                                        <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img1.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div>
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
                                        <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img2.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div>
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
                                        <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img3.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div>
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
                                        <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img4.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div>
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
                        <div class="tab-pane fade" id="pills-button-fashion" role="tabpanel" aria-labelledby="pills-button-fashion-tab" tabindex="0">
                            <div class="row g-3">
                                <div class="col-xxl-3 col-sm-6 col-xs-6">
                                    <div class="nft-card bg-base radius-16 overflow-hidden">
                                        <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img1.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div>
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
                                        <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img2.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div>
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
                                        <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img3.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div>
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
                                        <div class="radius-16 overflow-hidden">
                                            <img src="<?= base_url('assets/images/nft/nft-img4.png') ?>" alt="" class="w-100 h-100 object-fit-cover">
                                        </div>
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