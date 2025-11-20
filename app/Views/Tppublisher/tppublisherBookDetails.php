<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
         $.fn.dataTable.ext.errMode = 'none'; 
        new DataTable("#table-active");
        new DataTable("#table-inactive");
        new DataTable("#table-hold");

        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });
    function updateBookStatus(bookId, status) {
        let action = status === 1 ? 'activate' : (status === 0 ? 'deactivate' : 'hold');

        if (!confirm(`Are you sure you want to ${action} this book?`)) return;

        $.ajax({
            url: "<?= base_url('tppublisher/setBookStatus'); ?>",
            type: "POST",
            data: {
                book_id: bookId,
                status: status,
                <?= csrf_token() ?>: "<?= csrf_hash() ?>"
            },
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {
                    alert(response.message);
                    location.reload();
                } else {
                    alert(response.message || "Failed to update.");
                    console.error(response);
                }
            },
            error: function (xhr, status, error) {
                alert("AJAX error: " + error);
                console.error(xhr.responseText);
            }
        });
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
        <a href="<?= base_url('tppublisher/tpbookadddetails/') ?>"
           class="btn rounded-pill btn-info-600 radius-8 px-20 py-11">
           ADD BOOK
        </a>
    </div>

    <?php
    $sections = [
        'active' => ['title' => 'Active Books', 'data' => $active_books ?? []],
        'inactive' => ['title' => 'Inactive Books', 'data' => $inactive_books ?? []],
        'hold' => ['title' => 'Hold Books', 'data' => $pending_books ?? []],
    ];
    ?>

    <?php foreach ($sections as $key => $section): ?>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title mb-2"><?= esc($section['title']) ?></h5>

                <div class="table-responsive">
                    <!-- <table class="table bordered-table mb-0" id="table-<?= esc($key) ?>" data-page-length="10" style="font-size: 0.85rem; table-layout: fixed; width: 100%;"> -->
                         <table class="zero-config table table-hover mt-4"id="table-<?= esc($key) ?>"> 
                        <thead>
                            <tr>
                                <th style="font-size: 0.75rem;">
                                        <label class="form-check-label">S.L</label>
                                </th>
                                <th style="font-size: 0.85rem;">Sku No</th>
                                <th style="font-size: 0.85rem;">Book Name</th>
                                <th style="font-size: 0.85rem;">Author</th>
                                <th style="font-size: 0.85rem;">Publisher</th>
                                <th style="font-size: 0.85rem;">Status</th>
                                <th style="font-size: 0.85rem;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($section['data'])): ?>
                                <?php $sl = 1; foreach ($section['data'] as $book): ?>
                                    <tr>
                                        <td style="font-size: 0.75rem;"><?= $sl++ ?></td>
                                        <td style="font-size: 0.75rem;"><?= esc($book['sku_no']) ?></td>
                                        <td style="font-size: 0.75rem;"><?= esc($book['book_title']) ?></td>
                                        <td style="font-size: 0.75rem;"><?= esc($book['author_name'] ?? '-') ?></td>
                                        <td style="font-size: 0.75rem;"><?= esc($book['publisher_name'] ?? '-') ?></td>
                                        <td style="font-size: 0.75rem;">
                                            <?= $book['author_status'] == 1 ? 'Active' : ($book['author_status'] == 0 ? 'Inactive' : 'Hold') ?>
                                        </td>
                                        <td class="text-center" style="font-size: 0.75rem;">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="<?= base_url('tppublisher/tpbookview/'.$book['book_id']) ?>"
                                                   class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center"
                                                   title="View">
                                                    <iconify-icon icon="iconamoon:eye-light" width="16"></iconify-icon>
                                                </a>
                                                <a href="<?= base_url('tppublisher/edittpbook/'.$book['book_id']) ?>"
                                                   class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                                   title="Edit">
                                                    <iconify-icon icon="lucide:edit" width="16"></iconify-icon>
                                                </a>

                                                <?php if ($book['status'] == 1): ?>
                                                    <a href="#" onclick="updateBookStatus(<?= $book['book_id'] ?>, 0)"
                                                       class="w-32-px h-32-px bg-primary-light text-danger-600 rounded-circle d-inline-flex align-items-center justify-content-center"
                                                       title="Set Inactive">
                                                        <iconify-icon icon="mdi:close-circle" width="18"></iconify-icon>
                                                    </a>
                                                    <a href="#" onclick="updateBookStatus(<?= $book['book_id'] ?>, 2)"
                                                       class="w-32-px h-32-px bg-danger-focus text-warning-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                                       title="Set Hold">
                                                        <iconify-icon icon="mdi:clock-time-eight-outline" width="18"></iconify-icon>
                                                    </a>
                                                <?php elseif ($book['status'] == 0): ?>
                                                    <a href="#" onclick="updateBookStatus(<?= $book['book_id'] ?>, 1)"
                                                       class="w-32-px h-32-px bg-primary-light text-success-600 rounded-circle d-inline-flex align-items-center justify-content-center"
                                                       title="Set Active">
                                                        <iconify-icon icon="mdi:checkbox-marked-circle" width="18"></iconify-icon>
                                                    </a>
                                                    <a href="#" onclick="updateBookStatus(<?= $book['book_id'] ?>, 2)"
                                                       class="w-32-px h-32-px bg-danger-focus text-warning-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                                       title="Set Hold">
                                                        <iconify-icon icon="mdi:clock-time-eight-outline" width="18"></iconify-icon>
                                                    </a>
                                                <?php elseif ($book['status'] == 2): ?>
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
                                    <td colspan="6" class="text-center text-muted" style="font-size: 0.75rem;">
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