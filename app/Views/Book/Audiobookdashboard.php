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
    <div class="d-flex justify-content-end align-items-center my-3 p-3 rounded shadow-sm">
    <a href="<?= base_url('book/add_audio_book') ?>" class="btn btn-outline-lilac-600 radius-8 px-20 py-11">ADD AUDIO BOOK</a>
</div>
    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
    <!-- Inactive Books Card -->
    <div class="col-xxl-4 col-sm-6">
        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-4">
            <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                    <div class="d-flex align-items-center gap-2">
                        <span class="mb-0 w-48-px h-48-px bg-warning text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                            <iconify-icon icon="mdi:clock-outline" class="icon"></iconify-icon>
                        </span>
                        <div>
                            <span class="mb-2 fw-medium text-secondary-light text-sm">Inactive Books</span>
                            <h6 class="fw-semibold"><?= count($inactive_audio_books) ?></h6>
                        </div>
                    </div>
                    <div id="inactive-books-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                </div>
                <p class="text-sm mb-0">Waiting for activation</p>
            </div>
        </div>
    </div>

    <!-- Active Books Card -->
    <div class="col-xxl-4 col-sm-6">
        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-5">
            <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                    <div class="d-flex align-items-center gap-2">
                        <span class="mb-0 w-48-px h-48-px bg-success text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                            <iconify-icon icon="mdi:check-circle-outline" class="icon"></iconify-icon>
                        </span>
                        <div>
                            <span class="mb-2 fw-medium text-secondary-light text-sm">Active Books</span>
                            <h6 class="fw-semibold"><?= count($active_audio_books) ?></h6>
                        </div>
                    </div>
                    <div id="active-books-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                </div>
                <p class="text-sm mb-0">Currently available</p>
            </div>
        </div>
    </div>

    <!-- Cancelled Books Card -->
    <div class="col-xxl-4 col-sm-6">
        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-6">
            <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                    <div class="d-flex align-items-center gap-2">
                        <span class="mb-0 w-48-px h-48-px bg-danger text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                            <iconify-icon icon="mdi:cancel" class="icon"></iconify-icon>
                        </span>
                        <div>
                            <span class="mb-2 fw-medium text-secondary-light text-sm">Cancelled Books</span>
                            <h6 class="fw-semibold"><?= count($cancelled_audio_books) ?></h6>
                        </div>
                    </div>
                    <div id="cancelled-books-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                </div>
                <p class="text-sm mb-0">No longer available</p>
            </div>
        </div>
    </div>
