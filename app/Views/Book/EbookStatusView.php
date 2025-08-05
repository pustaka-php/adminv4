<!--  BEGIN CONTENT AREA  -->
<div class="container" style="margin: 5; padding: 5; margin-top: -650px;">
    <div class="layout-px-spacing">
        <div style="overflow-x: auto; white-space: nowrap; padding: 20px; font-family: Arial, sans-serif;">

    <!-- Wrapper to hold all cards in a single horizontal line -->
    <div style="display: inline-flex; gap: 20px;">

        <!-- 📘 Books Not Started -->
        <div style="min-width: 220px; background: linear-gradient(to top right, #ffecd2, #fcb69f); border-radius: 15px; box-shadow: 0 6px 16px rgba(0,0,0,0.08); padding: 20px; color: #333; text-align: center;">
            <h4 style="margin-bottom: 10px;">📘 Not Started</h4>
            <p style="font-size: 26px; font-weight: bold;"><?php echo $ebooks_data['total_not_start']; ?></p>
            <p style="font-size: 13px;">Yet to begin</p>
        </div>

       <!-- 📕 On Hold -->
<div style="min-width: 220px; background: linear-gradient(to top right, #a1c4fd, #c2e9fb); border-radius: 15px; box-shadow: 0 6px 16px rgba(0,0,0,0.08); padding: 20px; color: #333; text-align: center;">
    <h4 style="margin-bottom: 10px;">📕 On Hold</h4>
    <p style="font-size: 26px; font-weight: bold;"><?php echo $ebooks_data['holdbook_cnt']; ?></p>
    <a href="<?php echo base_url(); ?>book/get_holdbook_details" style="display: inline-block; margin-bottom: 10px;" title="View Details">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#333" viewBox="0 0 24 24">
            <path d="M12 5c-7.633 0-11 6.913-11 7s3.367 7 11 7 11-6.913 11-7-3.367-7-11-7zm0 12c-2.761 0-5-2.239-5-5s2.239-5 5-5
            5 2.239 5 5-2.239 5-5 5zm0-8c-1.657 0-3 1.343-3 3s1.343 3 3 3
            3-1.343 3-3-1.343-3-3-3z"/>
        </svg>
    </a>
</div>

        <!-- 📝 In Progress -->
        <div style="min-width: 220px; background: linear-gradient(to top right, #e0c3fc, #8ec5fc); border-radius: 15px; box-shadow: 0 6px 16px rgba(0,0,0,0.08); padding: 20px; color: #333; text-align: center;">
            <h4 style="margin-bottom: 10px;">📝 In Progress</h4>
            <p style="font-size: 26px; font-weight: bold;"><?php echo $ebooks_data['in_progress_cnt']; ?></p>
            <p style="font-size: 13px;">Ongoing</p>
        </div>

        <!-- ✅ Completed -->
        <div style="min-width: 220px; background: linear-gradient(to top right, #d4fc79, #96e6a1); border-radius: 15px; box-shadow: 0 6px 16px rgba(0,0,0,0.08); padding: 20px; color: #333; text-align: center;">
            <h4 style="margin-bottom: 10px;">✅ Completed</h4>
            <p style="font-size: 26px; font-weight: bold;"><?php echo $ebooks_data['completed_flag_cnt']; ?></p>
            <p style="font-size: 13px;">Finished</p>
        </div>

       <!-- ⏳ Pending -->
<div style="min-width: 220px; background: linear-gradient(to top right, #fddb92, #d1fdff); border-radius: 15px; box-shadow: 0 6px 16px rgba(0,0,0,0.08); padding: 20px; color: #333; text-align: center;">
    <h4 style="margin-bottom: 10px;">⏳ Pending</h4>
    <p style="font-size: 26px; font-weight: bold;"><?php echo $ebooks_data['in_active_cnt']; ?></p>
     <a href="<?php echo base_url(); ?>book/get_in_active_books" style="display: inline-block; margin-bottom: 10px;" title="View Details">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#333" viewBox="0 0 24 24">
            <path d="M12 5c-7.633 0-11 6.913-11 7s3.367 7 11 7 11-6.913 11-7-3.367-7-11-7zm0 12c-2.761 0-5-2.239-5-5s2.239-5 5-5
            5 2.239 5 5-2.239 5-5 5zm0-8c-1.657 0-3 1.343-3 3s1.343 3 3 3
            3-1.343 3-3-1.343-3-3-3z"/>
        </svg>
    </a>
</div>

    </div>
