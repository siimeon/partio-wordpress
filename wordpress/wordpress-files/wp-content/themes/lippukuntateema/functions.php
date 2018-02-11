<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

// update theme through wp-updates.com
require_once('wp-updates-theme.php');
new WPUpdatesThemeUpdater_2068('http://wp-updates.com/api/2/theme', basename(get_template_directory()));

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */

function lippukuntateema_setup() {
  add_theme_support('post-thumbnails');
  add_image_size('header', 1900, 800, true);
  add_image_size('box', 370, 260, true);
  add_theme_support('automatic-feed-links');
  add_theme_support('title-tag');
  add_theme_support('custom-logo');
  add_theme_support('custom-header', array('width' => 1900, 'height' => 800, 'default-image' => get_template_directory_uri() . '/dist/images/default-header.jpg'));

  register_nav_menus(array(
    'primary' => 'Päävalikko',
    'social' => 'Sosiaalinen media'
 ));

  add_theme_support('html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
 ));
}
add_action('after_setup_theme', 'lippukuntateema_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * @global int $content_width
 */

function lippukuntateema_content_width() {
  $GLOBALS['content_width'] = apply_filters('lippukuntateema_content_width', 640);
}
add_action('after_setup_theme', 'lippukuntateema_content_width', 0);

/**
 * Register widget area.
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

function lippukuntateema_widgets_init() {
  register_sidebar(array(
    'name'          => 'Etusivun nosto 1',
    'id'            => 'sidebar-box1',
    'description'   => '',
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ));
  register_sidebar(array(
    'name'          => 'Etusivun nosto 2',
    'id'            => 'sidebar-box2',
    'description'   => '',
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ));
  register_sidebar(array(
    'name'          => 'Etusivun nosto 3',
    'id'            => 'sidebar-box3',
    'description'   => '',
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ));
  register_sidebar(array(
    'name'          => 'Sivupalkki',
    'id'            => 'sidebar-side',
    'description'   => '',
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ));
  register_sidebar(array(
    'name'          => 'Alatunniste',
    'id'            => 'sidebar-footer',
    'description'   => '',
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ));
}
add_action('widgets_init', 'lippukuntateema_widgets_init');

/**
 * TinyMCE formats
 *
 * @link https://codex.wordpress.org/TinyMCE_Custom_Styles
 */

function lippukuntateema_tinymce_formats($init) {
  $init['block_formats'] = "Paragraph=p; Alaotsikko 2=h2; Alaotsikko 3=h3; Alaotsikko 4=h4";
  return $init;
}
add_filter('tiny_mce_before_init', 'lippukuntateema_tinymce_formats');

/**
 * Enqueue scripts and styles.
 */

function lippukuntateema_scripts() {
  wp_enqueue_style('lippukuntateema-style', get_template_directory_uri() . '/dist/styles/main.css', false, null);
  wp_enqueue_script('lippukuntateema-js', get_template_directory_uri() . '/dist/scripts/main.js', array('jquery'), null, true);

  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}
add_action('wp_enqueue_scripts', 'lippukuntateema_scripts');

/**
 * Enqueue scripts and styles for admin.
 */

function lippukuntateema_admin_scripts() {
  wp_enqueue_style('lippukuntateema_admin_css', get_template_directory_uri() . '/dist/styles/admin.css', false, null);
}
add_action('admin_enqueue_scripts', 'lippukuntateema_admin_scripts');

/**
 * Enqueue scripts and styles for TinyMCE
 */

function lippukuntateema_tinymce_styles() {
  add_editor_style('dist/styles/editor.css');
}
add_action('admin_init', 'lippukuntateema_tinymce_styles');

/**
 * Append to <head>
 */

function lippukuntateema_append_to_head() {
  // Detect JS – replace class no-js with js in html tag
  echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action('wp_head', 'lippukuntateema_append_to_head');

/**
 * Caret to dropdowns
 */

function lippukuntateema_dropdown_icon_to_menu_links($item_output, $item, $depth, $args) {
  if ($args->theme_location == 'primary') {
    foreach ($item->classes as $value) {
      if ($value == 'menu-item-has-children') {
        return $item_output . lippukuntateema_get_svg('caret-down');
      }
    }
  }
  return $item_output;
}
add_filter('walker_nav_menu_start_el', 'lippukuntateema_dropdown_icon_to_menu_links', 10, 4);

/**
 * Make tweet links clickable
 */
function lippukuntateema_linkify_tweet($tweet) {
  $tweet = preg_replace('/([\w]+\:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/', '<a target="_blank" href="$1">$1</a>', $tweet);
  $tweet = preg_replace('/#([A-Öa-z0-9\/\.]*)/', '<a target="_blank" href="https://www.twitter.com/search?q=$1">#$1</a>', $tweet);
  $tweet = preg_replace('/@([A-Öa-z0-9\/\.]*)/', '<a href="https://www.twitter.com/$1">@$1</a>', $tweet);
  return $tweet;
}

/**
 * Make instagram description clickable
 */
function lippukuntateema_linkify_instagram($item) {
  $item = preg_replace('/#([A-Öa-z0-9\/\.]*)/', '<a target="_blank" href="https://www.instagram.com/explore/tags/$1">#$1</a>', $item);
  $item = preg_replace('/@([A-Öa-z0-9\/\.]*)/', '<a href="https://www.instagram.com/$1">@$1</a>', $item);
  return $item;
}

/**
 * Include files
 */
require_once 'inc/template-tags.php';      // Template tags
require_once 'inc/polylang.php';           // Polylang strings and fallbacks
require_once 'inc/wp-settings.php';        // WP Settings
require_once 'inc/remove-commenting.php';  // Remove commenting
require_once 'inc/wp-login.php';           // Login screen
require_once 'inc/cpt.php';                // Custom post types
require_once 'inc/cmb2.php';               // Custom fields
require_once 'inc/customizer.php';         // Customizer additions
require_once 'inc/setup.php';              // Theme setup
