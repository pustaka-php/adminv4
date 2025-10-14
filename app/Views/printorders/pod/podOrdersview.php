<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
    <script src="<?= base_url('assets/js/homeFourChart.js') ?>"></script>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?> 

    
    <div class="row gy-4 mt-4">

    <!-- Quotation Table -->
    <div class="col-xxl-7">
        <div class="card h-100 radius-8 border-0 shadow-sm">
            <div class="card-body p-24">
                <h6 class="fw-bold text-lg mb-3">Quotation Details</h6>
                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No.Of.Pages</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>1</td><td>>=50 to <=75</td><td>0.5</td></tr>
                            <tr><td>2</td><td>>=76 to <=100</td><td>0.45</td></tr>
                            <tr><td>3</td><td>>=101 to <=150</td><td>0.41</td></tr>
                            <tr><td>4</td><td>>150</td><td>0.38</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Carousel -->
<div class="col-xxl-5">
    <div class="card h-100 radius-24 border-0 shadow-sm p-3 bg-gradient-start-2">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h6 class="fw-bold text-lg mb-0">Orders</h6>
            <a href="<?= base_url('pod/podbookadd') ?>" class="btn rounded-pill btn-neutral-600 text-base radius-8 px-20 py-11">
                Create Order
            </a>
        </div>

        <!-- Slider -->
        <div id="ordersSlider" class="carousel slide w-100" data-bs-ride="carousel">
            <div class="carousel-inner">

                <!-- Slide 1: POD Summary -->
                <div class="carousel-item active">
                    <a href="<?= base_url('pod/podbookscompleted') ?>" 
                   class="text-decoration-none d-flex flex-column justify-content-center align-items-center h-100 p-4 
                              w-100 radius-24 bg-gradient-purple border-0 shadow-sm">
                        <div class="w-24-px h-24-px d-flex justify-content-center align-items-center bg-purple-600 rounded-circle mb-3">
                            <iconify-icon icon="mdi:book"></iconify-icon>
                        </div>
                        <h5 class="fw-bold mb-2">POD Summary</h5>
                        <p class="mb-1">Total Books: <strong><?= esc($summary['total_books'] ?? 0) ?></strong></p>
                        <p class="mb-0">Active: <strong><?= esc($summary['active'] ?? 0) ?></strong> | Pending: <strong><?= esc($summary['pending'] ?? 0) ?></strong></p>
                    </a>
                </div>


                <!-- Slide 2: Completed Orders -->
                <div class="carousel-item">
                    <a href="<?= base_url('pod/completedpodorders') ?>" 
                       class="text-decoration-none d-flex flex-column justify-content-center align-items-center h-100 p-4 
                              w-100 radius-24 bg-gradient-purple border-0 shadow-sm">
                        <div class="w-24-px h-24-px d-flex justify-content-center align-items-center bg-purple-600 rounded-circle mb-3">
                            <iconify-icon icon="mdi:check"></iconify-icon>
                        </div>
                        <h5 class="fw-bold mb-2">Completed Orders</h5>
                        <p class="mb-1">This Month: <strong><?= esc($orders['month_completed'] ?? 0) ?></strong></p>
                        <p class="mb-0">Total: <strong><?= esc($orders['total_completed'] ?? 0) ?></strong></p>
                    </a>
                </div>

            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#ordersSlider" data-bs-slide="prev">
                <!-- <span class="carousel-control-prev-icon"></span> -->
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#ordersSlider" data-bs-slide="next">
                <!-- <span class="carousel-control-next-icon"></span> -->
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <!-- End Slider -->
    </div>
</div>



</div>

<!-- Include POD In-Progress Orders -->
<?= $this->include('printorders/pod/podInprogressOrders') ?>


<?= $this->endSection(); ?>