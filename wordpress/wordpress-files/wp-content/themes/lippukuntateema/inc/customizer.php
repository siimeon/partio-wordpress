<?php
/**
 * Customizer additions
 */

function lippukuntateema_customizer_settings($wp_customize) {
  $wp_customize->remove_section('static_front_page');
  $wp_customize->add_section('lippukuntateema_front', array(
    'title' => 'Etusivun asetukset',
    'description' => '',
    'priority' => 120,
  ));
  $wp_customize->add_setting('lippukuntateema_boxes_title', array('default' => 'Hyppää mukaan elämäsi seikkailuun'));
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'lippukuntateema_boxes_title',
  array(
    'label' => 'Nostojen otsikko',
    'section' => 'lippukuntateema_front',
    'settings' => 'lippukuntateema_boxes_title',
  )));
  $wp_customize->add_setting('lippukuntateema_news_title', array('default' => 'Ajankohtaista'));
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'lippukuntateema_news_title',
  array(
    'label' => 'Ajankohtaisten otsikko',
    'section' => 'lippukuntateema_front',
    'settings' => 'lippukuntateema_news_title',
  )));
  $wp_customize->add_setting('lippukuntateema_social_title', array('default' => 'Löydät meidät sosiaalisesta mediasta'));
  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'lippukuntateema_social_title',
  array(
    'label' => 'Sosiaalinen media otsikko',
    'section' => 'lippukuntateema_front',
    'settings' => 'lippukuntateema_social_title',
  )));

  $wp_customize->add_setting('header_textcolor', array('default' => '#253765'));
  $wp_customize->add_setting('lippukuntateema_brand_primary', array('default' => '#253765'));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'lippukuntateema_brand_primary', array(
    'label' => 'Ensisijainen teemaväri',
    'section' => 'colors',
    'settings' => 'lippukuntateema_brand_primary',
  )));
  $wp_customize->add_setting('lippukuntateema_brand_secondary', array('default' => '#28a9e1'));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'lippukuntateema_brand_secondary', array(
    'label' => 'Toissijainen teemaväri',
    'section' => 'colors',
    'settings' => 'lippukuntateema_brand_secondary',
  )));
}
add_action('customize_register', 'lippukuntateema_customizer_settings');

function lippuuntateema_customize_css() {
  ?>
    <style>
      h1,
      h2,
      h3,
      h4 {
        color: <?php echo get_theme_mod('lippukuntateema_brand_primary', '#253765'); ?>;
      }
      a {
        color: <?php echo get_theme_mod('lippukuntateema_brand_secondary', '#28a9e1'); ?>;
      }
      .site-header,
      .site-branding {
        background-color: <?php echo get_theme_mod('lippukuntateema_brand_primary', '#253765'); ?>;
      }
      .site-hero .site-hero-content h1,
      .site-hero .site-hero-content p {
        color: #<?php echo get_theme_mod('header_textcolor', '253765'); ?>;
      }
      .site-latest {
        background-color: <?php echo get_theme_mod('lippukuntateema_brand_secondary', '#28a9e1'); ?>;
      }
      .site-footer {
        border-top-color: <?php echo get_theme_mod('lippukuntateema_brand_secondary', '#28a9e1'); ?>;
        background-color: <?php echo get_theme_mod('lippukuntateema_brand_primary', '#253765'); ?>;
      }
      .menu-toggle {
        background-color: <?php echo get_theme_mod('lippukuntateema_brand_secondary', '#28a9e1'); ?>;
      }
      .button {
        background-color: <?php echo get_theme_mod('lippukuntateema_brand_primary', '#253765'); ?>;
      }
      .entry-footer .read-more {
        color: <?php echo get_theme_mod('lippukuntateema_brand_primary', '#253765'); ?>;
      }
      #primary-menu > li.current-menu-item,
      #primary-menu > li.current_page_item,
      #primary-menu > li:hover,
      #primary-menu > li > ul,
      #primary-menu > li > ul > li:hover,
      .blog #primary-menu > li.latest,
      .single-post #primary-menu > li.latest,
      .single-event #primary-menu > li.events {
        background-color: <?php echo get_theme_mod('lippukuntateema_brand_secondary', '#28a9e1'); ?>;
      }
    </style>
  <?php
}
add_action('wp_head', 'lippuuntateema_customize_css');
