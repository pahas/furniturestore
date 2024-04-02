<!doctype html>
<html>

<head>
  <?php
  include "common/head.php"
    ?>
</head>

<body>
  <?php
  include "common/appbar.php";
  include "common/card-item.php";
  include ($_SERVER['DOCUMENT_ROOT'] . "/common/constants.php");

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM items";
  $result = $conn->query($sql);

  echo '<div class="grid grid-cols-1 sm:grid-cols-4 gap-4 p-4 sm:p-16">';
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      createCardItem($row['title'], $row['description'], $row['id'], $row['photo'], $row['price']);
    }
  } else {
    echo "Нет товаров.";
  }
  echo '</div>';

  $conn->close();
  ?>


</body>

</html>