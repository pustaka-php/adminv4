<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">        
        <div class="page-header">
            <div class="page-title">
               <h6 class="text-center">Google Book Details</h6>
            </div>  
        </div>
        <br>
        <div class="d-flex justify-content-center">
            <div class="card shadow-none border bg-gradient-start-1 h-100 small-card">
                <div class="card-body p-20">
                    <div class="d-flex align-items-center justify-content-between gap-3">
                        <div>
                            <p class="fw-medium text-primary-light mb-1">Total Books</p>
                            <h6 class="mb-0">
                                <?php echo isset($googlebooks['count'][0]['total_books']) ? $googlebooks['count'][0]['total_books'] : '0'; ?>
                            </h6>
                        </div>
                        <div class="w-50-px h-50-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
                            <iconify-icon icon="mdi:book" class="text-white text-2xl mb-0"></iconify-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
        <br>    
        <table class="zero-config table table-hover mt-4">
            <thead class="thead-dark">
                <tr>
                    <th>Title</th>
                    <th>Publication Date</th>
                    <th>Amount (₹)</th>
                    <th>Amount ($)</th>
                    <th>Amount (€)</th>
                </tr>
            </thead> 
            <tbody>   
                <?php if (!empty($googlebooks['google'])): ?>
                    <?php foreach ($googlebooks['google'] as $book): ?>
                        <tr>

                            <td>
                                <a href="<?php echo $book['play_store_link']?>"target="_blank">
                                    <?php echo htmlspecialchars($book['title'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($book['publication_date'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($book['inr_price_excluding_tax'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($book['usd_price_excluding_tax'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($book['eur_price_excluding_tax'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No book details found for this author.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>