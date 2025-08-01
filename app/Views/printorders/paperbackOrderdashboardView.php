<?= $this->extend('layout/layout1'); ?>
<?= $this->section('script'); ?>
    <script src="<?= base_url('assets/js/homeFourChart.js') ?>"></script>    
<?= $this->endSection(); ?>
<?= $this->section('content'); ?> 
<div class="page-header">
    <div class="page-title">
        <h6> Paperback Order Published by Pustaka</h6>
    </div>
</div>
<div class="row row-cols-xxxl-5 row-cols-lg-3 row-cols-sm-2 row-cols-1 gy-4">
    <!-- Online Orders -->
    <div class="col">
        <div class="card shadow-none border bg-gradient-end-3">
            <div class="card-body p-20">
                <h4 class="mb-2 fw-medium text-secondary-light text-md">Online Orders</h4>
                <p class="card-text text-white fw-bold" style="font-size: 40px;"></p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="<?= base_url(); ?>pustakapaperback/online_orderbooks_status" class="bs-tooltip rounded" title="View">
                    <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-2xl mb-12 bg-info-100 text-info-600">
                        <i class="ri-eye-fill"></i>
                    </span>
                    </a>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top-0">
                <center>
                    <button type="button" class="btn btn-outline-warning" style="width:12rem; height: 40px; font-size: 20px;">Dashboard</button>
                </center>
            </div>
        </div>
    </div>
    <!-- Offline Orders -->
    <div class="col">
        <div class="card shadow-none border bg-gradient-end-1">
            <div class="card-body p-20">
                <h4 class="mb-2 fw-medium text-secondary-light text-md">Offline Orders</h4>
                <p class="card-text text-white fw-bold" style="font-size: 40px;"></p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="<?= base_url(); ?>pustaka_paperback/offline_orderbooks_status" class="bs-tooltip rounded" title="View">
                    <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-2xl mb-12 bg-lilac-200 text-lilac-600">
                        <i class="ri-eye-fill"></i>
                    </span>
                    </a>
                    <a href="<?= base_url();?>pustaka_paperback/offline_order_books_dashboard" class="btn btn-dark bs-tooltip rounded" title="Create Orders">
                        <i data-feather="plus"></i>
                    </a>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top-0">
                <center>
                    <button type="button" class="btn btn-outline-info" style="width:12rem; height: 40px; font-size: 20px;">Dashboard</button>
                </center>
            </div>
        </div>
    </div>
    <!-- Amazon Orders -->
    <div class="col">
        <div class="card shadow-none border bg-gradient-end-5">
            <div class="card-body p-20">
                <h4 class="mb-2 fw-medium text-secondary-light text-md">Amazon Orders</h4>
                <p class="card-text text-white fw-bold" style="font-size: 40px;"></p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="<?= base_url(); ?>pustaka_paperback/amazon_orderbooks_status" class="bs-tooltip rounded" title="View">
                    <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-2xl mb-12 bg-primary-100 text-primary-600">
                        <i class="ri-eye-fill"></i>
                    </span>
                    </a>
                    <a href="<?= base_url();?>pustaka_paperback/paperback_amazon_order" class="btn btn-dark bs-tooltip rounded" title="Create Orders">
                        <i data-feather="plus"></i>
                    </a>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top-0">
                <center>
                    <a href="<?= base_url();?>amazonpaperback/amazon_paperback_dashboard">
                        <button type="button" class="btn btn-outline-danger" style="width:12rem; height: 40px; font-size: 20px;">Dashboard</button>
                    </a>
                </center>
            </div>
        </div>
    </div>
    <!-- Flipkart Orders -->
    <div class="col">
        <div class="card shadow-none border bg-gradient-end-6">
            <div class="card-body p-20">
                <h4 class="mb-2 fw-medium text-secondary-light text-md">Flipkart Orders</h4>
                <p class="card-text text-white fw-bold" style="font-size: 40px;"></p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="<?= base_url(); ?>pustaka_paperback/flipkart_orderbooks_status" class="bs-tooltip rounded" title="View">
                    <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-2xl mb-12 bg-warning-100 text-warning-600">
                        <i class="ri-eye-fill"></i>
                    </span>
                    </a>
                    <a href="<?= base_url();?>pustaka_paperback/paperback_flipkart_order" class="btn btn-dark bs-tooltip rounded" title="Create Orders">
                        <i data-feather="plus"></i>
                    </a>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top-0">
                <center>
                    <button type="button" class="btn btn-outline-primary" style="width:12rem; height: 40px; font-size: 20px;">Dashboard</button>
                </center>
            </div>
        </div>
    </div>
    <!-- Authors Orders -->
    <div class="col">
        <div class="card shadow-none border bg-gradient-end-3">
            <div class="card-body p-20">
                <h4 class="mb-2 fw-medium text-secondary-light text-md">Authors Orders</h4>
                <p class="card-text text-white fw-bold" style="font-size: 40px;"></p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="<?= base_url(); ?>pustaka_paperback/author_orderbooks_status" class="bs-tooltip rounded" title="View">
                    <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-2xl mb-12 bg-success-100 text-success-600">
                        <i class="ri-eye-fill"></i>
                    </span>
                    </a>
                    <a href="<?= base_url();?>pustaka_paperback/author_list_details" class="btn btn-dark bs-tooltip rounded" title="Create Orders">
                        <i data-feather="plus"></i>
                    </a>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top-0">
                <center>
                    <button type="button" class="btn btn-outline-success" style="width:12rem; height: 40px; font-size: 20px;">Dashboard</button>
                </center>
            </div>
        </div>
    </div>
    <!-- BookShop Orders -->
    <div class="col">
        <div class="card shadow-none border bg-gradient-end-1">
            <div class="card-body p-20">
                <h4 class="mb-2 fw-medium text-secondary-light text-md">BookShop Orders</h4>
                <p class="card-text text-white fw-bold" style="font-size: 40px;"></p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="<?= base_url(); ?>pustaka_paperback/bookshop_orderbooks_status" class="bs-tooltip rounded" title="View">
                    <span class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-2xl mb-12 bg-danger-100 text-danger-600">
                        <i class="ri-eye-fill"></i>
                    </span>
                    </a>
                    <a href="<?= base_url();?>pustaka_paperback/bookshop_orders_dashboard" class="btn btn-dark bs-tooltip rounded" title="Create Orders">
                        <i data-feather="plus"></i>
                    </a>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top-0">
                <center>
                    <button type="button" class="btn btn-outline-secondary" style="width:12rem; height: 40px; font-size: 20px;">Dashboard</button>
                </center>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<div class="page-title">
