<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>
<div class="row gy-4">
    <div class="col-xxl-12">
        <div class="card position-relative">
            <div class="row g-0">
                <!-- Main Content (Left Side) -->
                <div class="col-md-10">
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <!-- Not Started Card -->
                            <div class="col-md-4">
                                <div class="trail-bg h-100 text-center d-flex flex-column justify-content-between align-items-center p-3 rounded-3">
                                    <h6 class="text-white">Not Started</h6>
                                    <div>
                                        <h6 class="text-white"><?= $ebooks_data['total_not_start']; ?> books</h6>
                                        <a href="<?= base_url(); ?>book/notstartedbooks" class="btn rounded-pill btn-info-100 text-info-600 radius-8 px-20 py-11">View</a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Status Cards -->
                           <div class="col-md-8">
                                <div class="row g-3">
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="radius-8 h-100 text-center p-20 bg-purple-light">
                                            <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-xl mb-12 bg-lilac-200 border border-lilac-400 text-lilac-600">
                                                <i class="ri-pause-circle-line text-purple"></i>
                                            </span>
                                            <span class="d-block">On Hold</span>
                                            <h6 class="mb-0"><?= $ebooks_data['holdbook_cnt']; ?></h6>
                                            <a href="<?= base_url(); ?>book/getholdbookdetails" class="mt-1 d-inline-block text-purple">
                                                <i class="ri-eye-fill"></i> View
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- In Progress -->
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="radius-8 h-100 text-center p-20 bg-success-100">
                                            <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-xl mb-12 bg-success-200 border border-success-400 text-success-600">
                                                <i class="ri-edit-box-line text-success"></i>
                                            </span>
                                            <span class="d-block">In Progress</span>
                                            <h6 class="mb-0"><?= $ebooks_data['in_progress_cnt']; ?></h6>
                                            <p class="text-sm mt-1 mb-0 text-success">Ongoing</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Completed -->
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="radius-8 h-100 text-center p-20 bg-info-focus">
                                            <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-xl mb-12 bg-info-200 border border-info-400 text-info-600">
                                                <i class="ri-checkbox-circle-line text-info"></i>
                                            </span>
                                            <span class="d-block">Published</span>
                                            <h6 class="mb-0"><?= $ebooks_data['completed_flag_cnt']; ?></h6>
                                            <a href="<?= base_url(); ?>book/getactivebooks" class="mt-1 d-inline-block text-info">
                                                <i class="ri-eye-fill"></i> View
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- Pending -->
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="radius-8 h-100 text-center p-20 bg-danger-100">
                                            <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-xl mb-12 bg-danger-200 border border-danger-400 text-danger-600">
                                                <i class="ri-time-line text-danger"></i>
                                            </span>
                                            <span class="d-block">Pending For Activation</span>
                                            <h6 class="mb-0"><?= $ebooks_data['in_active_cnt']; ?></h6>
                                            <a href="<?= base_url(); ?>book/getinactivebooks" class="mt-1 d-inline-block text-danger">
                                                <i class="ri-eye-fill"></i> View
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Buttons Column (Right Side) -->
                <div class="col-md-2 d-flex flex-column justify-content-center align-items-center gap-3 p-3;">
                    <a href="<?= base_url('book/addbook') ?>"
                       class="btn rounded-pill shadow-sm text-white w-100"
                       style="background: linear-gradient(45deg, rgb(166, 0, 255), rgb(244, 202, 228)); border: none;">
                       <i class="ri-add-line me-1"></i> Add Book
                    </a>
                    <a href="<?= base_url('book/browseinprogressbooks') ?>"
                       class="btn rounded-pill shadow-sm text-white w-100"
                       style="background: linear-gradient(45deg, rgb(236, 61, 134), rgb(226, 239, 155)); border: none;">
                       <i class="ri-book-open-line me-1"></i> Browse
                    </a>
                </div>
            </div>
        </div>
        <br>
    
   
    <!-- Status Summary Table with Buttons -->
    <div class="card shadow-sm rounded-4 border-0">
    <div class="card-body p-3">
        <h6>Status Summary</h6>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Not Started</th>
                        <th>Scan</th>
                        <th>OCR</th>
                        <th>Level 1</th>
                        <th>Level 2</th>
                        <th>Cover</th>
                        <th>Generation</th>
                        <th>Upload</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-nowrap">
                            <i class="ri-book-2-line text-primary me-1"></i>
                            Full Cycle - Hardcopy
                        </td>
                        <td><?= $ebooks_data['not_start_hardcopy'] ?></td>
                        <td><?= $ebooks_data['scan_flag_cnt'] ?></td>
                        <td><?= $ebooks_data['ocr_flag_cnt'] ?></td>
                        <td><?= $ebooks_data['level1_flag_cnt'] ?></td>
                        <td><?= $ebooks_data['level2_flag_cnt'] ?></td>
                        <td><?= $ebooks_data['cover_flag_cnt'] ?></td>
                        <td><?= $ebooks_data['book_generation_flag_cnt'] ?></td>
                        <td><?= $ebooks_data['upload_flag_cnt'] ?></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap">
                            <i class="ri-file-word-line text-info me-1"></i>
                            Softcopy - Word
                        </td>
                        <td><?= $ebooks_data['not_start_wrd'] ?></td>
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                        <td><?= $ebooks_data['cover_flag_cnt_wrd'] ?></td>
                        <td><?= $ebooks_data['book_generation_flag_wrd'] ?></td>
                        <td><?= $ebooks_data['upload_flag_cnt_wrd'] ?></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap">
                            <i class="ri-file-pdf-line text-danger me-1"></i>
                            Softcopy - PDF
                        </td>
                        <td><?= $ebooks_data['not_start_pdf'] ?></td>
                        <td>--</td>
                        <td><?= $ebooks_data['ocr_flag_cnt_pdf'] ?></td>
                        <td><?= $ebooks_data['level1_flag_cnt_pdf'] ?></td>
                        <td><?= $ebooks_data['level2_flag_cnt_pdf'] ?></td>
                        <td><?= $ebooks_data['cover_flag_cnt_pdf'] ?></td>
                        <td><?= $ebooks_data['book_generation_flag_pdf'] ?></td>
                        <td><?= $ebooks_data['upload_flag_cnt_pdf'] ?></td>
                    </tr>
                </tbody>
                    <tr>
                        <td>Total</td>
                        <td><?= $ebooks_data['not_start_hardcopy'] + $ebooks_data['not_start_pdf'] + $ebooks_data['not_start_wrd'] ?></td>
                        <td><?= $ebooks_data['scan_flag_cnt'] ?></td>
                        <td><?= $ebooks_data['ocr_flag_cnt'] + $ebooks_data['ocr_flag_cnt_pdf'] ?></td>
                        <td><?= $ebooks_data['level1_flag_cnt'] + $ebooks_data['level1_flag_cnt_pdf'] ?></td>
                        <td><?= $ebooks_data['level2_flag_cnt'] + $ebooks_data['level2_flag_cnt_pdf'] ?></td>
                        <td><?= $ebooks_data['cover_flag_cnt'] + $ebooks_data['cover_flag_cnt_wrd'] + $ebooks_data['cover_flag_cnt_pdf'] ?></td>
                        <td><?= $ebooks_data['book_generation_flag_cnt'] + $ebooks_data['book_generation_flag_wrd'] + $ebooks_data['book_generation_flag_pdf'] ?></td>
                        <td><?= $ebooks_data['upload_flag_cnt'] + $ebooks_data['upload_flag_cnt_wrd'] + $ebooks_data['upload_flag_cnt_pdf'] ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
        <br>
        <h6>List of In Progress Books</h6>
        <table class="table zero-config">
    <thead>
            <tr>
                <th >S.No</th>   
                <th >Author</th>
                <th >BookID</th>
                <th >Title</th>
                <th >Scan</th>
                <th >OCR</th>
                <th >Level 1</th>
                <th >Level 2</th>
                <th >Cover</th>
                <th >Book Gen</th>
                <th >Upload</th>
                <th >Comp</th>
                <!-- <th >Action</th> -->
            </tr>
            </thead>
            <tbody>
        
							<?php  
                                    $i=1;
                                    foreach ($ebooks_data['status_details'] as $ebooks_details) {
                                    ?>
                				<tr>
                                    <td ><?php echo $i++; ?></td>
                                    <td ><?php echo $ebooks_details['author_name']; ?></td>
                                    <td ><center><?php echo $ebooks_details['book_id']; ?></center>
                                    
                                      <button class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-xl mb-12 bg-blue-200 border border-blue-400 text-blue-600" data-bs-toggle="modal" data-bs-target="#holdModal<?= $ebooks_details['book_id']; ?>" title="Hold">
                                            <i class="ri-pause-circle-line text-danger"></i>
                                        </button>

                                        <button class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-xl mb-12 bg-blue-100 border border-blue-400 text-blue-600" data-bs-toggle="modal" data-bs-target="#viewModal<?= $ebooks_details['book_id']; ?>" title="View">
                                            <i class="ri-eye-line text-primary"></i>
                                        </button>
                                    
                                    <td ><?php echo $ebooks_details['book_title'] ?></td>

                                    <?php if ($ebooks_details['scan_flag'] == 2) { ?>
                                        <td class="text-center" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"> <line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    <?php }elseif ($ebooks_details['scan_flag']  == 1) { ?>
                                        <td class="text-center" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                                    <?php } else { ?>
                                        <td ><button class="btn btn-primary mb-2 mr-2"><a href="" onclick="mark_scan_complete(<?php echo $ebooks_details['book_id'];?>)"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></a></td>
                                    <?php } ?>
                                   

                                    <?php if ($ebooks_details['ocr_flag'] == 2) { ?>
                                        <td class="text-center" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"> <line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    <?php }elseif ($ebooks_details['ocr_flag'] == 1) { ?>
                                        <td class="text-center" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                                    <?php } elseif ($ebooks_details['scan_flag']== 0) { ?>
                                        <td ><button class="btn btn-secondary mb-2 mr-2" disabled><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></td>
                                    <?php } else { ?>
                                        <td ><button class="btn btn-secondary mb-2 mr-2"><a href="" onclick="mark_ocr_complete(<?php echo $ebooks_details['book_id'];?>)"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></a></td>
                                    <?php } ?>

                                    
                                    <?php if ($ebooks_details['level1_flag'] == 2) { ?>
                                        <td class="text-center" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"> <line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    <?php }elseif ($ebooks_details['level1_flag'] == 1) { ?>
                                        <td class="text-center" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                                    <?php } elseif ($ebooks_details['ocr_flag'] == 0) { ?>
                                        <td ><button class="btn btn-danger mb-2 mr-2" disabled><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></td>
                                    <?php } else { ?>
                                        <td ><a href="" onclick="mark_level1_complete(<?php echo $ebooks_details['book_id'];?>)"><button class="btn btn-danger mb-2 mr-2 btn-sm"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></a></td>
                                    <?php } ?>


                                    <?php if ($ebooks_details['level2_flag'] == 2) { ?>
                                        <td class="text-center" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"> <line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    <?php }elseif ($ebooks_details['level2_flag'] == 1) { ?>
                                        <td class="text-center" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                                    <?php } elseif ($ebooks_details['level1_flag'] == 0) { ?>
                                        <td ><button class="btn btn-info mb-2 mr-2" disabled><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></td>
                                    <?php } else { ?>
                                        <td ><button class="btn btn-success mb-2 mr-2 btn-sm"><a href="" onclick="mark_level2_complete(<?php echo $ebooks_details['book_id'];?>)"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></a></td>
                                    <?php } ?>

                                   <?php if ($ebooks_details['cover_flag'] == 1) { ?>
                                        <td class="text-center" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                                    <?php } else { ?>
                                        <td ><button class="btn btn-info mb-2 mr-2 btn-sm"><a href="" onclick="mark_cover_complete(<?php echo $ebooks_details['book_id'];?>)"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></a></td>
                                    <?php } ?>

                                    
                                    <?php if ($ebooks_details['book_generation_flag'] == 1) { ?>
                                        <td class="text-center" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                                    <?php }elseif ($ebooks_details['level2_flag']== 0 || $ebooks_details['cover_flag'] == 0 ){ ?>
                                        <td ><button class="btn btn-warning mb-2 mr-2" disabled><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></td>
                                    <?php } else { ?>
                                        <td ><center><button  class="btn btn-dark mb-2 mr-2 btn-sm"><a href="" onclick="mark_book_generation_complete(<?php echo $ebooks_details['book_id'];?>)"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></a></center></td>
                                    <?php } ?>

                                   <?php if ($ebooks_details['upload_flag'] == 1) { ?>
                                        <td class="text-center" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                                    <?php } elseif ($ebooks_details['book_generation_flag'] == 0) { ?>
                                        <td ><button class="btn btn-danger mb-2 mr-2" disabled><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></td>
                                    <?php } else { ?>
                                        <td ><button class="btn btn-warning mb-2 mr-2 btn-sm"><a href="" onclick="mark_upload_complete(<?php echo $ebooks_details['book_id'];?>)"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></a></td>
                                    <?php } ?>

                                     <?php if ($ebooks_details['completed'] == 1) { ?>
                                        <td class="text-center" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                                    <?php } elseif ($ebooks_details['upload_flag'] == 0) { ?>
                                        <td ><button class="btn btn-neutral mb-2 mr-2" disabled><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></td>
                                    <?php } else { ?>
                                        <td><button class="btn btn-success mb-2 mr-2 btn-sm"><a href="" onclick="mark_completed(<?php echo $ebooks_details['book_id'];?>)" ><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></a></td>
                                    <?php } ?>



                                </tr>
                                <!-- Remove modal - Move the book in_progress state to holdbook state-->
                                <div class="modal fade" id="holdModal<?= $ebooks_details['book_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="holdModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="holdModalLabel">Put On Hold !!!</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h6 style="font-family:verdana;">Are you sure you want to Hold this record?</h6> 
                                                  <h6> Book Id: <?= $ebooks_details['book_id']?><br>
                                                         Title: <?= $ebooks_details['book_title']?></h6>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                                                 <a href="" onclick="hold_in_progress(<?php echo $ebooks_details['book_id'];?>)" class="mt-1 btn  btn-danger">Hold</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- View modal-->
                                <!-- View Modal (Card Style) -->
<div class="modal fade" id="viewModal<?= $ebooks_details['book_id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content radius-8 border-0">
            <div class="modal-header bg-primary text-white radius-top-8">
                <h5 class="modal-title fw-bold" id="viewModalLabel">Book Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="card h-100 border-0 radius-8 p-3 shadow-sm">
                    <div class="d-flex flex-wrap gap-3 mb-3">
                        <div class="d-flex flex-column">
                            <span class="text-secondary fw-medium">Book Id</span>
                            <h6 class="fw-semibold"><?= $ebooks_details['book_id']?></h6>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="text-secondary fw-medium">Title</span>
                            <h6 class="fw-semibold"><?= $ebooks_details['book_title']?></h6>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="text-secondary fw-medium">Author</span>
                            <h6 class="fw-semibold"><?= $ebooks_details['author_name']?></h6>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-3 mb-3">
                        <div class="d-flex flex-column">
                            <span class="text-secondary fw-medium">Content Type</span>
                            <h6 class="fw-semibold"><?= $ebooks_details['content_type']?></h6>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="text-secondary fw-medium">Initial Page Number</span>
                            <h6 class="fw-semibold"><?= $ebooks_details['initial_page_number']?></h6>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="text-secondary fw-medium">Priority</span>
                            <h6 class="fw-semibold"><?= $ebooks_details['priority']?></h6>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="text-secondary fw-medium">Created Date</span>
                            <h6 class="fw-semibold"><?= $ebooks_details['date_created']?></h6>
                        </div>
                    </div>

                    <hr>
                    <center><h5 class="text-primary fw-bold mb-3">Book Processing State</h5></center>

                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        <div class="d-flex flex-column align-items-center p-2 border radius-8 w-120px">
                            <span class="text-sm fw-medium text-secondary">Scan</span>
                            <h6 class="fw-semibold mb-0"><?= ($ebooks_details['scan_flag'] == 1) ? 'Done' : 'Processing' ?></h6>
                        </div>
                        <div class="d-flex flex-column align-items-center p-2 border radius-8 w-120px">
                            <span class="text-sm fw-medium text-secondary">OCR</span>
                            <h6 class="fw-semibold mb-0"><?= ($ebooks_details['ocr_flag'] == 1) ? 'Done' : 'Processing' ?></h6>
                        </div>
                        <div class="d-flex flex-column align-items-center p-2 border radius-8 w-120px">
                            <span class="text-sm fw-medium text-secondary">Level 1</span>
                            <h6 class="fw-semibold mb-0"><?= ($ebooks_details['level1_flag'] == 1) ? 'Done' : 'Processing' ?></h6>
                        </div>
                        <div class="d-flex flex-column align-items-center p-2 border radius-8 w-120px">
                            <span class="text-sm fw-medium text-secondary">Level 2</span>
                            <h6 class="fw-semibold mb-0"><?= ($ebooks_details['level2_flag'] == 1) ? 'Done' : 'Processing' ?></h6>
                        </div>
                        <div class="d-flex flex-column align-items-center p-2 border radius-8 w-120px">
                            <span class="text-sm fw-medium text-secondary">Cover</span>
                            <h6 class="fw-semibold mb-0"><?= ($ebooks_details['cover_flag'] == 1) ? 'Done' : 'Processing' ?></h6>
                        </div>
                        <div class="d-flex flex-column align-items-center p-2 border radius-8 w-120px">
                            <span class="text-sm fw-medium text-secondary">Book Generation</span>
                            <h6 class="fw-semibold mb-0"><?= ($ebooks_details['book_generation_flag'] == 1) ? 'Done' : 'Processing' ?></h6>
                        </div>
                        <div class="d-flex flex-column align-items-center p-2 border radius-8 w-120px">
                            <span class="text-sm fw-medium text-secondary">Upload</span>
                            <h6 class="fw-semibold mb-0"><?= ($ebooks_details['upload_flag'] == 1) ? 'Done' : 'Processing' ?></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-info radius-8" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

                                    <?php } ?>
                                    </tbody>
                                    </table>
                                    <br>
            
            <?= $this->endSection(); ?>

