<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
            <h6 class="text-center">Amazon completed Books List</h6><br>
            </div>
        </div>
        <table class="table mb-4 zero-config">
                <thead>
                    <tr>
                    <th style="border: 1px solid grey">S.NO</th>
                    <th style="border: 1px solid grey">Order id</th>
                    <th style="border: 1px solid grey">Book ID</th>
                    <th style="border: 1px solid grey">title</th>
                    <th style="border: 1px solid grey">Author name</th>
                    <th style="border: 1px solid grey">Shipped Date</th>
                    </tr>
                </thead>
                <tbody style="font-weight: 1000;">
                <?php $i=1;
                foreach ($amazon_orderbooks['completed_all'] as $order_books){?>
                    <tr>
                        <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                        <td style="border: 1px solid grey">
                        <a href="<?= base_url('paperback/amazonorderdetails/'.$order_books['amazon_order_id']) ?>" target="_blank">
                        <?php echo $order_books['amazon_order_id'] ?></a></td>
                        <td style="border: 1px solid grey"><?php echo $order_books['book_id']?> </td>
                        <td style="border: 1px solid grey"><?php echo $order_books['book_title'] ?></td>
                        <td style="border: 1px solid grey"><?php echo $order_books['author_name'] ?></td>
                        <td style="border: 1px solid grey"><?php echo date('d-m-Y',strtotime($order_books['ship_date']))?> </td>
                    </tr>
            <?php }?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>