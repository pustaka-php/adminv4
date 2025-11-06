<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="card shadow-sm mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="zero-config table table-hover mt-4">
                <thead class="table-light">
                    <tr>
                        <th width="5%">#</th>                       
                        <th width="10%">Book ID</th>
                        <th width="35%">Title</th>
                        <th width="20%">Author</th>
                        <th width="15%">Create Date</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($ebooks_data['book_not_start'])): ?>
                        <?php foreach ($ebooks_data['book_not_start'] as $index => $ebooks_details): ?>
                            <tr class="align-middle">
                                <td><?= $index + 1 ?></td>                                
                                <td><a href="<?= base_url('book/editbook/' . $ebooks_details['book_id']) ?>" target="_blank" style="color: blue;"><?= $ebooks_details['book_id'] ?? 'N/A' ?></a></span></td>
                                <td>
                                    <div class="text-truncate" style="max-width: 300px;" title="<?= htmlspecialchars($ebooks_details['book_title'] ?? '') ?>">
                                        <?= $ebooks_details['book_title'] ?? 'N/A' ?>
                                    </div>
                                </td>
                                <td><?= $ebooks_details['author_name'] ?? 'N/A' ?></td>
                                 <td>
                                    <?= !empty($ebooks_details['date_created']) ? 
                                        '<span>' . date('d-m-y', strtotime($ebooks_details['date_created'])) . '</span>' :
                                        '<span>N/A</span>' ?>
                                </td>
                                <td>
                                    <button id="startBtn_<?= $ebooks_details['book_id'] ?>" 
                                        onclick="mark_start_work(<?= $ebooks_details['book_id'] ?? 0 ?>)" 
                                        class="btn btn-info-600 radius-8 px-14 py-6 text-sm">
                                        Start Work
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fas fa-check-circle fa-2x mb-2 text-success"></i><br>
                                All books have been started!
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>

var base_url = "<?= base_url() ?>";

function mark_start_work(book_id) {
    var btn = $('#startBtn_' + book_id);
    btn.prop('disabled', true).text('Starting...');

    $.ajax({
        url: base_url + '/book/ebooksmarkstart',
        type: 'POST',
        dataType: 'json',
        data: {
            book_id: book_id,
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
        },
        success: function(data) {
            if (data.status == 1) {
                alert("✅ Successfully Started the Work!!");
                location.reload(); // refresh page → book will be gone
            } else {
                btn.prop('disabled', false).text('Start Work');
                alert("❌ Unknown error!! Check again.");
            }
        },
        error: function(xhr, status, error) {
            btn.prop('disabled', false).text('Start Work');
            console.log(xhr.responseText);
            alert("⚠️ AJAX error: " + error);
        }
    });
}

</script>
<?= $this->endSection(); ?>
