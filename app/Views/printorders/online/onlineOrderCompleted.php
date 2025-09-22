<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
              <h6 class='text-center'>Online Order completed List</h6> 
            </div>
        </div>
        <table class="zero-config table table-hover mt-4">
            <thead>
                <tr>
                <th>S.NO</th>
                <th>Order id</th>
                <th>Order Date</th>
                <th>Book ID</th>
                <th>title</th>
                <th>Author name</th>
                <th>shipped date</th>
                </tr>
            </thead>
                <tbody style="font-weight: normal;">
                <?php $i=1;
                foreach ($online_orderbooks['completed_all'] as $order_books){?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td>
                        <a href="<?= base_url('paperback/onlineorderdetails/' . $order_books['online_order_id']) ?>" target="_blank">
                            <?php echo $order_books['online_order_id']; ?>
                        </a>
                        <br>
                        <?php echo '(' . $order_books['username'] . ')'; ?> 
                        <br><br>
                        <a href="<?php echo $order_books['tracking_url']; ?>" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck">
                                <rect x="1" y="3" width="15" height="13"></rect>
                                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                            </svg>
                        </a>  
                        </td>
                        <td><?php echo date('d-m-Y',strtotime($order_books['order_date']))?> </td>
                        <td><a href="<?= base_url('paperback/paperbackledgerbooksdetails/' .$order_books['book_id']) ?>" target="_blank"><?php echo $order_books['book_id'] ?></a></td>
                        <td><?php echo $order_books['book_title'] ?></td>
                        <td><?php echo $order_books['author_name'] ?></td>
                        <td> <?php
                        if ($order_books['ship_date']== NULL) {
                            echo '';
                        } else {
                            echo date('d-m-Y', strtotime($order_books['ship_date'])); 
                        }?></td>
                        
                    </tr>
            <?php }?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>