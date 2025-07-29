<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>
<div class="container py-2">
  <!-- Search Header -->
  <div class="col-12">
    <div class="p-16 bg-info-50 radius-8 border-start-width-3-px border-info border-top-0 border-end-width-3-px border-bottom-0">
      <p class="text-muted">Find users by ID, email or phone</p>

    <form action="<?= base_url('user/getuserdetails') ?>" method="post">
    <?= csrf_field() ?>
        <div class="input-group mb-3">
          <span class="input-group-text bg-light">
            <iconify-icon icon="carbon:user-search"></iconify-icon>
          </span>
          <input id="t-text" onchange="format_email()" type="text" name="identifier" 
                 placeholder="Enter User Id, Email or Phone" 
                 class="form-control" required>
        </div>
        <div class="d-flex justify-content-center">
          <button type="submit" class="btn btn-primary-400 text-white rounded-pill px-20 py-11">
            Search User
          </button>
        </div>
      </form>
    </div>
  </div>
  <br>

  <!-- Cards -->
  <div class="col-12">
    <div class="card radius-12 shadow-none border">
        <div class="card-body p-16">
            <div class="row gy-4">
                <?php 
                $percentAddress = $total_registration > 0 ? ($users_with_address / $total_registration) * 100 : 0;
                $percentPhone   = $total_registration > 0 ? ($users_with_phone / $total_registration) * 100 : 0;
                $percentOtp     = $total_registration > 0 ? ($users_with_otp / $total_registration) * 100 : 0;
                $percentGoogle  = $total_registration > 0 ? ($users_with_google / $total_registration) * 100 : 0;
                ?>

                <div class="col-xxl-3 col-xl-4 col-sm-6">
                    <div class="card shadow-none border bg-gradient-start-1 h-100">
                        <div class="card-body p-20">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div>
                                    <p class="fw-medium text-primary-light mb-1">Users With Address</p>
                                    <h6 class="mb-0"><?= $users_with_address ?> users</h6>
                                </div>
                                <div class="w-50-px h-50-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
                                    <iconify-icon icon="ri:map-pin-line" class="text-white text-2xl mb-0"></iconify-icon>
                                </div>
                            </div>
                            <div class="progress h-8-px w-100 bg-primary-50 mt-12 mb-2" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?= round($percentAddress, 1) ?>">
                                <div class="progress-bar animated-bar rounded-pill bg-primary-600" style="width: <?= round($percentAddress, 1) ?>%"></div>
                            </div>
                            <p class="fw-medium text-sm text-primary-light mb-0 d-flex align-items-center gap-2">
                                <?= round($percentAddress, 1) ?>% from total users
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-sm-6">
                    <div class="card shadow-none border bg-gradient-start-2 h-100">
                        <div class="card-body p-20">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div>
                                    <p class="fw-medium text-primary-light mb-1">Users With Phone</p>
                                    <h6 class="mb-0"><?= $users_with_phone ?> users</h6>
                                </div>
                                <div class="w-50-px h-50-px bg-purple rounded-circle d-flex justify-content-center align-items-center">
                                    <iconify-icon icon="ri:phone-line" class="text-white text-2xl mb-0"></iconify-icon>
                                </div>
                            </div>
                            <div class="progress h-8-px w-100 bg-lilac-100 mt-12 mb-2" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?= round($percentPhone, 1) ?>">
                                <div class="progress-bar animated-bar rounded-pill bg-lilac-600" style="width: <?= round($percentPhone, 1) ?>%"></div>
                            </div>
                            <p class="fw-medium text-sm text-primary-light mb-0 d-flex align-items-center gap-2">
                                <?= round($percentPhone, 1) ?>% from total users
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-sm-6">
                    <div class="card shadow-none border bg-gradient-start-3 h-100">
                        <div class="card-body p-20">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div>
                                    <p class="fw-medium text-primary-light mb-1">Users With OTP</p>
                                    <h6 class="mb-0"><?= $users_with_otp ?> users</h6>
                                </div>
                                <div class="w-50-px h-50-px bg-info rounded-circle d-flex justify-content-center align-items-center">
                                    <iconify-icon icon="ri:shield-keyhole-line" class="text-white text-2xl mb-0"></iconify-icon>
                                </div>
                            </div>
                            <div class="progress h-8-px w-100 bg-success-100 mt-12 mb-2" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?= round($percentOtp, 1) ?>">
                                <div class="progress-bar animated-bar rounded-pill bg-success-600" style="width: <?= round($percentOtp, 1) ?>%"></div>
                            </div>
                            <p class="fw-medium text-sm text-primary-light mb-0 d-flex align-items-center gap-2">
                                <?= round($percentOtp, 1) ?>% from total users
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-sm-6">
                    <div class="card shadow-none border bg-gradient-start-4 h-100">
                        <div class="card-body p-20">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div>
                                    <p class="fw-medium text-primary-light mb-1">Users With Google</p>
                                    <h6 class="mb-0"><?= $users_with_google ?> users</h6>
                                </div>
                                <div class="w-50-px h-50-px bg-success-main rounded-circle d-flex justify-content-center align-items-center">
                                    <iconify-icon icon="ri:google-fill" class="text-white text-2xl mb-0"></iconify-icon>
                                </div>
                            </div>
                            <div class="progress h-8-px w-100 bg-warning-100 mt-12 mb-2" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?= round($percentGoogle, 1) ?>">
                                <div class="progress-bar animated-bar rounded-pill bg-warning-600" style="width: <?= round($percentGoogle, 1) ?>%"></div>
                            </div>
                            <p class="fw-medium text-sm text-primary-light mb-0 d-flex align-items-center gap-2">
                                <?= round($percentGoogle, 1) ?>% from total users
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

  <!-- Daily Login Summary -->
  <div class="col-lg-12 mt-4">
    <div class="card">
      <div class="card-header py-16 px-24 bg-base border border-end-0 border-start-0 border-top-0">
        <h5 class="card-title mb-0">Daily Login Summary (Last 7 Days)</h5>
      </div>
      <div class="card-body">
        <?php if (!empty($login_summary)) : ?>
          <?php
            $summary_data = [];
            foreach ($login_summary as $item) {
              $date = $item['login_date'];
              $type = $item['login_type'];
              $count = $item['login_count'];

              if (!isset($summary_data[$date])) {
                $summary_data[$date] = [
                  'email_with_google' => 0,
                  'email_with_password' => 0,
                  'mobile_with_otp' => 0,
                  'total' => 0
                ];
              }

              $summary_data[$date][$type] = $count;
              $summary_data[$date]['total'] += $count;
            }
            krsort($summary_data);
          ?>

          <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
            <table class="table vertical-striped-table mb-0 text-center align-middle">
              <thead class="sticky-top bg-primary-100">
                <tr>
                  <th>Date</th>
                  <th>Email with Google</th>
                  <th>Email with Password</th>
                  <th>Mobile with OTP</th>
                  <th>Total Logins</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($summary_data as $date => $counts): ?>
                  <tr>
                    <td>
                      <h6 class="text-md mb-0 fw-normal"><?= date('d M Y', strtotime($date)); ?></h6>
                      <span class="text-sm text-secondary-light fw-normal"><?= date('l', strtotime($date)); ?></span>
                    </td>
                    <td>
                      <span class="bg-info-100 text-info-600 px-3 py-1 rounded-pill fw-medium text-sm"><?= $counts['email_with_google']; ?></span>
                    </td>
                    <td>
                      <span class="bg-warning-100 text-warning-700 px-3 py-1 rounded-pill fw-medium text-sm"><?= $counts['email_with_password']; ?></span>
                    </td>
                    <td>
                      <span class="bg-success-100 text-success-700 px-3 py-1 rounded-pill fw-medium text-sm"><?= $counts['mobile_with_otp']; ?></span>
                    </td>
                    <td>
                      <span class="bg-primary-100 text-primary-700 px-4 py-1 rounded-pill fw-semibold"><?= $counts['total']; ?></span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php else : ?>
          <p class="text-center my-3">No login data found for the last 7 days.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Login Users Table -->
  <div class="col-lg-12 mt-4">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0 text-center">Login Users - Last 7 Days</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
          <table class="table basic-border-table table-bordered table-hover text-center align-middle mb-0">
            <thead class="table-light" style="position: sticky; top: 0; z-index: 1;">
              <tr>
                <th>Sl.No</th>
                <th>User ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>OTP</th>
                <th>Email</th> 
                <th>Channel</th>
                <th>User Type</th> 
                <th>Login Date</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($login_users)) : ?>
                <?php foreach ($login_users as $index => $user) : ?>
                  <tr>
                    <td><?= $index + 1; ?></td>
                    <td><?= esc($user['user_id']); ?></td>
                    <td><?= esc($user['username']); ?></td>
                    <td><?= esc($user['phone']); ?></td>
                    <td><?= esc($user['otp']); ?></td>
                    <td><?= esc($user['email']); ?></td>
                    <td><?= esc($user['channel']); ?></td>
                    <td>
                      <?= ($user['user_type'] == 1) ? "Public" : (($user['user_type'] == 2) ? "Author" : "Unknown"); ?>
                    </td>
                    <td><?= date('d M Y, h:i A', strtotime($user['created_at'])); ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else : ?>
                <tr>
                  <td colspan="10">No login users found for the last 7 days.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Summary Cards -->
  <div class="row mt-4 mb-4">
