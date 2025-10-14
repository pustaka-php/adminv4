<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="layout-px-spacing">

    <!-- Header -->
   <div class="row mt-3">
    <div class="col-12 d-flex justify-content-end">
        <a href="<?= base_url('pod/publisheradd') ?>" 
           class="btn btn-info btn-sm d-flex align-items-center justify-content-center gap-1">
            Add Publisher
        </a>
    </div>
</div>

   <!-- Table -->
<div class="table-responsive mt-3">
    <table class="table table-hover align-middle zero-config" style="border:1px solid #dee2e6;">
        <thead class="table-light text-center">
            <tr>
                <th>#</th>
                <th>Publisher Name</th>
                <th>Address</th>
                <th>City</th>
                <th>Contact Person</th>
                <th>Mobile</th>
                <th>Created Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $publishers = $publisher_data['publisher'] ?? [];
            if (!empty($publishers)):
                foreach ($publishers as $index => $p): ?>
                    <tr style="border-bottom:1px solid #dee2e6;">
                        <td class="text-center"><?= $index + 1 ?></td>
                        <td><?= esc($p['publisher_name']) ?></td>
                        <td><?= esc($p['address']) ?></td>
                        <td><?= esc($p['city']) ?></td>
                        <td><?= esc($p['contact_person']) ?></td>
                        <td><?= esc($p['contact_mobile']) ?></td>
                        <td><?= date('d M Y', strtotime($p['create_date'])) ?></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <!-- Edit Button -->
                                <a href="<?= base_url('pod/editpublisher/'.$p['id']) ?>" 
                                   class="btn rounded-pill btn-warning-600 radius-8 px-3 py-1 text-sm" 
                                   title="Edit Publisher" target="_blank">       
                                    <span>Edit</span>
                                </a>

                                <!-- View Button -->
                                <a href="<?= base_url('pod/publisherview/'.$p['id']) ?>" 
                                   class="btn rounded-pill btn-success-600 radius-8 px-3 py-1 text-sm" 
                                   title="View Publisher" target="_blank">
                                    <span>View</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach;
            else: ?>
                <tr>
                    <td colspan="8" class="text-center text-muted py-3">
                        No publishers found.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</div>

<?= $this->endSection(); ?>
