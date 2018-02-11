<?php
/**
 * Setup on theme activation
 */

// set theme options
function lippukuntateema_options() {
  // delete test comment
  // wp_delete_comment(1);

  // create blog page
  $latest_page = array(
    'post_type' => 'page',
    'post_title' => 'Ajankohtaiset',
    'post_content' => '',
    'post_status' => 'publish',
    'post_author' => 1,
    'post_slug' => 'ajankohtaiset'
  );
  wp_insert_post($latest_page);
  $latest = get_page_by_title('Ajankohtaiset');

  $option = array(
    'blogname' => 'Suomen Partiolaiset',
    'blogdescription' => 'Tule mukaan partioon!',
    'category_base' => '/kategoria',
    'tag_base' => '/avainsana',
    'default_comment_status' => 'closed',
    'use_trackback' => '',
    'default_ping_status' => 'closed',
    'default_pingback_flag' => '',
    'permalink_structure' => '/%year%/%monthnum%/%day%/%postname%/',
    'uploads_use_yearmonth_folders' => '',
    'use_smilies' => '',
    'show_on_front' => 'page',
    'page_on_front' => 2,
    'page_for_posts' => $latest->ID,
    'posts_per_page' => 5
  );
  foreach ($option as $key => $value ) {
    update_option($key, $value);
  }
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}
add_action('after_switch_theme', 'lippukuntateema_options');

// create menus
function lippukuntateema_menu_setup() {
  // get menu locations
  $locations = get_theme_mod('nav_menu_locations');

  // primary menu
  $primary_menu_name = 'Päävalikko';
  $primary_menu_name_location = 'primary';
  $primary_menu_exists = wp_get_nav_menu_object($primary_menu_name);
  if(!$primary_menu_exists) {
    $primary_menu_id = wp_create_nav_menu($primary_menu_name);

    wp_update_nav_menu_item($primary_menu_id, 0, array(
        'menu-item-title' =>  'Etusivu',
        'menu-item-classes' => 'home',
        'menu-item-url' => home_url('/'),
        'menu-item-status' => 'publish'));

    wp_update_nav_menu_item($primary_menu_id, 0, array(
        'menu-item-title' =>  'Ajankohtaiset',
        'menu-item-classes' => 'latest',
        'menu-item-url' => '/ajankohtaiset',
        'menu-item-status' => 'publish'));

    wp_update_nav_menu_item($primary_menu_id, 0, array(
        'menu-item-title' =>  'Tapahtumat',
        'menu-item-classes' => 'events',
        'menu-item-url' => '/tapahtumat',
        'menu-item-status' => 'publish'));

    if(!has_nav_menu($primary_menu_name_location)) {
      $locations[$primary_menu_name_location] = $primary_menu_id;
      set_theme_mod('nav_menu_locations', $locations);
    }
  }

  // social menu
  $social_menu_name = 'Sosiaalinen media';
  $social_menu_name_location = 'social';
  $social_menu_exists = wp_get_nav_menu_object($social_menu_name);
  if(!$social_menu_exists) {
    $social_menu_id = wp_create_nav_menu($social_menu_name);

    wp_update_nav_menu_item($social_menu_id, 0, array(
        'menu-item-title' =>  'Facebook',
        'menu-item-classes' => 'facebook',
        'menu-item-url' => 'https://www.facebook.com/partio',
        'menu-item-status' => 'publish'));

    wp_update_nav_menu_item($social_menu_id, 0, array(
        'menu-item-title' =>  'Instagram',
        'menu-item-classes' => 'instagram',
        'menu-item-url' => 'https://www.instagram.com/partioscout',
        'menu-item-status' => 'publish'));

    wp_update_nav_menu_item($social_menu_id, 0, array(
        'menu-item-title' =>  'Twitter',
        'menu-item-classes' => 'twitter',
        'menu-item-url' => 'https://twitter.com/Partiolaiset',
        'menu-item-status' => 'publish'));

    wp_update_nav_menu_item($social_menu_id, 0, array(
        'menu-item-title' =>  'Youtube',
        'menu-item-classes' => 'youtube',
        'menu-item-url' => 'https://www.youtube.com/user/partioscout',
        'menu-item-status' => 'publish'));

    wp_update_nav_menu_item($social_menu_id, 0, array(
        'menu-item-title' =>  'Snapchat',
        'menu-item-classes' => 'snapchat',
        'menu-item-url' => 'https://www.snapchat.com/add/partioscout',
        'menu-item-status' => 'publish'));

    if(!has_nav_menu($social_menu_name_location)) {
      $locations[$social_menu_name_location] = $social_menu_id;
    }
  }

  // set menu locations
  set_theme_mod('nav_menu_locations', $locations);
}
add_action('after_setup_theme', 'lippukuntateema_menu_setup');