<div class="col-xxl-4 col-sm-6 mb-3">
  <div class="card h-100 radius-12 bg-gradient-success text-center">
    <div class="card-body p-24">
      <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-success-600 text-white mb-16 radius-12">
        <iconify-icon icon="fa6-solid:calendar-day" width="40" height="40"></iconify-icon>
      </div>
      <h5 class="info-heading fw-bold mb-0 fs-6">
        <?= date('M'); ?> : <?= esc($monthly_registration); ?>
      </h5>
    </div>
  </div>
</div>

<!-- Weekly Registration -->
<div class="col-xxl-4 col-sm-6 mb-3">
  <div class="card h-100 radius-12 bg-gradient-danger text-center">
    <div class="card-body p-24">
      <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-danger-600 text-white mb-16 radius-12">
        <iconify-icon icon="fa6-solid:calendar-week" width="40" height="40"></iconify-icon>
      </div>
      <h5 class="info-heading fw-bold mb-0 fs-6">
        Week : <?= esc($weekly_registration); ?>
      </h5>
    </div>
  </div>
</div>

<!-- Total Registration -->
<div class="col-xxl-4 col-sm-6 mb-3">
  <div class="card h-100 radius-12 bg-gradient-primary text-center">
    <div class="card-body p-24">
      <div class="w-64-px h-64-px d-inline-flex align-items-center justify-content-center bg-primary-600 text-white mb-16 radius-12">
        <iconify-icon icon="fa6-solid:calendar" width="40" height="40"></iconify-icon>
      </div>
      <h5 class="info-heading fw-bold mb-0 fs-6">
        Total : <?= esc($total_registration); ?>
      </h5>
    </div>
  </div>
