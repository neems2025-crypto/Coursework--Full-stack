<?php

session_start();

if (empty($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login-form.php");
    exit;
}


include 'db.php';


$game_id = $_POST['game_id'];
$game_name = $_POST['game_name'];
$game_description = $_POST['game_description'];
$rating = $_POST['rating'];
$released_date = $_POST['released_date'];

// Update query
$sql = "UPDATE videogames 
        SET game_name='$game_name',
            game_description='$game_description',
            rating='$rating',
            released_date='$released_date'
        WHERE game_id=$game_id";

mysqli_query($mysqli, $sql);

// Redirect back to list
header("Location: games.php");
exit;
?>

