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
            justify-content: center;
            align-items: center;
            height: 50vh;
        }

        .center a {
            margin: 0 10px;
        }
    </style>
</head>

<body>
    <?php
    include "common/appbar.php";
    include ($_SERVER['DOCUMENT_ROOT'] . "/common/constants.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['email'])) {

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $email = $_POST['email'];
            $sql = "UPDATE users SET verified = true WHERE email = '$email'";
            $conn->query($sql);

            echo '<script>alert("Пользователь верифицирован");</script>';
        } else {
            if ($_POST['password'] == $adminPwd) {
                $_SESSION['admin'] = true;
                echo '<script>alert("Вы вошли как администратор");</script>';
            } else {
                echo '<script>alert("Неверный пароль");</script>';
            }
        }
    }

    if (
        !isset($_SESSION['admin']) ||
        $_SESSION['admin'] != true
    ) {
        echo <<<HTML
    <div class="center">
        <form class="mt-4" action="/admin.php" method="POST">
            <input type="password" name="password" placeholder="Введите пароль"
                class="border border-gray-300 rounded-md p-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md ml-2">Отправить</button>
        </form>

    </div>
    HTML;
    } else {
        echo <<<HTML
        <div class="center">
            <form class="mt-4" action="/admin.php" method="POST">
                <input type="email" name="email" placeholder="Введите эмейл"
                    class="border border-gray-300 rounded-md p-2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md ml-2">Верифицировать</button>
            </form>
    
        </div>
        HTML;
    }
    ?>

</body>

</html>