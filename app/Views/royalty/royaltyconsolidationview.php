<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="card-header text-center">
            <a href="<?= base_url('royalty/download_bank_excel') ?>" class="btn btn-primary mt-3">
                Download Bank Excel
            </a>
        </div>

        <div class="card-body">
            <?php
                // Initialize totals
                $total_ebooks_outstanding = 0;
                $total_audiobooks_outstanding = 0;
                $total_paperbacks_outstanding = 0;
                $total_bonus_value = 0;
                $totalOutstanding = 0;
                $total_tds_amount = 0;
                $total_afterTDS_amount = 0;
                $count_of_yes = 0;

                // First pass to calculate totals
                foreach ($royalty as $royalty_data) {
                    $condition = ($type === 'quarterly') 
                        ? ($royalty_data['total_outstanding'] > 500) 
                        : ($royalty_data['total_outstanding'] > 0);

                    if ($condition && $royalty_data['bank_status'] === "Yes") {
                        $count_of_yes++;
                        $total_tds_amount += $royalty_data['tds_value'];

                        // Calculate adjusted total_after_tds considering excess/advance
                        $adjusted_after_tds = $royalty_data['total_after_tds'];

                        if (!empty($royalty_data['excess_payment']) && $royalty_data['excess_payment'] > 0) {
                            $adjusted_after_tds -= $royalty_data['excess_payment'];
                        }
                        if (!empty($royalty_data['advance_payment']) && $royalty_data['advance_payment'] > 0) {
                            $adjusted_after_tds -= $royalty_data['advance_payment'];
                        }

                        $total_afterTDS_amount += $adjusted_after_tds;
                        $total_ebooks_outstanding += $royalty_data['ebooks_outstanding'];
                        $total_audiobooks_outstanding += $royalty_data['audiobooks_outstanding'];
                        $total_paperbacks_outstanding += $royalty_data['paperbacks_outstanding'];
                        $total_bonus_value += $royalty_data['bonus_value'];
                        $totalOutstanding += $royalty_data['total_outstanding'];
                    }
                }
            ?>

            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
            <?php elseif (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <div class="table-responsive scroll-sm">
                <table class="table table-bordered table-striped table-hover zero-pagination">
                    <thead>
                        <tr>
                            <th>Copyright Owner</th>
                            <th>Publisher Name</th>
                            <th>Ebooks</th>
                            <th>Audiobooks</th>
                            <th>Paperback</th>
                            <th>Bonus</th>
                            <th>Total</th>
                            <th>TDS</th>
                            <th>Bank</th>
                            <th>To Pay</th>
                            <th>Payment</th>
                            <th>Breakup</th>
                        </tr>

                        <!-- Totals Row -->
                        <tr class="table-secondary fw-bold">
                            <td class="text-center"></td>
                            <td class="text-center">Total</td>
                            <td class="text-center"><?= indian_format($total_ebooks_outstanding, 2) ?></td>
                            <td class="text-center"><?= indian_format($total_audiobooks_outstanding, 2) ?></td>
                            <td class="text-center"><?= indian_format($total_paperbacks_outstanding, 2) ?></td>
                            <td class="text-center"><?= indian_format($total_bonus_value, 2) ?></td>
                            <td class="text-center"><?= indian_format($totalOutstanding, 2) ?></td>
                            <td class="text-center"><?= indian_format($total_tds_amount, 2) ?></td>
                            <td class="text-center"><?= $count_of_yes ?></td>
                            <td class="text-center"><?= indian_format($total_afterTDS_amount, 2) ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                        $rowFound = false;
                        foreach ($royalty as $royalty_list): 
                            $condition = ($type === 'quarterly') 
                                ? ($royalty_list['total_outstanding'] > 500) 
                                : ($royalty_list['total_outstanding'] > 0);

                            if ($condition): 
                                $rowFound = true;

                                // Calculate adjusted To Pay
                                $reduction_note = '';
                                $adjusted_after_tds = $royalty_list['total_after_tds'];

                                if (!empty($royalty_list['excess_payment']) && $royalty_list['excess_payment'] > 0) {
                                    $adjusted_after_tds -= $royalty_list['excess_payment'];
                                    $reduction_note .= ' (-Excess ₹' . indian_format($royalty_list['excess_payment'], 2) . ')';
                                }
                                if (!empty($royalty_list['advance_payment']) && $royalty_list['advance_payment'] > 0) {
                                    $adjusted_after_tds -= $royalty_list['advance_payment'];
                                    $reduction_note .= ' (-Advance ₹' . indian_format($royalty_list['advance_payment'], 2) . ')';
                                }
                        ?>
                                <tr>
                                    <td><?= esc($royalty_list['copyright_owner']) ?></td>
                                    <td><?= esc($royalty_list['publisher_name']) ?></td>
                                    <td><?= indian_format($royalty_list['ebooks_outstanding'], 2) ?></td>
                                    <td><?= indian_format($royalty_list['audiobooks_outstanding'], 2) ?></td>
                                    <td><?= indian_format($royalty_list['paperbacks_outstanding'], 2) ?></td>
                                    <td><?= indian_format($royalty_list['bonus_value'], 2) ?></td>
                                    <td><?= indian_format($royalty_list['total_outstanding'], 2) ?></td>
                                    <td><?= indian_format($royalty_list['tds_value'], 2) ?></td>
                                    <td><?= esc($royalty_list['bank_status']) ?></td>
                                    <td>
                                        <?= indian_format($adjusted_after_tds, 2) ?>
                                        <?php if ($reduction_note): ?>
                                            <br><small class="text-danger fw-bold"><?= $reduction_note ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($royalty_list['bank_status'] === 'Yes'): ?>
                                            <form method="post" action="<?= base_url('royalty/paynow') ?>">
                                                <input type="hidden" name="copyright_owner"
                                                    value="<?= esc($royalty_list['copyright_owner']) ?>" />
                                                <button type="submit" class="btn btn-sm btn-success">Pay Now</button>
                                            </form>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('royalty/getroyaltybreakup/' . esc($royalty_list['copyright_owner'])) ?>" 
                                           class="btn btn-sm btn-info" target="_blank">
                                            View
                                        </a>
                                    </td>
                                </tr>
                        <?php 
                            endif;
                        endforeach; 
                        ?>

                        <?php if (!$rowFound): ?>
                            <tr>
                                <td colspan="13" class="text-center text-muted">
                                    No data found (<?= $type === 'quarterly' ? 'above ₹500' : 'above ₹0' ?>)
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

