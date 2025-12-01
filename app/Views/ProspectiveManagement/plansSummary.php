<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-1">Prospect Plan Summary</h5>
    </div>

    <div class="mb-4">
        <div class="mb-4">
    <div class="d-flex flex-nowrap gap-2 overflow-auto pb-3">

        <?php if (!empty($plans)): $i = 1; ?>
            <?php foreach ($plans as $p): ?>

                <?php
                    $gradient_classes = [
                        "bg-primary bg-gradient bg-opacity-10 border border-primary border-opacity-25",
                        "bg-success bg-gradient bg-opacity-10 border border-success border-opacity-25", 
                        "bg-info bg-gradient bg-opacity-10 border border-info border-opacity-25",
                        "bg-warning bg-gradient bg-opacity-10 border border-warning border-opacity-25",
                        "bg-danger bg-gradient bg-opacity-10 border border-danger border-opacity-25",
                        "bg-secondary bg-gradient bg-opacity-10 border border-secondary border-opacity-25",
                        "bg-dark bg-gradient bg-opacity-10 border border-dark border-opacity-25"
                    ];

                    $gradient_class = $gradient_classes[$i % count($gradient_classes)];
                ?>

                <div class="card shadow-sm h-100 <?= $gradient_class ?> flex-shrink-0"
                     style="width: calc(14.2857% - 8px); min-width: 140px; border-radius: 12px;">

                    <div class="card-body p-2 d-flex flex-column">

                        <!-- UPDATED HEADING: Plan Name — Total -->
                      <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-bold mb-0 text-truncate small lh-sm">
                                <?= esc($p['plan_name'] ?? ''); ?>
                            </h6>
                            <span class="fw-bold ms-2 fs-4"><?= $p['total_titles'] ?? 0; ?></span>
                        </div>


                        <div class="mt-auto">

                            <div class="d-flex justify-content-between align-items-center mb-1 small">
                                <span>Today</span>
                                <strong><?= $p['today_count'] ?? 0; ?></strong>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-1 small">
                                <span>This Month</span>
                                <strong><?= $p['month_count'] ?? 0; ?></strong>
                            </div>

                            <div class="d-flex justify-content-between align-items-center small">
                                <span>Previous Month</span>
                                <strong><?= $p['prev_month_count'] ?? 0; ?></strong>
                            </div>

                        </div>
                    </div>
                </div>

                <?php $i++; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="card border-0 bg-body-tertiary w-100 text-center py-4">
                <div class="card-body">
                    <i class="bi bi-inbox display-6 text-body-secondary mb-2"></i>
                    <p class="text-body-secondary mb-0">No plans available</p>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h6 class="fw-semibold mb-0">Plan Details</h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Plan Name</th>
                            <th>Total Titles</th>
                            <th>Plan Amount (₹)</th>
                            <th>Paid Amount (₹)</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($plans)): $i = 1; foreach ($plans as $row): ?>
                        <tr>
                            <td class="ps-4 fw-semibold"><?= $i ?></td>

                            <td>
                                <span class="fw-medium"><?= esc($row['plan_name'] ?? ''); ?></span>
                            </td>

                            <td>
                                <span class="badge bg-body-secondary text-body-emphasis border">
                                    <?= $row['total_titles'] ?? 0; ?>
                                </span>
                            </td>

                            <td class="fw-semibold"><?= indian_format($row['plan_cost'] ?? 0, 2); ?></td>

                            <td class="fw-semibold text-success"><?= indian_format($row['total_paid'] ?? 0, 2); ?></td>

                            <td class="text-center">
                                <a href="<?= base_url('prospectivemanagement/viewplan/' . urlencode($row['plan_name'] ?? '')); ?>"
                                   class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    <i class="bi bi-eye me-1"></i> View Details
                                </a>
                            </td>
                        </tr>
                        <?php $i++; endforeach; else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-body-secondary py-4">
                                <i class="bi bi-table display-6 d-block mb-2"></i>
                                No plans found
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>
