<?php get_header();?>
<div class="row">
    <div class="col-md-<?php if (get_theme_mod('style') == 'press'):    ?>6<?php else:?>8<?php endif;?>">

        <div class="box">
            <div class="box-header">&nbsp;</div>

            <div class="box-content">
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
        </div>
    </div>
    <div class="col-md-<?php if (get_theme_mod('style') == 'press'):?>4<?php else:?>4<?php endif;?>">
        <div class="box">
            <div class="box-header">&nbsp;</div>
            <div class="box-content">
         <?php
        if (get_theme_mod('style') == 'press'):
         leros_recent_news();
         leros_categories();
         else:
            get_sidebar();
        endif;?>
            </div>
        </div>
    </div>
    
</div>
<?php get_footer();?>