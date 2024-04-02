<?php
include ($_SERVER['DOCUMENT_ROOT'] . "/common/utils.php");
include ($_SERVER['DOCUMENT_ROOT'] . "/common/constants.php");

//name, email, phone, description, ids
$ids = $_POST['ids'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$description = $_POST['description'];

$orderInfo = "Имя: {$name}\nEmail: {$email}\n Телефон: {$phone}\n Описание: {$description}\n";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, title, description, photo, price, email FROM items WHERE id IN ($ids)";
$result = $conn->query($sql);
$items = new stdClass();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $items->{$row["id"]} = $row;
    }
}

$authorItems = new stdClass();

foreach ($items as $item) {
    $authorEmail = $item["email"];

    if (!isset($authorItems->{$authorEmail})) {
        $authorItems->{$authorEmail} = [];
    }

    $authorItems->{$authorEmail}[] = $item;
}

//iter over authorItems
foreach ($authorItems as $authorEmail => $items) {
    $author = $items[0]["email"];
    $totalPrice = 0;
    $itemList = "Новый заказ: \n";

    foreach ($items as $item) {
        $prettyPrice = prettyPrintPrice($item["price"]);
        $totalPrice += $item["price"];
        $itemList .= "{$item["title"]} - {$prettyPrice} руб.\n";
    }

    $prettyTotalPrice = prettyPrintPrice($totalPrice);

    mail($author, "New order", $orderInfo . $itemList . "\n Общая стоимость: {$prettyTotalPrice} руб.");
}

$conn->close();

//alert user
echo "
<script type='text/javascript' src='/common/common.js'></script>
<script>
window.basket.clear();
alert('Заказ успешно создан!');
window.location = '/dashboard/items.php';
</script>";