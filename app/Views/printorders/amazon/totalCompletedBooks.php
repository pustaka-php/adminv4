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
                    <th>S.NO</th>
                    <th>Order id</th>
                    <th>Book ID</th>
                    <th>title</th>
                    <th>Author name</th>
                    <th>Shipped Date</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal;">
                <?php $i=1;
                foreach ($amazon_orderbooks['completed_all'] as $order_books){?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td>
                        <a href="<?= base_url('paperback/amazonorderdetails/'.$order_books['amazon_order_id']) ?>" target="_blank">
                        <?php echo $order_books['amazon_order_id'] ?></a></td>
                        <td><?php echo $order_books['book_id']?> </td>
                        <td><?php echo $order_books['book_title'] ?></td>
                        <td><?php echo $order_books['author_name'] ?></td>
                        <td><?php echo date('d-m-Y',strtotime($order_books['ship_date']))?> </td>
                    </tr>
            <?php }?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>