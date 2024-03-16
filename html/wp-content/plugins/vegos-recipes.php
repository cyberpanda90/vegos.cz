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
        'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
        'show_in_rest'       => false,
    );

    register_post_type('recipe', $args);
}

add_action('init', 'vegos_register_recipe_post_type');
