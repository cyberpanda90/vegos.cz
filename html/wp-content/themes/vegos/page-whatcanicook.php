<?php
/* Template Name: Recepty podle mých ingrediencí */
get_header();

$current_user_id = get_current_user_id();
$user_ingredients = get_user_meta($current_user_id, 'my_ingredients', true);
?><h1>Co můžu vařit?</h1><?php
if (!empty($user_ingredients)) {
    // Získání receptů, které obsahují alespoň jednu ingredienci uživatele
    $args = [
        'post_type' => 'recipe',
        'posts_per_page' => -1,
        'tax_query' => [
            [
                'taxonomy' => 'ingredient',
                'field' => 'term_id',
                'terms' => $user_ingredients,
                'operator' => 'IN',
            ],
        ],
    ];

    $query = new WP_Query($args);
    $valid_recipes = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $recipe_ingredients = wp_get_post_terms(get_the_ID(), 'ingredient', ['fields' => 'ids']);
            // Kontrola, jestli recept obsahuje pouze ingredience, které uživatel má
            if (!array_diff($recipe_ingredients, $user_ingredients)) {
                $valid_recipes[] = get_the_ID();
            }
        }
    }

    if (!empty($valid_recipes)) {
        foreach ($valid_recipes as $recipe_id) {
            $post = get_post($recipe_id); 
            setup_postdata($post);
            // Zde vypište obsah receptu (titulek, obsah atd.)
            echo '<div>';
            the_title('<h2>', '</h2>');
            the_content();
            echo '</div>';
        }
        wp_reset_postdata();
    } else {
        echo 'Nebyly nalezeny žádné recepty obsahující pouze vaše ingredience.';
    }
} else {
    echo 'Nemáte vybrané žádné ingredience.';
}

get_footer();