</div>
  </div>

<!-- Yearly Chart Section -->
<div class="col-12 mt-4">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Year Wise Registered Users</h5>
        </div>
        <div class="card-body">
            <div id="zoomAbleLineChart" style="min-height: 350px;"></div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const years = <?= json_encode($year) ?>;
    const userCounts = <?= json_encode($user_registration_cnt) ?>;
    
    if (!Array.isArray(years) || !Array.isArray(userCounts) || years.length === 0) {
        console.error('Invalid chart data:', {years, userCounts});
        document.getElementById('zoomAbleLineChart').innerHTML = 
            '<div class="alert alert-warning">No chart data available</div>';
        return;
    }

    const options = {
        chart: {
            type: 'bar',
            height: 350,
            toolbar: { show: true },
            animations: { enabled: true },
            events: {
                mounted: () => console.log('Chart rendered'),
                error: (err) => {
                    console.error('Chart error:', err);
                    showFallback();
                }
            }
        },
        series: [{
            name: 'Registered Users',
            data: userCounts
        }],
        xaxis: {
            categories: years,
            title: { text: 'Year' },
            labels: { style: { fontSize: '12px' } }
        },
        yaxis: {
            title: { text: 'Number of Users' },
            labels: { formatter: (val) => Math.round(val) }
        },
        colors: ['#6d0fab'],
        plotOptions: {
            bar: {
                borderRadius: 4,
                columnWidth: '70%',
                dataLabels: { position: 'top' }
            }
        },
        dataLabels: {
            enabled: true,
            formatter: (val) => val,
            offsetY: -20,
            style: {
                fontSize: '12px',
                colors: ['#6d0fab']
            }
        },
        tooltip: {
            enabled: true,
            y: { formatter: (val) => `${val} users` }
        }
    };

    try {
        const chart = new ApexCharts(document.querySelector("#zoomAbleLineChart"), options);
        chart.render();
        
        setTimeout(() => {
            if (!document.querySelector("#zoomAbleLineChart .apexcharts-canvas")) {
                showFallback();
            }
        }, 1000);
    } catch (err) {
        console.error('Chart initialization failed:', err);
        showFallback();
    }

    function showFallback() {
        const fallbackHtml = `
            <div class="alert alert-warning">
                Chart could not be displayed. Showing data in table format.
            </div>
            <table class="table table-bordered">
                <thead><tr><th>Year</th><th>Users</th></tr></thead>
                <tbody>
                    ${years.map((year, i) => `
                        <tr>
                            <td>${year}</td>
                            <td>${userCounts[i] || 0}</td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>`;
        document.getElementById('zoomAbleLineChart').innerHTML = fallbackHtml;
    }
});
</script>
<?= $this->endSection(); ?>