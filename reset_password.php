<?php
// Include the database configuration file
require 'db-connection.php';

// Handle password reset submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $playerName = $_POST['player_name'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate the form data
    if (empty($playerName) || empty($newPassword) || empty($confirmPassword)) {
        echo "<script>alert('All fields are required. Please try again.'); window.history.back();</script>";
        exit;
    }

    // Check if the passwords match
    if ($newPassword !== $confirmPassword) {
        echo "<script>alert('Passwords do not match. Please try again.'); window.history.back();</script>";
        exit;
    }

    // Update the password in the players table for the specific player
    $query = "UPDATE players SET password = ? WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $confirmPassword, $playerName);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Password successfully reset for player: " . htmlspecialchars($playerName) . "'); window.location.href='player-login.html';</script>";
        } else {
            echo "<script>alert('No such player found. Please check the player name.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Failed to reset password. Please try again later.'); window.history.back();</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="player-login.css">
    <title>Reset Password</title>
    
</head>
<body>
    <main>
<section class="login-container">
    <h2>Reset Password</h2>
    <form method="POST" action="">
        <div class="input-group">
        <label for="player_name">Player Name:</label>
        <input type="text" id="player_name" name="player_name" placeholder="Enter your player name" required>
</div>
<div class="input-group">
<label for="password">New Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter new password" required>
        </div>
        <div class="input-group">

        <label for="confirm_password">Re-enter Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter new password" required>
        </div>
        <button type="submit" class="login-btn">Reset Password</button>
    </form>
</section>
</main>
</body>
</html>
