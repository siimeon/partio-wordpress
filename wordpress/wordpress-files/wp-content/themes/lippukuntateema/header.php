<?php
/**
 * Header
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="site">
  <a class="skip-to-content screen-reader-text" href="#main"><?php pll_e( 'Siirry sisältöön', 'lippukuntateema' ); ?></a>
  <header id="masthead" class="site-header" role="banner">
    <div class="container">
      <div class="site-branding">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
          <?php if(has_custom_logo()): ?>
            <?php
              $custom_logo_id = get_theme_mod('custom_logo' );
              $image = wp_get_attachment_image_src($custom_logo_id , 'full');
            ?>
            <img src="<?php echo $image[0]; ?>" alt="">
          <?php else: ?>
            <img src="<?php echo get_template_directory_uri() . '/dist/images/huivi_500.png'; ?>" alt="">
          <?php endif; ?>
        </a>
      </div><!-- .site-branding -->
      <nav id="site-navigation" class="main-navigation" role="navigation">
        <?php lippukuntateema_menu_toggle_btn('menu-toggle'); ?>
        <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
      </nav><!-- #site-navigation -->
    </div>
  </header><!-- #masthead -->

  <div id="content" class="site-content">
