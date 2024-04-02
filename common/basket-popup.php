<?php

function createBasketPopup()
{
    $dropdownMenu = <<<HTML
    <div class="relative inline-block text-left rounded" id="basket-menu-wrapper">
        <div
        class="origin-top-right absolute right-0 w-60 mt-6 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden"
        id="basket-menu"
        role="menu"
        aria-orientation="vertical"
        aria-labelledby="basket-menu-button"
        tabindex="-1"
        >
        <div class="container mx-auto">
            <div class="container mx-auto" id="basket-content">
            <div class="my-2" style="display: flex; flex-direction: column;" id='basket-items'>
              
            </div>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded m-4" style="width: calc(100% - 32px);" id='basket-buy' onClick="window.handleBuy()">
                           Купить
                        </button>
            </div>
        </div>
        </div>
    </div>
    HTML;

    echo $dropdownMenu;
    echo <<<JS
    <script>
        document.getElementById('basket-menu-button').addEventListener('click', function() {
            console.log('click');
            var menu = document.getElementById('basket-menu');
            menu.classList.toggle('hidden');
        });

        document.addEventListener('click', function(event) {
            var menu = document.getElementById('basket-menu');
            var button = document.getElementById('basket-menu-button');
            if (!menu.contains(event.target) && !button.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>
    JS;
}
