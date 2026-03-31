
<h1>Game Search</h1>


<hr>

<?php
include("db.php");

$keywords = $_POST['keywords'] ?? '';

$sql = "SELECT * FROM videogames";
$stmt = null;

if (!empty($keywords)) {
    $sql .= " WHERE game_name LIKE ?
              OR game_description LIKE ?
              OR rating LIKE ?
              OR released_date LIKE ?
              ORDER BY released_date";

    $search = "%" . $keywords . "%";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssss", $search, $search, $search, $search);
    $stmt->execute();
    $results = $stmt->get_result();
} else {
    $sql .= " ORDER BY released_date";
    $results = mysqli_query($mysqli, $sql);
}
?>

<table border="1" cellpadding="8">
    <tr>
        <th>Game Name</th>
        <th>Rating</th>
        <th>Released Date</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($results)): ?>
        <tr>
            <td>
                <a href="game-details.php?id=<?= $row['game_id'] ?>">
                    <?= htmlspecialchars($row['game_name']) ?>
                </a>
            </td>
            <td><?= htmlspecialchars($row['rating']) ?></td>
            <td><?= htmlspecialchars($row['released_date']) ?></td>
        </tr>
    <?php endwhile; ?>
</table>