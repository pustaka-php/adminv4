<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>
<div class="container mt-5">
    <!-- Ebook Section -->
    <div class="card">
        <div class="card-header text-center">
            <h5>Royalty Breakup Details</h5>
            <h6>(Ebook Royalty)</h6>
        </div>
        <div>
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
                                    <td class="<?= $highlight ?>"><?= number_format($cons, 2) ?></td>
                                    <td class="<?= $highlight ?>"><?= number_format($trans, 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="fw-bold table-secondary">
                                <td>Total</td>
                                <td><?= number_format($ebook_cons_total, 2) ?></td>
                                <td><?= number_format($ebook_trans_total, 2) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <p class="text-center text-muted">No royalty breakup data found.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Audiobook Section -->
    <div class="card">
        <div class="card-header text-center">
            <h5>Royalty Breakup Details</h5>
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
                                    <td class="<?= $highlight ?>"><?= number_format($cons, 2) ?></td>
                                    <td class="<?= $highlight ?>"><?= number_format($trans, 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="fw-bold table-secondary">
                                <td>Total</td>
                                <td><?= number_format($audio_cons_total, 2) ?></td>
                                <td><?= number_format($audio_trans_total, 2) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <p class="text-center text-muted">No royalty data found.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Paperback Section -->
    <div class="card">
        <div class="card-header text-center">
            <h5>Royalty Breakup Details</h5>
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
                                    <td class="<?= $highlight ?>"><?= number_format($cons, 2) ?></td>
                                    <td class="<?= $highlight ?>"><?= number_format($trans, 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="fw-bold table-secondary">
                                <td>Total</td>
                                <td><?= number_format($paper_cons_total, 2) ?></td>
                                <td><?= number_format($paper_trans_total, 2) ?></td>
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