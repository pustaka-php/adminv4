<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>
<div class="row gy-4 mb-24">
    <div class="layout-px-spacing">
        <table class="table table-hover table-light table-bordered zero-config">
            <thead class="thead-dark">
                <tr>
                    <th>S.No</th>
                    <th>Author</th>
                    <th>BookId</th>
                    <th>Title</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach ($in_active as $ebooks): ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= esc($ebooks['author_name']); ?></td>
                    <td>
                        <center><?= esc($ebooks['book_id']); ?></center>
                        <br>
                        <center>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#holdModal<?= $ebooks['book_id']; ?>">
                                <i class="fas fa-pause-circle"></i> Hold
                            </button>
                        </center>
                    </td>
                    <td><?= esc($ebooks['book_title']); ?></td>
                    <td class="text-center">
                        <ul class="table-controls">
                            <li>
                                <a class="rounded text-danger bs-tooltip" title="Fill Data" target="_blank" href="<?= base_url('book/filldataview/'.$ebooks['book_id']); ?>" data-toggle="tooltip" data-placement="top">
                                    <iconify-icon icon="mdi:file-document-edit-outline" style="color: #2196f3; font-size: 1.5rem;"></iconify-icon>
                                </a>
                            </li>
                            <li>
                                <a href="#" onclick="add_to_test(<?= $ebooks['book_id']; ?>)" class="rounded text-danger bs-tooltip" title="Add to Test" data-toggle="tooltip" data-placement="right">
                                    <iconify-icon icon="mdi:flask-outline" style="color: #e7515a; font-size: 1.5rem;"></iconify-icon>
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url("book/activatebookpage/".$ebooks['book_id']); ?>" class="rounded text-danger bs-tooltip" title="Activate Book" data-toggle="tooltip" data-placement="right">
                                    <iconify-icon icon="mdi:check-circle-outline" style="color: #009688; font-size: 1.5rem;"></iconify-icon>
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modals for Hold action -->
<?php foreach ($in_active as $ebooks): ?>
<div class="modal fade" id="holdModal<?= $ebooks['book_id']; ?>" tabindex="-1" aria-labelledby="holdModalLabel<?= $ebooks['book_id']; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="holdModalLabel<?= $ebooks['book_id']; ?>">Put On Hold</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to hold Book <br> Book ID <?= $ebooks['book_id']; ?> - <?= esc($ebooks['book_title']); ?>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="hold_in_progress(<?= $ebooks['book_id']; ?>)">Hold</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script type="text/javascript">
var base_url = window.location.origin + '/';

function add_to_test(book_id) {
    var user_id = prompt("Enter User Id:");

    if(user_id) {
        $.ajax({
            url: base_url + 'book/addtotest',
            type: 'POST',
            data: { book_id: book_id, user_id: user_id },
            success: function(data) {
                if (data == 1) {
                    alert("Book added to test");
                } else {
                    alert("Failed to add book to test");
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert("Something went wrong!");
            }
        });
    }
}

function hold_in_progress(book_id) {
    $.ajax({
        url: base_url + 'book/holdinprogress',
        type: 'POST',
        data: { book_id: book_id },
        success: function(data) {
            if (data == 1) {
                alert("Record held successfully!");
                location.reload();
            } else {
                alert("Failed to hold record!");
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            alert("Something went wrong!");
        }
    });
}
</script>
<?= $this->endSection(); ?>
