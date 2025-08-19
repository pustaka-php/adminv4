<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid py-3">

    <div class="page-header">
      <div class="page-title">
        <?php if ($book_details['type_of_book'] == 1) { ?>
            <h6>Activate eBook</h6>
        <?php } else { ?>
            <h6>Activate Audio Book</h6>
        <?php } ?>
      </div>
    </div>

    <div class="row mb-4 mt-4">
        <div class="col-sm-12 col-12 order-sm-0 order-1">
    <div class="tab-content">
        <div class="card p-3 radius-8 shadow-none bg-gradient-dark-start-2 mb-12">
            <div class="card-body p-0">
                <!-- Header with icon -->
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-12">
                    <div class="d-flex align-items-center gap-2">
                        <span class="mb-0 w-48-px h-48-px bg-base text-pink text-2xl flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                            <i class="ri-book-2-fill"></i>
                        </span>
                        <div>
                            <h5 class="mb-0 fw-medium text-secondary-light text-lg">Book Details</h5>
                        </div>
                    </div>
                </div>

                <!-- Book details list -->
                <div class="d-flex flex-column gap-8">
                    <div class="d-flex align-items-center">
                        <div class="text-secondary-light fw-medium">Title:</div>
                        <div><?= esc($book_details['book_title']) ?></div>
                    </div>
                    
                    <div class="d-flex align-items-center">
                        <div class="text-secondary-light fw-medium">Book ID:</div>
                        <div><?= esc($book_details['book_id']) ?></div>
                    </div>
                    
                    <div class="d-flex align-items-center">
                        <div class="text-secondary-light fw-medium">Regional Title:</div>
                        <div><?= esc($book_details['regional_book_title']) ?></div>
                    </div>
                    
                    <div class="d-flex align-items-center">
                        <div class="text-secondary-light fw-medium">Author:</div>
                        <div><?= esc($author_details['author_name']) ?></div>
                    </div>
                    
                    <div class="d-flex align-items-center">
                        <div class="text-secondary-light fw-medium">Create Date:</div>
                        <div><?= esc($book_details['created_at']) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

                <!-- Book DETAILS -->
                <div class="tab-pane fade show active">
                    <blockquote class="blockquote">
                        <table class="table table-bordered table-hover mt-5">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Language</th>
                                    <th scope="col">Genre</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">URL Name</th>
                                    <th scope="col"># pages</th>
                                    <th scope="col">Cost (INR)</th>
                                    <th scope="col">Cost (USD)</th>
                                    <th scope="col">Created By</th>
                                </tr>                                               
                            </thead>                                             
                            <tbody >
                                <tr>
                                    <td><?php echo $book_details['language']; ?></td>
                                    <td><?php echo $book_details['genre_id']; ?></td>
                                    <td><?php echo $book_details['book_category']; ?></td>
                                    <td><?php echo $book_details['url_name']; ?></td>
                                    <td><?php echo $book_details['number_of_page']; ?></td>
                                    <td><?php echo $book_details['cost']; ?></td>
                                    <td><?php echo $book_details['book_cost_international']; ?></td>
                                    <td><?php echo $book_details['created_by']; ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered table-hover mt-5">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Cover Image URL</th>
                                    <th scope="col">epub URL</th>
                                </tr>                                               
                            </thead>                                             
                            <tbody >
                                <tr>
                                    <td><?php echo $book_details['cover_image']; ?></td>
                                    <td><?php echo $book_details['epub_url']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <table class="table table-bordered table-hover mt-5">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Agreement</th>
                                    <th scope="col">Paperback</th>
                                    <th scope="col">Copyright Owner</th>
                                    <th scope="col">Royalty</th>
                                </tr>                                               
                            </thead>                                             
                            <tbody >
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

                                    <?php $paper_back_status = "Unknown"; ?>
                                    <?php if (is_null($book_details['paper_back_flag'])) { 
                                        $paper_back_status = "Not Set"; ?>
                                    <?php } ?>
                                    <?php if ($book_details['paper_back_flag'] == 0) { 
                                        $paper_back_status = "Not Taken"; ?>
                                    <?php } ?>
                                    <?php if ($book_details['paper_back_flag'] == 1) { 
                                        $paper_back_status = "Available"; ?>
                                    <?php } ?>

                                    <td><?php echo $agreement_status; ?></td>
                                    <td><?php echo $paper_back_status; ?></td>
                                    <td><?php echo $book_details['copyright_owner']; ?></td>
                                    <td><?php echo $book_details['royalty']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <label class="mt-3">Description</label>
                        <textarea class="form-control" rows="7"><?php echo $book_details['description'] ?></textarea>
                    </blockquote>      
                </div>
                
                <?php if ($book_details['type_of_book'] == 3) { ?>
                    <!-- Narrator DETAILS -->
                    <div class="tab-pane fade show active">
                        <blockquote class="blockquote">
                            <div class="card-body">
            <ul class="list-unstyled mb-0">
                <li class="mb-2">
                    <span class="font-weight-bold">Narrator name:</span> 
                    <?= esc($narrator_details['narrator_name']) ?>
                </li>
                <li class="mb-2">
                    <span class="font-weight-bold">Narrator ID:</span> 
                    <?= esc($narrator_details['narrator_id']) ?>
                </li>
                <li class="mb-2">
                    <span class="font-weight-bold">Narrator URL Name:</span> 
                    <?= esc($narrator_details['narrator_url']) ?>
                </li>
                <li class="mb-2">
                    <span class="font-weight-bold">Narrator Image URL:</span> 
                    <?= esc($narrator_details['narrator_image']) ?>
                </li>
                <li class="mb-2">
                    <span class="font-weight-bold">Narrator User ID:</span> 
                    <?= esc($narrator_details['user_id']) ?>
                </li>
                <li class="mb-2">
                    <span class="font-weight-bold">Duration:</span> 
                    <?= esc($book_details['number_of_page']) ?>
                </li>
                <li class="mb-2">
                    <span class="font-weight-bold">Rental INR (Author Transaction):</span> 
                    <?= esc($book_details['rental_cost_inr']) ?>
                </li>
            </ul>
        </div>

        <table class="table table-bordered table-hover mt-5">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Agreement</th>
                    <th scope="col">Paperback</th>
                    <th scope="col">Copyright Owner</th>
                    <th scope="col">Royalty</th>
                </tr>                                               
            </thead>                                             
            <tbody >
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

                    <?php $paper_back_status = "Unknown"; ?>
                    <?php if (is_null($book_details['paper_back_flag'])) { 
                        $paper_back_status = "Not Set"; ?>
                    <?php } ?>
                    <?php if ($book_details['paper_back_flag'] == 0) { 
                        $paper_back_status = "Not Taken"; ?>
                    <?php } ?>
                    <?php if ($book_details['paper_back_flag'] == 1) { 
                        $paper_back_status = "Available"; ?>
                    <?php } ?>

                    <td><?php echo $agreement_status; ?></td>
                    <td><?php echo $paper_back_status; ?></td>
                    <td><?php echo $book_details['copyright_owner']; ?></td>
                    <td><?php echo $book_details['royalty']; ?></td>
                </tr>
            </tbody>
        </table>
                    <label class="mt-3">Description</label>
                    <textarea class="form-control" rows="7"><?php echo $narrator_details['description'] ?></textarea>
                    <label class="mt-3">Chapter Details</label>
                    <table class="table table-bordered table-hover mt-5">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Name (Eng)</th>
                                <th scope="col">URL</th>
                                <th scope="col">Duration</th>
                            </tr>                                               
                        </thead>                                             
                        <tbody >
                        <?php for ($i=0; $i<sizeof($audio_chapters); $i++) { ?>
                            <tr>
                                <td><?php echo $audio_chapters[$i]['chapter_id']; ?></td>
                                <td><?php echo $audio_chapters[$i]['chapter_name']; ?></td>
                                <td><?php echo $audio_chapters[$i]['chapter_name_english']; ?></td>
                                <td><?php echo $audio_chapters[$i]['chapter_url']; ?></td>
                                <td><?php echo $audio_chapters[$i]['chapter_duration']; ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </blockquote>      
            </div>
        <?php } ?>

            <div class="row">
                <!-- Author DETAILS -->
                <div class="col-md-6 mb-4">
                    <div class="card p-3 radius-8 shadow-none bg-gradient-dark-start-1 h-100">
                        <div class="card-body p-0">
                            <!-- Header with icon -->
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-12">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="mb-0 w-48-px h-48-px bg-base text-pink text-2xl flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                        <i class="ri-user-3-fill"></i>
                                    </span>
                                    <div>
                                        <span class="mb-0 fw-medium text-secondary-light text-lg">Author Details</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Author details list -->
                            <div class="d-flex flex-column gap-8">
                                <div class="d-flex align-items-center">
                                    <div class="text-secondary-light fw-medium">Author Name:</div>
                                    <div><?= esc($author_details['author_name']) ?></div>
                                </div>
                                
                                <div class="d-flex align-items-center">
                                    <div class="text-secondary-light fw-medium">Author ID:</div>
                                    <div><?= esc($author_details['author_id']) ?></div>
                                </div>
                                
                                <div class="d-flex align-items-center">
                                    <div class="text-secondary-light fw-medium">Copyright Owner:</div>
                                    <div><?= esc($author_details['copy_right_owner_name']) ?></div>
                                </div>
                                
                                <div class="d-flex align-items-center">
                                    <div class="text-secondary-light fw-medium">Status:</div>
                                    <div><?= esc($author_details['status']) ?></div>
                                </div>
                                
                                <div class="d-flex align-items-center">
                                    <div class="text-secondary-light fw-medium">Owner ID:</div>
                                    <div><?= esc($author_details['copyright_owner']) ?></div>
                                </div>
                                
                                <div class="d-flex align-items-center">
                                    <div class="text-secondary-light fw-medium">User ID:</div>
                                    <div><?= esc($author_details['user_id']) ?></div>
                                </div>
                                
                                <div class="d-flex align-items-center">
                                    <div class="text-secondary-light fw-medium">Activated Date:</div>
                                    <div><?= esc($author_details['activated_at']) ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User DETAILS -->
                <div class="col-md-6 mb-4">
                    <div class="card p-3 radius-8 shadow-none bg-gradient-dark-start-3 h-100">
                        <div class="card-body p-0">
                            <!-- Header with icon -->
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-12">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="mb-0 w-48-px h-48-px bg-base text-pink text-2xl flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                        <i class="ri-account-circle-fill"></i>
                                    </span>
                                    <div>
                                        <span class="mb-0 fw-medium text-secondary-light text-lg">User Details</span>
                                    </div>
                                </div>
                            </div>

                            <!-- User details list -->
                            <div class="d-flex flex-column gap-8">
                                <div class="d-flex align-items-center">
                                    <div class="text-secondary-light fw-medium">Username:</div>
                                    <div><?= esc($user_details['username']) ?></div>
                                </div>
                                
                                <div class="d-flex align-items-center">
                                    <div class="text-secondary-light fw-medium">User ID:</div>
                                    <div><?= esc($user_details['user_id']) ?></div>
                                </div>
                                
                                <div class="d-flex align-items-center">
                                    <div class="text-secondary-light fw-medium">Email:</div>
                                    <div><?= esc($user_details['email']) ?></div>
                                </div>
                                
                                <div class="d-flex align-items-center">
                                    <div class="text-secondary-light fw-medium">User Type:</div>
                                    <div><?= esc($user_details['user_type']) ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <!-- Copyright Mapping DETAILS -->
                <div class="tab-pane fade show active">
                    <blockquote class="blockquote">
                        <label class="mt-3">Copyright Mappings</label>
                            <table class="table table-bordered table-hover mt-5">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Copyright Owner</th>
                                        <th scope="col">Author ID</th>
                                    </tr>                                               
                                </thead>                                             
                                <tbody >
                                <?php for ($i=0; $i<sizeof($copyright_mapping_details); $i++) { ?>
                                    <tr>
                                        <td><?php echo $copyright_mapping_details[$i]['copyright_owner']; ?></td>
                                        <td><?php echo $copyright_mapping_details[$i]['author_id']; ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                    </blockquote>      
                </div>

                <!-- Actions -->
                
                <?php 
                    $activate_flag = true;
                    if ($book_details['copyright_owner'] == 0)
                    {
                        $activate_flag = false;
                        $copyright_message = "Copyright owner: Not set!!!";
                    }
                    else
                    {
                        $copyright_message = "Copyright owner: " . $book_details['copyright_owner'];
                    }
                    if ($book_details['royalty'] == 0)
                    {
                        $activate_flag = false;
                        $royalty_message = "Royalty: Not set!!!";
                    }
                    else
                    {
                        $royalty_message = "Royalty: " . $book_details['royalty'] . "%";
                    }
                    if ($book_details['cost'] == 0)
                    {
                        $activate_flag = false;
                        $cost_message = "Cost: Free book!!!";
                    }
                    else
                    {
                        $cost_message = "Cost: " . $book_details['cost'];
                    }
                    if ($author_details['status'] == 'Inactive')
                    {
                        $activate_flag = false;
                        $author_message = "Author Status: Not activated!!!";
                    }
                    else
                    {
                        $author_message = "Author Status: Active";
                    }
                    if (strlen($book_details['description']) == 0)
                    {
                        $activate_flag = false;
                        $description_message = "Description: Not set!!!";
                    }
                    else
                    {
                        $description_message = "Description: Set";
                    }

                    $copyright_mapping_flag = false;
                    for ($i=0; $i<sizeof($copyright_mapping_details); $i++) 
                    {
                        if ($copyright_mapping_details[$i]['author_id'] == $author_details['author_id'])
                        {
                            $copyright_mapping_flag = true;
                        }
                    }
                    if (!$copyright_mapping_flag)
                    {
                        $activate_flag = false;
                        $copyright_mapping_message = "Copyright Mapping: Not available!!!";
                    }
                    else
                    {
                        $copyright_mapping_message = "Copyright Mapping: Available";
                    }
                    if ($book_details['type_of_book'] == 3)
                    {
                        if ($book_details['narrator_id'] == 0)
                        {
                            $activate_flag = false;
                            $narrator_message = "Narrator Name: Not set!!!!";
                        }
                        else
                        {
                            $narrator_message = "Narrator Name: " . $narrator_details['narrator_name'];
                        }
                    }
                ?>
               <div class="tab-pane fade show active">
    <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-6">
        <div class="card-body p-0">
            <!-- Header with icon -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-12">
                <div class="d-flex align-items-center gap-2">
                    <span class="mb-0 w-48-px h-48-px bg-base text-pink text-2xl flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                        <i class="ri-copyright-fill"></i>
                    </span>
                    <div>
                        <span class="mb-0 fw-medium text-secondary-light text-lg">Copyright & Details</span>
                    </div>
                </div>
            </div>

            <!-- Messages list -->
            <div class="d-flex flex-column gap-8">
                <div class="d-flex align-items-start gap-8">
                    <i class="ri-checkbox-circle-fill text-success mt-1"></i>
                    <div><?= esc($copyright_message) ?></div>
                </div>
                
                <div class="d-flex align-items-start gap-8">
                    <i class="ri-checkbox-circle-fill text-success mt-1"></i>
                    <div><?= esc($description_message) ?></div>
                </div>
                
                <div class="d-flex align-items-start gap-8">
                    <i class="ri-checkbox-circle-fill text-success mt-1"></i>
                    <div><?= esc($royalty_message) ?></div>
                </div>
                
                <div class="d-flex align-items-start gap-8">
                    <i class="ri-checkbox-circle-fill text-success mt-1"></i>
                    <div><?= esc($cost_message) ?></div>
                </div>
                
                <div class="d-flex align-items-start gap-8">
                    <i class="ri-checkbox-circle-fill text-success mt-1"></i>
                    <div><?= esc($author_message) ?></div>
                </div>
                
                <div class="d-flex align-items-start gap-8">
                    <i class="ri-checkbox-circle-fill text-success mt-1"></i>
                    <div><?= esc($copyright_mapping_message) ?></div>
                </div>
                
                <?php if ($book_details['type_of_book'] == 3): ?>
                <div class="d-flex align-items-start gap-8">
                    <i class="ri-checkbox-circle-fill text-success mt-1"></i>
                    <div><?= esc($narrator_message) ?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

                <div class="tab-pane fade show active">
                    <blockquote class="blockquote">
                        <span style="color: black" class="ml-1">
    Book Link: 
    <a target="_blank" style="color: blue" href="<?= config('App')->pustaka_url ?>/home/ebook/<?= strtolower($book_details['language']) ?>/<?= $book_details['url_name'] ?>">
        <?= config('App')->pustaka_url ?>home/ebook/<?= strtolower($book_details['language']) ?>/<?= $book_details['url_name'] ?>
    </a>
                </span>
                        <?php if ($book_details['status'] == 1) { 
                            $activate_flag = false; ?>
                            <h6 style="color: black" class="ml-1">Book already active!!</h6>
                        <?php } ?>

                        <?php if ((!$activate_flag) and ($book_details['status'] == 0)) { ?>
                            <h6 style="color: black" class="ml-1">Fix Errors!!!</h6>
                        <?php } ?>

                        <?php if ($activate_flag) { ?>
    <div class="d-flex align-items-center gap-2 mt-3">
        <input type="checkbox" 
            class="form-check-input" 
            id="send_mail_input" 
            checked
            style="width: 18px; height: 18px; cursor: pointer">
        <label for="send_mail_input" 
            class="fw-medium mb-0 cursor-pointer"
            style="user-select: none">
            Send eMail to Author
        </label>
    </div>
    <button onclick="activateBook(<?= $book_details['book_id'] ?>)" 
            class="mt-3 btn btn-success">
        ACTIVATE
    </button>
<?php } ?>
                    </blockquote>      
                </div>
            </div>
        </div>
    </div>
  </div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    function activateBook(book_id) {
    const sendMail = document.getElementById("send_mail_input").checked;

    $.ajax({
        url: "<?= base_url('book/activatebook') ?>",
        method: "POST",
        data: {
            "book_id": book_id,
            "send_mail": sendMail
        },
        success: function(response) {
            if (response.success) {
                alert(response.message);
                location.reload();
            } else {
                alert("Error: " + response.message);
            }
        },
        error: function(xhr, status, error) {
            alert("Request failed: " + error);
        }
    });
}
</script>
<?= $this->endSection(); ?>