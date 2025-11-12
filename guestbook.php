<?php
// Database connection
$servername = "localhost";
$username   = "your_db_username"; // replace with your DB username
$password   = "your_db_password"; // replace with your DB password
$dbname     = "guestbook_app";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert new entry securely with prepared statements
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = $_POST['name'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO guestbook_entries (name, message) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $message);
    $stmt->execute();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Cadillac Technology Guestbook</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>🚗 Cadillac Technology Guestbook</h1>
    <p>Driving Innovation Forward</p>
    <nav>
      <a href="guestbook.php">Home</a> |
      <a href="about.html">About</a>
    </nav>
  </header>

  <section class="form-area">
    <h2>Sign the Guestbook</h2>
    <form method="post">
      <label>Name:</label>
      <input type="text" name="name" required><br>
      <label>Message:</label><br>
      <textarea name="message" required></textarea><br>
      <input type="submit" value="Post Message">
    </form>
  </section>

  <section class="messages">
    <h2>Recent Messages</h2>
    <?php
    $result = $conn->query("SELECT * FROM guestbook_entries ORDER BY submitted_at DESC LIMIT 20");
    while($row = $result->fetch_assoc()):
    ?>
      <div class="entry">
        <p><strong><?= htmlspecialchars($row['name']) ?></strong> wrote:</p>
        <p><?= nl2br(htmlspecialchars($row['message'])) ?></p>
        <small>Posted on <?= $row['submitted_at'] ?></small>
        <hr>
      </div>
    <?php endwhile; ?>
  </section>

  <footer>
    <p>© 2025 Cadillac Technology | Academic Project by Niuskary Salazar Castillo</p>
  </footer>
</body>
</html>
