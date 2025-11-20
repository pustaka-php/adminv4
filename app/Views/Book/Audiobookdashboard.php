<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>
 <a href="<?= base_url('book/bookdashboard'); ?>" 
           class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>

<?php
function calculateTrend($data) {
    $count = count($data);
    if ($count < 2) return null;
    $last = $data[$count - 1];
    $prev = $data[$count - 2];
    if ($prev == 0) return null;
    return round((($last - $prev) / $prev) * 100, 1);
}

$colors = ["#FF9F29", "#487FFF", "#45B369", "#9935FE", "#FF6384", "#36A2EB", "#FFCE56", "#9C27B0", "#00BCD4"];

$active_audio_books = $audio_books_dashboard_data['active_audio_books'];
$inactive_audio_books = $audio_books_dashboard_data['inactive_audio_books'];
$cancelled_audio_books = $audio_books_dashboard_data['cancelled_audio_books'];

$graph_cnt_data = json_encode($audio_books_dashboard_data['graph_data']['activated_cnt']);
$graph_date_data = json_encode($audio_books_dashboard_data['graph_data']['activated_date']);
?>

<div class="container">
    <!-- 🔹 All three buttons in one right-aligned row -->
    <div class="d-flex justify-content-end align-items-center gap-2 my-3 p-3 rounded shadow-sm">
        
        <a href="<?= base_url('narrator/narratordashboard'); ?>" 
           class="btn rounded-pill btn-primary-600 radius-8 px-20 py-11">
            Narrators
        </a>

        <a href="<?= base_url('book/addaudiobook'); ?>" 
           class="btn rounded-pill btn-success-600 radius-8 px-20 py-11">
            Add Audio Book
        </a>

    </div>
