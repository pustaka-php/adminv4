<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>
<div class="row gy-4 mb-4">
    <div class="layout-px-spacing">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table table-bordered table table-hover table-light zero-config mb-0">
                        <thead class="table-dark fs-7">
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
                                <td class="text-center">
                                    <div class="d-flex flex-column align-items-center">
                                        <div><?= esc($ebooks['book_id']); ?></div>
                                        <button class="btn btn-warning btn-sm mt-2 px-3 fs-7" data-bs-toggle="modal" data-bs-target="#holdModal<?= $ebooks['book_id']; ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm-1 13H9V9h2v6zm4 0h-2V9h2v6z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>

                                <td class="text-start" style="font-size:0.95rem;"><?= esc($ebooks['book_title']); ?></td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a class="btn btn-sm btn-outline-primary fs-7" title="Fill Data" target="_blank"
                                            href="<?= base_url('book/filldataview/'.$ebooks['book_id']); ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" style="fill:#2196f3;">
                                                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34a1.003 1.003 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                            </svg>
                                        </a>
                                        <a href="#" onclick="add_to_test(<?= $ebooks['book_id']; ?>)" class="btn btn-sm btn-outline-danger fs-7" title="Add to Test">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" style="fill:#e7515a;">
                                                <path d="M7 2v2h1v6.1L3.1 19.2c-.9 1.5.2 3.3 1.9 3.3h14c1.7 0 2.8-1.8 1.9-3.3L16 10.1V4h1V2H7m3 2h4v7.1l5.4 9.2H4.6L10 11.1V4Z"/>
                                            </svg>
                                        </a>
                                    </div>
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

<!-- Modals for Hold action -->
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
