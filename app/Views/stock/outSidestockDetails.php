<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>

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
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($outsidestock_details['outside_stock'])) : ?>
                        <?php $i = 1; foreach ($outsidestock_details['outside_stock'] as $row): ?>
                            <tr>
                                <td style="text-align:center;"><?= $i++ ?></td>
                                <td style="text-align:center;"><?= esc($row['book_id']) ?></td>
                                <td style="word-break: break-word; white-space: normal;"><?= esc($row['book_title']) ?></td>
                                <td><?= esc($row['author_name']) ?> - <?= esc($row['author_id']) ?></td>

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
