<?php
/*
 * Template Name: Recept
 * Template Post Type: recipe
 */
   
 get_header();  ?>
kugouighliuh
<main id="main-content">
    <?php
    while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
            </header>

            <div class="entry-content">
                <?php
                // Výpis kroků receptu
                $steps = get_post_meta(get_the_ID(), '_vegos_recipe_steps', true);
                if (!empty($steps)) {
                    echo '<h2>Kroky receptu</h2>';
                    echo '<ol>';
                    foreach ($steps as $step) {
                        echo '<li>' . esc_html($step) . '</li>';
                    }
                    echo '</ol>';
                }

                // Výpis ingrediencí
                $ingredients = get_post_meta(get_the_ID(), '_vegos_recipe_ingredients', true);
                if (!empty($ingredients)) {
                    echo '<h2>Ingredience</h2>';
                    echo '<ul>';
                    foreach ($ingredients as $ingredient) {
                        echo '<li>' . esc_html($ingredient['name']) . ' - ' . esc_html($ingredient['amount']) . ' ' . esc_html($ingredient['unit']) . '</li>';
                    }
                    echo '</ul>';
                }

                // Zobrazení typu jídla (taxonomie)
                $food_types = get_the_terms(get_the_ID(), 'food_type');
                if (!empty($food_types)) {
                    echo '<h2>Typ jídla</h2>';
                    echo '<ul>';
                    foreach ($food_types as $type) {
                        echo '<li>' . esc_html($type->name) . '</li>';
                    }
                    echo '</ul>';
                }

                the_content();
                ?>
            </div>

            <footer class="entry-footer">
                <?php // Zde můžete přidat další metadata jako tagy, kategorie atd. ?>
            </footer>
        </article>

    <?php endwhile; ?>
</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
