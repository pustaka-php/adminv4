<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid py-3">
    <div class="row g-4">
        <!-- Main Book Cards -->
        <div class="col-xxl-3 col-md-6">
            <div class="card p-3 radius-8 shadow-none bg-gradient-dark-start-1 mb-0 h-100">
                <div class="card-body p-0">
    <!-- Title Section -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-0">
        <div class="d-flex align-items-center gap-2 mb-3">
            <span class="mb-0 w-40-px h-40-px bg-base text-green text-xl flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle">
                <i class="ri-progress-1-fill"></i>
            </span>
            <div>
                <span class="mb-0 fw-medium text-secondary-light text-md">In Progress: e-Books</span>
            </div>
        </div>
    </div>

    <!-- Main Count -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-8 mb-3">
        <h6 class="fw-semibold mb-0"><?= $dashboard_data['in_progress_data']['main_cnt'] ?? 0 ?></h6>
         <a href="<?= base_url('book/getebooksstatus') ?>" class="btn btn-white rounded-pill text-info-600 radius-8 px-14 py-6 text-sm border border-info-300">
                    <i class="ri-eye-line me-1 fs-6"></i> View
                </a>
    </div>

    <!-- Status Counts Row -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
               
                <div class="d-flex align-items-center gap-2">
                    <span class="text-secondary-light text-sm">Unallocated:</span>
                    <span class="badge bg-warning text-xs"><?= $dashboard_data['in_progress_data']['unassigned_cnt'] ?? 0 ?></span>
                </div>
            </div>
        </div>
    </div>

            </div>
        </div>

        <div class="col-xxl-3 col-md-6">
            <div class="card p-3 radius-8 shadow-none bg-gradient-dark-start-2 mb-0 h-100">
                <div class="card-body p-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-0">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="mb-0 w-40-px h-40-px bg-base text-blue text-xl flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle">
                                <i class="ri-book-2-fill"></i>
                            </span>
                            <div>
                                <span class="mb-0 fw-medium text-secondary-light text-md">e-Books</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-8 mb-3">
                        <h6 class="mb-0"><?= str_replace(',', '', $dashboard_data['ebook_cnt']) ?></h6>
                         <a href="<?= base_url('book/ebooks') ?>" class="btn btn-white rounded-pill text-info-600 radius-8 px-14 py-6 text-sm border border-info-300">
                            <i class="ri-eye-line me-1"></i> View
                        </a>
                    </div>

                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-8">
                        <div>
                            <?php
                                // Get current and previous month names
                                $currentMonthName = date('F'); 
                                $previousMonthName = date('F', strtotime('-1 month'));
                                ?>

                                <span class="badge bg-primary text-xs">
                                    <?= $currentMonthName ?>: <?= $dashboard_data['ebook_current_cnt'] ?>
                                </span>
                                <span class="badge bg-primary text-xs">
                                    <?= $previousMonthName ?>: <?= $dashboard_data['ebook_previous_cnt'] ?>
                                </span>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-md-6">
            <div class="card p-3 radius-8 shadow-none bg-gradient-dark-start-3 mb-0 h-100">
                <div class="card-body p-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-0">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="mb-0 w-40-px h-40-px bg-base text-purple text-xl flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle">
                                <i class="ri-headphone-fill"></i>
                            </span>
                            <div>
                                <span class="mb-0 fw-medium text-secondary-light text-md">Audio Books</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-8 mb-3">
                        <h6 class="fw-semibold mb-0"><?= $dashboard_data['audiobook_cnt'] ?></h6>
                        <a href="<?= base_url('book/audiobookdashboard') ?>" class="btn btn-white rounded-pill text-info-600 radius-8 px-14 py-6 text-sm border border-info-300">
                            <i class="ri-eye-line me-1"></i> View
                        </a>
                    </div>

                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-8">
                        <div>
                            <?php
                                // Get current and previous month names
                                $currentMonthName = date('F'); 
                                $previousMonthName = date('F', strtotime('-1 month'));
                                ?>
                            <span class="badge bg-primary text-xs"><?= $currentMonthName ?>: <?= $dashboard_data['audio_book_current_cnt'] ?></span>
                            <span class="badge bg-primary text-xs"><?= $previousMonthName ?>: <?= $dashboard_data['audio_book_previous_cnt'] ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-md-6">
            <div class="radius-8 h-100 text-center p-20 bg-success-100">
                <div class="card-body p-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-0">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="mb-0 w-40-px h-40-px bg-base text-purple text-xl flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle">
                                <i class="ri-book-open-line"></i>
                            </span>
                            <div>
                                <span class="mb-0 fw-medium text-secondary-light text-md">Paper Back</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-8 mb-3">
                        <h6 class="fw-semibold mb-0"><?= $dashboard_data['paper_back_cnt'] ?></h6>
                        <a href="<?= base_url('book/paperbacksummary') ?>" class="btn btn-white rounded-pill text-info-600 radius-8 px-14 py-6 text-sm border border-info-300">
                            <i class="ri-eye-line me-1"></i> View
                        </a>
                    </div>

                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-8">
                        <div>
                            <?php
                                // Get current and previous month names
                                $currentMonthName = date('F'); 
                                $previousMonthName = date('F', strtotime('-1 month'));
                                ?>
                            <span class="badge bg-primary text-xs"><?= $currentMonthName ?>:<?= $dashboard_data['paper_back_current_cnt'] ?? 0 ?></span>
                           <span class="badge bg-primary text-xs"><?= $previousMonthName ?>: <?= $dashboard_data['paper_back_previous_cnt'] ?? 0 ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Cards -->