// create widgets
class Widgets {
  private $widgets = array();
  private $options = array();
  public function __construct() {
    $this->options = wp_get_sidebars_widgets();
  }
  public function unregisterAllWidgets() {
    foreach ($this->options as $name => $values) {
      // if (strpos($name, 'dashboard') !== false) {
        $this->options[$name] = array();
      // }
    }
  }
  public function cleanWidgetSettings($type, $multi = null) {
    $this->widgets[$type] = array();
    if ($multi !== null) $this->widgets[$type]['_multiwidget'] = (int)(bool)$multi;
  }
  public function setMultiWidget($type, $val = 1) {
    $this->widgets[$type]['_multiwidget'] = $val;
  }
  public function add($type, array $options, $area = null) {
    $this->widgets[$type][] = $options;
    if ($area !== null) {
      if (array_key_exists($area, $this->options) === false) {
        throw new Exception('Widget area ' . $area . ' not exists.');
      }
      end($this->widgets[$type]);
      $this->options[$area][] = $type . '-' . key($this->widgets[$type]);
    }
  }
  public function __destruct() {
    foreach ($this->widgets as $name => $settings) {
      if (!array_key_exists('_multiwidget', $settings)) $settings['_multiwidget'] = 1;
      update_option('widget_' . $name, $settings);
    }
    wp_set_sidebars_widgets($this->options);
  }
}
function lippukuntateema_init_widgets() {
  $widgets = new Widgets();
  $widgets->unregisterAllWidgets();

  $widgets->add(
    'media_image',
    array(
      'title' => '',
      'url' => get_template_directory_uri() .'/dist/images/default-box1.jpg',
      'link_type' => 'custom',
      'link_url' => 'https://www.partio.fi/tule-mukaan'
    ),
    'sidebar-box1'
  );
  $widgets->add(
    'text',
    array(
      'title' => '',
      'text' => '<h2><a href="https://www.partio.fi/tule-mukaan">Liity partioon</a></h2>',
      'filter' => false,
      'classes' => '',
      'ids' => null,
    ),
    'sidebar-box1'
  );

  $widgets->add(
    'media_image',
    array(
      'title' => '',
      'url' => get_template_directory_uri() .'/dist/images/default-box2.jpg',
      'link_type' => 'custom',
      'link_url' => 'https://www.partio.fi/tule-mukaan/aikuisena-partioon'
    ),
    'sidebar-box2'
  );
  $widgets->add(
    'text',
    array(
      'title' => '',
      'text' => '<h2><a href="https://www.partio.fi/tule-mukaan/aikuisena-partioon">Aikuisena partioon</a></h2>',
      'filter' => false,
      'classes' => '',
      'ids' => null,
    ),
    'sidebar-box2'
  );

  $widgets->add(
    'media_image',
    array(
      'title' => '',
      'url' => get_template_directory_uri() .'/dist/images/default-box3.jpg',
      'link_type' => 'custom',
      'link_url' => '/tapahtumat',
      'classes' => '',
      'ids' => null,
    ),
    'sidebar-box3'
  );
  $widgets->add(
    'text',
    array(
      'title' => '',
      'text' => '<h2><a href="/tapahtumat">Tapahtumakalenteri</a></h2>',
      'filter' => false,
      'classes' => '',
      'ids' => null,
    ),
    'sidebar-box3'
  );

  $widgets->add(
    'text',
    array(
      'title' => 'Mukaan partioon',
      'text' => '<ul>
      <li><a href="https://www.partio.fi/tutustu-partioon/mita-partiossa-tehdaan">Mitä partiossa tehdään?</a></li>
      <li><a href="https://www.partio.fi/tule-mukaan">Mukaan lapsena tai nuorena</a></li>
      <li><a href="https://www.partio.fi/tule-mukaan/aikuisena-partioon">Mukaan aikuisena</a></li>
      </ul>',
      'filter' => false,
      'classes' => '',
      'ids' => null,
    ),
    'sidebar-footer'
  );
  $widgets->add(
    'text',
    array(
      'title' => 'Lippukuntalaisille',
      'text' => '<ul>
      <li><a href="#kokoontumisajat">Ryhmien kokoontumisajat</a></li>
      <li><a href="#toimintakalenteri">Toimintakalenteri</a></li>
      <li><a href="#ilmoittautuminen">Tapahtumiin ilmoittautuminen</a></li>
      <li><a href="#osallistumisohjeet">Osallistumis- ja peruutusohjeet</a></li>
      </ul>',
      'filter' => false,
      'classes' => '',
      'ids' => null,
    ),
    'sidebar-footer'
  );
  $widgets->add(
    'text',
    array(
      'title' => 'Hyödyllisiä linkkejä',
      'text' => '<ul>
      <li><a href="/tapahtumat">Piirin tapahtumakalenteri</a></li>
      <li><a href="http://partio.ohjelma.fi">partio-ohjelma.fi</a></li>
      </ul>',
      'filter' => false,
      'classes' => '',
      'ids' => null,
    ),
    'sidebar-footer'
  );
  $widgets->add(
    'text',
    array(
      'title' => 'Ota yhteyttä!',
      'text' => '<p>Lippukunnan nimi<br>
      Koulun tai kirkon tila<br>
      Lorem ipsumin katu 117<br
      15300 Kaupunki</p>
      <p>Lippukunnanjohtaja<br>
      0401234123</p>',
      'filter' => false,
      'classes' => '',
      'ids' => null,
    ),
    'sidebar-footer'
  );

  $widgets->add(
    'search',
    array(
      'title' => ''
    ),
    'sidebar-side'
  );
  $widgets->add(
    'archives',
    array(
      'title' => 'Uutisarkisto'
    ),
    'sidebar-side'
  );
}
add_action('after_switch_theme', 'lippukuntateema_init_widgets');


