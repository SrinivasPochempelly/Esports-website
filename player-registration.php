<?php
include 'db-connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['player-name'];
    $email = $_POST['player-mail'];
    $password = $_POST['player-password'];
    $confirmPassword = $_POST['player-confirm-password'];

    $checkQuery = $conn->prepare("SELECT * FROM players WHERE username = ? OR email = ?");
    $checkQuery->bind_param("ss", $username, $email);
    $checkQuery->execute();
    $checkResult = $checkQuery->get_result();

    if ($checkResult->num_rows > 0) {   
        die("Username or email already taken. <a href='player-registration.html'>Go back</a>");
    }

    if ($password !== $confirmPassword) {
        die("Passwords do not match. <a href='player-registration.html'>Go back</a>");
    }



    $sql = "INSERT INTO players(username,email,password) VALUES('$username','$email','$password')";

    if(!$conn->query($sql)){
        die("Error : ".$conn->error());
    }
    header("Location: player-login.html");
    
}
?>
