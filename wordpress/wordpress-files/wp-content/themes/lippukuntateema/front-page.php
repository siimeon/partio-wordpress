<?php
/**
 * The template for displaying front page.
 **/

get_header(); ?>

  <?php get_template_part('template-parts/hero'); ?>

  <div id="primary" class="content-area">
    <section id="boxes" class="site-boxes">
      <div class="site-boxes-wrap">
        <h1><?php echo get_theme_mod('lippukuntateema_boxes_title', 'Hyppää mukaan elämäsi seikkailuun'); ?></h1>
        <div class="container">
          <div class="box box-one"><?php dynamic_sidebar( 'sidebar-box1' ); ?></div>
          <div class="box box-two"><?php dynamic_sidebar( 'sidebar-box2' ); ?></div>
          <div class="box box-three"><?php dynamic_sidebar( 'sidebar-box3' ); ?></div>
        </div>
      </div>
    </section>
    <section id="latest" class="site-latest">
      <div class="site-latest-wrap">
        <h1><?php echo get_theme_mod('lippukuntateema_news_title', 'Ajankohtaista'); ?></h1>
        <div class="container">
          <?php
            $args = array(
              'post_type' => array('post'),
              'posts_per_page' => '3',
            );
            $query = new WP_Query($args);
            if ($query->have_posts()): ?>
              <?php while ($query->have_posts()): $query->the_post(); ?>
                <?php get_template_part('template-parts/teaser', 'post'); ?>
              <?php endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div>
        <footer class="site-latest-footer">
          <a class="button" href="<?php echo get_permalink(get_option('page_for_posts')); ?>">Lue kaikki uutiset</a>
        </footer>
      </div>
    </section>
    <main id="main" class="site-main" role="main">
      <?php if (have_posts()) :
        while (have_posts()) : the_post(); ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
              <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            </header><!-- .entry-header -->
            <div class="entry-content">
              <?php the_content(); ?>
            </div><!-- .entry-content -->
          </article><!-- #post-## -->
        <?php endwhile;
      endif; ?>
    </main><!-- #main -->
    <?php if(lippukuntateema_has_fb() || lippukuntateema_has_twitter() || lippukuntateema_has_ig()): ?>
      <section id="some" class="site-feeds">
        <h1><?php echo get_theme_mod('lippukuntateema_social_title', 'Löydät meidät sosiaalisesta mediasta'); ?></h1>
        <?php if(lippukuntateema_has_fb()): ?>
          <section class="feeds-facebook">
            <?php
              $fb_page_id = lippukuntateema_get_option('lippukuntateema_fb_page_id');
              $feed = dude_facebook_feed()->get_posts($fb_page_id);
            ?>
            <h1 class="feed-title"><?php echo lippukuntateema_get_svg('facebook', array('wrap' => false)); ?> <a target="_blank" href="https://www.facebook.com/profile.php?id=<?php echo $fb_page_id; ?>">Facebook</a></h1>
            <div class="container">
              <?php foreach ($feed['data'] as $item): ?>
                <div class="feed-item">
                  <div class="feed-item-image">
                    <a target="_blank" href="<?php echo $item['link']; ?>"><img src="<?php echo $item['full_picture']; ?>" alt=""></a>
                  </div>
                  <div class="feed-item-content">
                    <?php
                      if ($item['story']) {
                        $message = $item['story'];
                      } else {
                        $message = $item['message'];
                      }
                      echo $message;
                    ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </section>
        <?php endif; ?>
        <?php if(lippukuntateema_has_twitter()): ?>
          <section class="feeds-twitter">
            <?php
              $twitter_username = lippukuntateema_get_option('lippukuntateema_twitter_username');
              $tweets = dude_twitter_feed()->get_user_tweets($twitter_username);
            ?>
            <h1 class="feed-title"><?php echo lippukuntateema_get_svg('twitter', array('wrap' => false)); ?> <a target="_blank" href="https://twitter.com/<?php echo $twitter_username; ?>">Twitter</a></h1>
            <div class="container">
              <?php if ($tweets): ?>
                <?php foreach ($tweets as $tweet): ?>
                  <div class="feed-item">
                    <div class="feed-item-content">
                      <?php echo lippukuntateema_linkify_tweet($tweet->text); ?>
                    </div>
                    <a class="feed-item-link" target="_blank" href="https://twitter.com/<?php echo $twitter_username; ?>/status/<?php echo $tweet->id; ?>">Näytä koko twiitti</a>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </section>
        <?php endif; ?>
        <?php if(lippukuntateema_has_ig()): ?>
          <?php
            $instagram_user_id = lippukuntateema_get_option('lippukuntateema_ig_user_id');
            $instagram_feed = dude_insta_feed()->get_user_images($instagram_user_id);
          ?>
          <?php if(isset($instagram_feed['data'])): ?>
            <section class="feeds-ig">
              <h1 class="feed-title"><?php echo lippukuntateema_get_svg('instagram', array('wrap' => false)); ?> <a target="_blank" href="https://www.instagram.com/<?php echo $instagram_feed['data'][0]['user']['username']; ?>">Instagram</a></h1>
              <div class="container">
                <?php foreach ($instagram_feed['data'] as $item): ?>
                  <div class="feed-item">
                    <div class="feed-item-image">
                      <a target="_blank" href="<?php echo $item['link']; ?>"><img src="<?php echo $item['images']['standard_resolution']['url']; ?>" alt=""></a>
                    </div>
                    <div class="feed-item-content">
                      <?php echo lippukuntateema_linkify_instagram($item['caption']['text']); ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </section>
          <?php endif; ?>
        <?php endif; ?>
      </section>
    <?php endif; ?>
  </div><!-- #primary -->

<?php
get_footer();
