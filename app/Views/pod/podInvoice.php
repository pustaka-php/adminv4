<?= $this->extend('layout/layout1'); ?>


<?= $this->section('content'); ?> 
    <div class="row gy-4">
        <div class="col-xxl-8">
            <div class="row gy-4">
               

                <div class="col-12">
                    <!-- <h6 class="mb-16">Trending Bids</h6> -->
                    <div class="row gy-4">
                        <!-- Dashboard Widget Start -->
                        <div class="col-lg-4 col-sm-6">
                            <div class="card px-24 py-16 shadow-none radius-12 border h-100 bg-gradient-start-3">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                        <div class="d-flex align-items-center flex-wrap gap-16">
                                            <span class="mb-0 w-40-px h-40-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                                <iconify-icon icon="flowbite:users-group-solid" class="icon"></iconify-icon>
                                            </span>

                                            <div class="flex-grow-1">
                                                <h6 class="fw-semibold mb-0"><?php echo $invoice['pending']['pending_invoice']?></h6>
                                                <span class="fw-medium text-secondary-light text-md">Pending Invoice</span>
                                                <p class="text-sm mb-0 d-flex align-items-center flex-wrap gap-12 mt-12">
                                                    value : <span class="bg-success-focus px-6 py-2 rounded-2 fw-medium text-success-main text-sm d-flex align-items-center gap-8">
                                                        <?php echo '₹'.number_format($invoice['pending']['pending_total'],2)?>
                                                        <!-- <i class="ri-arrow-up-line"></i> -->
                                                    </span> 
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Dashboard Widget End -->

                        <!-- Dashboard Widget Start -->
                        <div class="col-lg-4 col-sm-6">
                            <div class="card px-24 py-16 shadow-none radius-12 border h-100 bg-gradient-start-5">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                        <div class="d-flex align-items-center flex-wrap gap-16">
                                            <span class="mb-0 w-40-px h-40-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                                <iconify-icon icon="flowbite:users-group-solid" class="icon"></iconify-icon>
                                            </span>

                                            <div class="flex-grow-1">
                                                <h6 class="fw-semibold mb-0"><?php echo $invoice['raised']['raised_invoice']?></h6>
                                                <span class="fw-medium text-secondary-light text-md">Raised Invoice</span>
                                                <p class="text-sm mb-0 d-flex align-items-center flex-wrap gap-12 mt-12">
                                                    value : <span class="bg-success-focus px-6 py-2 rounded-2 fw-medium text-success-main text-sm d-flex align-items-center gap-8">
                                                        <?php echo '₹'.number_format($invoice['raised']['raised_total'],2)?>
                                                        <!-- <i class="ri-arrow-down-line"></i> -->
                                                    </span> 
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Dashboard Widget End -->

                        <!-- Dashboard Widget Start -->
                        <div class="col-lg-4 col-sm-6">
                            <div class="card px-24 py-16 shadow-none radius-12 border h-100 bg-gradient-start-2">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                        <div class="d-flex align-items-center flex-wrap gap-16">
                                            <span class="mb-0 w-40-px h-40-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                                <iconify-icon icon="flowbite:users-group-solid" class="icon"></iconify-icon>
                                            </span>

                                            <div class="flex-grow-1">
                                                <h6 class="fw-semibold mb-0"><?php echo $invoice['paid']['paid_invoice']?></h6>
                                                <span class="fw-medium text-secondary-light text-md">Paid Invoices</span>
                                                <p class="text-sm mb-0 d-flex align-items-center flex-wrap gap-12 mt-12">
                                                   value :  <span class="bg-success-focus px-6 py-2 rounded-2 fw-medium text-success-main text-sm d-flex align-items-center gap-8">
                                                         <?php echo '₹'.number_format($invoice['paid']['paid_total'],2)?>
                                                    </span> 
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Dashboard Widget End -->
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
                					<th style="border: 1px solid grey">Publisher Name</th>
                					<th style="border: 1px solid grey">Total Invoice</th>
                					<th style="border: 1px solid grey">Paid</th>
                                    <th style="border: 1px solid grey">Pending</th>
            					</tr>
            				</thead>
                            <?php  foreach ($publisher as $invoice_reports_details)
							{ ?>
                				<tr>
                    				<td style="border: 1px solid grey"><?php echo  $invoice_reports_details['publisher_name']; ?></td>
									<td style="border: 1px solid grey"><p><?php echo $invoice_reports_details['total_invoice_amount'];?></td></p> 
                            		<td style="border: 1px solid grey"><p><?php echo  $invoice_reports_details['paid_amount'];?></td></p>
                                    <td style="border: 1px solid grey"><p><?php echo $invoice_reports_details['pending_amount'];?></td></p>
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
                        <?php
                        $total = $summary['cgst'] + $summary['igst']+ $summary['sgst'];
                        ?>
                        <span class="text-secondary-light"> <?php echo '₹'.number_format($total,2)."  (cgst+igst+sgst)" ?></span>
                        <!-- 7.2k Social visitors -->
                    </div>

                    <div class="d-flex flex-column gap-32 mt-32">
                        <div class="d-flex align-items-center justify-content-between gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="w-40-px h-40-px rounded-circle d-flex justify-content-center align-items-center bg-lilac-100 flex-shrink-0">
                                    <img src="<?= base_url('assets/images/home-nine/socials1.png') ?>" alt="" class="">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="text-md mb-0 fw-semibold"> Invoice </h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-8">
                                <span class="text-secondary-light text-md fw-medium"><?php echo '₹'.$summary['TotalInvoice']?></span>
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
                                <span class="text-secondary-light text-md fw-medium"><?php echo '₹'.$summary['TotalPaid']?></span>
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
                                <span class="text-secondary-light text-md fw-medium"><?php echo '₹'.$summary['TotalPending']?></span>
                                <!-- <span class="text-success-600 text-md fw-medium">0.3%</span> -->
                            </div>
                        </div>
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
                                <span class="text-secondary-light text-md fw-medium"><?php echo '₹'.number_format($summary['cgst'],2)?></span>
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
                                <span class="text-secondary-light text-md fw-medium"><?php echo '₹'.number_format($summary['igst'],2)?></span>
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
                                <span class="text-secondary-light text-md fw-medium"><?php echo '₹'.number_format($summary['sgst'],2)?></span>
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
                                        <th><div class="th-content">Total Invoice</div></th>
                                        <th><div class="th-content">Paid</div></th>
                                        <th><div class="th-content">Pending</div></th>
                                
                                    </tr>
                                </thead>
                                <tbody >
        
							<?php  
                                    $i=1;
                                    foreach ($month as $monthly_invoice) {
                                    ?>
                				<tr>
                                    <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                                    <td style="border: 1px solid grey"><?php echo $monthly_invoice['month_name']; ?></td>
									<td style="border: 1px solid grey"><p>₹ <?php echo $monthly_invoice['monthly_total_amount'];?></td></p> 
                            		<td style="border: 1px solid grey"><p>₹ <?php echo $monthly_invoice['monthly_paid_amount'];?></td></p>
                                    <td style="border: 1px solid grey"><p>₹<?php echo $monthly_invoice['monthly_pending_amount'];?></td></p>
                				</tr>
                                     
                			<?php 
                                }
                            ?>
            				</tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
         </div>


    </div>
<?= $this->endSection(); ?>

