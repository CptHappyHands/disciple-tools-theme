<?php
/**
 * DMM CRM setup of custom post types 
 *
 * @contacts
 * @groups
 * @places
 * @updates
 * @prayer
 *
 * @package dmmcrm
 */

	
if ( ! defined( 'ABSPATH' ) ) exit;

/*
*
* POST TYPE CONTACTS
*/

// Register Custom Post Type
function contacts_post_type() {

	$labels = array(
		'name'                  => _x( 'Contacts', 'Post Type General Name', 'dmmcrm' ),
		'singular_name'         => _x( 'Contact', 'Post Type Singular Name', 'dmmcrm' ),
		'menu_name'             => __( 'Contacts', 'dmmcrm' ),
		'name_admin_bar'        => __( 'Contacts', 'dmmcrm' ),
		'archives'              => __( 'Contact Archives', 'dmmcrm' ),
		'attributes'            => __( 'Contact Attributes', 'dmmcrm' ),
		'parent_item_colon'     => __( 'Parent Contact:', 'dmmcrm' ),
		'all_items'             => __( 'All Contacts', 'dmmcrm' ),
		'add_new_item'          => __( 'Add New Contact', 'dmmcrm' ),
		'add_new'               => __( 'Add New', 'dmmcrm' ),
		'new_item'              => __( 'New Contact', 'dmmcrm' ),
		'edit_item'             => __( 'Edit Contact', 'dmmcrm' ),
		'update_item'           => __( 'Update Contact', 'dmmcrm' ),
		'view_item'             => __( 'View Contact', 'dmmcrm' ),
		'view_items'            => __( 'View Contacts', 'dmmcrm' ),
		'search_items'          => __( 'Search Contact', 'dmmcrm' ),
		'not_found'             => __( 'Not found', 'dmmcrm' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'dmmcrm' ),
		'featured_image'        => __( 'Featured Image', 'dmmcrm' ),
		'set_featured_image'    => __( 'Set featured image', 'dmmcrm' ),
		'remove_featured_image' => __( 'Remove featured image', 'dmmcrm' ),
		'use_featured_image'    => __( 'Use as featured image', 'dmmcrm' ),
		'insert_into_item'      => __( 'Insert into item', 'dmmcrm' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'dmmcrm' ),
		'items_list'            => __( 'Contacts list', 'dmmcrm' ),
		'items_list_navigation' => __( 'Contacts list navigation', 'dmmcrm' ),
		'filter_items_list'     => __( 'Filter contacts list', 'dmmcrm' ),
	);
	$rewrite = array(
		'slug'                  => 'contact',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => false,
	);
	$args = array(
		'label'                 => __( 'Contact', 'dmmcrm' ),
		'description'           => __( 'Contacts generated by the media to movement effort', 'dmmcrm' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
		'taxonomies'            => array( 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-admin-users',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,		
		'exclude_from_search'   => true,
		'publicly_queryable'    => false,
		'rewrite'               => $rewrite,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'rest_base'             => 'contacts',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	);
	register_post_type( 'dmm_contacts', $args );

}
add_action( 'init', 'contacts_post_type', 0 );
 
 
// Register Custom Post Type
function groups_post_type() {

	$labels = array(
		'name'                  => _x( 'Groups', 'Post Type General Name', 'dmmcrm' ),
		'singular_name'         => _x( 'Group', 'Post Type Singular Name', 'dmmcrm' ),
		'menu_name'             => __( 'Groups', 'dmmcrm' ),
		'name_admin_bar'        => __( 'Group', 'dmmcrm' ),
		'archives'              => __( 'Group Archives', 'dmmcrm' ),
		'attributes'            => __( 'Group Attributes', 'dmmcrm' ),
		'parent_item_colon'     => __( 'Parent Group:', 'dmmcrm' ),
		'all_items'             => __( 'All Groups', 'dmmcrm' ),
		'add_new_item'          => __( 'Add New Group', 'dmmcrm' ),
		'add_new'               => __( 'Add Group', 'dmmcrm' ),
		'new_item'              => __( 'New Group', 'dmmcrm' ),
		'edit_item'             => __( 'Edit Group', 'dmmcrm' ),
		'update_item'           => __( 'Update Group', 'dmmcrm' ),
		'view_item'             => __( 'View Group', 'dmmcrm' ),
		'view_items'            => __( 'View Groups', 'dmmcrm' ),
		'search_items'          => __( 'Search Group', 'dmmcrm' ),
		'not_found'             => __( 'Not found', 'dmmcrm' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'dmmcrm' ),
		'featured_image'        => __( 'Featured Image', 'dmmcrm' ),
		'set_featured_image'    => __( 'Set featured image', 'dmmcrm' ),
		'remove_featured_image' => __( 'Remove featured image', 'dmmcrm' ),
		'use_featured_image'    => __( 'Use as featured image', 'dmmcrm' ),
		'insert_into_item'      => __( 'Insert into item', 'dmmcrm' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'dmmcrm' ),
		'items_list'            => __( 'Items list', 'dmmcrm' ),
		'items_list_navigation' => __( 'Items list navigation', 'dmmcrm' ),
		'filter_items_list'     => __( 'Filter items list', 'dmmcrm' ),
	);
	$args = array(
		'label'                 => __( 'Group', 'dmmcrm' ),
		'description'           => __( 'These are 3/3 groups and simple churches', 'dmmcrm' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'excerpt', 'thumbnail', 'comments', ),
		'taxonomies'            => array( 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-admin-multisite',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,		
		'exclude_from_search'   => true,
		'publicly_queryable'    => false,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'rest_base'             => 'groups',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	);
	register_post_type( 'dmm_groups', $args );

}
add_action( 'init', 'groups_post_type', 0 );


// Register Custom Post Type
function places_post_type() {

	$labels = array(
		'name'                  => _x( 'Places', 'Post Type General Name', 'dmmcrm' ),
		'singular_name'         => _x( 'Place', 'Post Type Singular Name', 'dmmcrm' ),
		'menu_name'             => __( 'Places', 'dmmcrm' ),
		'name_admin_bar'        => __( 'Place', 'dmmcrm' ),
		'archives'              => __( 'Place Archives', 'dmmcrm' ),
		'attributes'            => __( 'Place Attributes', 'dmmcrm' ),
		'parent_item_colon'     => __( 'Parent Place:', 'dmmcrm' ),
		'all_items'             => __( 'All Places', 'dmmcrm' ),
		'add_new_item'          => __( 'Add New Place', 'dmmcrm' ),
		'add_new'               => __( 'Add New', 'dmmcrm' ),
		'new_item'              => __( 'New Place', 'dmmcrm' ),
		'edit_item'             => __( 'Edit Place', 'dmmcrm' ),
		'update_item'           => __( 'Update Place', 'dmmcrm' ),
		'view_item'             => __( 'View Place', 'dmmcrm' ),
		'view_items'            => __( 'View Places', 'dmmcrm' ),
		'search_items'          => __( 'Search Place', 'dmmcrm' ),
		'not_found'             => __( 'Not found', 'dmmcrm' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'dmmcrm' ),
		'featured_image'        => __( 'Featured Image', 'dmmcrm' ),
		'set_featured_image'    => __( 'Set featured image', 'dmmcrm' ),
		'remove_featured_image' => __( 'Remove featured image', 'dmmcrm' ),
		'use_featured_image'    => __( 'Use as featured image', 'dmmcrm' ),
		'insert_into_item'      => __( 'Insert into place', 'dmmcrm' ),
		'uploaded_to_this_item' => __( 'Uploaded to this place', 'dmmcrm' ),
		'items_list'            => __( 'Places list', 'dmmcrm' ),
		'items_list_navigation' => __( 'Places list navigation', 'dmmcrm' ),
		'filter_items_list'     => __( 'Filter places list', 'dmmcrm' ),
	);
	$args = array(
		'label'                 => __( 'Place', 'dmmcrm' ),
		'description'           => __( 'All places posts include location data', 'dmmcrm' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'comments', ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-location',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'rest_base'             => 'places',
		'rest_controller_class' => 'WP_REST_Places_Controller',
	);
	register_post_type( 'places_post_type', $args );

}
add_action( 'init', 'places_post_type', 0 );


// Register Custom Post Type
function update_post_type() {

	$labels = array(
		'name'                  => _x( 'Updates', 'Post Type General Name', 'dmmcrm' ),
		'singular_name'         => _x( 'Update', 'Post Type Singular Name', 'dmmcrm' ),
		'menu_name'             => __( 'Updates', 'dmmcrm' ),
		'name_admin_bar'        => __( 'Update', 'dmmcrm' ),
		'archives'              => __( 'Update Archives', 'dmmcrm' ),
		'attributes'            => __( 'Update Attributes', 'dmmcrm' ),
		'parent_item_colon'     => __( 'Parent Update:', 'dmmcrm' ),
		'all_items'             => __( 'All Updates', 'dmmcrm' ),
		'add_new_item'          => __( 'Add New Update', 'dmmcrm' ),
		'add_new'               => __( 'Add New', 'dmmcrm' ),
		'new_item'              => __( 'New Update', 'dmmcrm' ),
		'edit_item'             => __( 'Edit Update', 'dmmcrm' ),
		'update_item'           => __( 'Update \"Update\"', 'dmmcrm' ),
		'view_item'             => __( 'View Update', 'dmmcrm' ),
		'view_items'            => __( 'View Updates', 'dmmcrm' ),
		'search_items'          => __( 'Search Update', 'dmmcrm' ),
		'not_found'             => __( 'Not found', 'dmmcrm' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'dmmcrm' ),
		'featured_image'        => __( 'Featured Image', 'dmmcrm' ),
		'set_featured_image'    => __( 'Set featured image', 'dmmcrm' ),
		'remove_featured_image' => __( 'Remove featured image', 'dmmcrm' ),
		'use_featured_image'    => __( 'Use as featured image', 'dmmcrm' ),
		'insert_into_item'      => __( 'Insert into update', 'dmmcrm' ),
		'uploaded_to_this_item' => __( 'Uploaded to this update', 'dmmcrm' ),
		'items_list'            => __( 'Updates list', 'dmmcrm' ),
		'items_list_navigation' => __( 'Updates list navigation', 'dmmcrm' ),
		'filter_items_list'     => __( 'Filter updates list', 'dmmcrm' ),
	);
	$args = array(
		'label'                 => __( 'Update', 'dmmcrm' ),
		'description'           => __( 'DMM project updates for project supporters', 'dmmcrm' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'post-formats', ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-book-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'rest_base'             => 'updates',
		'rest_controller_class' => 'WP_REST_Updates_Controller',
	);
	register_post_type( 'dmm_update', $args );

}
add_action( 'init', 'update_post_type', 0 );


// Modify the default "Post" type to be called Prayer
function dmmcrm_change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Prayer';
    $submenu['edit.php'][5][0] = 'Prayers';
    $submenu['edit.php'][10][0] = 'Add Prayers';
    $submenu['edit.php'][16][0] = 'Prayers Tags';
}
function dmmcrm_change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Prayers';
    $labels->singular_name = 'Prayer';
    $labels->add_new = 'Add Prayers';
    $labels->add_new_item = 'Add Prayers';
    $labels->edit_item = 'Edit Prayers';
    $labels->new_item = 'Prayer';
    $labels->view_item = 'View Prayers';
    $labels->search_items = 'Search Prayers';
    $labels->not_found = 'No Prayers found';
    $labels->not_found_in_trash = 'No Prayers found in Trash';
    $labels->all_items = 'All Prayers';
    $labels->menu_name = 'Prayers';
    $labels->name_admin_bar = 'Prayer';
}
 
add_action( 'admin_menu', 'dmmcrm_change_post_label' );
add_action( 'init', 'dmmcrm_change_post_object' );
 
 
 
 ?>