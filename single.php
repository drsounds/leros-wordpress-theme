<?php get_header();?>
        <?php while ( have_posts() ) : the_post(); ?>
<div class="row">
    <div class="col-md-<?php if (get_theme_mod('style') == 'press'):?>6<?php else:?>6<?php endif;?>">
        <div class="box">
            <div class="box-header">
                <h5>&nbsp;</h5>
            </div>
            <div class="box-content">
        <?php /* Start the Loop */ ?>
        <article>

            <h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
            <small>Posted on 
<?php the_time('l, F jS, Y') ?> at 
<?php the_time() ?>
 under <?php the_category(', ') ?></small>
            <?php the_content(); ?>
            <small>This entry was posted on 
            <?php the_time('l, F jS, Y') ?> at 
            <?php the_time() ?> and is filed 
            under <?php the_category(', ') ?>. You 
            can follow any responses to this entry 
            through the <?php comments_rss_link('RSS 2.0'); ?> 
            feed.</small>
        </article>
        <hr>
        <?php comments_template(); ?>
    </div>
</div>
    </div>
    <div class="col-md-3" style="border-left: 1px dotted #aaa; min-height: 300pt">
        
                <?php get_template_part('sidebar', 'leros');?>
        <?php /*
        if (get_theme_mod('style') == 'press'):
        $facts = get_post_meta($post->ID, 'leros_facts', TRUE);
        if (!empty($facts)) {
            ?><div class="fact">
            <div class="title"><?php echo __('Fact', 'leros');?></div>
            <p><?php echo $facts?></p>
            <hr>
            </div><?php
        }?><b><?php echo __('More reading', 'leros');?></b><?php
            $tags = wp_get_post_tags($post->ID);
            $categories = wp_get_post_categories($post->ID);

            foreach($tags as $tag):
                leros_tag_feed($tag);
            endforeach;
            foreach($categories as $c):
                $category = get_category($c);
                leros_category_feed($category);
            endforeach;
            else:
                get_sidebar();
            endif;*/?>
    </div>
    
</div>
<?php endwhile; ?>
<?php get_footer();?>