<?php

function hodcode_enqueue_styles()
{
    wp_enqueue_style(
        'hodkode-style',
        get_stylesheet_uri(),
    );
    wp_enqueue_script(
        'tailwind',
        "https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4",
    );
}
add_action('wp_enqueue_scripts', 'hodcode_enqueue_styles');


add_action('after_setup_theme', function () {
    add_theme_support('custom-logo');
});

add_action('after_setup_theme', function () {
    register_nav_menus([
        'header' => "Header Menu right"
    ]);
    register_nav_menus([
        'header 2' => "Header Menu left"
    ]);
    register_nav_menus([
        'footer' => "footer"
    ]);
});
add_filter('nav_menu_css_class', function ($classes, $item, $args) {
    if ($args->theme_location === 'footer') {
        $classes[] = 'border-2 border-gray-300 rounded-full p-2.5';
    }
    return $classes;
}, 10, 3);
function create_product_post_type()
{
    register_post_type('product', [
        'labels' => [
            'name' => 'محصولات',
            'singular_name' => 'محصول',
            'add_new_item' => 'افزودن محصول جدید',
            'edit_item' => 'ویرایش محصول',
            'all_items' => 'همه محصولات',
        ],
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-cart',
        'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
        'rewrite' => ['slug' => 'products'],
    ]);
}
add_action('init', 'create_product_post_type');

function create_product_taxonomy()
{
    register_taxonomy('product_category', 'product', [
        'labels' => [
            'name' => 'دسته‌بندی محصولات',
            'singular_name' => 'دسته‌بندی محصول',
            'all_items' => 'همه دسته‌ها',
            'edit_item' => 'ویرایش دسته',
            'add_new_item' => 'افزودن دسته جدید',
            'new_item_name' => 'نام دسته جدید',
        ],
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'rewrite' => ['slug' => 'product-category'],
    ]);
}
add_action('init', 'create_product_taxonomy');
