<?php get_header();?>
<?php wp_footer(); 

// #QINOTE: Array filter
$cids = array();
$sids = array();
$scoops = array();
// Get scoops
if (is_front_page() && get_theme_mod('style') == 'press') {
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
        $sids[] = $_article['ID'];
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
                <p class="title"><?php echo $scoop['title']?></p>
                <?php
                foreach($scoop['articles'] as $article):
                ?>
                <article>
                    <?php $image = get_post_meta($article['ID'], 'leros_image', TRUE);
                    if (!empty($image)):?>
                    <div class="image-large" style="background-image: url('<?php echo $image ?>')"></div>
                <?php endif;?>
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
}
?>
<div class="row">
    <?php
    if (get_theme_mod('layout') == 'wide'):?>
    </div>
</div>
<div class="glazz" style="background-image: url('<?php echo $background_image?>')?>"></div>
<?php else:?>
    <div class="col-md-<?php if (get_theme_mod('style') == 'press'):?>6<?php else:?>6<?php endif;?>">
        <div class="box">
            <div class="box-content">
                <div class="btn-group">
                    <a class="btn btn-default">Test</a>
                    <a class="btn btn-primary">Test</a>
                </div>
            </div>
        <?php /* Start the Loop */
        

        if (get_theme_mod('style') == 'press'):

        

        $q = new WP_Query();
        $q->query(array('post_type' => 'post', 'date_query' => array(
            array(
                'after' => '24 hours ago'
            )
        )));
        while ( $q->have_posts() ) : $q->the_post();  
        $live_duration = (int)get_post_meta($q->post->ID, 'leros_live_duration', TRUE);

        $date = get_the_date('Y-m-d H:i', $q->post->ID);
        $post_date = strtotime($date);
        $now = strtotime(current_time('Y-m-d H:i'));

        if ($now < $post_date + ($live_duration * 60)) {
            $cids[] = $q->post->ID;
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
            if (in_array($post->ID, $sids)) continue;
            foreach($scoops as $scoop) {
                if ($scoop['priority'] == $i) {
                    ?><section class="scoop">
                    <p class="title"><?php echo $scoop['title']?></p>
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
            <?php the_time('l, F jS, Y') ?><br>
            <h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
            <p><?php the_category(', ') ?>
 <?php if (get_theme_mod('style') == 'press'):
            the_excerpt();
        else:
            the_content();
        endif;?></p>
            <a href="<?php echo get_permalink(); ?>"> Read More...</a>
        </article>
        <hr>
        
        <?php 
            $i++;
            endwhile;?>
            <div class="navigation"><p><?php posts_nav_link('&#8734;','&laquo;&laquo; Go Forward 
In Time','Go Back in Time &raquo;&raquo;'); ?></p></div>
</div></div>
    </div>
    <div class="col-md-3">
        <div class="box">
            <div class="box-content">
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
        </div>
    </div>

<?php endif;?>
</div>
<?php get_footer();?>