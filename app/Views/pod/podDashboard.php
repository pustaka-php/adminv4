<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?> 
<div class="row gy-4 mb-24">
    <!-- ======================= First Row Cards Start =================== -->
    <div class="col-xxl-12">
        <div class="row gy-4 align-items-stretch">
            
            <!-- Card 1 -->
            <div class="col-xxl-3 col-md-6">
                <a href="<?php echo base_url().'pod/publisherdashboard' ?>" class="d-block text-decoration-none">
                    <div class="radius-8 h-100 text-center p-20 bg-danger-100">
                        <div class="card-body d-flex flex-column justify-content-between p-0">
                            <div class="d-flex align-items-center gap-2 mb-12">
                                <span class="w-48-px h-48-px bg-base text-danger text-2xl d-flex justify-content-center align-items-center rounded-circle h6">
                                    <i class="ri-user-3-fill"></i>
                                </span>
                                <div>
                                    <span class="fw-medium text-secondary-light text-lg">POD Publisher</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-8">
                                <h5 class="fw-semibold mb-0"><?php echo $dashboard['publisher']['total']?></h5>
                                <div class="text-start mt-2">
                                    <p class="mb-1 text-sm">
                                        <strong>Active:</strong> 
                                        <span class="text-white px-1 rounded-2 fw-medium bg-info-main text-sm">
                                            <?php echo $dashboard['publisher']['active']?>
                                        </span>
                                    </p>
                                    <p class="mb-0 text-sm">
                                        <strong>Inactive:</strong> 
                                        <span class="text-white px-1 rounded-2 fw-medium bg-warning-main text-sm">
                                            <?php echo $dashboard['publisher']['inactive']?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>


            <!-- Card 2 -->
            <div class="col-xxl-3 col-md-6">
                <div class="radius-8 h-100 text-center p-20 bg-info-focus">
                    <div class="card-body d-flex flex-column justify-content-between p-0">
                        <div class="d-flex align-items-center gap-2 mb-12">
                            <span class="w-48-px h-48-px bg-base text-info text-2xl d-flex justify-content-center align-items-center rounded-circle h6">
                                <i class="ri-shopping-cart-2-fill"></i>
                            </span>
                            <div>
                                <span class="fw-medium text-secondary-light text-lg">POD Orders</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-8">
                            <h5 class="fw-semibold mb-0"><?php echo $dashboard['orders']['total']?></h5>
                            <div class="text-start mt-2">
                                <p class="mb-1 text-sm"><strong>Completed:</strong> <span class="text-white px-1 rounded-2 fw-medium bg-info-main text-sm"><?php echo $dashboard['orders']['completed']?></span></p>
                                <p class="mb-0 text-sm"><strong>Pending:</strong> <span class="text-white px-1 rounded-2 fw-medium bg-warning-main text-sm"><?php echo $dashboard['orders']['pending']?></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-xxl-3 col-md-6">
                <div class="radius-8 h-100 text-center p-20 bg-success-100">
                    <div class="card-body d-flex flex-column justify-content-between p-0">
                        <div class="d-flex align-items-center gap-2 mb-12">
                            <span class="w-48-px h-48-px bg-base text-success text-2xl d-flex justify-content-center align-items-center rounded-circle h6">
                                <i class="ri-file-list-3-fill"></i>
                            </span>
                            <div>
                                <center><span class="fw-medium text-secondary-light text-lg">POD Invoice</span></center>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-8">
                            <h5 class="fw-semibold mb-0"><?php echo $dashboard['invoice']['total']?></h5>
                            <div class="text-start mt-2">
                                <p class="mb-1 text-sm"><strong>Completed:</strong> <span class="text-white px-1 rounded-2 fw-medium bg-info-main text-sm"><?php echo $dashboard['invoice']['completed']?></span></p>
                                <p class="mb-0 text-sm"><strong>Pending:</strong> <span class="text-white px-1 rounded-2 fw-medium bg-warning-main text-sm"><?php echo $dashboard['invoice']['pending']?></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-xxl-3 col-md-6">
                <div class="radius-8 h-100 text-center p-20 bg-purple-light">
                    <div class="card-body d-flex flex-column justify-content-between p-0">
                        <div class="d-flex align-items-center gap-2 mb-12">
                            <span class="w-48-px h-48-px bg-base text-purple text-2xl d-flex justify-content-center align-items-center rounded-circle h6">
                                <i class="ri-book-open-fill"></i>
                            </span>
                            <div>
                                <span class="fw-medium text-lg">End To End POD</span>                    
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-8">
                            <h5 class="fw-semibold mb-0"><?php echo $dashboard['pod']['total']?></h5>
                            <div class="text-start mt-2">
                                <p class="mb-1 text-sm"><strong>Completed:</strong> <span class="text-white px-1 rounded-2 fw-medium bg-info-main text-sm"><?php echo $dashboard['pod']['completed']?></span></p>
                                <p class="mb-0 text-sm"><strong>Pending:</strong> <span class="text-white px-1 rounded-2 fw-medium bg-warning-main text-sm"><?php echo $dashboard['pod']['pending']?></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<?= $this->endSection(); ?>
