<?php

include ($_SERVER['DOCUMENT_ROOT'] . "/common/utils.php");

function createCardItem($title, $description, $id, $img, $price, $admin = false)
{
    $prettyPrice = prettyPrintPrice($price);
    $onClick = 'window.basket.add(' . $id . '); alert(\'Добавлено в корзину\')';
    $btnClassname = 'bg-blue-500 hover:bg-blue-700';
    $btnText = 'Купить';

    if ($admin) {
        $onClick = 'window.location.href=\'/dashboard/items.php?id=' . $id . '\'';
        $btnClassname = 'bg-red-500 hover:bg-red-700';
        $btnText = 'Удалить';
    }

    $card = <<<HTML
    <div class="max-w-sm rounded overflow-hidden shadow-lg" >
        <img class="w-full" src="$img" alt="Product Image">
        <div class="px-6 py-4">
            <div class="font-bold text-xl mb-2">$title</div>
            <p class="text-gray-700 text-base">$description</p>
            <p class="text-gray-700 text-2xl py-2"><b>$prettyPrice руб.</b></p>
        </div>
        <div class="px-6 py-4" style="padding-top: 0;">
            <button class="$btnClassname text-white font-bold py-2 px-4 rounded" onClick="$onClick">
            $btnText
            </button>
            <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded" onClick="window.location.href='/item.php?id=$id'">
                Посмотреть
            </button>
        </div>
    </div>
    HTML;

    echo $card;
}

?>