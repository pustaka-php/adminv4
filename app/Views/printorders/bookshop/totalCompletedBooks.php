<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
              <h6 class='text-center'>Bookshop completed Books List</h6> 
            </div>
        </div> 
        <br>
        <table class="table table-hover mb-4 zero-config">
            <thead>
                <tr>
                    <th>S.NO</th>
                    <th>Order Date</th>
                    <th>Order id</th>
                    <th>Buyer's Order No</th>
                    <th>No.of title</th>
                    <th>Ship Date</th>
                    <th>Payment Details</th>
                    <th>View </th>
                </tr>
            </thead>
            <tbody style="font-weight: normal;">
                <?php $i=1;
                    foreach ($orderbooks['completed_all'] as $order_books){?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                            <td>
                                <a href="<?= base_url('paperback/bookshoporderdetails/' . $order_books['order_id']) ?>" target="_blank">
                                    <?php echo $order_books['order_id']; ?>
                                </a> <br>
                                <?php echo '(' . $order_books['bookshop_name'] . ')'; ?>
                                <br> <?php echo $order_books['city']; ?>
                            </td>
                            <td><?php echo date('d-m-Y',strtotime($order_books['order_date']))?> </td>
                            <td><?php echo $order_books['vendor_po_order_number']?> </td>
                            <td><?php echo $order_books['tot_book']?> </td>
                            <td><?php echo date('d-m-Y',strtotime($order_books['ship_date']))?> </td>
                            <td><?php echo $order_books['payment_type'].'-'.$order_books['payment_status'] ?>
                        <?php $payment_status=$order_books['payment_status'];?>
                        <br>
                        <?php if ($payment_status =='Pending') { ?>
                            <a href="" onclick="mark_pay('<?php echo $order_books['order_id'] ?>')" class="btn-sm btn-primary mb-2 mr-2">Mark Paid</a>
                        <?php } ?>
                        </td>
                        <td>
                            <a href="<?= base_url('paperback/bookshoporderdetails/' . $order_books['order_id']) ?>" class="btn btn-info mb-2 mr-2">View</a>
                        </td>    
                    </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
 </div>
<?= $this->endSection() ?>