<?php
session_start();
include 'db-connection.php';

if (!isset($_SESSION['organizername'])) {
    header("Location: organizer-login.php");
    exit();
}

$organizer_username = $_SESSION['organizername'];

// Query to fetch tournaments organized by the logged-in organizer
$sql = "SELECT * FROM tournaments WHERE organizername = ? ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $organizer_username);
$stmt->execute();
$result = $stmt->get_result();
$tournaments = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Osmania Esports - Organize</title>
    <link rel="stylesheet" href="organize.css">
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
            <a class="current-page" href="organize.php">Organize</a>
            <a href="about.html">About Us</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <div class="tournament-menu">
            <nav>
            <a href="#" onclick="toggleTournamentSection('your-tournaments')"><span id="your-menu">Your Tournaments</span></a>
        <span id="add-menu"><a href="#" onclick="toggleTournamentSection('add-tournament')">Add Tournament</a></span>
     </nav>
        </div>

        <section class="welcome-heading">
            <h1 class="title">Welcome, <?php echo htmlspecialchars($_SESSION['organizername']); ?>!</h1>
            <p class="subtitle">Every event you organize brings us one step closer to greatness. Keep pushing the boundaries!</p>
        </section>

        <div class="content">
            <!-- Your Tournaments Section -->
            <div class="your-tournaments" id="your-tournaments">
                <h2>Your Tournaments</h2>
                <div class="tournaments-box">
                    <?php if (count($tournaments) > 0): ?>
                        <?php foreach ($tournaments as $tournament): ?>
                            <div class="tournaments">
                                <h3><?php echo htmlspecialchars($tournament['tournament_name']); ?></h3>
                                <p><strong>Game:</strong> <?php echo htmlspecialchars($tournament['game_name']); ?></p>
                                <p><strong>Date:</strong> <?php echo htmlspecialchars($tournament['start_date']); ?></p>
                                <p><strong>Time:</strong> <?php echo htmlspecialchars($tournament['start_time']); ?></p>

                                <?php
                                date_default_timezone_set('Asia/Kolkata');
                                $start_datetime = $tournament['start_date'].' '.$tournament['start_time'];
                                $current_time = new DateTime();
                                $target_time = new DateTime($start_datetime);
                                $time_difference = $current_time->getTimestamp() - $target_time->getTimestamp();
                                ?>

                                <?php if ($time_difference >= -1200 && $time_difference < 600): ?>
                                    <form method="POST" action="update-room.php">
                                        <input type="hidden" name="tournament_id" value="<?php echo $tournament['id']; ?>">
                                        <label for="room_id">Room ID:</label>
                                        <input type="text" name="room_id" placeholder="Enter Room ID" required>
                                        <label for="room_password">Room Password:</label>
                                        <input type="text" name="room_password" placeholder="Enter Room Password" required>
                                        <button type="submit">Save</button>
                                    </form>
                                <?php elseif ($time_difference < -1200): ?>
                                    <p class="info">You can provide the Room ID and Password <strong>20 minutes</strong> before the tournament starts.</p>
                                <?php else: ?>
                                    <p class="info">The tournament has already started or passed.</p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="no-tournament">You haven't organized any tournaments yet!</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Add Tournament Section -->
            <div class="add-tournament" id="add-tournament" style="display:none;">
                <h2>Add a Tournament</h2>
                <form method="POST" action="addtournament.php">
                    <label for="tournament-name">Name of the Tournament:</label>
                    <input id="tournament-name" placeholder="Enter name of the Tournament" name="tournament-name" required>
                    
                    <label for="game-name">Select the Game:</label>
                    <select id="game-name" name="game-name" required>
                        <option value="">Select a game</option>
                        <option value="BGMI">BGMI</option>
                        <option value="FREE FIRE">FREE FIRE</option>
                        <option value="VALORANT">VALORANT</option>
                        <option value="COD MOBILE">COD MOBILE</option>
                    </select>

                    <label for="game-mode">Select a Mode:</label>
                    <select id="game-mode" name="game-mode" required>
                        <option value="">Select a mode</option>
                        <option value="SOLO">SOLO</option>
                        <option value="DUO">DUO</option>
                        <option value="SQUAD">SQUAD</option>
                    </select>

                    <label for="slots">Number of Slots:</label>
                    <input type="number" id="slots" name="maxslots" required placeholder="Max slots" min="1">

                    <label for="entry-fee">Entry Fee (0 for free):</label>
                    <input type="number" id="entry-fee" name="entry-fee" required placeholder="Enter entry fee">

                    <label for="price-pool">Prize Pool:</label>
                    <input id="price-pool" type="number" name="price-pool" required placeholder="Enter prize pool">

                    <label for="start-date">Tournament Date:</label>
                    <input type="date" id="start-date" name="start-date" required>

                    <label for="time">Tournament Time:</label>
                    <input type="time" id="time" name="time" required>

                    <button type="submit">Add Tournament</button>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Osmania Esports. All rights reserved.</p>
    </footer>

    <script src="my-tournaments.js"></script>
    <script>
        // Toggle between the "Your Tournaments" and "Add Tournament" views
        function toggleTournamentView(view) {
            document.getElementById('your-tournaments').style.display = (view === 'your-tournaments') ? 'block' : 'none';
            document.getElementById('add-tournament').style.display = (view === 'add-tournament') ? 'block' : 'none';
        }
    </script>
</body>
</html>
