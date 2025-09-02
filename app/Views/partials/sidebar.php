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
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                        <span>Dashboard</span>
                    </a>
                    <ul class="sidebar-submenu">
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
                        <li>
                            <a href="<?= site_url('user/userdashboard') ?>">
                                <i class="ri-circle-fill circle-icon text-success w-auto"></i> User
                            </a>
                        </li>
                        <li>
                            <a href="<?= route_to('sales/salesdashboard') ?>">
                                <i class="ri-circle-fill circle-icon text-purple w-auto"></i> Sales
                            </a>
                        </li>
                        <li>
                            <a href="<?= route_to('book/bookdashboard') ?>">
                                <i class="ri-circle-fill circle-icon text-danger w-auto"></i> Book
                            </a>
                        </li>
                    </ul>
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

                <li class="dropdown">
                    <a  href="javascript:void(0)">
                        <iconify-icon icon="solar:document-text-outline" class="menu-icon"></iconify-icon>
                        <span>Paperback Sales</span>
                    </a>
                <ul class="sidebar-submenu">
                    <li>
                    <a href="<?= route_to('paperback/onlineorderbooksstatus') ?>"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>Online</a>
                    </li>
                    <li>
                    <a href="<?= route_to('paperback/offlineorderbooksstatus') ?>"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Offline</a>
                    </li>
                    <li>
                    <a href="<?= route_to('paperback/amazonorderbooksstatus') ?>"><i class="ri-circle-fill circle-icon text-success-main w-auto"></i>Amazon</a>
                    </li>
                    <li>
                    <a href="<?= route_to('paperback/authororderbooksstatus') ?>"><i class="ri-circle-fill circle-icon text-purple w-auto"></i>Author</a>
                    </li>
                </ul>
                <li class="dropdown">
                    <a  href="javascript:void(0)">
                        <i class="ri-user-settings-line text-xl me-6 d-flex w-auto"></i>
                        <span>  Author</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a  href="<?= route_to('user/authorgiftbooks') ?>"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>Gift Books</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                     <a  href="javascript:void(0)">
                        <i class="ri-book-open-line"></i>
                        <span>POD</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a  href="<?= route_to('pod/dashboard') ?>"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>POD Overview</a>
                        </li>
                         <!-- <li>
                            <a  href="<?= route_to('pod/orders') ?>"><i class="ri-circle-fill circle-icon text-warning-600 w-auto"></i>Pod Order</a>
                        </li> -->
                         <li>
                            <a  href="<?= route_to('pod/invoice') ?>"><i class="ri-circle-fill circle-icon text-success-600 w-auto"></i>Pod Invoice</a>
                        </li>
                    </ul>
                </li>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</aside>
