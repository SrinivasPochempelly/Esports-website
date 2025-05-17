<?php
session_start();
include 'db-connection.php';

$sql = "SELECT * FROM tournaments WHERE start_date >= CURDATE() and status='upcoming' ORDER BY start_date ASC";
$result = $conn->query($sql);
$upcoming_tournaments = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Osmania Esports</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="organize.css">
    <link rel="icon" href="images/osmania-esports-logo-removebg.png">
</head>
<body>
    <?php
    if(isset($_SESSION['username'])){
        $is_logged_in = true;
        $name = $_SESSION['username'];
    }
    else if(isset($_SESSION['organizername'])){
        $is_logged_in = true;
        $name = $_SESSION['organizername'];
    }
    else {
        $is_logged_in = false;
    }
    ?>

    <header>
    <div class="header-left">
            <img src="images/osmania-esports-logo-removebg.png" alt="Osmania Esports Logo" class="logo">
            <h1 class="header-title">Osmania Esports</h1>
        </div>
        <nav>
            <a class="current-page" href="index.php">Home</a>
            <?php if($is_logged_in): ?>
                <?php if(isset($_SESSION['organizername'])): ?>
                    <a href="organize.php">Organize</a>
                <?php else: ?>
                    <a href="my-tournaments.php">My Tournaments</a>
                <?php endif; ?>
            <?php endif; ?>
            <a href="about.html">About Us</a>
            <?php if ($is_logged_in): ?>
                <a href="logout.php" id="logout-menu">Logout</a>
                <span class="welcome-message">Welcome, <?php echo htmlspecialchars($name); ?>!</span>
            <?php else: ?>
                <a id="player-menu" href="player-login.html">Player Login</a>
                <a id="organize-menu" href="organizerlogin.html">Organizer Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <section class="welcome-heading">
            <h1 class="title">Welcome to Osmania Esports</h1>
            <p class="subtitle">Compete, Conquer, Celebrate!</p>
        </section>

        <div class="our-games-box">
    <h1>OUR GAMES</h1>
    <div class="our-games">
        <div class="game-img">
            <img src="images/bgmi1.jpeg" alt="BGMI Image">
            <p>BGMI</p>
        </div>
        <div class="game-img">
            <img src="images/freefire1.jpeg" alt="FREE FIRE MAX Image">
            <p>FREE FIRE MAX</p>
        </div>
        <div class="game-img">
            <img src="images/valorant1.jpeg" alt="VALORANT Image">
            <p>VALORANT</p>
        </div>
        <div class="game-img">
            <img src="images/cod1.jpeg" alt="CALL OF DUTY Image">
            <p>CALL OF DUTY MOBILE</p>
        </div>
        <div class="game-img">
            <img src="images/leagueoflegends.webp" alt="LEAGUE OF LEGENDS Image">
            <p>LEAGUE OF LEGENDS</p>
        </div>
        <div class="game-img">
            <img src="images/dota2.jpg" alt="DOTA 2 Image">
            <p>DOTA 2</p>
        </div>
        <div class="game-img">
            <img src="images/apexlegends.jpg" alt="APEX LEGENDS Image">
            <p>APEX LEGENDS</p>
        </div>
        <div class="game-img">
            <img src="images/rocketleague.jpg" alt="ROCKET LEAGUE Image">
            <p>ROCKET LEAGUE</p>
        </div>
        <div class="game-img">
            <img src="images/rainbowsixsiege.jpg" alt="RAINBOW SIX SIEGE Image">
            <p>RAINBOW SIX SIEGE</p>
        </div>
        <div class="game-img">
            <img src="images/hearthstone.avif" alt="HEARTHSTONE Image">
            <p>HEARTHSTONE</p>
        </div>
        <div class="game-img">
            <img src="images/fifa.png" alt="FIFA Image">
            <p>FIFA</p>
        </div>
        <div class="game-img">
            <img src="images/overwatch.webp" alt="OVERWATCH Image">
            <p>OVERWATCH</p>
        </div>
        <div class="game-img">
            <img src="images/streetfighterv.png" alt="STREET FIGHTER V Image">
            <p>STREET FIGHTER V</p>
        </div>
    </div>
</div>


        <div class="your-tournaments" id="your-tournaments">
            <h2>Upcoming Tournaments</h2>
            <div class="tournaments-box">
                <?php if (count($upcoming_tournaments) > 0): ?>
                    <?php foreach ($upcoming_tournaments as $tournament): ?>
                        <div class="tournaments">
                            <h3><?php echo htmlspecialchars($tournament['tournament_name']); ?></h3>
                            <p><span>Game: </span><?php echo htmlspecialchars($tournament['game_name']); ?></p>
                            <p><span>Mode: </span><?php echo htmlspecialchars($tournament['game_mode']); ?></p>
                            <p><span>Prize Pool: </span>₹<?php echo htmlspecialchars($tournament['prize_pool']); ?></p>
                            <p><span>Date: </span><?php echo htmlspecialchars($tournament['start_date']); ?></p>
                            <a href="tournament-details.php?id=<?php echo $tournament['id']; ?>">
                                <button class="details-btn">More Details</button>
                            </a>
                            <?php $_SESSION['tournament_id'] = $tournament['id']; ?>
                            <a href="tournament-register.html?id=<?php echo $tournament['id']; ?>">
                                <button class="details-btn">Register</button>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No upcoming tournaments yet. Stay tuned!</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Osmania Esports. All rights reserved.</p>
    </footer>
</body>
</html>
