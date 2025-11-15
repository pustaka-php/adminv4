<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-header d-flex justify-content-between align-items-center">
                <div class="page-title text-center flex-grow-1">
                    <h6 class="text-center">Offline completed Books List</h6><br>
                </div>
                <a href="<?= base_url('paperback/offlineorderbooksstatus'); ?>" 
                class="btn btn-outline-secondary btn-sm">
                    ← Back
                </a>
            </div>
        </div> 
        <br>
        <table class="zero-config table table-hover mt-4">
            <thead>
                <tr>
                    <th>S.NO</th>
                    <th>Order id</th>
                    <th>Order Date</th>
                    <th>Book ID</th>
                    <th>Title</th>
                    <th>Author name</th>
                    <th>Shipped Date</th>
                    <th>Payment Details</th>
                </tr>
            </thead>
            <tbody style="font-weight: normal;">
                <?php $i=1;
                    foreach ($offline_orderbooks['completed_all'] as $order_books){?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td>
                                <a href="<?= base_url('paperback/offlineorderdetails/' . $order_books['offline_order_id']) ?>" target="_blank">
                                    <?php echo $order_books['offline_order_id']; ?>
                                </a>
                                <br>
                                <?php echo '(' . $order_books['customer_name'] . ')'; ?> 
                                <?php echo $order_books['city']; ?>
                                <br><br>
                                <a href="<?php echo $order_books['url']; ?>" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck">
                                        <rect x="1" y="3" width="15" height="13"></rect>
                                        <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                    </svg>
                                </a>
                        </td>
                        <td><?php
                        if ($order_books['order_date']== NULL) {
                            echo '';
                        } else {
                            echo date('d-m-Y', strtotime($order_books['order_date'])); 
                        }?></td>
                        <td><a href="<?= base_url('paperback/paperbackledgerbooksdetails/' .$order_books['book_id']) ?>" target="_blank"><?php echo $order_books['book_id'] ?></a></td>
                        <td><?php echo $order_books['book_title'] ?></td>
                        <td><?php echo $order_books['author_name'] ?></td>
                        <td><?php echo date('d-m-Y',strtotime($order_books['shipped_date']))?> </td>
                        <td><?php echo $order_books['payment_type'].'-'.$order_books['payment_status'] ?>
                        <?php $payment_status=$order_books['payment_status'];?>
                        <br>
                        <?php if ($payment_status =='Pending') { ?>
                            <a href="" onclick="mark_pay('<?php echo $order_books['offline_order_id'] ?>')" class="btn-sm btn-primary mb-2 mr-2">Mark Paid</a>
                        <?php } ?>
                        </td>
                    </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
 </div>
 <?= $this->endSection(); ?>