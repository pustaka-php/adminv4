<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="col-xxl-3 col-sm-6">
            <div class="card h-100 radius-12 bg-gradient-primary text-center" 
                style="width: 800px; max-width: 100%; margin-left: 500px; padding: 20px;">
                <div class="card-body p-24">
                    <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-primary-600 text-white mb-16 radius-12">
                        <iconify-icon icon="ri:shopping-cart-fill" class="h5 mb-0"></iconify-icon>
                    </div>
                    <h6 class="mb-8">Amazon Order</h6>
                    <p class="card-text mb-8 text-secondary-light">
                        <strong>Order Id:</strong> <?php echo $orderbooks['order']['amazon_order_id']; ?><br>
                        <strong>Shipping Type:</strong> <?php echo $orderbooks['order']['shipping_type']; ?><br>
                        <strong>Order Date:</strong> 
                        <?php 
                        if ($orderbooks['order']['order_date'] != NULL) {
                            echo date('d-m-Y', strtotime($orderbooks['order']['order_date']));
                        } ?><br>
                        <strong>Ship Date:</strong> <?php echo date('d-m-Y', strtotime($orderbooks['order']['ship_date'])); ?>
                    </p>
                </div>
            </div>
        </div>
        <br><br>
        <table class="table table-bordered mb-4 zero-config">
            <thead>
            <h6 class="text-center">List of Books</h6>
            <br>
            <tr>
                <th>S.No</th> 
                <th>BookId</th>
                <th>Title</th>
                <th>Regional Title</th>
                <th>Author</th>
                <th>Book Price</th>
                <th>quantity</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody style="font-weight: normal;">
                <?php
                    $i = 1;
                    foreach ($orderbooks['details'] as $books_details) {
                ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $books_details['book_id'] ?></td>
                        <td><?php echo $books_details['book_title'] ?></td>
                        <td><?php echo $books_details['regional_book_title'] ?></td>
                        <td><?php echo $books_details['author_name'] ?></td>
                        <td><?php echo $books_details['paper_back_inr'] ?></td>
                        <td><?php echo $books_details['quantity'] ?></td>
                        <td>
                        <?php
                       if ($books_details['ship_status']==0 ) 
                       {
                            echo "In Processing";
                        } else if ($books_details['ship_status']==1 ) {
                            echo "Shipped" ;
                        }else if ($books_details['ship_status']==2 ) {
                            echo "Cancel" ;
                        } else {
                            echo "Return";
                        } 
                        ?>
                        </td>
                        </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>