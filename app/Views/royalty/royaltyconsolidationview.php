<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header text-center">
            <!-- <h5>Royalty Outstanding List</h5> -->
            <a href="<?= base_url('royalty/download_bank_excel') ?>" class="btn btn-primary mt-3">Download Bank Excel</a>
        </div>
        <div class="card-body">

            <?php
                $total_ebooks_outstanding = 0;
                $total_audiobooks_outstanding = 0;
                $total_paperbacks_outstanding = 0;
                $total_bonus_value = 0;
                $totalOutstanding = 0;
                $total_tds_amount = 0;
                $total_afterTDS_amount = 0;
                $count_of_yes = 0;

                foreach ($royalty as $royalty_data) {
                    if ($royalty_data['total_after_tds'] > 500 && $royalty_data['bank_status'] === "Yes") {
                        $count_of_yes++;
                        $total_tds_amount += $royalty_data['tds_value'];
                        $total_afterTDS_amount += $royalty_data['total_after_tds'];
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
                <table class="zero-config table table-hover mt-4">
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
                    </thead>
                    <tbody class="table-secondary">
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center fw-bold"><?= number_format($total_ebooks_outstanding, 2) ?></td>
                            <td class="text-center fw-bold"><?= number_format($total_audiobooks_outstanding, 2) ?></td>
                            <td class="text-center fw-bold"><?= number_format($total_paperbacks_outstanding, 2) ?></td>
                            <td class="text-center fw-bold"><?= number_format($total_bonus_value, 2) ?></td>
                            <td class="text-center fw-bold"><?= number_format($totalOutstanding, 2) ?></td>
                            <td class="text-center fw-bold"><?= number_format($total_tds_amount, 2) ?></td>
                            <td class="text-center fw-bold"><?= $count_of_yes ?></td>
                            <td class="text-center fw-bold"><?= number_format($total_afterTDS_amount, 2) ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                    <tbody>
                        <?php foreach ($royalty as $royalty_list): ?>
                            <tr>
                                <td><?= esc($royalty_list['copyright_owner']) ?></td>
                                <td><?= esc($royalty_list['publisher_name']) ?></td>
                                <td><?= number_format($royalty_list['ebooks_outstanding'], 2) ?></td>
                                <td><?= number_format($royalty_list['audiobooks_outstanding'], 2) ?></td>
                                <td><?= number_format($royalty_list['paperbacks_outstanding'], 2) ?></td>
                                <td><?= number_format($royalty_list['bonus_value'], 2) ?></td>
                                <td><?= number_format($royalty_list['total_outstanding'], 2) ?></td>
                                <td><?= number_format($royalty_list['tds_value'], 2) ?></td>
                                <td><?= esc($royalty_list['bank_status']) ?></td>
                                <td><?= number_format($royalty_list['total_after_tds'], 2) ?></td>
                                <td>
                                    <?php if ($royalty_list['total_after_tds'] > 500 && $royalty_list['bank_status'] === 'Yes'): ?>
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
                                    <a href="<?= base_url('royalty/getroyaltybreakup/' . $royalty_list['copyright_owner']) ?>" class="btn btn-sm btn-info" target="_blank">
                                        View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>
