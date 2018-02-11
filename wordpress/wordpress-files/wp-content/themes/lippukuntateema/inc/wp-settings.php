<?php
/**
 * Tweaks for WordPress settings
 */

/*
  Contents
  ==================================
  01. Editor
  02. Admin
  03. Uploads
  04. Front-end
  05. Plugins
  ==================================
 */


/* =========================================================
  01. Editor
 ======================================================== */

// Show 2nd editor row by default

function lippukuntateema_show_second_editor_row( $tinymce ) {
  $tinymce[ 'wordpress_adv_hidden' ] = FALSE;
  return $tinymce;
}
add_filter( 'tiny_mce_before_init', 'lippukuntateema_show_second_editor_row' );

// Default gallery links to file, size to medium and columns to 2

function lippukuntateema_gallery_defaults( $settings ) {
  $settings['galleryDefaults']['link'] = 'file';
  $settings['galleryDefaults']['size'] = 'medium';
  $settings['galleryDefaults']['columns'] = '2';
  return $settings;
}
add_filter( 'media_view_settings', 'lippukuntateema_gallery_defaults');


/* =========================================================
  02. Admin
 ======================================================== */

// Remove update nags from non-admins

function lippukuntateema_remove_update_nags_for_non_admins() {
  if (!current_user_can('update_core')) {
    remove_action( 'admin_notices', 'update_nag', 3 );
  }
}
add_action( 'admin_head', 'lippukuntateema_remove_update_nags_for_non_admins', 1 );

// Remove admin color scheme picker

remove_all_actions( 'admin_color_scheme_picker' );

// Remove profile contact methods

function lippukuntateema_remove_contact_methods( $contact ) {
  unset( $contact['aim'] );
  unset( $contact['jabber'] );
  unset( $contact['yim'] );
  unset( $contact['googleplus'] );
  unset( $contact['twitter'] );
  unset( $contact['facebook'] );
  return $contact;
}
add_filter( 'user_contactmethods', 'lippukuntateema_remove_contact_methods', 10, 1 );

// Clean up admin menus for non-admins

function lippukuntateema_cleanup_admin_menu() {
  if ( ! current_user_can ( 'administrator' ) ) {
    //remove_menu_page('tools.php');
    remove_submenu_page( 'themes.php', 'themes.php' );
  }
}
add_action( 'admin_menu', 'lippukuntateema_cleanup_admin_menu', 9999 );

// Force default setting for image link to "none" (option is autoloaded so this makes no extra db queries)

function lippukuntateema_default_image_link_to_none() {
  if ( get_option( 'image_default_link_type' ) !== 'none' ) {
    update_option('image_default_link_type', 'none');
  }
}
add_action('admin_init', 'lippukuntateema_default_image_link_to_none', 10);

// Limit revision number

function lippukuntateema_limit_revisions( $number, $post_id ) {
  return 10;
}
add_filter( 'wp_revisions_to_keep', 'lippukuntateema_limit_revisions', 10, 2 );


/* =========================================================
  03. Front-end
 ======================================================== */

// Replace default excerpt dots

function lippukuntateema_excerpt_more( $more ) {
  return '...';
}
add_filter('excerpt_more', 'lippukuntateema_excerpt_more');

// Set custom excerpt length

function lippukuntateema_excerpt_length( $length ) {
  return 25;
}
add_filter( 'excerpt_length', 'lippukuntateema_excerpt_length', 999 );

/* =========================================================
  04. Dashboard
 ======================================================== */

function lippukuntateema_admin_dashboard() {
  remove_meta_box( 'dashboard_right_now',       'dashboard', 'normal' );
  remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_incoming_links',  'dashboard', 'normal' );
  remove_meta_box( 'dashboard_activity',        'dashboard', 'normal' );
  remove_meta_box( 'dashboard_plugins',         'dashboard', 'normal' );
  remove_meta_box( 'wpseo-dashboard-overview',  'dashboard', 'normal' );
  remove_meta_box( 'dashboard_quick_press',     'dashboard', 'side' );
  remove_meta_box( 'dashboard_recent_drafts',   'dashboard', 'side' );
  remove_meta_box( 'dashboard_primary',         'dashboard', 'side' );
  remove_meta_box( 'dashboard_secondary',       'dashboard', 'side' );
}
add_action('wp_dashboard_setup', 'lippukuntateema_admin_dashboard', 99);
remove_action('welcome_panel', 'wp_welcome_panel');


/* =========================================================
  05. Plugins
 ======================================================== */

// Lower Yoast metabox

add_filter( 'wpseo_metabox_prio', function(){ return 'low'; } );

// Remove Yoast notifications

function lippukuntateema_remove_wpseo_notifications() {

  if ( !class_exists( 'Yoast_Notification_Center' ) )
    return;

  remove_action( 'admin_notices', array( Yoast_Notification_Center::get(), 'display_notifications' ) );
  remove_action( 'all_admin_notices', array( Yoast_Notification_Center::get(), 'display_notifications' ) );

}
add_action( 'admin_init', 'lippukuntateema_remove_wpseo_notifications' );

// Remove "SEO" from admin bar

function lippukuntateema_yoast_admin_bar_render() {
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu('wpseo-menu');
}
add_action( 'wp_before_admin_bar_render', 'lippukuntateema_yoast_admin_bar_render' );

// Grant everybody that can publish pages (admin and editors) access to Redirection plugin

add_filter('redirection_role', function(){ return 'publish_pages'; });

// Reset Gravity Forms tabindex (a11y)

add_filter( 'gform_tabindex', '__return_false' );

// Hide ACF from non-administrator admin menu

function lippukuntateema_hide_acf_from_nonadmins( $show ) {
  return current_user_can('administrator');
}
add_filter('acf/settings/show_admin', 'lippukuntateema_hide_acf_from_nonadmins');
