<?php get_header();?>
<?php wp_footer(); 

// #QINOTE: Array filter
$cids = array();

// Get scoops
$scoops = array();
$_scoops = new WP_Query();
$_scoops->query(array('post_type' => 'scoop'));
while($_scoops->have_posts() ):
    $_scoops->the_post();
    $scoop = array(
        'ID' => get_the_ID(),
        'title' => get_the_title(get_the_ID()),
        'tag' => get_post_meta(get_the_ID(), 'leros_tag', TRUE),
        'excerpt' => get_the_excerpt(get_the_ID()),
        'priority' => get_post_meta(get_the_ID(), 'leros_priority', TRUE),
        'color' => get_post_meta(get_the_ID(), 'leros_color', TRUE),
        'articles' => array()
    );
    // Get articles
    $articles = new WP_Query();
    $articles->query(array('post_type' => 'post', 'tag' => $scoop['tag'], 'posts_per_page' => 3));
    while($articles->have_posts()): $articles->the_post();

        $_article = array(
            'ID' => $articles->post->ID,
            'title' => get_the_title($articles->post->ID),
            'excerpt' => get_the_excerpt($articles->post->ID),
            'tag' => get_post_meta($articles->post->ID, 'tag', TRUE),
            'priority' => get_post_meta($articles->post->ID, 'priority', TRUE),
            'color' => get_post_meta($articles->post->ID, 'color', TRUE),
            
        );
        $scoop['articles'][] = $_article;
    endwhile;
    $scoops[] = $scoop;
endwhile;

foreach($scoops as $scoop):
    if ($scoop['priority'] <= 0) {
        ?>
        <div class="row">
            <div class="col-md-12">
                <section class="scoop">
                <h2><?php echo $scoop['title']?></h2>
                <?php
                foreach($scoop['articles'] as $article):
                ?>
                <article>
                    <h3><a href="<?php echo get_the_permalink($article['ID'])?>"><?php echo $article['title']?></a></h3>
                    <p><?php echo $article['excerpt']?></p>
                        <a href="<?php echo get_the_permalink($article['ID'])?>">Läs mer</a>
                </article>

                <?php
                endforeach;?></section>
            </div>
        </div><br><?php
    }
endforeach;
?>
<div class="row">
    <?php
    if (get_theme_mod('layout') == 'wide'):?>
    </div>
</div>
<div class="glazz" style="background-image: url('<?php echo $background_image?>')?>"></div>
<?php else:?>
    <div class="col-md-7">
        <?php /* Start the Loop */
        

        if (get_theme_mod('style') == 'press'):

        

        $q = new WP_Query();
        $q->query(array('post_type' => 'post', 'date_query' => array(
            array(
                'after' => '24 hours ago'
            )
        )));
        while ( $q->have_posts() ) : $q->the_post(); $cids[] = $q->post->ID; 
        $live_duration = (int)get_post_meta($q->post->ID, 'leros_live_duration', TRUE);

        $date = get_the_date('Y-m-d H:i', $q->post->ID);
        $post_date = strtotime($date);
        $now = strtotime(current_time('Y-m-d H:i'));

        if ($now < $post_date + ($live_duration * 60)) {
        ?>
            <div class="rightnow">
                <b><i class="fa fa-clock-o"></i> <?php echo __('Just nu', 'leros')?></b>: <?php the_time('H:i') ?>  <a href="<?php the_permalink($q->post->ID);?>"><?php the_title();?></a>
            </div><?php 
        }
        endwhile;
        /* Start the Loop */
        endif;
        $i = 0;
        while ( have_posts() ) : the_post();
            if (in_array($post->ID, $cids)) continue;
            foreach($scoops as $scoop) {
                if ($scoop['priority'] == $i) {
                    ?><section class="scoop">
                    <h2><?php echo $scoop['title']?></h2>
                    <?php
                    foreach($scoop['articles'] as $article):
                    ?>
                    <article>
                        <h3><a href="<?php echo get_the_permalink($article['ID'])?>"><?php echo $article['title']?></a></h3>
                        <p><?php echo $article['excerpt']?></p>
                        <a href="<?php echo get_the_permalink($article['ID'])?>">Läs mer</a>
                    </article>
                    <?php
                    endforeach;?></section><?php

                }
            }
         ?>
        <article style="">

            <h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
            <small>Posted on 
<?php the_time('l, F jS, Y') ?> at 
<?php the_time() ?>
 under <?php the_category(', ') ?></small>
 <?php if (get_theme_mod('style') == 'press'):
            the_excerpt();
        else:
            the_content();
        endif;?>
            <a href="<?php echo get_permalink(); ?>"> Read More...</a>
        </article>
        <hr>
        
        <?php 
            $i++;
            endwhile;?>
            <div class="navigation"><p><?php posts_nav_link('&#8734;','&laquo;&laquo; Go Forward 
In Time','Go Back in Time &raquo;&raquo;'); ?></p></div>
    </div>
    <div class="col-md-3    <">
        <?php
        if (get_theme_mod('style') == 'press'):
    if (!is_front_page()):
        leros_recent_news_category(); endif;
         leros_recent_news();   
         leros_categories();
           if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-1')) : 

         endif; 
         else:
            get_sidebar();
        endif;?>
    </div>

<?php endif;?>
</div>
<?php get_footer();?>