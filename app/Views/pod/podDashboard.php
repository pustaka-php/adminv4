<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?> 
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<div class="row gy-4 mb-24">
    <!-- ======================= First Row Cards Start =================== -->
    <div class="col-xxl-12">
        <div class="row gy-4 align-items-stretch">
            
            <!-- Card 1 -->
            <div class="col-xxl-3 col-md-6">
                <a href="<?= base_url().'pod/publisherdashboard' ?>" class="d-block text-decoration-none">
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
                                <h5 class="fw-semibold mb-0"><?= $dashboard['publisher']['total'] ?></h5>
                                <div class="text-start mt-2">
                                    <p class="mb-1 text-sm">
                                        <strong>Active:</strong> 
                                        <span class="text-white px-1 rounded-2 fw-medium bg-info-main text-sm">
                                            <?= $dashboard['publisher']['active'] ?>
                                        </span>
                                    </p>
                                    <p class="mb-0 text-sm">
                                        <strong>Inactive:</strong> 
                                        <span class="text-white px-1 rounded-2 fw-medium bg-warning-main text-sm">
                                            <?= $dashboard['publisher']['inactive'] ?>
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
               <!-- <a href="<?= base_url().'pod/publisherdashboard' ?>" class="d-block text-decoration-none"> -->
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
                                <h5 class="fw-semibold mb-0"><?= $dashboard['orders']['total'] ?></h5>
                                <div class="text-start mt-2">
                                    <p class="mb-1 text-sm"><strong>Completed:</strong> <span class="text-white px-1 rounded-2 fw-medium bg-info-main text-sm"><?= $dashboard['orders']['completed'] ?></span></p>
                                    <p class="mb-0 text-sm"><strong>Pending:</strong> <span class="text-white px-1 rounded-2 fw-medium bg-warning-main text-sm"><?= $dashboard['orders']['pending'] ?></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- </a> -->
            </div>

            <!-- Card 3 -->
            <div class="col-xxl-3 col-md-6">
                <a href="<?= base_url().'pod/invoice' ?>" class="d-block text-decoration-none">
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
                                <h5 class="fw-semibold mb-0"><?= $dashboard['invoice']['total'] ?></h5>
                                <div class="text-start mt-2">
                                    <p class="mb-1 text-sm"><strong>Completed:</strong> <span class="text-white px-1 rounded-2 fw-medium bg-info-main text-sm"><?= $dashboard['invoice']['completed'] ?></span></p>
                                    <p class="mb-0 text-sm"><strong>Pending:</strong> <span class="text-white px-1 rounded-2 fw-medium bg-warning-main text-sm"><?= $dashboard['invoice']['pending'] ?></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card 4 -->
            <div class="col-xxl-3 col-md-6">
                <a href="<?= base_url().'pod/endtoendpod' ?>" class="d-block text-decoration-none">
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
                                <h5 class="fw-semibold mb-0"><?= $dashboard['pod']['total'] ?></h5>
                                <div class="text-start mt-2">
                                    <p class="mb-1 text-sm"><strong>Completed:</strong> <span class="text-white px-1 rounded-2 fw-medium bg-info-main text-sm"><?= $dashboard['pod']['completed'] ?></span></p>
                                    <p class="mb-0 text-sm"><strong>Pending:</strong> <span class="text-white px-1 rounded-2 fw-medium bg-warning-main text-sm"><?= $dashboard['pod']['pending'] ?></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- ======================= Second Row Start =================== -->
    <div class="row">              
        <!-- Earning Statistic -->
        <div class="col-xxl-12 col-sm-12 mb-3">
        <div class="card h-100 radius-8 border-0 shadow-sm">
            <div class="card-body p-24">
                <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between mb-3">
                    <div>
                        <h6 class="mb-1 fw-bold text-lg">Orders Status</h6>
                        <!-- <span class="text-sm fw-medium text-secondary-light">Yearly earning overview</span> -->
                    </div>
                </div>

                <!-- Status Table -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="border: 1px solid grey">Start</th>
                                <th style="border: 1px solid grey">Files Ready</th>
                                <th style="border: 1px solid grey">Cover</th>
                                <th style="border: 1px solid grey">Content</th>
                                <th style="border: 1px solid grey">Laminate</th>
                                <th style="border: 1px solid grey">Binding</th>
                                <th style="border: 1px solid grey">Final Cut</th>
                                <th style="border: 1px solid grey">QC</th>
                                <th style="border: 1px solid grey">Invoice</th>
                                <th style="border: 1px solid grey">Packing</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <?php
                                $copy=$pending_books['cover_copy'];
                                $page=$pending_books['content_page'];
                                $a3_sheets = ceil($page/8);
                                $num_bundles=ceil($a3_sheets/1000);?>  
                            <td style="border: 1px solid grey"><span class="badge bg-success"><?php echo $pending_books['start_flag_cnt'];?></span></td>
                            <td style="border: 1px solid grey"><span class="badge bg-success"><?php echo $pending_books['files_ready_flag_cnt'];?></span></td>
                            <td style="border: 1px solid grey"><span class="badge bg-warning"><?php echo $pending_books['cover_flag_cnt']." / ".number_format($copy,0)?></span></td>
                            <td style="border: 1px solid grey"><span class="badge bg-secondary"><?php echo $pending_books['content_flag_cnt']." / ". number_format($page,0)."/ ".number_format($a3_sheets,0)."/ ".number_format($num_bundles,0);?>  </span></td>
                            <td style="border: 1px solid grey"><span class="badge bg-secondary"><?php echo $pending_books['lamination_flag_cnt'];?></span></td>
                            <td style="border: 1px solid grey"><span class="badge bg-secondary"><?php echo $pending_books['binding_flag_cnt'];?></span></td>
                            <td style="border: 1px solid grey"><span class="badge bg-secondary"><?php echo $pending_books['finalcut_flag_cnt'];?></span></td>
                            <td style="border: 1px solid grey"><span class="badge bg-secondary"><?php echo $pending_books['qc_flag_cnt'];?></span></td>
                            <td style="border: 1px solid grey"><span class="badge bg-secondary"><?php echo $pending_books['invoice_flag_cnt'];?>  </span></td>
                            <td style="border: 1px solid grey"><span class="badge bg-secondary"><?php echo $pending_books['packing_flag_cnt'];?></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br>
                <span class="text-sm fw-medium text-secondary-light">Content: Orders / Pages / A3 sheets / Bundles</span>
            </div>
        </div>
    </div>
</div>
<!-- ======================= 3rd Row Start =================== -->
 <?= $this->include('pod/podInprogressOrders') ?>
 <!-- ======================= 4rd Row Start =================== -->
  <?= $this->include('pod/podPendingInvoice') ?>


<?= $this->endSection(); ?>


