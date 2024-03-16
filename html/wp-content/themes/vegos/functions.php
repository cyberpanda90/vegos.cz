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
