<?php
session_start();

if (
    !isset($_SESSION['loggedin']) ||
    $_SESSION['loggedin'] !== true ||
    !isset($_SESSION['agent']) ||
    $_SESSION['agent'] !== ($_SERVER['HTTP_USER_AGENT'] ?? '')
) {
    header("Location: login-form.php");
    exit;
}

include("db.php");

$sql = "SELECT * FROM videogames ORDER BY released_date";
$results = mysqli_query($mysqli, $sql);

if (!$results) {
    die("Database error: " . htmlspecialchars(mysqli_error($mysqli)));
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>My Games</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
  background: linear-gradient(135deg, #eef2ff, #e0f2fe) !important;
  font-family: 'Segoe UI', Tahoma, sans-serif;
}

.games-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  background: #ffffff;
  border-radius: 14px;
  overflow: hidden;
  box-shadow: 0 12px 30px rgba(0,0,0,0.12);
}

.games-table thead tr {
  background: linear-gradient(135deg, #22c55e, #16a34a) !important;
}

.games-table thead th {
  color: #ffffff !important;
  padding: 16px;
  font-weight: 600;
  font-size: 15px;
  border: none;
}

.games-table td {
  padding: 16px;
  border-bottom: 1px solid #e5e7eb;
  font-size: 15px;
}

.games-table tbody tr:nth-child(even) {
  background: #f9fafb;
}

.games-table tbody tr:hover {
  background: #ecfdf5;
  transition: 0.3s;
}

.games-table a.game-link {
  color: #2563eb;
  font-weight: 600;
  text-decoration: none;
}

.games-table a.game-link:hover {
  text-decoration: underline;
}

.btn-warning {
  background: #facc15 !important;
  border: none !important;
  color: #000 !important;
  font-weight: 600;
}

.btn-warning:hover {
  background: #eab308 !important;
}

.btn-outline-danger {
  border: 1px solid #ef4444 !important;
  color: #ef4444 !important;
  font-weight: 600;
}

.btn-outline-danger:hover {
  background: #ef4444 !important;
  color: white !important;
}
</style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">

    <a class="navbar-brand fw-bold" href="list-games.php">List of ALL my games!!!</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">
      <div class="ms-auto d-flex align-items-center">

        <form class="d-flex me-3" action="search-games.php" method="post">
          <input class="form-control form-control-sm me-2" type="text" name="keywords" placeholder="Search">
          <button class="btn btn-sm btn-outline-light" type="submit">Go!</button>
        </form>

        <ul class="navbar-nav me-3">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="ajaxDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              AJAX Features
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="ajaxDropdown">
              <li>
                <a class="dropdown-item" href="bootstrap-ajax-dropdown.html">Dropdown Example</a>
              </li>
              <li>
                <a class="dropdown-item" href="bootstrap-ajax-modal.html">Modal Example</a>
              </li>
            </ul>
          </li>
        </ul>

        <span class="text-white me-3">
          Logged in as <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
        </span>

        <a class="btn btn-danger btn-sm" href="logout.php">Logout</a>

      </div>
    </div>
  </div>
</nav>

<div class="container py-4">

  <div class="d-flex justify-content-between mb-3">
    <h2 class="h4">My Games</h2>
    <a href="add-game-form.php" class="btn btn-success btn-sm">+ Add a game</a>
  </div>

  <table class="games-table">
    <thead>
      <tr>
        <th>Game</th>
        <th>Rating</th>
        <th>Actions</th>
      </tr>
    </thead>

    <tbody>
      <?php while ($row = mysqli_fetch_assoc($results)): ?>
      <tr>
        <td>
          <a class="game-link" href="game-details.php?id=<?= (int)$row['game_id'] ?>">
            <?= htmlspecialchars($row['game_name']) ?>
          </a>
        </td>

        <td><?= htmlspecialchars($row['rating']) ?></td>

        <td>
          <a class="btn btn-warning btn-sm" href="edit-game-form.php?id=<?= (int)$row['game_id'] ?>">
            Edit
          </a>

          <a class="btn btn-outline-danger btn-sm" href="delete-games.php?id=<?= (int)$row['game_id'] ?>" onclick="return confirm('Delete this game?');">
            Delete
          </a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>