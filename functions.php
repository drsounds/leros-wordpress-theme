<?php

require_once 'metaboxes.php';
function leros_customize_register( $wp_customize ) {
    
   $wp_customize->add_setting(
      'background_image_url',
      array(
        'default'   => '/wp-content/themes/leros/images/ct.jpg',
        'transport' => 'postMessage'
      )
    );
   $wp_customize->add_setting(
      'style',
      array(
        'default'   => 'normal',
        'transport' => 'postMessage'
      )
    );
   $wp_customize->add_control(
  
            'style',
            array(
                'label' => __('Style', 'leros'),
                'section' => 'title_tagline',
                'type' => 'url'
            )
        
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,

            'background_image_url',
            array(
                'label' => __('Background image URL', 'leros'),
                'section' => 'title_tagline',
                'type' => 'url'
            )
        )
    );
}

function leros_recent_news_category() {
  $categories = get_the_category();
  $category = $categories[0];
  ?>
  <table width="100%" class="feed">
    <thead>
      <tr>
        <th><?php echo $category->name?></th>
      </tr>
    </thead>
    <tbody>
  <?php
  $q = new WP_Query(array('posts_per_page' => 5, 'category' => $category->id));
  $q->query(array('category' => $category->id, 'posts_per_page' => 5));
  if ($q->have_posts()): while($q->have_posts()): $q->the_post();
  ?><tr><td><?php echo the_time('Y-m-d') ?><br><a href="<?php echo the_permalink()?>"><?php the_title();?></a></td></tr><?php
  endwhile;
  endif;
  ?></tbody></table><?php
}

function leros_recent_news() {
  $categories = get_the_category();
  $category = $categories[0];
  ?>   
  <table width="100%" class="feed">
    <thead>
      <tr>
        <th><i class="fa fa-clock-o"></i> <?php echo __('Recent posts', 'leros');?></th>
      </tr>
    </thead>
    <tbody>
  <?php
  $q = new WP_Query(array('posts_per_page' => 5));
  $q->query(array('posts_per_page' => 5));
  if ($q->have_posts()): while($q->have_posts()): $q->the_post();
  ?><tr><td><?php echo the_time('Y-m-d') ?><br><a href="<?php echo the_permalink()?>"><?php the_title();?></a></td></tr><?php
  endwhile;
  endif;
  ?></tbody></table><?php
}

function leros_tag_feed($tag) {
  ?>   
  <table width="100%" class="feed">
    <thead>
      <tr>
        <th><i class="fa fa-tag"></i> <a href="<?php echo get_tag_link($tag->ID)?>"><?php echo __($tag->name, 'leros');?></a></th>
      </tr>
    </thead>
    <tbody>
  <?php
  $q = new WP_Query(array('tag' => $tag->name, 'posts_per_page' => 5));
  $q->query(array('tag' => $tag->name, 'posts_per_page' => 5));
  if ($q->have_posts()): while($q->have_posts()): $q->the_post();
  ?><tr><td><?php echo the_time('Y-m-d') ?><br><a href="<?php echo the_permalink()?>"><?php the_title();?></a></td></tr><?php
  endwhile;
  endif;
  ?></tbody></table><?php
}


function leros_category_feed($category) {
  ?>   
  <table width="100%" class="feed">
    <thead>
      <tr>
        <th><a href="<?php echo get_category_link($category->ID)?>"><i class="fa fa-folder"></i> <?php echo $category->name?></a></th>
      </tr>
    </thead>
    <tbody>
  <?php
  $q = new WP_Query();
  $q->query(array('cat' => $category->term_id, 'posts_per_page' => 5));
  if ($q->have_posts()): while($q->have_posts()): $q->the_post();
  ?><tr><td><?php echo the_time('Y-m-d') ?><br><a href="<?php echo the_permalink()?>"><?php the_title();?></a></td></tr><?php
  endwhile;
  endif;
  ?></tbody></table><?php
}


