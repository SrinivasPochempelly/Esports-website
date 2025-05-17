<?php
    session_start();
    include 'db-connection.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['organizer-name'];
    $password = $_POST['organizer-password'];
    $response= array('success'=>FALSE,'username' => $username, 'userid' => 0);

    $query = $conn->prepare("SELECT * FROM organizers WHERE organizername = ?");
    if (!$query) {
        die("Query preparation failed: " . $conn->error);
    }

    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($password == $user['password']) {
            $_SESSION['organizerid'] = $user['organizerid'];
            $_SESSION['organizername'] = $user['organizername'];

            $response['success']=TRUE;
            $response['userid'] = $user['user_id'];

            header("Location: organize.php");
            exit();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "<script> alert('User not found!'); </script>";
        
    }
    }
?>
