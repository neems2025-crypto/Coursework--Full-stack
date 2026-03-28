<?php
session_start();

// protect page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login-form.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: add-game-form.php");
    exit;
}

$game_name        = isset($_POST['GameName']) ? trim($_POST['GameName']) : '';
$game_description = isset($_POST['GameDescription']) ? trim($_POST['GameDescription']) : '';
$released_date    = isset($_POST['DateReleased']) ? trim($_POST['DateReleased']) : '';
$rating           = isset($_POST['GameRating']) ? (int)$_POST['GameRating'] : null;

if ($game_name === '' || $game_description === '' || $released_date === '' || $rating === null) {
    echo "<h3>Missing required fields.</h3>";
    echo "<p><a href='add-game-form.php'>Back to form</a></p>";
    exit;
}

require 'db.php';

$sql = "INSERT INTO videogames (game_name, game_description, released_date, rating)
        VALUES (?, ?, ?, ?)";

$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    echo "<h3>Database error.</h3>";
    echo "<p>" . htmlspecialchars($mysqli->error) . "</p>";
    exit;
}

$stmt->bind_param("sssi", $game_name, $game_description, $released_date, $rating);

if (!$stmt->execute()) {
    echo "<h3>Could not save game.</h3>";
    echo "<p>" . htmlspecialchars($stmt->error) . "</p>";
    exit;
}

header("Location: games.php");
exit;
?>
