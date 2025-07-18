<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        new DataTable("#table-active");
        new DataTable("#table-inactive");
        new DataTable("#table-pending");

        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });

    function updateBookStatus(id, status) {
        const action = status === 1 ? "Activate" : (status === 0 ? "Deactivate" : "Pending");
        if (confirm(`Set this book to ${action}?`)) {
            $.post("<?= base_url('tppublisher/setbookstatus') ?>",
                { book_id: id, status: status },
                function (response) {
                    if (response.success) {
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

<div class="card basic-data-table">
    <div class="d-flex justify-content-end mb-4">
        <a href="<?= base_url('tppublisher/tpbookadddetails/') ?>"
           class="btn rounded-pill btn-info-600 radius-8 px-20 py-11">
           ADD BOOK
        </a>
    </div>

    <?php
    $sections = [
        'active' => ['title' => 'Active Books', 'data' => $active_books ?? []],
        'inactive' => ['title' => 'Inactive Books', 'data' => $inactive_books ?? []],
        'pending' => ['title' => 'Pending Books', 'data' => $pending_books ?? []],
    ];
    ?>

    <?php foreach ($sections as $key => $section): ?>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title mb-2"><?= esc($section['title']) ?></h5>

                <div class="table-responsive">
                    <table class="table bordered-table mb-0" id="table-<?= esc($key) ?>" data-page-length="10" style="font-size: 0.85rem;">
                        <thead>
                            <tr>
                                <th style="font-size: 0.85rem; width: 5%;">
                                    <div class="form-check style-check d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox">
                                        <label class="form-check-label">S.L</label>
                                    </div>
                                </th>
                                <th style="font-size: 0.85rem; width: 30%;">Book Name</th>
                                <th style="font-size: 0.85rem; width: 25%;">Author</th>
                                <th style="font-size: 0.85rem; width: 20%;">Publisher</th>
                                <th style="font-size: 0.85rem; width: 10%;">Status</th>
                                <th style="font-size: 0.85rem; width: 10%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($section['data'])): ?>
                                <?php $sl = 1; foreach ($section['data'] as $book): ?>
                                    <tr>
                                        <td><?= $sl++ ?></td>
                                        <td><?= esc($book['book_title']) ?></td>
                                        <td><?= esc($book['author_name'] ?? '-') ?></td>
                                        <td><?= esc($book['publisher_name'] ?? '-') ?></td>
                                        <td>
                                            <?= $book['status'] == 1 ? 'Active' : ($book['status'] == 0 ? 'Inactive' : 'Pending') ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="<?= base_url('tppublisher/bookview/'.$book['book_id']) ?>"
                                                   class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center"
                                                   title="View">
                                                    <iconify-icon icon="iconamoon:eye-light" width="16"></iconify-icon>
                                                </a>

                                                <a href="<?= base_url('tppublisher/bookedit/'.$book['book_id']) ?>"
                                                   class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                                   title="Edit">
                                                    <iconify-icon icon="lucide:edit" width="16"></iconify-icon>
                                                </a>

                                                <?php if ($book['status'] == 1): ?>
    <!-- Active: Show Inactive + Pending -->
    <a href="#" onclick="updateBookStatus(<?= $book['book_id'] ?>, 0)"
       class="w-32-px h-32-px bg-primary-light text-danger-600 rounded-circle d-inline-flex align-items-center justify-content-center"
       title="Set Inactive">
        <iconify-icon icon="mdi:close-circle" width="18"></iconify-icon>
    </a>
    <a href="#" onclick="updateBookStatus(<?= $book['book_id'] ?>, 2)"
       class="w-32-px h-32-px bg-danger-focus text-warning-main rounded-circle d-inline-flex align-items-center justify-content-center"
       title="Set Pending">
        <iconify-icon icon="mdi:clock-time-eight-outline" width="18"></iconify-icon>
    </a>

<?php elseif ($book['status'] == 0): ?>
    <!-- Inactive: Show Active + Pending -->
    <a href="#" onclick="updateBookStatus(<?= $book['book_id'] ?>, 1)"
      class="w-32-px h-32-px bg-primary-light text-success-600 rounded-circle d-inline-flex align-items-center justify-content-center"
       title="Set Active">
        <iconify-icon icon="mdi:checkbox-marked-circle" width="18"></iconify-icon>
    </a>
    <a href="#" onclick="updateBookStatus(<?= $book['book_id'] ?>, 2)"
       class="w-32-px h-32-px bg-danger-focus text-warning-main rounded-circle d-inline-flex align-items-center justify-content-center"
       title="Set Pending">
        <iconify-icon icon="mdi:clock-time-eight-outline" width="18"></iconify-icon>
    </a>

<?php elseif ($book['status'] == 2): ?>
    <!-- Pending: Show Active + Inactive -->
     <a href="#" onclick="updateBookStatus(<?= $book['book_id'] ?>, 1)"
       class="w-32-px h-32-px bg-primary-light text-success-600 rounded-circle d-inline-flex align-items-center justify-content-center"
       title="Set Active">
        <iconify-icon icon="mdi:checkbox-marked-circle" width="18"></iconify-icon>
    </a>
    <a href="#" onclick="updateBookStatus(<?= $book['book_id'] ?>, 0)"
       class="w-32-px h-32-px bg-primary-light text-danger-600 rounded-circle d-inline-flex align-items-center justify-content-center"
       title="Set Inactive">
        <iconify-icon icon="mdi:close-circle" width="18"></iconify-icon>
    </a>
<?php endif; ?>



                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        No <?= strtolower($section['title']) ?> found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection(); ?>
