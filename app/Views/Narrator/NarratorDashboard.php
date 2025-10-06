<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">
    <!-- Page Header -->
   <div class="d-flex justify-content-between align-items-center mb-4">
    <div></div>
    <a href="<?= base_url('narrator/addnarratorview') ?>" 
       class="btn rounded-pill btn-primary-600 radius-8 px-20 py-11">
        Add Narrator
    </a>
</div>
<br>
    <!-- Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover table-light zero-config">
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Narrator Name</th>
                        <th scope="col">Email</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dashboard_data['narrators'])): ?>
                        <?php foreach ($dashboard_data['narrators'] as $index => $narrator): ?>
                            <tr>
                                <td><?= esc($index + 1) ?></td>
                                <td><?= esc($narrator['narrator_name']) ?></td>
                                <td><?= esc($narrator['email']) ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('narrator/editnarratorview/' . $narrator['narrator_id']) ?>"
                                       class="btn btn-sm btn-outline-info px-3">
                                       <i class="bi bi-pencil-square me-1"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No narrators found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
