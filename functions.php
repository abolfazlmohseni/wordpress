<?php

function maghzino_enqueue_styles() {
  wp_enqueue_style(
    'maghzino-style', // Handle name
    get_stylesheet_uri(), // This gets style.css in the root of the theme
    
  );
  wp_enqueue_script(
    'tailwind', // Handle name
    "https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4", // This gets style.css in the root of the theme
    
  );
}
add_action('wp_enqueue_scripts', 'maghzino_enqueue_styles');

add_action("init",function(){
    add_theme_support("custom-logo");
    add_theme_support("post-thumbnails");
    add_theme_support("custom-background");
    // register_post_type("product", [
    //   "public" => true,
    //   "label" => "محصولات",

    //   "supports" => [
    //     "title",
    //     "editor",
    //     "thumbnails",
    //     "excerpt",
    //     "custom-fields",
    //   ],

      // "show_in_rest" => true,

      // "rewrite" => ["slug" => "test"]

      
//     ]);
//   //   register_taxonomy('product_category', ['product'], [
//   //   'hierarchical'      => true,
//   //   'labels'            => [
//   //     'name'          => 'دسته بندی های محصولات',
//   //     'singular_name' => 'دسته بندی محصول'
//   //   ],
//   //   'rewrite'           => ['slug' => 'product-category'],
//   //   "show_in_rest" => true,
//   // ]);

});
    add_action( 'after_setup_theme',function (){
    register_nav_menus([
        'header' => "Header Menu"
    ]);
});

// maghzino_add_custom_field("price", "product", "Price (final)" );
// maghzino_add_custom_field("old_price", "product", "Price (before)");

function maghzino_add_custom_field($fieldName, $postType, $title)
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


// add_action('pre_get_posts', function ($query) {
//   if ($query->is_home() && $query->is_main_query() && !is_admin()) {
//     $query->set('post_type', 'product');
//   }
// });

// add_action('pre_get_posts', function ($query) {
//   if ($query->is_home() && $query->is_main_query() && !is_admin()) {
//     $query->set('post_type', 'product');
//   }
// });