<?php


/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function lippukuntateema_register_event_metabox() {
  $prefix = 'lippukuntateema_event_';
  $cmb_demo = new_cmb2_box( array(
    'id' => $prefix . 'metabox',
    'title' => 'Tapahtuman tiedot',
    'object_types' => array('event'),
    'context' => 'side',
    'priority' => 'core',
  ));
  $cmb_demo->add_field( array(
    'name' => 'Tapahtumapaikka',
    'id' => $prefix . 'location',
    'type' => 'text_medium',
    'attributes' => array(
      'required' => 'required',
    ),
  ));
  $cmb_demo->add_field( array(
    'name' => 'Tapahtuma alkaa',
    'id' => $prefix . 'date_start',
    'type' => 'text_date_timestamp',
    'date_format' => 'd.m.Y',
    'attributes' => array(
      'required' => 'required',
      'data-datepicker' => json_encode(array(
        'firstDay' => 1,
      )),
    ),
  ));
  $cmb_demo->add_field( array(
    'name' => 'Tapahtuma loppuu',
    'id' => $prefix . 'date_end',
    'type' => 'text_date_timestamp',
    'date_format' => 'd.m.Y',
    'attributes' => array(
      'data-datepicker' => json_encode(array(
        'firstDay' => 1,
      )),
    ),
  ));
}
add_action('cmb2_admin_init', 'lippukuntateema_register_event_metabox');

/**
 * CMB2 Theme Options
 * @version 0.1.0
 */
class Lippukuntateema_Admin {

  /**
    * Option key, and option page slug
    * @var string
    */
  protected $key = 'lippukuntateema_options';

  /**
    * Options page metabox id
    * @var string
    */
  protected $metabox_id = 'lippukuntateema_option_metabox';

  /**
   * Options Page title
   * @var string
   */
  protected $title = '';

  /**
   * Options Page hook
   * @var string
   */
  protected $options_page = '';

  /**
   * Holds an instance of the object
   *
   * @var Lippukuntateema_Admin
   */
  protected static $instance = null;

  /**
   * Returns the running object
   *
   * @return Lippukuntateema_Admin
   */
  public static function get_instance() {
    if ( null === self::$instance ) {
      self::$instance = new self();
      self::$instance->hooks();
    }

    return self::$instance;
  }

  /**
   * Constructor
   * @since 0.1.0
   */
  protected function __construct() {
    $this->title = 'Some-syötteet';
  }

  /**
   * Initiate our hooks
   * @since 0.1.0
   */
  public function hooks() {
    add_action('admin_init', array( $this, 'init'));
    add_action('admin_menu', array( $this, 'add_options_page'));
    add_action('cmb2_admin_init', array( $this, 'add_options_page_metabox'));
  }

  /**
   * Register our setting to WP
   * @since  0.1.0
   */
  public function init() {
    register_setting( $this->key, $this->key );
  }

  /**
   * Add menu options page
   * @since 0.1.0
   */
  public function add_options_page() {
    $this->options_page = add_menu_page( $this->title, $this->title, 'manage_options', $this->key, array( $this, 'admin_page_display' ) );
    add_action("admin_print_styles-{$this->options_page}", array('CMB2_hookup', 'enqueue_cmb_css'));
  }

  /**
   * Admin page markup. Mostly handled by CMB2
   * @since  0.1.0
   */
  public function admin_page_display() {
    ?>
    <div class="wrap cmb2-options-page <?php echo $this->key; ?>">
      <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
      <p>Syötä alla oleviin kenttiin palvelukohtaiset tunniste- ja käyttäjätiedot ohjeistuksen mukaan.<br>
         Syöte näytetään etusivulla, kun kaikki tiedot on tallennettu kenttiin.</p>
      <h4>Facebook</h4>
      <ul>
        <li>Hae Facebook-sivun ID osoitteesta <a target="_blank" href="https://findmyfbid.com">https://findmyfbid.com</a> (Partiolaisten sivun ID on 66765173461).</li>
        <li>Kirjaudu Facebook-tilille osoitteessa <a target="_blank" href="https://developers.facebook.com">https://developers.facebook.com</a> ja luo uusi applikaatio.</li>
        <li>Syötä tunnistetieto kenttään muodossa AppID|AppSecret.</li>
      </ul>
      <h4>Twitter</h4>
      <ul>
        <li>Kirjaudu Twitter-tilille osoitteessa <a target="_blank" href="https://apps.twitter.com">https://apps.twitter.com</a> ja luo uusi applikaatio.</li>
        <li>Hae applikaation 'Keys and Access Tokens' välilehdeltä kaikki tarvittavat tiedot.</li>
      </ul>
      <h4>Instagram</h4>
      <ul>
        <li>Kirjaudu Instagram-tilille osoitteessa <a target="_blank" href="https://www.instagram.com/developer/clients/register">https://www.instagram.com/developer/clients/register</a> ja luo uusi applikaatio.</li>
        <li>Hae uusi tunniste käyttäen Client ID tietoa, päivitä se ja sivuston osoite suoraan URL-osoitteeseen <a target="_blank" href="https://api.instagram.com/oauth/authorize/?client_id=CLIENT-ID&redirect_uri=REDIRECT-URI&response_type=token">https://api.instagram.com/oauth/authorize/?client_id=CLIENT-ID&redirect_uri=REDIRECT-URI&response_type=token</a>. CLIENT-ID korvataan applikaation Client ID tiedolla ja REDIRECT-URI korvataan sivuston osoitteella.</li>
        <li>Tunniste (Access Token) palautetaan selaimen osoiteriville.</li>
      </ul>
      <?php cmb2_metabox_form($this->metabox_id, $this->key); ?>
    </div>
    <?php
  }

