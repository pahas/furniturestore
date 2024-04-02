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
    include ($_SERVER['DOCUMENT_ROOT'] . "/common/constants.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Save the user
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Check if user with the same email already exists
        $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($checkEmailQuery);
        if ($result->num_rows > 0) {
            // User with the same email already exists
            echo '<script>alert("Пользователь с таким e-mail уже зарегистрирован");</script>';
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // SQL query to insert the user into the table
            $sql = "INSERT INTO users (email, password) VALUES ('$email', '$hashedPassword')";

            if ($conn->query($sql) === TRUE) {
                //echo "User saved successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            echo '<script>alert("Пользователь успешно зарегистрирован. Ожидайте верификации");
                window.location.href = "/";
            </script>';
        }

        // Close connection
        $conn->close();
    }
    ?>

    <div class="flex justify-center items-center pt-16">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 m-4 sm:min-w-[500px] w-full md:w-auto">
            <h2 class="text-2xl mb-4">Регистрация</h2>
            <form action="register.php" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        E-mail
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="email" type="email" placeholder="E-mail" name='email'>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Пароль
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="password" type="password" placeholder="Пароль" name='password'>
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Зарегестрироваться
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>