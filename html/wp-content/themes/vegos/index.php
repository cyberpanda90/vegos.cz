<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div id="page">
        <header id="header">
            <h1><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
            <p><?php bloginfo('description'); ?></p>
        </header>

        <div id="content">
            <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
                <article class="post">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <?php the_content(); ?>
                </article>
            <?php endwhile; endif; ?>
        </div>

        <footer id="footer">
            <p>© <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
        </footer>
    </div>

    <?php wp_footer(); ?>
</body>
</html>
