<?php

session_start();

if (empty($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login-form.php");
    exit;
}



include 'db.php';

$id = $_GET['id'];

// Get the specific game info
$sql = "SELECT * FROM videogames WHERE game_id = $id";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);
?>

<!doctype html>
<html lang="en">
<body>

<h1>Update Game</h1>

<form action="update-game.php" method="post">
  <input type="hidden" name="game_id" value="<?=$row['game_id']?>">

  <label>Game Name:</label><br>
  <input type="text" name="game_name" value="<?=$row['game_name']?>" required><br><br>
  
  <label>Description:</label><br>
  <textarea name="game_description" rows="5" cols="40" required><?=$row['game_description']?></textarea><br><br>

  <label>Rating:</label><br>
  <input type="number" name="rating" value="<?=$row['rating']?>" required><br><br>

  <label>Release Date:</label><br>
  <input type="date" name="released_date" value="<?=$row['released_date']?>" required><br><br>

  <input class="btn" type="submit" value="Update Game">
</form>

</body>
</html>
