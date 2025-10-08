<div class="navbar-header">
    <div class="row align-items-center justify-content-between">
        <div class="col-auto">
            <div class="d-flex flex-wrap align-items-center gap-4">
                <button type="button" class="sidebar-toggle">
                    <iconify-icon icon="heroicons:bars-3-solid" class="icon text-2xl non-active"></iconify-icon>
                    <iconify-icon icon="iconoir:arrow-right" class="icon text-2xl active"></iconify-icon>
                </button>
                <button type="button" class="sidebar-mobile-toggle">
                    <iconify-icon icon="heroicons:bars-3-solid" class="icon"></iconify-icon>
                </button>
                <form class="navbar-search" action="<?= base_url('adminv4/search') ?>" method="get">
                    <input type="text" name="search" placeholder="Search">
                    <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                </form>

            </div>
        </div>
        <div class="col-auto">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <button type="button" data-theme-toggle class="w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center"></button>
            
                <?php 
                $cancel_count = session()->get('cancel_count') ?? 0;
                $mismatch_count = session()->get('mismatch_count') ?? 0;
                $total_notifications = $cancel_count + $mismatch_count;
                $user_type = session()->get('user_type');
                ?>

                <?php if($user_type == 4): ?>
                <div class="dropdown">
                    <button class="rounded-circle d-flex justify-content-center align-items-center w-40 h-40 bg-neutral-200 border-0"
                            type="button" data-bs-toggle="dropdown" > <!-- Increased button size -->
                        
                        <iconify-icon icon="iconoir:bell" class="text-primary-light text-2xxl"></iconify-icon>

                        <?php if($total_notifications > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border-0"
                                style="font-size:10px; width:18px; height:18px; right:-6px; top:-6px; display:flex; align-items:center; justify-content:center;">
                                <?= esc($total_notifications) ?>
                            </span>
                        <?php endif; ?>
                    </button>

                    <div class="dropdown-menu to-top dropdown-menu-sm shadow-sm border-0 p-0">
                        <div class="py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
                            <div>
                                <h6 class="text-lg text-primary-light fw-semibold mb-2">Notifications</h6>
                            </div>
                            <button type="button" class="hover-text-danger" data-bs-dismiss="dropdown">
                                <iconify-icon icon="radix-icons:cross-1" class="icon text-xl"></iconify-icon>
                            </button>
                        </div>
                        <ul class="to-top-list p-0 m-0 list-unstyled">
                            <?php if($cancel_count > 0): ?>
                                <li>
                                    <a class="dropdown-item text-black px-16 py-8 hover-bg-transparent hover-text-danger d-flex align-items-center gap-3"
                                    href="<?= base_url('user/cancelsubscription') ?>">
                                        <iconify-icon icon="mdi:cancel" class="icon text-xl text-danger"></iconify-icon>
                                        Cancel Requests (<?= esc($cancel_count) ?>)
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if($mismatch_count > 0): ?>
                                <li>
                                    <a class="dropdown-item text-black px-16 py-8 hover-bg-transparent hover-text-warning d-flex align-items-center gap-3"
                                    href="<?= base_url('stock/getmismatchstock') ?>">
                                        <iconify-icon icon="mdi:alert" class="icon text-xl text-warning"></iconify-icon>
                                        Mismatch Alerts (<?= esc($mismatch_count) ?>)
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if($total_notifications == 0): ?>
                                <li>
                                    <span class="dropdown-item text-muted px-16 py-8 small d-block">No new notifications</span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>

                <div class="dropdown">
                    <button class="d-flex justify-content-center align-items-center rounded-circle" type="button" data-bs-toggle="dropdown">
                        <img src="<?= base_url('assets/images/user.png') ?>" alt="image" class="w-40-px h-40-px object-fit-cover rounded-circle">
                    </button>
                    <div class="dropdown-menu to-top dropdown-menu-sm">
                        <div class="py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
                            <div>
                                <h6 class="text-lg text-primary-light fw-semibold mb-2"> <?= esc(session()->get('username') ?? 'Guest') ?></h6>
                                <!-- <span class="text-secondary-light fw-medium text-sm"></span> -->
                            </div>
                            <button type="button" class="hover-text-danger">
                                <iconify-icon icon="radix-icons:cross-1" class="icon text-xl"></iconify-icon>
                            </button>
                        </div>
                        <ul class="to-top-list">
                            <!-- <li>
                                <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3" href="<?= route_to('viewProfile') ?>">
                                    <iconify-icon icon="solar:user-linear" class="icon text-xl"></iconify-icon> My Profile
                                </a>
                            </li> -->
                            <li>
                               <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-danger d-flex align-items-center gap-3"
                                href="<?= base_url('adminv4/logout') ?>">
                                    <iconify-icon icon="lucide:power" class="icon text-xl"></iconify-icon> Log Out
                                </a>

                            </li>
                        </ul>
                    </div>
                </div><!-- Profile dropdown end -->
            </div>
        </div>
    </div>
</div>