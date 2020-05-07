<?php

/**
 * @wordpress-plugin
 * Plugin Name:       WP FAQ Playground
 * Plugin URI:        https://hkvlaanderen.com
 * Description:       Easy to modify plugin for displaying FAQs
 * Version:           1.0.0
 * Author:            Hendrik Vlaanderen
 * Author URI:        https://hkvlaanderen.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-faq-playground
*/

defined( 'ABSPATH' ) or die( 'Direct script access disallowed.' );



require_once 'templates/list.php';
add_shortcode('faq_items', 'faq_show_loop');

function faq_show_loop(){
    ob_start();

    get_faq_loop();

    $html = ob_get_contents();
    ob_end_clean();

    return $html;

}


function faq_playground_include_scripts(){

    $version = 1.0;

    wp_enqueue_style( 'understrap-styles', plugins_url('faq') .'/css/faq.css', array(), $version );
    wp_enqueue_script('faq', plugins_url('faq') . '/js/faq.js', array('jquery'), $version, true);

}

add_action( 'wp_enqueue_scripts', 'faq_playground_include_scripts', 10);


if ( ! function_exists('register_playground_faq') ) {

// Register Custom Post Type
    function register_playground_faq() {

        $labels = array(
            'name'                  => _x( 'FAQ', 'Post Type General Name', 'faq-playground' ),
            'singular_name'         => _x( 'FAQ', 'Post Type Singular Name', 'faq-playground' ),
            'menu_name'             => __( 'FAQ', 'faq-playground' ),
            'name_admin_bar'        => __( 'FAQ', 'faq-playground' ),
            'archives'              => __( 'FAQ', 'faq-playground' ),
            'attributes'            => __( 'Item Attributes', 'faq-playground' ),
            'parent_item_colon'     => __( 'Parent Item:', 'faq-playground' ),
            'all_items'             => __( 'All FAQ Items', 'faq-playground' ),
            'add_new_item'          => __( 'Add New FAQ Item', 'faq-playground' ),
            'add_new'               => __( 'Add FAQ Item', 'faq-playground' ),
            'new_item'              => __( 'New FAQ Item', 'faq-playground' ),
            'edit_item'             => __( 'Edit FAQ Item', 'faq-playground' ),
            'update_item'           => __( 'Update FAQ Item', 'faq-playground' ),
            'view_item'             => __( 'View FAQ Item', 'faq-playground' ),
            'view_items'            => __( 'View FAQ Items', 'faq-playground' ),
            'search_items'          => __( 'Search FAQ Items', 'faq-playground' ),
            'not_found'             => __( 'Not found', 'faq-playground' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'faq-playground' ),
            'featured_image'        => __( 'Featured Image', 'faq-playground' ),
            'set_featured_image'    => __( 'Set featured image', 'faq-playground' ),
            'remove_featured_image' => __( 'Remove featured image', 'faq-playground' ),
            'use_featured_image'    => __( 'Use as featured image', 'faq-playground' ),
            'insert_into_item'      => __( 'Insert into item', 'faq-playground' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'faq-playground' ),
            'items_list'            => __( 'Items list', 'faq-playground' ),
            'items_list_navigation' => __( 'Items list navigation', 'faq-playground' ),
            'filter_items_list'     => __( 'Filter items list', 'faq-playground' ),
        );
        $args = array(
            'label'                 => __( 'FAQ', 'faq-playground' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'excerpt' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-businessman',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => true,
            'publicly_queryable'    => false,
            'query_var' 			=> true,
            'capability_type'       => 'page',
            'rewrite' 				=> array('slug' => 'faq')
        );
        register_post_type( 'faq', $args );

    }
    add_action( 'init', 'register_playground_faq', 0 );

}


// Register Custom Taxonomy
function register_faq_playground_category() {

    $labels = array(
        'name'                       => _x( 'FAQ Categories', 'Taxonomy General Name', 'sanatio' ),
        'singular_name'              => _x( 'FAQ Category', 'Taxonomy Singular Name', 'sanatio' ),
        'menu_name'                  => __( 'FAQ Category', 'sanatio' ),
        'all_items'                  => __( 'All Categories', 'sanatio' ),
        'parent_item'                => __( 'Parent Item', 'sanatio' ),
        'parent_item_colon'          => __( 'Parent Item:', 'sanatio' ),
        'new_item_name'              => __( 'New Item Name', 'sanatio' ),
        'add_new_item'               => __( 'Add New Item', 'sanatio' ),
        'edit_item'                  => __( 'Edit Item', 'sanatio' ),
        'update_item'                => __( 'Update Item', 'sanatio' ),
        'view_item'                  => __( 'View Item', 'sanatio' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'sanatio' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'sanatio' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'sanatio' ),
        'popular_items'              => __( 'Popular Items', 'sanatio' ),
        'search_items'               => __( 'Search Items', 'sanatio' ),
        'not_found'                  => __( 'Not Found', 'sanatio' ),
        'no_terms'                   => __( 'No items', 'sanatio' ),
        'items_list'                 => __( 'Items list', 'sanatio' ),
        'items_list_navigation'      => __( 'Items list navigation', 'sanatio' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => false,
        'show_ui'                    => true,
        'has_archive'                => false,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'rewrite'                    => false,


    );
    register_taxonomy( 'faq_category', array( 'faq' ), $args );

}
add_action( 'init', 'register_faq_playground_category', 0 );

