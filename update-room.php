<?php
session_start();
include 'db-connection.php';

if (!isset($_SESSION['organizername'])) {
    header("Location: organizer-login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tournament_id = $_POST['tournament_id'];
    $room_id = $_POST['room_id'];
    $room_password = $_POST['room_password'];
    $update_sql = "UPDATE tournaments SET room_id = ?, room_password = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssi", $room_id, $room_password, $tournament_id);

    if ($update_stmt->execute()) {
        echo "<script>
                alert('Room ID and Password updated successfully!');
                window.location.href = 'organize.php';
              </script>";
    } else {
        echo "<script>
                alert('Failed to update Room ID and Password. Please try again.');
                window.location.href = 'organize.php';
              </script>";
    }
    $update_stmt->close();
    $stmt->close();
    $conn->close();
}
?>
