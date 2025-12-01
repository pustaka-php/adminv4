<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>
<div class="row gy-4">
    <!-- Paperback Stock Card -->
    <div class="col-xxl-4 col-sm-6">
        <div class="card h-100 radius-12 bg-gradient-purple text-start">
            <div class="card-body p-24">
                <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-lilac-600 text-white mb-16 radius-12">
                    <iconify-icon icon="solar:book-2-bold" class="h5 mb-0"></iconify-icon>
                </div>
                <h6 class="mb-8">Paperback Stock</h6>
                <p class="card-text mb-8 text-secondary-light">
                    <strong>Book ID:</strong> <?= esc($book_details['book_id']) ?><br>
                    <strong>Title:</strong> <?= esc($book_details['book_title']) ?><br>
                    <strong>Quantity:</strong> <?= esc($book_details['quantity']) ?><br>
                    <strong>Stock in Hand:</strong> <?= esc($book_details['stock_in_hand']) ?><br>
                    <strong>Last Updated Date:</strong> <?= esc($book_details['last_update_date']) ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Author Transaction Card -->
    <div class="col-xxl-4 col-sm-6">
        <div class="card h-100 radius-12 bg-gradient-success text-start">
            <div class="card-body p-24">
                <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-success-600 text-white mb-16 radius-12">
                    <iconify-icon icon="ph:pen-bold" class="h5 mb-0"></iconify-icon>
                </div>
                <h6 class="mb-8">Author Transaction</h6>
                <?php if ($author_transaction): ?>
                    <p class="card-text mb-8 text-secondary-light">
                        <strong>Book ID:</strong> <?= esc($author_transaction['book_id']) ?><br>
                        <strong>Title:</strong> <?= esc($author_transaction['book_title']) ?><br>
                        <!-- <strong>Quantity:</strong> <?= esc($author_transaction['quantity']) ?><br>
                        <strong>Stock In:</strong> <?= esc($author_transaction['stock_in_hand']) ?><br> -->
                        <strong>Order Date:</strong> <?= esc($author_transaction['order_date']) ?><br>
                        <strong>Comments:</strong> <?= esc($author_transaction['comments']) ?>
                    </p>
                <?php else: ?>
                    <p>No transaction data found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Stock Ledger Card -->
    <div class="col-xxl-4 col-sm-6">
        <div class="card h-100 radius-12 bg-gradient-danger text-start">
            <div class="card-body p-24">
                <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-danger-600 text-white mb-16 radius-12">
                    <iconify-icon icon="mdi:clipboard-text-clock-outline" class="h5 mb-0"></iconify-icon>
                </div>
                <h6 class="mb-8">Stock Ledger</h6>
                <?php if ($stock_ledger): ?>
                    <p class="card-text mb-8 text-secondary-light">
                        <strong>Book ID:</strong> <?= esc($stock_ledger['book_id']) ?><br>
                        <strong>Title:</strong> <?= esc($stock_ledger['book_title']) ?><br>
                        <!-- <strong>Quantity:</strong> <?= esc($stock_ledger['stock_in']) ?><br> -->
                        <strong>Description:</strong> <?= esc($stock_ledger['description']) ?><br>
                        <strong>Stock In:</strong> <?= esc($stock_ledger['stock_in']) ?><br>
                        <strong>Date:</strong> <?= esc($stock_ledger['transaction_date']) ?>
                    </p>
                <?php else: ?>
                    <p>No stock ledger entry found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<br>
<?php foreach ($stock_user_details as $user): ?>
    <h7 class="mb-24 d-flex justify-content-center">
        <span style="color: #4548d5ff; font-weight: bold;">Updated By:</span>&nbsp;
        <?= esc($user['updated_user_id']) ?> - <?= esc($user['updated_by']) ?> - <?= esc($user['last_update_date']) ?>
    </h7>
    <h7 class="mb-24 d-flex justify-content-center">
        <span style="color: #28a745; font-weight: bold;">Validated By:</span>&nbsp;
        <?= esc($user['validated_user_id']) ?> - <?= esc($user['validated_by']) ?> - <?= esc($user['last_validated_date']) ?>
    </h7>
<?php endforeach; ?>

<br>
<!-- Back Button with POST Form -->
<div class="d-flex justify-content-end gap-3">
    <form action="<?= base_url('stock/validatestock'); ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="book_id" value="<?= esc($book_details['book_id']) ?>">
        <button type="submit" class="badge text-sm fw-semibold bg-success-600 px-20 py-9 radius-4 text-white text-center border-0">
            Validate Stock
        </button>
    </form>

  <a href="<?= base_url('adminv4/closeWindow?title=' . urlencode('Ignored this time')); ?>"
   class="badge text-sm fw-semibold bg-primary-600 px-20 py-9 radius-4 text-white text-center">
   Ignore this time
</a>

</div>
<?= $this->endSection(); ?>
