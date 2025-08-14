<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    
<header class="bg-white border-b border-gray-300">
    <div class="max-w-screen-lg mx-auto flex gap-5 p-3 items-center">
        <?php if (function_exists("the_custom_logo")) {
            echo '<div class="max-w-[45px]">';
            the_custom_logo();
            echo '</div>';
        } ?>    
        <?php wp_nav_menu([
            "theme_location"=>"header",
            "menu_class"=>"flex gap-3",
            "container"=>false
        ])?>
    </div>
    
</header>