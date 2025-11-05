<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid py-4">

    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 rounded-2 p-2 me-2">
                        <iconify-icon icon="mdi:chart-box-outline" class="fs-5 text-primary"></iconify-icon>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Prospective Management</h6>
                    </div>
                </div>
                <div class="d-flex gap-3">
                    <a href="<?= base_url('prospectivemanagement/addprospect'); ?>" class="btn btn-info-600 radius-6 px-18 py-9">
                        Add Prospect
                    </a>
                    <a href="<?= base_url('prospectivemanagement/plandetails'); ?>" class="btn btn-success-600 radius-6 px-18 py-9">
                        Plan Details
                    </a>
                </div>
            </div>
        </div>
    </div><br>

    <!-- Status Overview Cards -->
    <div class="row mb-4">
        <!-- In Progress -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                                <iconify-icon icon="mdi:progress-clock" class="fs-3 text-primary"></iconify-icon>
                            </div>
                            <div>
                                <h6 class="mb-1">In Progress</h6>
                                <h6 class="fw-bold mb-0"><?= $prospectCounts['inProgressCount'] ?? 0; ?></h6>
                            </div>
                        </div>
                        <div class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                            Active
                        </div>
                    </div>
                    <div class="d-flex justify-content-between text-sm">
                        <span>Today: <strong class="text-success"><?= $prospectCounts['todayInProgress'] ?? 0; ?></strong></span>
                        <span>This Month: <strong class="text-info"><?= $prospectCounts['monthInProgress'] ?? 0; ?></strong></span>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="<?= base_url('prospectivemanagement/inprogress'); ?>" class="btn btn-outline-primary btn-sm w-50 d-flex align-items-center justify-content-center">
                        <iconify-icon icon="mdi:arrow-right" class="me-1"></iconify-icon>
                        View Details
                    </a>
                </div>
            </div>
        </div>

        <!-- Closed -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 rounded-3 p-3 me-3">
                                <iconify-icon icon="mdi:check-circle-outline" class="fs-3 text-success"></iconify-icon>
                            </div>
                            <div>
                                <h6 class="mb-1">Closed</h6>
                                <h6 class="fw-bold mb-0"><?= $prospectCounts['closedCount'] ?? 0; ?></h6>
                            </div>
                        </div>
                        <div class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                            Completed
                        </div>
                    </div>
                    <div class="d-flex justify-content-between text-sm">
                        <span>Today: <strong class="text-success"><?= $prospectCounts['todayClosed'] ?? 0; ?></strong></span>
                        <span>This Month: <strong class="text-info"><?= $prospectCounts['monthClosed'] ?? 0; ?></strong></span>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="<?= base_url('prospectivemanagement/closed'); ?>" class="btn btn-outline-success btn-sm w-50 d-flex align-items-center justify-content-center">
                        <iconify-icon icon="mdi:arrow-right" class="me-1"></iconify-icon>
                        View Details
                    </a>
                </div>
            </div>
        </div>

        <!-- Denied -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-danger bg-opacity-10 rounded-3 p-3 me-3">
                                <iconify-icon icon="mdi:close-circle-outline" class="fs-3 text-danger"></iconify-icon>
                            </div>
                            <div>
                                <h6 class="mb-1">Denied</h6>
                                <h6 class="fw-bold mb-0"><?= $prospectCounts['deniedCount'] ?? 0; ?></h6>
                            </div>
                        </div>
                        <div class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">
                            Rejected
                        </div>
                    </div>
                    <div class="d-flex justify-content-between text-sm">
                        <span>Today: <strong class="text-success"><?= $prospectCounts['todayDenied'] ?? 0; ?></strong></span>
                        <span>This Month: <strong class="text-info"><?= $prospectCounts['monthDenied'] ?? 0; ?></strong></span>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="<?= base_url('prospectivemanagement/denied'); ?>" class="btn btn-outline-danger btn-sm w-50 d-flex align-items-center justify-content-center">
                        <iconify-icon icon="mdi:arrow-right" class="me-1"></iconify-icon>
                        View Details
                    </a>
                </div>
            </div>
        </div>
    </div><br>

    <!-- Plans and Payments Section -->
    <div class="row g-4">

        <!-- Plans Purchased -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header border-0 pb-0 pt-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning bg-opacity-10 rounded-3 p-2 me-3">
                                <iconify-icon icon="mdi:gift-outline" class="fs-4 text-warning"></iconify-icon>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Plans Purchased</h6>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <div>
                                Total: <strong><?= $planCounts['totalPlans'] ?? 0; ?></strong>
                            </div>
                            <a href="<?= base_url('prospectivemanagement/planssummary'); ?>" 
                            class="btn btn-sm btn-outline-primary d-flex align-items-center">
                                <iconify-icon icon="mdi:eye-outline" class="me-1"></iconify-icon> 
                                Details
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Main Plans -->
                    <div class="row g-3 mb-4">
                        <?php 
                            $mainPlans = [
                                ['name' => 'Silver', 'color' => 'secondary'],
                                ['name' => 'Gold', 'color' => 'warning'],
                                ['name' => 'Platinum', 'color' => 'info']
                            ];
                            foreach ($mainPlans as $plan): ?>
                            <div class="col-4">
                                <div class="card border bg-<?= $plan['color']; ?> bg-opacity-10 h-100 text-center p-3">
                                    <div class="fw-semibold text-<?= $plan['color']; ?> mb-2"><?= $plan['name']; ?></div>
                                    <div class="fw-bold fs-4"><?= $planCounts[$plan['name']] ?? 0; ?></div>
                                    
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Other Plans -->
                    <div class="row g-3">
                        <?php 
                            $otherPlans = [
                                ['name' => 'Rhodium', 'color' => 'dark'],
                                ['name' => 'Silver++', 'color' => 'secondary'],
                                ['name' => 'Pearl', 'color' => 'light'],
                                ['name' => 'Sapphire', 'color' => 'primary']
                            ];
                            foreach ($otherPlans as $plan): ?>
                            <div class="col-6 col-md-3">
                                <div class="card border bg-light h-100 text-center p-3">
                                    <div class="fw-semibold mb-1 small"><?= $plan['name']; ?></div>
                                    <div class="fw-bold fs-5 text-secondary"><?= $planCounts[$plan['name']] ?? 0; ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payments Summary -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header border-0 pb-0 pt-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="bg-info bg-opacity-10 rounded-3 p-2 me-3">
                                <iconify-icon icon="mdi:currency-inr" class="fs-4 text-info"></iconify-icon>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Payments Summary</h6>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="text-muted small">
                                Updated: <?= date('d-m-y'); ?>
                            </div>
                            <a href="<?= base_url('prospectivemanagement/paymentdetails'); ?>" 
                            class="btn btn-sm btn-outline-primary d-flex align-items-center">
                                <iconify-icon icon="mdi:eye-outline" class="me-1"></iconify-icon> 
                                Details
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Total Amount -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card bg-primary bg-opacity-10 border p-4">
                                <div class="text-center">
                                    <div class="mb-0">Total Revenue</div>
                                    <div class="fw-bold fs-2">₹<?= number_format($paymentSummary['totalRevenue'] ?? 0); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Status -->
                    <div class="row g-3">
                        <div class="col-4">
                            <div class="card border bg-success bg-opacity-10 h-100 text-center p-3">
                                <div class="fw-semibold text-success mb-2">Paid</div>
                                <div class="fw-bold fs-4">₹<?= number_format($paymentSummary['paidTotal'] ?? 0); ?></div>
                               
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card border bg-danger bg-opacity-10 h-100 text-center p-3">
                                <div class="fw-semibold text-danger mb-2">Pending</div>
                                <div class="fw-bold fs-4">₹<?= number_format($paymentSummary['pendingTotal'] ?? 0); ?></div>
                                
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card border bg-warning bg-opacity-10 h-100 text-center p-3">
                                <div class="fw-semibold text-warning mb-2">Partial</div>
                                <div class="fw-bold fs-4">₹<?= number_format($paymentSummary['partialTotal'] ?? 0); ?></div>
                               
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
<script>
    console.log("✅ Prospective Management Dashboard Loaded");
</script>
<?= $this->endSection(); ?>
