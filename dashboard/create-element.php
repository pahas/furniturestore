<?php
session_start();
include ($_SERVER['DOCUMENT_ROOT'] . "/common/constants.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $photo = $_POST['photo'];
    $price = $_POST['price'];
    $email = $_POST['email'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL statement to insert a new item
    $stmt = $conn->prepare("INSERT INTO items (title, description, photo, price, email) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $description, $photo, $price, $email);
    $stmt->execute();

    // Close the database connection
    $stmt->close();
    $conn->close();

    //create an alert message
    echo '<script>alert("Успешно сохранено");</script>';
    header("Location: /dashboard/items.php");
}
?>

<!doctype html>
<html>

<head>
    <?php
    include ($_SERVER['DOCUMENT_ROOT'] . "/common/head.php");
    ?>
</head>

<body>
    <?php
    include ($_SERVER['DOCUMENT_ROOT'] . "/common/appbar.php");

    ?>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Добавить предмет мебели</h1>
        <form action="/dashboard/create-element.php" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="title" class="block text-lg font-medium text-gray-700">Название</label>
                <input type="text" name="title" id="title" class="mt-1 p-2 border border-gray-300 rounded-md w-full"
                    required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-lg font-medium text-gray-700">Описание</label>
                <textarea name="description" id="description" class="mt-1 p-2 border border-gray-300 rounded-md w-full"
                    required></textarea>
            </div>
            <div class="mb-4">
                <label for="photo" class="block text-lg font-medium text-gray-700">Фото (URL)</label>
                <input type="text" name="photo" id="photo" class="mt-1 p-2 border border-gray-300 rounded-md w-full"
                    required>
            </div>
            <div class="mb-4">
                <label for="price" class="block text-lg font-medium text-gray-700">Цена</label>
                <input type="number" name="price" id="price" class="mt-1 p-2 border border-gray-300 rounded-md w-full"
                    required>
            </div>
            <div class="mb-4">
                <input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Добавить предмет
                </button>
            </div>
        </form>
    </div>
</body>

</html>