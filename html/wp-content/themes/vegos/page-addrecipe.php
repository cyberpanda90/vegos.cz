<?php
/* Template Name: Přidat Recept */
get_header();

if ( ! is_user_logged_in() ) {
    echo 'Pro přidání receptu se musíte přihlásit.';
    get_footer();
    exit;
}
?>

<form id="add-recipe-form" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
    <input type="hidden" name="action" value="add_recipe">
    <?php wp_nonce_field( 'add_recipe_nonce', 'add_recipe_nonce_field' ); ?>
    
    <label for="recipe-title">Název receptu</label>
    <input type="text" id="recipe-title" name="recipe_title" required>
    
    <label for="recipe-content">Popis receptu</label>
    <textarea id="recipe-content" name="recipe_content" required></textarea>

    <div id="recipe-ingredients-container">
        <div class="vegos-ingredient-row">
            <select name="vegos_recipe_ingredients_name[]" style="width: 30%">
                <option value="">Vyberte ingredienci</option>
                <?php
                $ingredients = get_terms( array(
                    'taxonomy'   => 'ingredient',
                    'hide_empty' => false,
                ) );
                foreach ($ingredients as $ingredient) {
                    echo '<option value="' . esc_attr($ingredient->name) . '">' . esc_html($ingredient->name) . '</option>';
                }
                ?>
            </select>
            <input type="number" name="vegos_recipe_ingredients_amount[]" placeholder="Množství" style="width: 20%">
            <select name="vegos_recipe_ingredients_unit[]" style="width: 20%">
                <option value="g">g</option>
                <option value="kg">kg</option>
                <option value="l">l</option>
                <option value="ml">ml</option>
                <option value="ks">ks</option>
                <option value="lžíce">lžíce</option>
                <option value="lžička">lžička</option>
            </select>
        </div>
    </div>
    <button type="button" id="add-ingredient" class="button">Přidat ingredienci</button>
    
    <div id="recipe-steps-container">
        <div class="recipe-step">
            <label for="vegos_recipe_steps">Kroky přípravy</label>
            <textarea name="vegos_recipe_steps[]" required></textarea>
        </div>
    </div>
    <button type="button" id="add-step">Přidat další krok</button>

    <input type="submit" value="Přidat Recept">
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('add-step').addEventListener('click', function() {
        var container = document.getElementById('recipe-steps-container');
        var firstStep = container.querySelector('.recipe-step');
        var newStep = firstStep.cloneNode(true);

        newStep.querySelector('textarea').value = '';
        container.appendChild(newStep);
    });
});

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('add-ingredient').addEventListener('click', function() {
        var container = document.getElementById('recipe-ingredients-container');
        var firstIngredient = container.querySelector('.vegos-ingredient-row');
        var newIngredient = firstIngredient.cloneNode(true);

        newIngredient.querySelector('select').value = '';
        newIngredient.querySelector('input').value = '';
        container.appendChild(newIngredient);
    });
});
</script>


<?php
get_footer();
