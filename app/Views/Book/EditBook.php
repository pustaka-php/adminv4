<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>
  <div class="layout-px-spacing">
    <div class="page-header">
      <div class="page-title">
        <?php if ($book_details['type_of_book'] == 1) { ?>
            <h6>Edit Ebook</h6>
        <?php } else { ?>
            <h5>Edit Audio Book</h5>
        <?php } ?>
        <?php if ($book_details['status']==0) 
        {
          $status = "InActive";
        } else {
          $status = "Active";
        } ?>
        <h6>Current State - <?php echo $status; ?> </h6>
      </div>
    </div>

    <div class="row mb-4 mt-4">
        <div class="col-sm-12 col-12 order-sm-0 order-1">
            <div class="tab-content">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card p-4 shadow-sm radius-8 border input-form-light h-100 bg-gradient-end-1">
                            <div class="card-body">

                                <!-- Header: Title + Basic Info -->
                                <div class="d-flex flex-wrap align-items-start gap-3 mb-4">
                                    <span class="d-flex justify-content-center align-items-center w-48 h-48 bg-primary-600 text-white rounded-circle fs-5 flex-shrink-0">
                                        
                                    </span>
                                    <div class="flex-grow-1">
                                        <h6 class="fw-semibold mb-2"><?= esc($book_details['book_title']) ?></h6>
                                        <p class="text-secondary-light mb-0" style="font-size: 0.95rem;">
                                            <strong>Book ID:</strong> <?= esc($book_details['book_id']) ?><br>
                                            <strong>Regional Title:</strong> <?= esc($book_details['regional_book_title']) ?><br>
                                            <strong>Author:</strong> <?= esc($author_details['author_name']) ?><br>
                                            <strong>Ebook Copyright Owner:</strong> <?= esc($copy_right_owner_name) ?> (ID: <?= esc($copy_right_owner_id) ?>)<br>
                                            <strong>Created Date:</strong> <?= date('d-m-y', strtotime($book_details['created_at'])) ?><br>
                                            <strong>Ebook Activated Date:</strong> <?= date('d-m-y', strtotime($book_details['activated_at'])) ?><br>
                                            <strong>Paperback Activated Date:</strong> 
                                            <?= !empty($book_details['paperback_activate_at']) && $book_details['paperback_activate_at'] != '0' 
                                                ? date('d-m-Y', strtotime($book_details['paperback_activate_at'])) 
                                                : '-' 
                                            ?>
                                        </p>
                                    </div>

                                </div>

                                <!-- Book Metadata Table -->
                                <div class="table-responsive mb-4">
                                    <table class="table table-bordered table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>Language</th>
                                                <th>Genre</th>
                                                <th>Category</th>
                                                <th>Url Name</th>
                                                <th># Pages</th>
                                                <th>Cost (INR)</th>
                                                <th>Cost (USD)</th>
                                                <th>Book ID Mapping</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fw-medium">
                                            <tr>
                                                <td><?= esc($book_details['language']) ?></td>
                                                <td><?= esc($book_details['genre_id']) ?></td>
                                                <td><?= esc($book_details['book_category']) ?></td>
                                                <td><?= esc($book_details['url_name']) ?></td>
                                                <td><?= esc($book_details['number_of_page']) ?></td>
                                                <td>₹<?= esc($book_details['cost']) ?></td>
                                                <td>$<?= esc($book_details['book_cost_international']) ?></td>
                                                <td><?= esc($book_details['book_id_mapping']) ?></td>
                                                <td><?= esc($book_details['created_by']) ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Description & Remarks -->
                                <div class="mb-3">
                                    <label class="fw-medium">Description</label>
                                   <textarea class="form-control text-sm" rows="5" readonly><?= esc($book_details['description']) ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="fw-medium">Remarks</label>
                                    <textarea class="form-control" rows="5" readonly><?= isset($book_details['ebook_remarks']) ? esc($book_details['ebook_remarks']) : '' ?></textarea>
                                </div>

                                <!-- Edit Button -->
                                <a target="_blank" href="<?= base_url("book/editbookbasicdetails/".$book_details['book_id']) ?>" 
                                class="btn btn-info">
                                    Edit Basic Details
                                </a>

                            </div>
                        </div>
                    </div>
                </div>


                <!-- Book DETAILS -->
                <div class="tab-pane fade show active">
                    <blockquote class="blockquote">

                        <table class="table table-bordered table-hover mt-5" style="font-size: 0.9rem;">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Cover Image URL</th>
                                    <th scope="col">ePUB URL</th>
                                </tr>                                               
                            </thead>                                             
                            <tbody>
                                <tr>
                                    <td><?= esc($book_details['cover_image']) ?></td>
                                    <td><?= esc($book_details['epub_url']) ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <a target="_blank" href="<?= base_url("book/editbookurldetails/{$book_details['book_id']}") ?>" class="ml-2 btn btn-info btn-sm mb-3">Edit URLs</a>

                        <table class="table table-bordered table-hover mt-3" style="font-size: 0.9rem;">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">EPUB ISBN Number</th>
                                    <th scope="col">In Agreement?</th>
                                    <th scope="col">eBook Royalty</th>
                                </tr>                                               
                            </thead>                                             
                            <tbody>
                                <?php 
                                    $agreement_status = "Unknown";
                                    if (is_null($book_details['agreement_flag'])) $agreement_status = "Not Set";
                                    if ($book_details['agreement_flag'] === 0) $agreement_status = "Not Taken";
                                    if ($book_details['agreement_flag'] === 1) $agreement_status = "Available";
                                ?>
                                <tr>
                                    <td><?= esc($book_details['isbn_number']) ?></td>
                                    <td><?= esc($agreement_status) ?></td>
                                    <td><?= esc($book_details['royalty']) ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <a target="_blank" href="<?= base_url("book/editbookisbndetails/{$book_details['book_id']}") ?>" class="ml-2 btn btn-info btn-sm">Edit Details</a>

                    </blockquote>      
                </div>

                
                <!-- Paperback DETAILS -->
                <div class="tab-pane fade show active">
                    <blockquote class="blockquote">

                        <!-- Paperback Agreement & Royalty -->
                        <table class="table table-bordered table-hover mt-5" style="font-size: 0.9rem;">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Paperback</th>
                                    <th scope="col">Agreement</th>
                                    <th scope="col">Paperback Royalty</th>
                                    <th scope="col">Paperback Copyright Owner</th>
                                    <th scope="col">Paperback ISBN</th>
                                </tr>                                               
                            </thead>                                             
                            <tbody>
                                <?php 
                                    // Paperback Enabled?
                                    $paper_back_enabled = ($book_details['paper_back_flag'] == 1) ? "Yes" : "No";

                                    // Agreement Signed?
                                    $paper_back_agreement = ($book_details['paper_back_agreement_flag'] == 1) ? "Yes" : "No";

                                    // Only show details if enabled
                                    if ($book_details['paper_back_flag'] == 1) {
                                        $paper_back_royalty = $book_details['paper_back_royalty'] ?? '-';
                                        $paper_back_owner   = $book_details['paper_back_copyright_owner'] ?? '-';
                                        $paper_back_isbn    = $book_details['paper_back_isbn'] ?? '-';
                                    } else {
                                        $paper_back_royalty = "-";
                                        $paper_back_owner   = "-";
                                        $paper_back_isbn    = "-";
                                    }
                                ?>
                                <tr>
                                    <td><?= esc($paper_back_enabled) ?></td>
                                    <td><?= esc($paper_back_agreement) ?></td>
                                    <td><?= esc($paper_back_royalty) ?></td>
                                    <td><?= esc($paper_back_owner) ?></td>
                                    <td><?= esc($paper_back_isbn) ?></td>
                                </tr>
                            </tbody>
                        </table>


                        <!-- Paperback Cost, Pages, Readiness, Weight -->
                        <table class="table table-bordered table-hover mt-3" style="font-size: 0.9rem;">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Paperback Cost (INR)</th>
                                    <th scope="col">Paperback Pages</th>
                                    <th scope="col">Paperback Readiness</th>
                                    <th scope="col">Paperback Weight</th>
                                </tr>                                               
                            </thead>                                             
                            <tbody>
                                <?php 
                                    $flag = (int)$book_details['paper_back_readiness_flag'];
                                    $paper_back_readiness_flag = "Unknown";

                                    if (is_null($book_details['paper_back_readiness_flag'])) {
                                        $paper_back_readiness_flag = "Not Set";
                                    } elseif ($flag === 0) {
                                        $paper_back_readiness_flag = "Not Ready";
                                    } elseif ($flag === 1) {
                                        $paper_back_readiness_flag = "Indesign File Available";
                                    }
                                ?>
                                <tr>
                                    <td><?= esc($book_details['paper_back_inr']) ?></td>
                                    <td><?= esc($book_details['paper_back_pages']) ?></td>
                                    <td><?= esc($paper_back_readiness_flag) ?></td>
                                    <td><?= esc($book_details['paper_back_weight']) ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Paperback Remarks -->
                        <label class="mt-3">Remarks</label>
                        <textarea class="form-control" rows="5" style="font-size: 0.9rem;" readonly><?= esc($book_details['paper_back_remarks']) ?></textarea>
                        <br/>

                        <a target="_blank" href="<?= base_url("book/editbookpaperbackdetails/{$book_details['book_id']}") ?>" class="ml-2 btn btn-info btn-sm">Edit Paperback Details</a>
                        
                    </blockquote>      
                </div>

                
                <?php if ($book_details['type_of_book'] == 3) { ?>
                    <!-- Narrator DETAILS -->
                    <div class="tab-pane fade show active">
                        <blockquote class="blockquote">
                            <h6 mb-4> Narrator name: <?php echo $narrator_details['narrator_name']; ?></h6>
                            <h6 mb-4> Narrator Id: <?php echo $narrator_details['narrator_id']; ?></h6>
                            <h6 mb-4> Narrator URL Name: <?php echo $narrator_details['narrator_url']; ?></h6>
                            <h6 mb-4> Narrator Image URL: <?php echo $narrator_details['narrator_image']; ?></h6>
                            <h6 mb-4> Narrator User ID: <?php echo $narrator_details['user_id']; ?></h6>
                            <h6 mb-4> Duration: <?php echo $book_details['number_of_page']; ?></h6>

                        <table class="table table-bordered table-hover mt-5">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Agreement</th>
                                    <th scope="col">Copyright Owner</th>
                                    <th scope="col">Royalty</th>
                                    <th scope="col">Cost (INR)</th>
                                    <th scope="col">Cost (USD)</th>
                                    <th scope="col">Rental Cost (INR)</th>
                                </tr>                                               
                            </thead>                                             
                            <tbody style="font-weight: 800;">
                                <tr>
                                    <?php $agreement_status = "Unknown"; ?>
                                    <?php if (is_null($book_details['agreement_flag'])) { 
                                        $agreement_status = "Not Set"; ?>
                                    <?php } ?>
                                    <?php if ($book_details['agreement_flag'] == 0) { 
                                        $agreement_status = "Not Taken"; ?>
                                    <?php } ?>
                                    <?php if ($book_details['agreement_flag'] == 1) { 
                                        $agreement_status = "Available"; ?>
                                    <?php } ?>
                                    <th><?php echo $agreement_status; ?></th>
                                    <th><?php echo $book_details['copyright_owner']; ?></th>
                                    <th><?php echo $book_details['royalty']; ?></th>
                                    <th><?php echo $book_details['cost']; ?></th>
                                    <th><?php echo $book_details['book_cost_international']; ?></th>
                                    <th><?php echo $book_details['rental_cost_inr']; ?></th>
                                </tr>
                            </tbody>
                        </table>
                        <label class="mt-3">Description</label>
                        <textarea class="form-control" rows="7"><?php echo $narrator_details['description'] ?></textarea>
                        <br/>
                        <a target="_blank" href="<?php echo base_url()."book/edit_book_audiobook_details/". $book_details['book_id'] ?>" class="ml-2 btn btn-info">Edit Audiobook Details</a>                            
                        </blockquote>
                    </div>
                <?php } ?>

                <!-- Author DETAILS -->
                <div class="row mb-4">
                    <!-- Author DETAILS Card -->
                    <div class="col-xxl-6 col-sm-12 mb-4">
                        <div class="card p-3 shadow-sm radius-8 border input-form-light h-100 bg-gradient-end-2">
                            <div class="card-body">
                                <h6 class="fw-semibold mb-3">Author Details</h6>
                                <p class="text-secondary-light mb-1">
                                    <strong>Author Name:</strong> <?= esc($author_details['author_name']) ?><br>
                                    <strong>Author ID:</strong> <?= esc($author_details['author_id']) ?><br>

                                    <?php if (!empty($copy_right_owner_id) && empty($paper_back_owner_id)) : ?>
                                        <!-- Only Ebook Copyright Owner -->
                                        <strong>Copyright Owner:</strong> 
                                        <?= esc($copy_right_owner_name) ?> (ID: <?= esc($copy_right_owner_id) ?>)<br>

                                    <?php elseif (!empty($copy_right_owner_id) && !empty($paper_back_owner_id)) : ?>
                                        <?php if ($copy_right_owner_id == $paper_back_owner_id) : ?>
                                            <!-- Same Owner -->
                                            <strong>Copyright Owner:</strong> 
                                            <?= esc($copy_right_owner_name) ?> (ID: <?= esc($copy_right_owner_id) ?>)<br>
                                        <?php else : ?>
                                            <!-- Different Owners -->
                                            <strong>Ebook Copyright:</strong> 
                                            <?= esc($copy_right_owner_name) ?> (ID: <?= esc($copy_right_owner_id) ?>)<br>
                                            <strong>Paperback Copyright:</strong> 
                                            <?= esc($paper_back_owner_name) ?> (ID: <?= esc($paper_back_owner_id) ?>)<br>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <strong>Status:</strong> <?= esc($author_details['status']) ?><br>
                                    <strong>User ID:</strong> <?= esc($author_details['user_id']) ?><br>
                                    <strong>Activated Date:</strong> <?= date('d-m-Y', strtotime($author_details['activated_at'])) ?>
                                </p>

                            </div>
                        </div>
                    </div>

                    <!-- User DETAILS Card -->
                    <div class="col-xxl-6 col-sm-12 mb-4">
                        <div class="card p-3 shadow-sm radius-8 border input-form-light h-100 bg-gradient-end-3">
                            <div class="card-body">
                                <h6 class="fw-semibold mb-3">User Details</h6>
                                <p class="text-secondary-light mb-1">
                                    <strong>User Name:</strong> <?= esc($user_details['username']) ?><br>
                                    <strong>User ID:</strong> <?= esc($user_details['user_id']) ?><br>
                                    <strong>User Email:</strong> <?= esc($user_details['email']) ?><br>
                                    <strong>User Type:</strong> <?= esc($user_details['user_type']) ?>
                                </p>
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