// facebook feed
function lippukuntateema_fb_access_token() {
  $fb_access_token = lippukuntateema_get_option('lippukuntateema_fb_access_token');
  return $fb_access_token;
}
add_filter('dude-facebook-feed/parameters/access_token', 'lippukuntateema_fb_access_token');

function lippukuntateema_fb_limit($parameters) {
  $parameters['limit'] = 3;
  return $parameters;
}
add_filter('dude-facebook-feed/api_call_parameters', 'lippukuntateema_fb_limit');

// twitter feed
function lippukuntateema_twitter_consumer_key() {
  $twitter_consumer_key = lippukuntateema_get_option('lippukuntateema_twitter_consumer_key');
  return $twitter_consumer_key;
}
add_filter('dude-twitter-feed/oauth_consumer_key', 'lippukuntateema_twitter_consumer_key');

function lippukuntateema_twitter_consumer_secret() {
  $twitter_consumer_secret = lippukuntateema_get_option('lippukuntateema_twitter_consumer_secret');
  return $twitter_consumer_secret;
}
add_filter('dude-twitter-feed/oauth_consumer_secret', 'lippukuntateema_twitter_consumer_secret');

function lippukuntateema_twitter_access_token() {
  $twitter_access_token = lippukuntateema_get_option('lippukuntateema_twitter_access_token');
  return $twitter_access_token;
}
add_filter('dude-twitter-feed/oauth_access_token', 'lippukuntateema_twitter_access_token');

function lippukuntateema_twitter_access_token_secret() {
  $twitter_access_token_secret = lippukuntateema_get_option('lippukuntateema_twitter_access_token_secret');
  return $twitter_access_token_secret;
}
add_filter('dude-twitter-feed/oauth_access_token_secret', 'lippukuntateema_twitter_access_token_secret');

