<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?> 
<div class="d-flex justify-content-end align-items-center my-3">
  <a href="<?= base_url('book/getebooksstatus'); ?>" 
           class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
</div>
<div class="row gy-4 mb-24">

    <!-- Full Width Table -->
    <div class="col-12">
        <div class="page-title mb-3 d-flex align-items-center justify-content-between">
            <span>Total Hold Books - <?= esc($ebooks_data['holdbook_cnt']) ?></span>
        </div>

        <div class="table-responsive">
            <table class="table zero-config">
                <thead class="thead-dark">
                    <tr>
                        <th>S.No</th> 
                        
                        <th>BookId</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($holdbook as $ebooks_details): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                           
                             <td><a href="<?= base_url('book/editbook/' . $ebooks_details['book_id']) ?>" target="_blank" style="color: blue;"><?= $ebooks_details['book_id'] ?? 'N/A' ?></a></span></td>
                            <td><?= esc($ebooks_details['book_title']) ?></td>
                             <td><?= esc($ebooks_details['author_name']) ?></td>
                            <td>
                                <button class="btn btn-success-600 radius-8 px-16 py-9 text-sm"
                                    onclick="mark_start_work(<?= $ebooks_details['book_id'] ?>)">
                                    Start Work
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>


<!-- Initialize DataTables + AJAX -->
<?= $this->section('script'); ?>
<script type="text/javascript">
    var base_url = "<?= base_url() ?>"; // ✅ always use base_url()

    function mark_start_work(book_id) {
        $.ajax({
            url: base_url + "book/ebooksmarkstart",
            type: "POST",
            data: { book_id: book_id },
            dataType: "json",
            success: function(data) {
                if (data.status == 1) {
                    alert("Successfully started the work!!");
                    location.reload(); // or reload DataTable instead
                } else {
                    alert("Unknown error!! Check again!");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                alert("Request failed! Check console.");
            }
        });
    }
</script>
<?= $this->endSection(); ?>