<!-- Initialize DataTables -->
 <?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        $('#bookTable').DataTable({
            "pageLength": 7,
            "lengthChange": true,
            "searching": true
        });
    });
</script>

    </div>
</div>

<!--  END CONTENT AREA  -->
<script type="text/javascript">
      var base_url = "<?= base_url() ?>";

    function mark_scan_complete(book_id) {
        $.ajax({
            url: base_url + '/book/markscancomplete',
            type: 'POST',
            data: {
                "book_id": book_id
            },
            success: function(data) {
    if (data.status == 1) {
        alert("Successfully marked SCAN complete!!");
    } else {
        alert("Unknown error!! Check again.");
    }
}
        });
    }

    function mark_ocr_complete(book_id) {
        $.ajax({
            url: base_url + '/book/markocrcomplete',
            type: 'POST',
            data: {
                "book_id": book_id
            },
            success: function(data) {
                 if (data.status == 1)  {
                    alert("Successfully marked OCR complete!!");
                }
                else {
                    alert("Unknown error!! Check again!")
                }
            }
        });
    }   

    function mark_level1_complete(book_id) {
        $.ajax({
            url: base_url + '/book/marklevel1complete',
            type: 'POST',
            data: {
                "book_id": book_id
            },
            success: function(data) {
                 if (data.status == 1)  {
                    alert("Successfully marked LEVEL 1 complete!!");
                }
                else {
                    alert("Unknown error!! Check again!")
                }
            }
        });
    }

    function mark_level2_complete(book_id) {
        $.ajax({
            url: base_url + '/book/marklevel2complete',
            type: 'POST',
            data: {
                "book_id": book_id
            },
            success: function(data) {
                 if (data.status == 1)  {
                    alert("Successfully marked LEVEL 2 complete!!");
                }
                else {
                    alert("Unknown error!! Check again!")
                }
            }
        });
    }

    function mark_cover_complete(book_id) {
        $.ajax({
            url: base_url + '/book/markcovercomplete',
            type: 'POST',
            data: {
                "book_id": book_id
            },
            success: function(data) {
                 if (data.status == 1)  {
                    alert("Successfully marked COVER complete!!");
                }
                else {
                    alert("Unknown error!! Check again!")
                }
            }
        });
    }

    function mark_book_generation_complete(book_id) {
        $.ajax({
            url: base_url + '/book/markbookgenerationcomplete',
            type: 'POST',
            data: {
                "book_id": book_id
            },
            success: function(data) {
                 if (data.status == 1)  {
                    alert("Successfully marked BOOK GENERATION complete!!");
                }
                else {
                    alert("Unknown error!! Check again!")
                }
            }
        });
    }

    function mark_upload_complete(book_id) {
        $.ajax({
            url: base_url + '/book/markuploadcomplete',
            type: 'POST',
            data: {
                "book_id": book_id
            },
            success: function(data) {
                 if (data.status == 1)  {
                    alert("Successfully marked UPLOAD complete!!");
                }
                else {
                    alert("Unknown error!! Check again!")
                }
            }
        });
    }    

    function mark_completed(book_id) {
        $.ajax({
            url: base_url + 'book/markcompleted',
            type: 'POST',
            data: {
                "book_id": book_id
            },
            success: function(data) {
                if (data.status == 1)  {
                    alert("Successfully completed!!");
                }
                else {
                    alert("Unknown error!! Check again!")
                }
            }
        });
    }    remove_in_progress

    function hold_in_progress(book_id) {
        $.ajax({
            url: base_url + '/book/holdinprogress',
            type: 'POST',
            data: {
                "book_id": book_id
            },
            success: function(data) {
                if (data == 1) {
                    alert("Records Hold!!");
                }
                else {
                    alert("Unknown error!! Check again!")
                }
            }
        });
    }
   
</script>
<?= $this->endSection(); ?>