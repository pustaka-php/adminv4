<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
         $.fn.dataTable.ext.errMode = 'none'; 
    });

    function updatePublisherStatus(id, status) {
        const action = status === 1 ? "Active" : "Inactive";
        if (confirm(`Set this publisher to ${action}?`)) {
            $.post("<?= base_url('tppublisher/setpublisherstatus') ?>",
                { publisher_id: id, status: status },
                function (response) {
                    if (response.success) {
                        alert(`Set to ${action}.`);
                        location.reload();
                    } else {
                        alert("Failed to update.");
                    }
                },
                "json"
            );
        }
    }
</script>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
 <a href="<?= base_url('tppublisher') ?>" 
           class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a><br><br>


<div class="card basic-data-table">
    <div class="d-flex justify-content-end mb-4">
    <a href="<?= base_url('tppublisher/tppublisherview') ?>" 
        class="btn rounded-pill btn-info-600 radius-8 px-20 py-11">
        ADD PUBLISHER
    </a>
    </div>


    <?php 
    $sections = [
        'active' => 'Active Publishers',
        'inactive' => 'Inactive Publishers',
    ];
    ?>

    <?php foreach ($sections as $key => $title): ?>
    <div class="card-body">
        <h5 class="card-title mb-2"><?= esc($title) ?></h5>


        <table class="zero-config table table-hover mt-4" id="dataTable" id="table-<?= esc($key) ?>" data-page-length="10">
            <thead>
                <tr>
                    <th>S.L</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($publishers[$key]) && is_array($publishers[$key])): ?>
                    <?php $sl = 1; foreach ($publishers[$key] as $pub): ?>
                        <tr>
                            <td><?= $sl++ ?></td>
                            <td><?= esc($pub['publisher_id'] ?? '-') ?></td>
                            <td><?= esc($pub['publisher_name'] ?? '-') ?></td>
                            <td><?= esc($pub['contact_person'] ?? '-') ?></td>
                            <td><?= esc($pub['email_id'] ?? '-') ?></td>
                            <td><?= esc($pub['mobile'] ?? '-') ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('tppublisher/tppublisherdetailsview/' . $pub['publisher_id']) ?>"
                                   class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center"
                                   title="View">
                                    <iconify-icon icon="iconamoon:eye-light" width="18"></iconify-icon>
                                </a>

                                <a href="<?= base_url('tppublisher/tppublisheredit/' . $pub['publisher_id']) ?>"
                                   class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                   title="Edit">
                                    <iconify-icon icon="lucide:edit" width="18"></iconify-icon>
                                </a>

                                <?php if ($pub['status'] == 1): ?>
                                    <a href="#" onclick="updatePublisherStatus(<?= $pub['publisher_id'] ?>, 0)"
                                       class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                       title="Deactivate">
                                       <iconify-icon icon="mdi:close-circle" width="18" style="color:red;" title="Inactive"></iconify-icon> 
                                    </a>
                                <?php else: ?>
                                    <a href="#" onclick="updatePublisherStatus(<?= $pub['publisher_id'] ?>, 1)"
                                       class="w-32-px h-32-px bg-info-light text-info-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                       title="Activate">
                                        <iconify-icon icon="mdi:checkbox-marked-circle" width="18" style="color:green;" title="Active"></iconify-icon>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
  <td colspan="7" class="text-center text-muted">
    No <?= strtolower($title) ?> found.
  </td>
</tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php endforeach; ?>

</div>

<?= $this->endSection(); ?>
