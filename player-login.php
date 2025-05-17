<?php
session_start();
include 'db-connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // $response= array('success'=>FALSE,'username' => $username, 'userid' => 0);

    $query = $conn->prepare("SELECT * FROM players WHERE username = ?");
    if (!$query) {
        die("Query preparation failed: " . $conn->error);
    }

    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($password == $user['password']) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];

            // $response['success']=TRUE;
            // $response['userid'] = $user['user_id'];

            header("Location: index.php");
            exit();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "<script> alert('User not found!'); </script>";
        
    }
}