</div>



    <!-- Charts Row -->
    <div class="row mt-4">
        <div class="col-md-7">
            <h6>Genre Wise Books</h6>
            <div id="genreBar" style="height: 350px;"></div>
        </div>
        <div class="col-md-5">
            <h6>Category Wise Books</h6>
            <div id="categoryBar" style="height: 350px;"></div>
        </div>
    </div>

    <!-- Language Chart + Author Table -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card h-100 radius-8 border-0">
                <div class="card-body p-22">
                    <h6 class="mb-2 fw-bold small text-center">Language Wise Books</h6><br> 
                    <div id="languageDonutChart" style="height: 250px;"></div>
                    <?php if (!empty($languageData)): ?>
                        <ul class="list-group list-group-flush mt-2">
                            <?php foreach ($languageData as $index => $lang): ?>
                               <li style="text-align: center;">
                                    <div class="d-flex align-items-center gap-2 small">
                                        <span class="badge rounded-pill" style="background-color: <?= esc($colors[$index % count($colors)]) ?>;">&nbsp;</span>
                                        <?= esc($lang['language_name']) ?>
                                   
                                    <span class="fw-bold small"><?= esc($lang['total_books']) ?></span>
                                     </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="text-center text-muted p-2 small">No language data available</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <h6>Author Wise Books</h6>
            <table class="table table-hover table-light zero-config">
                <thead>
                    <tr><th>Author Name</th><th>Total Books</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($authorData as $row): ?>
                        <tr><td><?= esc($row['author_name']) ?></td><td><?= esc($row['total']) ?></td></tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <br>
    <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-success">
                            <tr>
                                <th>Languages</th>
                                <th>Pustaka</th>
                                <th>Overdrive</th>
                                <th>GoogleBooks</th>
                                <th>StoryTel</th>
                                <th>Audible</th>
                                <th>KukuFM</th>
                                <th>YouTube</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $languages = [
                                'tml' => 'Tamil', 
                                'kan' => 'Kannada', 
                                'tel' => 'Telugu', 
                                'mlylm' => 'Malayalam', 
                                'eng' => 'English'
                            ];

                            $row_index = 0;
                            
                            foreach ($languages as $code => $name) { 
                                $bg_class = $row_index % 2 ? 'table-light' : '';
                                $pus_cnt = $dashboard["pus_{$code}_cnt"] ?? 0;
                                $row_index++;
                            ?>
                            <tr class="<?= $bg_class ?>">
                                <td class="text-start"><?= $name ?></td>
                                <td class="fw-bold"><?= ($pus_cnt > 0) ? $pus_cnt : "-" ?></td>

                                <?php
                                $platforms = ['over' => 'Overdrive', 'goog' => 'GoogleBooks', 'storytel' => 'StoryTel', 'aud' => 'Audible', 'ku' => 'KukuFM', 'you' => 'YouTube'];
                                foreach ($platforms as $prefix => $label) {
                                    $val = $dashboard["{$prefix}_{$code}_cnt"] ?? 0;
                                    if ($val > 0 && $pus_cnt > 0) {
                                        $percent = ($val / $pus_cnt) * 100;
                                        $percentText = number_format($percent, 1) . '%';
                                        $color = $percent >= 75 ? 'text-success' : ($percent >= 40 ? 'text-warning' : 'text-danger');
                                        echo "<td>{$val} <small class='{$color}'>($percentText)</small></td>";
                                    } else {
                                        echo "<td><span class='text-muted'>--</span></td>";
                                    }
                                }
                                ?>
                            </tr>
                            <?php } ?>

                            <tr class="table-info">
                                <td>Details</td>
                                <?php
                                $links = [
                                   'audiodetails',
                                    'overdriveudiobookdetails',
                                    'googleaudiodetails',
                                    'storytelaudiodetails',
                                    'audibledetails',
                                    'kukufmdetails',
                                    'youtubedetails'
                                ];
                                $btn_colors = ['primary', 'info', 'success', 'danger', 'warning', 'dark', 'secondary'];
                                $j = 0;

                                foreach ($links as $slug) {
                                    $btn_color = $btn_colors[$j % count($btn_colors)];
                                    $url = base_url() . "book/" . $slug;
                                    echo "<td>
                                            <a href='{$url}' target='_blank' rel='noopener noreferrer' class='btn btn-sm btn-{$btn_color}'>
                                                <i class='fas fa-eye'></i>
                                            </a>
                                          </td>";
                                    $j++;
                                }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <?php
        $cards = [
            ['Inactive Books', 'bg-warning', count($inactive_audio_books), 'mdi:clock-outline'],
            ['Active Books', 'bg-success', count($active_audio_books), 'mdi:check-circle-outline'],
            ['Cancelled Books', 'bg-danger', count($cancelled_audio_books), 'mdi:cancel']
        ];
        foreach ($cards as $card): ?>
            <div class="col-xxl-4 col-sm-6">
                <div class="card p-3 shadow-2 radius-8 border input-form-light h-100">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mb-0 w-48-px h-48-px <?= $card[1] ?> text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                    <iconify-icon icon="<?= $card[3] ?>" class="icon"></iconify-icon>
                                </span>
                                <div>
                                    <span class="mb-2 fw-medium text-secondary-light fs-5"><?= $card[0] ?></span>
                                    <h6 class="fw-semibold"><?= $card[2] ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-4" id="audioBooksTab" role="tablist">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#active-tab-pane">Active (<?= count($active_audio_books) ?>)</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#inactive-tab-pane">Inactive (<?= count($inactive_audio_books) ?>)</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#cancelled-tab-pane">Cancelled (<?= count($cancelled_audio_books) ?>)</button></li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="audioBooksTabContent">
        <?php
        $tabs = [
            ['active-tab-pane', 'Active Audio Books', $active_audio_books],
            ['inactive-tab-pane', 'Inactive Audio Books', $inactive_audio_books],
            ['cancelled-tab-pane', 'Cancelled Audio Books', $cancelled_audio_books]
        ];
        foreach ($tabs as $index => $tab): ?>
            <div class="tab-pane fade <?= $index == 0 ? 'show active' : '' ?>" id="<?= $tab[0] ?>" role="tabpanel">
                <div class="card shadow-sm">
                    <div class="card-body table-responsive">
                        <table class="zero-config table table-hover" data-page-length="10">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th><th>Book ID</th><th>Title</th><th>Author</th><th>Narrator</th><th>Duration</th>
                                    <?php if ($index == 0 || $index == 1): ?><th>Actions</th><?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tab[2] as $i => $book): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= $book['book_id'] ?></td>
                                        <td><?= $book['book_title'] ?></td>
                                        <td><?= $book['author_name'] ?></td>
                                        <td><?= $book['narrator_name'] ?></td>
                                        <td><?= $book['number_of_page'] ?> mins</td>
                                        <?php if ($index == 0 || $index == 1): ?>
                                            <td class="d-flex gap-2 align-items-center">
    <!-- Add Chapters (Blue) -->
    <a href="<?= base_url("book/audiobookchapters/{$book['book_id']}") ?>" title="Add Chapters">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
            <path fill="#2196f3" d="M21 4H3c-1.1 0-2 .9-2 2v14l4-4h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-2 9H5V11h14v2zm0-4H5V7h14v2z"/>
        </svg>
    </a>

    <!-- Edit Book (Orange) -->
    <a href="<?= base_url("adminv3/in_progress_edit_book/{$book['book_id']}") ?>" title="Edit">
        <svg aria-hidden="true" focusable="false" width="18" height="18" viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg">
            <path fill="#fd7e14" d="M402.3 344.9l32-32c5-5 13.7-1.5 13.7 5.7V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h273.5c7.1 0 10.7 8.6 5.7 13.7l-32 32c-1.5 1.5-3.5 2.3-5.7 2.3H48v352h352V350.5c0-2.1.8-4.1 2.3-5.6zM558.9 143.1L296.3 405.7l-90.4 10c-26.2 2.9-48.5-19.2-45.6-45.6l10-90.4L432.9 17.1c22.9-22.9 59.9-22.9 82.7 0l43.2 43.2c22.9 22.9 22.9 60 .1 82.8z"/>
        </svg>
    </a>

    <!-- Add to Test (Red) -->
    <a href="#" onclick="add_to_test(<?= $book['book_id'] ?>)" title="Add to Test">
         <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
            <path fill="#e7515a" d="M20.759 20.498c-2.342-3.663-5.575-6.958-5.743-11.498h-2.016c.173 5.212 3.512 8.539 5.953 12.356.143.302-.068.644-.377.644h-1.264l-4.734-7h-3.52c.873-1.665 1.85-3.414 1.936-6h-2.01c-.169 4.543-3.421 7.864-5.743 11.498-.165.347-.241.707-.241 1.057 0 1.283 1.023 2.445 2.423 2.445h13.153c1.4 0 2.424-1.162 2.424-2.446 0-.35-.076-.709-.241-1.056zm-4.759-15.498c0 1.105-.896 2-2 2s-2-.895-2-2 .896-2 2-2 2 .895 2 2zm-5-1.5c0 .829-.672 1.5-1.5 1.5s-1.5-.671-1.5-1.5.672-1.5 1.5-1.5 1.5.671 1.5 1.5zm0 3.5c0 .552-.447 1-1 1s-1-.448-1-1 .447-1 1-1 1 .448 1 1zm3-6c0 .552-.447 1-1 1s-1-.448-1-1 .447-1 1-1 1 .448 1 1z"/>
        </svg>
    </a>

    <!-- Activate (Green) -->
    <?php if ($index == 1): ?>
        <a href="<?= base_url("book/activatebookpage/{$book['book_id']}") ?>" title="Activate">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="12" fill="#198754"/>
                <polyline points="6,12 10,16 18,8" fill="none" stroke="#fff" stroke-width="2"/>
            </svg>
        </a>
    <?php endif; ?>
