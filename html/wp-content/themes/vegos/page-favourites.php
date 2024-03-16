<?php
/* Template Name: Moje oblíbené recepty */

get_header();

// Zkontrolujte, zda je uživatel přihlášen
if ( ! is_user_logged_in() ) {
    echo 'Pro zobrazení oblíbených receptů se musíte přihlásit.';
    get_footer();
    exit;
}

$current_user_id = get_current_user_id();
$favorites = get_user_meta($current_user_id, 'favorite_recipes', true);

// Ověření, zda je $favorites pole. Pokud ne, převedeme ho na pole.
if (!is_array($favorites)) {
    $favorites = $favorites ? array($favorites) : array();
}

echo '<h1>Oblíbené recepty</h1>';

if (empty($favorites)) {
    echo '<p>Nemáte žádné oblíbené recepty.</p>';
} else {
    echo '<p>Zde jsou vaše oblíbené recepty:</p>';
    $args = array(
        'post_type' => 'recipe',
        'post__in' => $favorites,
        'posts_per_page' => -1,
        'orderby' => 'post__in' // Toto zajistí, že pořadí příspěvků odpovídá pořadí v $favorites.
    );

    $favorites_query = new WP_Query($args);

    if ($favorites_query->have_posts()) {
        echo '<ul>';
        while ($favorites_query->have_posts()) {
            $favorites_query->the_post();
            echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
        }
        echo '</ul>';
    } else {
        echo '<p>Nemáte žádné oblíbené recepty.</p>';
    }

    wp_reset_postdata();
}

get_footer();
?>
