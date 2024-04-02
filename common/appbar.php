<?php
session_start();
include ($_SERVER['DOCUMENT_ROOT'] . "/common/user-popup.php");
include ($_SERVER['DOCUMENT_ROOT'] . "/common/basket-popup.php");

?>

<link rel="stylesheet" href="/common/common.css?v=<?php echo time(); ?>">
<script src="/common/common.js?v=<?php echo time(); ?>"></script>

<div
    class="sticky top-0 z-40 w-full backdrop-blur flex-none transition-colors duration-500 lg:z-50 lg:border-b lg:border-slate-900/10 dark:border-slate-50/[0.06] bg-white/95 supports-backdrop-blur:bg-white/60 dark:bg-transparent">
    <div class="max-w-8xl mx-auto">
        <div class="py-4 border-b border-slate-900/10 lg:px-8 lg:border-0 dark:border-slate-300/10 mx-4 lg:mx-0">
            <div class="relative flex items-center">
                <a class="mr-3 flex-none overflow-hidden md:w-auto" href="/">
                    <p class="text-sm sm:text-lg font">
                        FurnitureStore
                    </p>
                </a>
                <div class="relative flex items-center ml-auto">
                    <nav class="text-sm leading-6 font-semibold text-slate-700 dark:text-slate-200">
                        <ul class="flex items-center">
                            <li style="margin-right: 12px;">

                                <a class="hover:text-sky-500 dark:hover:text-sky-400" href="/about.php">О проекте</a>
                            </li>

                            <li style="position: relative;margin-left:12px;">
                                <button type="button"
                                    class="inline-flex items-center justify-center w-full rounded-md border border-gray-300 shadow-sm px-2 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    id="basket-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span id="basket" class="basket">0</span>
                                </button>
                            </li>
                            <?php
                            createBasketPopup();

                            if (isset($_SESSION['email'])) {
                                createUserPopup($_SESSION['email']);
                            } else {
                                echo "<li style=\"margin-right: 12px; margin-left: 12px;\"><a class=\"hover:text-sky-500 dark:hover:text-sky-400\" href=\"/login.php\">Вход</a>
                            </li>
                            <li style=\"margin-right: 12px;\"><a href=\"/register.php\"
                                    class=\"hover:text-sky-500 dark:hover:text-sky-400\">Регистрация</a>
                            </li>";
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>