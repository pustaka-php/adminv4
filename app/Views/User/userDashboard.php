<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>
<div class="container py-2">
  <!-- Search Header -->
  <div class="col-12">
  <div class="p-16 bg-info-50 radius-8 border-start-width-3-px border-info border-top-0 border-end-width-3-px border-bottom-0">
    <p class="text-muted">Find users by ID, email or phone</p>

    <form action="<?= base_url('user/getUserDetails') ?>" method="post">
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




            <!-- Stats Cards -->
            <div class="col-12">
    <div class="card radius-12">
        <div class="card-body p-16">
            <div class="row gy-4">
                <?php 
                $percentAddress = $total_registration > 0 ? ($users_with_address / $total_registration) * 100 : 0;
                $percentPhone   = $total_registration > 0 ? ($users_with_phone / $total_registration) * 100 : 0;
                $percentOtp     = $total_registration > 0 ? ($users_with_otp / $total_registration) * 100 : 0;
                $percentGoogle  = $total_registration > 0 ? ($users_with_google / $total_registration) * 100 : 0;
                ?>

                <div class="col-xxl-3 col-xl-4 col-sm-6">
                    <div class="px-20 py-16 shadow-none radius-8 h-100 gradient-deep-1 left-line line-bg-primary position-relative overflow-hidden">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                            <div>
                                <span class="mb-2 fw-medium text-secondary-light text-md">Users With Address</span>
                                <h6 class="fw-semibold mb-1"><?= $users_with_address ?> users</h6>
                            </div>
                            <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-2xl mb-12 bg-primary-100 text-primary-600">
                                <i class="ri-map-pin-line"></i>
                            </span>
                        </div>
                        <p class="text-sm mb-0">
                            <span class="bg-<?= ($percentAddress >= 0) ? 'success' : 'danger' ?>-focus px-1 rounded-2 fw-medium text-<?= ($percentAddress >= 0) ? 'success' : 'danger' ?>-main text-sm">
                                <i class="ri-arrow-right-<?= ($percentAddress >= 0) ? 'up' : 'down' ?>-line"></i> 
                                <?= round($percentAddress, 1) ?>%
                            </span> From total users
                        </p>
                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-sm-6">
                    <div class="px-20 py-16 shadow-none radius-8 h-100 gradient-deep-2 left-line line-bg-lilac position-relative overflow-hidden">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                            <div>
                                <span class="mb-2 fw-medium text-secondary-light text-md">Users With Phone</span>
                                <h6 class="fw-semibold mb-1"><?= $users_with_phone ?> users</h6>
                            </div>
                            <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-2xl mb-12 bg-lilac-200 text-lilac-600">
                                <i class="ri-phone-line"></i>
                            </span>
                        </div>
                        <p class="text-sm mb-0">
                            <span class="bg-<?= ($percentPhone >= 0) ? 'success' : 'danger' ?>-focus px-1 rounded-2 fw-medium text-<?= ($percentPhone >= 0) ? 'success' : 'danger' ?>-main text-sm">
                                <i class="ri-arrow-right-<?= ($percentPhone >= 0) ? 'up' : 'down' ?>-line"></i> 
                                <?= round($percentPhone, 1) ?>%
                            </span> From total users
                        </p>
                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-sm-6">
                    <div class="px-20 py-16 shadow-none radius-8 h-100 gradient-deep-3 left-line line-bg-success position-relative overflow-hidden">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                            <div>
                                <span class="mb-2 fw-medium text-secondary-light text-md">Users With OTP</span>
                                <h6 class="fw-semibold mb-1"><?= $users_with_otp ?> users</h6>
                            </div>
                            <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-2xl mb-12 bg-success-200 text-success-600">
                                <i class="ri-shield-keyhole-line"></i>
                            </span>
                        </div>
                        <p class="text-sm mb-0">
                            <span class="bg-<?= ($percentOtp >= 50) ? 'success' : 'danger' ?>-focus px-1 rounded-2 fw-medium text-<?= ($percentOtp >= 50) ? 'success' : 'danger' ?>-main text-sm">
                                <i class="ri-arrow-right-<?= ($percentOtp >= 50) ? 'up' : 'down' ?>-line"></i> 
                                <?= round($percentOtp, 1) ?>%
                            </span> From total users
                        </p>
                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-sm-6">
                    <div class="px-20 py-16 shadow-none radius-8 h-100 gradient-deep-4 left-line line-bg-warning position-relative overflow-hidden">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                            <div>
                                <span class="mb-2 fw-medium text-secondary-light text-md">Users With Google</span>
                                <h6 class="fw-semibold mb-1"><?= $users_with_google ?> users</h6>
                            </div>
                            <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-2xl mb-12 bg-warning-focus text-warning-600">
                                <i class="ri-google-fill"></i>
                            </span>
                        </div>
                        <p class="text-sm mb-0">
                            <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">
                                <i class="ri-arrow-right-up-line"></i> 
                                <?= round($percentGoogle, 1) ?>%
                            </span> From total users
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


            <!-- Summary Cards -->
            <div class="row mt-4">
                <div class="col-md-4 mb-3">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area bg-info">
                            <div class="infobox-1">
                                <div class="info-icon">
                                    <iconify-icon icon="fa6-solid:calendar-day" width="50" height="50"></iconify-icon>
                                </div>
                                <h5 class="info-heading mt-3" style="font-weight: 800;">
                                    <?= date('M'); ?> : <?= $monthly_registration; ?>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-3">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area bg-danger">
                            <div class="infobox-1">
                                <div class="info-icon">
                                    <iconify-icon icon="fa6-solid:calendar-week" width="50" height="50"></iconify-icon>
                                </div>
                                <h5 class="info-heading mt-3" style="font-weight: 800;">
                                    <?= date('Y'); ?> : <?= $yearly_registration; ?>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-3">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area bg-success">
                            <div class="infobox-1">
                                <div class="info-icon">
                                    <iconify-icon icon="fa6-solid:calendar" width="50" height="50"></iconify-icon>
                                </div>
                                <h5 class="info-heading mt-3" style="font-weight: 800;">
                                    Total : <?= $total_registration; ?>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Login Summary -->
            <h4 class="text-center my-4">Daily Login Summary (Last 7 Days)</h4>

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
                    <table class="table table-bordered table-striped text-center align-middle">
                        <thead class="table-dark sticky-top">
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
                                    <td><?= date('d M Y', strtotime($date)); ?></td>
                                    <td><span class="badge bg-primary"><?= $counts['email_with_google']; ?></span></td>
                                    <td><span class="badge bg-warning text-dark"><?= $counts['email_with_password']; ?></span></td>
                                    <td><span class="badge bg-success"><?= $counts['mobile_with_otp']; ?></span></td>
                                    <td><strong><?= $counts['total']; ?></strong></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <p class="text-center">No login data found for the last 7 days.</p>
            <?php endif; ?>

            <!-- Recent Logins Table -->
            <h5 class="text-center my-4 moving-text" style="font-weight: 600; color: #333;">
                Login Users - Last 7 Days
            </h5>

            <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                <table class="table table-bordered table-hover text-center align-middle">
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
                        <?php foreach ($login_users as $index => $user) { ?>
                            <tr>
                                <td><?= $index + 1; ?></td>
                                <td><?= $user['user_id']; ?></td>
                                <td><?= htmlspecialchars($user['username']); ?></td>
                                <td><?= $user['phone']; ?></td>
                                <td><?= $user['otp']; ?></td>
                                <td><?= $user['email']; ?></td>
                                <td><?= $user['channel']; ?></td>
                                <td>
                                    <?= ($user['user_type'] == 1) ? "Public" : (($user['user_type'] == 2) ? "Author" : "Unknown"); ?>
                                </td>
                                <td><?= date('d M Y, h:i A', strtotime($user['created_at'])); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Yearly Chart -->
            <h4 class="text-center mt-5">Year Wise Registered Users</h4>
            <div class="col-12 mt-3">
                <div id="user_yearly"></div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    var options = {
        chart: {
            type: 'area',
            stacked: true,
            height: 300,
            toolbar: {
                tools: {
                    download: false
                }
            }
        },
        colors: ['#6d0fab'],
        dataLabels: {
            enabled: false
        },
        series: [{
            name: 'Users Registered',
            data: <?= json_encode($user_registration_cnt); ?>,
        }],
        xaxis: {
            categories: <?= json_encode($year); ?>
        }
    }
    var chart = new ApexCharts(document.querySelector("#user_yearly"), options);
    chart.render();
</script>

<script>
    function format_email() {
        var curr_str = document.getElementById("t-text").value;
        if (curr_str.includes("<") && curr_str.includes(">")) {
            var final_str = curr_str.split('<').pop().split('>')[0];
            document.getElementById("t-text").value = final_str;
        }
    }
</script>
<?= $this->endSection(); ?>