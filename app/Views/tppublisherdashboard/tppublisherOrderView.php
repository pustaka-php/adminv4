<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>

<div class="card basic-data-table mb-5">
        <div class="card-header py-3 px-4">
                <h5 class="card-title mb-0">TP Publisher Paperback Order Summary</h5>
            </div>
            <div class="card-body">
                <form id="royaltyForm" action="<?= base_url('tppublisherdashboard/tppublisherordersubmit') ?>" method="POST">
                    <input type="hidden" name="num_of_books" value="<?= count($tppublisher_paperback_stock); ?>">
                    <input type="hidden" name="selected_book_list" value="<?= esc($tppublisher_selected_book_id); ?>">
                    <input type="hidden" name="address" value="<?= esc($address); ?>">
                    <input type="hidden" name="mobile" value="<?= esc($mobile); ?>">
                    <input type="hidden" name="ship_date" value="<?= esc($ship_date); ?>">
                    <input type="hidden" name="author_id" value="<?= esc($author_id); ?>">
                    <input type="hidden" name="publisher_id" value="<?= esc($publisher_id); ?>">

        <div class="card-body p-4">
            <!-- <table id="dataTable" class="table bordered-table mb-0" data-page-length='10' style="font-size:13px;"> -->
                 <table class="zero-config table table-hover mt-4" id="dataTable"  data-page-length="10"> 
                <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Book ID</th>
                                    <th>Publisher Book ID</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                    <th>Stock Status</th>
                                    <!-- <th>In Progress</th> -->
                                    <th>Stock In Hand</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1; $j = 0; $grand_total = 0;
                                foreach ($tppublisher_paperback_stock as $orders): 
                                    $quantity = isset($book_qtys[$j]) ? (int)$book_qtys[$j] : 0;
                                    $price = isset($orders['price']) ? (float)$orders['price'] : 0;
                                    $subtotal = $quantity * $price;
                                    $grand_total += $subtotal;
                                    $stockStatus = $quantity <= ($orders['stock_in_hand'] ?? 0) ? 'IN STOCK' : 'OUT OF STOCK';
                                    $rowClass = $stockStatus === 'IN STOCK' ? 'bg-success-light' : 'bg-danger-light';
                                ?>
                                <tr class="<?= $rowClass ?>">
                                    <td><?= $i++ ?></td>
                                    <td>
                                        <?= esc($orders['book_id']) ?>
                                        <input type="hidden" name="book_id<?= $j ?>" value="<?= esc($orders['book_id']) ?>">
                                        <input type="hidden" name="bk_qty<?= $j ?>" value="<?= esc($quantity) ?>">
                                        <input type="hidden" name="price<?= $j ?>" value="<?= esc($price) ?>">
                                    </td>
                                    <td><?= esc($orders['sku_no']) ?></td>
                                    <td><?= esc($orders['book_title']) ?></td>
                                    <td><?= esc($orders['author_name']) ?></td>
                                    <td><?= esc($quantity) ?></td>
                                    <td>₹<?= number_format($price, 2) ?></td>
                                    <td>₹<?= number_format($subtotal, 2) ?></td>
                                    <td><?= esc($stockStatus) ?></td>
                                    <!-- <td><?= esc($orders['Qty'] ?? '0') ?></td> -->
                                    <td><?= esc($orders['stock_in_hand'] ?? '0') ?></td>
                                </tr>
                                <?php $j++; endforeach; ?>
                                <tr class="bg-primary-light">
                                    <td colspan="5" class="text-end fw-bold">Total</td>
                                    <td colspan="2" class="fw-bold">₹<?= number_format($grand_total, 2) ?></td>
                                    <td colspan="4"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <?php
                    $royalty = 0;
                    if ($grand_total >= 1 && $grand_total <= 500) {
                        $royalty = 25;
                    } elseif ($grand_total <= 2000) {
                        $royalty = $grand_total * 0.10;
                    } elseif ($grand_total <= 4000) {
                        $royalty = $grand_total * 0.08;
                    } else {
                        $royalty = $grand_total * 0.05;
                    }
                    ?>

                    <div class="text-center mb-4">
                        <h5 class="text-primary">Handling charges: ₹<?= number_format($royalty, 2) ?></h5>
                    </div>

                    <input type="hidden" name="grand_total" value="<?= $grand_total ?>">
                    <input type="hidden" name="royalty" value="<?= $royalty ?>">
                    <input type="hidden" name="payment_status" id="payment_status" value="success">

                    <div class="d-flex justify-content-center gap-3">
                        <button type="submit" class="btn btn-success" id="confirmOrderBtn">
                            <i class="fas fa-check-circle me-2"></i>Confirm Order
                        </button>
                        <a href="<?= base_url('tppublisherdashboard/tppublisherdashboard') ?>" class="btn btn-danger">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>