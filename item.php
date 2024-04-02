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


    $id = $_GET['id'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT title, description, photo, price, email FROM items WHERE id = $id";
    $result = $conn->query($sql);



    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $prettyPrice = prettyPrintPrice($row["price"]);
        ?>

        <div class="container mx-auto">
            <div class="flex justify-center items-center mt-8">
                <div class="rounded overflow-hidden shadow-lg flex flex-col md:flex-row">
                    <div class="w-full md:w-1/3 px-4 py-4 md:p-0">
                        <img class="w-full h-auto" src="<?php echo $row["photo"]; ?>" alt="<?php echo $row["title"]; ?>">
                    </div>
                    <div class="w-full md:w-2/3 px-6 py-4">
                        <div class="font-bold text-3xl mb-4">
                            <?php echo $row["title"]; ?>
                        </div>
                        <p class="text-gray-700 text-lg">
                            <?php echo $row["description"]; ?>
                        </p>
                        <p class="text-gray-700 text-lg">Цена:
                            <?php echo $prettyPrice; ?> руб.
                        </p>
                        <p class="text-lg text-gray-500">Автор:
                            <?php echo $row["email"]; ?>
                        </p>
                        <div class="flex justify-start items-center mt-4">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg"
                                onClick="window.basket.add(<? echo $id ?>); alert('Добавлено в корзину')">
                                Купить
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo "Item not found";
    }

    $conn->close();
    ?>
</body>