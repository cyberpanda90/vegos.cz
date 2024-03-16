<?php
/**
 * Template Name: Přihlášení
 *
 * @package WordPress
 * @subpackage VašeTéma
 */

if ( is_user_logged_in() ) {
    wp_redirect( home_url() ); // Přesměrování přihlášených uživatelů na hlavní stránku
    exit;
}

get_header();

// Zde můžete přidat jakýkoliv HTML nebo šablonový tag před přihlašovacím formulářem
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            </header><!-- .entry-header -->

            <div class="entry-content">
                <?php
                // Vložení přihlašovacího formuláře
                wp_login_form( array(
                    'echo'           => true,
                    'redirect'       => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
                    'form_id'        => 'loginform-custom',
                    'label_username' => __( 'Uživatelské jméno' ),
                    'label_password' => __( 'Heslo' ),
                    'label_remember' => __( 'Zapamatovat si mě' ),
                    'label_log_in'   => __( 'Přihlásit se' ),
                    'id_username'    => 'user_login',
                    'id_password'    => 'user_pass',
                    'id_remember'    => 'rememberme',
                    'id_submit'      => 'wp-submit',
                    'remember'       => true,
                    'value_username' => '',
                    // Set 'value_remember' to true to default the "Remember me" checkbox to checked
                    'value_remember' => false,
                ) );
                ?>
            </div><!-- .entry-content -->

        </article><!-- #post-## -->

    </main><!-- .site-main -->
</div><!-- .content-area -->

<?php
get_footer();
