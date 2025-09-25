<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="card basic-data-table mb-5">

    <div class="card-body">
        <form id="royaltyForm" action="<?= base_url('tppublisherdashboard/tppublisherordersubmit') ?>" method="POST">
            <input type="hidden" name="address" value="<?= esc($address); ?>">
            <input type="hidden" name="mobile" value="<?= esc($mobile); ?>">
            <input type="hidden" name="ship_date" value="<?= esc($ship_date); ?>">
            <input type="hidden" name="payment_status" value="success">
            <input type="hidden" name="transport" value="<?= esc($transport); ?>">
            <input type="hidden" name="comments" value="<?= esc($comments); ?>">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Order Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grand_total = 0;
                    $total_quantity = 0;
                    foreach ($tppublisher_paperback_stock as $i => $book): 
                        $quantity = $book_qtys[$i] ?? 0;
                        $mrp = $book_prices[$i] ?? $book['mrp'];
                        $subtotal = $quantity * $mrp;
                        $grand_total += $subtotal;
                        $total_quantity += $quantity;
                    ?>
                    <tr>
                        <td><?= $i+1 ?></td>
                        <td>
                            <?= esc($book['book_title']) ?><br>
                            <small class="text-muted">
                                Pages: <?= esc($book['number_of_page']) ?> | ISBN: <?= esc(str_replace('-', '', $book['isbn'])) ?>
                            </small>
                        </td>
                        <td>₹<?= number_format($mrp,2) ?></td>
                        <td class="text-center"><?= $quantity ?></td>
                        <td class="text-center">₹<?= number_format($subtotal,2) ?></td>

                        <!-- Hidden inputs -->
                        <input type="hidden" name="book_id[]" value="<?= esc($book['book_id']) ?>">
                        <input type="hidden" name="quantity[]" value="<?= $quantity ?>">
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="fw-bold bg-light">
                    <tr>
                        <td colspan="3" class="text-end">Total</td>
                        <td class="text-center"><?= $total_quantity ?></td>
                        <td class="text-center">₹<?= number_format($grand_total,2) ?></td>
                    </tr>
                </tfoot>
            </table>

            <?php
            if ($grand_total <= 500) {
                $royalty = 25;
            } elseif ($grand_total <= 2000) {
                $royalty = ceil(($grand_total * 0.10) / 10) * 10;
            } elseif ($grand_total <= 4000) {
                $royalty = ceil(($grand_total * 0.08) / 10) * 10;
            } else {
                $royalty = ceil(($grand_total * 0.05) / 10) * 10;
            }
            ?>

            <div class="text-center mt-3">
                <h6>Handling Charges: ₹<?= number_format($royalty,2) ?></h6>

                <!-- Hidden fields -->
                <input type="hidden" name="grand_total" value="<?= $grand_total ?>">
                <input type="hidden" name="royalty" value="<?= $royalty ?>">
                <input type="hidden" name="total_quantity" value="<?= $total_quantity ?>">

                <button type="submit" class="btn btn-success">Confirm Order</button>
                <a href="<?= base_url('tppublisherdashboard/tppublisherdashboard') ?>" class="btn btn-danger">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>
