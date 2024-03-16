<?php
/**
 * Plugin Name: Vegoš Login fail
 * Plugin URI: https://vegos.cz
 * Description: Přesměrování na přihlašovací stránku po chybném přihlášení
 * Version: 1.0
 * Author: Vegoš
 * Author URI: https://vegos.cz
 */

 function vegos_custom_login_failed( $username ) {
    $referrer = $_SERVER['HTTP_REFERER'];  // kde přišel uživatel

    // Pokud není prázdný a není to wp-login.php
    if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
        wp_redirect( add_query_arg('login', 'failed', $referrer) );
        exit;
    }
}
