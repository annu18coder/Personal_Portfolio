<?php 
require "db.php";
session_start();

// $_SESSION["logged_in"] = true;
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";
    // $username = "admin";

    // $password_hash = password_hash("myPass123", PASSWORD_DEFAULT);
    // if(password_verify("myPass123", $password_hash)){
    //     echo "Password matches";
    // };

    // $sql = "SELECT INTO admins (username, password_hash) VALUES (:username, :password_hash)";

    // $sql = "SELECT id, username, password_hash FROM admins WHERE username =:username";
    $sql = "SELECT * FROM admins WHERE username = :username";

    // Yahan $pdo database connection hai, $sql query hai, aur $stmt prepared query ko represent karta hai.
    $stmt = $pdo->prepare($sql);

    // ":username" → SQL query ka placeholder.
    // $username → PHP variable jismein admin ka username hoga.
    // ":password_hash" → doosra placeholder.
    // $hash → password_hash() se generated hash.

    $stmt->execute([
        ":username" => $username,
        // ":password_hash" => $password_hash
    ]);

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if($admin){
        if(password_verify($password, $admin["password_hash"])){
        
            $_SESSION["logged_in"] = true;
            $_SESSION["admin_username"] = $admin["username"];
        
            header("Location: admin.php");
        }
        else{
            echo "Wrong password!";
        }
    }else{
        echo "Admin not found!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
    font-family: Arial, Helvetica, sans-serif;
    background: linear-gradient(135deg, #eef2ff, #f8fafc, #e0e7ff);
    color: #111827;
}

.login-container {
    width: 100%;
    max-width: 420px;
    padding: 40px 32px;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(31, 41, 55, 0.12);
}

.login-container h1 {
    margin-bottom: 10px;
    text-align: center;
    font-size: 30px;
    color: #111827;
}

.login-subtitle {
    margin-bottom: 30px;
    text-align: center;
    color: #6b7280;
    font-size: 14px;
    line-height: 1.6;
}

.login-container label {
    display: block;
    margin-bottom: 8px;
    font-size: 14px;
    font-weight: 600;
    color: #374151;
}

.login-container input {
    display: block;
    width: 100%;
    padding: 13px 14px;
    margin-bottom: 22px;
    border: 1px solid #d1d5db;
    border-radius: 10px;
    background: #f9fafb;
    color: #111827;
    font-size: 15px;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.login-container input:focus {
    border-color: #6366f1;
    background: #ffffff;
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.13);
}

.login-container button {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg, #6366f1, #3b82f6);
    color: white;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}

.login-container button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(99, 102, 241, 0.25);
}

.back-link {
    display: block;
    margin-top: 24px;
    text-align: center;
    color: #4f46e5;
    font-size: 14px;
    text-decoration: none;
}

.back-link:hover {
    text-decoration: underline;
}

@media (max-width: 480px) {
    .login-container {
        padding: 30px 22px;
    }

    .login-container h1 {
        font-size: 26px;
    }
}

    </style>
</head>
<body>
    
<div class="login-container">
    <h1>Admin Login</h1>

    <p class="login-subtitle">
        Enter your credentials to access your dashboard.
    </p>

    <form method="POST" action="admin-login.php">
        <label for="username">Username</label>
        <input
            type="text"
            id="username"
            name="username"
            placeholder="Enter your username"
            required
        >

        <label for="password">Password</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="Enter your password"
            required
        >

        <button type="submit">Login</button>
    </form>

    <a href="index.php" class="back-link">← Back to Portfolio</a>
</div>

</body>
</html>