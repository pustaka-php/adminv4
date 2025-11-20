<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<?php
// Helper function for safe date formatting
function formatDate($date, $format = 'd-m-Y') {
    if (empty($date) || $date === '0000-00-00' || $date === '0000-00-00 00:00:00') {
        return '<span class="text-muted">N/A</span>';
    }
    return date($format, strtotime($date));
}
?>

<div class="container py-4">

    <!-- Title + Back Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <iconify-icon icon="mdi:book-open-page-variant-outline" class="text-primary me-2" style="font-size: 1.8rem;"></iconify-icon>
            <h4 class="fw-bold text-primary mb-0">
                Prospector Book Details - <?= esc($prospect['name']); ?>
            </h4>
        </div>

        <a href="<?= base_url('prospectivemanagement/dashboard'); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fa fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <!-- Prospector Info Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-gradient-primary py-3 d-flex align-items-center">
            <iconify-icon icon="mdi:account-outline" class="me-2 fs-5"></iconify-icon>
            <h6 class="mb-0 fw-semibold">Prospector Information</h6>
        </div>

        <div class="card-body">
            <div class="row gy-3">
                <div class="col-md-3"><strong>ID:</strong> <?= esc($prospect['id']); ?></div>
                <div class="col-md-3"><strong>Name:</strong> <?= esc($prospect['name']); ?></div>
                <div class="col-md-3"><strong>Phone:</strong> <?= esc($prospect['phone']); ?></div>
                <div class="col-md-3"><strong>Email:</strong> <?= esc($prospect['email']); ?></div>
                <div class="col-md-3"><strong>Source:</strong> <?= esc($prospect['source_of_reference']); ?></div>
                <div class="col-md-3">
                    <strong>Author Status:</strong>
                    <span class="<?= $prospect['author_status'] == 'Active' ? 'text-success' : 'text-danger'; ?>">
                        <?= esc($prospect['author_status']); ?>
                    </span>
                </div>
                <div class="col-md-3"><strong>Email Sent Date:</strong> <?= formatDate($prospect['email_sent_date'], 'd-m-Y'); ?></div>
                <div class="col-md-3"><strong>Initial Call Date:</strong> <?= formatDate($prospect['initial_call_date'], 'd-m-Y'); ?></div>
                <div class="col-md-3"><strong>Created At:</strong> <?= formatDate($prospect['created_at'], 'd-m-Y'); ?></div>
            </div>
        </div>
    </div>

    <!-- Book Payment Details -->
    <?php
        $paid = array_filter($plans, fn($p) => strtolower($p['payment_status']) === 'paid');
        $partial = array_filter($plans, fn($p) => strtolower($p['payment_status']) === 'partial');
    ?>

    <?php if (empty($paid) && empty($partial)): ?>
        <div class="alert alert-secondary text-center">
            No Paid or Partial Titles found for this prospect.
        </div>
    <?php else: ?>

        <!-- Paid Titles -->
        <?php if (!empty($paid)): ?>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header py-3 bg-success bg-opacity-10">
                <div class="d-flex align-items-center">
                    <iconify-icon icon="mdi:cash-check" class="text-success me-2 fs-5"></iconify-icon>
                    <h6 class="fw-semibold text-success mb-0">Fully Paid Titles</h6>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Plan Name</th>
                                <th>Amount</th>
                                <th>Payment Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($paid as $p): ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= esc($p['title']); ?></td>
                                <td><?= esc($p['plan_name']); ?></td>
                                <td>₹<?= esc(number_format($p['payment_amount'], 2)); ?></td>
                                <td><?= formatDate($p['payment_date'], 'd-m-Y'); ?></td>
                                <td class="text-center">
                                <a href="<?= base_url('prospectivemanagement/viewbook/' . $p['prospector_id'] . '/' . $p['id']); ?>" 
                                    class="btn btn-sm btn-outline-primary me-2">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                <a href="<?= base_url('prospectivemanagement/editbook/' . $p['prospector_id'] . '/' . $p['id']); ?>" 
                                class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>

                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Partial Titles -->
        <?php if (!empty($partial)): ?>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header py-3 bg-warning bg-opacity-10">
                <div class="d-flex align-items-center">
                    <iconify-icon icon="mdi:cash-minus" class="text-warning me-2 fs-5"></iconify-icon>
                    <h6 class="fw-semibold text-warning mb-0">Partial Payment Titles</h6>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Plan Name</th>
                                <th>Amount</th>
                                <th>Payment Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($partial as $p): ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= esc($p['title']); ?></td>
                                <td><?= esc($p['plan_name']); ?></td>
                                <td>₹<?= esc(number_format($p['payment_amount'], 2)); ?></td>
                                <td><?= formatDate($p['payment_date'], 'd-m-Y'); ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('prospectivemanagement/viewbook/' . $p['prospector_id'] . '/' . $p['id']); ?>" 
   class="btn btn-sm btn-outline-primary me-2">
    <i class="bi bi-eye"></i> View
</a>
                                  <a href="<?= base_url('prospectivemanagement/editbook/' . $p['prospector_id'] . '/' . $p['id']); ?>" 
   class="btn btn-sm btn-outline-warning">
    <i class="bi bi-pencil"></i> Edit
</a>

                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>

    <?php endif; ?>

    <!-- ✅ General Remarks -->
    <?php if (!empty($generalRemarks)): ?>
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header py-3 bg-info bg-opacity-10">
            <div class="d-flex align-items-center">
                <iconify-icon icon="mdi:note-text-outline" class="text-info me-2 fs-5"></iconify-icon>
                <h6 class="fw-semibold text-info mb-0">General Remarks</h6>
            </div>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <?php foreach ($generalRemarks as $r): ?>
                    <li class="list-group-item">
                        <?php if (!empty($r['payment_description'])): ?>
                            <div><strong>Payment Description:</strong> <?= esc($r['payment_description']); ?></div>
                        <?php endif; ?>

                        <?php if (!empty($r['remarks'])): ?>
                            <div><strong>Remarks:</strong> <?= esc($r['remarks']); ?></div>
                        <?php endif; ?>

                        <small class="text-muted d-block mt-1">
                            By <?= esc($r['created_by'] ?? 'System'); ?> 
                            on <?= formatDate($r['create_date'], 'd-m-Y'); ?>
                        </small>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php endif; ?>

</div>

<?= $this->endSection(); ?>
