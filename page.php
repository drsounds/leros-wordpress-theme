<?php get_header();?>
<div class="row">
    <div class="col-md-6">
        <?php /* Start the Loop */ ?>
        <?php while ( have_posts() ) : the_post(); ?>
        <article>
            <h1><a href="<?php the_permalink();?>"><?php the_title();?></a></h1>
            <?php the_content(); ?>
        </article>
        <hr>
        <?php comments_template(); ?>
        <?php endwhile; ?>
    </div>
    <div class="col-md-4">
         <?php
        if (get_theme_mod('style') == 'press'):
         leros_recent_news();
         leros_categories();
         else:
            get_sidebar();
        endif;?>
    </div>
    
</div>
<?php get_footer();?>