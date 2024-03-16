<?php
/**
 * Template Name: Přihlášení
 *
 * @package WordPress
 */

// Přesměrování již přihlášených uživatelů
if ( is_user_logged_in() ) {
    wp_redirect( home_url() );
    exit;
}

get_header();
?>

<!-- Zde začíná obsah šablony -->

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <!-- Přihlašovací formulář -->
        <div class="login-form-container">
            <?php
            // Výpis chybových hlášení (pokud existují)
            $login  = (isset($_GET['login']) ) ? $_GET['login'] : 0;
            if ( 'failed' === $login ) {
                echo '<p class="login-msg">Přihlášení se nezdařilo. Zkuste to prosím znovu.</p>';
            }
            ?>

            <?php
            // Funkce pro výpis formuláře
            wp_login_form( array(
                'echo'           => true,
                'redirect'       => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], // Přesměrování zpět na tuto stránku
                'form_id'        => 'loginform',
                'label_username' => __( 'Uživatelské jméno' ),
                'label_password' => __( 'Heslo' ),
                'label_remember' => __( 'Zapamatuj si mě' ),
                'label_log_in'   => __( 'Přihlásit se' ),
                'id_username'    => 'user_login',
                'id_password'    => 'user_pass',
                'id_remember'    => 'rememberme',
                'id_submit'      => 'wp-submit',
                'remember'       => true,
                'value_username' => '',
                'value_remember' => false,
            ) );
            ?>
        </div>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
