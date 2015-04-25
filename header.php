<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <title><?php wp_title(); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />

        
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/style.php" type="text/css" media="screen" />
        <?php $isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
        if (!$isiPad):?>
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory')?>/mobile.css" media="screen and (max-width: 768px)">
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory')?>/mobile.css" media="screen and (max-device-width: 768px)">
    <?php else:?>
    <meta name="viewport" content="width=1280, initial-scale=1">
<?php endif;?>
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_enqueue_script('jquery'); ?>
        <?php wp_head(); ?>
    </head>
    <body style="">
        <div class="background" style="background-image: url('<?php echo get_theme_mod('background_image_url')?>'); ">
        </div>
         <div class="background-2" style=" ">
        </div>
        <script>
        jQuery(window).scroll(function () {
            jQuery('#header_layer_1').css({'top': (jQuery(window).scrollTop() * 0.5 + 100)  + 'px'});
            var scrollTop = jQuery(window).scrollTop();
            var opacity = 0;
            var range = 300;
            if (true) {
                jQuery("body").css({'background-position': '0px -' + (200 + scrollTop * 0.1) + 'pt'});
              // jQuery('#bg_blurred').css({'opacity': (scrollTop / range)});
            } else {
              //  jQuery('#bg_blurred').css({'opacity': 1});
            }
        });
        /*var t = false;
        setInterval(function () {
            if (t) {
                jQuery('body').css({'background-position-x': '0px'});
            } else {
                jQuery('body').css({'background-position-x': '1px'});
            }
            t = !t;
        }, 0.005);*/
        </script>
        <img id="header_layer_1" style="opacity: 0.5;width:100%; position: absolute; top: 100px; z-index:-1" src="<?php bloginfo('stylesheet_directory'); ?>/images/header_layer_1.svg">
        <div class="navbar">
            <div class="container<?php if (get_theme_mod('style') == 'press'):?>-fluid<?php endif;?>">
                <div class="col-md-4">
                    <div class="menu">
                        <ul style="float: left">
                            <li><a href="/"><?php echo bloginfo('title')?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8">
                    <?php wp_nav_menu('header-menu')?>
                       
                </div>
            </div>
        </div>
        <?php if (get_theme_mod('style') == 'press'):?>?>
        <div class="navbar-sub">
            <div class="container<?php if (get_theme_mod('style') == 'press'):?>-fluid<?php endif;?>">
               
                <div class="col-md-12">
                    <div class="menu">
                        <ul>
                         <?php
                        $current_category = get_the_category();
                        $categories = get_categories(array('parent' => 0));
                        foreach($categories as $c):
                            $category = get_category($c);?>
                        <li class="mitem <?php if ($current_category->cat_ID == $category->cat_ID):?>category_item-active<?php endif;?>"><a href="<?php echo get_category_link($category->cat_ID)?>"><?php echo $category->name?></a></lI>
                        <?php endforeach;?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php endif;?>
        <div style="height: 80pt"></div>

        <div class="content">
        <div class="container<?php if (get_theme_mod('style') == 'press'):?>-fluid<?php endif;?>">