<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
       <div class="card-deck">
               <div class="container-fluid">
    <div class="row g-3">

        <!-- Not Started -->
        <div class="col-xl col-lg-3 col-md-4 col-sm-6">
            <div class="card shadow-sm border-0 rounded-4 h-100 hover-shadow">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <span class="badge bg-primary-subtle text-primary p-3 rounded-circle">
                            <i class="fas fa-hourglass-start fa-lg"></i>
                        </span>
                    </div>
                    <h6 class="fw-semibold text-primary">Not Started</h6>
                    <h5 class="fw-bold mb-0"><?= $count['not_start_cnt']['cnt'] ?? 0; ?></h5>
                </div>
            </div>
        </div>

        <!-- In Progress -->
        <div class="col-xl col-lg-3 col-md-4 col-sm-6">
            <div class="card shadow-sm border-0 rounded-4 h-100 hover-shadow">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <span class="badge bg-warning-subtle text-warning p-3 rounded-circle">
                            <i class="fas fa-tasks fa-lg"></i>
                        </span>
                    </div>
                    <h6 class="fw-semibold text-warning">In Progress</h6>
                    <h5 class="fw-bold mb-0"><?= $count['Processing']['cnt'] ?? 0; ?></h5>
                </div>
            </div>
        </div>

        <!-- Re-Proofing -->
        <div class="col-xl col-lg-3 col-md-4 col-sm-6">
            <div class="card shadow-sm border-0 rounded-4 h-100 hover-shadow">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <span class="badge bg-info-subtle text-info p-3 rounded-circle">
                            <i class="fas fa-search fa-lg"></i>
                        </span>
                    </div>
                    <h6 class="fw-semibold text-info">Re-Proofing</h6>
                    <h5 class="fw-bold mb-0"><?= $count['re_proofing_cnt']['cnt'] ?? 0; ?></h5>
                </div>
            </div>
        </div>

        <!-- Re-InDesign -->
        <div class="col-xl col-lg-3 col-md-4 col-sm-6">
            <div class="card shadow-sm border-0 rounded-4 h-100 hover-shadow">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <span class="badge bg-secondary-subtle text-secondary p-3 rounded-circle">
                            <i class="fas fa-pencil-ruler fa-lg"></i>
                        </span>
                    </div>
                    <h6 class="fw-semibold text-secondary">Re-InDesign</h6>
                    <h5 class="fw-bold mb-0"><?= $count['re_indesign_cnt']['cnt'] ?? 0; ?></h5>
                </div>
            </div>
        </div>

        <!-- Re-FileUpload -->
        <div class="col-xl col-lg-3 col-md-4 col-sm-6">
            <div class="card shadow-sm border-0 rounded-4 h-100 hover-shadow">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <span class="badge bg-success-subtle text-success p-3 rounded-circle">
                            <i class="fas fa-upload fa-lg"></i>
                        </span>
                    </div>
                    <h6 class="fw-semibold text-success">Re-FileUpload</h6>
                    <h5 class="fw-bold mb-0"><?= $count['re_fileupload_cnt']['cnt'] ?? 0; ?></h5>
                </div>
            </div>
        </div>

    </div>
