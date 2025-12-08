<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>
<?php  
    
    $pending_count = 0;
    $validated_count = 0;

    foreach ($stock_details['stock'] as $row) {
        if ($row['validated_flag'] == '0') {
            $pending_count++;
        } elseif ($row['validated_flag'] == 1) {
            $validated_count++;
        }
    }

    $total_count = 0;
    $disabled_count = 0;

    foreach ($stock_details['stock'] as $row) {
        
        if ($row['paper_back_readiness_flag'] == 1) {
            $total_count++;
        } else {
            $disabled_count++;
        }
    }
?>
<div class="container text-center">
    <div class="d-inline-flex align-items-center gap-3 p-3 radius-8 border pe-36 br-hover-primary group-item" 
        style="background: linear-gradient(135deg, #f3e7ff, #e3d5ff); cursor:pointer; min-width: 400px;" 
        id="mismatchStockCard">
        <span class="bg-neutral-100 w-44-px h-44-px text-xxl radius-8 d-flex justify-content-center align-items-center 
                    text-secondary-light group-hover:bg-primary-600 group-hover:text-white">
            <iconify-icon icon="fluent:dismiss-circle-16-filled"></iconify-icon>
        </span>
        <div>
            <span class="text-dark fw-bold text-md d-block mb-3">Mismatch Stock Details</span>
            <div class="mt-2 text-dark text-sm">
                <div class="d-flex mb-2">
                    <span class="fw-medium" style="min-width:140px;">Stock In Hand:</span>
                    <span class="fw-bold"><?= esc($mismatch_stock['total_stock']) ?></span>
                </div>
                <div class="d-flex mb-2">
                    <span class="fw-medium" style="min-width:140px;">Mismatch Titles:</span>
                    <span class="fw-bold"><?= esc($mismatch_stock['mismatch_count']) ?></span>
                </div>
                <div class="d-flex">
                    <span class="fw-medium" style="min-width:140px;">Mismatch Quantity:</span>
                    <span class="fw-bold"><?= esc($mismatch_stock['total_quantity']) ?></span>
                </div>
                <br>
                <a href="getmismatchstock" class="badge text-sm fw-semibold bg-neutral-800 px-20 py-9 radius-4 text-base">View</a>
            </div>
        </div>
    </div>
    <br><br>
    <!-- Counts Row -->
    <div class="row mb-2 justify-content-center">
        <div class="col-3">
            <a href="<?= base_url('stock/pendingstock') ?>" class="d-block">
                <div class="alert alert-warning text-center mb-0">
                    <strong>Pending:</strong> <?= $pending_count ?>
                </div>
            </a>
        </div>
        <div class="col-3">
            <a href="<?= base_url('stock/validatedstock') ?>" class="d-block">
                <div class="alert alert-success text-center mb-0">
                    <strong>Validated:</strong> <?= $validated_count ?>
                </div>
            </a>
        </div>
        <div class="col-3">
            <a href="<?= base_url('stock/totalstock') ?>" class="d-block">
                <div class="alert alert-primary text-center mb-0">
                    <strong>Total:</strong> <?= $total_count ?>
                </div>
            </a>
        </div>
        <div class="col-3">
            <a href="<?= base_url('stock/disabledstock') ?>" class="d-block">
                <div class="alert alert-secondary text-center mb-0">
                    <strong>Disabled:</strong> <?= $disabled_count ?>
                </div>
            </a>
        </div>
    </div>
</div>
<br><br>
<!-- Flash Messages -->
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
            setTimeout(() => flash.remove(), 500);
        }
    }, 3000); 
</script>

