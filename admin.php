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

// Fetch customer data
$query = $pdo->query("SELECT * FROM customers");
$customers = $query->fetchAll(PDO::FETCH_ASSOC);

// Fetch messages if the 'section' is 'messages'
$messages = [];
if (isset($_GET['section']) && $_GET['section'] == 'messages') {
    $stmt = $pdo->prepare("SELECT * FROM contact_messages ORDER BY submitted_at DESC");
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch the full message details
if (isset($_GET['message_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM contact_messages WHERE id = :message_id");
    $stmt->bindParam(':message_id', $_GET['message_id']);
    $stmt->execute();
    $message = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>

    <header>
        <nav>
            <div class="nav__headers" id="home.php">
                <div class="nav__logos">
                    <a href="#">MAN1MAL</a>
                </div>
                <div class="nav__menu__btns" id="menu-btns">
                    <i class="ri-menu-lines"></i>
                </div>
            </div>
            <ul class="nav__link1" id="nav-links1">
                <ul>
                    <li><a href="admin.php">Customer List</a></li>
                    <li><a href="admin.php?section=messages">Messages</a></li>
                </ul>
            </ul>
        </nav>
    </header>

    <div class="container">
        <?php if (!isset($_GET['section']) || $_GET['section'] == 'customers'): ?>
            <h1>Customer List</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Remaining Hours</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($customer['id']); ?></td>
                            <td><?php echo htmlspecialchars($customer['name']); ?></td>
                            <td><?php echo htmlspecialchars($customer['email']); ?></td>
                            <td><?php echo htmlspecialchars($customer['remaining_hours']); ?></td>
                            <td>
                                <form action="update_hours.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $customer['id']; ?>">
                                    <input type="number" name="hours" placeholder="Add/Deduct Hours">
                                    <button type="submit">Update Hours</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php elseif ($_GET['section'] == 'messages'): ?>
            <h1>Visitor Messages</h1>
            <?php if (count($messages) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $msg): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($msg['name']); ?></td>
                                <td><?php echo htmlspecialchars($msg['email']); ?></td>
                                <td><?php echo htmlspecialchars(substr($msg['message'], 0, 50)); ?>...</td>
                                <td><?php echo htmlspecialchars($msg['submitted_at']); ?></td>
                                <td>
                                    <a href="admin.php?section=message&message_id=<?php echo $msg['id']; ?>">View Full Message</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No messages found.</p>
            <?php endif; ?>

        <?php elseif (isset($_GET['message_id']) && isset($message)): ?>
            <h1>Message Details</h1>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($message['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($message['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($message['phone']); ?></p>
            <p><strong>Message:</strong><br><?php echo nl2br(htmlspecialchars($message['message'])); ?></p>
            <p><strong>Date Sent:</strong> <?php echo htmlspecialchars($message['submitted_at']); ?></p>
            <a href="admin.php?section=messages">Back to Messages</a>
        <?php endif; ?>
    </div>

</body>

</html>
