<?php
/* Template Name: Moje Ingredience */

// Zajistěte, že je uživatel přihlášený
if ( ! is_user_logged_in() ) {
    wp_redirect( wp_login_url( get_permalink() ) );
    exit;
}

get_header();

$current_user = wp_get_current_user();
$saved_ingredients = get_user_meta( $current_user->ID, 'my_ingredients', true );

// Načtení ingrediencí z taxonomie
$ingredients = get_terms( array(
    'taxonomy'   => 'ingredient',
    'hide_empty' => false,
) );

?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
    <h1>Moje ingredience</h1>
        <form action="" method="post">
            <?php foreach ( $ingredients as $ingredient ): ?>
                <input type="checkbox" name="ingredients[]" value="<?php echo esc_attr( $ingredient->term_id ); ?>" <?php checked( in_array( $ingredient->term_id, (array) $saved_ingredients ) ); ?>>
                <label for="ingredient-<?php echo esc_attr( $ingredient->term_id ); ?>">
                    <?php echo esc_html( $ingredient->name ); ?>
                </label><br>
            <?php endforeach; ?>

            <input type="submit" value="Uložit">
            <?php wp_nonce_field( 'update_my_ingredients', 'my_ingredients_nonce' ); ?>
        </form>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
