<?php get_header(); ?>

<ul class="flex flex-wrap gap-4 max-w-screen-lg mx-4 sm:mx-auto mt-10">
    <?php
    $categories = get_terms([
        'taxonomy' => 'product_category',
        'orderby' => 'ID',
        'hide_empty' => false,
    ]);

    $active_cat_id = null;

    $current_url = $_SERVER['REQUEST_URI'];

    $active_cat_slug = null;
    foreach ($categories as $cat) {
        if (strpos($current_url, $cat->slug) !== false) {
            $active_cat_slug = $cat->slug;
            $active_cat_id = $cat->term_id;
            break;
        }
    }

    if (!$active_cat_id && !empty($categories)) {
        $active_cat_id = $categories[0]->term_id;
    }

    foreach ($categories as $cat) {
        $active_class = ($cat->term_id == $active_cat_id) ?
            'p-2.5 bg-blue-500 rounded-2xl text-white' :
            'p-2.5 bg-white rounded-2xl text-gray-600 border border-gray-400 hover:bg-zinc-100';

        echo '<li>
                <a href="' . esc_url(get_term_link($cat)) . '" 
                   class="px-3 py-1 rounded transition ' . $active_class . '">'
            . esc_html($cat->name) .
            '</a>
              </li>';
    }
    ?>
</ul>

<div id="page" class="site">
    <main id="main" class="max-w-screen-lg mx-auto mt-10">
        <div class="grid mx-4 grid-cols-1  sm:grid-cols-2 md:grid-cols-3 gap-10 sm:mx-2.5">
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $term_slug = null;
            if (is_tax('product_category')) {
                $term = get_queried_object();
                if ($term && !is_wp_error($term)) {
                    $term_slug = $term->slug;
                }
            }

            $args = [
                'post_type' => 'product',
                'posts_per_page' => 6,
                'paged' => $paged,
            ];

            if ($term_slug) {
                $args['tax_query'] = [
                    [
                        'taxonomy' => 'product_category',
                        'field'    => 'slug',
                        'terms'    => $term_slug,
                    ],
                ];
            }

            $query = new WP_Query($args);

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();

                    $price = get_post_meta(get_the_ID(), 'old_price', true);
                    $orgprice = get_post_meta(get_the_ID(), 'finalPrice', true);

                    echo '<div class="px-4 py-3 rounded-md bg-white">';

                    echo '<div class="">';
                    the_post_thumbnail();
                    echo '</div>';

                    the_title('<h2 class="text-nowrap truncate">', '</h2>');

                    $terms = get_the_terms(get_the_ID(), 'product_category');
                    $parent_term = null;

                    if ($terms && !is_wp_error($terms)) {
                        foreach ($terms as $term_item) {
                            if ($term_item->parent == 0) {
                                $parent_term = $term_item;
                                break;
                            }
                        }
                    }

                    if ($parent_term) {
                        echo '<a class="text-sm text-gray-600 my-2 block" href="' . esc_url(get_term_link($parent_term)) . '">' . esc_html($parent_term->name) . '</a>';
                    }

                    echo '<div class="flex items-center justify-between">';
                    if ($price) {
                        echo '<div class="rounded-md p-1 bg-red-600 text-white"><p>' . round((($price - $orgprice) / $price) * 100) . '%' . '</p></div>';
                    }
                    echo '<div class="flex gap-x-2">';
                    if ($price) {
                        echo '<p class="text-gray-500 line-through">' . esc_html($price) . '</p>';
                    }
                    echo '<p>' . esc_html($orgprice) . '</p><p class="text-gray-500 text-sm">تومان</p>';
                    echo '</div>';
                    echo '</div>';

                    echo '<div class="flex gap-x-2 mt-4">';
                    echo '<button class="w-1/2 py-1.5 px-2.5 rounded-lg bg-blue-500 text-white ">افزودن به سبد</button>';
            ?>

                    <a href="<?= the_permalink() ?>" class=" w-1/2 py-1.5 px-2.5 rounded-lg bg-gray-200 text-gray-500 text-center">مشاهده جزئيات</a>
                <?php
                    echo '</div>';

                    echo '</div>';
                }
                ?>

        </div>
    <?php

                echo '<div class="mt-10">';
                $pagination_links = paginate_links([
                    'total' => $query->max_num_pages,
                    'current' => $paged,
                    'prev_text' => 'قبلی',
                    'next_text' => 'بعدی',
                    'type' => 'array',
                ]);

                if (is_array($pagination_links)) {
                    echo '<div aria-label="Pagination" class="flex gap-x-2 justify-center">';
                    foreach ($pagination_links as $link) {
                        $is_current = strpos($link, 'current') !== false;
                        $li_class = $is_current
                            ? "border border-gray-200 px-3 bg-blue-500 rounded-xl text-white flex items-center justify-center"
                            : "flex items-center justify-center border border-gray-200 rounded-xl px-3 py-2";
                        echo '<div class="' . $li_class . '">' . $link . '</div>';
                    }
                    echo '</div>';
                }
                echo '</div>';

                wp_reset_postdata();
            } else {
                echo '<p>هیچ محصولی موجود نیست.</p>';
            }
    ?>

    </main>



</div>

<?php get_footer(); ?>