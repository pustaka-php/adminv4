<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?> 
<h6 class="mb-3 fw-bold">Stock Details</h6>

<div class="card basic-data-table">
    <div class="d-flex justify-content-end mb-2">
        <a href="<?= base_url('tppublisher/tpbookaddstock') ?>"
           class="btn rounded-pill btn-info-600 radius-8 px-20 py-11 text-sm">
           ADD STOCK
        </a>
    </div>

    <!-- Stock Table -->
    <div class="card-body">
        <?php if (!empty($stock_details)): ?>
            <table class="table table-hover zero-config" id="dataTable" data-page-length="10"> 
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Publisher</th>
                        <th>Author</th>
                        <th>Sku No</th>
                        <th>Book Id</th>
                        <th>Book</th>
                        <th>Stock In Hand</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stock_details as $index => $row): ?>
                    <tr>
                        <td><?= $index + 1; ?></td>
                        <td><?= esc($row->publisher_name); ?></td>
                        <td><?= esc($row->author_name); ?></td>
                        <td><?= esc($row->sku_no); ?></td>
                        <td><?= esc($row->book_id); ?></td>
                        <td><?= esc($row->book_title); ?></td>
                        <td><?= esc($row->stock_in_hand); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-muted text-sm">No stock data found.</p>
        <?php endif; ?>
    </div>
</div>
<br>
<h6 class="mb-3 fw-bold">Stock Ledger Details</h6>

<!-- Stock Ledger Tabs -->
<ul class="nav nav-tabs mt-4" id="ledgerTabs" role="tablist">
    <?php foreach($descriptions as $i => $desc): ?>
    <li class="nav-item" role="presentation">
        <button class="nav-link <?= $i === 0 ? 'active' : '' ?>" 
                id="tab-<?= $i ?>" 
                data-bs-toggle="tab" 
                data-bs-target="#content-<?= $i ?>" 
                type="button" role="tab">
            <?= esc($desc) ?>
        </button>
    </li>
    <?php endforeach; ?>
</ul>

<div class="tab-content mt-3">
    <?php foreach($descriptions as $i => $desc): ?>
    <div class="tab-pane fade <?= $i === 0 ? 'show active' : '' ?>" 
         id="content-<?= $i ?>" role="tabpanel">

        <table class="table table-hover zero-config" id="dataTable-<?= $i ?>" data-page-length="10"> 
            <thead>
                <tr>
                    <th>Sl. No.</th>
                    <th>Publisher</th>
                    <th>Author</th>
                    <th>Book</th>
                    <th>SKU</th>
                    <th>Stock In</th>
                    <th>Stock Out</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Group ledger by book_id for this description
                $books = [];
                foreach($ledgerData as $row){
                    if($row['description'] !== $desc) continue;

                    $bookId = $row['book_id'];
                    if(!isset($books[$bookId])){
                        $books[$bookId] = [
                            'publisher_name' => $row['publisher_name'],
                            'author_name'    => $row['author_name'],
                            'book_title'     => $row['book_title'],
                            'sku_no'         => $row['sku_no'],
                            'total_stock_in' => 0,
                            'total_stock_out'=> 0,
                        ];
                    }

                    // Add stock values
                    $books[$bookId]['total_stock_in']  += $row['total_stock_in'];
                    $books[$bookId]['total_stock_out'] += $row['total_stock_out'];
                }

                $slno = 1; // Start serial number
                ?>
                <?php foreach($books as $bookId => $book): ?>
                    <tr>
                        <td><?= $slno++; ?></td>
                        <td><?= esc($book['publisher_name']); ?></td>
                        <td><?= esc($book['author_name']); ?></td>
                        <td><?= esc($book['book_title']); ?></td>
                        <td><?= esc($book['sku_no']); ?></td>
                        <td><?= esc($book['total_stock_in']); ?></td>
                        <td><?= esc($book['total_stock_out']); ?></td>
                        <td>
                            <a href="<?= base_url('tppublisher/book-ledger-details/'.$bookId.'/'.urlencode($desc)) ?>" 
                               class="btn btn-primary-200 text-primary-800 radius-8 px-14 py-6 text-sm">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection(); ?>
