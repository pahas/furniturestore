<?php
session_start();
include ($_SERVER['DOCUMENT_ROOT'] . "/common/constants.php");

if (
    isset($_GET['logout']) &&
    $_GET["logout"] == "true"
) {
    session_destroy();
    header("Location: /");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $formPassword = $_POST['password'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    // Check if user exists
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $storedPassword = $row['password'];

        if ($row['verified'] == 0) {
            echo '<script>alert("Пользователь не верифицирован");</script>';
        } else {
            if (password_verify($formPassword, $storedPassword)) {
                // Password is correct, user exists
                $_SESSION['email'] = $email;
                header("Location: dashboard.php");
                exit();
            } else {
                // Invalid password
                echo '<script>alert("Invalid email or password");</script>';
            }
        }
    } else {
        // Invalid credentials
        echo '<script>alert("Invalid email or password");</script>';
    }

    // Close database connection
    mysqli_close($conn);
}
?>

<!doctype html>
<html>

<head>
    <?php
    include "common/head.php"
        ?>
</head>

<body>
    <?php include "common/appbar.php"; ?>

    <div class="flex justify-center items-center pt-16">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 m-4 sm:min-w-[500px] w-full md:w-auto">
            <h2 class="text-2xl mb-4">Вход</h2>
            <form action="login.php" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        E-mail
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="email" type="email" name="email" placeholder="E-mail">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Пароль
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="password" type="password" name="password" placeholder="Пароль">
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Войти
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>