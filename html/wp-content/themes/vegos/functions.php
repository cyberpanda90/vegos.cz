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
