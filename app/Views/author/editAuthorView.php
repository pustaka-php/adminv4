<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h5 class="text-center">Edit Author</h5><br>
            </div>
        </div>
        <div class="row mb-4 mt-4">
            <div class="col-sm-12 col-12 order-sm-0 order-1">
                <div class="tab-content">
                    <div class="col-xxl-12 col-sm-24">
                        <div class="card h-100 radius-12 bg-gradient-purple">
                            <div class="card-body p-24">
                               <!-- Author Details Section -->
                                <div class="d-flex align-items-center mb-12  text-center">
                                    <iconify-icon icon="mdi:pencil" class="h5 mb-0 text-lilac-600"></iconify-icon>
                                    <h5 class="mb-0">Author Details</h5>
                                </div>
                                <p class="card-text mb-8">
                                    <strong>Author Name:</strong> <?php echo $author_details['author_name']; ?><br>
                                    <strong>Author URL Name:</strong> <?php echo $author_details['url_name']; ?><br>
                                    <strong>Author Image:</strong> <?php echo $author_details['author_image']; ?><br>

                                    <?php if ($author_details['gender'] == 'M') { ?>
                                        <strong>Gender:</strong> Male<br>
                                    <?php } else { ?>
                                        <strong>Gender:</strong> Female<br>
                                    <?php } ?>

                                    <?php if ($author_details['author_type'] == 1) { ?>
                                        <strong>Author Type:</strong> Royalty<br>
                                    <?php } ?>
                                    <?php if ($author_details['author_type'] == 2) { ?>
                                        <strong>Author Type:</strong> Free<br>
                                    <?php } ?>
                                    <?php if ($author_details['author_type'] == 3) { ?>
                                        <strong>Author Type:</strong> Publisher<br>
                                    <?php } ?>

                                    <strong>Copyright Owner Name:</strong> <?php echo $author_details['copy_right_owner_name']; ?><br>
                                    <strong>Copyright Owner Relationship:</strong> <?php echo $author_details['relationship']; ?><br>
                                    <strong>Copyright Owner ID:</strong> <?php echo $author_details['copyright_owner']; ?><br>
                                    <strong>User ID:</strong> <?php echo $author_details['user_id']; ?><br>
                                </p>
                                <strong><label class="mt-3">Description</label></strong>
                                <textarea class="form-control mt-2" rows="5" readonly><?php echo $author_details['description'] ?></textarea>
                                <br>
                                <a target="_blank" href="<?php echo base_url()."author/editauthorbasicdetails/". $author_details['author_id'] ?>" 
                                class="btn text-lilac-600 hover-text-lilac px-0 py-0 mt-16 d-inline-flex align-items-center gap-2">
                                    Edit Basic Details 
                                    <iconify-icon icon="iconamoon:arrow-right-2" class="text-xl"></iconify-icon>
                                </a>

                            </div>
                        </div>
                    </div>
                    <br><br>
                    <!-- Agreement DETAILS -->
                    <div class="card h-100 radius-12 bg-gradient-success">
                        <div class="card-body p-24">
                            <div class="d-flex align-items-center mb-12  text-center">
                                <iconify-icon icon="fluent:toolbox-20-filled" class="h5 mb-0 text-lilac-600"></iconify-icon>
                                <h6 class="mb-8">From Author Table (Agreement Details)</h6>
                            </div>
                            <div class="mb-4">
                                <textarea class="form-control" rows="7" readonly><?php echo $author_details['agreement_details'] ?></textarea>
                            </div>
                            <br>
                            <!-- Table Card -->
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Book Counts</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table bordered-table mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Ebook Count</th>
                                                    <th scope="col">Audiobook Count</th>
                                                    <th scope="col">Paperback Count</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $author_details['agreement_ebook_count']; ?></td>
                                                    <td><?php echo $author_details['agreement_audiobook_count']; ?></td>
                                                    <td><?php echo $author_details['agreement_paperback_count']; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <a target="_blank" href="<?php echo base_url()."author/editauthoragreementdetails/". $author_details['author_id'] ?>" 
                                class="btn text-lilac-600 hover-text-info px-0 py-0 mt-16 d-inline-flex align-items-center gap-2">
                                Edit Agreement Details
                                <iconify-icon icon="iconamoon:arrow-right-2" class="text-xl"></iconify-icon>
                            </a>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <!-- Publisher DETAILS Column -->
                        <div class="col-md-6"> <!-- Half width on medium+ screens -->
                            <div class="card h-100 radius-12 bg-gradient-danger mb-4">
                                <div class="card-body p-24">
                                    <div class="d-flex align-items-center mb-12 text-center">
                                        <iconify-icon icon="mdi:book-open-page-variant" class="h5 mb-0 text-lilac-600"></iconify-icon>
                                        <h6 class="mb-0">Publisher Details</h6>
                                    </div>

                                    <p class="card-text mb-8">
                                        <strong>Publisher Id:</strong> <?php echo $publisher_details['publisher_id']; ?><br>
                                        <strong>Mobile:</strong> <?php echo $publisher_details['mobile']; ?><br>
                                        <strong>Email Id:</strong> <?php echo $publisher_details['email_id']; ?><br>
                                        <strong>Address:</strong> <?php echo $publisher_details['address']; ?><br>
                                        <strong>Publisher URL Name:</strong> <?php echo $publisher_details['publisher_url_name']; ?><br>
                                        <strong>Publisher Image:</strong> <?php echo $publisher_details['publisher_image']; ?><br>
                                        <strong>Copyright Owner:</strong> <?php echo $publisher_details['copyright_owner']; ?><br>
                                    </p>

                                    <a target="_blank" href="<?php echo base_url()."author/editauthorpublisherdetails/". $author_details['author_id'] ?>" 
                                    class="btn text-lilac-600 hover-text-lilac px-0 py-0 mt-16 d-inline-flex align-items-center gap-2">
                                        Edit Publisher Details 
                                        <iconify-icon icon="iconamoon:arrow-right-2" class="text-xl"></iconify-icon>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <br>
                        <!-- BANK AND PUBLISHER DETAILS -->
                        <div class="col-md-6">
                            <div class="card h-100 radius-12 bg-gradient-primary mb-4">
                                <div class="card-body p-24">
                                    <div class="d-flex align-items-center mb-12 text-center">
                                        <iconify-icon icon="mdi:bank-outline" class="h5 mb-0 text-lilac-600"></iconify-icon>
                                        <h6 class="mb-0">Bank Details</h6>
                                    </div>

                                    <p class="card-text mb-8">
                                        <strong>Bank Account No:</strong> <?php echo $publisher_details['bank_acc_no']; ?><br>
                                        <strong>Bank Account Name:</strong> <?php echo $publisher_details['bank_acc_name']; ?><br>
                                        <strong>Bank Account Type:</strong> <?php echo $publisher_details['bank_acc_type']; ?><br>
                                        <strong>Bank IFSC Code:</strong> <?php echo $publisher_details['ifsc_code']; ?><br>
                                        <strong>PAN Number:</strong> <?php echo $publisher_details['pan_number']; ?><br>
                                        <strong>Bonus Percentage:</strong> <?php echo $publisher_details['bonus_percentage']; ?><br>
                                    </p>

                                    <a target="_blank" href="<?php echo base_url()."author/editauthorbankdetails/". $author_details['author_id'] ?>" 
                                    class="btn text-lilac-600 hover-text-lilac px-0 py-0 mt-16 d-inline-flex align-items-center gap-2">
                                        Edit Bank Details 
                                        <iconify-icon icon="iconamoon:arrow-right-2" class="text-xl"></iconify-icon>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <!-- Copyright Mapping DETAILS -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Copyright Mapping</h5>
                            <a href="<?= base_url('author/addauthorcopyrightdetails/' . $author_details['author_id']); ?>" class="btn btn-sm btn-primary" target="_blank">
                                + Add
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table colored-row-table mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="bg-base">Author ID</th>
                                            <th scope="col" class="bg-base">Copyright Owner</th>
                                            <th scope="col" class="bg-base">Date Created</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($copyright_mapping_details as $copyright_mapping_detail) { ?>
                                            <tr class="align-middle">
                                                <td><?php echo $copyright_mapping_detail['author_id']; ?></td>
                                                <td>
                                                    <span class="fw-medium text-sm">
                                                        <?php echo $copyright_mapping_detail['copyright_owner']; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="fw-medium text-sm">
                                                        <?php echo date('d M, Y', strtotime($copyright_mapping_detail['date_created'])); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <br><br>
                   <!-- Author Name DETAILS -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Author Language Details</h5>
                        </div>
                        <div class="card-body">
                            <div class=" ">
                                <table class="table  mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="bg-base">Author ID</th>
                                            <th scope="col" class="bg-base">Language</th>
                                            <th scope="col" class="bg-base">Display Name 1</th>
                                            <th scope="col" class="bg-base">Display Name 2</th>
                                            <th scope="col" class="bg-base">Regional Author Name</th>
                                            <th scope="col" class="bg-base text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $bgClasses = ['bg-primary-light', 'bg-success-focus', 'bg-info-focus', 'bg-warning-focus', 'bg-danger-focus'];
                                        $i = 0;
                                        foreach ($author_language_details as $author_language_detail) { 
                                            $bg = $bgClasses[$i % count($bgClasses)];
                                        ?>
                                        <tr class="<?= $bg ?> align-middle">
                                            <td><?= $author_language_detail['author_id']; ?></td>
                                            <td><?= $author_language_detail['language_name']; ?></td>
                                            <td><span class="fw-medium text-sm"><?= $author_language_detail['display_name1']; ?></span></td>
                                            <td><span class="fw-medium text-sm"><?= $author_language_detail['display_name2']; ?></span></td>
                                            <td><span class="fw-medium text-sm"><?= $author_language_detail['regional_author_name']; ?></span></td>
                                            <td class="text-center">
                                                <a target="_blank" href="<?= base_url("author/editauthornamedetails/".$author_details['author_id']) ?>" class="btn btn-info btn-sm">Edit</a>
                                            </td>
                                        </tr>
                                        <?php $i++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <!-- User DETAILS -->
                    <div class="row">
                        <!-- USER DETAILS CARD (Purple) -->
                        <div class="col-md-6">
                            <div class="card h-100 radius-12 bg-gradient-purple mb-4">
                                <div class="card-body p-24">
                                    <div class="d-flex align-items-center mb-12 text-center">
                                        <iconify-icon icon="mdi:account-circle-outline" class="h5 mb-0 text-lilac-600"></iconify-icon>
                                        <h6 class="mb-0">User Details</h6>
                                    </div>

                                    <p class="card-text mb-8">
                                        <strong>User ID:</strong> <?php echo $user_details['user_id']; ?><br>
                                        <strong>Username:</strong> <?php echo $user_details['username']; ?><br>
                                        <strong>Email ID:</strong> <?php echo $user_details['email']; ?><br>

                                        <?php if ($user_details['channel'] == 'google') { ?>
                                            <strong>Logged in through:</strong> Google<br>
                                        <?php } else { ?>
                                            <strong>Logged in through:</strong> Email ID / Password<br>
                                        <?php } ?>

                                        <?php if ($user_details['password'] == '4732210395731ca375874a1e7c8f62f6') { ?>
                                            <strong>Password:</strong> Default (books123)<br>
                                        <?php } ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- AUTHOR SOCIAL MEDIA DETAILS CARD (Mild Yellow Gradient) -->
                        <div class="col-md-6">
                            <div class="card h-100 radius-12 bg-gradient-success mb-4">
                                <div class="card-body p-24">
                                    <div class="d-flex align-items-center mb-12 text-center">
                                        <iconify-icon icon="mdi:share-variant-outline" class="h5 mb-0 text-lilac-600"></iconify-icon>
                                        <h6 class="mb-0">Author Social Media Details</h6>
                                    </div>

                                    <p class="card-text mb-8">
                                        <strong>Facebook Link:</strong> <?php echo $author_details['fb_url']; ?><br>
                                        <strong>Twitter Link:</strong> <?php echo $author_details['twitter_url']; ?><br>
                                        <strong>Blog Link:</strong> <?php echo $author_details['blog_url']; ?><br>
                                    </p>

                                    <a target="_blank" 
                                    href="<?php echo base_url()."author/editauthorsocialmedialinks/". $author_details['author_id'] ?>" 
                                    class="btn text-lilac-600 hover-text-lilac px-0 py-0 mt-16 d-inline-flex align-items-center gap-2">
                                        Edit Social Media Details 
                                        <iconify-icon icon="iconamoon:arrow-right-2" class="text-xl"></iconify-icon>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <!-- Author Links DETAILS -->
                    <div class="row g-4">
                        <div class="col-xxl-12 col-sm-24">
                            <div class="card h-100 radius-12 bg-gradient-danger text-center">
                                <div class="card-body p-24">
                                    <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-danger-600 text-white mb-16 radius-12">
                                        <iconify-icon icon="ph:link-fill" class="h5 mb-0"></iconify-icon>
                                    </div>
                                    <h6 class="mb-8">Author Links</h6>
                                    <div class="text-start">
                                        <p class="mb-2"><strong>Amazon:</strong> <a target="_blank" href="<?php echo $author_details['amazon_link']; ?>"><?php echo $author_details['amazon_link']; ?></a></p>
                                        <p class="mb-2"><strong>Scribd:</strong> <a target="_blank" href="<?php echo $author_details['scribd_link']; ?>"><?php echo $author_details['scribd_link']; ?></a></p>
                                        <p class="mb-2"><strong>Google Books:</strong> <a target="_blank" href="<?php echo $author_details['googlebooks_link']; ?>"><?php echo $author_details['googlebooks_link']; ?></a></p>
                                        <p class="mb-2"><strong>StoryTel:</strong> <a target="_blank" href="<?php echo $author_details['storytel_link']; ?>"><?php echo $author_details['storytel_link']; ?></a></p>
                                        <p class="mb-2"><strong>Overdrive:</strong> <a target="_blank" href="<?php echo $author_details['overdrive_link']; ?>"><?php echo $author_details['overdrive_link']; ?></a></p>
                                        <p class="mb-2"><strong>Pinterest:</strong> <a target="_blank" href="<?php echo $author_details['pinterest_link']; ?>"><?php echo $author_details['pinterest_link']; ?></a></p>
                                        <p class="mb-2"><strong>Pratilipi:</strong> <a target="_blank" href="<?php echo $author_details['pratilipi_link']; ?>"><?php echo $author_details['pratilipi_link']; ?></a></p>
                                        <p class="mb-2"><strong>Audible:</strong> <a target="_blank" href="<?php echo $author_details['audible_link']; ?>"><?php echo $author_details['audible_link']; ?></a></p>
                                        <p class="mb-2"><strong>Odilo:</strong> <a target="_blank" href="<?php echo $author_details['odilo_link']; ?>"><?php echo $author_details['odilo_link']; ?></a></p>
                                    </div>
                                    <a target="_blank" href="<?php echo base_url()."author/editauthorlinks/". $author_details['author_id'] ?>" class="btn text-danger-600 hover-text-danger px-0 py-10 d-inline-flex align-items-center gap-2 mt-3">
                                        Edit Author Links <iconify-icon icon="iconamoon:arrow-right-2" class="text-xl"></iconify-icon>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>