<div class="col-xxl-3 col-md-6">
    <div class="card p-3 radius-8 shadow-none bg-gradient-dark-start-1 mb-0 h-100">
        <div class="card-body p-0">
            <!-- Title Section -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-0">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="mb-0 w-40-px h-40-px bg-base text-green text-xl flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle">
                        <i class="ri-progress-1-fill"></i>
                    </span>
                    <div>
                        <span class="mb-0 fw-medium text-secondary-light text-md">In Progress: Paperback</span>
                    </div>
                </div>
            </div>

    <!-- Main Count -->
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-8 mb-3">
                <h6 class="fw-semibold mb-0"><?= $dashboard_data['paperback_data']['main_cnt'] ?? 0 ?></h6>
                <a href="<?= base_url('book/paperbackdashboard') ?>" class="btn btn-white rounded-pill text-info-600 radius-8 px-14 py-6 text-sm border border-info-300">
                    <i class="ri-eye-line me-1"></i> View
                </a>
            </div>

            <!-- Status Counts Row -->
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="text-secondary-light text-sm">Unallocated:</span>
                    <span class="badge bg-warning text-xs"><?= $dashboard_data['paperback_data']['unassigned_cnt'] ?? 0 ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
        <div class="col-xxl-3 col-md-6">
            <div class="card p-3 radius-8 shadow-none bg-gradient-dark-start-2 mb-0 h-100">
                <div class="card-body p-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-0">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="mb-0 w-40-px h-40-px bg-base text-purple text-xl flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle">
                                <i class="ri-book-2-line"></i>
                            </span>
                            <div>
                                <span class="mb-0 fw-medium text-secondary-light text-md">e-Book Status</span>
                            </div>
                        </div>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item bg-transparent px-0 py-2 border-0 d-flex justify-content-between align-items-center">
                            <span class="text-secondary-light text-sm">Inactive</span>
                            <span class="badge bg-purple text-xs">
                                <?= isset($dashboard_data['e_book_inactive_books']) ? number_format((int)$dashboard_data['e_book_inactive_books']) : '0' ?>
                            </span>
                        </li>
                        <li class="list-group-item bg-transparent px-0 py-2 border-0 d-flex justify-content-between align-items-center">
                            <span class="text-secondary-light text-sm">Cancelled</span>
                            <span class="badge bg-purple text-xs">
                                <?= isset($dashboard_data['e_book_cancelled_books']) ? number_format((int)$dashboard_data['e_book_cancelled_books']) : '0' ?>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-md-6">
            <div class="card p-3 radius-8 shadow-none bg-gradient-dark-start-3 mb-0 h-100">
                <div class="card-body p-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-0">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="mb-0 w-40-px h-40-px bg-base text-purple text-xl flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle">
                                <i class="ri-headphone-line"></i>
                            </span>
                            <div>
                                <span class="mb-0 fw-medium text-secondary-light text-md">Audio Book Status</span>
                            </div>
                        </div>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item bg-transparent px-0 py-1 border-0 d-flex justify-content-between align-items-center">
                            <span class="text-secondary-light text-sm">Inactive</span>
                            <span class="badge bg-primary text-xs"><?= $dashboard_data['audio_book_inactive_books'] ?></span>
                        </li>
                        <li class="list-group-item bg-transparent px-0 py-1 border-0 d-flex justify-content-between align-items-center">
                            <span class="text-secondary-light text-sm">Cancelled</span>
                            <span class="badge bg-primary text-xs"><?= $dashboard_data['audio_book_cancelled_books'] ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-md-6">
            <div class="radius-8 h-100 text-center p-20 bg-success-100">
                <div class="card-body p-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-0">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="mb-0 w-40-px h-40-px bg-base text-purple text-xl flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle">
                                <i class="ri-book-open-line"></i>
                            </span>
                            <div>
                                <span class="mb-0 fw-medium text-secondary-light text-md">Paper Back Status</span>
                            </div>
                        </div>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item bg-transparent px-0 py-1 border-0 d-flex justify-content-between align-items-center">
                            <span class="text-secondary-light text-sm">Inactive</span>
                            <span class="badge bg-success text-xs"><?= $dashboard_data['paper_back_inactive_cnt'] ?></span>
                        </li>
                        <li class="list-group-item bg-transparent px-0 py-1 border-0 d-flex justify-content-between align-items-center">
                            <span class="text-secondary-light text-sm">Cancelled</span>
                            <span class="badge bg-success text-xs"><?= $dashboard_data['paper_back_cancelled_cnt'] ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Book Availability Table -->
    <div class="container my-5">
        <h6 class="text-center fw-bold mb-4">Book & Audio Book Availability</h6>
        
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs mb-4 justify-content-center" id="bookTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="ebook-tab" data-bs-toggle="tab" data-bs-target="#ebook-tab-pane" type="button" role="tab">e-Books</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="audiobook-tab" data-bs-toggle="tab" data-bs-target="#audiobook-tab-pane" type="button" role="tab">Audio Books</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="paperback-tab" data-bs-toggle="tab" data-bs-target="#paperback-tab-pane" type="button" role="tab">Paperback Books</button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="bookTabsContent">
            <!-- E-Book Tab -->
        <div class="tab-pane fade show active" id="ebook-tab-pane" role="tabpanel">
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>Languages</th>
                            <th>Pustaka</th>
                            <th>Amazon</th>
                            <th>Scribd</th>
                            <th>StoryTel</th>
                            <th>GoogleBooks</th>
                            <th>Overdrive</th>
                            <th>Pratilipi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Use language_name to match model keys
                        $languages = ['Tamil', 'Kannada', 'Telugu', 'Malayalam', 'English'];
                        
                        $row_index = 0;
                        
                        foreach ($languages as $lang) {
                            $bg_class = $row_index % 2 ? 'table-light' : '';
                            $pus = $dashboard_data["pus_{$lang}_cnt"] ?? 0; // <-- language_name
                            echo "<tr class='{$bg_class}'>";
                            echo "<td class='text-start'>{$lang}</td>";
                            echo "<td>{$pus}</td>";
                            
                            $sources = ['amz', 'scr', 'storytel', 'goog', 'over', 'prat'];
                            foreach ($sources as $src) {
                                $key = "{$src}_{$lang}_cnt"; // <-- language_name
                                if (!isset($dashboard_data[$key])) {
                                    echo "<td><span class='text-muted'>--</span></td>";
                                } else {
                                    $val = $dashboard_data[$key];
                                    $percent = ($pus > 0) ? number_format($val / $pus * 100, 1) : 0;
                                    $color = $percent >= 75 ? "text-success" : ($percent >= 40 ? "text-warning" : "text-danger");
                                    echo "<td>{$val} <small class='{$color}'>({$percent}%)</small></td>";
                                }
                            }
                            echo "</tr>";
                            $row_index++;
                        }
                        ?>

                        <tr class="table-info">
                            <td>Details</td>
                            <?php
                            $details = [
                                'pustaka' => 'Pustaka',
                                'amazon' => 'Amazon',
                                'scribd' => 'Scribd',
                                'storytel' => 'StoryTel',
                                'google' => 'GoogleBooks',
                                'overdrive' => 'Overdrive',
                                'pratilipi' => 'Pratilipi'
                            ];

                            $btn_colors = ['primary', 'secondary', 'info', 'danger', 'success', 'warning', 'dark'];
                            $i = 0;

                            foreach ($details as $slug => $label) {
                                $url = base_url() . "book/{$slug}details";
                                $btn = $btn_colors[$i % count($btn_colors)];
                               echo "<td><a href='{$url}' target='_blank' rel='noopener noreferrer' class='btn btn-sm btn-{$btn}'><i class='fas fa-eye'></i></a></td>";
                                $i++;
                            }
                            ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


          <div class="tab-pane fade" id="audiobook-tab-pane" role="tabpanel">
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
                            <td><?= ($pus_cnt > 0) ? $pus_cnt : "-" ?></td>

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
        </div>
        <!-- paperback books -->
        <div class="tab-pane fade" id="paperback-tab-pane" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center align-middle">
                                <thead class="table-info">
                                    <tr>
                                        <th>Languages</th>
                                        <th>Pustaka</th>
                                        <th>Amazon</th>
                                        <th>Flipkart</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                    $languages = ['Tamil', 'Kannada', 'Telugu', 'Malayalam', 'English'];
                    $row_index = 0;

                    foreach ($languages as $name) { 
                        $bg_class = $row_index % 2 ? 'table-light' : '';
                        $row_index++;

                        // Total Pustaka count
                        $pus_cnt  = $paperback["pus_{$name}_cnt"] ?? 0;

                        // Platform data (published + unpublished)
                        $amazon   = $paperback[$name]['amazon'] ?? ['published'=>0,'unpublished'=>0];
                        $flipkart = $paperback[$name]['flipkart'] ?? ['published'=>0,'unpublished'=>0];
                    ?>
                    <tr class="<?= $bg_class ?>">
                        <td class="text-start"><?= $name ?></td>
                        <td><?= ($pus_cnt > 0) ? $pus_cnt : "-" ?></td>

                        <?php
                        // Amazon
                        $total_amz = $amazon['published'] + $amazon['unpublished'];
                        if ($total_amz > 0) {
                            $percent = ($amazon['published'] / $total_amz) * 100;
                            $percentText = number_format($percent, 1) . '%';
                            $color = $percent >= 75 ? 'text-success' : ($percent >= 40 ? 'text-warning' : 'text-danger');
                            echo "<td>{$amazon['published']}<small class='{$color}'>($percentText)</small></td>";
                        } else {
                            echo "<td><span class='text-muted'>--</span></td>";
                        }

                        // Flipkart
                        $total_flip = $flipkart['published'] + $flipkart['unpublished'];
                        if ($total_flip > 0) {
                            $percent = ($flipkart['published'] / $total_flip) * 100;
                            $percentText = number_format($percent, 1) . '%';
                            $color = $percent >= 75 ? 'text-success' : ($percent >= 40 ? 'text-warning' : 'text-danger');
                            echo "<td>{$flipkart['published']} <small class='{$color}'>($percentText)</small></td>";
                        } else {
                            echo "<td><span class='text-muted'>--</span></td>";
                        }
                        ?>
                    </tr>
                    <?php } ?>


                <!-- Details row -->
                <tr class="table-info">
                    <td>Details</td>
                    <?php
                    $links = [
                        'paperbackdetails',
                        'amazonpaperbackdetails',
                        'flipkartpaperbackdetails'
                    ];
                    $btn_colors = ['primary', 'success', 'warning'];
                    $j = 0;

                    foreach ($links as $slug) {
                        $btn_color = $btn_colors[$j % count($btn_colors)];
                        $url = base_url("book/{$slug}");
                            echo "<td>
                                <a href='{$url}' target='_blank' rel='noopener noreferrer' 
                                class='btn btn-sm btn-{$btn_color}'>
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
</div>

    </div>
</div>

   <!-- Current & Previous Month Published Book Details Buttons -->
    <div class="d-flex justify-content-center gap-3 my-4 flex-wrap">
        <a href="<?= base_url('book/ebookprecurrmonthdetails'); ?>" 
        target="_blank"
        class="btn btn-primary rounded-pill radius-8 px-20 py-11">
            E-Book: Current & Previous Month Published Details
        </a>

        <a href="<?= base_url('book/paperbackprecurrmonthdetails'); ?>" 
        target="_blank"
        class="btn btn-success rounded-pill radius-8 px-20 py-11">
            Paperback: Current & Previous Month Published Details
        </a>
    </div>

</div>

<script>
$(document).ready(function() {
    $('#currentMonthTable, #previousMonthTable').DataTable({
        responsive: true,
        dom: '<"top"f>rt<"bottom"lip><"clear">',
        pageLength: 10
    });
});
</script>

<?= $this->endSection(); ?>