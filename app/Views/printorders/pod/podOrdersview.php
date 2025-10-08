<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
    <script src="<?= base_url('assets/js/homeFourChart.js') ?>"></script>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?> 

    
    <div class="row gy-4 mt-4">

    <!-- Crypto Home Widgets Start -->
    <div class="col-xxl-7">
        <div class="row gy-4">
            <div class="col-xxl-12">
                <div class="card h-100 radius-8 border-0">
                    <div class="card-body p-24">
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between mb-20">
                            <h6 class="mb-2 fw-bold text-lg">Quotation Details</h6>
                        </div>

                        <div class="table-responsive scroll-sm">
                            <table class="table bordered-table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">No.Of.Pages</th>
                                        <th scope="col">Price </th>
                                        <!-- <th scope="col" class="text-center">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td><span class="text-success-main">1</span></td>
                                        <td>>=50 to <=75</td>
                                        <td>0.5</td> 
                                    </tr>
                                    <tr>
                                        <td><span class="text-success-main">2</span></td>
                                        <td>>=76 to <=100</td>
                                        <td>0.45</td>
                                    </tr>
                                    <tr>
                                        <td><span class="text-success-main">3</span></td>
                                        <td>>=101 to <=150</td>
                                        <td>0.41</td>
                                    </tr>
                                    <tr>
                                        <td><span class="text-success-main">4</span></td>
                                        <td> >150</td>
                                        <td>0.38</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Crypto Home Widgets End -->

    <div class="col-xxl-5">
        <div class="row gy-4">
            <div class="col-xxl-12 col-lg-6">
                <div class="card h-100 radius-8 border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between mb-20">
                            <h6 class="mb-2 fw-bold text-lg">Orders</h6>
                            <a  href="" class="btn btn-outline-primary d-inline-flex align-items-center gap-2 text-sm btn-sm px-8 py-6">
                                <iconify-icon icon="ph:plus-circle" class="icon text-xl"></iconify-icon> Create Order
                            </a>
                        </div>

                        <div>
                            <div class="card-slider">
                                <div class="p-20 h-240-px radius-8 overflow-hidden position-relative z-1">
                                  
               
                                </div>
                                <div class="p-20 h-240-px radius-8 overflow-hidden position-relative z-1">
                                    <!-- <p class="mb-1 text-sm"><strong>Completed:</strong> <span class="text-white px-1 rounded-2 fw-medium bg-info-main text-sm"><?= $dashboard['orders']['completed'] ?></span></p> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- ======================= 3rd Row Start =================== -->
        <?= $this->include('printorders/pod/podInprogressOrders') ?>
</div>

<?= $this->endSection(); ?>