<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 

<!-- Include Iconify (add once in your layout if not already) -->
<script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h6>Author Book Publish Dashboard - <?php echo urldecode($author_name); ?></h6><br>
            </div>
        </div>
        <hr>
        <table class="mt-4 table table-hover">
            <thead>
                <th class="no-content">Edit</th>
                <th class="no-content">Book ID</th>
                <th class="no-content">Title</th>
                <th># Pages</th>
                <th>Published Date</th>
                <th>Pustaka</th>
                <th>Amazon</th>
                <th>Scribd</th>
                <th>Google</th>
                <th>Overdrive</th>
                <th>Storytel</th>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($book_details); $i++) { ?>
                <tr>
                    <!-- Edit Icon -->
                    <td>
                        <ul class="table-controls">
                            <li>
                                <a class="rounded text-danger bs-tooltip" title="Edit Book" target="_blank" href="<?php echo base_url().'book/editbook/'.$book_details[$i]->book_id; ?>" data-toggle="tooltip" data-placement="top">
                                    <span class="iconify" data-icon="mdi:pencil-outline" data-width="20" data-height="20" style="color:#2196f3;"></span>
                                </a>
                            </li>
                        </ul>
                    </td>

                    <td><?php echo $book_details[$i]->book_id; ?></td>
                    <td><?php echo $book_details[$i]->book_title; ?><br>(<?php echo $book_details[$i]->regional_book_title; ?>)</td>
                    <td><?php echo $book_details[$i]->number_of_page; ?></td>
                    <td><?php echo $book_details[$i]->pub_dt; ?></td>

                    <!-- Pustaka -->
                    <td>
                        <?php if ($book_details[$i]->status == true) { 
                            $temp_download_link = $book_details[$i]->download_link;
                            $url_length = strlen($temp_download_link);
                            $first_sub_string = substr($temp_download_link, 0, $url_length - 1);
                            $lang_name = strtolower($book_details[$i]->language_name);
                        ?> 
                        <a href="<?php echo "http://www.pustaka.co.in/home/ebook/".$lang_name.substr($temp_download_link, strripos($first_sub_string, "/")); ?>" target="_blank">Yes</a>
                        <?php } else { ?> 
                        <span class="text-danger">No</span> 
                        <?php } ?>
                    </td>

                    <!-- Amazon -->
                    <td>
                        <?php if ($book_details[$i]->amazon_bk_link != null) { ?>
                            <a href="<?php echo "https://www.amazon.in/dp/".$book_details[$i]->amazon_bk_link; ?>" target="_blank">Yes</a>
                        <?php } else { ?>
                            <span class="text-danger">No</span>
                        <?php } ?>
                    </td>

                    <!-- Scribd -->
                    <td>
                        <?php if ($book_details[$i]->scribd_bk_link != null) { ?>
                            <a href="<?php echo "https://www.scribd.com/book/".$book_details[$i]->scribd_bk_link; ?>" target="_blank">Yes</a>
                        <?php } else { ?>
                            <span class="text-danger">No</span>
                        <?php } ?>
                    </td>

                    <!-- Google Play -->
                    <td>
                        <?php if ($book_details[$i]->play_store_link != null) { ?>
                            <span>Yes</span>
                        <?php } else { ?>
                            <span class="text-danger">No</span>
                        <?php } ?>
                    </td>

                    <!-- Overdrive -->
                    <td>
                        <?php if ($book_details[$i]->overdrive_bk_link != null) { ?>
                            <a href="<?php echo $book_details[$i]->overdrive_bk_link; ?>" target="_blank">Yes</a>
                        <?php } else { ?>
                            <span class="text-danger">No</span>
                        <?php } ?>
                    </td>

                    <!-- Storytel -->
                    <td>
                        <?php if ($book_details[$i]->storytel_isbn != null) { ?>
                            <a href="<?php echo $book_details[$i]->storytel_isbn; ?>" target="_blank">Yes</a>
                        <?php } else { ?>
                            <span class="text-danger">No</span>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>
