<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>
<?php  $pending_count = 0;
        $validated_count = 0;

        foreach ($stock_details['stock'] as $row) {
            if ($row['validated_flag'] == '0') {
                $pending_count++;
            } elseif ($row['validated_flag'] == 1) {
                $validated_count++;
            }
        }

        $total_count = count($stock_details['stock']);
        
?>
<div class="row mb-3">
        <div class="col-md-4">
            <div class="alert alert-warning text-center mb-0">
                <strong>Pending:</strong> <?= $pending_count ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="alert alert-success text-center mb-0">
                <strong>Validated:</strong> <?= $validated_count ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="alert alert-primary text-center mb-0">
                <strong>Total:</strong> <?= $total_count ?>
            </div>
        </div>
    </div>

<!-- Flash message -->
<?php if (session()->getFlashdata('message')): ?>
    <div id="flash-message" class="alert alert-success d-flex align-items-center" role="alert" 
         style="background-color:#d4edda; color:#155724; border-left:5px solid #28a745; padding:10px 15px; border-radius:5px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="green" viewBox="0 0 24 24" style="margin-right:8px;">
            <path d="M12 0a12 12 0 1012 12A12.013 12.013 0 0012 0zm-1.2 17.4l-5.4-5.4 1.4-1.4 4 4 8-8 1.4 1.4z"/>
        </svg>
        <strong><?= session()->getFlashdata('message') ?></strong>
        <button type="button" class="btn-close ms-auto" aria-label="Close" 
                onclick="this.parentElement.style.display='none'" 
                style="border:none; background:none; font-size:20px; cursor:pointer;">×</button>
    </div>
<?php elseif (session()->getFlashdata('error')): ?>
    <div id="flash-message" class="alert alert-danger" role="alert" 
         style="background-color:#f8d7da; color:#721c24; border-left:5px solid #dc3545; padding:10px 15px; border-radius:5px;">
        <strong><?= session()->getFlashdata('error') ?></strong>
    </div>
<?php endif; ?>

<script>
    setTimeout(function () {
        let flash = document.getElementById('flash-message');
        if (flash) {
            flash.style.transition = "opacity 0.5s ease";
            flash.style.opacity = 0;
            setTimeout(() => flash.remove(), 500); // Remove after fade-out
        }
    }, 5000); // Hide after 3 seconds
</script>
<div class="card basic-data-table">
    <div class="card-body">
        <div class="table-responsive">
             <table class="zero-config table table-hover mt-4"> 
               <thead>
                    <tr>
                        <th style="width: 2%; text-align:center;">ID</th>
                        <th style="width: 3%; text-align:center;">Book ID</th>
                        <th style="width: 35%;">Book Title</th>
                        <th style="width: 30%;">Author</th>
                         <th style="text-align:center;">Quantity</th>
                        <!-- Dynamically print bookfair (retailer) column headers -->
                        <?php if (!empty($stock_data)): ?>
                            <?php 
                                // get keys from first row to identify dynamic columns
                                $firstRow = $stock_data[0]; 
                                // exclude known columns from dynamic columns
                                $exclude = ['id','book_id','quantity','lost_qty','stock_in_hand','last_update_date','book_title','author_name','author_id'];
                                foreach ($firstRow as $col => $val):
                                    if (!in_array($col, $exclude)):
                            ?>
                                <th style="text-align:center;"><?= esc($col) ?></th>
                            <?php 
                                    endif;
                                endforeach;
                            ?>
                        <?php endif; ?>

                        <th style="width: 10%; text-align:center;">Stock In Hand</th>
                          <th style="text-align:center;">Lost Quantity</th>
                          <th style="width: 5%; text-align:center;">Validation</th>

                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($stock_details['stock'] )) : ?>
                        <?php $i = 1; foreach ($stock_details['stock']  as $row): ?>
                            <tr>
                                <td style="text-align:center;"><?= $i++ ?></td>
                                <td style="text-align:center;"><?= esc($row['book_id']) ?></td>
                                <td style="word-break: break-word; white-space: normal;"><?= esc($row['book_title']) ?></td>
                                <td><?= esc($row['author_name']) ?> - <?= esc($row['author_id']) ?></td>
                                <td style="text-align:center;"><?= esc($row['quantity']) ?></td>

                                <!-- Bookfair quantities for this book -->
                                <?php if (!empty($stock_data)): ?>
                                    <?php
                                        // Find matching stock_data row for this book_id
                                        $stockRow = null;
                                        foreach ($stock_data as $srow) {
                                            if ($srow['book_id'] == $row['book_id']) {
                                                $stockRow = $srow;
                                                break;
                                            }
                                        }
                                        if ($stockRow):
                                            foreach ($stockRow as $col => $val):
                                                if (!in_array($col, $exclude)) {
                                                    echo '<td style="text-align:center;">' . esc($val) . '</td>';
                                                }
                                            endforeach;
                                        else:
                                            // If no matching stock data found, print zeroes or dashes
                                            foreach ($firstRow as $col => $val) {
                                                if (!in_array($col, $exclude)) {
                                                    echo '<td style="text-align:center;">0</td>';
                                                }
                                            }
                                        endif;
                                    ?>
                                <?php endif; ?>

                                <td style="text-align:center;"><?= esc($row['stock_in_hand']) ?></td>
                                <td style="text-align:center; color:red;"><?= esc($row['lost_qty']) ?></td>
                            <td style="text-align:center;">
                        <?php if ($row['validated_flag'] == '0'): ?>
                            <!-- Pending -->
                            <a href="<?= base_url('stock/validate/'.$row['book_id']) ?>" title="Pending Validation" style="cursor:pointer;">
                            <!-- Pick ONE of the SVGs above and paste here -->
                            <!-- Example: Clock -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" aria-hidden="true">
                                <circle cx="12" cy="12" r="10" fill="none" stroke="#ff9800" stroke-width="2"/>
                                <path d="M12 6v6l4 2" fill="none" stroke="#ff9800" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            </a>
                        <?php elseif ($row['validated_flag'] == '1'): ?>
                            <!-- Validated (green tick) -->
                            <span title="Validated">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" aria-hidden="true">
                                <circle cx="12" cy="12" r="10" fill="none" stroke="#2e7d32" stroke-width="2"/>
                                <path d="M8 12l2.5 2.5L16 9" fill="none" stroke="#2e7d32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            </span>
                        <?php endif; ?>
                        </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="10" class="text-center">No stock details found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        new DataTable('#dataTable');
    });
</script>
<?= $this->endSection(); ?>
