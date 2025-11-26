<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content') ?>

<div class="row">
    <!-- Book Info: full width on top -->
    <div class="col-12 mb-3">
       <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-1">
            <h5>Book Info</h5>
            <p><b>ID:</b> <?= esc($book['book_id']) ?></p>
            <p><b>Publisher Name:</b> <?= esc($book['publisher_name']) ?></p>
            <p><b>Sku No:</b> <?= esc($book['sku_no']) ?></p>
            <p><b>Title:</b> <?= esc($book['book_title']) ?></p>
            <p><b>Regional Title:</b> <?= esc($book['book_regional_title']) ?></p>
            <p><b>MRP:</b> <?= esc($book['mrp']) ?></p>
            <p><b>No of Pages:</b> <?= esc($book['no_of_pages']) ?></p>
            <p><b>ISBN:</b> <?= esc($book['isbn']) ?></p>
        </div>
    </div>
</div>

<div class="row">
    <!-- Stock Info -->
    <div class="col-md-6 mb-3">
        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-2">
            <h5>Stock Info</h5>
            <p><b>Quantity:</b> <?= esc($stock['book_quantity']) ?></p>
            <p><b>Stock in Hand:</b> <?= esc($stock['stock_in_hand']) ?></p>
        </div>
    </div>

    <!-- Ledger Stock -->
    <div class="col-md-6 mb-3">
    <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-3">
    <h5>Ledger Stock</h5>
    <p><b>Total Stock:</b> <?= esc($ledger['stock_in']) ?></p>
    <p><b>Stock Out:</b> <?= esc($ledger['stock_out']) ?></p>
    <p><b>Pending Order:</b> <?= esc($ledger['pending_qty']) ?></p>
    <p><b>Balance Stock In:</b> <?= esc($ledger['available']) ?></p>
</div>


    </div>
</div>

<hr>
<br>

<!-- First Table -->
<h6>Ledger Details</h6>
<table class="zero-config table table-hover mt-4">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Channel</th>
            <th>Description</th>
            <th>Stock In</th>
            <th>Stock Out</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($orders as $row): ?>
        <tr>
            <td><?= $row['order_id'] ?></td>
            <td><?= $row['channel_type'] ?></td>
            <td><?= $row['description'] ?></td>
            <td><?= $row['stock_in'] ?></td>
            <td><?= $row['stock_out'] ?></td>
            <td><?= date('d-m-y', strtotime($row['transaction_date'])) ?></td>

        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<br>

<hr>

<h6>Order - Publisher</h6>
<table class="zero-config table table-hover mt-4">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Order Date</th>
            <th>Contact Person</th>
            <th>City</th>
            <th>Quantity</th>
            <th>Channel</th>            
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($orderRoyalty)): ?>
            <?php foreach($orderRoyalty as $row): ?>
                <tr>
                    <td><?= esc($row['order_id']) ?></td>
                    <td><?= date('d-m-y', strtotime($row['order_date'])) ?></td>
                    <td><?= esc($row['contact_person']) ?></td>
                    <td><?= esc($row['city']) ?></td>
                    <td><?= esc($row['quantity']) ?></td>
                    <td><?= esc($row['channel_type']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">No order details found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<hr>
<br>
<h6>Sales - Pustaka</h6>
<table class="zero-config table table-hover mt-4">
    <thead>
        <tr>
            
            <th>Sales Date</th>
            <th>Quantity</th>
            <th>Channel</th>
            <th>To Pay</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($sales)): ?>
            <?php foreach($sales as $row): ?>
                <tr>
                    
                    <td><?= date('d-m-y', strtotime($row['create_date'])) ?></td>
                    <td><?= esc($row['sales_qty']) ?></td>
                    <td><?= esc($row['sales_channel']) ?></td>
                    <td><?= esc($row['author_amount']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">No sales details found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>



<?= $this->endSection() ?>
