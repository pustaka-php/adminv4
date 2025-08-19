<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="card bg-info" style="width: 45rem; margin: 0 auto; border-radius: 10px; overflow: hidden;">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <h3 class="text-center">Amazon Order</h3>
                </li>
                <li class="list-group-item">
                <h5>Order Id: <?php echo $orderbooks['order']['amazon_order_id']; ?> </h5>
                <h5>Shipping Type: <?php echo $orderbooks['order']['shipping_type']; ?> </h5>
                <h5>Order Date:
                    <?php
                    if ($orderbooks['order']['order_date']== NULL) {
                        echo '';
                    } else {
                        echo date('d-m-Y',strtotime($orderbooks['order']['order_date']));
                    }?></h5>
                <h5>Ship Date: <?php echo date('d-m-Y',strtotime($orderbooks['order']['ship_date']));?></h5>
                </li>
            </ul>
        </div>
        <br>
        <br>
        <table class="table table-bordered mb-4 zero-config">
            <thead>
            <center><h4>List of Books</h4></center>
            <br>
            <tr>
                <th style="border: 1px solid grey; width: 5%;">S.No</th> 
                <th style="border: 1px solid grey; width: 8%">BookId</th>
                <th style="border: 1px solid grey">Title</th>
                <th style="border: 1px solid grey">Regional Title</th>
                <th style="border: 1px solid grey">Author</th>
                <th style="border: 1px solid grey">Book Price</th>
                <th style="border: 1px solid grey">quantity</th>
                <th style="border: 1px solid grey">Status</th>
            </tr>
            </thead>
            <tbody style="font-weight: 800;">
                <?php
                    $i = 1;
                    foreach ($orderbooks['details'] as $books_details) {
                ?>
                    <tr>
                        <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['book_id'] ?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['book_title'] ?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['regional_book_title'] ?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['author_name'] ?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['paper_back_inr'] ?></td>
                        <td style="border: 1px solid grey"><?php echo $books_details['quantity'] ?></td>
                        <td style="border: 1px solid grey">
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