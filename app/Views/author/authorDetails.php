<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>

<div class="col-xxl-14">
    <!-- Tab Buttons -->
    <ul class="nav button-tab nav-pills mb-16" id="pills-tab-four" role="tablist">
        <li class="nav-item" role="presentation">
            <button
                class="nav-link d-flex align-items-center gap-2 fw-semibold text-primary-light radius-4 px-16 py-10 active"
                id="pills-button-icon-home-tab"
                data-bs-toggle="pill"
                data-bs-target="#basic_author_details"
                type="button"
                role="tab"
                aria-controls="basic_author_details"
                aria-selected="true"
            >
                <iconify-icon icon="solar:home-smile-angle-outline" class="text-xl"></iconify-icon>
                <span class="line-height-1">Basic</span>
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button
                class="nav-link d-flex align-items-center gap-2 fw-semibold text-primary-light radius-4 px-16 py-10"
                id="pills-button-icon-details-tab"
                data-bs-toggle="pill"
                data-bs-target="#books_details"
                type="button"
                role="tab"
                aria-controls="books_details"
                aria-selected="false"
            >
                <iconify-icon icon="mdi:book-open-page-variant" class="text-xl"></iconify-icon>
                <span class="line-height-1">Books</span>
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button
                class="nav-link d-flex align-items-center gap-2 fw-semibold text-primary-light radius-4 px-16 py-10"
                id="pills-button-icon-profile-tab"
                data-bs-toggle="pill"
                data-bs-target="#channel_details"
                type="button"
                role="tab"
                aria-controls="channel_details"
                aria-selected="false"
            >
                <iconify-icon icon="mdi:account-group" class="text-xl"></iconify-icon>
                <span class="line-height-1">Channel</span>
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button
                class="nav-link d-flex align-items-center gap-2 fw-semibold text-primary-light radius-4 px-16 py-10"
                id="pills-button-icon-settings-tab"
                data-bs-toggle="pill"
                data-bs-target="#royalty_details"
                type="button"
                role="tab"
                aria-controls="royalty_details"
                aria-selected="false"
            >
                <iconify-icon icon="mdi:crown-outline" class="text-xl"></iconify-icon>
                <span class="line-height-1">Royalty</span>
            </button>
        </li>
    </ul>
    <br>
    <div class="tab-content" id="pills-tabContent">

        <!-- Basic Tab Content -->
        <div class="tab-pane fade show active" id="basic_author_details" role="tabpanel" aria-labelledby="pills-button-icon-home-tab">
            <div class="row gy-4">
                <!-- Left Profile Card -->
                <div class="col-lg-4">
                    <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                        <img src="<?= base_url('assets/images/cover.png') ?>" alt="" class="w-100 object-fit-cover">
                        <div class="pb-24 ms-16 mb-24 me-16" style="margin-top: -100px;">
                            <div class="text-center border border-top-0 border-start-0 border-end-0">
                                <?php $author_img_url = 'https://pustaka-assets.s3.ap-south-1.amazonaws.com/'; ?>

                                <img
                                    src="<?= $author_img_url . $author_details['basic_author_details']['author_image'] ?>"
                                    alt="Author Image"
                                    class="border br-white border-width-20-px w-200-px h-200-px rounded-circle object-fit-cover"
                                >
                                <h6 class="mb-0 mt-16"><?= $author_details['basic_author_details']['author_name'] ?? 'N/A' ?></h6>
                                <span class="text-secondary-light mb-16"><?= $author_details['basic_author_details']['email'] ?? 'N/A' ?></span>
                            </div>

                            <div class="mt-24">
                                <h6 class="text-xl mb-16">Personal Info</h6>
                                <ul>
                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light">Mobile</span>
                                        <span class="w-70 text-secondary-light fw-medium">: <?= $author_details['basic_author_details']['mobile'] ?></span>
                                    </li>

                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light">Password</span>
                                        <span class="w-70 text-secondary-light fw-medium">: <?= $author_details['user_password'] ?></span>
                                    </li>

                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light">Address</span>
                                        <span class="w-70 text-secondary-light fw-medium">: <?= $author_details['basic_author_details']['author_address'] ?></span>
                                    </li>

                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light">Copyright Owner</span>
                                        <span class="w-70 text-secondary-light fw-medium">: <?= $author_details['basic_author_details']['copy_right_owner_name'] ?></span>
                                    </li>

                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light">Publisher Name</span>
                                        <span class="w-70 text-secondary-light fw-medium">: <?= $author_details['basic_author_details']['publisher_names'] ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="col-lg-8">
                    <div class="card h-100">
                        <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                            <div class="card-body p-24">
                                <h6 class="text-xl mb-16 text-center">General Info</h6>
                                <ul>
                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light">Bank Acc</span>
                                        <span class="w-70 text-secondary-light fw-medium">: <?= $author_details['basic_author_details']['bank_acc_no'] ?></span>
                                    </li>

                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light">IFSC</span>
                                        <span class="w-70 text-secondary-light fw-medium">: <?= $author_details['basic_author_details']['ifsc_code'] ?></span>
                                    </li>

                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light">PAN</span>
                                        <span class="w-70 text-secondary-light fw-medium">: <?= $author_details['basic_author_details']['pan_number'] ?></span>
                                    </li>

                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light">Social</span>
                                        <span class="w-70 text-secondary-light fw-medium">
                                            : FB: <?= $author_details['basic_author_details']['fb_url'] ?>,
                                            Twitter: <?= $author_details['basic_author_details']['twitter_url'] ?>,
                                            Blog: <?= $author_details['basic_author_details']['blog_url'] ?>
                                        </span>
                                    </li>

                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light">Agreement</span>
                                        <span class="w-70 text-secondary-light fw-medium">: <?= $author_details['basic_author_details']['agreement_details'] ?></span>
                                    </li>

                                    <li class="d-flex align-items-center gap-1">
                                        <span class="w-30 text-md fw-semibold text-primary-light">Description</span>
                                        <span class="w-70 text-secondary-light fw-medium">: <?= $author_details['basic_author_details']['description'] ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Books Tab -->
        <div class="tab-pane fade" id="books_details" role="tabpanel" aria-labelledby="pills-button-icon-details-tab">
            <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                <div class="card-header py-16 px-24 bg-base border border-end-0 border-start-0 border-top-0">
                    <h6 class="text-lg mb-0">Books Overview</h6>
                </div>

                <div class="card-body p-24 pt-10">
                    <ul class="nav focus-tab nav-pills mb-16" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10 active"
                                id="pills-ebooks-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#books_tab"
                                type="button"
                                role="tab"
                                aria-controls="books_tab"
                                aria-selected="true"
                            >
                                <iconify-icon icon="mdi:book-open-page-variant" class="me-1"></iconify-icon>
                                E-Books
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10"
                                id="pills-audio-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#audio_books_tab"
                                type="button"
                                role="tab"
                                aria-controls="audio_books_tab"
                                aria-selected="false"
                            >
                                <iconify-icon icon="mdi:headphones" class="me-1"></iconify-icon>
                                Audio Books
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10"
                                id="pills-paper-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#paperback_books_tab"
                                type="button"
                                role="tab"
                                aria-controls="paperback_books_tab"
                                aria-selected="false"
                            >
                                <iconify-icon icon="mdi:book" class="me-1"></iconify-icon>
                                Paperbacks
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="books-pills-tabContent">
                        <!-- E-Books -->
                        <div class="tab-pane fade show active" id="books_tab" role="tabpanel" aria-labelledby="pills-ebooks-tab">
                            <div class="row gy-4">
                                <div class="col-xxl-3 col-sm-6">
                                    <div class="card h-100 radius-12 bg-gradient-purple text-center">
                                        <div class="card-body p-24">
                                            <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-lilac-600 text-white mb-16 radius-12">
                                                <iconify-icon icon="mdi:book-open-page-variant" class="h5 mb-0"></iconify-icon>
                                            </div>
                                            <h6 class="mb-8">Total E-Books</h6>
                                            <h4><?= $ebook_count['total_count']['ebook_count']; ?></h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xxl-3 col-sm-6">
                                    <div class="card h-100 radius-12 bg-gradient-primary text-center">
                                        <div class="card-body p-24">
                                            <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-primary-600 text-white mb-16 radius-12">
                                                <iconify-icon icon="mdi:book-check" class="h5 mb-0"></iconify-icon>
                                            </div>
                                            <h6 class="mb-8">Active</h6>
                                            <h4><?= $ebook_count['active']['ebook_count']; ?></h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xxl-3 col-sm-6">
                                    <div class="card h-100 radius-12 bg-gradient-success text-center">
                                        <div class="card-body p-24">
                                            <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-success-600 text-white mb-16 radius-12">
                                                <iconify-icon icon="mdi:book-remove" class="h5 mb-0"></iconify-icon>
                                            </div>
                                            <h6 class="mb-8">Inactive</h6>
                                            <h4><?= $ebook_count['inactive']['ebook_count']; ?></h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xxl-3 col-sm-6">
                                    <div class="card h-100 radius-12 bg-gradient-danger text-center">
                                        <div class="card-body p-24">
                                            <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-danger-600 text-white mb-16 radius-12">
                                                <iconify-icon icon="mdi:book-lock" class="h5 mb-0"></iconify-icon>
                                            </div>
                                            <h6 class="mb-8">Suspended</h6>
                                            <h4><?= $ebook_count['suspended']['ebook_count']; ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Audio Books -->
                        <div class="tab-pane fade" id="audio_books_tab" role="tabpanel" aria-labelledby="pills-audio-tab">
                            <?php if ($audio_count['total_count']['audio_count'] > 0) { ?>
                                <div class="row gy-4">
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card h-100 radius-12 bg-gradient-purple text-center">
                                            <div class="card-body p-24">
                                                <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-lilac-600 text-white mb-16 radius-12">
                                                    <iconify-icon icon="mdi:headphones" class="h5 mb-0"></iconify-icon>
                                                </div>
                                                <h6 class="mb-8">Total Audio Books</h6>
                                                <h4><?= $audio_count['total_count']['audio_count']; ?></h4>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card h-100 radius-12 bg-gradient-primary text-center">
                                            <div class="card-body p-24">
                                                <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-primary-600 text-white mb-16 radius-12">
                                                    <iconify-icon icon="mdi:headphones-check" class="h5 mb-0"></iconify-icon>
                                                </div>
                                                <h6 class="mb-8">Active</h6>
                                                <h4><?= $audio_count['active']['audio_count']; ?></h4>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card h-100 radius-12 bg-gradient-success text-center">
                                            <div class="card-body p-24">
                                                <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-success-600 text-white mb-16 radius-12">
                                                    <iconify-icon icon="mdi:headphones-off" class="h5 mb-0"></iconify-icon>
                                                </div>
                                                <h6 class="mb-8">Inactive</h6>
                                                <h4><?= $audio_count['inactive']['audio_count']; ?></h4>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card h-100 radius-12 bg-gradient-danger text-center">
                                            <div class="card-body p-24">
                                                <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-danger-600 text-white mb-16 radius-12">
                                                    <iconify-icon icon="mdi:headphones-pause" class="h5 mb-0"></iconify-icon>
                                                </div>
                                                <h6 class="mb-8">Suspended</h6>
                                                <h4><?= $audio_count['suspended']['audio_count']; ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <center><h3>No Audio Books</h3></center>
                            <?php } ?>
                        </div>

                        <!-- Paperbacks -->
                        <div class="tab-pane fade" id="paperback_books_tab" role="tabpanel" aria-labelledby="pills-paper-tab">
                            <?php if (isset($paperback['total_counts']) && $paperback['total_counts']['paperback_count'] > 0) { ?>
                                <div class="row gy-4">
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card h-100 radius-12 bg-gradient-purple text-center">
                                            <div class="card-body p-24">
                                                <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-lilac-600 text-white mb-16 radius-12">
                                                    <iconify-icon icon="mdi:book" class="h5 mb-0"></iconify-icon>
                                                </div>
                                                <h6 class="mb-8">Total Paperbacks</h6>
                                                <h4><?= $paperback['total_counts']['paperback_count']; ?></h4>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card h-100 radius-12 bg-gradient-primary text-center">
                                            <div class="card-body p-24">
                                                <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-primary-600 text-white mb-16 radius-12">
                                                    <iconify-icon icon="mdi:book-check" class="h5 mb-0"></iconify-icon>
                                                </div>
                                                <h6 class="mb-8">Active</h6>
                                                <h4><?= $paperback['active']['paperback_count']; ?></h4>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card h-100 radius-12 bg-gradient-success text-center">
                                            <div class="card-body p-24">
                                                <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-success-600 text-white mb-16 radius-12">
                                                    <iconify-icon icon="mdi:book-remove" class="h5 mb-0"></iconify-icon>
                                                </div>
                                                <h6 class="mb-8">Inactive</h6>
                                                <h4><?= $paperback['inactive']['paperback_count']; ?></h4>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card h-100 radius-12 bg-gradient-danger text-center">
                                            <div class="card-body p-24">
                                                <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-danger-600 text-white mb-16 radius-12">
                                                    <iconify-icon icon="mdi:book-lock" class="h5 mb-0"></iconify-icon>
                                                </div>
                                                <h6 class="mb-8">Suspended</h6>
                                                <h4><?= $paperback['suspended']['paperback_count']; ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <center><h3>No Paperbacks</h3></center>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Channel Tab -->
        <div class="tab-pane fade" id="channel_details" role="tabpanel" aria-labelledby="pills-button-icon-profile-tab">
            <div class="row gy-4">

                <!-- Pustaka -->
                <div class="col-xxl-3 col-sm-6">
                <div class="card h-100 radius-12 bg-gradient-purple text-center">
                    <div class="card-body p-24">
                    <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-lilac-600 text-white mb-16 radius-12">
                        <iconify-icon icon="mdi:book-open-page-variant" class="h5 mb-0"></iconify-icon>
                    </div>
                    <h6 class="mb-8">Pustaka</h6>
                    <h3 class="mb-8"><?php echo $author_details['channel_wise_cnt']['pustaka']; ?></h3>
                    <p class="card-text mb-8 text-secondary-light">Books available on Pustaka platform.</p>
                    <a href="<?php echo base_url()."author/authorpustakadetails/".$author_id ?>" class="btn text-lilac-600 hover-text-lilac px-0 py-0 mt-16 d-inline-flex align-items-center gap-2">
                        View Details <iconify-icon icon="iconamoon:arrow-right-2" class="text-xl"></iconify-icon>
                    </a>
                    </div>
                </div>
                </div>

                <!-- Amazon -->
                <div class="col-xxl-3 col-sm-6">
                <div class="card h-100 radius-12 bg-gradient-primary text-center">
                    <div class="card-body p-24">
                    <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-primary-600 text-white mb-16 radius-12">
                        <iconify-icon icon="mdi:amazon" class="h5 mb-0"></iconify-icon>
                    </div>
                    <h6 class="mb-8">Amazon</h6>
                    <h3 class="mb-8"><?php echo $author_details['channel_wise_cnt']['amazon']; ?></h3>
                    <p class="card-text mb-8 text-secondary-light">Available titles on Amazon store.</p>
                    <a href="<?php echo base_url()."author/authoramazondetails/".$author_id ?>" class="btn text-primary-600 hover-text-primary px-0 py-10 d-inline-flex align-items-center gap-2">
                        View Details <iconify-icon icon="iconamoon:arrow-right-2" class="text-xl"></iconify-icon>
                    </a>
                    </div>
                </div>
                </div>

                <!-- Google -->
                <div class="col-xxl-3 col-sm-6">
                <div class="card h-100 radius-12 bg-gradient-success text-center">
                    <div class="card-body p-24">
                    <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-success-600 text-white mb-16 radius-12">
                        <iconify-icon icon="mdi:google" class="h5 mb-0"></iconify-icon>
                    </div>
                    <h6 class="mb-8">Google Books</h6>
                    <h3 class="mb-8"><?php echo $author_details['channel_wise_cnt']['google']; ?></h3>
                    <p class="card-text mb-8 text-secondary-light">Books available through Google Books.</p>
                    <a href="<?php echo base_url()."author/authors_google_details/".$author_id ?>" class="btn text-success-600 hover-text-success px-0 py-10 d-inline-flex align-items-center gap-2">
                        View Details <iconify-icon icon="iconamoon:arrow-right-2" class="text-xl"></iconify-icon>
                    </a>
                    </div>
                </div>
                </div>

                <!-- Overdrive -->
                <div class="col-xxl-3 col-sm-6">
                <div class="card h-100 radius-12 bg-gradient-danger text-center">
                    <div class="card-body p-24">
                    <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-danger-600 text-white mb-16 radius-12">
                        <iconify-icon icon="mdi:book-account" class="h5 mb-0"></iconify-icon>
                    </div>
                    <h6 class="mb-8">Overdrive</h6>
                    <h3 class="mb-8"><?php echo $author_details['channel_wise_cnt']['overdrive']; ?></h3>
                    <p class="card-text mb-8 text-secondary-light">eBooks available via Overdrive.</p>
                    <a href="<?php echo base_url()."author/author_overdrive_details/".$author_id ?>" class="btn text-danger-600 hover-text-danger px-0 py-10 d-inline-flex align-items-center gap-2">
                        View Details <iconify-icon icon="iconamoon:arrow-right-2" class="text-xl"></iconify-icon>
                    </a>
                    </div>
                </div>
                </div>

                <!-- Scribd -->
                <div class="col-xxl-3 col-sm-6">
                <div class="card h-100 radius-12 bg-gradient-success text-center">
                    <div class="card-body p-24">
                    <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-warning-600 text-white mb-16 radius-12">
                        <iconify-icon icon="mdi:file-document-outline" class="h5 mb-0"></iconify-icon>
                    </div>
                    <h6 class="mb-8">Scribd</h6>
                    <h3 class="mb-8"><?php echo $author_details['channel_wise_cnt']['scribd']; ?></h3>
                    <p class="card-text mb-8 text-secondary-light">Audiobooks and eBooks on Scribd.</p>
                    <a href="<?php echo base_url()."author/author_scribd_details/".$author_id ?>" class="btn text-warning-600 hover-text-warning px-0 py-10 d-inline-flex align-items-center gap-2">
                        View Details <iconify-icon icon="iconamoon:arrow-right-2" class="text-xl"></iconify-icon>
                    </a>
                    </div>
                </div>
                </div>

                <!-- Storytel -->
                <div class="col-xxl-3 col-sm-6">
                <div class="card h-100 radius-12 bg-gradient-danger text-center">
                    <div class="card-body p-24">
                    <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-info-600 text-white mb-16 radius-12">
                        <iconify-icon icon="mdi:headphones" class="h5 mb-0"></iconify-icon>
                    </div>
                    <h6 class="mb-8">Storytel</h6>
                    <h3 class="mb-8"><?php echo $author_details['channel_wise_cnt']['storytel']; ?></h3>
                    <p class="card-text mb-8 text-secondary-light">Audiobooks on Storytel platform.</p>
                    <a href="<?php echo base_url()."author/author_storytel_details/".$author_id ?>" class="btn text-info-600 hover-text-info px-0 py-10 d-inline-flex align-items-center gap-2">
                        View Details <iconify-icon icon="iconamoon:arrow-right-2" class="text-xl"></iconify-icon>
                    </a>
                    </div>
                </div>
                </div>

                <!-- Pratilipi -->
                <div class="col-xxl-3 col-sm-6">
                <div class="card h-100 radius-12 bg-gradient-purple text-center">
                    <div class="card-body p-24">
                    <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-lilac-600 text-white mb-16 radius-12">
                        <iconify-icon icon="mdi:library" class="h5 mb-0"></iconify-icon>
                    </div>
                    <h6 class="mb-8">Pratilipi</h6>
                    <h3 class="mb-8"><?php echo $author_details['channel_wise_cnt']['pratilipi']; ?></h3>
                    <p class="card-text mb-8 text-secondary-light">Stories published on Pratilipi.</p>
                    <a href="<?php echo base_url()."author/author_pratilipi_details/".$author_id ?>" class="btn text-lilac-600 hover-text-lilac px-0 py-10 d-inline-flex align-items-center gap-2">
                        View Details <iconify-icon icon="iconamoon:arrow-right-2" class="text-xl"></iconify-icon>
                    </a>
                    </div>
                </div>
                </div>

            </div>
        </div>

        <!-- Royalty Tab -->
        <div class="tab-pane fade" id="royalty_details" role="tabpanel" aria-labelledby="pills-button-icon-settings-tab">
            <p>Royalty content goes here...</p>
        </div>

    </div> <!-- /.tab-content -->
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    // ======================== Upload Image Start =====================
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#imagePreview").css("background-image", "url(" + e.target.result + ")");
                $("#imagePreview").hide();
                $("#imagePreview").fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imageUpload").change(function () {
        readURL(this);
    });
    // ======================== Upload Image End =====================

    // ================== Password Show Hide Js Start ================
    function initializePasswordToggle(toggleSelector) {
        $(toggleSelector).on("click", function () {
            $(this).toggleClass("ri-eye-off-line");
            var input = $($(this).attr("data-toggle"));
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    }

    // Call the function
    initializePasswordToggle(".toggle-password");
    // ========================= Password Show Hide Js End ===========================
</script>
<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
<?= $this->endSection(); ?>