  /**
   * Add the options metabox to the array of metaboxes
   * @since  0.1.0
   */
  function add_options_page_metabox() {

    // hook in our save notices
    add_action("cmb2_save_options-page_fields_{$this->metabox_id}", array($this, 'settings_notices'), 10, 2);

    $cmb = new_cmb2_box(array(
      'id' => $this->metabox_id,
      'hookup' => false,
      'cmb_styles' => false,
      'show_on' => array(
        'key' => 'options-page',
        'value' => array($this->key,)
      ),
    ));

    $cmb->add_field( array(
      'name' => __('Facebook Page ID', 'lippukuntateema'),
      'desc' => '',
      'id' => 'lippukuntateema_fb_page_id',
      'type' => 'text',
      'default' => '',
    ));

    $cmb->add_field( array(
      'name' => __('Facebook Access Token', 'lippukuntateema'),
      'desc' => '',
      'id' => 'lippukuntateema_fb_access_token',
      'type' => 'text',
      'default' => '',
    ));

    $cmb->add_field( array(
      'name' => __('Twitter username', 'lippukuntateema'),
      'desc' => '',
      'id' => 'lippukuntateema_twitter_username',
      'type' => 'text',
      'default' => '',
    ));

    $cmb->add_field( array(
      'name' => __('Twitter consumer key', 'lippukuntateema'),
      'desc' => '',
      'id' => 'lippukuntateema_twitter_consumer_key',
      'type' => 'text',
      'default' => '',
    ));

    $cmb->add_field( array(
      'name' => __('Twitter consumer secret', 'lippukuntateema'),
      'desc' => '',
      'id' => 'lippukuntateema_twitter_consumer_secret',
      'type' => 'text',
      'default' => '',
    ));

    $cmb->add_field( array(
      'name' => __('Twitter access token', 'lippukuntateema'),
      'desc' => '',
      'id' => 'lippukuntateema_twitter_access_token',
      'type' => 'text',
      'default' => '',
    ));

    $cmb->add_field( array(
      'name' => __('Twitter access token secret', 'lippukuntateema'),
      'desc' => '',
      'id' => 'lippukuntateema_twitter_access_token_secret',
      'type' => 'text',
      'default' => '',
    ));

    $cmb->add_field( array(
      'name' => __('Instagram user ID', 'lippukuntateema'),
      'desc' => '',
      'id' => 'lippukuntateema_ig_user_id',
      'type' => 'text',
      'default' => '',
    ));

    $cmb->add_field( array(
      'name' => __('Instagram access token', 'lippukuntateema'),
      'desc' => '',
      'id' => 'lippukuntateema_ig_access_token',
      'type' => 'text',
      'default' => '',
    ));

  }

  /**
   * Register settings notices for display
   *
   * @since  0.1.0
   * @param  int   $object_id Option key
   * @param  array $updated   Array of updated fields
   * @return void
   */
  public function settings_notices($object_id, $updated) {
    if ($object_id !== $this->key || empty($updated)) {
      return;
    }

    add_settings_error($this->key . '-notices', '', __('Settings updated.', 'lippukuntateema' ), 'updated');
    settings_errors($this->key . '-notices');
  }

  /**
   * Public getter method for retrieving protected/private variables
   * @since  0.1.0
   * @param  string  $field Field to retrieve
   * @return mixed          Field value or exception is thrown
   */
  public function __get( $field ) {
    // Allowed fields to retrieve
    if ( in_array( $field, array( 'key', 'metabox_id', 'title', 'options_page' ), true ) ) {
      return $this->{$field};
    }

    throw new Exception( 'Invalid property: ' . $field );
  }
}

/**
 * Helper function to get/return the Lippukuntateema_Admin object
 * @since  0.1.0
 * @return lippukuntateema_Admin object
 */
function lippukuntateema_admin() {
  return Lippukuntateema_Admin::get_instance();
}

/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 * @param  string $key     Options array key
 * @param  mixed  $default Optional default value
 * @return mixed           Option value
 */
 function lippukuntateema_get_option($key = '', $default = false) {
   if ( function_exists( 'cmb2_get_option' ) ) {
     return cmb2_get_option( lippukuntateema_admin()->key, $key, $default );
   }
   $opts = get_option( lippukuntateema_admin()->key, $default );
   $val = $default;
   if ( 'all' == $key ) {
     $val = $opts;
   } elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
     $val = $opts[ $key ];
   }
   return $val;
 }

lippukuntateema_admin();
