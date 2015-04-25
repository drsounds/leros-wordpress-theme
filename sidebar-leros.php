<?php
if (get_theme_mod('style') == 'press'):
  if (!is_front_page()):
  leros_recent_news_category(); endif;
   leros_recent_news();   
   leros_categories();
  if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-1')) : 

  endif; 
  else:
    ?>
  <div class="box">
    <div class="box-header">
      &nbsp;
    </div>
    <div class="box-content">
      <?php get_sidebar(); ?>
    </div>
  </div><?php 
endif;?>