<?php
$session = \Config\Services::session();
?>
<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="<?= route_to('index') ?>" class="sidebar-logo"> 
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="1" class="light-logo" size= "168x40">
            <img src="<?= base_url('assets/images/logo-light.png') ?>" alt="2" class="dark-logo">
            <img src="<?= base_url('assets/images/logo-icon.png') ?>" alt="3" class="logo-icon">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li class="dropdown">
                <a  href="javascript:void(0)">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="<?= base_url('stock/stockdashboard'); ?>"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Stock</a>
                    </li>
                    <li>
                    <a href="<?= route_to('tppublisher') ?>"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>TpPublisher </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a  href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Royalty</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                    <a href="<?= route_to('royalty/transactiondetails') ?>"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>Month Wise</a>
                    </li>
                    <li>
                    <a href="<?= route_to('royalty/royaltyconsolidation') ?>"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>Author Wise</a>
                    </li>
                </ul>
            </li>
        </ul>

        <?php if (session('user_type') == 7): ?>
            <li>
                <a href="<?= route_to('tppublisherdashboard') ?>">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>TP Publisher Dashboard</span>
                </a>
            </li>
        <?php endif; ?>
        
    </div>
</aside>