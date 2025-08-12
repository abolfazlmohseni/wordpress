<!DOCTYPE html>
<html <?php language_attributes() ?>>

<head>
    <meta charset="<?php bloginfo('charset') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head() ?>
</head>

<body>
    <header class="bg-white border-b border-gray-300">
        <div class="max-w-screen-lg mx-auto flex justify-between items-center gap-1 p-3 text-gray-500">
            <div class="flex items-center">
                <div class="w-12 h-12 ml-2">
                    <?php if (function_exists("the_custom_logo")) {
                        the_custom_logo();
                    } ?>
                </div>
                <?php wp_nav_menu([
                    "theme_location" => "header",
                    "menu_class" => "flex gap-4",
                    "container" => false
                ]) ?>
            </div>
            <div>
                <?php wp_nav_menu([
                    "theme_location" => "header 2",
                    "menu_class" => "flex gap-4",
                    "container" => false
                ]) ?>
            </div>
        </div>

    </header>