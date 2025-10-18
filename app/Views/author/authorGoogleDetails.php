<?= $this->extend('layout/layout1'); ?>
<?= $this->section('script'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">        
        <div class="page-header">
            <div class="page-title">
                <center>
               <h3>Google Book Details</h3>
            </div>  
        </div>
        <br>
        <div class="cards-container">
            <div class="card">
                <h2>Total Books</h2>
                <p><?php echo isset($googlebooks['count'][0]['total_books']) ? $googlebooks['count'][0]['total_books'] : '0'; ?></p>
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
<style>
.cards-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    margin-top: 20px;
}

.card {
    background: #d6d6f5;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 250px;
    text-align: center;
    transition: transform 0.3s ease-in-out;
}

.card:hover {
    transform: translateY(-5px);
}

.card h2 {
    font-size: 18px;
    color: #333;
    margin-bottom: 10px;
}

.card p {
    font-size: 24px;
    font-weight: bold;
    color:rgb(12, 13, 14);
}
</style>
<?= $this->endSection(); ?>