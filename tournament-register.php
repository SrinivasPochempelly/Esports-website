<?php
session_start();
include 'db-connection.php';
echo $_SESSION['tournament_id'];

if(isset($_SESSION['organizername'])){
    echo "<script> console.log('Organizer can't be register'); </script>";
    $_SESSION['organizer_reg']='yes';
    header("Location : index.php");
}

if (!isset($_SESSION['username'])) {
    echo "<script> console.log('Login first in order to register'); </script>";
    header("Location: player-login.html");
    exit();
}
$tournament_id = $_SESSION['tournament_id'];
$player_username = $_SESSION['username'];
$sql = "SELECT tournament_id , player_username FROM tournament_registrations WHERE tournament_id = ? AND player_username = ?";
$stmt = $conn->prepare($sql);
if(!$stmt){
    echo"Error" .$conn->error;
}
$stmt->bind_param("ss", $tournament_id, $player_username);
$stmt->execute();
$result = $stmt->get_result();
$resultCheck = $result->fetch_assoc();


if($resultCheck['tournament_id'] == $tournament_id && $resultCheck['player_username'] == $player_username){
    echo "<script> alert('You have already registered for this tournament'); </script>";
    $_SESSION['player_reg'] = 'yes';
    header('Location: index.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['submit'] == 'submit') {
    $team_name = $_POST['team-name'] ?? 'team';
    $igl_name = $_POST['igl-name'] ?? 'user' ;
    // $tournament_id = $_SESSION['tournament_id'];
    // $player_username = $_SESSION['username'];

    $sql = "INSERT INTO tournament_registrations (tournament_id, player_username,team_name,igl_name) VALUES (?, ?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $tournament_id, $player_username,$team_name,$igl_name);
    if ($stmt->execute()) {
        echo "Successfully registered for the tournament!";
        header("Location: my-tournaments.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>=