</div>
        <h4 class="mt-4 mb-3">📊 Status Summary</h4>

<table class="table table-bordered table-hover text-center align-middle">
    <thead class="table-dark text-white">
        <tr>
            <th>Type</th>
            <th>Not Started</th>
            <th>Scan</th>
            <th>OCR</th>
            <th>Level 1</th>
            <th>Level 2</th>
            <th>Cover</th>
            <th>Book Generation</th>
            <th>Upload</th>
        </tr>
    </thead>
    <tbody>
        <!-- Full Cycle - Hardcopy -->
        <tr class="table-light">
            <td>Full Cycle - Hardcopy</td>
            <td><?php echo $ebooks_data['not_start_hardcopy']; ?></td>
            <td><?php echo $ebooks_data['scan_flag_cnt']; ?></td>
            <td><?php echo $ebooks_data['ocr_flag_cnt']; ?></td>
            <td><?php echo $ebooks_data['level1_flag_cnt']; ?></td>
            <td><?php echo $ebooks_data['level2_flag_cnt']; ?></td>
            <td><?php echo $ebooks_data['cover_flag_cnt']; ?></td>
            <td><?php echo $ebooks_data['book_generation_flag_cnt']; ?></td>
            <td><?php echo $ebooks_data['upload_flag_cnt']; ?></td>
        </tr>

        <!-- Softcopy - Word -->
        <tr class="table-white">
            <td>Softcopy - Word</td>
            <td><?php echo $ebooks_data['not_start_wrd']; ?></td>
            <td>--</td>
            <td>--</td>
            <td>--</td>
            <td>--</td>
            <td><?php echo $ebooks_data['cover_flag_cnt_wrd']; ?></td>
            <td><?php echo $ebooks_data['book_generation_flag_wrd']; ?></td>
            <td><?php echo $ebooks_data['upload_flag_cnt_wrd']; ?></td>
        </tr>

        <!-- Softcopy - PDF -->
        <tr class="table-light">
            <td>Softcopy - PDF</td>
            <td><?php echo $ebooks_data['not_start_pdf']; ?></td>
            <td>--</td>
            <td><?php echo $ebooks_data['ocr_flag_cnt_pdf']; ?></td>
            <td><?php echo $ebooks_data['level1_flag_cnt_pdf']; ?></td>
            <td><?php echo $ebooks_data['level2_flag_cnt_pdf']; ?></td>
            <td><?php echo $ebooks_data['cover_flag_cnt_pdf']; ?></td>
            <td><?php echo $ebooks_data['book_generation_flag_pdf']; ?></td>
            <td><?php echo $ebooks_data['upload_flag_cnt_pdf']; ?></td>
        </tr>
    </tbody>

    <tfoot class="table-secondary fw-bold">
        <tr>
            <td>Total</td>
            <td><?php echo $ebooks_data['not_start_hardcopy'] + $ebooks_data['not_start_pdf'] + $ebooks_data['not_start_wrd']; ?></td>
            <td><?php echo $ebooks_data['scan_flag_cnt']; ?></td>
            <td><?php echo $ebooks_data['ocr_flag_cnt'] + $ebooks_data['ocr_flag_cnt_pdf']; ?></td>
            <td><?php echo $ebooks_data['level1_flag_cnt'] + $ebooks_data['level1_flag_cnt_pdf']; ?></td>
            <td><?php echo $ebooks_data['level2_flag_cnt'] + $ebooks_data['level2_flag_cnt_pdf']; ?></td>
            <td><?php echo $ebooks_data['cover_flag_cnt'] + $ebooks_data['cover_flag_cnt_wrd'] + $ebooks_data['cover_flag_cnt_pdf']; ?></td>
            <td><?php echo $ebooks_data['book_generation_flag_cnt'] + $ebooks_data['book_generation_flag_wrd'] + $ebooks_data['book_generation_flag_pdf']; ?></td>
            <td><?php echo $ebooks_data['upload_flag_cnt'] + $ebooks_data['upload_flag_cnt_wrd'] + $ebooks_data['upload_flag_cnt_pdf']; ?></td>
        </tr>
    </tfoot>
</table>

<br>
<center>
    <a target="_blank" href="<?php echo base_url()."book/add_book" ?>"
       class="btn btn-lg mx-2 rounded-pill shadow-sm text-white"
       style="background: linear-gradient(45deg,rgb(166, 0, 255),rgb(244, 202, 228)); border: none;">
        Add Book
    </a>

    <a target="_blank" href="<?php echo base_url()."adminv3/browse_in_progress_books" ?>"
       class="btn btn-lg mx-2 rounded-pill shadow-sm text-white"
       style="background: linear-gradient(45deg,rgb(236, 61, 134),rgb(226, 239, 155)); border: none;">
        Browse Books
    </a>
