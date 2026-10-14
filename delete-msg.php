<?php
session_start();
require "db.php";

if(!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true){
    http_response_code(403);
    exit("Access denied!");
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Method not allowed.");
}

// verify CSRF token
$token = $_POST["csrf_token"] ?? "";
   
    if(!is_string($token) || !hash_equals($_SESSION["csrf_token"] ?? "", $token))
        {
            http_response_code(403);
            exit("Invalid request.");
        }

    $id = $_POST["id"] ?? "";

    if(filter_var($id, FILTER_VALIDATE_INT) !== false && $id > 0){
        $sql = "DELETE FROM contact_messages WHERE id = :id";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ":id" => $id
        ]);
    }

header("Location: admin.php");
exit;
?>