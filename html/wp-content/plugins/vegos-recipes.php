<?php
/**
 * Plugin Name: Vegoš Recipes
 * Plugin URI: https://vegos.cz
 * Description: Přidává nový typ příspěvku "Recept" pro správu receptů.
 * Version: 1.0
 * Author: Vegoš
 * Author URI: https://vegos.cz
 */


 function vegos_register_recipe_post_type() {
    $labels = array(
        'name'                  => _x('Recepty', 'Post type general name', 'textdomain'),
        'singular_name'         => _x('Recept', 'Post type singular name', 'textdomain'),
        'menu_name'             => _x('Recepty', 'Admin Menu text', 'textdomain'),
        'name_admin_bar'        => _x('Recept', 'Add New on Toolbar', 'textdomain'),
        'add_new'               => __('Přidat nový', 'textdomain'),
        'add_new_item'          => __('Přidat nový recept', 'textdomain'),
        'new_item'              => __('Nový recept', 'textdomain'),
        'edit_item'             => __('Upravit recept', 'textdomain'),
        'view_item'             => __('Zobrazit recept', 'textdomain'),
        'all_items'             => __('Všechny recepty', 'textdomain'),
        'search_items'          => __('Hledat recepty', 'textdomain'),
        'parent_item_colon'     => __('Nadřazené recepty:', 'textdomain'),
        'not_found'             => __('Žádné recepty nenalezeny.', 'textdomain'),
        'not_found_in_trash'    => __('Žádné recepty v koši.', 'textdomain'),
        'featured_image'        => _x('Obrázek receptu', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain'),
        'set_featured_image'    => _x('Nastavit obrázek receptu', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'remove_featured_image' => _x('Odstranit obrázek receptu', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'use_featured_image'    => _x('Použít jako obrázek receptu', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'archives'              => _x('Archiv receptů', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain'),
        'insert_into_item'      => _x('Vložit do receptu', 'Overrides the “Insert into post”/“Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain'),
        'uploaded_to_this_item' => _x('Nahráno k tomuto receptu', 'Overrides the “Uploaded to this post”/“Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain'),
        'filter_items_list'     => _x('Filtrovat seznam receptů', 'Screen reader text for the filter links heading on the post type listing screen. Added in 4.4', 'textdomain'),
        'items_list_navigation' => _x('Navigace seznamu receptů', 'Screen reader text for the pagination heading on the post type listing screen. Added in 4.4', 'textdomain'),
        'items_list'            => _x('Seznam receptů', 'Screen reader text for the items list heading on the post type listing screen. Added in 4.4', 'textdomain'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'recept'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'author', 'thumbnail', 'excerpt', 'comments'),
        'show_in_rest'       => false,
    );

    register_post_type('recipe', $args);
}

add_action('init', 'vegos_register_recipe_post_type');

function vegos_register_ingredients_taxonomy() {
    $labels = array(
        'name'                       => _x('Ingredience', 'taxonomy general name', 'textdomain'),
        'singular_name'              => _x('Ingredience', 'taxonomy singular name', 'textdomain'),
        'search_items'               => __('Hledat Ingredience', 'textdomain'),
        'popular_items'              => __('Populární Ingredience', 'textdomain'),
        'all_items'                  => __('Všechny Ingredience', 'textdomain'),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __('Upravit Ingredience', 'textdomain'),
        'update_item'                => __('Aktualizovat Ingredience', 'textdomain'),
        'add_new_item'               => __('Přidat novou Ingredience', 'textdomain'),
        'new_item_name'              => __('Nové jméno Ingredience', 'textdomain'),
        'separate_items_with_commas' => __('Oddělte ingredience čárkami', 'textdomain'),
        'add_or_remove_items'        => __('Přidat nebo odebrat ingredience', 'textdomain'),
        'choose_from_most_used'      => __('Vyberte z nejčastěji používaných ingrediencí', 'textdomain'),
        'not_found'                  => __('Nenalezeno', 'textdomain'),
        'menu_name'                  => __('Ingredience', 'textdomain'),
    );

    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_in_nav_menus'     => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array('slug' => 'ingredience'),
        'show_in_rest'          => false,
    );

    register_taxonomy('ingredient', 'recipe', $args);
}

add_action('init', 'vegos_register_ingredients_taxonomy');

function vegos_register_food_type_taxonomy() {
    $labels = array(
        'name'              => _x('Typy jídla', 'taxonomy general name', 'textdomain'),
        'singular_name'     => _x('Typ jídla', 'taxonomy singular name', 'textdomain'),
        'search_items'      => __('Hledat Typy jídla', 'textdomain'),
        'all_items'         => __('Všechny Typy jídla', 'textdomain'),
        'parent_item'       => __('Nadřazený Typ jídla', 'textdomain'),
        'parent_item_colon' => __('Nadřazený Typ jídla:', 'textdomain'),
        'edit_item'         => __('Upravit Typ jídla', 'textdomain'),
        'update_item'       => __('Aktualizovat Typ jídla', 'textdomain'),
        'add_new_item'      => __('Přidat nový Typ jídla', 'textdomain'),
        'new_item_name'     => __('Nový název Typu jídla', 'textdomain'),
        'menu_name'         => __('Typ jídla', 'textdomain'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_in_nav_menus' => true,
        'show_in_rest'      => false,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'typ-jidla'),
    );

    register_taxonomy('food_type', array('recipe'), $args);
}

add_action('init', 'vegos_register_food_type_taxonomy');

function vegos_add_recipe_steps_metabox() {
    add_meta_box('recipe_steps_metabox', 'Postup přípravy', 'vegos_recipe_steps_metabox_callback', 'recipe', 'normal', 'high');
}
add_action('add_meta_boxes', 'vegos_add_recipe_steps_metabox');

function vegos_recipe_steps_metabox_callback($post) {
    // Bezpečnostní pole
    wp_nonce_field('vegos_save_recipe_steps', 'vegos_recipe_steps_nonce');

    // Získání uložených kroků, pokud existují
    $steps = get_post_meta($post->ID, '_vegos_recipe_steps', true);

    // Kontejner pro kroky
    echo '<div id="vegos_recipe_steps_container">';
    if (is_array($steps) && !empty($steps)) {
        foreach ($steps as $index => $step) {
            echo '<p><textarea name="vegos_recipe_steps[]" style="width:100%;" rows="4">' . esc_textarea($step) . '</textarea></p>';
        }
    } else {
        echo '<p><textarea name="vegos_recipe_steps[]" style="width:100%;" rows="4"></textarea></p>';
    }
    echo '</div>';
    echo '<button type="button" id="vegos_add_step_button">Přidat další krok</button>';

    // JavaScript pro přidání dalších kroků
    ?>
    <script>
    jQuery(document).ready(function($) {
        var container = $('#vegos_recipe_steps_container');
        $('#vegos_add_step_button').click(function() {
            container.append('<p><textarea name="vegos_recipe_steps[]" style="width:100%;" rows="4"></textarea></p>');
        });
    });
    </script>
    <?php
}

function vegos_save_recipe_steps($post_id) {
    // Kontrola bezpečnostního nonce
    if (!isset($_POST['vegos_recipe_steps_nonce']) || !wp_verify_nonce($_POST['vegos_recipe_steps_nonce'], 'vegos_save_recipe_steps')) {
        return;
    }

    // Kontrola oprávnění
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Uložení kroků, pokud existují
    if (isset($_POST['vegos_recipe_steps'])) {
        $steps = array_map('sanitize_textarea_field', $_POST['vegos_recipe_steps']);
        update_post_meta($post_id, '_vegos_recipe_steps', $steps);
    } else {
        delete_post_meta($post_id, '_vegos_recipe_steps');
    }
}
add_action('save_post_recipe', 'vegos_save_recipe_steps');

function vegos_add_ingredients_metabox() {
    add_meta_box('recipe_ingredients_metabox', 'Ingredience', 'vegos_ingredients_metabox_callback', 'recipe', 'normal', 'high');
}
add_action('add_meta_boxes', 'vegos_add_ingredients_metabox');

function vegos_ingredients_metabox_callback($post) {
    wp_nonce_field('vegos_save_ingredients', 'vegos_ingredients_nonce');
    $terms = get_terms(array(
        'taxonomy' => 'ingredient',
        'hide_empty' => false,
    ));

    // Načtení uložených ingrediencí z meta
    $saved_ingredients = get_post_meta($post->ID, '_vegos_recipe_ingredients', true);

    echo '<div id="vegos_ingredients_container">';
    
    // Pokud jsou nějaké ingredience uloženy, zobrazit je
    if (!empty($saved_ingredients)) {
        foreach ($saved_ingredients as $ing) {
            echo vegos_get_ingredient_row_html($terms, $ing['name'], $ing['amount'], $ing['unit']);
        }
    }

    echo '</div>';
    echo '<button type="button" id="vegos_add_ingredient_button" class="button">Přidat ingredienci</button>';

    // Funkce pro generování HTML kódu řádku ingrediencí
    // Nyní je tato funkce použita pro generování prázdného i předvyplněného řádku
    ?>
    <script type="text/javascript">
    function getIngredientRowHtml(name = '', amount = '', unit = '') {
        return `
            <div class="vegos-ingredient-row">
                <select name="vegos_recipe_ingredients_name[]" style="width: 30%;">
                    <option value="">Vyberte ingredienci</option>
                    <?php foreach ($terms as $term): ?>
                    <option value="<?php echo esc_attr($term->name); ?>" ${name === "<?php echo esc_js($term->name); ?>" ? 'selected' : ''}><?php echo esc_html($term->name); ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="number" name="vegos_recipe_ingredients_amount[]" value="${amount}" placeholder="Množství" style="width: 20%;" min="0">
                <select name="vegos_recipe_ingredients_unit[]" style="width: 20%;">
                    <option value="kg" ${unit === "kg" ? 'selected' : ''}>kg</option>
                    <option value="g" ${unit === "g" ? 'selected' : ''}>g</option>
                    <option value="ks" ${unit === "ks" ? 'selected' : ''}>ks</option>
                    <option value="l" ${unit === "l" ? 'selected' : ''}>l</option>
                    <option value="ml" ${unit === "ml" ? 'selected' : ''}>ml</option>
                    <option value="lžíce" ${unit === "lžíce" ? 'selected' : ''}>lžíce</option>
                    <option value="lžička" ${unit === "lžička" ? 'selected' : ''}>lžička</option>
                </select>
                <button type="button" class="button vegos-remove-ingredient-button">Odstranit</button>
            </div>`;
    }

    jQuery(document).ready(function($) {
    var container = $('#vegos_ingredients_container');

    function updateIngredientOptions() {
        var allSelectedIngredients = [];
        $("select[name='vegos_recipe_ingredients_name[]']").each(function() {
            var selectedValue = $(this).val();
            if (selectedValue) {
                allSelectedIngredients.push(selectedValue);
            }
        });

        $("select[name='vegos_recipe_ingredients_name[]']").each(function() {
            var currentSelectedValue = $(this).val();
            $(this).find('option').each(function() {
                var optionValue = $(this).attr('value');
                if (optionValue && allSelectedIngredients.includes(optionValue) && currentSelectedValue !== optionValue) {
                    $(this).attr('disabled', true);
                } else {
                    $(this).removeAttr('disabled');
                }
            });
        });
    }

    $('#vegos_add_ingredient_button').click(function(e) {
        e.preventDefault();
        container.append(getIngredientRowHtml());
        updateIngredientOptions();
    });

    $(document).on('change', "select[name='vegos_recipe_ingredients_name[]']", function() {
        updateIngredientOptions();
    });

    $(document).on('click', '.vegos-remove-ingredient-button', function(e) {
        e.preventDefault();
        $(this).closest('.vegos-ingredient-row').remove();
        updateIngredientOptions();
    });

    // Inicializační volání pro nastavení
    updateIngredientOptions();


});
jQuery(document).ready(function($) {
    // Funkce pro synchronizaci ingrediencí z metaboxu do sidebaru
    function syncIngredientsToSidebar() {
        // Získat všechny vybrané hodnoty ingrediencí z metaboxu
        var selectedIngredients = [];
        $("#vegos_ingredients_container select[name='vegos_recipe_ingredients_name[]']").each(function() {
            var ingredientValue = $(this).val();
            if (ingredientValue) {
                selectedIngredients.push(ingredientValue);
            }
        });

        // Projít všechny checkboxy v sidebaru taxonomie a zaškrtnout příslušné
        $("#ingredientchecklist li input").each(function() {
            if (selectedIngredients.indexOf($(this).val()) > -1) {
                $(this).prop('checked', true);
            } else {
                $(this).prop('checked', false);
            }
        });
    }

    // Přidání event handleru pro změnu na výběru ingredience
    $("#vegos_ingredients_container").on("change", "select[name='vegos_recipe_ingredients_name[]']", function() {
        syncIngredientsToSidebar();
    });

    // Můžete také přidat event handler pro tlačítko 'Odstranit'
    $("#vegos_ingredients_container").on("click", ".vegos-remove-ingredient-button", function() {
        // Počkejte, než se odstranění dokončí
        setTimeout(function() {
            syncIngredientsToSidebar();
        }, 100);
    });
});

    </script>
    <?php
}

// Pomocná funkce pro generování HTML kódu řádku ingrediencí na serverové straně
function vegos_get_ingredient_row_html($terms, $selected_name = '', $selected_amount = '', $selected_unit = '') {
    ob_start(); // Začátek ukládání výstupu do bufferu
    ?>
    <div class="vegos-ingredient-row">
        <select name="vegos_recipe_ingredients_name[]" style="width: 30%;">
            <option value="">Vyberte ingredienci</option>
            <?php foreach ($terms as $term): ?>
            <option value="<?php echo esc_attr($term->name); ?>" <?php selected($selected_name, $term->name); ?>><?php echo esc_html($term->name); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="vegos_recipe_ingredients_amount[]" value="<?php echo esc_attr($selected_amount); ?>" placeholder="Množství" style="width: 20%;" min="0">
        <select name="vegos_recipe_ingredients_unit[]" style="width: 20%;">
            <option value="kg" <?php selected($selected_unit, 'kg'); ?>>kg</option>
            <option value="g" <?php selected($selected_unit, 'g'); ?>>g</option>
            <option value="ks" <?php selected($selected_unit, 'ks'); ?>>ks</option>
            <option value="l" <?php selected($selected_unit, 'l'); ?>>l</option>
            <option value="ml" <?php selected($selected_unit, 'ml'); ?>>ml</option>
        </select>
        <button type="button" class="button vegos-remove-ingredient-button">Odstranit</button>
    </div>
    <?php
    return ob_get_clean(); // Vrátí obsah bufferu a ukončí buffering
}



function vegos_save_ingredients($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['vegos_ingredients_nonce']) || !wp_verify_nonce($_POST['vegos_ingredients_nonce'], 'vegos_save_ingredients')) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['vegos_recipe_ingredients_name'], $_POST['vegos_recipe_ingredients_amount'], $_POST['vegos_recipe_ingredients_unit'])) {
        $ingredients_data = [];
        $names = $_POST['vegos_recipe_ingredients_name'];
        $amounts = $_POST['vegos_recipe_ingredients_amount'];
        $units = $_POST['vegos_recipe_ingredients_unit'];

        foreach ($names as $index => $name) {
            if (!empty($name)) { // Ignorujeme prázdné řádky
                $ingredients_data[] = [
                    'name' => sanitize_text_field($name),
                    'amount' => sanitize_text_field($amounts[$index]),
                    'unit' => sanitize_text_field($units[$index]),
                ];
            }
        }
        update_post_meta($post_id, '_vegos_recipe_ingredients', $ingredients_data);
    } else {
        delete_post_meta($post_id, '_vegos_recipe_ingredients');
    }
}
add_action('save_post_recipe', 'vegos_save_ingredients');

function vegos_add_featured_image_support() {
    add_theme_support('post-thumbnails', array('recipe'));
}
add_action('after_setup_theme', 'vegos_add_featured_image_support');
