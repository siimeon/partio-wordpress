<?php
/**
 * Template part for displaying a message that posts cannot be found.
 */

?>

<article class="error-404 not-found">
  <div class="page-content">
    <h1 class="entry-title"><?php pll_e( 'Ei hakutuloksia' ); ?></h1>
    <div class="entry-content">
      <p><?php pll_e( 'Hakutuloksia ei löytynyt. Kokeile eri hakusanoja.' ); ?></p>
      <div class="search-form search-404">
        <?php get_search_form(); ?>
      </div>
    </div>
  </div><!-- .page-content -->
</article><!-- .error-404 -->
