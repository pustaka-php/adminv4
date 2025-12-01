<?= $this->extend('layout/layout1'); ?>


<?= $this->section('content'); ?> 
    <div class="row gy-4">
        <div class="col-xxl-8">
            <div class="row gy-4">
               

                <div class="col-12">
    <div class="row g-4">
        <?php 
        $cards = [
            'pending' => [
                'title' => 'Pending Invoices',
                'value' => $invoice['pending']['pending_invoice'],
                'total' => $invoice['pending']['pending_total'],
                'bg'    => 'bg-gradient-start-3',
                'link'  => base_url('pod/pendinginvoices') // <-- your link here
            ],
            'raised' => [
                'title' => 'Raised Invoices',
                'value' => $invoice['raised']['raised_invoice'],
                'total' => $invoice['raised']['raised_total'],
                'bg'    => 'bg-gradient-start-5',
                'link'  => base_url('pod/raisedinvoices')
            ],
            'paid' => [
                'title' => 'Paid Invoices',
                'value' => $invoice['paid']['paid_invoice'],
                'total' => $invoice['paid']['paid_total'],
                'bg'    => 'bg-gradient-start-2',
                'link'  => base_url('pod/paidinvoices')
            ]
        ];
        ?>

        <?php foreach ($cards as $c): ?>
        <div class="col-lg-4 col-sm-6">
            <a href="<?= $c['link'] ?>" class="text-decoration-none">
                <div class="card px-24 py-16 shadow-none radius-12 border h-100 <?= $c['bg'] ?>">
                    <div class="card-body d-flex align-items-center gap-16 p-0">
                       <span class="w-60 h-60 bg-primary-600 text-white d-flex justify-content-center align-items-center rounded-circle">
                            <iconify-icon icon="flowbite:users-group-solid" style="font-size:32px;"></iconify-icon>
                        </span>

                        <div class="flex-grow-1 ms-3">
                            <h6 class="fw-semibold mb-0"><?= $c['value'] ?></h6>
                            <span class="fw-medium text-secondary-light text-md"><?= $c['title'] ?></span>
                           
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>

      
                <!-- add any tables here  -->
                
			<div class="widget-two">
				<div class="widget-content">
					<div class="w-numeric-value">
						<div class="w-content">
							<!-- <span class="w-value">PoD Report</span> -->
						</div>
					</div>					
                    <div class="table-responsive">
						<table class="table zero-config">
            				<thead>
            					<tr>
                					<th>Publisher Name</th>
                					<th>Total Invoice</th>
                					<th>Paid</th>
                                    <th>Pending</th>
            					</tr>
            				</thead>
                            <?php foreach ($publisher as $invoice_reports_details) { ?>
                                <tr>
                                    <td>
                                        <?php if ($invoice_reports_details['pending_amount'] != 0) { ?>
                                            <a class="text-primary fw-bold"
                                            href="<?= base_url('pod/raisedinvoicedetails/' . $invoice_reports_details['publisher_id']) ?>">
                                                <?= $invoice_reports_details['publisher_name']; ?>
                                            </a>
                                        <?php } else { ?>
                                            <span class="" style="cursor: default;">
                                                <?= $invoice_reports_details['publisher_name']; ?>
                                            </span>
                                        <?php } ?>
                                    </td>

                                    <td><p><?= $invoice_reports_details['total_invoice_amount']; ?></p></td>
                                    <td><p><?= $invoice_reports_details['paid_amount']; ?></p></td>
                                    <td><p><?= $invoice_reports_details['pending_amount']; ?></p></td>
                                </tr>
                            <?php } ?>
        				</table>
                    </div>
                </div>
			</div>

            
            </div>
        </div>
        <div class="col-xxl-4">
            <!-- <div class="card h-100"> -->
                <div class="card-body p-24">
                    <div class="d-flex align-items-start flex-column gap-2">
                        <h6 class="mb-2 fw-bold text-lg">Total Summary</h6>
                     
                        <span class="text-secondary-light">
                            <?php echo indian_format($summary['overallInvoice'],2) ; ?>
                            (Raised Invoice + Pending Invoice)
                        </span>

                    </div>

                    <div class="d-flex flex-column gap-32 mt-32">
                        <div class="d-flex align-items-center justify-content-between gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="w-40-px h-40-px rounded-circle d-flex justify-content-center align-items-center bg-lilac-100 flex-shrink-0">
                                    <img src="<?= base_url('assets/images/home-nine/socials1.png') ?>" alt="" class="">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="text-md mb-0 fw-semibold">Raised Invoice </h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-8">
                                <span class="text-secondary-light text-md fw-medium"><?php echo ' '.indian_format($summary['TotalInvoice'],2)?></span>
                                <!-- <span class="text-success-600 text-md fw-medium">0.3%</span> -->
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="w-40-px h-40-px rounded-circle d-flex justify-content-center align-items-center bg-warning-100 flex-shrink-0">
                                    <img src="<?= base_url('assets/images/home-nine/socials2.png') ?>" alt="" class="">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="text-md mb-0 fw-semibold"> Paid </h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-8">
                                <span class="text-secondary-light text-md fw-medium"><?php echo ' '.indian_format($summary['TotalPaid'],2)?></span>
                                <!-- <span class="text-danger-600 text-md fw-medium">1.3%</span> -->
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="w-40-px h-40-px rounded-circle d-flex justify-content-center align-items-center bg-info-100 flex-shrink-0">
                                    <img src="<?= base_url('assets/images/home-nine/socials3.png') ?>" alt="" class="">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="text-md mb-0 fw-semibold"> Pending </h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-8">
                                <span class="text-secondary-light text-md fw-medium"><?php echo ' '.indian_format($summary['TotalPending'],2)?></span>
                                <!-- <span class="text-success-600 text-md fw-medium">0.3%</span> -->
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex align-items-center justify-content-between gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="w-40-px h-40-px rounded-circle d-flex justify-content-center align-items-center bg-success-100 flex-shrink-0">
                                    <img src="<?= base_url('assets/images/home-nine/socials4.png') ?>" alt="" class="">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="text-md mb-0 fw-semibold"> CGST  </h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-8">
                                <span class="text-secondary-light text-md fw-medium"><?php echo ' '.indian_format($summary['cgst'],2)?></span>
                                <!-- <span class="text-success-600 text-md fw-medium">0.3%</span> -->
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="w-40-px h-40-px rounded-circle d-flex justify-content-center align-items-center bg-danger-100 flex-shrink-0">
                                    <img src="<?= base_url('assets/images/home-nine/socials5.png') ?>" alt="" class="">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="text-md mb-0 fw-semibold"> IGST </h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-8">
                                <span class="text-secondary-light text-md fw-medium"><?php echo ' '.indian_format($summary['igst'],2)?></span>
                                <!-- <span class="text-success-600 text-md fw-medium">0.3%</span> -->
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="w-40-px h-40-px rounded-circle d-flex justify-content-center align-items-center bg-info-100 flex-shrink-0">
                                    <img src="<?= base_url('assets/images/home-nine/socials3.png') ?>" alt="" class="">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="text-md mb-0 fw-semibold"> SGST </h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-8">
                                <span class="text-secondary-light text-md fw-medium"><?php echo ' '.indian_format($summary['sgst'],2)?></span>
                                <!-- <span class="text-success-600 text-md fw-medium">0.3%</span> -->
                            </div>
                        </div>
                        <hr>
                         <div class="d-flex align-items-center justify-content-between gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="w-40-px h-40-px rounded-circle d-flex justify-content-center align-items-center bg-info-100 flex-shrink-0">
                                    <img src="<?= base_url('assets/images/home-nine/socials3.png') ?>" alt="" class="">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="text-md mb-0 fw-semibold"> Pending Invoice</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-8">
                                <span class="text-secondary-light text-md fw-medium"><?php echo ' '.indian_format($summary['pending'],2)?></span>
                                <!-- <span class="text-success-600 text-md fw-medium">0.3%</span> -->
                            </div>
                        </div>
                    </div>

                </div>
            <!-- </div> -->
        </div>

         <div class="d-flex flex-column gap-32 mt-32">
            <div class="col-xl-12 col-lg-10 col-md-10 col-sm-10 col-12 layout-spacing">
                <div class="widget-two">
                    <div class="widget-content">
                        <div class="w-numeric-value">
                            <div class="w-content">
                                <!-- <span class="w-value">Monthly Invoice</span> -->
                            </div>
                        </div>					
                        <div class="table-responsive">
                            <table class="table zero-config">
                                <thead>
                                    <tr>
                                        <th><div class="th-content">S.NO</div></th>
                                        <th><div class="th-content">Month</div></th>
                                        <th><div class="th-content">sales / Orders</div></th>
                                        <th><div class="th-content">Paid  / Orders</div></th>
                                        <th><div class="th-content">Pending  / Orders</div></th>
                                
                                    </tr>
                                </thead>
                                <tbody >
        
							<?php  
                            $i = 1;
                            foreach ($month as $monthly_invoice) {
                            ?>
                            <tr>
                                <td><?= $i++; ?></td>

                                <td>
                                    <?php if ($monthly_invoice['pending_invoice'] != 0) { ?>
                                        <a class="text-primary fw-bold"
                                        href="<?= base_url('pod/invoice/details/' . $monthly_invoice['month_order'] . '/pending') ?>">
                                            <?= $monthly_invoice['month_name']; ?>
                                        </a>
                                    <?php } else { ?>
                                        <span class="" style="cursor: default;">
                                            <?= $monthly_invoice['month_name']; ?>
                                        </span>
                                    <?php } ?>
                                </td>

                                <td>
                                    <p>
                                        <?= $monthly_invoice['monthly_total_amount']; ?> /
                                        <strong><?= $monthly_invoice['total_invoice']; ?></strong>
                                    </p>
                                </td>

                                <td>
                                    <p>
                                        <?= $monthly_invoice['monthly_paid_amount']; ?> /
                                        <strong><?= $monthly_invoice['paid_invoice']; ?></strong>
                                    </p>
                                </td>

                                <td>
                                    <p>
                                        <?= $monthly_invoice['monthly_pending_amount']; ?> /
                                        <strong><?= $monthly_invoice['pending_invoice']; ?></strong>
                                    </p>
                                </td>

                            </tr>
                            <?php } ?>

            				</tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
         </div>


    </div>
<?= $this->endSection(); ?>