function leros_pages() {
  $categories = get_the_category();
  $category = $categories[0];
  ?>   
  <table width="100%" class="feed">
    <thead>
      <tr>
        <th><?php echo __('Pages', 'leros');?></th>
      </tr>
    </thead>
    <tbody>
  <?php
  $q = new WP_Query(array('post_type' => 'page', 'posts_per_page' => 5));
  $q->query(array('posts_per_page' => 5,  'post_type' => 'page'));
  if ($q->have_posts()): while($q->have_posts()): $q->the_post();
  ?><tr><td><?php echo the_time('Y-m-d') ?><br><a href="<?php echo the_permalink()?>"><?php the_title();?></a></td></tr><?php
  endwhile;
  endif;
  ?></tbody></table><?php
}
function leros_categories() {
  $categories = get_categories();
  ?>   
  <table width="100%" class="feed">
    <thead>
      <tr>
        <th><?php echo __('Categories', 'leros');?></th>
      </tr>
    </thead>
    <tbody>
  <?php
  foreach($categories as $category):
  ?><tr><td><a href="<?php echo get_category_link($category->id)?>"><?php echo $category->name;?></a></td></tr><?php
  endforeach;
  ?></tbody></table><?php
}

function leros_register_menus() {
  register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu' ),
      'extra-menu' => __( 'Extra Menu' )
    )
  );
}
add_action( 'init', 'leros_register_menus' );

add_action( 'customize_register', 'leros_customize_register' ); 

/**
 * Register our sidebars and widgetized areas.
 *
 */
function leros_widgets_init() {

  register_sidebar( array(
    'name'          => 'Home right sidebar',
    'id'            => 'sidebar-1 ',
    'before_widget' => '<div>',
    'after_widget'  => '</div>',
    'before_title'  => '<h2 class="rounded">',
    'after_title'   => '</h2>',
  ) );

}
add_action( 'widgets_init', 'leros_widgets_init' );


// Creating the widget 
class leros_spotify_widget extends WP_Widget {

  function __construct() {
  parent::__construct(
  // Base ID of your widget
  'leros_widget', 

  // Widget name will appear in UI
  __('Spotify Play Button', 'leros'), 

  // Widget description
  array( 'description' => __( 'Spotify play button', 'leros' ), ) 
  );
  }

  // Creating widget front-end
  // This is where the action happens
  public function widget( $args, $instance ) {
    $spotify_uri = apply_filters( 'widget_spotify_uri', $instance['spotify_uri'] );
    // before and after widget arguments are defined by themes
    echo $args['before_widget'];
    //if ( ! empty( $spotify_uri ) )
    //  echo $args['before_spotify_uri'] . $spotify_uri . $args['after_spotify_uri'];

    // This is where you run the code and display the output
    ?>
    <iframe src="https://embed.spotify.com/?uri=<?php echo $instance['spotify_uri']?>" width="300" height="380" frameborder="0" allowtransparency="true"></iframe>
    <?php
    echo $args['after_widget'];
  }
      
  // Widget Backend 
  public function form( $instance ) {
    if ( isset( $instance[ 'spotify_uri' ] ) ) {
    $spotify_uri = $instance[ 'spotify_uri' ];
    }
    else {
    $spotify_uri = __( 'New spotify_uri', 'leros' );
    }
    // Widget admin form
    ?>
    <p>
    <label for="<?php echo $this->get_field_id( 'spotify_uri' ); ?>"><?php _e( 'spotify_uri:' ); ?></label> 
    <input class="widefat" id="<?php echo $this->get_field_id( 'spotify_uri' ); ?>" name="<?php echo $this->get_field_name( 'spotify_uri' ); ?>" type="text" value="<?php echo esc_attr( $spotify_uri ); ?>" />
    </p>
    <?php 
  }
    
  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['spotify_uri'] = ( ! empty( $new_instance['spotify_uri'] ) ) ? strip_tags( $new_instance['spotify_uri'] ) : '';
    return $instance;
  }
} // Class leros_widget ends here

// Register and load the widget
function leros_load_widget() {
  register_widget( 'leros_spotify_widget' );
}
add_action( 'widgets_init', 'leros_load_widget' );

if( !function_exists( 'style_options' )) {
  function style_options($wp) {
    if (
          !empty($_GET['theme-options'])
          && $_GET['theme-options'] == 'css'
      ) {
          # get theme options
          header('Content-Type: text/css');
          require dirname(__FILE__) . '/style.php';
          exit;
        }
  }
  add_action('parse_request', 'style_options');
}