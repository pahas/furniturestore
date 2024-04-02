<?php
session_start();
?>

<!doctype html>
<html>

<head>
    <?php
    include "common/head.php"
        ?>
    <style>
        .center {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 50vh;
        }

        .center a {
            margin: 10px;
        }
    </style>
</head>

<body>
    <?php
    include "common/appbar.php";
    include ($_SERVER['DOCUMENT_ROOT'] . "/common/constants.php");

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //count user's items
    
    $email = $_SESSION['email'];
    $sql = "SELECT * FROM items WHERE email = '$email'";
    $result = $conn->query($sql);
    $count = $result->num_rows;

    ?>
    <div class="center" style="margin-top: 30vh;">
        <div>
            <div class="p-4">
                <span class="text-lg">
                    <?php echo $_SESSION['email']; ?>
                </span>

                <i class="fas fa-check-circle text-green-500 mr-2"></i>
            </div>
        </div>
        <div>
            <a href="dashboard/create-element.php"
                class="button bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Создать товар</a>
            <a href="dashboard/items.php"
                class="button bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Мои товары</a>
        </div>
        <div>
            <div class="p-4">
                <span class="text-lg">
                    Количество ваших товаров:
                    <?php echo $count ?>
                </span>
            </div>
        </div>
    </div>

</body>

</html>