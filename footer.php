<?php wp_footer(); ?>



<?php if (!is_front_page() && get_theme_mod('style') == 'press'):?>

<div class="divider"><h3><?php echo __('Recent blog posts', 'leros');?></div>
<div class="row">
    <div class="col-md-7">
        <?php /* Start the Loop */
        $q = new WP_Query();
        $q->query(array('post_type' => 'post', 'date_query' => array(
            array(
                'after' => '5 minutes ago'
            )
        )));
        while ( $q->have_posts() ) : $q->the_post(); ?>
        <div class="rightnow">
            <b><i class="fa fa-clock-o"></i><?php echo __('Just nu', 'leros')?></b>: <?php the_time('H:i') ?>  <a href="<?php the_permalink($q->post->ID);?>"><?php the_title();?></a>
        </div><?php 
        endwhile;
        /* Start the Loop */
       

         ?>
        <?php 
        $uri = $_SERVER['PHP_SELF'];
      
        $q = new WP_Query();
        $q->query(array('post_type' => 'post', 
            'date_query' => array(
                array(
                    'before' => '5 minutes ago'
                )
            )
        ));

         ?>
        <?php while ( $q->have_posts() ) : $q->the_post(); ?>
        <article style="">

            <h3><a href="<?php the_permalink($q->post->ID);?>"><?php the_title();?></a></h3>
            <small>Posted on 
<?php the_time('l, F jS, Y') ?> at 
<?php the_time() ?>
 under <?php the_category(', ') ?></small>
            <?php the_excerpt(); ?>
            <a href="<?php echo get_permalink($q->post->ID); ?>"> Read More...</a>
        </article>
        <hr>
        <?php endwhile;
         ?>

    </div>
    <div class="col-md-3">
         
          <?php
        if (get_theme_mod('style') == 'press'):
    if (!is_front_page()):
         leros_recent_news();
        leros_recent_news_category(); endif;
         leros_categories();
         else:
            get_sidebar();
        endif;?>

    </div>
</div>
<?php endif;?>
</div>
<div style="padding: 30pt; height: 200pt; background-color: rgba(233, 244, 255, .9); box-shadow:inset 0px 5pt 61pt white">
    <div class="row">
        <div class="col-md-12" style="text-align: center">
            <p>Wordpress Theme by Alexander Forselius</p>
        </div>
    </div>
</div>
</body>
</html>