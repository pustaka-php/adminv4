<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                <iconify-icon icon="mdi:progress-clock" class="fs-4 text-primary"></iconify-icon>
            </div>
            <h5 class="fw-bold mb-0 text-primary">In Progress Prospects</h5>
        </div>

        <a href="<?= base_url('prospectivemanagement/dashboard'); ?>" class="btn btn-outline-secondary btn-sm d-flex align-items-center shadow-sm">
            <iconify-icon icon="mdi:arrow-left" class="me-1 fs-5"></iconify-icon> Back
        </a>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="zero-config table table-hover mt-4">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Source</th>
                            <th>Created Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($prospects)) : ?>
                            <?php foreach ($prospects as $row) : ?>
                                <tr class="align-middle">
                                    <td class="fw-semibold text-muted"><?= esc($row['id']); ?></td>
                                    <td class="fw-bold"><?= esc($row['name']); ?></td>
                                    <td><?= esc($row['phone']); ?></td>
                                    <td><?= esc($row['email']); ?></td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success border border-success rounded-pill px-3 py-1">
                                            <?= esc($row['source_of_reference']); ?>
                                        </span>
                                    </td>
                                    <td><?= date('d M Y', strtotime($row['created_at'])); ?></td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">

                                            <!-- View -->
                                            <a href="<?= base_url('prospectivemanagement/view/' . $row['id']); ?>" 
                                                class="btn btn-outline-info btn-sm rounded-pill mx-1" title="View Details">
                                                <iconify-icon icon="mdi:eye-outline" class="fs-6"></iconify-icon>
                                            </a>

                                            <!-- Edit -->
                                            <a href="<?= base_url('prospectivemanagement/edit/' . $row['id']); ?>" 
                                                class="btn btn-outline-primary btn-sm rounded-pill mx-1" title="Edit Prospect">
                                                <iconify-icon icon="mdi:pencil-outline" class="fs-6"></iconify-icon>
                                            </a>

                                             <!-- Closed -->
                                            <a href="<?= base_url('prospectivemanagement/closeinprogress/' . $row['id']); ?>" 
                                                class="btn btn-outline-success btn-sm rounded-pill mx-1" 
                                                title="Mark as Closed"
                                                onclick="return confirm('Are you sure you want to mark this prospect as Closed?');">
                                                <iconify-icon icon="mdi:check-circle-outline" class="fs-6"></iconify-icon>
                                            </a>

                                            <!-- Denied -->
                                            <a href="<?= base_url('prospectivemanagement/deny/' . $row['id']); ?>" 
                                                class="btn btn-outline-danger btn-sm rounded-pill mx-1" 
                                                title="Mark as Denied"
                                                onclick="return confirm('Are you sure you want to mark this prospect as Denied?');">
                                                <iconify-icon icon="mdi:cancel" class="fs-6"></iconify-icon>
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    No prospects found.
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