function lippukuntateema_twitter_limit($parameters) {
  $parameters['count'] = 3;
  return $parameters;
}
add_filter('dude-twitter-feed/user_tweets_parameters', 'lippukuntateema_twitter_limit');

// instagram feed
function lippukuntateema_ig_user_id() {
  $ig_user_id = lippukuntateema_get_option('lippukuntateema_ig_user_id');
  return $ig_user_id;
}

function lippukuntateema_ig_access_token() {
  $ig_access_token = lippukuntateema_get_option('lippukuntateema_ig_access_token');
  return $ig_access_token;
}
add_filter('dude-insta-feed/access_token/user=' . lippukuntateema_ig_user_id(), 'lippukuntateema_ig_access_token');

function lippukuntateema_ig_limit($parameters) {
  $parameters['count'] = 3;
  return $parameters;
}
add_filter('dude-insta-feed/user_images_parameters', 'lippukuntateema_ig_limit');

function lippukuntateema_has_fb() {
  if(lippukuntateema_get_option('lippukuntateema_fb_page_id') &&
     lippukuntateema_get_option('lippukuntateema_fb_access_token')) {
    return true;
  } else {
    return false;
  }
}

function lippukuntateema_has_twitter() {
  if(lippukuntateema_get_option('lippukuntateema_twitter_username') &&
     lippukuntateema_get_option('lippukuntateema_twitter_consumer_key') &&
     lippukuntateema_get_option('lippukuntateema_twitter_consumer_secret') &&
     lippukuntateema_get_option('lippukuntateema_twitter_access_token') &&
     lippukuntateema_get_option('lippukuntateema_twitter_access_token_secret')) {
    return true;
  } else {
    return false;
  }
}

function lippukuntateema_has_ig() {
  if(lippukuntateema_get_option('lippukuntateema_ig_user_id') &&
     lippukuntateema_get_option('lippukuntateema_ig_access_token')) {
    return true;
  } else {
    return false;
  }
}


/**
 * Admin notices
 */
function lippukuntateema_admin_notices() { ?>
  <div class="notice notice-success is-dismissible">
    <p>Hei! Teema on nyt asennettu. Olemme asettaneet sinulle valmiiksi muutamia asioita.<br>
       Alla olevista linkeistä voit muokata teeman asetuksia.</p>
    <ul>
      <li><a href="<?php echo admin_url('post.php?post='. get_option('page_on_front') .'&action=edit'); ?>">Muokkaa etusivun sisältöä.</a></li>
      <li><a href="<?php echo admin_url('customize.php'); ?>">Muokkaa teeman asetuksia.</a></li>
      <li><a href="<?php echo admin_url('admin.php?page=lippukuntateema_options'); ?>">Muokkaa some-syötteiden tietoja.</a></li>
      <li><a href="<?php echo admin_url('admin.php?page=gadash_settings'); ?>">Asenna Google Analytics-seuranta.</a></li>
    </ul>
  </div>
<?php
}
add_action('admin_notices', 'lippukuntateema_admin_notices');


/**
 * Remove 'Archives:' from title
 */
function lippukuntateema_clean_archives_title($title) {
  global $post;
  if (is_category()) {
    $title = single_cat_title('', false);
  } elseif (is_tag()) {
    $title = single_tag_title('', false);
  } elseif (is_tax()) {
    $title = single_cat_title('', false);
  } elseif (is_post_type_archive()) {
    $title = post_type_archive_title('', false);
  } elseif (is_author()) {
    $title = '<span class="vcard">' . get_the_author() . '</span>';
  }
  return $title;
}
add_filter('get_the_archive_title', 'lippukuntateema_clean_archives_title');


/**
 * Translate front-end strings
 */
function lippukuntateema_ninja_forms_i18n_front_end($strings) {
  $strings['validateRequiredField'] = 'Tämä on pakollinen kenttä.';
  $strings['fieldsMarkedRequired'] = '<span class="ninja-forms-req-symbol">*</span> Tähdellä merkityt kentät ovat pakollisia.';
  $strings['formErrorsCorrectErrors'] = 'Korjaa merkityt virheet ennen lomakkeen lähettämistä.';
  return $strings;
}
add_filter('ninja_forms_i18n_front_end', 'lippukuntateema_ninja_forms_i18n_front_end');
