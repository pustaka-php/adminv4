<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="row gy-4 mb-4">
    <div class="layout-px-spacing">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table table-hover table-light zero-config">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Author</th>
                                <th style="width: 150px; text-align: center;">Book ID</th>
                                <th style="width: 200px;">Title</th>
                                <th style="width: 180px;">Action</th>
                            </tr>
                        </thead>
                        <tbody class="fs-6">
                            <?php $i=1; foreach ($active as $ebooks): ?>
                            <tr>
                                <td class="fw-semibold"><?= $i++; ?></td>
                                <td class="text-start" style="font-size:0.95rem;"><?= esc($ebooks['author_name']); ?></td>
                                <td class="text-center"><?= esc($ebooks['book_id']); ?></td>
                                <td class="text-start" style="font-size:0.95rem;"><?= esc($ebooks['book_title']); ?></td>
                                <td class="text-center">
                                    <ul class="table-controls list-unstyled d-flex gap-2 mb-0 justify-content-center">
                                        <!-- Edit / Fill Data -->
                                        <li>
                                            <a class="rounded text-primary bs-tooltip" 
                                               title="Edit / Fill Data" 
                                               target="_blank" 
                                               href="<?= base_url('book/editbook/'.$ebooks['book_id']); ?>"
                                               data-bs-toggle="tooltip" data-bs-placement="top">
                                                <iconify-icon icon="mdi:file-document-edit-outline" style="font-size:1.5rem;"></iconify-icon>
                                            </a>
                                        </li>

                                        <!-- Add to Test -->
                                        <li>
                                            <a href="javascript:void(0);" 
                                               onclick="add_to_test(<?= $ebooks['book_id']; ?>)" 
                                               class="rounded text-danger bs-tooltip" 
                                               title="Add to Test" 
                                               data-bs-toggle="tooltip" data-bs-placement="top">
                                                <iconify-icon icon="mdi:flask-outline" style="font-size:1.5rem;"></iconify-icon>
                                            </a>
                                        </li>

                                        <!-- Activate -->
                                        <li>
                                            <a href="<?= base_url('book/activatebookpage/'.$ebooks['book_id']); ?>" 
                                               class="rounded text-success bs-tooltip" 
                                               title="Activate Book" 
                                               data-bs-toggle="tooltip" data-bs-placement="top">
                                                <iconify-icon icon="mdi:check-circle-outline" style="font-size:1.5rem;"></iconify-icon>
                                            </a>
                                        </li>

                                        <!-- Hold (SVG icon) -->
                                        <li>
                                            <a href="javascript:void(0);" 
                                               class="rounded text-warning bs-tooltip" 
                                               title="Hold Book" 
                                               data-bs-toggle="modal" 
                                               data-bs-target="#holdModal<?= $ebooks['book_id']; ?>"
                                               style="display:inline-flex; align-items:center; justify-content:center; width:36px; height:36px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm-1 13H9V9h2v6zm4 0h-2V9h2v6z"/>
                                                </svg>
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
        </div>
    </div>
</div>

<!-- Modals for Hold -->
<?php foreach ($active as $ebooks): ?>
<div class="modal fade" id="holdModal<?= $ebooks['book_id']; ?>" tabindex="-1" aria-labelledby="holdModalLabel<?= $ebooks['book_id']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm rounded-3">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fs-5" id="holdModalLabel<?= $ebooks['book_id']; ?>">Put On Hold</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center fs-6">
                Are you sure you want to hold this Book?  
                <br><b>Book ID: <?= $ebooks['book_id']; ?> - <?= esc($ebooks['book_title']); ?></b>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary fs-7" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger fs-7" onclick="hold_in_progress(<?= $ebooks['book_id']; ?>)">Hold</button>
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
        $.post(base_url + 'book/addtotest', { book_id: book_id, user_id: user_id }, function(data){
            alert(data == 1 ? "Book added to test" : "Failed to add book to test");
        }).fail(function(){
            alert("Something went wrong!");
        });
    }
}

function hold_in_progress(book_id) {
    $.post(base_url + 'book/holdinprogress', { book_id: book_id }, function(data){
        if (data == 1) {
            alert("Record held successfully!");
            location.reload();
        } else {
            alert("Failed to hold record!");
        }
    }).fail(function(){
        alert("Something went wrong!");
    });
}
</script>
<?= $this->endSection(); ?>
