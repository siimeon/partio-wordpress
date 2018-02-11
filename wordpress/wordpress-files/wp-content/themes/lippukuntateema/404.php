<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 */


get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

      <article class="error-404 not-found">
        <div class="page-content">
          <h1 class="entry-title"><?php pll_e( 'Hakemaasi sivua ei löytynyt' ); ?></h1>
          <div class="entry-content">
            <p><?php pll_e( 'Sivu on saatettu poistaa tai siirtää eri osoitteeseen. Käytä alla olevaa hakua löytääksesi etsimäsi.' ); ?></p>
            <div class="search-404 search-form">
              <?php get_search_form(); ?>
            </div>
          </div>
        </div><!-- .page-content -->
      </article><!-- .error-404 -->

    </main><!-- #main -->
  </div><!-- #primary -->

<?php
get_footer();
