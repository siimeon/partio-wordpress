<?php
/**
 * Custom template tags for this theme.
 */

/*
  Contents
  ==================================
  01. Get SVG
  02. Social share buttons
  03. Numeric posts navigation
  04. Sub-pages navigation
  05. Posted on
  06. Entry footer
  07. Menu toggle btn
  ==================================
 */


/* =========================================================
  01. Get SVG
 ======================================================== */

function lippukuntateema_get_svg( $icon, $args = array() ) {

  // Set defaults
  $defaults = array(
    'wrap'        => true, // Wrap in <span>
    'class'       => '',
    'title'       => '',
    'desc'        => '',
    'aria_hidden' => true, // Hide from screen readers.
  );

  // Set SVG variable
  $svg = '';

  // Parse args
  $args = wp_parse_args( $args, $defaults );

  // Add extra space before classes
  $args['class'] = $args['class'] ? ' ' . $args['class'] : '';

  // Set aria hidden
  $aria_hidden = ( $args['aria_hidden'] === true ) ? ' aria-hidden="true"' : '';

  // Set ARIA
  $aria_labelledby = ( $args['title'] && $args['desc'] ) ? ' aria-labelledby="title desc"' : '';

  if( $args['wrap'] === true ) {
    $svg .= '<span class="icon-wrap">';
  }

  // Begin SVG markup
  $svg .= '<svg class="icon icon-' . esc_html( $icon ) . esc_html($args['class']) . '"' . $aria_hidden . $aria_labelledby . ' role="img">';
    // If there is a title, display it.
    if ( $args['title'] ) {
      $svg .= '<title>' . esc_html( $args['title'] ) . '</title>';
    }
    // If there is a description, display it.
    if ( $args['desc'] ) {
      $svg .= '<desc>' . esc_html( $args['desc'] ) . '</desc>';
    }
  $svg .= '<use xlink:href="' . get_template_directory_uri() . '/dist/sprite/sprite.svg#icon-' . esc_html( $icon ) . '"></use>';
  $svg .= '</svg>';

  if( $args['wrap'] === true ) {
    $svg .= '</span>';
  }

  return $svg;
}


/* =========================================================
  02. Social share buttons
 ======================================================== */

function lippukuntateema_social_share_buttons() {
  $url = (!is_tax()) ? get_permalink() : get_term_link(get_queried_object()->term_id);
  $title = get_the_title();
  ?>
  <div class="social-share-container">
    <a data-social-media="Facebook" href="<?php echo "https://www.facebook.com/sharer/sharer.php?u=$url"; ?>" target="_blank" class="social-share-link social-share-fb">
      <?php echo lippukuntateema_get_svg('facebook'); ?>
      <span class="social-share-service"><?php pll_e('Facebook'); ?></span>
    </a>
    <a data-social-media="Twitter" href="<?php echo "https://twitter.com/share?url=$url"; ?>" target="_blank" class="social-share-link social-share-twitter">
      <?php echo lippukuntateema_get_svg('twitter'); ?>
      <span class="social-share-service"><?php pll_e('Twitter'); ?></span>
    </a>
  </div>
<?php
}

/* =========================================================
  03. Numeric posts navigation
 ======================================================== */

function lippukuntateema_numeric_posts_nav($custom_query = null) {

  global $wp_query;

  if( !empty( $custom_query ) ) {
    $wp_query_temp = $wp_query;
    $wp_query = $custom_query;
  }

  $max_num_pages = $wp_query->max_num_pages;

  if( $max_num_pages <= 1 )
    return;

  $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
  $max = intval( $max_num_pages );

  /** Add current page to the array */
  if ( $paged >= 1 )
    $links[] = $paged;

  /** Add the pages around the current page to the array */
  if ( $paged >= 3 ) {
    $links[] = $paged - 1;
    $links[] = $paged - 2;
  }

  if ( ( $paged + 2 ) <= $max ) {
    $links[] = $paged + 2;
    $links[] = $paged + 1;
  }

  echo '<div class="navigation numeric-navigation"><ul>' . "\n";

  if ( get_previous_posts_link() )
    printf( '<li>%s</li>' . "\n", get_previous_posts_link() ); // add custom prev posts label

  if ( ! in_array( 1, $links ) ) {
    $class = ( $paged == 1 ) ? ' class="active"' : '';

    printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

    if ( ! in_array( 2, $links ) )
      echo '<li>…</li>';
  }

  /** Link to current page, plus 2 pages in either direction if necessary */
  sort( $links );
  foreach ( (array) $links as $link ) {
    $class = ( $paged == $link ) ? ' class="active"' : '';
    printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
  }

  if ( ! in_array( $max, $links ) ) {
    if ( ! in_array( $max - 1, $links ) )
      echo '<li>…</li>' . "\n";

    $class = ( $paged == $max ) ? ' class="active"' : '';
    printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
  }

  /** Next Post Link */
  if ( get_next_posts_link() )
    printf( '<li>%s</li>' . "\n", get_next_posts_link() ); // add custom next posts label

  echo '</ul></div>' . "\n";

  if( !empty( $wp_query_temp ) )
    $wp_query = $wp_query_temp;

}


/* =========================================================
  04. Sub-pages navigation (pretendable)
 ======================================================== */

class lippukuntateema_Pretendable_Walker extends Walker_Page {
   function start_el(&$output, $page, $depth = 0, $args = array(), $current_page = 0) {
    global $pretend_id;
    if(!empty($pretend_id) && $pretend_id == $page->ID ) {
      $args['link_before'] = '<span class="current_page_item pretend_current_page_item">';
      $args['link_after'] = '</span>';
    }
    parent::start_el($output, $page, $depth, $args, $current_page);
  }
}

