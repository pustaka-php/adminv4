<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<?php
$data = json_encode($royalty_author_launches['month_details']);
$data1 = json_encode($royalty_author_launches['authors']);
$data2 = json_encode($free_author_launches['free_month_details']);
$data3 = json_encode($free_author_launches['free_authors']);
$data4 = json_encode($magpub_author_launches['magpub_month_details']);
$data5 = json_encode($magpub_author_launches['magpub_authors']);
?>

<div class="container">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <div class="row mt-2">
                    <div class="col-11">
                        <h5 class="text-center">
                            <i class="fas fa-users text-primary" style="margin-right: 10px;"></i>
                            Author Dashboard
                        </h5><br>
                        <div class="d-flex gap-5 justify-content-end">
                            <a href="<?= base_url('user/authorgiftbooks'); ?>">
                                <span class="badge text-sm fw-semibold bg-lilac-600 px-20 py-10 radius-4 text-white">
                                    Gift Books
                                </span>
                            </a>
                        </div><br>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

        <div class="col-12">
            <div class="row" style="display: flex; flex-wrap: wrap; justify-content: space-between; gap: 20px;">

                <!-- Royalty Authors -->
                <div class="col" style="flex: 1; min-width: 22%; max-width: 24%; display: flex;">
                    <a target="_blank" href="<?= site_url('author/royaltyauthordashboard') ?>" style="width: 100%;">
                        <div class="card shadow-none border bg-gradient-start-3"
                            style="width: 100%; padding: 28px 20px; border-radius: 12px; min-height: 240px; transition: all 0.3s ease;">
                            <div class="card-body text-center">

                                <!-- Heading -->
                                <h6 style="font-weight:600; margin-bottom:18px; font-size:14px; white-space:nowrap;">
                                    <i class="fas fa-user text-primary" style="margin-right: 6px; font-size:13px;"></i>
                                    Royalty Authors
                                </h6>

                                <!-- Counts -->
                                <div style="display: flex; flex-direction: column; gap: 12px; align-items: center;">
                                    <div style="font-weight: 600; font-size: 16px; color: #2c9307ff; display: flex; align-items: center; gap: 8px;">
                                        <span class="iconify" data-icon="mdi:account-check-outline" style="font-size: 22px;"></span>
                                        <?= esc($authors_count['active_royalty_auth_cnt']) ?> Active
                                    </div>
                                    <div style="font-weight: 600; font-size: 16px; color: #ee0d0dff; display: flex; align-items: center; gap: 8px;">
                                        <span class="iconify" data-icon="mdi:account-off-outline" style="font-size: 22px;"></span>
                                        <?= esc($authors_count['inactive_royalty_auth_cnt']) ?> Inactive
                                    </div>
                                </div>

                            </div>
                        </div>
                    </a>
                </div>

                <!-- Free Authors -->
                <div class="col" style="flex: 1; min-width: 22%; max-width: 24%; display: flex;">
                    <a target="_blank" href="<?= site_url('author/freeauthordashboard') ?>" style="width: 100%;">
                        <div class="card shadow-none border bg-gradient-start-5"
                            style="width: 100%; padding: 28px 20px; border-radius: 12px; min-height: 240px; transition: all 0.3s ease;">
                            <div class="card-body text-center">

                                <!-- Heading -->
                                <h6 style="font-weight:600; margin-bottom:18px; font-size:14px; white-space:nowrap;">
                                    <i class="fas fa-user text-primary" style="margin-right: 6px; font-size:13px;"></i>
                                    Free Authors
                                </h6>

                                <!-- Counts -->
                                <div style="display: flex; flex-direction: column; gap: 12px; align-items: center;">
                                    <div style="font-weight: 600; font-size: 16px; color: #2c9307ff; display: flex; align-items: center; gap: 8px;">
                                        <span class="iconify" data-icon="mdi:account-check-outline" style="font-size: 22px;"></span>
                                        <?= esc($authors_count['active_free_auth_cnt']) ?> Active
                                    </div>
                                    <div style="font-weight: 600; font-size: 16px; color: #ee0d0dff; display: flex; align-items: center; gap: 8px;">
                                        <span class="iconify" data-icon="mdi:account-off-outline" style="font-size: 22px;"></span>
                                        <?= esc($authors_count['inactive_free_auth_cnt']) ?> Inactive
                                    </div>
                                </div>

                            </div>
                        </div>
                    </a>
                </div>

                <!-- Magazine / Publisher Authors -->
                <div class="col" style="flex: 1; min-width: 22%; max-width: 24%; display: flex;">
                    <a target="_blank" href="<?= site_url('author/magpubauthordashboard') ?>" style="width: 100%;">
                        <div class="card shadow-none border bg-gradient-start-2"
                            style="width: 100%; padding: 28px 20px; border-radius: 12px; min-height: 240px; transition: all 0.3s ease;">
                            <div class="card-body text-center">

                                <!-- Heading -->
                                <h6 style="font-weight:600; margin-bottom:18px; font-size:12px; white-space:nowrap;">
                                    <i class="fas fa-users text-primary" style="margin-left:-14px; font-size:12px;"></i>
                                    Magazine/Publisher
                                </h6>

                                <!-- Counts -->
                                <div style="display: flex; flex-direction: column; gap: 12px; align-items: center;">
                                    <div style="font-weight: 600; font-size: 16px; color: #2c9307ff; display: flex; align-items: center; gap: 8px;">
                                        <span class="iconify" data-icon="mdi:account-check-outline" style="font-size: 22px;"></span>
                                        <?= esc($authors_count['active_mag_auth_cnt']) ?> Active
                                    </div>
                                    <div style="font-weight: 600; font-size: 16px; color: #ee0d0dff; display: flex; align-items: center; gap: 8px;">
                                        <span class="iconify" data-icon="mdi:account-off-outline" style="font-size: 22px;"></span>
                                        <?= esc($authors_count['inactive_mag_auth_cnt']) ?> Inactive
                                    </div>
                                </div>

                            </div>
                        </div>
                    </a>
                </div>

                <!-- Add New Author -->
                <!-- Add New Author -->
                <div class="col" style="flex: 1; min-width: 22%; max-width: 24%; display: flex;">
                    <a href="<?= site_url('author/addauthor') ?>" style="width: 100%;">
                        <div class="card shadow-none border bg-gradient-start-4"
                            style="width: 100%; padding: 32px 24px; border-radius: 12px; min-height: 240px; transition: all 0.3s ease;">
                            <div class="card-body text-center" style="padding: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 16px;">
                                <h6 style="font-weight:600; margin-bottom:4px; font-size:14px; white-space:nowrap;">
                                        Add Author
                                </h6>
                                <!-- Icon on Top -->
                                <span style="width: 60px; height: 60px; background-color: #16a34a; color: #fff; display: flex; justify-content: center; align-items: center; border-radius: 12px; font-size: 30px;">
                                    <span class="iconify" data-icon="mdi:account-plus" style="font-size:30px;"></span>
                                </span>

                                <!-- Text Below Icon -->
                                <div>
                                    
                                    <span style="font-weight:500; color:#6c757d; font-size:13px;">
                                        Click to add new author
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>


            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
