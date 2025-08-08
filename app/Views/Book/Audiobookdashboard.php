<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>
<?php
    $inactive_audio_books = $audio_books_dashboard_data['inactive_audio_books'];
    $active_audio_books = $audio_books_dashboard_data['active_audio_books'];
    $cancelled_audio_books = $audio_books_dashboard_data['cancelled_audio_books'];
    $graph_cnt_data = json_encode($audio_books_dashboard_data['graph_data']['activated_cnt']);
    $graph_date_data = json_encode($audio_books_dashboard_data['graph_data']['activated_date']);
?>

<div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center my-3 p-3 bg-light rounded shadow-sm">
        <a href="<?= base_url('book/add_audio_book') ?>" class="btn btn-info fw-bold text-white">➕ ADD AUDIO BOOK</a>
    </div>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="text-center bg-warning-subtle p-3 rounded">
                <h5>⏳ Inactive</h5>
                <h2><?= count($inactive_audio_books) ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-center bg-info-subtle p-3 rounded">
                <h5>✅ Active</h5>
                <h2><?= count($active_audio_books) ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-center bg-danger-subtle p-3 rounded">
                <h5>❌ Cancelled</h5>
                <h2><?= count($cancelled_audio_books) ?></h2>
            </div>
        </div>
    </div>

    <!-- Inactive Table -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light fw-bold">⏳ Inactive Audio Books (<?= count($inactive_audio_books) ?>)</div>
        <div class="card-body table-responsive">
            <table class="zero-config table table-hover mt-4" id="inactiveAudioBooksTable" data-page-length="10">
                <thead class="table-light">
                    <tr>
                        <th>#</th><th>Book ID</th><th>Title</th><th>Author</th><th>Narrator</th><th>Duration</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inactive_audio_books as $i => $book): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= $book['book_id'] ?></td>
                            <td><?= $book['book_title'] ?></td>
                            <td><?= $book['author_name'] ?></td>
                            <td><?= $book['narrator_name'] ?></td>
                            <td><?= $book['number_of_page'] ?> mins</td>
                            <td>
                                <a href="<?= base_url("book/audio_book_chapters/{$book['book_id']}") ?>" title="Chapters">
    <iconify-icon icon="mdi:book-open-page-variant" style="font-size: 18px;"></iconify-icon>
</a>

<a href="<?= base_url("adminv3/in_progress_edit_book/{$book['book_id']}") ?>" title="Edit" target="_blank">
    <iconify-icon icon="mdi:pencil" style="font-size: 18px;"></iconify-icon>
</a>

<a href="#" onclick="add_to_test(<?= $book['book_id'] ?>)" title="Add to Test">
    <iconify-icon icon="icony:test-tube" style="font-size: 18px;"></iconify-icon>
</a>

<a href="<?= base_url("book/activate_book_page/{$book['book_id']}") ?>" title="Activate">
    <iconify-icon icon="icony:check-circle" style="font-size: 18px;"></iconify-icon>
</a>

                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Active Table -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light fw-bold">✅ Active Audio Books (<?= count($active_audio_books) ?>)</div>
        <div class="card-body table-responsive">
            <table class="zero-config table table-hover mt-4" id="activeAudioBooksTable" data-page-length="10">
                <thead class="table-light">
                    <tr>
                        <th>#</th><th>Book ID</th><th>Title</th><th>Author</th><th>Narrator</th><th>Duration</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($active_audio_books as $i => $book): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= $book['book_id'] ?></td>
                            <td><?= $book['book_title'] ?></td>
                            <td><?= $book['author_name'] ?></td>
                            <td><?= $book['narrator_name'] ?></td>
                            <td><?= $book['number_of_page'] ?> mins</td>
                            <td>
                                <a href="<?= base_url("adminv3/audio_book_chapters/{$book['book_id']}") ?>" title="Chapters">📖</a>
                                <a href="<?= base_url("adminv3/in_progress_edit_book/{$book['book_id']}") ?>" title="Edit" target="_blank">✏️</a>
                                <a href="#" onclick="add_to_test(<?= $book['book_id'] ?>)" title="Add to Test">🧪</a>
                                <a href="#" onclick="pause_book(<?= $book['book_id'] ?>)" title="Pause">⏸️</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Cancelled Table -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light fw-bold">❌ Cancelled Audio Books (<?= count($cancelled_audio_books) ?>)</div>
        <div class="card-body table-responsive">
            <table class="zero-config table table-hover mt-4" id="cancelledAudioBooksTable" data-page-length="10">
                <thead class="table-light">
                    <tr>
                        <th>#</th><th>Book ID</th><th>Title</th><th>Author</th><th>Narrator</th><th>Duration</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cancelled_audio_books as $i => $book): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= $book['book_id'] ?></td>
                            <td><?= $book['book_title'] ?></td>
                            <td><?= $book['author_name'] ?></td>
                            <td><?= $book['narrator_name'] ?></td>
                            <td><?= $book['number_of_page'] ?> mins</td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Graph -->
    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <h4 class="text-center mb-4">📈 Month-wise Activated Books</h4>
            <div id="monthly_activated_books" style="height: 350px;"></div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<!-- JS -->
<?= $this->section('scripts'); ?>
<script src="<?= base_url('assets/js/lib/apexcharts.min.js') ?>"></script>

<script>
    const base_url = "<?= base_url(); ?>";

    // Render Apex Chart
    const graph_options = {
        chart: {
            type: 'area',
            stacked: true,
            height: 350
        },
        colors: ['#3b82f6'],
        dataLabels: { enabled: false },
        series: [{
            name: "Books",
            data: <?= $graph_cnt_data; ?>
        }],
        xaxis: {
            categories: <?= $graph_date_data; ?>
        }
    };
    const graph_chart = new ApexCharts(document.querySelector("#monthly_activated_books"), graph_options);
    graph_chart.render();

    // Add to Test
    function add_to_test(book_id) {
        const user_id = prompt("Enter User ID:");
        if (!user_id) return;

        $.post(base_url + '/book/add_to_test', { book_id, user_id }, function(data) {
            if (data == 1) alert("Book added to test");
        });
    }

    // Dummy Pause (can replace with AJAX)
    function pause_book(book_id) {
        alert("Pause functionality not implemented yet for Book ID: " + book_id);
    }

    // DataTable
    $(document).ready(function() {
        $('#inactiveAudioBooksTable').DataTable();
        $('#activeAudioBooksTable').DataTable();
        $('#cancelledAudioBooksTable').DataTable();
    });
</script>
<?= $this->endSection(); ?>
