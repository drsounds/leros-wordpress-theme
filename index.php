<?php get_header();?>
<?php wp_footer(); ?>
<div class="row">
    <div class="col-md-7">
        <?php /* Start the Loop */
        if (get_theme_mod('style') == 'press'):
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
        endif;
        while ( have_posts() ) : the_post(); ?>
        <article style="">

            <h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
            <small>Posted on 
<?php the_time('l, F jS, Y') ?> at 
<?php the_time() ?>
 under <?php the_category(', ') ?></small>
            <?php the_excerpt(); ?>
            <a href="<?php echo get_permalink(); ?>"> Read More...</a>
        </article>
        <hr>
        <div class="navigation"><p><?php posts_nav_link('&#8734;','&laquo;&laquo; Go Forward 
In Time','Go Back in Time &raquo;&raquo;'); ?></p></div>
        <?php endwhile;?>
    </div>
    <div class="col-md-4">
        <?php
        if (get_theme_mod('style') == 'press'):
    if (!is_front_page()):
        leros_recent_news_category(); endif;
         leros_recent_news();
         leros_categories();
         else:
            get_sidebar();
        endif;?>
    </div>
</div>
<?php get_footer();?>