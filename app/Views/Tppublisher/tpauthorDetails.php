<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        new DataTable("#table-active");
        new DataTable("#table-inactive");
    });

    function updatePublisherStatus(id, status) {
    const action = status === 1 ? "Active" : "Inactive";

    const row = $(`a[onclick*="updatePublisherStatus(${id}"]`).closest("tr");
    const publisherStatusText = row.find("td:nth-child(7)").text().trim().toLowerCase();

    if (status === 1 && publisherStatusText !== "active") {
        alert("Cannot activate author. Publisher is inactive.");
        return;
    }

    if (confirm(`Set this Author to ${action}?`)) {
        $.post("<?= base_url('tppublisher/setAuthorStatus') ?>",
            { author_id: id, status: status },
            function (response) {
                if (response.success) {
                    alert(`Set to ${action}.`);
                    location.reload();
                } else {
                    alert(response.message || "Failed to update.");
                }
            },
            "json"
        );
    }
}

</script>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<div class="card basic-data-table">
    <div class="d-flex justify-content-end mb-4">
        <a href="<?= base_url('tppublisher/tpauthoradddetails') ?>"
           class="btn rounded-pill btn-info-600 radius-8 px-20 py-11">
           ADD AUTHOR
        </a>
    </div>

    <?php
    $sections = [
        'active' => 'Active Authors',
        'inactive' => 'Inactive Authors',
    ];

    $authors = [
        'active' => $active_authors ?? [],
        'inactive' => $inactive_authors ?? [],
    ];
    ?>

    <?php foreach ($sections as $key => $title): ?>
        <div class="card-body">
            <h5 class="card-title mb-2"><?= esc($title) ?></h5>

            <table class="table bordered-table mb-0" id="table-<?= esc($key) ?>" data-page-length="10">
                <thead>
                    <tr>
                        <th>
                            <div class="form-check style-check d-flex align-items-center">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">S.L</label>
                            </div>
                        </th>
                        <th>Publisher Name</th>
                        <th>Author ID</th>
                        <th>Author Name</th>
                        <th>Mobile</th>
                        <th>Email ID</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($authors[$key]) && is_array($authors[$key])): ?>
                        <?php $sl = 1; foreach ($authors[$key] as $pub): ?>
                            <tr>
                                <td><?= $sl++ ?></td>
                                <td><?= esc($pub['publisher_name']) ?></td>
                                <td><?= esc($pub['author_id']) ?></td>
                                <td><?= esc($pub['author_name']) ?></td>
                                <td><?= esc($pub['mobile']) ?></td>
                                <td><?= esc($pub['email_id']) ?></td>
                                <td><?= $pub['publisher_status'] == 1 ? 'Active' : 'Inactive' ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('tppublisher/tpauthorview/'.$pub['author_id']); ?>"
                                       class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center"
                                       title="View">
                                        <iconify-icon icon="iconamoon:eye-light" width="18"></iconify-icon>
                                    </a>

                                    <a href="<?= base_url('tppublisher/tpauthoredit/'.$pub['author_id']); ?>"
                                       class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                       title="Edit">
                                        <iconify-icon icon="lucide:edit" width="18"></iconify-icon>
                                    </a>

                                    <?php if ($pub['author_status'] == 1): ?>
                                        <a href="#"
                                           onclick="updatePublisherStatus(<?= $pub['author_id'] ?>, 0)"
                                           class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                           title="Deactivate">
                                            <iconify-icon icon="mdi:close-circle" width="18" style="color:red;"></iconify-icon>
                                        </a>
                                    <?php else: ?>
                                        <a href="#"
                                           onclick="updatePublisherStatus(<?= $pub['author_id'] ?>, 1)"
                                           class="w-32-px h-32-px bg-info-light text-info-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                           title="Activate">
                                            <iconify-icon icon="mdi:checkbox-marked-circle" width="18" style="color:green;"></iconify-icon>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">
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