</td>

                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <br>

    <!-- Graph -->
    <center><h6 class="mt-4">Month-wise Activated Books</h6></center>
    <div id="monthly_activated_books" style="height: 350px;"></div>
</div>

<!-- Scripts -->
<script src="<?= base_url('assets/js/lib/apexcharts.min.js') ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Monthly Activated Books
    new ApexCharts(document.querySelector("#monthly_activated_books"), {
        chart: { type: 'area', height: 350, toolbar: { show: true } },
        series: [{ name: "Books Activated", data: <?= $graph_cnt_data ?> }],
        xaxis: { categories: <?= $graph_date_data ?> },
        colors: ['#ff5757'],
        stroke: { curve: 'smooth', width: 2 },
        dataLabels: { enabled: false },
        fill: { type: 'gradient', gradient: { opacityFrom: 0.7, opacityTo: 0.3 } }
    }).render();

    // Language Donut
    <?php if (!empty($languageData)): ?>
    new ApexCharts(document.querySelector("#languageDonutChart"), {
        chart: { type: 'donut', height: 250 },
        series: <?= json_encode(array_map('intval', array_column($languageData, 'total_books'))) ?>,
        labels: <?= json_encode(array_column($languageData, 'language_name')) ?>,
        colors: <?= json_encode($colors) ?>,
    }).render();
    <?php endif; ?>

    // Bar Chart - Genre Wise
    <?php if (!empty($genreData)): ?>
        new ApexCharts(document.querySelector("#genreBar"), {
            chart: { type: 'bar', height: 350 },
            series: [{ name: 'Books', data: <?= json_encode(array_map('intval', array_column($genreData, 'total_books'))) ?> }],
            xaxis: { categories: <?= json_encode(array_column($genreData, 'genre_name')) ?>, labels: { rotate: -45 } },
            colors: ['#1E88E5', '#F4511E', '#43A047', '#8E24AA', '#FFB300'],
            plotOptions: { bar: { borderRadius: 4, horizontal: false } },
            dataLabels: { enabled: false },
            tooltip: { y: { formatter: val => val + ' books' } },
            grid: { strokeDashArray: 3 }
        }).render();
    <?php else: ?>
        document.querySelector("#genreBar").innerHTML = '<div class="text-center text-muted p-4">No genre data available</div>';
    <?php endif; ?>

    // Bar Chart - Category Wise
    <?php if (!empty($categoryData)): ?>
        new ApexCharts(document.querySelector("#categoryBar"), {
            chart: { type: 'bar', height: 350 },
            series: [{ name: 'Books', data: <?= json_encode(array_map('intval', array_column($categoryData, 'total_books'))) ?> }],
            xaxis: { categories: <?= json_encode(array_column($categoryData, 'book_category')) ?>, labels: { rotate: -45 } },
            colors: ['#FF7043', '#66BB6A', '#29B6F6', '#AB47BC', '#FFA726'],
            plotOptions: { bar: { borderRadius: 4, horizontal: false } },
            dataLabels: { enabled: false },
            tooltip: { y: { formatter: val => val + ' books' } },
            grid: { strokeDashArray: 3 }
        }).render();
    <?php else: ?>
        document.querySelector("#categoryBar").innerHTML = '<div class="text-center text-muted p-4">No category data available</div>';
    <?php endif; ?>
});
</script>

<?= $this->endSection(); ?>
