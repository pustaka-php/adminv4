<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?> 
<div style="width: 100%; max-width: 100%; margin: 0 auto;">
    <div style="border: 1px solid #ccc; border-radius: 6px; padding: 20px;">
        <div style="overflow-x: hidden;">
            <table class="table bordered-table mb-0">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Financial Year</th>
                        <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">E-Book</th>
                        <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Audiobook</th>
                        <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Paperback</th>
                        <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalEbook = 0;
                    $totalAudio = 0;
                    $totalPaperback = 0;
                    $totalRevenue = 0;
                    ?>

                    <?php if (!empty($over_all['overall_sales'])): ?>
                        <?php foreach ($over_all['overall_sales'] as $row): ?>
                            <?php
                            $ebook = (float)$row['ebook_revenue'];
                            $audio = (float)$row['audiobook_revenue'];
                            $paperback = (float)$row['paperback_revenue'];
                            $total = $ebook + $audio + $paperback;
                            $totalEbook += $ebook;
                            $totalAudio += $audio;
                            $totalPaperback += $paperback;
                            $totalRevenue += $total;
                            ?>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #ddd;"><?= htmlspecialchars($row['fy']) ?></td>
                                <td style="padding: 8px; border: 1px solid #ddd;">₹<?= number_format($ebook, 2) ?></td>
                                <td style="padding: 8px; border: 1px solid #ddd;">₹<?= number_format($audio, 2) ?></td>
                                <td style="padding: 8px; border: 1px solid #ddd;">₹<?= number_format($paperback, 2) ?></td>
                                <td style="padding: 8px; border: 1px solid #ddd;">₹<?= number_format($total, 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr style="background-color: #e9f0ff; font-weight: bold;">
                            <td style="padding: 8px; border: 1px solid #ddd;">Total</td>
                            <td style="padding: 8px; border: 1px solid #ddd;">₹<?= number_format($totalEbook, 2) ?></td>
                            <td style="padding: 8px; border: 1px solid #ddd;">₹<?= number_format($totalAudio, 2) ?></td>
                            <td style="padding: 8px; border: 1px solid #ddd;">₹<?= number_format($totalPaperback, 2) ?></td>
                            <td style="padding: 8px; border: 1px solid #ddd;">₹<?= number_format($totalRevenue, 2) ?></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align:center; padding: 10px; border: 1px solid #ddd;">No data available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
