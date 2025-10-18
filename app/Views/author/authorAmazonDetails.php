<div id="content" class="main-content">
    <div class="layout-px-spacing">        
        <div class="page-header">
            <div class="page-title">
                <center>
                <h3>Amazon Book Details</h3>
            </div>
        </div>
        <br>
        <div class="cards-container">
            <div class="card">
                <h2>Total Books</h2>
                <p><?php echo isset($channel_wise['count'][0]['total_books']) ? $channel_wise['count'][0]['total_books'] : '0'; ?></p>
            </div>
            
            <div class="card">
                <h2>IN Enabled</h2>
                <p><?php echo isset($channel_wise['count'][0]['total_in_enabled']) ? $channel_wise['count'][0]['total_in_enabled'] : '0'; ?></p>
            </div>
            
            <div class="card">
                <h2>US Enabled</h2>
                <p><?php echo isset($channel_wise['count'][0]['total_us_enabled']) ? $channel_wise['count'][0]['total_us_enabled'] : '0'; ?></p>
            </div>
            
            <div class="card">
                <h2>UK Enabled</h2>
                <p><?php echo isset($channel_wise['count'][0]['total_uk_enabled']) ? $channel_wise['count'][0]['total_uk_enabled'] : '0'; ?></p>
            </div>
        </div>
        <br>
        <table class="zero-config table table-hover mt-4">
            <thead class="thead-dark">
                <tr>
                    <th>Book Title</th>
                    <th>Amount (₹)</th>
                    <th>Amount ($)</th>
                    <th>(IN) Activation Date</th>
                    <th>(UK) Activation Date</th>
                    <th>(US) Activation Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($channel_wise['channel'])): ?>
                    <?php foreach ($channel_wise['channel'] as $book): ?>
                        <tr>
                            <td>
                                <a href="https://www.amazon.in/dp/<?php echo urlencode($book['asin'] ?? ''); ?>" target="_blank">
                                    <?php echo htmlspecialchars($book['title'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($book['digital_list_price_inr'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($book['digital_list_price_usd'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($book['ku_activation_date'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($book['ku_uk_activation_date'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($book['ku_us_activation_date'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <br>
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