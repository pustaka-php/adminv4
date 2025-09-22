<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="card h-80 radius-12 bg-gradient-success text-end"style="max-width: 45rem; margin: 0 auto;">
            <div class="card-body p-24">
                <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-success-600 text-white mb-16 radius-12">
                    <iconify-icon icon="fluent:toolbox-20-filled" class="h5 mb-0"></iconify-icon>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-transparent border-0">
                        <h6 class="text-center">Flipkart Order</h6>
                    </li><br>
                    <li class="list-group-item bg-transparent border-0 text-start">
                        <h6 class="text-center">Order Id: <?php echo $orderbooks['order']['flipkart_order_id']; ?> </h6>
                        <h6 class="text-center">Order Date:
                            <?php
                            if ($orderbooks['order']['order_date']== NULL) {
                                echo '';
                            } else {
                                echo date('d-m-Y',strtotime($orderbooks['order']['order_date']));
                            }?>
                        </h6>
                        <h6 class="text-center">Ship Date: <?php echo date('d-m-Y',strtotime($orderbooks['order']['ship_date']));?></h6>
                    </li>
                </ul>
            </div>
        </div>
        <br>
        <br>
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
