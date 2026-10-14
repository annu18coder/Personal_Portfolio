# PHP LEARNINGS:
process.php: 
echo "Name: " . htmlspecialchars($name); 
htmlspecialchars(var_name) : used to bring the html elements safely.

<?php 
$host = "localhost"; // mysql server ka address
$dbname = "porfolio_db";      //  database ka naam
$username = "root";     
$password = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    echo "Database connected successfully!";
} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit("Database connection failed. Please check the database configuration.");
}


new PDO(): PHP Data Objects
PHP aur MYSQL k beech connection bnata h

try{}: connection successful hone pr code execute krta h

catch{}: connection m error ane pr use handle krta h
?>