<?php wp_footer();
 // #QINOTE: Array filter
    $cids = array();

    $scoops = array();
    $sids = array();
if (get_theme_mod('style') == 'press') {
if (!is_front_page()) {

    ?>
    <br>
    <?php
   
    // Get scoops
    if (!is_front_page()) {
        $_scoops = new WP_Query();
        $_scoops->query(array('post_type' => 'scoop'));
        while($_scoops->have_posts() ) {
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
            while($articles->have_posts()) {
                $articles->the_post();

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
            }
        }
        $scoops[] = $scoop;
    }
    foreach($scoops as $scoop) {
        if ($scoop['priority'] <= 0) {
            ?>
            <div class="row">
                <div class="col-md-12">
                    <section class="scoop">
                    <h2><?php echo $scoop['title']?></h2>
                    <?php
                    foreach($scoop['articles'] as $article) {
                    ?>
                    <article>
                        <h3><a href="<?php echo get_the_permalink($article['ID'])?>"><?php echo $article['title']?></a></h3>
                        <p><?php echo $article['excerpt']?></p>
                            <a href="<?php echo get_the_permalink($article['ID'])?>">Läs mer</a>
                    </article>

                    <?php
                    }?></section>
                </div>
            </div><br><?php
        }
    }   
?>
<div class="row">
    <?php
    if (get_theme_mod('layout') == 'wide') {?>
    </div>
</div>
<div class="glazz" style="background-image: url('<?php echo $background_image?>')?>"></div>
<?php } else {?>
    <div class="col-md-<?php if (get_theme_mod('style') == 'press'):?>6<?php else:?>6<?php endif;?>">
        <div class="box">
            <div class="box-content">
        <?php /* Start the Loop */
        

        if (get_theme_mod('style') == 'press') {

        

            $q = new WP_Query();
            $q->query(array('post_type' => 'post', 'date_query' => array(
                array(
                    'after' => '24 hours ago'
                )
            )));
            while ( $q->have_posts() ) { $q->the_post();  
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
            }
        /* Start the Loop */
        }
        $i = 0;
        while ( $q->have_posts() ) { $q->the_post(); 

        if (in_array($q->post->ID, $cids)) continue;
        if (in_array($q->post->ID, $sids)) continue;
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

            <h3><a href="<?php the_permalink($q->post->ID);?>"><?php the_title();?></a></h3>
            <small>Posted on 
<?php the_time('l, F jS, Y') ?> at 
<?php the_time() ?>
 under <?php the_category(', ') ?></small>
            <?php the_excerpt(); ?>
            <a href="<?php echo get_permalink($q->post->ID); ?>"> Read More...</a>
        </article>
        <hr>
        <?php
            $i++;
         }
         ?>

            </div>
        </div>
    </div>
    <div class="col-md-3">
         <div class="box">
            <div class="box-content">
          <?php
        if (get_theme_mod('style') == 'press') {
    if (!is_front_page()):
         leros_recent_news();
        leros_recent_news_category(); endif;
         leros_categories();
         } else {
            get_sidebar();
        }?>
            </div>
        </div>

    </div>
</div>
<?php }
}
}?>
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