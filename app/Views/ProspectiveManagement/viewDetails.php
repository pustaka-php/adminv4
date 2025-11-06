<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">

    <!-- Title + Back Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <iconify-icon icon="mdi:account-details-outline" class="text-primary me-2" style="font-size: 1.8rem;"></iconify-icon>
            <h4 class="fw-bold text-primary mb-0">
                Prospect Details - <?= esc($prospect['name']); ?>
            </h4>
        </div>

       <a href="<?= base_url('prospectivemanagement/dashboard'); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fa fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <!-- Status Badge -->
    <div class="row mb-4">
        <div class="col">
            <div class="text-end">
                <?php
                $status_class = '';
                $status_text = '';
                if ($prospect['prospectors_status'] == 1) {
                    $status_class = 'bg-success';
                    $status_text = 'Closed';
                } elseif ($prospect['prospectors_status'] == 0) {
                    $status_class = 'bg-warning text-dark';
                    $status_text = 'In Progress';
                } else {
                    $status_class = 'bg-secondary';
                    $status_text = 'Denied';
                }
                ?>
                <span class="badge <?= $status_class; ?> fs-6 px-5 py-3">
                    <?= $status_text; ?>
                </span>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Side - Summary & Payment Info -->
        <div class="col-lg-4">
            <!-- Prospect Summary -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header py-3">
                    <div class="d-flex align-items-center">
                        <iconify-icon icon="mdi:account-box-outline" class="text-primary me-2"></iconify-icon>
                        <h6 class="mb-0 fw-semibold">
                            Prospect Summary
                        </h6>
                    </div>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5 small">Source</dt>
                        <dd class="col-sm-7 mb-2 fw-medium"><?= esc($prospect['source_of_reference']); ?></dd>

                        <dt class="col-sm-5 small">Email Sent</dt>
                        <dd class="col-sm-7 mb-2">
                            <?= $prospect['email_sent_flag'] ? 
                                '<span class="badge bg-success">Yes</span>' : 
                                '<span class="badge bg-secondary">No</span>'; ?>
                        </dd>

                        <dt class="col-sm-5 small">Initial Call</dt>
                        <dd class="col-sm-7 mb-2">
                            <?= $prospect['initial_call_flag'] ? 
                                '<span class="badge bg-success">Yes</span>' : 
                                '<span class="badge bg-secondary">No</span>'; ?>
                        </dd>

                        <dt class="col-sm-5 small">Recommended Plan</dt>
                        <dd class="col-sm-7 mb-2 fw-medium"><?= esc($prospect['recommended_plan']); ?></dd>

                        <dt class="col-sm-5 small">Created</dt>
                        <dd class="col-sm-7 mb-2 fw-medium"><?= date('d-m-y', strtotime($prospect['created_at'])); ?></dd>

                        <dt class="col-sm-5 small">Last Updated</dt>
                        <dd class="col-sm-7 mb-0 fw-medium"><?= date('d-m-y', strtotime($prospect['last_update_date'])); ?></dd>
                    </dl>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="card border-0 shadow-sm">
                <div class="card-header py-3">
                    <div class="d-flex align-items-center">
                        <iconify-icon icon="mdi:credit-card-outline" class="text-primary me-2"></iconify-icon>
                        <h6 class="mb-0 fw-semibold">
                            Payment Information
                        </h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small">Status</span>
                            <span class="badge bg-primary"><?= esc($prospect['payment_status']); ?></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small">Amount</span>
                            <span class="fw-bold text-success">
                                <?= indian_format((float)$prospect['payment_amount'], 2, '.', ','); ?>
                            </span>

                        </div>
                    </div>
                    <div class="mb-0">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small">Payment Date</span>
                            <span class="fw-semibold">
                                <?= $prospect['payment_date'] ? date('d-m-y', strtotime($prospect['payment_date'])) : '<span class="text-muted">N/A</span>'; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Activity & Remarks -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header py-3">
                    <div class="d-flex align-items-center">
                        <iconify-icon icon="mdi:comment-text-outline" class="text-primary me-2"></iconify-icon>
                        <h6 class="mb-0 fw-semibold">Activity & Remarks</h65>
                    </div>
                </div>

                <div class="card-body p-0">
                    <!-- 🔹 REMARKS TABLE -->
                    <?php 
                    $remarksList = array_filter($remarks, fn($r) => !empty($r['remarks']));
                    ?>
                    <?php if (!empty($remarksList)): ?>
                        
                        <div class="table-responsive px-4">
                            <table class="zero-config table table-hover mt-4">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%" class="text-center">#</th>
                                        <th>Remarks</th>
                                        <th width="20%" class="text-center">Date</th>
                                        <th width="20%" class="text-center">Updated By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach ($remarksList as $r): ?>
                                    <tr>
                                        <td class="text-center fw-medium"><?= $i++; ?></td>
                                        <td><?= esc($r['remarks']); ?></td>
                                        <td class="text-center"><?= date('d-m-y', strtotime($r['create_date'])); ?></td>
                                        <td class="text-center fw-medium"><?= esc($r['created_by']); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <hr class="my-4">
                    <?php endif; ?>

                    <!-- 🔹 PAYMENT DESCRIPTION TABLE -->
                    <?php 
                    $paymentList = array_filter($remarks, fn($r) => !empty($r['payment_description']));
                    ?>
                    <?php if (!empty($paymentList)): ?>
                        <div class="px-4 pt-2">
                            <div class="d-flex align-items-center mb-3">
                                <iconify-icon icon="mdi:credit-card-outline" class="me-2 text-success fs-5"></iconify-icon>
                                <h6 class="fw-semibold text-success mb-0">
                                    Payment Description History
                                </h6>
                            </div>
                        </div>

                        <div class="table-responsive px-4 pb-4">
                            <table class="zero-config table table-hover mt-4">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%" class="text-center">#</th>
                                        <th>Payment Description</th>
                                        <th width="20%" class="text-center">Date</th>
                                        <th width="20%" class="text-center">Updated By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach ($paymentList as $p): ?>
                                    <tr>
                                        <td class="text-center fw-medium"><?= $i++; ?></td>
                                        <td><?= esc($p['payment_description']); ?></td>
                                        <td class="text-center"><?= date('d-m-y', strtotime($p['des_date'])); ?></td>
                                        <td class="text-center fw-medium"><?= esc($p['created_by']); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                    <!-- 🔹 EMPTY MESSAGE -->
                    <?php if (empty($remarksList) && empty($paymentList)): ?>
                        <div class="text-center py-5">
                            <iconify-icon icon="mdi:inbox-outline" class="display-4 mb-3"></iconify-icon>
                            <p class="mb-0">No activity recorded yet</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>