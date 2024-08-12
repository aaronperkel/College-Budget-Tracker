<?php
include 'connect-db.php';
date_default_timezone_set('America/New_York');

$date = htmlspecialchars($_POST['date']);
$description = htmlspecialchars($_POST['description']);
$amount = htmlspecialchars($_POST['amount']);
$receiptLink = htmlspecialchars($_POST['receipt']);

$sql = 'SELECT current_balance FROM balance ORDER BY id DESC LIMIT 1';
$statement = $pdo->prepare($sql);
$statement->execute();
$result = $statement->fetch(PDO::FETCH_ASSOC);
$current_balance = (float) $result['current_balance'];

$sql = 'INSERT INTO balance (current_balance, last_update) VALUES (?, ?)';
$statement = $pdo->prepare($sql);
$data = array($current_balance - (float) $amount, $date);
$statement->execute($data);

$sql = 'INSERT INTO transactions (date, description, amount, receipt_link) VALUES (?, ?, ?, ?)';
$statement = $pdo->prepare($sql);
$data = array($date, $description, $amount, $receiptLink);
$statement->execute($data);

# Redirect back to the main page after updating
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>