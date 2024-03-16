<?php
   
 get_header();  ?>
<main id="main-content">
    <?php
    while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                <?php
$current_user_id = get_current_user_id();
$favorites = get_user_meta($current_user_id, 'favorite_recipes', true);
if (!is_array($favorites)) {
    $favorites = $favorites ? array($favorites) : array();
}
$recipe_id = get_the_ID();

if ( is_user_logged_in() ): ?>
    <button id="remove-from-favorites" data-recipe-id="<?php echo $recipe_id; ?>" <?php if (!in_array($recipe_id, $favorites)): ?>style="display:none"<?php endif; ?>>Odebrat z oblíbených</button>
    <button id="add-to-favorites" data-recipe-id="<?php echo $recipe_id; ?>" <?php if (in_array($recipe_id, $favorites)): ?>style="display:none"<?php endif; ?>>Přidat do oblíbených</button>

<?php else: ?>
    <a href="/login" class="btn btn-primary">Pro uložení do oblíbených se přihlaste</a>
<?php endif; ?>


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

<div id="login-modal" style="display:none;">
    <p>Musíte být přihlášeni, abyste mohli přidat recept do oblíbených.</p>
    <!-- Tlačítko pro zavření modálního okna nebo odkaz na přihlášení -->
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var addToFavoritesBtn = document.getElementById('add-to-favorites');
    var removeFromFavoritesBtn = document.getElementById('remove-from-favorites');

    if (addToFavoritesBtn) {
        addToFavoritesBtn.addEventListener('click', function() {
            var recipeId = this.getAttribute('data-recipe-id');
            fetch('/wp-admin/admin-ajax.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
                },
                body: 'action=add_to_favorites&recipe_id=' + recipeId,
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    addToFavoritesBtn.style.display = 'none';
                    removeFromFavoritesBtn.style.display = 'block';
                    
                } else {
                    alert(data.data.message); // Zobrazí chybovou zprávu z PHP
                }
            });
        });
    }

    if (removeFromFavoritesBtn) {
        removeFromFavoritesBtn.addEventListener('click', function() {
            var recipeId = this.getAttribute('data-recipe-id');
            fetch('/wp-admin/admin-ajax.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
                },
                body: 'action=remove_from_favorites&recipe_id=' + recipeId,
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    removeFromFavoritesBtn.style.display = 'none';
                    addToFavoritesBtn.style.display = 'block';
                } else {
                    alert(data.data.message); // Zobrazí chybovou zprávu z PHP
                }
            });
        });
    }
});

</script>

<?php get_footer(); ?>
