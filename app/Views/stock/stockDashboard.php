<?= $this->extend('layout/layout1'); ?>
<?= $this->section('script'); ?>
  <script src="<?= base_url('assets/js/homeFiveChart.js') ?>"></script>
<?= $this->endSection(); ?>
<?= $this->section('content'); ?>

<div class="row gy-4">
    <div class="d-flex gap-4 justify-content-end">
        <a href="<?= base_url('stock/addstock'); ?>">
            <span class="badge text-sm fw-semibold bg-lilac-600 px-20 py-9 radius-4 text-white">
                Add Stock
            </span>
        </a>
        <a href="<?= base_url('stock/otherdistribution'); ?>">
            <span class="badge text-sm fw-semibold bg-info-600 px-20 py-9 radius-4 text-white">Other Distribution</span>
        </a>
    </div>

    <!-- Stock In Hand -->
    <div class="col-xxl-3 col-sm-6">
        <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-3">
            <div class="card-body p-0">
                <div class="d-flex align-items-center">
                    <div class="w-64-px h-64-px radius-16 bg-base-50 d-flex justify-content-center align-items-center me-20">
                        <span class="w-40-px h-40-px bg-primary-600 text-white d-flex justify-content-center align-items-center radius-8">
                            <iconify-icon icon="mdi:book-open-variant"></iconify-icon>
                        </span>
                    </div>
                    <div>
                        <span class="mb-2 fw-medium text-secondary-light text-md">Stock</span>
                        <h6 class="fw-semibold my-1"><?= esc($details['stock_in_hand']->total_books ?? 0) ?></h6>
                        <p class="text-sm mb-1">
                            Stock In Hand: <span class="fw-semibold text-success"><?= esc($details['stock_in_hand']->total_stock ?? 0) ?></span><br>
                            No of Titles: <span class="fw-semibold text-primary"><?= esc($details['stock_in_hand']->total_titles ?? 0) ?></span>
                        </p>
                        <a href="getstockdetails" class="badge text-sm fw-semibold bg-neutral-800 px-20 py-9 radius-4 text-base">View</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Out of Stock -->
    <div class="col-xxl-3 col-sm-6">
        <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-2">
            <div class="card-body p-0">
                <div class="d-flex align-items-center">
                    <div class="w-64-px h-64-px radius-16 bg-base-50 d-flex justify-content-center align-items-center me-20">
                        <span class="w-40-px h-40-px bg-purple text-white d-flex justify-content-center align-items-center radius-8">
                            <iconify-icon icon="mdi:cart-off"></iconify-icon>
                        </span>
                    </div>
                    <div>
                        <span class="mb-2 fw-medium text-secondary-light text-md">Out of Stock</span>
                        <h6 class="fw-semibold my-1"><?= esc($details['out_of_stock']->out_of_stocks_titles ?? 0) ?></h6>
                        <p class="text-sm mb-1">
                            No of Titles: <span class="fw-semibold text-primary"><?= esc($details['out_of_stock']->out_of_stocks_titles ?? 0) ?></span>
                        </p>
                        <a href="outofstockdetails" class="badge text-sm fw-semibold bg-neutral-800 px-20 py-9 radius-4 text-base">View</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lost Books -->
    <div class="col-xxl-3 col-sm-6">
        <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-5">
            <div class="card-body p-0">
                <div class="d-flex align-items-center">
                    <div class="w-64-px h-64-px radius-16 bg-base-50 d-flex justify-content-center align-items-center me-20">
                        <span class="w-40-px h-40-px bg-red text-white d-flex justify-content-center align-items-center radius-8">
                            <iconify-icon icon="mdi:book-alert"></iconify-icon>
                        </span>
                    </div>
                    <div>
                        <span class="mb-2 fw-medium text-secondary-light text-md">Lost Books</span>
                        <h6 class="fw-semibold my-1"><?= esc($details['lost_books']->total_lost_books ?? 0) ?></h6>
                        <p class="text-sm mb-1">
                            No of Titles: <span class="fw-semibold text-primary"><?= esc($details['lost_books']->total_lost_titles ?? 0) ?></span>
                        </p>
                        <a href="loststockdetails" class="badge text-sm fw-semibold bg-neutral-800 px-20 py-9 radius-4 text-base">View</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Outside Stocks -->
    <div class="col-xxl-3 col-sm-6">
        <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-4">
            <div class="card-body p-0">
                <div class="d-flex align-items-center">
                    <div class="w-64-px h-64-px radius-16 bg-base-50 d-flex justify-content-center align-items-center me-20">
                        <span class="w-40-px h-40-px bg-success-main text-white d-flex justify-content-center align-items-center radius-8">
                            <iconify-icon icon="mdi:truck-cargo-container"></iconify-icon>
                        </span>
                    </div>
                    <div>
                        <span class="mb-2 fw-medium text-secondary-light text-md">Outside Stocks</span>
                        <?php
                        $outsideStocks = $details['outside_stocks'] ?? (object)['total_books' => 0, 'total_title' => 0];

                        $totalBooks = $outsideStocks->total_books ?? 0;
                        $totalTitles = $outsideStocks->total_title ?? 0;
                        ?>
                        <h6 class="fw-semibold my-1"><?= esc($totalBooks) ?></h6>
                        No of Titles:<span class="fw-semibold text-primary"><?= esc($totalTitles) ?></span>
                        <br>
                        <a href="outsidestockdetails" class="badge text-sm fw-semibold bg-neutral-800 px-20 py-9 radius-4 text-base">View</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>