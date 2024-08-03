<?php
$phpSelf = htmlspecialchars($_SERVER['PHP_SELF']);
$pathParts = pathinfo($phpSelf);
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Aaron Perkel - 529 Tracker</title>
        <meta name="author" content="Aaron Perkel">
        <meta name="description" content="Tracking my 529 Transactions">

        <meta name="viewport" content="width=device-width, 
        initial-scale=1.0">

        <link rel="apple-touch-icon" sizes="16x16" href="../img/apple-touch-icon.png">
        <link rel="icon" href="../img/favicon.ico">

        <link href="css/custom.css?version=<?php print time(); ?>" 
                rel="stylesheet" 
                type="text/css">
    </head>
    <?php
    print '<body class="' . $pathParts['filename'] . '">';
    print '<!-- #################   Body element    ################# -->';
    include 'connect-db.php';
    include 'header.php';
    ?>