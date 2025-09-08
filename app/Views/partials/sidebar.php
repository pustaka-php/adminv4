<?php
$session = \Config\Services::session();
?>
<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>

    <div>
        <a href="<?= route_to('index') ?>" class="sidebar-logo"> 
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="Light Logo" class="light-logo" width="168" height="40">
            <img src="<?= base_url('assets/images/logo-light.png') ?>" alt="Dark Logo" class="dark-logo">
            <img src="<?= base_url('assets/images/logo-icon.png') ?>" alt="Logo Icon" class="logo-icon">
        </a>
    </div>

    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <?php if (session('user_type') == 7): ?>
                <li>
                    <a href="<?= route_to('tppublisherdashboard') ?>">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                        <span>TP Publisher Dashboard</span>
                    </a>
                </li>
            <?php else: ?>
                <li>
                    <a  href="<?= route_to('user/authorgiftbooks') ?>">
                        <i class="ri-user-settings-line text-xl me-6 d-flex w-auto"></i>
                        <span>  Authors</span>
                    </a>  
                </li>
               
                <li >
                    <a href="<?= route_to('book/bookdashboard') ?>">
                          <iconify-icon icon="mdi:book-open-page-variant-outline" class="menu-icon" style="font-size:25px;"></iconify-icon>
                        <span>Books</span>
                    </a>
                </li>
                <li>
                    <a  href="<?= route_to('user/userdashboard') ?>">
                       <iconify-icon icon="ri:group-line" style="font-size:22px;"class="menu-icon"></iconify-icon>
                        <span>Users</span>
                    </a>  
                </li>

                <li>
                    <a  href="<?= route_to('orders/ordersdashboard') ?>">
                        <iconify-icon icon="majesticons:shopping-cart" style="font-size:22px;" class="menu-icon"></iconify-icon>
                        <span>Orders</span>
                    </a> 
                </li>
                <li>
                    <a  href="<?= route_to('stock/stockdashboard') ?>">
                        <iconify-icon icon="mdi:bookshelf" style="font-size:22px;" class="menu-icon"></iconify-icon>
                        <span>Stock</span>
                    </a> 
                </li>

                <li>
                    <a  href="<?= route_to('sales/salesdashboard') ?>">
                        <iconify-icon icon="solar:wallet-bold" style="font-size:22px;" class="menu-icon"></iconify-icon>
                        <span>Sales</span>
                    </a> 
                </li>

                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                        <span>Royalty</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="<?= route_to('royalty/transactiondetails') ?>">
                                <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Month Wise
                            </a>
                        </li>
                        <li>
                            <a href="<?= route_to('royalty/royaltyconsolidation') ?>">
                                <i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Author Wise
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- <ul class="sidebar-submenu">
                        <li>
                            <a href="<?= base_url('stock/stockdashboard'); ?>">
                                <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Stock
                            </a>
                        </li>
                        <li>
                            <a href="<?= route_to('tppublisher') ?>">
                                <i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> TpPublisher
                            </a>
                        </li>
                    </ul> -->
                <li>
                    <a  href="<?= route_to('tppublisher') ?>">
                        <iconify-icon icon="ri:building-line" style="font-size:22px;" class="menu-icon"></iconify-icon>
                        <span>TpPublisher</span>
                    </a> 
                </li>
            <?php endif; ?>
        </ul>
    </div>
</aside>
