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
                    <!-- Publisher DETAILS -->
                    <div class="tab-pane fade show active">
                        <blockquote class="blockquote">
                            <h5 class="mb-4">From Publisher Table:</h5>
                            <h6 class="mb-4">Publisher Id: <?php echo $publisher_details['publisher_id']; ?></h6>
                            <h6 class="mb-4">Mobile: <?php echo $publisher_details['mobile']; ?></h6>
                            <h6 class="mb-4">Email id: <?php echo $publisher_details['email_id']; ?></h6>
                            <h6 class="mb-4">Address: <?php echo $publisher_details['address']; ?></h6>
                            <h6 class="mb-4">Publisher URL Name: <?php echo $publisher_details['publisher_url_name']; ?></h6>
                            <h6 class="mb-4">Publisher Image: <?php echo $publisher_details['publisher_image']; ?></h6>
                            <h6 class="mb-4">Copyright Owner: <?php echo $publisher_details['copyright_owner']; ?></h6>
                            <a target="_blank" href="<?php echo base_url()."author/edit_author_publisher_details/". $author_details['author_id'] ?>" class="ml-2 btn btn-info">Edit Publisher Details</a>
                        </blockquote>
                    </div>
                    <br><br>
                    <!-- Bank DETAILS -->
                    <div class="tab-pane fade show active">
                        <blockquote class="blockquote">
                            <h2 mb-4>Bank Details from Publisher Table:</h2>
                            <h4 mb-4>Bank Account No: <?php echo $publisher_details['bank_acc_no']; ?></h4>
                            <h4 mb-4>Bank Account Name: <?php echo $publisher_details['bank_acc_name']; ?></h4>
                            <h4 mb-4>Bank Account Type: <?php echo $publisher_details['bank_acc_type']; ?></h4>
                            <h4 mb-4>Bank IFSC Code: <?php echo $publisher_details['ifsc_code']; ?></h4>
                            <h4 mb-4>PAN Number: <?php echo $publisher_details['pan_number']; ?></h4>
                            <h4 mb-4>Bonus Percentage: <?php echo $publisher_details['bonus_percentage']; ?></h4>
                            <a target="_blank" href="<?php echo base_url()."author/edit_author_bank_details/". $author_details['author_id'] ?>" class="ml-2 btn btn-info">Edit Bank Details</a>
                        </blockquote>
                    </div>
                    <br><br>
                    <!-- User DETAILS -->
                    <div class="tab-pane fade show active">
                        <blockquote class="blockquote">
                            <h2 mb-4>From User Table:</h2>
                            <h4 mb-4>User Id: <?php echo $user_details['user_id']; ?></h4>
                            <h4 mb-4>User Name: <?php echo $user_details['username']; ?></h4>
                            <h4 mb-4>Email id: <?php echo $user_details['email']; ?></h4>
                            <?php if ($user_details['channel'] == 'google') { ?>
                                <h4 mb-4>Logged in through: Google</h4>
                            <?php } else { ?>
                                <h4 mb-4>Logged in through: Email id/Password</h4>
                            <?php } ?>
                            <?php if ($user_details['password'] == '4732210395731ca375874a1e7c8f62f6') { ?>
                                <h4 mb-4>Password: Default (books123)</h4>
                            <?php } ?>
                        </blockquote>                        
                    </div>
                    <br><br>
                    <!-- Copyright Mapping DETAILS -->
                    <div class="tab-pane fade show active">
                        <blockquote class="blockquote">
                            <h2 mb-4>From Copyright mapping:</h2>
                            <table class="table table-bordered table-hover mt-5">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Author Id</th>
                                    <th scope="col">Copyright Owner</th>
                                    <th scope="col">Date Created</th>
                                </tr>                                               
                            </thead>                                             
                            <tbody style="font-weight: 800;">
                                <?php foreach ($copyright_mapping_details as $copyright_mapping_detail) { ?>
                                <tr>
                                    <th><?php echo $copyright_mapping_detail['author_id']; ?></th>
                                    <th><?php echo $copyright_mapping_detail['copyright_owner']; ?></th>
                                    <th><?php echo $copyright_mapping_detail['date_created']; ?></th>
                                </tr>
                                <?php } ?>
                            </tbody>
                            </table>
                            <a target="_blank" href="<?php echo base_url()."author/edit_author_copyright_details/". $author_details['author_id'] ?>" class="ml-2 btn btn-info">Edit Copyright Mapping Details</a>
                        </blockquote>                        
                    </div>
                    <br><br>
                    <!-- Author Name DETAILS -->
                    <div class="tab-pane fade show active">
                        <blockquote class="blockquote">
                            <h2 mb-4>From Author Language Table:</h2>
                            <table class="table table-bordered table-hover mt-5">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Author Id</th>
                                    <th scope="col">Language Id</th>
                                    <th scope="col">Display Name 1</th>
                                    <th scope="col">Display Name 2</th>
                                    <th scope="col">Regional Author Name</th>
                                </tr>                                               
                            </thead>                                             
                            <tbody style="font-weight: 800;">
                                <?php foreach ($author_language_details as $author_language_detail) { ?>
                                <tr>
                                    <th><?php echo $author_language_detail['author_id']; ?></th>
                                    <th><?php echo $author_language_detail['language_id']; ?></th>
                                    <th><?php echo $author_language_detail['display_name1']; ?></th>
                                    <th><?php echo $author_language_detail['display_name2']; ?></th>
                                    <th><?php echo $author_language_detail['regional_author_name']; ?></th>
                                </tr>
                                <?php } ?>
                            </tbody>
                            </table>
                            <a target="_blank" href="<?php echo base_url()."author/edit_author_name_details/". $author_details['author_id'] ?>" class="ml-2 btn btn-info">Edit Author Names</a>
                        </blockquote>                        
                    </div>
                    <br><br>
                    <!-- Author Social Media DETAILS -->
                    <div class="tab-pane fade show active">
                        <blockquote class="blockquote">
                            <h2 mb-4>From Author Table:</h2>
                            <h4 mb-4>Facebook Link: <?php echo $author_details['fb_url']; ?></h4>
                            <h4 mb-4>Twitter Link: <?php echo $author_details['twitter_url']; ?></h4>
                            <h4 mb-4>Blog Link: <?php echo $author_details['blog_url']; ?></h4>
                            <a target="_blank" href="<?php echo base_url()."author/edit_author_social_details/". $author_details['author_id'] ?>" class="ml-2 btn btn-info">Edit Social Media Details</a>
                        </blockquote>                        
                    </div>
                    <br><br>
                    <!-- Author Links DETAILS -->
                    <div class="tab-pane fade show active">
                        <blockquote class="blockquote">
                            <h2 mb-4>From Author Table:</h2>
                            <h4 mb-4>Amazon Link: <?php echo $author_details['amazon_link']; ?></h4>
                            <h4 mb-4>Scribd Link: <?php echo $author_details['scribd_link']; ?></h4>
                            <h4 mb-4>Googlebooks Link: <?php echo $author_details['googlebooks_link']; ?></h4>
                            <h4 mb-4>StoryTel Link: <?php echo $author_details['storytel_link']; ?></h4>
                            <h4 mb-4>Overdrive Link: <?php echo $author_details['overdrive_link']; ?></h4>
                            <h4 mb-4>Pinterest Link: <?php echo $author_details['pinterest_link']; ?></h4>
                            <h4 mb-4>Pratilipi Link: <?php echo $author_details['pratilipi_link']; ?></h4>
                            <h4 mb-4>Audible Link: <?php echo $author_details['audible_link']; ?></h4>
                            <h4 mb-4>Odilo Link: <?php echo $author_details['odilo_link']; ?></h4>
                            <a target="_blank" href="<?php echo base_url()."author/editauthorlinks/". $author_details['author_id'] ?>" class="ml-2 btn btn-info">Edit Author Links to Channels</a>
                        </blockquote>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>