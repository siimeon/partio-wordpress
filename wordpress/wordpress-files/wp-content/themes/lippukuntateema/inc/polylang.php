<?php
/**
 * Polylang registered strings and fallback functions
 */

/**
 * String translations
 */

if(function_exists('pll_register_string')) :
  pll_register_string('Page not found', 'Hakemaasi sivua ei löytynyt', 'lippukuntateema');
  pll_register_string('Page not found description', 'Sivu on saatettu poistaa tai siirtää eri osoitteeseen. Käytä alla olevaa hakua löytääksesi etsimäsi.', 'lippukuntateema');
  pll_register_string('Nothing found', 'Ei hakutuloksia', 'lippukuntateema');
  pll_register_string('Nothing found description', 'Hakutuloksia ei löytynyt. Kokeile eri hakusanoja.', 'lippukuntateema');
  pll_register_string('Previous', 'Edellinen', 'lippukuntateema');
  pll_register_string('Next', 'Seuraava', 'lippukuntateema');
  pll_register_string('Search: ', 'Haku: ', 'lippukuntateema');
  pll_register_string('Share in social media', 'Jaa sosiaalisessa mediassa', 'lippukuntateema');
  pll_register_string('Keywords', 'Avainsanat', 'lippukuntateema');
  pll_register_string('Categories', 'Kategoriat', 'lippukuntateema');
  pll_register_string('Skip to content', 'Siirry sisältöön', 'lippukuntateema');
  pll_register_string('Social share: Facebook', 'Facebook', 'lippukuntateema');
  pll_register_string('Social share: Twitter', 'Twitter', 'lippukuntateema');
  pll_register_string('Social share: LinkedIn', 'LinkedIn', 'lippukuntateema');
  pll_register_string('Social share: Google+', 'Google+', 'lippukuntateema');
endif;

/**
 * Fallback Polylang (preserve functionality without the plugin)
 */

if ( ! function_exists('pll__') ) :
  function pll__($s) {
    return $s;
  }
  function pll_e($s) {
    echo $s;
  }
  function pll_current_language() {
    return 'fi';
  }
  function pll_get_post_language($id) {
    return 'fi';
  }
  function pll_get_post($post_id, $slug = '') {
    return $post_id;
  }
  function pll_get_term($term_id, $slug = '') {
    return $term_id;
  }
  function pll_translate_string($str, $lang = '') {
    return $str;
  }
  function pll_home_url($slug = '') {
    return get_home_url();
  }
endif;
