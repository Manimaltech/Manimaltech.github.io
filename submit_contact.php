<?php
// Database connection settings
$host = 'localhost';
$dbname = 'pc_rental';  // your database name
$username = 'root';     // your PHPMyAdmin username
$password = '';         // your PHPMyAdmin password

// Connect to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);

    // Insert the data into the database
    $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, phone, message) VALUES (:name, :email, :phone, :message)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':message', $message);

    if ($stmt->execute()) {
        // Set success to true if the message was inserted successfully
        $success = true;
    } else {
        // Set error to true if something went wrong
        $error = true;
    }
}
?>
