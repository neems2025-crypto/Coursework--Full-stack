<?php
// ----------------------
// LOGIN SECURITY
// ----------------------
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login-form.php");
    exit;
}
?>
<script>
if (!sessionStorage.getItem('tabLoggedIn')) {
    window.location.href = "login-form.php";
}
</script>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Games</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #f4f7fb, #e8f0ff);
      font-family: 'Segoe UI', Tahoma, sans-serif;
    }

    .games-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 10px 25px rgba(0,0,0,0.12);
    }

    .games-table thead {
      background: linear-gradient(135deg, #0d6efd, #4dabf7);
      color: white;
    }

    .games-table th {
      padding: 16px;
      text-transform: uppercase;
      font-size: 13px;
      letter-spacing: 1px;
    }

    .games-table td {
      padding: 14px;
      border-bottom: 1px solid #eef1f5;
    }

    .games-table tbody tr:nth-child(even) {
      background: #f9fbff;
    }

    .games-table tbody tr:hover {
      background: #eef6ff;
      transition: 0.3s;
      transform: scale(1.01);
    }

    .games-table a.game-link {
      color: #0d6efd;
      font-weight: 600;
      text-decoration: none;
    }

    .games-table a.game-link:hover {
      text-decoration: underline;
    }

    .btn-warning {
      background: linear-gradient(135deg, #ffd43b, #fab005);
      border: none;
      color: #000;
    }

    .btn-outline-danger:hover {
      background: #dc3545;
      color: #fff;
    }
  </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">

    <a class="navbar-brand fw-bold" href="list-games.php">List of ALL my games!!!</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#mainNavbar" aria-controls="mainNavbar"
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNavbar">
      <div class="ms-auto d-flex align-items-center">

        <!-- Search -->
        <form class="d-flex me-3" action="search-games.php" method="post">
          <input class="form-control form-control-sm me-2"
                 type="text" name="keywords" placeholder="Search">
          <button class="btn btn-sm btn-outline-light" type="submit">Go!</button>
        </form>

        <!-- AJAX -->
        <ul class="navbar-nav me-3">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="ajaxDropdown"
               role="button" data-bs-toggle="dropdown" aria-expanded="false">
              AJAX Features
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="ajaxDropdown">
              <li>
                <a class="dropdown-item" href="bootstrap-ajax-dropdown.html">
                  Dropdown Example
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="bootstrap-ajax-modal.html">
                  Modal Example
                </a>
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

<div class="container my-4">

<?php
include("db.php");

$sql = "SELECT * FROM videogames ORDER BY released_date";
$results = mysqli_query($mysqli, $sql);

if (!$results) {
  die("Database error: " . htmlspecialchars(mysqli_error($mysqli)));
}
?>

<div class="d-flex justify-content-between mb-3">
  <h2>My Games</h2>
  <a href="add-game-form.php" class="btn btn-success btn-sm">+ Add a game</a>
</div>

<table class="games-table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Game</th>
      <th>Rating</th>
      <th>Actions</th>
    </tr>
  </thead>

  <tbody>
    <?php while ($row = mysqli_fetch_assoc($results)): ?>
      <tr>
        <td><?= (int)$row['game_id'] ?></td>

        <td>
          <a class="game-link" href="game-details.php?id=<?= (int)$row['game_id'] ?>">
            <?= htmlspecialchars($row['game_name']) ?>
          </a>
        </td>

        <td><?= htmlspecialchars($row['rating']) ?></td>

        <td>
          <a class="btn btn-warning btn-sm"
             href="edit-game-form.php?id=<?= (int)$row['game_id'] ?>">
            Edit
          </a>

          <a class="btn btn-outline-danger btn-sm ms-1"
             href="delete-games.php?id=<?= (int)$row['game_id'] ?>"
             onclick="return confirm('Delete this game?');">
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