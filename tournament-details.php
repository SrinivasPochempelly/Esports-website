<?php
session_start();
include 'db-connection.php';

if (!isset($_GET['id'])) {
    echo "Invalid tournament.";
    exit();
}

$tournament_id = $_GET['id'];

$sql = "SELECT * FROM tournaments WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $tournament_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Tournament not found.";
    exit();
}
$tournament = $result->fetch_assoc();
$game_name[]=$tournament['game_name'];
$_SESSION['tournament_id'] = $tournament['id'];
// echo $_SESSION['tournament_id'];
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($tournament['tournament_name']); ?> Details</title>
    <link rel="stylesheet" href="tournament-details.css">
    
</head>
<body onload="load_image()">
    <main>
        <h1 class="title">Tournament Details</h1>
        <div class='details'>
            <h1><?php echo htmlspecialchars($tournament['tournament_name']); ?></h1>
            <img src="" alt="Game Image" id='game-image'>
            <p><strong>Game:</strong> <?php echo htmlspecialchars($tournament['game_name']); ?></p>
            <p><strong>Mode:</strong> <?php echo htmlspecialchars($tournament['game_mode']); ?></p>
            <p><strong>Max Slots:</strong> <?php echo htmlspecialchars($tournament['max_slots']); ?></p>
            <p><strong>Entry Fee:</strong> <?php echo htmlspecialchars($tournament['entry_fee']); ?></p>
            <p><strong>Prize Pool:</strong> <?php echo htmlspecialchars($tournament['prize_pool']); ?></p>
            <p><strong>Start Date:</strong> <?php echo htmlspecialchars($tournament['start_date']); ?></p>
            <p><strong>Start Time:</strong> <?php echo htmlspecialchars($tournament['start_time']); ?></p>
            <form method="POST" action="tournament-register.html">
                <input type="hidden" name="tournament_id" value="<?php echo $tournament['id']; ?>">
                <button class="register-btn" type="submit">Register Now</button>
            </form>
        </div>
        <p></p>
        <div class="rules">
                <h2>General Rules:</h2>
                <p><span>Fair Play:</span> All participants must adhere to the rules of the game and the tournament.</p>
                <p><span>Sportsmanship:</span> Players should maintain a positive attitude and respect their opponents.</p>
                <p><span>Eligibility:</span> Players must be above 16 years and game level should be minimum 30.</p>
                <p><span>Team Composition:</span> Teams must have a certain number of players and may have restrictions on substitutions.</p>
                <p><span>Game Settings:</span> The game settings, such as difficulty level, map selection, and character choices, are often standardized.</p>
                <p><span>Match Format:</span> The format of the tournament, such as round-robin or single-elimination, is determined by the organizer.</p>
                <p><span>Scoring System:</span> The scoring system is used to determine the winner of each match and the overall tournament.</p>
                <p><span>Disputes:</span> A dispute resolution process is in place to handle any disagreements or controversies.</p>
                <h2>Game-Specific Rules:</h2>
                <p><span>Game Mechanics:</span> Players must follow the specific rules and mechanics of the game.</p>
                <p><span>Banned Items or Strategies:</span> Certain items or strategies may be banned to ensure fair play.</p>
                <p><span>Communication:</span> Players may be allowed to communicate with their teammates using voice chat or text chat.</p>
                <p><span>Third-Party Software:</span> The use of third-party software, such as cheats or hacks, is strictly prohibited.</p>
                <h2>Additional Rules for Battlegrounds eSports:</h2>
                <p><span>Map Selection:</span> Maps are often selected through a veto system or a predetermined rotation.</p>
                <p><span>Match Length:</span> Matches have a time limit, and the team with the most kills or highest score at the end wins.</p>
                <p><span>Third-Party Interference:</span> Players are not allowed to receive outside assistance, such as coaching or tips, during matches.</p>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Osmania Esports. All rights reserved.</p>
    </footer>
    <script>
        function load_image(){
        var gameName = <?php echo json_encode($game_name); ?>;
        if(gameName == 'FREE FIRE')
            var image_url = 'images/freefire1.jpeg';
        else if(gameName == 'BGMI')
            var image_url = 'images/bgmi1.jpeg';
        else if(gameName == 'VALORANT')
            var image_url = 'images/valorant1.jpeg';
        else if(gameName == 'COD MOBILE')
            var image_url = 'images/cod1.jpeg';
        document.getElementById('game-image').src= image_url;
        }
    
    </script>
</body>
</html>
