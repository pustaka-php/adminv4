<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h6 class="text-center">Initiate Print Completed List</h6>
            </div>
        </div>
        <br>
        <table class="table zero-config">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Created Date</th>
                    <th>Book Id</th>
                    <th>Title</th>
                    <th>Author Name</th>
                    <th>Copies</th>
                    <th>Completed Date</th>
                </tr>
            </thead>
            <tbody style="font-weight: normal;">
                <?php $i=1;
                foreach($print['completed_all'] as $print_book ) { 
                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($print_book['order_date'])); ?><br></td>
                        <input type="hidden" id="id" name="id" value="<?php $print_book['id']?>">
                        <td><?php echo $print_book['book_id']; ?></td>
                        <td><?php echo $print_book['book_title']; ?></td>
                        <td><?php echo $print_book['author_name']; ?></td>
                        <td><?php echo $print_book['quantity']; ?></td>
                        <td>
                        <?php
                        if ($print_book['completed_date']== NULL) {
                            echo '';
                        } else {
                            echo date('d-m-Y', strtotime($print_book['completed_date'])); 
                        }?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>