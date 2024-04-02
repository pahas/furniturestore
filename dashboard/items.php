<?php
session_start();
?>

<!doctype html>
<html>

<head>
    <?php
    include ($_SERVER['DOCUMENT_ROOT'] . "/common/head.php");
    ?>
    <style>
        .center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50vh;
        }
    </style>
</head>

<body>

    <?php
    include ($_SERVER['DOCUMENT_ROOT'] . "/common/appbar.php");
    include ($_SERVER['DOCUMENT_ROOT'] . "/common/card-item.php");
    include ($_SERVER['DOCUMENT_ROOT'] . "/common/constants.php");

    // Retrieve email from _SESSION
    $email = $_SESSION['email'];
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (
        isset($_GET['id'])
    ) {
        //delete item, todo security check
        $id = $_GET['id'];
        $sql = "DELETE FROM items WHERE id = $id";
        $conn->query($sql);
        $sql = "";
        echo '<script>alert("Товар удален"); window.location.href = "/dashboard/items.php";</script>';
    }

    // Prepare and execute the SQL query
    $sql = "SELECT * FROM items WHERE email = '$email'";
    $result = $conn->query($sql);

    // Display items in a cool grid
    echo '<h1 class="text-center text-3xl font-bold mb-8 mt-2">Ваши товары</h1>'; // Add the title for the grid items
    echo '<div class="grid grid-cols-1 sm:grid-cols-4 gap-4 p-4 sm:p-16">';
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            createCardItem($row['title'], $row['description'], $row['id'], $row['photo'], $row['price'], true);
        }
    } else {
        echo "Нет товаров.";
    }
    echo '</div>';

    // Close the database connection
    $conn->close();
    ?>

</body>

</html>