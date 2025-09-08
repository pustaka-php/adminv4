<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title row">
                <div class="col">
                </div>
                <div class="col-3">
                    <a href="authorlistdetails" class="btn btn-info mb-2 mr-2">Create New Author Orders</a>
                </div>
            </div>
        </div>
        <br><br>
        <div class="card basic-data-table">
            <div class="row"> 
            <!-- Author Orders Summary Table -->
            <div class="col-md-6 mb-4">
                <div class="card mb-4 h-100">
                    <div class="card-header border-bottom bg-base py-16 px-24">
                        <h5 class="card-title mb-0">Author Order Summary</h5>
                    </div>
                    <br><br>
                    <div class="card-body">
                        <table class="table colored-row-table mb-0">
                            <thead>
                                <tr>
                                    <th class="bg-base">Status</th>
                                    <th class="bg-base">Total Orders</th>
                                    <th class="bg-base">Total Titles</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="bg-primary-light">In Progress</td>
                                    <td class="bg-primary-light">
                                        <?= $summary['in_progress']['total_orders'] ?? 0 ?>
                                    </td>
                                    <td class="bg-primary-light">
                                        <?= $summary['in_progress']['total_titles'] ?? 0 ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-success-focus">Completed(last 30 Days)</td>
                                    <td class="bg-success-focus">
                                        <?= $summary['completed']['total_orders'] ?? 0 ?>
                                    </td>
                                    <td class="bg-success-focus">
                                        <?= $summary['completed']['total_titles'] ?? 0 ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-info-focus">Completed (All Time)</td>
                                    <td class="bg-info-focus">
                                        <?= $summary['completed_all']['total_orders'] ?? 0 ?>
                                    </td>
                                    <td class="bg-info-focus">
                                        <?= $summary['completed_all']['total_titles'] ?? 0 ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-warning-focus">Total Completed Items</td>
                                    <td colspan="2" class="bg-warning-focus">
                                        <?= $summary['completed_all_detail']['total_items'] ?? 0 ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Month-wise Orders Chart -->
            <div class="col-md-6 mb-4">
                <div class="card h-100 p-0 ms-3">
                    <div class="card-header border-bottom bg-base py-16 px-24">
                        <h6 class="text-lg fw-semibold mb-0">Author Orders Month-wise</h6>
                    </div>
                    <div class="card-body p-24">
                        <div id="authorChart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <br><br>
		<h6 class="text-center"><u>In progress Orders</u></h6>
            <table class="table zero-config">
                <thead class="thead-dark">
                    <tr>
                        <th>S.NO</th>
                        <th>Order id</th>
                        <th>Author name</th>
                        <th>No.of title</th>
                        <th>No.of comp title</th>
                        <th>Ship Date</th>
                        <th>Invoice</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal;">
                    <?php $i = 1;
                    foreach ($orders['in_progress'] as $book) { ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $book['order_id']; ?>
                            <a href="<?= base_url('paperback/authororderdetails/' . $book['order_id']) ?>" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="blue" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link">
                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                    <polyline points="15 3 21 3 21 9"></polyline>
                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                </svg>
                            </a>
                            </td>
                            <td><?php echo $book['author_name']; ?></td>
                            <td><?php echo $book['tot_book']; ?></td>
                            <td><?php echo $book['comp_cnt']; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($book['ship_date'])) ?></td>
                            <?php $invoice_number = $book['invoice_number']; ?>

                            <td>
                                <div class="text-center">
                                <?php if ($book['invoice_flag'] == 0) { ?>
                                    <a href="<?php echo base_url()."paperback/createauthorinvoice/". $book['order_id']?>" class="btn btn-primary btn-sm"style="padding: 4px 10px; font-size: 12px;" target="_blank">Create Invoice</a>
                            <?php } else {?>
                                <?php echo $book['invoice_number']; ?>
                            <?php } ?>
                                
                                </div>
                            </td>
                            <td>
                                <?php if (($book['comp_cnt'] == $book['tot_book']) &&($book['invoice_flag'] == 1)){ ?>
                                    <a href="<?= base_url('paperback/authorordership/' . $book['order_id']) ?>" class="btn btn-warning mb-2 mr-2" target="_blank">Ship</a>
                                    <a href="" onclick="mark_cancel(<?php echo $book['order_id']; ?>)" class="btn btn-danger mb-2 mr-2">Cancel</a>
                                <?php }else{?>

                                    <a href="" class="btn btn-warning mb-2 mr-2" target="_blank" 
                                    style="padding: 4px 10px; font-size: 12px;" disabled>Ship</a>
                                    <a href="" onclick="mark_cancel(<?php echo $book['order_id']; ?>)" class="btn btn-danger mb-2 mr-2"style="padding: 4px 10px; font-size: 12px;">Cancel</a>
                                <?php }?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <br><br>
        <h6 class="text-center">Status</h6>
        <table class="table zero-config">
            <thead>
            <tr>
                <th>Delivery Date</th>   
				<th>Order id</th>   
                <th>Author</th>
                <th>book id - Title</th>
				<th>copy</th>
                <th>Files Ready</th>
                <th>Cover</th>
                <th>Content</th>
                <th>Laminate</th>
                <th>Binding</th>
                <th>Final Cut</th>
                <th>QC</th>
                <th>comp</th>
            </tr>
            </thead>
            <tbody style="font-weight: normal;">
                <?php foreach($author_order['start_books'] as $book){ ?>
                <tr>
				    <td><?php echo date('d-m-Y',strtotime($book['ship_date'])) ?></td>
					<td>
                            <a href="<?= base_url('paperback/authororderdetails/' . $book['order_id']) ?>" target="_blank">
                                <?php echo $book['order_id']; ?>
                            </a> 
                    </td>
                    <td><?php echo $book['author_name']; ?> </td>
                    <td><?php echo $book['book_id'].' : '.$book['book_title']; ?><br>
					<td><?php echo $book['quantity']; ?></td>

                    <td class="text-center">
                        <?php if ($book['files_ready_flag'] == 1) {?>
                            <?php 
                                if ($book['rework_flag'] == 1){ 
                                    echo "Rework InProcessing";
                                } else if ($book['rework_flag'] == 0  || $book['rework_flag'] == NULL ){?>
                                <div class="row">
                                    <div class="col-1">
                                        <a href="<?=('https://pustaka-indesign.s3.ap-south-1.amazonaws.com/' .$book['book_id'].'/'.$book['url_name'].'-cover.pdf') ?>"   class="bs-tooltip" title="<?php echo 'Cover'?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                                        </a> 
                                        </div>
                                        <div class="col-1">
                                        <a href="<?=('https://pustaka-indesign.s3.ap-south-1.amazonaws.com/' .$book['book_id'].'/'.$book['url_name'].'-content.pdf') ?>"  class="bs-tooltip" title="<?php echo 'Content'?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                        </a> 
                                        </div>
                                        <div class="col-1">
                                        <a href="<?=('https://pustaka-indesign.s3.ap-south-1.amazonaws.com/' .$book['book_id'].'/'.$book['url_name'].'-content-single.pdf') ?>"  class="bs-tooltip" title="<?php echo 'Single Content'?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-minus"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="9" y1="15" x2="15" y2="15"></line></svg>
                                        </a> 
                                    </div>
                                </div>     
                                <?php
                                }else{
                                    echo "";
                                }
                                ?>
                            <?php } else { ?>
                            <button class="btn btn-primary mb-2 mr-2"><a href="" onclick="mark_filesready_completed('<?php echo $book['order_id'] ?>','<?php echo $book['book_id'] ?>')"><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></a>
                        <?php } ?>
                    </td>
                   

                    <?php if ($book['cover_flag'] == 1) { ?>
                        <td>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                    <?php } elseif ($book['files_ready_flag'] == 0) { ?>
                        <td><button class="btn btn-warning mb-2 mr-2" disabled><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></td>
                    <?php } else { ?>
                        <td style="border: 1px solid grey"><a href="" onclick="mark_cover_completed('<?php echo $book['order_id'] ?>','<?php echo $book['book_id'] ?>')"><button class="btn btn-warning mb-2 mr-2"><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></a></td>
                    <?php } ?>

                    <?php if ($book['content_flag'] == 1) { ?>
                        <td>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                    <?php }else { ?>
                        <td><a href="" onclick="mark_content_completed('<?php echo $book['order_id'] ?>','<?php echo $book['book_id'] ?>')"><button class="btn btn-danger mb-2 mr-2 btn-sm"><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></a></td>
                    <?php } ?>

                    <?php if ($book['lamination_flag'] == 1) { ?>
                        <td>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                    <?php } elseif ($book['files_ready_flag'] == 0 or $book['cover_flag'] == 0) { ?>
                        <td style="border: 1px solid grey;width:5"><button class="btn btn-secondary mb-2 mr-2" disabled><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></td>
                    <?php } else { ?>
                        <td><a href="" onclick="mark_lamination_completed('<?php echo $book['order_id'] ?>','<?php echo $book['book_id'] ?>')"><button class="btn btn-secondary mb-2 mr-2"><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></a></td>
                    <?php } ?>

                    <?php if ($book['binding_flag'] == 1) { ?>
                        <td>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                    <?php } elseif ($book['files_ready_flag'] == 0 or $book['cover_flag'] == 0 or $book['content_flag'] == 0 or $book['lamination_flag'] == 0) { ?>
                        <td><button class="btn btn-dark mb-2 mr-2" disabled><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></td>
                    <?php } else { ?>
                        <td><a href="" onclick="mark_binding_completed('<?php echo $book['order_id'] ?>','<?php echo $book['book_id'] ?>')"><button class="btn btn-dark mb-2 mr-2"><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></a></td>
                    <?php } ?>

                    <?php if ($book['finalcut_flag'] == 1) { ?>
                        <td>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                    <?php } elseif ($book['files_ready_flag'] == 0 or $book['cover_flag'] == 0 or $book['content_flag'] == 0 or $book['lamination_flag'] == 0 or $book['binding_flag'] == 0) { ?>
                        <td><button class="btn btn-info mb-2 mr-2" disabled><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></td>
                    <?php } else { ?>
                        <td><a href="" onclick="mark_finalcut_completed('<?php echo $book['order_id'] ?>','<?php echo $book['book_id'] ?>')"><button class="btn btn-info mb-2 mr-2"><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></a></td>
                    <?php } ?>

                    <?php if ($book['qc_flag'] == 1) { ?>
                        <td>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                    <?php } elseif ($book['files_ready_flag'] == 0 or $book['cover_flag'] == 0 or $book['content_flag'] == 0 or $book['lamination_flag'] == 0 or $book['binding_flag'] == 0 or $book['finalcut_flag'] == 0) { ?>
                        <td><button class="btn btn-warning mb-2 mr-2" disabled><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></td>
                    <?php } else { ?>
                        <td><a href="" onclick="mark_qc_completed('<?php echo $book['order_id'] ?>','<?php echo $book['book_id'] ?>')"><button class="btn btn-warning mb-2 mr-2"><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></a></td>
                    <?php } ?>

                    <?php if ($book['completed_flag'] == 1) { ?>
                        <td>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#04b31b" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                    <?php } else { ?>
                        <td><a href="" onclick="mark_completed('<?php echo $book['order_id'] ?>','<?php echo $book['book_id'] ?>')"><button class="btn btn-success mb-2 mr-2"><svg xmlns="http://www.w3.org/2000/svg" height="0.625em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.1s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg></button></a></td>
                    <?php } ?>

                </tr>
                <?php } ?>
            </tbody>
        </table>
        <br><br>
        <h6 class="text-center">List of Books not started!!</h6>
        <table class="table zero-config">
            <thead>
            <tr>
			    <th>S.NO</th>
				<th>order id</th>
                <th>Author</th>
				<th>book id</th>
                <th>Title</th>
                <th>Delivery Date</th>
                <th>Copies</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody style="font-weight: normal;">
                <?php 
				 $i=1;
				foreach($author_order['books'] as $book){
                    ?>
                    <tr>
					    <td><?php echo $i++; ?></td>
						<td>
                            <a href="<?= base_url('paperback/authororderdetails/' . $book['order_id']) ?>" target="_blank">
                                <?php echo $book['order_id']; ?>
                            </a>
                        </td>
                        <td><?php echo $book['author_name']; ?></td>
						<td><?php echo $book['book_id']; ?></td>
                        <td><?php echo $book['book_title']; ?></td>
                        <td><?php echo date('d-m-Y',strtotime($book['ship_date'])) ?></td>
                        <td><?php echo $book['quantity']; ?></td>
                        <td><button><a href="" onclick="mark_start_work('<?php echo $book['order_id'] ?>','<?php echo $book['book_id'] ?>')" class="btn btn-success" style="padding: 4px 10px; font-size: 12px;">Start Work</a></button></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <br><br>
        <h6 class="text-center"><u>Completed Orders & Pending Payment</u>
        <a href="<?php echo base_url(); ?>paperback/totalauthorordercompleted" class="bs-tooltip " title="<?php echo 'View all Completed Books'?>"target=_blank>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="blue" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                        <polyline points="15 3 21 3 21 9"></polyline>
                        <line x1="10" y1="14" x2="21" y2="3"></line>
                    </svg>
                </a></h6>
        <h6 class="text-center">( Shows for 30 days from date of shipment )</h6>
        <table class="table table-hover table-success mb-4 zero-config">
                <thead>
                    <tr>
                        <th>S.NO</th>
                        <th>Order id</th>
                        <th>Author name</th>
                        <th>No.of title</th>
                        <th>Invoice amount</th>
                        <th>Ship Date</th>
                        <th>Payment Status</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal;">
                    <?php $i = 1;
                    foreach ($orders['completed'] as $book) { ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td>
                            <a href="<?= base_url('paperback/authororderdetails/' . $book['order_id']) ?>" target="_blank">
                                <?php echo $book['order_id']; ?>
                            </a>
                            <br>
                            <a href="<?php echo $book['tracking_url']; ?>" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck">
                                    <rect x="1" y="3" width="15" height="13"></rect>
                                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                </svg>
                            </a>
                              
                            </td>
                            <td><?php echo $book['author_name']; ?></td>
                            <td><?php echo $book['tot_book']; ?></td>
                            <td><?php echo '₹' .$book['net_total']; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($book['ship_date'])) ?></td>
                            <td><?php echo $book['payment_status']; ?>
                            <?php $payment_status=$book['payment_status'];?>
                            <?php if ($payment_status =='Pending') { ?>
                                    <a href="" onclick="mark_pay('<?php echo $book['order_id'] ?>')" class="btn-sm btn-primary mb-2 mr-2">Mark Paid</a>
                                <?php } ?>
                            </td>
                    <?php } ?>
                </tbody>
            </table>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Data from PHP
    const chartData = <?= json_encode($summary['chart']); ?>;

    // Extract arrays
    const months = chartData.map(item => item.order_month);
    const totalTitles = chartData.map(item => parseInt(item.total_titles));
    const totalMrp = chartData.map(item => parseFloat(item.total_mrp));

    var options = {
        chart: {
            type: 'bar',
            height: 400,
            stacked: false,
            toolbar: { show: false }
        },
        series: [
            {
                name: "Total Titles",
                type: 'column',
                data: totalTitles
            },
            {
                name: "Total MRP",
                type: 'column',
                data: totalMrp
            }
        ],
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '40%',
                endingShape: 'rounded'
            }
        },
        xaxis: {
            categories: months,
            title: { text: 'Order Month' }
        },
        yaxis: [
            {
                title: { text: "Total Titles" },
                labels: {
                    formatter: function (val) { return val.toLocaleString(); }
                }
            },
            {
                opposite: true,
                title: { text: "Total MRP" },
                labels: {
                    formatter: function (val) {
                        return "₹" + val.toLocaleString();
                    }
                }
            }
        ],
        dataLabels: {
            enabled: false
        },
        colors: ['#1E90FF', '#b8e31eff'],
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function (val, opts) {
                    if (opts.seriesIndex === 1) {
                        return "₹" + val.toLocaleString();
                    }
                    return val.toLocaleString();
                }
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'center'
        }
    };

    var chart = new ApexCharts(document.querySelector("#authorChart"), options);
    chart.render();
});
</script>
<script type="text/javascript">
    var base_url = window.location.origin;

    function mark_start_work(order_id,book_id) {
        $.ajax({
            url: base_url + 'paperback/authorordermarkstart',
            type: 'POST',
            data: {
				"order_id":order_id,
                "book_id": book_id,
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

    function mark_filesready_completed(order_id,book_id) {
        $.ajax({
            url: base_url + 'paperback/markfilesreadycompleted',
            type: 'POST',
            data: {
                "order_id":order_id,
                "book_id": book_id,
            },
            success: function(data) {
                if (data == 1) {
                    alert("Successfully marked FILES READY completed!!");
                }
                else {
                    alert("Unknown error!! Check again!")
                }
            }
        });
    }

    function mark_cover_completed(order_id,book_id) {
        $.ajax({
            url: base_url + 'paperback/markcovercompleted',
            type: 'POST',
            data: {
				"order_id":order_id,
                "book_id": book_id,
            },
            success: function(data) {
                if (data == 1) {
                    alert("Successfully marked COVER PRINT completed!!");
                }
                else {
                    alert("Unknown error!! Check again!")
                }
            }
        });
    }

    function mark_content_completed(order_id,book_id) {
        $.ajax({
            url: base_url + 'paperback/markcontentcompleted',
            type: 'POST',
            data: {
                "order_id":order_id,
                "book_id": book_id,
            },
            success: function(data) {
                if (data == 1) {
                    alert("Successfully marked CONTENT PRINT completed!!");
                }
                else {
                    alert("Unknown error!! Check again!")
                }
            }
        });
    }    

    function mark_lamination_completed(order_id,book_id) {
        $.ajax({
            url: base_url + 'paperback/marklaminationcompleted',
            type: 'POST',
            data: {
                "order_id":order_id,
                "book_id": book_id,
            },
            success: function(data) {
                if (data == 1) {
                    alert("Successfully marked LAMINATION completed!!");
                }
                else {
                    alert("Unknown error!! Check again!")
                }
            }
        });
    }

    function mark_binding_completed(order_id,book_id) {
        $.ajax({
            url: base_url + 'paperback/markbindingcompleted',
            type: 'POST',
            data: {
                "order_id":order_id,
                "book_id": book_id,
            },
            success: function(data) {
                if (data == 1) {
                    alert("Successfully marked BINDING completed!!");
                }
                else {
                    alert("Unknown error!! Check again!")
                }
            }
        });
    }

    function mark_finalcut_completed(order_id,book_id) {
        $.ajax({
            url: base_url + 'paperback/markfinalcutcompleted',
            type: 'POST',
            data: {
                "order_id":order_id,
                "book_id": book_id,
            },
            success: function(data) {
                if (data == 1) {
                    alert("Successfully marked FINAL CUT completed!!");
                }
                else {
                    alert("Unknown error!! Check again!")
                }
            }
        });
    }

    function mark_qc_completed(order_id,book_id) {
        $.ajax({
            url: base_url + 'paperback/markqccompleted',
            type: 'POST',
            data: {
                "order_id":order_id,
                "book_id": book_id,
            },
            success: function(data) {
                if (data == 1) {
                    alert("Successfully marked QC completed!!");
                }
                else {
                    alert("Unknown error!! Check again!")
                }
            }
        });
    }    

    function mark_completed (order_id,book_id) {
        $.ajax({
            url: base_url + 'paperback/authorordermarkcompleted',
            type: 'POST',
            data: {
                "order_id":order_id,
                "book_id": book_id,
            },
            success: function(data) {
                if (data == 1) {
                    alert("Successfully marked completed!!");
                }
                else {
                    alert("Unknown error!! Check again!")
                }
            }
        });
    }   
    
    function mark_cancel(order_id){
        $.ajax({
            url: base_url + 'paperback/authormarkcancel',
            type: 'POST',
            data: {
                "order_id":order_id,
            },
            success: function(data) {
               //alert(data);
                if (data == 1) {
                    alert("Shipping Cancel!!");
                
                }
                else {
                    alert("Unknown error!! Check again!")
                }
            }
        });
    }

   function mark_pay(order_id){
        $.ajax({
                url: base_url + 'paperback/authormarkpay',
                type: 'POST',
                data: {
                    "order_id":order_id,
                },
                success: function(data) {
                    if (data == 1) {
                        alert("Payment Received!");
                    }
                    else {
                        alert("Unknown error!! Check again!")
                    }
            }
         });
    }
</script>
<?= $this->endSection(); ?>
