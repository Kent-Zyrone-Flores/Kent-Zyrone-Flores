<?php
$conn = new mysqli("localhost", "root", "", "visitor_tracker");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  session_destroy();
  header("Location: login.php");
  exit;
}

// Handle bulk delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_selected'])) {
  if (!empty($_POST['selected_ids'])) {
    $ids = implode(",", array_map('intval', $_POST['selected_ids']));
    $conn->query("DELETE FROM visitors WHERE id IN ($ids)");
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Visitor Log</title>
  <link rel="stylesheet" href="css/logger.css">
</head>
<body>
  <p style="text-align: right; margin-right: 20px;">
    <a href="logout.php" class="logout-btn">Logout</a>
  </p>

  <h2>Visitor Log</h2>

  <form method="POST">
    <div style="margin: 10px 0 10px 10px;">
      <input type="checkbox" id="selectAll" class="select-all"> Select All
      <button type="submit" name="delete_selected" class="delete-btn" onclick="return confirm('Delete selected records?')">Delete Selected</button>
    </div>

    <table border="1" cellpadding="8" cellspacing="0">
      <tr>
        <th></th>
        <th>IP Address</th>
        <th>City</th>
        <th>Region</th>
        <th>Country</th>
        <th>ISP</th>
        <th>Visit Time</th>
        <th>Action</th>
      </tr>

      <?php
      $result = $conn->query("SELECT * FROM visitors ORDER BY visit_time DESC");
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $dt = new DateTime($row['visit_time']);
          $formattedDate = $dt->format('F j, Y') . ' | ' . $dt->format('h:i A');
          echo "<tr>
                  <td><input type='checkbox' name='selected_ids[]' value='{$row['id']}'></td>
                  <td>{$row['ip']}</td>
                  <td>{$row['city']}</td>
                  <td>{$row['region']}</td>
                  <td>{$row['country']}</td>
                  <td>{$row['isp']}</td>
                  <td>$formattedDate</td>
                  <td><a href='?delete_id={$row['id']}' onclick=\"return confirm('Delete this record?');\" style='color:red;'>Delete</a></td>
                </tr>";
        }
      } else {
        echo "<tr><td colspan='8' style='text-align:center;'>No visitors yet.</td></tr>";
      }
      $conn->close();
      ?>
    </table>
  </form>

  <script>
    document.getElementById('selectAll').addEventListener('change', function () {
      const checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
      checkboxes.forEach(cb => cb.checked = this.checked);
    });
  </script>
</body>
</html>
