<?php

require "db.php";

header("Content-Type: application/json");

if($_SERVER["REQUEST_METHOD"] !== "POST"){
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "message" => "Invalid request."
    ]);
    exit;
}

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $message = trim($_POST["msg"] ?? "");

    // validation
    if($name === "" || $message === ""){
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "Name and message are required."
        ]);
        exit();
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "Please enter a valid email address."
        ]);
        exit();
    }

    // Like mongodb here we need to prepare the SQL Query
    // Prepare the SQL query

    try{
        $sql = "INSERT INTO contact_messages(name, email, message)
        VALUES(:name, :email, :message)";

        $stmt = $pdo->prepare($sql);

        // Insert the submitted values
        $stmt->execute([
            ":name" => $name,
            ":email" => $email,
            ":message" => $message
        ]);
        
        echo json_encode([
            "success" => true,
            "message" => "Thank you! Your message has been saved successfully!"
        ]);

    }
    catch(PDOException $e){
        error_log("Contact form database error: ".$e->getMessage());
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => "Sorry, Your message could not be saved. Please try again."
        ]);
}

?>