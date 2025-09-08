<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?> 

    <div class="row gy-4">
        <div class="col-xxl-8">
            <div class="row gy-4">

                <!-- Online -->
                <div class="col-xxl-4 col-sm-6">
                    <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-1">
                        <a href="<?= route_to('paperback/onlineorderbooksstatus') ?>">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                            <iconify-icon icon="mingcute:user-follow-fill" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Online</span>
                                            <h6 class="fw-semibold">15,000</h6>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm mb-0">Increase by 
                                    <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">+200</span> this week
                                </p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Offline -->
                <div class="col-xxl-4 col-sm-6">
                    <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-2">
                        <a href="<?= route_to('paperback/offlineorderbooksstatus') ?>">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px bg-success-main flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6">
                                            <iconify-icon icon="mingcute:user-follow-fill" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Offline</span>
                                            <h6 class="fw-semibold">8,000</h6>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm mb-0">Increase by 
                                    <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">+200</span> this week
                                </p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Amazon -->
                <div class="col-xxl-4 col-sm-6">
                    <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-3">
                        <a href="<?= route_to('paperback/amazonorderbooksstatus') ?>">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px bg-yellow text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                            <iconify-icon icon="iconamoon:discount-fill" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Amazon</span>
                                            <h6 class="fw-semibold">$5,00,000</h6>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm mb-0">Increase by 
                                    <span class="bg-danger-focus px-1 rounded-2 fw-medium text-danger-main text-sm">-$10k</span> this week
                                </p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Flipkart -->
                <div class="col-xxl-4 col-sm-6">
                    <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-4">
                        <a href="<?= route_to('paperback/flipkartorderbooksstatus') ?>">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px bg-purple text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                            <iconify-icon icon="mdi:message-text" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Flipkart</span>
                                            <h6 class="fw-semibold">25%</h6>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm mb-0">Increase by 
                                    <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">+5%</span> this week
                                </p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Author -->
                <div class="col-xxl-4 col-sm-6">
                    <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-5">
                        <a href="<?= route_to('paperback/authororderbooksstatus') ?>">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px bg-pink text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                            <iconify-icon icon="mdi:leads" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Author</span>
                                            <h6 class="fw-semibold">250</h6>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm mb-0">Increase by 
                                    <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">+20</span> this week
                                </p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- BookShop -->
                <div class="col-xxl-4 col-sm-6">
                    <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-6">
                        <a href="<?= route_to('paperback/bookshoporderbooksstatus') ?>">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px bg-cyan text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                            <iconify-icon icon="streamline:bag-dollar-solid" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">BookShop</span>
                                            <h6 class="fw-semibold">$3,00,700</h6>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm mb-0">Increase by 
                                    <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">+$15k</span> this week
                                </p>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <!-- Revenue Growth -->
        <div class="col-xxl-4 col-sm-12 mb-3">
            <div class="card h-100 radius-8 border-0 overflow-hidden">
                <div class="card-body p-24">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                        <h6 class="mb-2 fw-bold text-lg">POD Orders</h6>
                        <div>
                            <a href="<?= base_url('pod/dashboard') ?>" class="btn btn-sm btn-primary radius-8">
                                View
                            </a>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap align-items-center mt-3">
                        <ul class="flex-shrink-0">
                            <li class="d-flex align-items-center gap-1 mb-20">
                                <span class="w-12-px h-12-px rounded-circle bg-success-main"></span>
                                <span class="text-secondary-light text-sm fw-medium">
                                    Not Started: <?= $pending_books['NotStarted']; ?>
                                </span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-20">
                                <span class="w-12-px h-12-px rounded-circle bg-warning-main"></span>
                                <span class="text-secondary-light text-sm fw-medium">
                                    In Progress: <?= $pending_books['PendingCount']; ?>
                                </span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-20">
                                <span class="w-12-px h-12-px rounded-circle bg-primary-600"></span>
                                <span class="text-secondary-light text-sm fw-medium">
                                    Pending Invoice: <?= $dashboard['invoice']['pending']; ?>
                                </span>
                            </li>
                        </ul>
                        <div id="donutChart" class="flex-grow-1 apexcharts-tooltip-z-none title-style circle-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection(); ?>


<?= $this->section('script'); ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    var options = {
        chart: {
            type: 'donut',
            height: 250
        },
        labels: ['Not Started', 'In Progress', 'Pending Invoice'],
        series :[<?php echo $pending_books['NotStarted'];?>,<?php echo $pending_books['PendingCount'];?>,<?php echo $dashboard['invoice']['pending'];?>],
       
        colors: ['#28a745', '#ffc107', '#0d6efd'],
        legend: {
            show: false
        },
        dataLabels: {
            enabled: false
        },
        plotOptions: {
            pie: {
                startAngle: -90,
                endAngle: 90,
                offsetY: 10
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#donutChart"), options);
    chart.render();
});
</script>
<?= $this->endSection(); ?>