function lippukuntateema_sub_pages_navigations() {

  global $post;
  global $pretend_id;

  if( !empty( $pretend_id ) && is_numeric( $pretend_id ) ) {
    $post = get_post($pretend_id);
    setup_postdata($post);
  }

  $hierarchy_pos = count( $post->ancestors );
  if( $hierarchy_pos >= 2 ) {
    $parent = wp_get_post_parent_id( $post->post_parent );
  } elseif( $hierarchy_pos == 0 ) {
    $parent = $post->ID;
  } else {
    $parent = $post->post_parent;
  }

  $walker = new lippukuntateema_Pretendable_Walker();

  $list = wp_list_pages( array(
    'echo'        => 0,
    'child_of'    => $parent,
    'link_after'  => '',
    'title_li'    => '',
    'sort_column' => 'menu_order, post_title',
    'walker'      => $walker
  ));

  if( !empty( $list ) ) {
    $parent_top = array_reverse( get_post_ancestors($post->ID) );
    $first_parent = get_page( $parent_top[0] );
    $parent_css = '';
    if( $first_parent->ID == get_the_ID() ) {
      $parent_css = 'current_page_item';
    }

 ?>
    <nav class="sub-pages-navigation">
      <h2 class="<?php echo $parent_css; ?>"><a href="<?php echo get_permalink($first_parent->ID); ?>"><?php echo $first_parent->post_title; ?></a></h2>
      <ul><?php echo $list; ?></ul>
    </nav>

<?php

  } //!empty($list)

  if(!empty($pretend_id))
    wp_reset_postdata();

}


/* =========================================================
  05. Posted on
 ======================================================== */

function lippukuntateema_posted_on() {
  $time_string_format = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
  $time_string = sprintf( $time_string_format, esc_attr( get_the_date( 'j.n.Y' ) ), esc_html( get_the_date() ));
  echo '<span class="posted-on">' . $time_string . '</span>';
}


/* =========================================================
  06. Entry footer
 ======================================================== */

function lippukuntateema_entry_footer() {
  // Hide category and tag text for pages.
  if ( get_post_type() === 'post' ) {

    $categories_list = get_the_category_list( esc_html__( ', ', 'lippukuntateema' ) );
    if ( $categories_list ) {
      printf( '<span class="cat-links">' . esc_html__( pll__('Kategoriat') . ': %1$s', 'lippukuntateema' ) . '</span>', $categories_list );
    }

    $tags_list = get_the_tag_list( '', esc_html__( ', ', 'lippukuntateema' ) );
    if ( $tags_list ) {
      printf( '<span class="tags-links">' . esc_html__( pll__('Avainsanat') . ': %1$s', 'lippukuntateema' ) . '</span>', $tags_list );
    }
  }
}


/* =========================================================
  07. Menu toggle btn
 ======================================================== */

function lippukuntateema_menu_toggle_btn( $id, $args = array() ) {

  // Set defaults
  $defaults = array(
    'class'                => '',
    'label'                => '',
    'screen-readet-text'   => pll__('Menu'),
  );

  // Parse args
  $args = wp_parse_args($args, $defaults);

  // Setup class
  $class = 'menu-toggle';
  if(!empty($args['class'])) {
    $class .= ' ' . trim($args['class']);
  }

?>

  <button id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($class); ?>" aria-expanded="false">
    <span class="screen-reader-text"><?php echo esc_html($args['screen-readet-text']); ?></span>

    <svg class="icon icon-menu-toggle menu-open" aria-hidden="true" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100">
      <g class="svg-menu-toggle">
        <path class="line line-1" d="M5 13h90v14H5z"/>
        <path class="line line-2" d="M5 43h90v14H5z"/>
        <path class="line line-3" d="M5 73h90v14H5z"/>
      </g>
    </svg>

    <svg class="icon icon-menu-toggle menu-close" aria-hidden="true" version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
      <g class="svg-menu-toggle">
        <path d="M31.708 25.708c-0-0-0-0-0-0l-9.708-9.708 9.708-9.708c0-0 0-0 0-0 0.105-0.105 0.18-0.227 0.229-0.357 0.133-0.356 0.057-0.771-0.229-1.057l-4.586-4.586c-0.286-0.286-0.702-0.361-1.057-0.229-0.13 0.048-0.252 0.124-0.357 0.228 0 0-0 0-0 0l-9.708 9.708-9.708-9.708c-0-0-0-0-0-0-0.105-0.104-0.227-0.18-0.357-0.228-0.356-0.133-0.771-0.057-1.057 0.229l-4.586 4.586c-0.286 0.286-0.361 0.702-0.229 1.057 0.049 0.13 0.124 0.252 0.229 0.357 0 0 0 0 0 0l9.708 9.708-9.708 9.708c-0 0-0 0-0 0-0.104 0.105-0.18 0.227-0.229 0.357-0.133 0.355-0.057 0.771 0.229 1.057l4.586 4.586c0.286 0.286 0.702 0.361 1.057 0.229 0.13-0.049 0.252-0.124 0.357-0.229 0-0 0-0 0-0l9.708-9.708 9.708 9.708c0 0 0 0 0 0 0.105 0.105 0.227 0.18 0.357 0.229 0.356 0.133 0.771 0.057 1.057-0.229l4.586-4.586c0.286-0.286 0.362-0.702 0.229-1.057-0.049-0.13-0.124-0.252-0.229-0.357z"></path>
      </g>
    </svg>

    <?php if(!empty($args['label'])) : ?>
      <span class="menu-toggle-label"><?php echo esc_html($args['label']); ?></span>
    <?php endif; ?>
  </button>

<?php
}
