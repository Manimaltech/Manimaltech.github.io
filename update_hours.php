<?php
// Database connection settings
$host = 'localhost';
$dbname = 'pc_rental';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Get the customer ID and hours from the POST request
if (isset($_POST['id']) && isset($_POST['hours'])) {
    $id = (int) $_POST['id'];
    $hours = (int) $_POST['hours'];

    // Update the remaining hours in the database
    $stmt = $pdo->prepare("UPDATE customers SET remaining_hours = remaining_hours + :hours WHERE id = :id");
    $stmt->bindParam(':hours', $hours);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "Hours updated successfully!";
    } else {
        echo "Failed to update hours.";
    }

    // Redirect back to the admin panel
    header("Location: admin.php");
    exit;
}
?>
