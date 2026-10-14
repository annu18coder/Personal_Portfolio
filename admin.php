<?php
require "db.php";
session_start();

if(!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true){
    http_response_code(403);
    exit("Access denied!");
}
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}
$sql = "SELECT * FROM contact_messages ORDER BY id DESC";

$stmt = $pdo->query($sql);

$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>

    <style>
                * {
            box-sizing: border-box;
        }

        body {
            margin: 0 auto;
            padding: 30px;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
        }

        h1{
            margin-bottom: 8px;
        }

        h2{
            margin-top: 30px;
        }

        .dashboard-card{
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgb(0, 0, 0, 0.06);
            margin: 20px 0;
        }
        .count{
            font-size: 28px;
            font-weight: bold;
            margin: 8px 0 0;
        }
        .table-wrapper{
            background: white;
            overflow-x: auto;
            border-radius: 10px;
            width: 100%;
            margin-bottom: 40px;
        }

        table{
            width: 100%;
            min-width: 750px;
            border-collapse: collapse;
        }
        th, td{
            padding: 14px;
            text-align: left;
            border-radius: 1px solid #e5e7eb;
        }
        th{
            background-color: #1f2937;
            color: white;
        }

        tbody tr:hover{
            background-color: #f9fafb;
        }

        td{
            overflow-wrap: anywhere;
        }

        .logout{
            display: flex;
            margin: 0 auto;
            padding: 10px 25px;
            background-color: #1a4581;
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 30px:

        }

        .delete-btn{
            background-color: #dc2626;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
        }

        .delete-btn:hover{
            background-color: #b91c1c;
        }

        @media (max-width: 600px){
            body{
                padding: 16px;
            }
            h1{
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <h1>Welcome to Admin Page!</h1>
    <p>
        Hello,
        <?php
            echo htmlspecialchars($_SESSION["admin_username"]);
        ?>!
    </p>
    <br><br>

    <h2>Contact Messages</h2>
    <br><br>
    <p>Total Messages: <?= count($messages) ?></p>
    <div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Messages</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>

    <tbody>
        <?php
            if(count($messages) > 0): ?>
            <?php
                foreach($messages as $message): ?>
                <tr>
                    <td>
                        <?=htmlspecialchars((string)$message["id"]) ?>
                    </td>
                    <td>
                        <?=htmlspecialchars($message["name"]) ?>
                    </td>
                    <td>
                        <?=htmlspecialchars($message["email"]) ?>
                    </td>
                    <td>
                        <?=htmlspecialchars($message["message"]) ?>
                    </td>
                    <td>
                        <?=htmlspecialchars($message["created_at"]) ?>
                    </td>
                    <td>
                        <form method="POST" action="delete-msg.php" onsubmit="return confirm('Are you sure you want to delete this message?');">
                            <input type="hidden" name="id" 
                                   value="<?= (int)$message['id'] ?>" >
                            <input type="hidden" name="csrf_token" 
                                   value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>" >

                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>

            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan = "6">No messages yet.</td>
            </tr>

        <?php endif; ?>
    </tbody>
</table>
</div>
    <a href="logout.php">
        <button type="submit" class="logout">Logout</button>
    </a>
    
</body>
</html>