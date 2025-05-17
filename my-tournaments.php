<?php
session_start();
include 'db-connection.php';

$username = $_SESSION['username'];

$sql = 'SELECT * FROM tournament_registrations tr 
        INNER JOIN tournaments t 
        ON tr.tournament_id = t.id 
        WHERE tr.player_username = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$upcoming = [];
$ongoing = [];
$completed = [];
$time_difference;
date_default_timezone_set('Asia/Kolkata');

$sql1 = "UPDATE tournaments SET status = ? WHERE id = ?";
$stmt1 = $conn->prepare($sql1);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $start_datetime = $row['start_date'].' '.$row['start_time'];
        $current_time = new DateTime();
        $target_time = new DateTime($start_datetime);
        $time_difference = $current_time->getTimestamp() - $target_time->getTimestamp();

        $stmt1->bind_param('si', $status, $id);

        if ($time_difference < -900) {
            $upcoming[] = $row;
        } elseif ($time_difference >= -900 && $time_difference <= 1800) {
            $ongoing[] = $row;
            $status = 'ongoing';
            $id = $row['id'];
            $stmt1->execute();
        } else {
            $completed[] = $row;
            $status = 'completed';
            $id = $row['id'];
            $stmt1->execute();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tournaments - Osmania Esports</title>
    <link rel="stylesheet" href="my-tournaments.css">
    <link rel="icon" href="images/osmania-esports-logo-removebg.png">
</head>
<body>
    <header>
    <div class="header-left">
            <img src="images/osmania-esports-logo-removebg.png" alt="Osmania Esports Logo" class="logo">
            <h1 class="header-title">Osmania Esports</h1>
        </div>
        <nav class="menu-bar">
            <a href="index.php">Home</a>
            <a class="current-page" href="my-tournaments.php">My Tournaments</a>
            <a href="logout.php">Logout</a>
            <a href="about.html">About Us</a>
            <span class="welcome-message">Welcome, <?php echo htmlspecialchars($username); ?>!</span>
        </nav>
    </header>

    

    <main>
    <div class="submenu">
        <a id="upcoming-tab" class="active" onclick="showSection('upcoming')">Upcoming</a>
        <a id="ongoing-tab" onclick="showSection('ongoing')">Ongoing</a>
        <a id="completed-tab" onclick="showSection('completed')">Completed</a>
    </div>
        <div class="tournaments-box active" id="upcoming">
            <?php if (count($upcoming) > 0): ?>
                <?php foreach ($upcoming as $tournament): ?>
                    <div class="tournaments">
                        <h3><?php echo htmlspecialchars($tournament['tournament_name']); ?></h3>
                        <p><strong>Game: </strong> <?php echo htmlspecialchars($tournament['game_name']); ?></p>
                        <p><strong>Prize Pool: </strong> ₹<?php echo htmlspecialchars($tournament['prize_pool']); ?></p>
                        <p><strong>Start Date: </strong> <?php echo htmlspecialchars($tournament['start_date']); ?></p>
                        <p><strong>Start Time: </strong> <?php echo htmlspecialchars($tournament['start_time']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-tournament">No upcoming tournaments!</p>
            <?php endif; ?>
        </div>

        <div class="tournaments-box" id="ongoing">
            <?php if (count($ongoing) > 0): ?>
                <?php foreach ($ongoing as $tournament): ?>
                    <div class="tournaments">
                        <h3><?php echo htmlspecialchars($tournament['tournament_name']); ?></h3>
                        <p><strong>Game: </strong> <?php echo htmlspecialchars($tournament['game_name']); ?></p>
                        <p><strong>Prize Pool: </strong> ₹<?php echo htmlspecialchars($tournament['prize_pool']); ?></p>
                        <p><strong>Start Date: </strong> <?php echo htmlspecialchars($tournament['start_date']); ?></p>
                        <p><strong>Start Time: </strong> <?php echo htmlspecialchars($tournament['start_time']); ?></p>
                        <p><strong>Room ID: </strong> <?php echo htmlspecialchars($tournament['room_id']); ?></p>
                        <p><strong>Password: </strong> <?php echo htmlspecialchars($tournament['room_password']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-tournament">No ongoing tournaments!</p>
            <?php endif; ?>
        </div>

        <div class="tournaments-box" id="completed">
            <?php if (count($completed) > 0): ?>
                <?php foreach ($completed as $tournament): ?>
                    <div class="tournaments">
                        <h3><?php echo htmlspecialchars($tournament['tournament_name']); ?></h3>
                        <p><strong>Game: </strong> <?php echo htmlspecialchars($tournament['game_name']); ?></p>
                        <p><strong>Prize Pool: </strong> ₹<?php echo htmlspecialchars($tournament['prize_pool']); ?></p>
                        <p><strong>Start Date: </strong> <?php echo htmlspecialchars($tournament['start_date']); ?></p>
                        <p><strong>Start Time: </strong> <?php echo htmlspecialchars($tournament['start_time']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-tournament">No completed tournaments!</p>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Osmania Esports. All rights reserved.</p>
    </footer>

    <script src="my-tournaments.js"></script>
</body>
</html>
