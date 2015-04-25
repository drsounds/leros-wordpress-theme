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