</div>

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4" id="audioBooksTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="inactive-tab" data-bs-toggle="tab" data-bs-target="#inactive-tab-pane" type="button" role="tab">
                 Inactive (<?= count($inactive_audio_books) ?>)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="active-tab" data-bs-toggle="tab" data-bs-target="#active-tab-pane" type="button" role="tab">
                 Active (<?= count($active_audio_books) ?>)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled-tab-pane" type="button" role="tab">
                 Cancelled (<?= count($cancelled_audio_books) ?>)
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="audioBooksTabContent">
        <!-- Inactive Tab -->
        <div class="tab-pane fade show active" id="inactive-tab-pane" role="tabpanel" aria-labelledby="inactive-tab">
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="zero-config table table-hover" id="inactiveAudioBooksTable" data-page-length="10">
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
                                            <a href="<?= base_url("book/audio_book_chapters/{$book['book_id']}") ?>" title="add and view Chapters" class="action-icon"  style="color: #4da6ff;">
                                                <iconify-icon icon="mdi:book-open-outline" style="font-size: 18px;"></iconify-icon>
                                            </a>

                                            <a href="<?= base_url("adminv3/in_progress_edit_book/{$book['book_id']}") ?>" title="Edit" target="_blank" class="action-icon" style="color: #6cbd7e;">
                                                <iconify-icon icon="mdi:square-edit-outline" style="font-size: 18px;"></iconify-icon>
                                            </a>

                                            <a href="#" onclick="add_to_test(<?= $book['book_id'] ?>)" title="Add to Test" class="action-icon" style="color: #9d7ad6;">
                                                <iconify-icon icon="mdi:flask-outline" style="font-size: 18px;"></iconify-icon>
                                            </a>

                                            <a href="<?= base_url("book/activate_book_page/{$book['book_id']}") ?>" title="Activate" class="action-icon" style="color: #4cc9b4;">
                                                <iconify-icon icon="mdi:check-circle-outline" style="font-size: 18px;"></iconify-icon>
                                            </a>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Active Tab -->
        <div class="tab-pane fade" id="active-tab-pane" role="tabpanel" aria-labelledby="active-tab">
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="zero-config table table-hover" id="activeAudioBooksTable" data-page-length="10">
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
                                      <!-- Plain Action Icons -->
                                        <a href="<?= base_url("adminv3/audio_book_chapters/{$book['book_id']}") ?>" title="Chapters" class="action-icon" style="color: #4da6ff;">
                                            <iconify-icon icon="mdi:book-open-outline" style="font-size: 20px;"></iconify-icon> <!-- Blue -->
                                        </a>

                                        <a href="<?= base_url("adminv3/in_progress_edit_book/{$book['book_id']}") ?>" title="Edit" target="_blank" class="action-icon" style="color: #6cbd7e;" >
                                            <iconify-icon icon="mdi:square-edit-outline" style="font-size: 20px;"></iconify-icon> <!-- Green -->
                                        </a>

                                        <a href="#" onclick="add_to_test(<?= $book['book_id'] ?>)" title="Add to Test" class="action-icon" style="color: #9d7ad6;">
                                            <iconify-icon icon="mdi:flask-outline" style="font-size: 20px;"></iconify-icon> <!-- Purple -->
                                        </a>

                                        <a href="#" onclick="pause_book(<?= $book['book_id'] ?>)" title="Cancel" class="action-icon" style="color: #bb0e2e;">
                                            <iconify-icon icon="mdi:alpha-x-circle" style="font-size: 20px;"></iconify-icon>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Cancelled Tab -->
        <div class="tab-pane fade" id="cancelled-tab-pane" role="tabpanel" aria-labelledby="cancelled-tab">
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="zero-config table table-hover" id="cancelledAudioBooksTable" data-page-length="10">
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
        </div>
    </div>
    <br>

    <!-- Graph -->
    <center><h6 class="mt-4">Month-wise Activated Books</h6></center>
<div id="monthly_activated_books" style="height: 350px;"></div>

<div class="page-header">
    <div class="page-title">
        <div class="mt-3 row">
            <div class="col-10">
                <p class="mb-4">Audio Books Active (Total: <?= sizeof($active_audio_books) ?>)</p>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/lib/apexcharts.min.js') ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var graph_options = {
            chart: {
                type: 'area',
                height: 350,
                stacked: false,
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: true,
                        zoom: true,
                        pan: true,
                        reset: true
                    }
                },
                zoom: {
                    enabled: true
                }
            },
            colors: ['#ff5757'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            series: [{
                name: "Books Activated",
                data: <?= $graph_cnt_data ?>
            }],
            xaxis: {
                categories: <?= $graph_date_data ?>,
                labels: {
                    style: {
                        colors: '#666',
                        fontSize: '12px'
                    }
                },
                axisBorder: {
                    show: true,
                    color: '#eee'
                },
                axisTicks: {
                    show: true,
                    color: '#eee'
                }
            },
            yaxis: {
                min: 0,
                labels: {
                    style: {
                        colors: '#666',
                        fontSize: '12px'
                    },
                    formatter: function(val) {
                        return Math.floor(val);
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.3,
                    stops: [0, 100]
                }
            },
            tooltip: {
                enabled: true,
                y: {
                    formatter: function(val) {
                        return val + " books";
                    }
                }
            },
            grid: {
                borderColor: '#eee',
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            }
        };

        var graph_chart = new ApexCharts(document.querySelector("#monthly_activated_books"), graph_options);
        graph_chart.render();
    });

    // Initialize DataTables when tab is shown
    $(document).ready(function() {
        // Initialize all tables
        $('#inactiveAudioBooksTable').DataTable();
        $('#activeAudioBooksTable').DataTable();
        $('#cancelledAudioBooksTable').DataTable();

        // Reinitialize DataTable when tab is shown to ensure proper rendering
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        });
    });
</script>
<?= $this->endSection(); ?>