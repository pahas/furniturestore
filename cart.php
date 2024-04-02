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

    $ids = $_GET['ids'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, title, description, photo, price, email FROM items WHERE id IN ($ids)";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $items = new stdClass();

        while ($row = $result->fetch_assoc()) {
            $prettyPrice = prettyPrintPrice($row["price"]);
            $items->{$row["id"]} = $row; // Add the item to the object
        }

        $splittedIds = explode(",", $ids);
        $position = 1;

        foreach ($splittedIds as $id) {
            if (isset($items->{$id})) {
                $item = $items->{$id};
                ?>

                <div class="container mx-auto">
                    <div class="flex justify-center items-center mt-8">
                        <div class="flex justify-center items-center mt-8">
                            <!-- <div class="font-bold text-3xl mr-4">
                                <?php echo $position; ?>.
                            </div> -->
                            <div class="rounded overflow-hidden shadow-lg flex flex-col md:flex-row pl-2"
                                style="width: 70vw; align-items: center;">
                                <div class="w-auto px-4 py-4 md:p-0">
                                    <img class="w-auto h-auto" style="max-height: 15vh; border-radius: 4px;"
                                        src="<?php echo $item["photo"]; ?>" alt="<?php echo $item["title"]; ?>">
                                </div>
                                <div class="w-full md:w-2/3 px-6 py-4">
                                    <div class="font-bold text-3xl mb-4">
                                        №
                                        <?php echo $position; ?>.
                                        <?php echo $item["title"]; ?>
                                    </div>
                                    <p class="text-gray-700 text-lg">
                                        <?php echo $item["description"]; ?>
                                    </p>
                                    <p class="text-gray-700 text-lg">Цена:
                                        <?php echo $prettyPrice; ?> руб.
                                    </p>
                                    <p class="text-lg text-gray-500">Автор:
                                        <?php echo $item["email"]; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                echo "Item not found";
            }

            $position++;
        }
    } else {
        echo "Item not found";
    }

    $conn->close();
    ?>

    <div class="container mx-auto mt-8">
        <div class="flex justify-center w-full">
            <div class="bg-white rounded-lg shadow-lg">
                <form class="w-full p-6" style="width: 70vw;" method='POST' action='/dashboard/create-order.php'>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="name">
                                Имя
                            </label>
                            <input required
                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                id="name" type="text" placeholder="Петр Иванов" name='name'>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="email">
                                E-mail
                            </label>
                            <input required
                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                id="email" type="email" placeholder="petrivanov@mail.ru" name='email'>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="phone">
                                Номер телефона
                            </label>
                            <input required name="phone"
                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                id="phone" type="text" placeholder="1234567890" name='phone'>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="description">
                                Комментарии к заказу
                            </label>
                            <textarea
                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                id="description" name="description"
                                placeholder="Код от домофона 123.. Привезите с 8-00 до 12-00"></textarea>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <button
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit">
                            Отправить заказ
                        </button>
                    </div>
                    <input type="hidden" name="ids" value="<?php echo $ids; ?>">
                </form>
            </div>
        </div>
    </div>

</body>