</div>

        <br>
        <table class="table zero-config">
            <thead>
            <tr>
                <th >S.NO</th> 
                <th >Author</th>
                <th >book id </th>
				<th >Title</th>
                <th >Re-Proofing</th>
                <th >Re-Indesign</th>
                <th >File upload</th>
                <th >Completed</th>
            </tr>
            </thead>
            <tbody style="font-weight: 400;">
                <?php $i=1;
                foreach($books_data['in_progress'] as $book){ ?>
                <tr>
                <td ><?php echo $i++; ?> </td>
                    <td ><?php echo $book['author_name']; ?> </td>
                    <td ><?php echo $book['book_id']?><br>
					<td ><?php echo $book['book_title'];  ?></td>
                    <?php if ($book['re_proofing_flag'] == 1) { ?>
                        <td class="text-center" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                    <?php } else { ?>
                        <td ><button class="btn btn-primary mb-2 mr-2"><a href="" onclick="mark_re_proofing_completed(<?php echo $book['book_id'] ?>)"><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8h584c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32h52z"/></svg></button></a></td>
                    <?php } ?>

                    <?php if ($book['re_indesign_flag'] == 1) { ?>
                        <td class="text-center" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                    <?php } elseif ($book['re_proofing_flag'] == 0) { ?>
                        <td ><button class="btn btn-warning mb-2 mr-2" disabled><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8h584c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32h52z"/></svg></button></td>
                    <?php } else { ?>
                        <td ><a href="" onclick="mark_re_indesign_completed(<?php echo $book['book_id'] ?>)"><button class="btn btn-warning mb-2 mr-2"><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8h584c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32h52z"/></svg></button></a></td>
                    <?php } ?>

                    <?php if ($book['re_fileupload_flag'] == 1) { ?>
                        <td class="text-center" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                    <?php } elseif ($book['re_indesign_flag'] == 0) { ?>
                        <td ><button class="btn btn-danger mb-2 mr-2" disabled><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8h584c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32h52z"/></svg></button></td>
                    <?php } else { ?>
                        <td ><a href="" onclick="mark_re_fileupload_completed(<?php echo $book['book_id'] ?>)"><button class="btn btn-danger mb-2 mr-2"><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8h584c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32h52z"/></svg></button></a></td>
                    <?php } ?>

                    <?php if ($book['re_completed_flag'] == 1) { ?>
                        <td class="text-center" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                    <?php } elseif ($book['re_fileupload_flag'] == 0) { ?>
                        <td ><button class="btn btn-success mb-2 mr-2" disabled><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8h584c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32h52z"/></svg></button></td>
                    <?php }else { ?>
                        <td ><a href="<?php echo base_url();?>book/reworkcompletedsubmit/<?php echo $book['book_id'];?>" onclick="" target="_blank"><button class="btn btn-success mb-2 mr-2"><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8h584c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32h52z"/></svg></button></a></td>
                    <?php } ?>

                </tr>
                <?php } ?>
            </tbody>
        </table>
        <br>
       <br>
       <h6>List of Books not started!!</h6>
        <table class="table zero-config">
            <thead>
            <tr>
			    <th >S.NO</th>
				<th >Created Date</th>
				<th >book id</th>
                <th >Title</th>
                <th >Author</th>
                <th >Action</th>
            </tr>
            </thead>
            <tbody style="font-weight: 400;">
                <?php 
				 $i=1;
				foreach($books_data['not_started'] as $book){
                    ?>
                    <tr>
					    <td ><?php echo $i++; ?></td>
						<td ><?php echo date('d-m-y', strtotime($book['created_date'])) ?></td>
						<td ><?php echo $book['book_id']; ?></td>
                        <td ><?php echo $book['book_title']; ?></td>
                        <td ><?php echo $book['author_name']; ?></td>
                        <td ><button><a href="" onclick="mark_start_rework(<?php echo $book['book_id'] ?>)" class="btn btn-success radius-8 px-14 py-6 text-sm">Start Work</a></button></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <br><br>  
    <div>
<div>
    <?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script type="text/javascript">
    var base_url = window.location.origin;

    function mark_start_rework(book_id) {
    $.ajax({
        url: base_url + '/book/reworkmarkstart',
        type: 'POST',
        data: { book_id: book_id },
        success: function(data) {
            if (data == 1) {
                alert("Successfully started the work!!");
                location.reload();
            } else {
                alert("Unknown error!! Check again!");
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
            alert("Something went wrong! Check console.");
        }
    });
}


    function mark_re_proofing_completed(book_id) {
        $.ajax({
            url: base_url + '/book/markreproofingcompleted',
            type: 'POST',
            data: { book_id: book_id },
            success: function(data) {
                if (data == 1) {
                    alert("Successfully marked Re-Proofing completed!!");
                    location.reload();
                } else {
                    alert("Unknown error!! Check again!");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                alert("Something went wrong! Check console.");
            }
        });
    }

    function mark_re_indesign_completed(book_id) {
        $.ajax({
            url: base_url + '/book/markreindesigncompleted',
            type: 'POST',
            data: { book_id: book_id },
            success: function(data) {
                if (data == 1) {
                    alert("Successfully marked Re-Indesign completed!!");
                    location.reload();
                } else {
                    alert("Unknown error!! Check again!");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                alert("Something went wrong! Check console.");
            }
        });
    }

    function mark_re_fileupload_completed(book_id) {
        $.ajax({
            url: base_url + '/book/markrefileuploadcompleted',
            type: 'POST',
            data: { book_id: book_id },
            success: function(data) {
                if (data == 1) {
                    alert("Successfully marked File Upload completed!!");
                    location.reload();
                } else {
                    alert("Unknown error!! Check again!");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                alert("Something went wrong! Check console.");
            }
        });
    }

    function mark_rework_completed(book_id) {
        $.ajax({
            url: base_url + '/book/markreworkcompleted',
            type: 'POST',
            data: { book_id: book_id },
            success: function(data) {
                if (data == 1) {
                    alert("Successfully marked Rework completed!!");
                    location.reload();
                } else {
                    alert("Unknown error!! Check again!");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                alert("Something went wrong! Check console.");
            }
        });
    }
</script>

  <?= $this->endSection(); ?>