</center>
        <br>
        <h4>List of In Progress Books</h4>
        <table class="table zero-config" style="border-collapse: separate; border-spacing: 0; overflow: hidden;">
    <thead style="background: linear-gradient(90deg,rgb(218, 242, 153) 0%,rgb(50, 254, 203) 100%); color: white;">
            <tr>
                <th style="border: 1px solid grey">S.No</th>   
                <th style="border: 1px solid grey">Author</th>
                <th style="border: 1px solid grey">BookID</th>
                <th style="border: 1px solid grey">Title</th>
                <th style="border: 1px solid grey">Scan</th>
                <th style="border: 1px solid grey">OCR</th>
                <th style="border: 1px solid grey">Level 1</th>
                <th style="border: 1px solid grey">Level 2</th>
                <th style="border: 1px solid grey">Cover</th>
                <th style="border: 1px solid grey">Book Gen</th>
                <th style="border: 1px solid grey">Upload</th>
                <th style="border: 1px solid grey">Comp</th>
                <!-- <th style="border: 1px solid grey">Action</th> -->
            </tr>
            </thead>
            <tbody style="font-weight: 1000;">
        
							<?php  
                                    $i=1;
                                    foreach ($ebooks_data['status_details'] as $ebooks_details) {
                                    ?>
                				<tr>
                                    <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                                    <td style="border: 1px solid grey"><?php echo $ebooks_details['author_name']; ?></td>
                                    <td style="border: 1px solid grey"><center><?php echo $ebooks_details['book_id']; ?></center>
                                    <br><center> <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#holdModal<?= $ebooks_details['book_id']; ?>">Hold </button> </center>
                                    <br><center><button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#viewModal<?= $ebooks_details['book_id']; ?>">View</a></center></td>
                                    
                                    <td style="border: 1px solid grey"><?php echo $ebooks_details['book_title'] ?></td>

                                    <?php if ($ebooks_details['scan_flag'] == 2) { ?>
                                        <td class="text-center" style="border: 1px solid grey">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"> <line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    <?php }elseif ($ebooks_details['scan_flag']  == 1) { ?>
                                        <td class="text-center" style="border: 1px solid grey">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                                    <?php } else { ?>
                                        <td style="border: 1px solid grey"><button class="btn btn-primary mb-2 mr-2"><a href="" onclick="mark_scan_complete(<?php echo $ebooks_details['book_id'];?>)"><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></a></td>
                                    <?php } ?>
                                   

                                    <?php if ($ebooks_details['ocr_flag'] == 2) { ?>
                                        <td class="text-center" style="border: 1px solid grey">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"> <line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    <?php }elseif ($ebooks_details['ocr_flag'] == 1) { ?>
                                        <td class="text-center" style="border: 1px solid grey">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                                    <?php } elseif ($ebooks_details['scan_flag']== 0) { ?>
                                        <td style="border: 1px solid grey"><button class="btn btn-warning mb-2 mr-2" disabled><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></td>
                                    <?php } else { ?>
                                        <td style="border: 1px solid grey"><a href="" onclick="mark_ocr_complete(<?php echo $ebooks_details['book_id'];?>)"><button class="btn btn-warning mb-2 mr-2"><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></a></td>
                                    <?php } ?>

                                    
                                    <?php if ($ebooks_details['level1_flag'] == 2) { ?>
                                        <td class="text-center" style="border: 1px solid grey">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"> <line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    <?php }elseif ($ebooks_details['level1_flag'] == 1) { ?>
                                        <td class="text-center" style="border: 1px solid grey">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                                    <?php } elseif ($ebooks_details['ocr_flag'] == 0) { ?>
                                        <td style="border: 1px solid grey"><button class="btn btn-secondary mb-2 mr-2" disabled><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></td>
                                    <?php } else { ?>
                                        <td style="border: 1px solid grey"><a href="" onclick="mark_level1_complete(<?php echo $ebooks_details['book_id'];?>)"><button class="btn btn-secondary mb-2 mr-2 btn-sm"><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></a></td>
                                    <?php } ?>


                                    <?php if ($ebooks_details['level2_flag'] == 2) { ?>
                                        <td class="text-center" style="border: 1px solid grey">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"> <line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    <?php }elseif ($ebooks_details['level2_flag'] == 1) { ?>
                                        <td class="text-center" style="border: 1px solid grey">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                                    <?php } elseif ($ebooks_details['level1_flag'] == 0) { ?>
                                        <td style="border: 1px solid grey"><button class="btn btn-success mb-2 mr-2" disabled><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></td>
                                    <?php } else { ?>
                                        <td style="border: 1px solid grey"><a href="" onclick="mark_level2_complete(<?php echo $ebooks_details['book_id'];?>)"><button class="btn btn-success mb-2 mr-2 btn-sm"><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></a></td>
                                    <?php } ?>

                                   <?php if ($ebooks_details['cover_flag'] == 1) { ?>
                                        <td class="text-center" style="border: 1px solid grey">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                                    <?php } else { ?>
                                        <td style="border: 1px solid grey"><a href="" onclick="mark_cover_complete(<?php echo $ebooks_details['book_id'];?>)"><button class="btn btn-info mb-2 mr-2 btn-sm"><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></a></td>
                                    <?php } ?>

                                    
                                    <?php if ($ebooks_details['book_generation_flag'] == 1) { ?>
                                        <td class="text-center" style="border: 1px solid grey">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                                    <?php }elseif ($ebooks_details['level2_flag']== 0 || $ebooks_details['cover_flag'] == 0 ){ ?>
                                        <td style="border: 1px solid grey"><button class="btn btn-dark mb-2 mr-2" disabled><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></td>
                                    <?php } else { ?>
                                        <td style="border: 1px solid grey"><center><a href="" onclick="mark_book_generation_complete(<?php echo $ebooks_details['book_id'];?>)"><button  class="btn btn-dark mb-2 mr-2 btn-sm"><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></a></center></td>
                                    <?php } ?>

                                   <?php if ($ebooks_details['upload_flag'] == 1) { ?>
                                        <td class="text-center" style="border: 1px solid grey">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                                    <?php } elseif ($ebooks_details['book_generation_flag'] == 0) { ?>
                                        <td style="border: 1px solid grey"><button class="btn btn-warning mb-2 mr-2" disabled><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></td>
                                    <?php } else { ?>
                                        <td style="border: 1px solid grey"><a href="" onclick="mark_upload_complete(<?php echo $ebooks_details['book_id'];?>)"><button class="btn btn-warning mb-2 mr-2 btn-sm"><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></a></td>
                                    <?php } ?>

                                     <?php if ($ebooks_details['completed'] == 1) { ?>
                                        <td class="text-center" style="border: 1px solid grey">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                                    <?php } elseif ($ebooks_details['upload_flag'] == 0) { ?>
                                        <td style="border: 1px solid grey"><button class="btn btn-success mb-2 mr-2" disabled><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></td>
                                    <?php } else { ?>
                                        <td style="border: 1px solid grey"><a href="" onclick="mark_completed(<?php echo $ebooks_details['book_id'];?>)" ><button class="btn btn-success mb-2 mr-2 btn-sm"><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></a></td>
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
                                                <h5 style="font-family:verdana;">Are you sure you want to Hold this record?</h5> 
                                                  <h6 style="font-family:courier;"> Book Id: <?= $ebooks_details['book_id']?><br>
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
                                <div class="modal fade" id="viewModal<?= $ebooks_details['book_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="viewModalLabel">Book Details</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                            
                                                  <h6 style="font-family:courier;"> Book Id: <?= $ebooks_details['book_id']?></h6>
                                                  <h6 style="font-family:courier;">Title: <?= $ebooks_details['book_title']?></h6>
                                                  <h6 style="font-family:courier;">Author: <?= $ebooks_details['author_name']?></h6>
                                                  <h6 style="font-family:courier;">Content Type:<?= $ebooks_details['content_type']?></h6>
                                                  <h6 style="font-family:courier;">Initial Page Number: <?= $ebooks_details['initial_page_number']?></h6>
                                                  <h6 style="font-family:courier;">Priority: <?= $ebooks_details['priority']?></h6>
                                                  <h6 style="font-family:courier;">Created Date: <?= $ebooks_details['date_created']?></h6>
                                                  <hr><center><h5  style="color:blue;"> Book Processing state</h5></center>
                                                  <h6 style="font-family: courier;">Scan: <?= ($ebooks_details['scan_flag'] == 1) ? 'Done' : 'Processing' ?></h6>
                                                  <h6 style="font-family: courier;">OCR: <?= ($ebooks_details['ocr_flag'] == 1) ? 'Done' : 'Processing' ?></h6>
                                                  <h6 style="font-family: courier;">Level 1: <?= ($ebooks_details['level1_flag'] == 1) ? 'Done' : 'Processing' ?></h6>
                                                  <h6 style="font-family: courier;">Level 2: <?= ($ebooks_details['level2_flag'] == 1) ? 'Done' : 'Processing' ?></h6>
                                                  <h6 style="font-family: courier;">Cover: <?= ($ebooks_details['cover_flag'] == 1) ? 'Done' : 'Processing' ?></h6>
                                                  <h6 style="font-family: courier;">Book Generation: <?= ($ebooks_details['book_generation_flag'] == 1) ? 'Done' : 'Processing' ?></h6>
                                                  <h6 style="font-family: courier;">Upload: <?= ($ebooks_details['upload_flag'] == 1) ? 'Done' : 'Processing' ?></h6>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                     <?php  } ?>
                           
            </tbody>
                           
        </table>

<h4 class="mb-3">
    List of Books Not Started !!! - <span class="text-primary"><?php echo $ebooks_data['start_flag_cnt']; ?></span>
</h4>

<div class="table-responsive">
    <table id="bookTable" class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>S.No</th>
                <th>Date</th>
                <th>Author</th>
                <th>Book ID</th>
                <th>Title</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody style="font-weight: 600;">
            <?php $i = 1;
            foreach ($ebooks_data['book_not_start'] as $ebooks_details): ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo !empty($ebooks_details['date_created']) ? $ebooks_details['date_created'] : 'N/A'; ?></td>
                    <td><?php echo !empty($ebooks_details['author_name']) ? $ebooks_details['author_name'] : 'N/A'; ?></td>
                    <td><?php echo !empty($ebooks_details['book_id']) ? $ebooks_details['book_id'] : 'N/A'; ?></td>
                    <td><?php echo !empty($ebooks_details['book_title']) ? $ebooks_details['book_title'] : 'N/A'; ?></td>
                    <td>
    <button onclick="mark_start_work(<?php echo isset($ebooks_details['book_id']) ? $ebooks_details['book_id'] : 0; ?>)"
        style="background: linear-gradient(135deg, #f6d365, #fda085); color: white; padding: 6px 12px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">
        Start Work
    </button>
</td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Initialize DataTables -->
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
    var base_url = window.location.origin;
    // Storing all values from form into variables
    function mark_start_work(book_id) {
        $.ajax({
            url: base_url + '/book/ebooks_mark_start',
            type: 'POST',
            data: {
                "book_id": book_id
            },
            success: function(data) {
               
                if (data == 1) {
                    alert("Successfully started the work!!");
                }
                else {
                    alert("Unknown error!! Check again!")
                }
            }
        });
    }

    function mark_scan_complete(book_id) {
        $.ajax({
            url: base_url + '/book/mark_scan_complete',
            type: 'POST',
            data: {
                "book_id": book_id
            },
            success: function(data) {
                if (data == 1) {
                    alert("Successfully marked SCAN complete!!");
                }
                else {
                    alert("Unknown error!! Check again!")
                }
            }
        });
    }

    function mark_ocr_complete(book_id) {
        $.ajax({
            url: base_url + '/book/mark_ocr_complete',
            type: 'POST',
            data: {
                "book_id": book_id
            },
            success: function(data) {
                if (data == 1) {
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
            url: base_url + '/book/mark_level1_complete',
            type: 'POST',
            data: {
                "book_id": book_id
            },
            success: function(data) {
                if (data == 1) {
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
            url: base_url + '/book/mark_level2_complete',
            type: 'POST',
            data: {
                "book_id": book_id
            },
            success: function(data) {
                if (data == 1) {
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
            url: base_url + '/book/mark_cover_complete',
            type: 'POST',
            data: {
                "book_id": book_id
            },
            success: function(data) {
                if (data == 1) {
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
            url: base_url + '/book/mark_book_generation_complete',
            type: 'POST',
            data: {
                "book_id": book_id
            },
            success: function(data) {
                if (data == 1) {
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
            url: base_url + '/book/mark_upload_complete',
            type: 'POST',
            data: {
                "book_id": book_id
            },
            success: function(data) {
                if (data == 1) {
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
            url: base_url + '/book/mark_completed',
            type: 'POST',
            data: {
                "book_id": book_id
            },
            success: function(data) {
                if (data == 1) {
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
            url: base_url + '/book/hold_in_progress',
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