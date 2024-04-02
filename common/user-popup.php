<?php

function createUserPopup($email)
{
    $dropdownMenu = <<<HTML
        <div class="relative inline-block text-left"  style="margin-left: 24px;">
            <div>
                <button type="button" class="inline-flex items-center justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                    <i class="fas fa-user mr-2"></i> 
                    $email
                </button>
            </div>
            <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden" id="user-menu" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                <div class="py-1" role="none">
                    <a href="/dashboard.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Панель управления</a>
                    <a href="/login.php?logout=true" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Выйти</a>
                </div>
            </div>
        </div>
    HTML;

    echo $dropdownMenu;
    echo <<<JS
    <script>
        document.getElementById('user-menu-button').addEventListener('click', function() {
            var menu = document.getElementById('user-menu');
            menu.classList.toggle('hidden');
        });

        document.addEventListener('click', function(event) {
            var menu = document.getElementById('user-menu');
            var button = document.getElementById('user-menu-button');
            if (!menu.contains(event.target) && !button.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>
    JS;
}