<h6 class="text-center">Amazon, Flipkart, Offline and Online Order </h6>
<table class="zero-config table table-bordered mb-4">
    <thead class="thead-dark">
        <tr>
            <th style="border: 1px solid grey">S.No</th>
            <th style="border: 1px solid grey">Order Id</th>
            <th style="border: 1px solid grey">BookId</th>
            <th style="border: 1px solid grey">Channel</th>
            <th style="border: 1px solid grey">Title</th>
            <th style="border: 1px solid grey">Copies</th>
            <th style="border: 1px solid grey">Author</th>
            <th style="border: 1px solid grey">Order Date</th>
            <th style="border: 1px solid grey">Ship Date</th>
            <th style="border: 1px solid grey">Stock In Hand</th>
            <th style="border: 1px solid grey">Qty Details</th>
            <th style="border: 1px solid grey">Stock state</th>
        </tr>
    </thead>
    <tbody style="font-weight: 800;">
        <?php
        $i = 1;
        $tmp_order_id = null;
        $tmp_order_id_count = 0;
        foreach ($pending as $books_details) {
        ?>
            <tr>
                <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                <td style="border: 1px solid grey">
                    <?php
                    if ($books_details['channel'] == 'Offline') {
                    ?>
                        <a href="<?php echo base_url() . "pustaka_paperback/offline_order_details/" . $books_details['order_id']?>" target="_blank">
                            <?php echo $books_details['order_id'] ?>
                        </a>
                    <?php
                    } else if ($books_details['channel'] == 'Online') {
                    ?>
                        <a href="<?php echo base_url() . "pustaka_paperback/online_order_details/" . $books_details['order_id'] ?>"target="_blank">
                            <?php echo $books_details['order_id'] ?>
                        </a>
                    <?php
                    } else if ($books_details['channel'] == 'Amazon') {
                    ?>
                        <a href="<?php echo base_url() . "pustaka_paperback/amazon_order_details/" . $books_details['order_id'] ?>"target="_blank">
                            <?php echo $books_details['order_id'] ?>
                        </a>
                    <?php
                    }else if ($books_details['channel'] == 'Flipkart') {
                    ?>
                        <a href="<?php echo base_url() . "pustaka_paperback/flipkart_order_details/" . $books_details['order_id'] ?>"target="_blank">
                            <?php echo $books_details['order_id'] ?>
                        </a>
                    <?php
                    }else{?>
                    <?php echo $books_details['order_id'] ?>
                    <?php
                    }
                    ?>
                    <br>
                    <?php echo $books_details['customer_name'] ?>
                </td>
                <td style="border: 1px solid grey"><?php echo $books_details['book_id'] ?></td>
                <td style="border: 1px solid grey"><?php echo $books_details['channel'] ?></td>
                <td style="border: 1px solid grey"><?php echo $books_details['book_title'] ?></td>
                <td style="border: 1px solid grey"><?php echo $books_details['quantity'] ?></td>
                <td style="border: 1px solid grey"><?php echo $books_details['author_name'] ?></td>

                <td style="border: 1px solid grey">
                    <?php
                    if ($books_details['order_date'] == NULL) {
                        echo '';
                    } else {
                        echo date('d-m-Y', strtotime($books_details['order_date']));
                    }
                    ?>
                </td>
                <td style="border: 1px solid grey">
                    <?php
                    if ($books_details['ship_date'] == NULL) {
                        echo '';
                    } else {
                        echo date('d-m-Y', strtotime($books_details['ship_date']));
                    }
                    ?>
                </td>
                <td style="border: 1px solid grey"><?php echo $books_details['stock_in_hand'] ?></td>
                <td style="border: 1px solid grey">
                    Ledger: <?php echo $books_details['qty'] ?><br>
                    Fair / Store: <?php echo $books_details['bookfair'] ?><br>
                <?php if ($books_details['lost_qty'] < 0) { ?>
                    <span style="color:#008000;">Excess: <?php echo abs($books_details['lost_qty']) ?></span><br>
                <?php } elseif ($books_details['lost_qty'] > 0) { ?>
                    <span style="color:#ff0000;">Lost: <?php echo $books_details['lost_qty'] ?><br></span>
                <?php } ?>
                </td>
                
                <?php
                $stockStatus = $books_details['quantity'] <= ($books_details['stock_in_hand']+$books_details['lost_qty']) ? 'IN STOCK' : 'OUT OF STOCK';
                $recommendationStatus = "";
                        
                if ($books_details['quantity'] <= ($books_details['stock_in_hand']+$books_details['lost_qty']))
                {
                    $stockStatus = "IN STOCK";
                    // Stock is available; check whether it is from lost qty
                    if ($books_details['quantity'] <= $books_details['stock_in_hand']) {
                        $stockStatus = "IN STOCK";
                        $recommendationStatus ="";
                    } else {
                        $stockStatus = "IN STOCK";
                        $recommendationStatus = "Print using </span><span style='color:#ff0000;'>LOST</span><span style='color:#0000ff;'> Qty! No Initiate to Print";
                    }
                } else {
                    $stockStatus = "OUT OF STOCK";
                    // Stock not available; Check whether it is from excess qty
                    if ($books_details['quantity'] <= $books_details['stock_in_hand']) {
                        $stockStatus = "OUT OF STOCK";
                        $recommendationStatus = "Print using </span><span style='color:#008000;'>EXCESS</span><span style='color:#0000ff;'> Qty! Initiate Print Also";
                    } else {
                        $stockStatus = "OUT OF STOCK";
                        $recommendationStatus ="";
                    }
                }
                
                ?>
                <td style="border: 1px solid grey">
                    <center>
                    <?php echo $stockStatus; ?>
                    <br><span style="color:#0000ff;"><?php 
                        if (($stockStatus == 'OUT OF STOCK') && ($recommendationStatus == '')) {
                        ?><br><br>
                            <div class="d-flex justify-content-between">
                                <a href="<?php echo base_url() . "pustaka_paperback/paperback_print_status" ?>" class="btn-sm btn-info" target="_blank">status</a>
                                <a href="<?php echo base_url() . "pustaka_paperback/initiate_print_dashboard/" . $books_details['book_id'] ?>" class="btn-sm btn-info" target="_blank">Print</a>
                            </div>
                        <?php 
                            } else {
                                echo $recommendationStatus;
                            } 
                        ?></span>
                    </center>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
</div>
<br>
<br>
<div class="page-title">
<h6 class="text-center">Author Order & Bookshop Order </h6>
    <table class="zero-config table table-bordered mb-4">
        <thead class="">
            <tr>
                <th style="border: 1px solid grey">S.No</th>
                <th style="border: 1px solid grey">Order Id</th>
                <th style="border: 1px solid grey">Order Date</th>
                <th style="border: 1px solid grey">Channel</th>
                <th style="border: 1px solid grey">No.Of.Title</th>
                <th style="border: 1px solid grey">Invoice Number</th>
                <th style="border: 1px solid grey">Ship Date</th>
            </tr>
        </thead>
        <tbody style="font-weight: 800;">
            <?php
            $i = 1;
            foreach ($orders as $books_details) {
            ?>
                <tr>
                    <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                    <td style="border: 1px solid grey">
                        <?php
                        if ($books_details['channel'] == 'Author Order') {
                        ?>
                            <a href="<?php echo base_url() . "pustaka_paperback/author_order_details/" . $books_details['order_id']?>" target="_blank">
                                <?php echo $books_details['order_id'] ?>
                            </a>
                        <?php
                        } else if ($books_details['channel'] == 'Bookshop Order') {
                        ?>
                            <a href="<?php echo base_url() . "pustaka_paperback/bookshop_order_details/" . $books_details['order_id'] ?>"target="_blank">
                                <?php echo $books_details['order_id'] ?>
                            </a>
                        <?php
                        }else{?>
                        <?php echo $books_details['order_id'] ?>
                        <?php
                        }
                        ?>
                        <br>
                        <?php echo $books_details['customer_name'] ?>
                    </td>
                    <td style="border: 1px solid grey">
                        <?php
                        if ($books_details['order_date'] == NULL) {
                            echo '';
                        } else {
                            echo date('d-m-Y', strtotime($books_details['order_date']));
                        }
                        ?>
                    </td>
                    <td style="border: 1px solid grey"><?php echo $books_details['channel'] ?></td>
                    <td style="border: 1px solid grey"><?php echo $books_details['no_of_title'] ?></td>

                    <td style="border: 1px solid grey">
                    <?php
                    if ($books_details['invoice_number'] == NULL) {
                        echo 'Not Avaliable';
                    } else {
                        echo $books_details['invoice_number'] ;
                    }
                    ?></td>
                    <td style="border: 1px solid grey">
                        <?php
                        if ($books_details['ship_date'] == NULL) {
                            echo '';
                        } else {
                            echo date('d-m-Y', strtotime($books_details['ship_date']));
                        }
                        ?>
                    </td>   
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<?= $this->endSection(); ?>