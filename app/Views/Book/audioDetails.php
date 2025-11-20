<?php
// Convert data to JSON for charts
$audio_month          = json_encode($audio['audio_month']);
$audio_minutes        = json_encode($audio['audio_monthly_minutes']);
$genre_name           = json_encode($audio['audio_genre_name']);
$genre_minutes        = json_encode($audio['audio_genre_minutes']);
$lang_name            = json_encode($audio['audio_lang_name']);
$lang_cnt             = json_encode($audio['audio_lang_cnt']);
$narr_name            = json_encode($audio['audio_narrator_name']);
$narr_cnt             = json_encode($audio['audio_narrator_cnt']);
$author_name          = json_encode($audio['audio_author_name']);
$author_cnt           = json_encode($audio['audio_author_cnt']);

// Sort authors by book count DESC
$authors = [];
for ($i = 0; $i < count($audio['audio_author_name']); $i++) {
    $authors[] = [
        'name'  => $audio['audio_author_name'][$i],
        'count' => $audio['audio_author_cnt'][$i]
    ];
}
usort($authors, fn($a, $b) => $b['count'] - $a['count']);
?>

<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid py-4">

    <!-- TITLE -->
    <div class="row mb-4">
        <div class="col-12 text-center mb-3">
            <div class="p-3 gradient-deep-2 fw-bold"
            style="font-size: 18px; border-radius: 8px;">
            Total minutes: <?= $dashboard_data['audiobook_minutes']; ?>
            </div>
        </div>

    <!-- GENRE TABLE -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-danger text-center">
                    <h6 class="mb-0">Audio Books by Genre</h6>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-light zero-config">
                        <thead>
                            <tr>
                                <th>Genre Name</th>
                                <th class="text-center">Books</th>
                                <th class="text-center">Minutes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i < count($audio['audio_genre_name']); $i++): ?>
                            <tr>
                                <td><?= $audio['audio_genre_name'][$i] ?></td>
                                <td class="text-center"><?= $audio['audio_genre_cnt'][$i] ?></td>
                                <td class="text-center"><?= $audio['audio_genre_minutes'][$i] ?></td>
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- CHARTS -->
    <div class="row g-4">

        <!-- TOP AUTHORS -->
        <div class="col-lg-6 col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-primary text-center">
                    <h6 class="mb-0">Top Authors</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Author Name</th>
                                <th>Audio Books</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($authors as $author): ?>
                            <tr>
                                <td><?= $author['name'] ?></td>
                                <td><?= $author['count'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- LANGUAGE CHART -->
        <div class="col-lg-6 col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-purple text-center">
                    <h6 class="mb-0">Audio Books by Language</h6>
                </div>
                <div class="card-body">
                    <div id="audio_lang_chart" style="height:300px;"></div>
                </div>
            </div>
        </div>

    </div>

    <br>

    <!-- MONTHLY & NARRATOR -->
    <div class="row g-4">

        <!-- Monthly Minutes -->
        <div class="col-lg-6 col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-info text-center">
                    <h6 class="mb-0">Monthly Uploaded Minutes</h6>
                </div>
                <div class="card-body">
                    <div id="monthly_minutes_chart" style="height:300px;"></div>
                </div>
            </div>
        </div>

        <!-- Top Narrators -->
        <div class="col-lg-6 col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-dark text-center text-white">
                    <h6 class="mb-0">Top Narrators</h6>
                </div>
                <div class="card-body">
                    <div id="narrator_chart" style="height:300px;"></div>
                </div>
            </div>
        </div>

    </div>

</div>


<!-- APEXCHARTS -->


<script>
document.addEventListener("DOMContentLoaded", function() {

    // Language Pie Chart
   new ApexCharts(document.querySelector("#audio_lang_chart"), {
    chart: { 
        type: 'pie', 
        height: 300,
        toolbar: { show: false },
        zoom: { enabled: false }
    },
    labels: <?= $lang_name ?>,
    series: <?= $lang_cnt ?>,
}).render();


    // Monthly Minutes Line Chart
    new ApexCharts(document.querySelector("#monthly_minutes_chart"), {
    chart: { 
        type: 'line', 
        height: 300,
        toolbar: { show: false },
        zoom: { enabled: false }
    },
    series: [{
        name: "Minutes",
        data: <?= $audio_minutes ?>
    }],
    xaxis: { categories: <?= $audio_month ?> }
}).render();


    // Top Narrators Bar Chart
   new ApexCharts(document.querySelector("#narrator_chart"), {
    chart: { 
        type: 'bar', 
        height: 300,
        toolbar: { show: false },
        zoom: { enabled: false }
    },
    series: [{
        name: "Books",
        data: <?= $narr_cnt ?>
    }],
    xaxis: { categories: <?= $narr_name ?> }
}).render();

});
</script>

<?= $this->endSection(); ?>
