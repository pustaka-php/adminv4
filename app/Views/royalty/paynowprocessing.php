<!DOCTYPE html>
<html>
<head>
    <title>Processing Payment</title>
    <meta http-equiv="refresh" content="2;url=<?= base_url('royalty/royaltyconsolidation') ?>">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            text-align: center;
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 4px 20px rgba(0,0,0,0.1);
            animation: fadeIn 0.6s ease-out;
        }
        .tick-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid #4CAF50;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            animation: popIn 0.5s ease-out forwards;
        }
        .tick {
            font-size: 50px;
            color: #4CAF50;
            animation: tickAppear 0.3s ease-out 0.3s forwards;
            opacity: 0;
        }
        @keyframes popIn {
            0% { transform: scale(0.5); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        @keyframes tickAppear {
            to { opacity: 1; }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .loading {
            width: 60px;
            height: 60px;
            border: 6px solid #ccc;
            border-top: 6px solid #4CAF50;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        h2 {
            margin: 10px 0;
            color: #333;
        }
        p {
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!empty($allSuccess) && $allSuccess): ?>
            <div class="tick-circle">
                <div class="tick">✔</div>
            </div>
            <h2>Payment Successful</h2>
            <p>You will be redirected shortly...</p>
        <?php else: ?>
            <div class="loading"></div>
            <h2>Processing your payment...</h2>
            <p>Please wait, you will be redirected shortly.</p>
        <?php endif; ?>
    </div>
</body>
</html>
