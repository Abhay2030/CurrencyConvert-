<?php
$convertedAmount = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $from = $_POST['from'];
    $to = $_POST['to'];
    $amount = floatval($_POST['amount']);

    $apiKey = 'c1f320a55598e703b0f6252e'; 
    $url = "https://v6.exchangerate-api.com/v6/$apiKey/pair/$from/$to";

    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if ($data && isset($data['conversion_rate'])) {
        $rate = $data['conversion_rate'];
        $convertedAmount = number_format($amount * $rate, 2);
    } else {
        $error = "Failed to fetch exchange rate. Please check your API key or try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Currency Converter</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="converter">
    <h2>💱 Currency Converter</h2>
    <form method="post">
        <input type="number" name="amount" placeholder="Enter amount" step="0.01" required>
        <select name="from">
            <option value="USD">USD</option>
            <option value="INR">INR</option>
            <option value="EUR">EUR</option>
            <option value="JPY">JPY</option>
        </select>
        <select name="to">
            <option value="INR">INR</option>
            <option value="USD">USD</option>
            <option value="EUR">EUR</option>
            <option value="JPY">JPY</option>
        </select>
        <button type="submit">Convert</button>
    </form>

    <?php if ($convertedAmount): ?>
        <p class="result">Converted Amount: <strong><?= $convertedAmount . ' ' . $to ?></strong></p>
    <?php elseif ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>
</div>
</body>
</html>
