<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <title><?php wp_title(); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/style.php" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory')?>/mobile.css" media="screen and (max-width: 768px)">
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory')?>/mobile.css" media="screen and (max-device-width: 768px)">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_enqueue_script('jquery'); ?>
        <?php wp_head(); ?>
    </head>
    <body style="background-image: url('<?php echo get_theme_mod('background_image_url')?>'); background-position-y: -200pt; background-image: url('/wp-content/themes/leros/images/ct_blurred.jpg'); background-size: cover; background-attachment: fixed">
        <div style="display: none" id="bg_normal" style="z-index: -10; position: fixed; left: 0px; top: 0px; width:100%; height: 100%; background-image: url('<?php echo get_theme_mod('background_image_url')?>'); background-position-y: -200pt; background-image: url('/wp-content/themes/leros/images/ct.jpg'); background-size: cover; background-attachment: fixed"></div>

        
        <script>
        jQuery(window).scroll(function () {
            jQuery('#header_layer_1').css({'top': (jQuery(window).scrollTop() * 0.5 + 100)  + 'px'});
            var scrollTop = jQuery(window).scrollTop();
            var opacity = 0;
            var range = 300;
            if (scrollTop < range) {

              // jQuery('#bg_blurred').css({'opacity': (scrollTop / range)});
            } else {
              //  jQuery('#bg_blurred').css({'opacity': 1});

            }
        });
        </script>
        <div class="body">
            <div id="span"></div>
            <div class="header-layered" style="height:300pt;">
             <img id="header_layer_1" style="width:100%; position: absolute; top: 100px; z-index:-1" src="<?php bloginfo('stylesheet_directory'); ?>/images/header_layer_1.svg">
                <img id="header_layer_2" style="width:100%; position: absolute; top: 32%; z-index:-1" src="<?php bloginfo('stylesheet_directory'); ?>/images/header_layer_2.svg">
            </div>
            <div id="title_row" style="">
                <div class="row" style="margin-top: 0pt">
                  
                    <div class="col-md-12" id="title" style="text-align: center">
                        <a id="toggler" class="fa fa-bars" style="float: left;font-size:50pt; color: white" onclick="toggleMenu(event)" href="javascript:void(event)"></a>
                    <h1><?php bloginfo('name');?></h1>
                        <p><?php bloginfo('description');?></p>
                        

                    </div>

                </div>
            </div>
            <?php if (get_theme_mod('style') == 'press'):
                                        ?>
            <div class="container">
                <div class="menu">
                    <ul >
                        <li class="mitem category_item"><a href="/"><?php echo __('Home', 'leros')?></a></lI>
                        
                        <?php
                        $categories = get_categories();
                        foreach($categories as $c):
                            $category = get_category($c);?>
                        <li class="mitem category_item"><a href="<?php echo get_category_link($category->cat_ID)?>"><?php echo $category->name?></a></lI>
                        <?php endforeach;?>
                    </ul>
                    
                </div><br>
                <div class="menu cmenu">
                    <ul ><?php
                        $current_category = get_the_category();
                        $categories = get_categories(array('child_of' => $current_category[0]->cat_ID));
                        ?><li class="mitem"><a href="<?php echo get_category_link($current_category->cat_ID);?>"><?php echo $current_category[0]->name . " - Hem"?></li><?php
                        foreach($categories as $c):
                            $category = get_category($c);?>
                        
                        <li class="mitem"><a href="<?php echo get_category_link($category->cat_ID)?>"><?php echo $category->name?></a></lI>
                        <?php endforeach;?>
                    </ul>
                    
                </div><br>
            </div>
            <?php
                        endif;?>
            <div class="container">            
                    
               <div class="row">
                </div>
            </div>
        </div>
        <div class="content">
        <div class="container">