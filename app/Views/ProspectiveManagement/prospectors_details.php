<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">

    <!-- Title + Back Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <iconify-icon icon="mdi:book-open-page-variant-outline" class="text-primary me-2" style="font-size: 1.8rem;"></iconify-icon>
            <h4 class="fw-bold text-primary mb-0">
                Prospect Book Details - <?= esc($prospect['name']); ?>
            </h4>
        </div>

        <a href="<?= base_url('prospectivemanagement/dashboard'); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fa fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <!-- ROW -->
    <div class="row">

        <!-- Paid Books Table -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light py-3">
                    <div class="d-flex align-items-center">
                        <iconify-icon icon="mdi:check-circle-outline" class="text-success me-2 fs-5"></iconify-icon>
                        <h6 class="fw-semibold text-success mb-0">Paid Books</h6>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($paid_books)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-success">
                                    <tr>
                                        <th width="8%" class="text-center">#</th>
                                        <th>Plan Name</th>
                                        <th>Title</th>
                                        <th width="20%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($paid_books as $book): ?>
                                    <tr>
                                        <td class="text-center fw-medium"><?= $i++; ?></td>
                                        <td><?= esc($book['plan_name']); ?></td>
                                        <td><?= esc($book['title_name']); ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url('prospectors/viewbook/' . $book['id']); ?>" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <iconify-icon icon="mdi:inbox-outline" class="fs-1 text-muted mb-2"></iconify-icon>
                            <p class="text-muted mb-0">No paid books found</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Partial Payment Books -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light py-3">
                    <div class="d-flex align-items-center">
                        <iconify-icon icon="mdi:cash-clock" class="text-warning me-2 fs-5"></iconify-icon>
                        <h6 class="fw-semibold text-warning mb-0">Partial Payment Books</h6>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($partial_books)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-warning">
                                    <tr>
                                        <th width="8%" class="text-center">#</th>
                                        <th>Plan Name</th>
                                        <th>Title</th>
                                        <th width="25%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $j=1; foreach ($partial_books as $book): ?>
                                    <tr>
                                        <td class="text-center fw-medium"><?= $j++; ?></td>
                                        <td><?= esc($book['plan_name']); ?></td>
                                        <td><?= esc($book['title_name']); ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url('prospectors/viewbook/' . $book['id']); ?>" 
                                               class="btn btn-sm btn-outline-primary me-2">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                            <a href="<?= base_url('prospectors/editbook/' . $book['id']); ?>" 
                                               class="btn btn-sm btn-outline-success">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <iconify-icon icon="mdi:inbox-outline" class="fs-1 text-muted mb-2"></iconify-icon>
                            <p class="text-muted mb-0">No partial payment books found</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection(); ?>