<!-- Stock Table -->
<div class="card basic-data-table">
    <div class="card-body">
        <div class="table-responsive">
            <table class="zero-config table table-hover mt-4"> 
               <thead>
                    <tr>
                        <th style="width: 3%; text-align:center;">Book ID</th>
                        <th style="width: 35%;">Book Title</th>
                        <th style="width: 30%;">Author</th>
                        <th style="text-align:center;">Quantity</th>
                        <?php if (!empty($stock_data)): ?>
                            <?php 
                                $firstRow = $stock_data[0]; 
                                $exclude = ['id','book_id','quantity','lost_qty', 'excess_qty', 'stock_in_hand','last_update_date','book_title','author_name','author_id'];
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
                        <th style="text-align:center;">Excess Quantity</th>
                        <th style="width: 5%; text-align:center;">Validation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($stock_details['stock'] )) : ?>
                        <?php $i = 1; foreach ($stock_details['stock']  as $row): ?>

                            <?php if ($row['paper_back_readiness_flag'] == 0) continue; ?>
                            <tr>
                                <td style="text-align:center;"><?= esc($row['book_id']) ?></td>
                                <td style="word-break: break-word; white-space: normal;"><?= esc($row['book_title']) ?></td>
                                <td><?= esc($row['author_name']) ?> - <?= esc($row['author_id']) ?></td>
                                <td style="text-align:center;"><?= esc($row['quantity']) ?></td>

                                <?php if (!empty($stock_data)): ?>
                                    <?php
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
                                <td style="text-align:center; color:warning;"><?= esc($row['excess_qty']) ?></td>
                               <td style="text-align: center;">
                                    <div style="display: flex; flex-direction: column; align-items: center; gap: 5px;">
                                        <!-- Date -->
                                        <span style="font-size: 13px; color: #444;">
                                            <?= !empty($row['last_validated_date']) 
                                                ? date('d-m-Y', strtotime($row['last_validated_date'])) 
                                                : '' ?>
                                        </span>

                                        <!-- Icon -->
                                        <a href="javascript:void(0)" 
                                        title="Pending Validation" 
                                        style="cursor:pointer;"
                                        onclick="openValidationModal(<?= $row['book_id'] ?>, <?= $row['mismatch_flag'] ?>)">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 80" width="28" height="34" aria-labelledby="title2 desc2" role="img">
                                                <path d="M36 76s22-10 30-24V18L36 6 6 18v34c8 14 30 24 30 24z" fill="#0e76a8"/>
                                                <circle cx="36" cy="36" r="16" fill="#ffffff"/>
                                                <path d="M30 36l4.5 4.5L46 29" fill="none" stroke="#0e76a8" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>
                                    </div>
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

<!-- Validation Confirmation Modal -->
<div class="modal fade" id="confirmValidationModal" tabindex="-1" aria-labelledby="confirmValidationLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmValidationLabel">Confirm Validation</h5>
        <button type="button" class="btn-close btn-primary" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="validationMessage">
        <!-- Dynamic message will be inserted here -->
      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a id="confirmBtn" class="btn btn-success">Yes, Validate</a>
        
        <!-- New Mismatch Button -->
         <form id="mismatchForm" action="<?= base_url('stock/mismatchupdate') ?>" method="post" style="display:inline;">
            <input type="hidden" name="book_id" id="mismatchBookId">
            <button type="submit" class="btn btn-warning">Mismatch</button>
        </form>
      </div>
    </div>
  </div>
</div>


<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
function openValidationModal(bookId, mismatchFlag) {
    document.getElementById('validationMessage').innerText = 
        "Are you sure you want to validate this Book ID: " + bookId + "?";
    document.getElementById('confirmBtn').href = "<?= base_url('stock/validate/') ?>" + bookId;
    document.getElementById('mismatchBookId').value = bookId;

    // Disable validation if mismatch_flag = 1
    var confirmBtn = document.getElementById('confirmBtn');
    if (mismatchFlag == 1) {
        confirmBtn.classList.add("disabled");
        confirmBtn.setAttribute("aria-disabled", "true");
        confirmBtn.style.pointerEvents = "none"; // Prevent click
        confirmBtn.innerText = "Validation Disabled";
    } else {
        confirmBtn.classList.remove("disabled");
        confirmBtn.removeAttribute("aria-disabled");
        confirmBtn.style.pointerEvents = "auto";
        confirmBtn.innerText = "Yes, Validate";
    }

    var myModal = new bootstrap.Modal(document.getElementById('confirmValidationModal'), {
        keyboard: false
    });
    myModal.show();
}

document.addEventListener("DOMContentLoaded", function () {
    new DataTable('#dataTable');
});
</script>
<?= $this->endSection(); ?>
