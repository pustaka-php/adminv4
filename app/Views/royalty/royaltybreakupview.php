<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container mt-5">
    <!-- Ebook Section -->
    <div class="">
        <div class="card-header text-center">
            <h5>Royalty Breakup Details</h5>
            <?php 
            // Collect unique publisher details
            $uniquePublishers = [];
            foreach ($details as $item) {
                $key = $item['publisher_name'] . $item['copyright_owner'];
                $uniquePublishers[$key] = $item;
            }
            ?>

            <?php if (!empty($uniquePublishers)) : ?>
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <?php foreach ($uniquePublishers as $item) : ?>
                            <p><strong>Publisher Name:</strong> <?= esc($item['publisher_name']) ?></p>
                            <p><strong>Copyright Owner ID:</strong> <?= esc($item['copyright_owner']) ?></p>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Royalty Summary Section -->
            <?php if (!empty($summary)) : ?>
                <div class="card mb-4 shadow-sm">
                    <div class="card-header text-center bg-info text-white">
                        <h6><strong>Royalty Summary</strong></h6>
                    </div>
                    <div class="card-body">
                            <!-- Royalty Summary -->
                            <?php 
                            $ebook_total     = $summary['ebooks_outstanding'] ?? 0;
                            $audio_total     = $summary['audiobooks_outstanding'] ?? 0;
                            $paper_total     = $summary['paperbacks_outstanding'] ?? 0;
                            $bonus           = $summary['bonus_value'] ?? 0;
                            $tds             = $summary['tds_value'] ?? 0;
                            $excess          = $summary['excess_payment'] ?? 0;
                            $advance         = $summary['advance_payment'] ?? 0;

                            // Compute overall total & final "To Pay"
                            $total = $ebook_total + $audio_total + $paper_total + $bonus;
                            $to_pay = $total - $tds - $excess - $advance;

                            ?>

                            <div class="royalty-summary">

                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="fw-bold">Ebook Total</td>
                                            <td class=""><?= indian_format($ebook_total, 2) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Audiobook Total</td>
                                            <td class=""><?= indian_format($audio_total, 2) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Paperback Total</td>
                                            <td class=""><?= indian_format($paper_total, 2) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Bonus</td>
                                            <td class=""><?= indian_format($bonus, 2) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">TDS (-)</td>
                                            <td class=" text-danger">-<?= indian_format($tds, 2) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Excess Payment (-)</td>
                                            <td class=" text-danger">-<?= indian_format($excess, 2) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Advance Payment (-)</td>
                                            <td class=" text-danger">-<?= indian_format($advance, 2) ?></td>
                                        </tr>
                                        <tr class="fw-bold table-success">
                                            <th>To Pay</th>
                                            <td class="fw-bold text-dark" ><?= indian_format($to_pay, 2) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <br><br>
    <div class="card">
        <div class="card-header text-center">
            <h6>(Ebook Royalty)</h6>
        </div>
        <div class="card-body p-3">
            <?php
            $ebook_cons_total = 0;
            $ebook_trans_total = 0;
            ?>
            <?php if (!empty($ebook_details)) : ?>
                <div class="table-responsive">
                    <table class="zero-config table table-hover mt-4">
                        <thead>
                            <tr>
                                <th>Channel</th>
                                <th>Cons</th>
                                <th>Trans</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ebook_details as $row) :
                                $cons = (float)$row['consolidation_amount'];
                                $trans = (float)$row['transaction_amount'];
                                $ebook_cons_total += $cons;
                                $ebook_trans_total += $trans;
                                $highlight = (abs($cons - $trans) > 0.01) ? 'text-danger' : '';
                            ?>
                                <tr>
                                    <td><?= esc($row['channel']) ?></td>
                                    <td class="<?= $highlight ?>"><?= indian_format($cons, 2) ?></td>
                                    <td class="<?= $highlight ?>"><?= indian_format($trans, 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="fw-bold table-secondary">
                                <td>Total</td>
                                <td><?= indian_format($ebook_cons_total, 2) ?></td>
                                <td><?= indian_format($ebook_trans_total, 2) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <p class="text-center text-muted">No royalty breakup data found.</p>
            <?php endif; ?>
        </div>
    </div>

    <br><br>

    <!-- Audiobook Section -->
    <div class="card">
        <div class="card-header text-center">
            <h6>(Audiobook Royalty)</h6>
        </div>
        <div class="card-body p-3">
            <?php
            $audio_cons_total = 0;
            $audio_trans_total = 0;
            ?>
            <?php if (!empty($audiobook_details)) : ?>
                <div class="table-responsive">
                    <table class="zero-config table table-hover mt-4">
                        <thead>
                            <tr>
                                <th>Channel</th>
                                <th>Cons</th>
                                <th>Trans</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($audiobook_details as $channel => $data) :
                                $cons = (float)($data['consolidation_amount'] ?? 0);
                                $trans = (float)($data['transaction_amount'] ?? 0);
                                $audio_cons_total += $cons;
                                $audio_trans_total += $trans;
                                $highlight = (abs($cons - $trans) > 0.01) ? 'text-danger' : '';
                            ?>
                                <tr>
                                    <td><?= esc($channel) ?></td>
                                    <td class="<?= $highlight ?>"><?= indian_format($cons, 2) ?></td>
                                    <td class="<?= $highlight ?>"><?= indian_format($trans, 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="fw-bold table-secondary">
                                <td>Total</td>
                                <td><?= indian_format($audio_cons_total, 2) ?></td>
                                <td><?= indian_format($audio_trans_total, 2) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <p class="text-center text-muted">No royalty data found.</p>
            <?php endif; ?>
        </div>
    </div>

    <br><br>

    <!-- Paperback Section -->
    <div class="card">
        <div class="card-header text-center">
            <h6>(Paperback Royalty)</h6>
        </div>
        <div>
            <?php
            $paper_cons_total = 0;
            $paper_trans_total = 0;
            ?>
            <?php if (!empty($paperback_details)) : ?>
                <div class="table-responsive scroll-sm">
                    <table class="zero-config table table-hover mt-4">
                        <thead>
                            <tr>
                                <th>Channel</th>
                                <th>Cons</th>
                                <th>Trans</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($paperback_details as $channel => $data) :
                                $cons = (float)($data['consolidation_amount'] ?? 0);
                                $trans = (float)($data['transaction_amount'] ?? 0);
                                $paper_cons_total += $cons;
                                $paper_trans_total += $trans;
                                $highlight = (abs($cons - $trans) > 0.01) ? 'text-danger' : '';
                            ?>
                                <tr>
                                    <td><?= esc($channel) ?></td>
                                    <td class="<?= $highlight ?>"><?= indian_format($cons, 2) ?></td>
                                    <td class="<?= $highlight ?>"><?= indian_format($trans, 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="fw-bold table-secondary">
                                <td>Total</td>
                                <td><?= indian_format($paper_cons_total, 2) ?></td>
                                <td><?= indian_format($paper_trans_total, 2) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <p class="text-center text-muted">No paperback royalty data found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>
