<?php
include 'connect-db.php';
date_default_timezone_set('America/New_York');

if (isset($_POST['balance'])) {
    $balance = filter_var(trim($_POST['balance']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $sql = 'INSERT INTO balance (current_balance, last_update) VALUES (?, ?)';
    $statement = $pdo->prepare($sql);
    $data = array($balance, date('Y-m-d'));
    $statement->execute($data);

    // Redirect back to the main page after updating
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>