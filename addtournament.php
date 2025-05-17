<?php
session_start();
include 'db-connection.php'; // Include your DB connection

// Check if the user is logged in
if (!isset($_SESSION['organizername'])) {
    header("Location: organizer-login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect tournament details from the form
    $organizer_name = $_SESSION['organizername'];
    $tournament_name = $_POST['tournament-name'];
    $game_name = $_POST['game-name'];
    $game_mode = $_POST['game-mode'];
    $max_slots = $_POST['maxslots'];
    $entry_fee = $_POST['entry-fee'];
    $prize_pool = $_POST['price-pool'];
    $start_date = $_POST['start-date'];
    $start_time = $_POST['time'];

    // Debugging the variables
    var_dump($organizer_name, $tournament_name, $game_name, $game_mode, $max_slots, $entry_fee, $prize_pool, $start_date, $start_time);

    // Prepare SQL query to insert the tournament details
    $sql = "INSERT INTO tournaments (organizername, tournament_name, game_name, game_mode, max_slots, entry_fee, prize_pool, start_date, start_time)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Check if the query preparation is successful
    if (!$stmt) {
        die("SQL Error: " . $conn->error); // Debugging line
    }

    // Bind parameters
    if (!$stmt->bind_param("ssssiiiss", $organizer_name, $tournament_name, $game_name, $game_mode, $max_slots, $entry_fee, $prize_pool, $start_date, $start_time)) {
        die("Binding Error: " . $stmt->error);
    }

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to organize.php after successful insertion
        header("Location: organize.php");
        exit();
    } else {
        die("Execution Error: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
}
?>
