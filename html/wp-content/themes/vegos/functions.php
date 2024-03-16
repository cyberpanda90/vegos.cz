<?php
/**
 * Vegoš functions and definitions
 */

 function vegos_login_page_url( $login_url, $redirect, $force_reauth ) {
    $login_page = home_url( '/klient/' );
    $login_url = add_query_arg( 'redirect_to', $redirect, $login_page );
    $login_url = add_query_arg( 'reauth', $force_reauth, $login_url );

    return $login_url;
}
add_filter( 'login_url', 'vegos_login_page_url', 10, 3 );

function vegos_login_page_redirect() {
    global $pagenow;
    $page_viewed = basename($_SERVER['REQUEST_URI']);

    if ( $pagenow == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET' ) {
        wp_redirect(home_url('/klient/'));
        exit;
    }
}
add_action('init','vegos_login_page_redirect');

function vegos_save_my_ingredients() {
    if ( ! isset( $_POST['my_ingredients_nonce'] ) || ! wp_verify_nonce( $_POST['my_ingredients_nonce'], 'update_my_ingredients' ) ) {
        return;
    }

    if ( isset( $_POST['ingredients'] ) && is_user_logged_in() ) {
        $current_user = wp_get_current_user();
        $ingredients = array_map( 'sanitize_text_field', $_POST['ingredients'] );
        update_user_meta( $current_user->ID, 'my_ingredients', $ingredients );
    }
}
add_action( 'template_redirect', 'vegos_save_my_ingredients' );

function handle_add_recipe_form_submission() {
    if ( ! isset( $_POST['add_recipe_nonce_field'] ) 
        || ! wp_verify_nonce( $_POST['add_recipe_nonce_field'], 'add_recipe_nonce' ) ) {
        wp_die( 'Ověření selhalo, prosím zkuste to znovu.' );
    }

    $recipe_title = sanitize_text_field( $_POST['recipe_title'] );
    $recipe_content = sanitize_textarea_field( $_POST['recipe_content'] );

    $recipe_id = wp_insert_post([
        'post_title'   => $recipe_title,
        'post_content' => $recipe_content,
        'post_status'  => 'publish',
        'post_type'    => 'recipe',
    ]);

    if ($recipe_id && !is_wp_error($recipe_id)) {
        if (isset($_POST['vegos_recipe_steps']) && is_array($_POST['vegos_recipe_steps'])) {
            $steps = array_map('sanitize_textarea_field', $_POST['vegos_recipe_steps']);
            update_post_meta($recipe_id, '_vegos_recipe_steps', $steps);
        }

        if (isset($_POST['vegos_recipe_ingredients_name']) && is_array($_POST['vegos_recipe_ingredients_name'])) {
            $ingredients_data = [];
            $names = $_POST['vegos_recipe_ingredients_name'];
            $amounts = $_POST['vegos_recipe_ingredients_amount'];
            $units = $_POST['vegos_recipe_ingredients_unit'];

            foreach ($names as $index => $name) {
                if (!empty($name)) {
                    $recipe_ingredients[] = [
                        'name' => sanitize_text_field($name),
                        'amount' => sanitize_text_field($amounts[$index]),
                        'unit' => sanitize_text_field($units[$index]),
                    ];
                }
            }

            update_post_meta($recipe_id, '_vegos_recipe_ingredients', $recipe_ingredients);
        }

        wp_redirect(get_permalink($recipe_id));
        exit;
    } else {
        wp_die('Při vytváření receptu došlo k chybě.');
    }
}
add_action('admin_post_add_recipe', 'handle_add_recipe_form_submission');
add_action('admin_post_nopriv_add_recipe', 'handle_add_recipe_form_submission');

function handle_add_to_favorites() {
    if (!isset($_POST['recipe_id'])) {
        wp_send_json_error(['message' => 'Není zadáno ID receptu.']);
        wp_die();
    }

    $recipe_id = intval($_POST['recipe_id']);
    $user_id = get_current_user_id();

    if (!$recipe_id || !$user_id) {
        wp_send_json_error(['message' => 'Nastala chyba.']);
        wp_die();
    }

    $current_favorites = get_user_meta($user_id, 'favorite_recipes', true);
    if (empty($current_favorites)) {
        $current_favorites = [];
    } elseif (!is_array($current_favorites)) {
        $current_favorites = [$current_favorites];
    }

    if (!in_array($recipe_id, $current_favorites)) {
        $current_favorites[] = $recipe_id;
        update_user_meta($user_id, 'favorite_recipes', $current_favorites);
        wp_send_json_success(['message' => 'Recept byl přidán do oblíbených.']);
    } else {
        wp_send_json_success(['message' => 'Tento recept je již ve vašich oblíbených.']);
    }

    wp_die();
}

function handle_add_to_favorites_nopriv() {
    wp_send_json_error(['message' => 'Musíte být přihlášeni.']);
    wp_die();
}


// Připojení AJAX akcí
add_action('wp_ajax_add_to_favorites', 'handle_add_to_favorites');
add_action('wp_ajax_nopriv_add_to_favorites', 'handle_add_to_favorites_nopriv');

// Přidání do oblíbených
add_action('wp_ajax_add_to_favorites', function() {
    $recipe_id = intval($_POST['recipe_id']);
    $user_id = get_current_user_id();
    $favorites = get_user_meta($user_id, 'favorite_recipes', true);

    if (!is_array($favorites)) {
        $favorites = [];
    }

    if (!in_array($recipe_id, $favorites)) {
        $favorites[] = $recipe_id;
        update_user_meta($user_id, 'favorite_recipes', $favorites);
        wp_send_json_success(['message' => 'Recept byl přidán do oblíbených.']);
    } else {
        wp_send_json_error(['message' => 'Recept je již v oblíbených.']);
    }
});

// Odebrání z oblíbených
add_action('wp_ajax_remove_from_favorites', function() {
    $recipe_id = intval($_POST['recipe_id']);
    $user_id = get_current_user_id();
    $favorites = get_user_meta($user_id, 'favorite_recipes', true);

    if (($key = array_search($recipe_id, $favorites)) !== false) {
        unset($favorites[$key]);
        update_user_meta($user_id, 'favorite_recipes', $favorites);
        wp_send_json_success(['message' => 'Recept byl odebrán z oblíbených.']);
    } else {
        wp_send_json_error(['message' => 'Recept nebyl nalezen v oblíbených.']);
    }
});
