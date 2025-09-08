<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
              <h3 class='text-center'>Bookshop completed Books List</h3> 
            </div>
        </div> 
        <br>
        <table class="table table-hover mb-4 zero-config">
            <thead>
                <tr>
                    <th style="border: 1px solid grey">S.NO</th>
                    <th style="border: 1px solid grey">Order Date</th>
                    <th style="border: 1px solid grey">Order id</th>
                    <th style="border: 1px solid grey">Buyer's Order No</th>
                    <th style="border: 1px solid grey">No.of title</th>
                    <th style="border: 1px solid grey">Ship Date</th>
                    <th style="border: 1px solid grey">Payment Details</th>
                    <th style="border: 1px solid grey">View </th>
                </tr>
            </thead>
            <tbody style="font-weight: 1000;">
                <?php $i=1;
                    foreach ($orderbooks['completed_all'] as $order_books){?>
                    <tr>
                        <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                            <td style="border: 1px solid grey">
                                <a href="<?= base_url('pustaka_paperback/bookshop_order_details/' . $order_books['order_id']) ?>" target="_blank">
                                    <?php echo $order_books['order_id']; ?>
                                </a> <br>
                                <?php echo '(' . $order_books['bookshop_name'] . ')'; ?>
                                <br> <?php echo $order_books['city']; ?>
                            </td>
                            <td style="border: 1px solid grey"><?php echo date('d-m-Y',strtotime($order_books['order_date']))?> </td>
                            <td style="border: 1px solid grey"><?php echo $order_books['vendor_po_order_number']?> </td>
                                <td style="border: 1px solid grey"><?php echo $order_books['tot_book']?> </td>
                            <td style="border: 1px solid grey"><?php echo date('d-m-Y',strtotime($order_books['ship_date']))?> </td>
                            <td style="border: 1px solid grey"><?php echo $order_books['payment_type'].'-'.$order_books['payment_status'] ?>
                        <?php $payment_status=$order_books['payment_status'];?>
                        <br>
                        <?php if ($payment_status =='Pending') { ?>
                            <a href="" onclick="mark_pay('<?php echo $order_books['order_id'] ?>')" class="btn-sm btn-primary mb-2 mr-2">Mark Paid</a>
                        <?php } ?>
                        </td>
                        <td style="border: 1px solid grey; text-align: center;">
                            <a href="<?= base_url('pustaka_paperback/bookshop_order_details/' . $order_books['order_id']) ?>" class="btn btn-info mb-2 mr-2">View</a>
                        </td>    
                    </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
 </div>