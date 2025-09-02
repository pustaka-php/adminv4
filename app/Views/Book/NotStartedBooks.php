<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>

<div class="card shadow-sm mb-4">
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="zero-config table table-hover mt-4" id="previousMonthTable" data-page-length="10">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="15%">Date</th>
                                    <th width="20%">Author</th>
                                    <th width="10%">Book ID</th>
                                    <th width="35%">Title</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($ebooks_data['book_not_start'])): ?>
                                    <?php foreach ($ebooks_data['book_not_start'] as $index => $ebooks_details): ?>
                                        <tr class="align-middle">
                                            <td><?php echo $index + 1; ?></td>
                                            <td>
                                                <?php if (!empty($ebooks_details['date_created'])): ?>
                                                    <span class="text-dark">
                                                        <?php echo date('M d, Y', strtotime($ebooks_details['date_created'])); ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">N/A</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo $ebooks_details['author_name'] ?? 'N/A'; ?></td>
                                            <td>
                                                <span class="badge bg-info text-dark"><?php echo $ebooks_details['book_id'] ?? 'N/A'; ?></span>
                                            </td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 300px;" title="<?php echo htmlspecialchars($ebooks_details['book_title'] ?? ''); ?>">
                                                    <?php echo $ebooks_details['book_title'] ?? 'N/A'; ?>
                                                </div>
                                            </td>
                                            <td>
                                            <button onclick="mark_start_work(<?= $ebooks_details['book_id'] ?? 0 ?>)" 
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

    <!-- Initialize DataTables -->
    <?= $this->section('script'); ?>
    <script>
        $(document).ready(function() {
            $('#bookTable').DataTable({
                "pageLength": 7,
                "lengthChange": true,
                "searching": true
            });
        });
    </script>

        </div>
    </div>

    <!--  END CONTENT AREA  -->
    <script type="text/javascript">
        var base_url = "<?= base_url() ?>";
        // Storing all values from form into variables
        function mark_start_work(book_id) {
            $.ajax({
                url: base_url + '/book/ebooksmarkstart',
                type: 'POST',
                data: {
                    "book_id": book_id
                },
                success: function(data) {
        if (data.status == 1) {
            alert("Successfully started the work!!");
        } else {
            alert("Unknown error!! Check again!");
        }
    }
            });
        }
     <?= $this->endSection(); ?>