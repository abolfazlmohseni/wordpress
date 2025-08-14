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
    add_theme_support('post-thumbnails');
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
        'supports' => ['title', 'editor', 'thumbnail'],
        'rewrite' => ['slug' => 'products'],
        'show_in_rest' => true,

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



hodcode_add_custom_field("finalPrice", "product", "finalPrice");
hodcode_add_custom_field("old_price", "product", "price");
hodcode_add_custom_field("SensorType", "product", "SensorType");
hodcode_add_custom_field("SensorDisconnection", "product", "SensorDisconnection");
function hodcode_add_custom_field($fieldName, $postType, $title)
{

    add_action('add_meta_boxes', function () use ($fieldName, $postType, $title) {
        add_meta_box(
            $fieldName . '_box',
            $title,
            function ($post) use ($fieldName) {
                $value = get_post_meta($post->ID, $fieldName, true);
                wp_nonce_field($fieldName . '_nonce', $fieldName . '_nonce_field');
                echo '<input type="text" style="width:100%"
         name="' . esc_attr($fieldName) . '" value="' . esc_attr($value) . '">';
            },
            $postType,
            'normal',
            'default'
        );
    });

    add_action('save_post', function ($post_id) use ($fieldName) {
        // checks
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!isset($_POST[$fieldName . '_nonce_field'])) return;
        if (!wp_verify_nonce($_POST[$fieldName . '_nonce_field'], $fieldName . '_nonce')) return;
        if (!current_user_can('edit_post', $post_id)) return;
        // save
        if (isset($_POST[$fieldName])) {
            $san = sanitize_text_field(wp_unslash($_POST[$fieldName]));
            update_post_meta($post_id, $fieldName, $san);
        } else {
            delete_post_meta($post_id, $fieldName);
        }
    });
}


add_action('pre_get_posts', function ($query) {
    if ($query->is_home() && $query->is_main_query() && !is_admin()) {
        $query->set('post_type', 'product');
    }
});
