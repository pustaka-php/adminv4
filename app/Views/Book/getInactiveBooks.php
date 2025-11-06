<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="row gy-4 mb-24">
    <div class="layout-px-spacing">
        <table class="table table-hover table-light zero-config">
            <thead>
                <tr>
                    <th>S.No</th>
                    
                    <th>BookId</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th style="text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach ($in_active as $ebooks): ?>
                <tr>
                    <td><?= $i++; ?></td>
                    
                    <td>
                        <center><a href="<?= base_url('book/editbook/' . $ebooks['book_id']) ?>" target="_blank" style="color: blue;"><?= $ebooks['book_id'] ?? 'N/A' ?></a></center>
                    </td>
                    <td><?= esc($ebooks['book_title']); ?></td>
                    <td><?= esc($ebooks['author_name']); ?></td>
                    <td class="text-center">
                        <ul class="table-controls list-unstyled d-flex gap-2 mb-0 justify-content-center">
                            <!-- Hold Icon (SVG) -->
                            <li>
                                <a href="javascript:void(0);"
                                   class="rounded bs-tooltip"
                                   title="Hold"
                                   role="button"
                                   aria-label="Hold book"
                                   data-bs-toggle="modal"
                                   data-bs-target="#holdModal<?= $ebooks['book_id']; ?>"
                                   style="display:inline-flex; align-items:center; justify-content:center; width:36px; height:36px; color:#f0ad4e;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
                                        <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2z" stroke="currentColor" stroke-width="1.2"/>
                                        <rect x="8" y="7" width="2.5" height="10" rx="0.5" fill="currentColor"/>
                                        <rect x="13.5" y="7" width="2.5" height="10" rx="0.5" fill="currentColor"/>
                                    </svg>
                                </a>
                            </li>

                            <!-- Fill Data -->
                            <li>
                                <a class="rounded text-primary bs-tooltip" 
                                   title="Fill Data" 
                                   target="_blank" 
                                   href="<?= base_url('book/filldataview/'.$ebooks['book_id']); ?>"
                                   data-bs-toggle="tooltip"
                                   data-bs-placement="top">
                                    <iconify-icon icon="mdi:file-document-edit-outline" style="font-size:1.5rem;"></iconify-icon>
                                </a>
                            </li>

                            <!-- Add to Test -->
                            <li>
                                <a href="javascript:void(0);" 
                                   onclick="add_to_test(<?= $ebooks['book_id']; ?>)" 
                                   class="rounded text-danger bs-tooltip" 
                                   title="Add to Test" 
                                   data-bs-toggle="tooltip" 
                                   data-bs-placement="right">
                                    <iconify-icon icon="mdi:flask-outline" style="font-size:1.5rem;"></iconify-icon>
                                </a>
                            </li>

                            <!-- Activate Book -->
                            <li>
                                <a href="<?= base_url('book/activatebookpage/'.$ebooks['book_id']); ?>" 
                                   class="rounded text-success bs-tooltip" 
                                   title="Activate Book" 
                                   data-bs-toggle="tooltip" 
                                   data-bs-placement="right">
                                    <iconify-icon icon="mdi:check-circle-outline" style="font-size:1.5rem;"></iconify-icon>
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

// Initialize Bootstrap tooltips
document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('.bs-tooltip, [data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (el) {
        return new bootstrap.Tooltip(el);
    });
});

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
