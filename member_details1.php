<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Details</title>
    <style>
        :root {
            --color-primary: #6200ea;
            --color-secondary: #03dac5;
            --color-bg: #121212;
            --color-text: #e0e0e0;
            --color-accent: #bb86fc;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: var(--color-bg);
            color: var(--color-text);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #1e1e1e;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            width: 80%;
            max-width: 600px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: var(--color-accent);
            text-align: center;
        }

        .member-details, .balance-details {
            margin-bottom: 20px;
            background-color: #2c2c2c;
            padding: 20px;
            border-radius: 8px;
        }

        .member-details p, .balance-details p {
            margin: 10px 0;
        }

        input[type="text"] {
            padding: 10px;
            width: calc(100% - 22px);
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-top: 5px;
            box-sizing: border-box;
            background-color: #3c3c3c;
            color: var(--color-text);
        }

        button[type="submit"], .custom-button {
            padding: 10px 20px;
            background-color: var(--color-primary);
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover, .custom-button:hover {
            background-color: var(--color-secondary);
        }

        .back-button {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .back-button img {
            width: 26px;
            height: 26px;
        }

        .transaction-history {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        session_start();

        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "banks2";
        date_default_timezone_set('Asia/Kolkata');

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        function sanitize_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if (isset($_GET['member_id'])) {
            $member_id = sanitize_input($_GET['member_id']);

            if (isset($_POST['today_amount'])) {
                $today_amount = sanitize_input($_POST['today_amount']);

                $stmt_update = $conn->prepare("UPDATE member_balances SET today_amount = today_amount + ?, total_balance = total_balance + ? WHERE member_id = ?");
                $stmt_update->bind_param("ddi", $today_amount, $today_amount, $member_id);

                if ($stmt_update->execute()) {
                    $amount = $today_amount;
                    $date = date('Y-m-d');
                    $time = date('H:i:s');
                    $done_by = "Some User";
                    $type_of_account = "Savings Account";

                    $stmt_insert = $conn->prepare("INSERT INTO transactions (member_id, amount, date, time, done_by, type_of_account) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt_insert->bind_param("idssss", $member_id, $amount, $date, $time, $done_by, $type_of_account);

                    if ($stmt_insert->execute()) {
                        echo "Transaction recorded successfully";
                    } else {
                        echo "Error recording transaction: " . $stmt_insert->error;
                    }
                } else {
                    echo "Error updating balances: " . $stmt_update->error;
                }
                $stmt_update->close();
            }

            $stmt_total_balance = $conn->prepare("SELECT SUM(amount) AS total_balance FROM transactions WHERE member_id = ?");
            $stmt_total_balance->bind_param("i", $member_id);
            $stmt_total_balance->execute();
            $result_total_balance = $stmt_total_balance->get_result();
            $row_total_balance = $result_total_balance->fetch_assoc();
            $total_balance = $row_total_balance['total_balance'];
            $stmt_total_balance->close();

            $stmt_select = $conn->prepare("SELECT * FROM members WHERE member_id = ?");
            $stmt_select->bind_param("i", $member_id);
            $stmt_select->execute();
            $result = $stmt_select->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                ?>
                <h1>Member Details</h1>
                <div class="member-details">
                    <p><strong>Member ID:</strong> <?php echo $row['member_id']; ?></p>
                    <p><strong>Name:</strong> <?php echo $row['name']; ?></p>
                    <p><strong>Account Number:</strong> <?php echo $row['account_no']; ?></p>
                    <p><strong>Address:</strong> <?php echo $row['address']; ?></p>
                    <p><strong>Class:</strong> <?php echo $row['class']; ?></p>
                </div>
                <div class="balance-details">
                    <h2>Balance Details</h2>
                    <p><strong>Total Balance:</strong> <?php echo $total_balance; ?></p>
                </div>
                <div class="transaction-history">
                    <button onclick="location.href='transaction_history.php?member_id=<?php echo $member_id; ?>';" type="button" class="custom-button">Transaction History</button>
                    <button onclick="location.href='recurring_deposit.php?member_id=<?php echo $member_id; ?>';" type="button" class="custom-button">Recurring Deposit</button>
                </div>
                <div class="back-button">
                    <button onclick="window.location.href='welcome.php';">
                        <img src="https://img.icons8.com/metro/26/home.png" alt="home"/>
                    </button>
                </div>
                <?php
            } else {
                echo "Member ID not found";
            }
            $stmt_select->close();
        } else {
            echo "No member ID provided";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
