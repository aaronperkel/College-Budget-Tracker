<?php include 'top.php'; 
    date_default_timezone_set('America/New_York');

    function getCurrentDate() {
        return date('Y-m-d');
    }

    function getStartOfMonth() {
        return date('Y-m-01');
    }

    function checkAndUpdateBalance($pdo) {
        $currentDate = getCurrentDate();
        $startOfMonth = getStartOfMonth();

        $sql = "SELECT current_balance, last_update FROM balance ORDER BY id DESC LIMIT 1";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        $lastUpdate = $result['last_update'];
        $current_balance = $result['current_balance'];
        if (!$lastUpdate || $lastUpdate < $startOfMonth) {
            $current_balance += 250;
            $sql = "INSERT INTO balance (current_balance, last_update) VALUES (?, ?)";
            $statement = $pdo->prepare($sql);
            $data = array($current_balance, $currentDate);
            $statement->execute($data);
        }
    }
    checkAndUpdateBalance($pdo);
?>
        <main>
            <div class="h2-container">
                <h2>Current Balance:</h2>
                <form method="POST" action="update_balance.php">
                    <?php
                        $sql = "SELECT current_balance FROM balance ORDER BY id DESC LIMIT 1";
                        $statement = $pdo->prepare($sql);
                        $statement->execute();
                        $result = $statement->fetch(PDO::FETCH_ASSOC);
                        $current_balance = $result['current_balance'];
                        print '<input class="balance-input" type="text" name="balance" value="$' . $current_balance . '">';
                    ?>
                </form>
            </div>

            <table id="transactionHistory">
                <th colspan="4">Transaction History</th>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Receipt</th>
                </tr>
                <?php
                    $sql = 'SELECT date, description, amount, receipt_link FROM transactions';
                    $statement = $pdo->prepare($sql);
                    $statement->execute();
                    $cells = $statement->fetchAll();

                    foreach($cells as $cell) {
                        print '<tr>';
                        print '<td>' . $cell['date'] . '</td>';
                        print '<td>' . $cell['description'] . '</td>';
                        print '<td>$' . $cell['amount'] . '</td>';
                        print '<td><a href="receipts/' . $cell['receipt_link'] . '" target="_blank">View Receipt</a></td>';
                        print '</tr>';
                    }
                ?>
            </table>

            <table>
                <form id="transactionForm" method="POST" action="new_transaction.php">
                    <tr>
                        <th colspan="4">New Transaction</th>
                    </tr>
                    <tr>
                        <td><input type="date" id="date" name="date" required></td>
                        <td><input type="text" id="description" name="description" placeholder="Description:" required></td>
                        <td><input type="number" id="amount" name="amount" step="0.01" placeholder="$12.34" required></td>
                        <td><input type="text" id="receipt" name="receipt" placeholder="Path:"></td>
                    </tr> 
                    <tr>
                        <td colspan="4"><input type="submit"></input></td>
                    </tr>
                </form>
            </table>
        </main>
        <?php include 'footer.php'; ?>