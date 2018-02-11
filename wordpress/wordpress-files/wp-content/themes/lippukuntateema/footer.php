<?php
/**
 * The template for displaying the footer.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

?>

  </div><!-- #content -->

  <div id="prefooter" class="site-prefooter">
    <div class="container">
      <a class="logo" href="http://www.partio.fi"><img src="<?php echo get_template_directory_uri() . '/dist/images/partio-logo.png'; ?>"></a>
      <nav class="social-links">
        <h4>Löydät meidät sosiaalisesta mediasta:</h4>
        <?php wp_nav_menu( array( 'theme_location' => 'social', 'menu_id' => 'social-menu' ) ); ?>
      </nav>
    </div>
  </div>

  <footer id="colophon" class="site-footer" role="contentinfo">
    <div class="container">
      <?php dynamic_sidebar( 'sidebar-footer' ); ?>
    </div>
  </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
