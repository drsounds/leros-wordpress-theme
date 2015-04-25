<?php

require_once 'metaboxes.php';
function leros_customize_register( $wp_customize ) {
  $wp_customize->add_section(
    'leros_options',
    array(
      'title' => __( 'Leros settings', 'leros' ),
      'priority' => 100,
      'capability' => 'edit_theme_options',
      'description' => __('Change theme related settings', 'leros'),
    )
  );
   $wp_customize->add_setting(
      'background_image_url',
      array(
        'default'   => '/wp-content/themes/leros/images/ct.jpg',
        'transport' => 'postMessage'
      )
    );
    $wp_customize->add_setting(
      'primary_color',
      array(
        'default'   => '#009ece',
        'transport' => 'postMessage'
      )
    );
    $wp_customize->add_setting(
      'secondary_color',
      array(
        'default'   => '#00a398',
        'transport' => 'postMessage'
      )
    );
    $wp_customize->add_setting(
      'tertiary_color',
      array(
        'default'   => '#00a398',
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
                'section' => 'leros_options',
                'type' => 'url'
            )
        
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,

            'background_image_url',
            array(
                'label' => __('Background image URL', 'leros'),
                'section' => 'leros_options',
           )
        )
    );
    $wp_customize->add_control(
      new WP_Customize_Color_Control(
        $wp_customize, 
      'primary_color',
      array(
          'label' => __('Primary color', 'leros'),
          'section' => 'leros_options',
      )
      ));
      $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'secondary_color',
        array(
            'label' => __('Secondary color', 'leros'),
            'section' => 'leros_options',
        )
        )
      );
      $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'tertiary_color',
        array(
            'label' => __('Tertiary color', 'leros'),
            'section' => 'leros_options',
        )
        )
    );
}

/**
 * Newsfeed widget
 **/
class Leros_NewsFeed_Widget extends WP_Widget {

  /**
   * Sets up the widgets name etc
   */
  public function __construct() {
    // widget actual processes
    parent::__construct(
      'leros_newsfeed_widget', // Base ID
      __( 'Newsfeed Widget', 'leros' ), // Name
      array( 'description' => __( 'A newsfeed widget', 'leros' ), ) // Args
    );
  }

  /**
   * Outputs the content of the widget
   *
   * @param array $args
   * @param array $instance
   */
  public function widget( $args, $instance ) {
    echo $args['before_widget'];
    // outputs the content of the widget
    $id = $instance['id'];

    $type = $instance['type'];
    if (!empty($type) && !empty($id)) {
      if ($type == 'category') {
        $category = get_category(get_category_by_slug($id));
        leros_category_feed($category);
      }
      if ($type == 'tag') {
        $tag = get_tag(get_term_by('name', $id, 'post_tag'));
        leros_tag_feed($tag);
      }
    }
      echo $args['after_widget'];
  }

  /**
   * Outputs the options form on admin
   *
   * @param array $instance The widget options
   */
  public function form( $instance ) {
    // outputs the options form on admin
    ?>
    <input type="radio" id="<?php echo $this->get_field_id('type')?>" name="<?php echo $this->get_field_name('type')?>" value="category" checked><?php echo __('Category' , 'leros');?><br>
    <input type="radio" id="<?php echo $this->get_field_id('type')?>" name="<?php echo $this->get_field_name('type')?>" value="tag"><?php echo __('Tag' , 'leros');?><br>
    <label for="id"><?php echo __('Category/Tag', 'leros');?></label><br>
    <input class="widefat" id="<?php echo $this->get_field_id('id')?>" name="<?php echo $this->get_field_name('id')?>" value="<?php echo esc_attr( $instance['id'] )?>"><?php


  }

  /**
   * Processing widget options on save
   *
   * @param array $new_instance The new options
   * @param array $old_instance The previous options
   */
  public function update( $new_instance, $old_instance ) {
    // processes widget options to be saved
    $instance = $old_instance;  
    $instance['category'] = ( ! empty( $new_instance['category'] ) ) ? strip_tags( $new_instance['category'] ) : '';
    $instance['type'] = ( ! empty( $new_instance['type'] ) ) ? strip_tags( $new_instance['type'] ) : '';
    $instance['id'] = ( ! empty( $new_instance['id'] ) ) ? strip_tags( $new_instance['id'] ) : '';
    return $instance;
  }
}

function leros_recent_news_category() {
  $categories = get_the_category();
  $category = $categories[0];
  ?>
  <div class="box">
    <div class="box-header">
      <?php echo $category->name?>
    </div>
    <div class="box-content">
      <table width="100%" class="feed">
    
    <tbody>
  <?php
  $q = new WP_Query();
  $q->query(array('cat' => $category->cat_ID, 'posts_per_page' => 5));
  if ($q->have_posts()): while($q->have_posts()): $q->the_post();
  ?><tr><td><?php format_date() ?><br><a href="<?php echo the_permalink()?>"><?php the_title();?></a></td></tr><?php
  endwhile;
  endif;
  ?></tbody></table></div></div><?php
}

function leros_recent_news() {
  $categories = get_the_category();
  $category = $categories[0];
  ?>   
  <div class="box">
    <div class="box-header">
      <i class="fa fa-clock-o"></i> <?php echo __('Recent posts', 'leros');?>
    </div>
    <div class="box-content">
  <table width="100%" class="feed">
        <tbody>
  <?php
  $q = new WP_Query(array('posts_per_page' => 5));
  $q->query(array('posts_per_page' => 5));
  if ($q->have_posts()): while($q->have_posts()): $q->the_post();
  ?><tr><td><?php format_date() ?><br><a href="<?php echo the_permalink()?>"><?php the_title();?></a></td></tr><?php
  endwhile;
  endif;
  ?></tbody></table></div></div><?php
}

function format_date() {
  if (date('Yz') == get_the_time('Yz')) {
    return the_time('H:i');
  } 
  if (date('Yz') - 1 == get_the_time('Yz')) {
    echo __("Yesterday", "leros") . " ";
    the_time('H:i');
    return;
  }
  return the_time('Y-m-d H:i');
}

function leros_tag_feed($tag) {
  ?>   
  <div class="box">
    <div class="box-header">
      <i class="fa fa-tag"></i> <a href="<?php echo get_tag_link($tag->ID)?>"><?php echo __($tag->name, 'leros');?></a>
    </div>
    <div class="box-content">
  <table width="100%" class="feed">
    
    <tbody>
  <?php
  $q = new WP_Query(array('tag' => $tag->name, 'posts_per_page' => 5));
  $q->query(array('tag' => $tag->name, 'posts_per_page' => 5));
  if ($q->have_posts()): while($q->have_posts()): $q->the_post();
  ?><tr><td><?php format_date() ?><br><a href="<?php echo the_permalink()?>"><?php the_title();?></a></td></tr><?php
  endwhile;
  endif;
  ?></tbody></table></div></div><?php
}


function leros_category_feed($category) {
  ?>  
  <div class="box">
    <div class="box-header">
      <a href="<?php echo get_category_link($category->ID)?>"><i class="fa fa-folder"></i> <?php echo $category->name?></a>
    </div>
    <div class="box-content">
  <table width="100%" class="feed feed-<?php echo $category->term_id?>">
    
    <tbody>
  <?php
  $q = new WP_Query();
  $q->query(array('cat' => $category->term_id, 'posts_per_page' => 5));
  if ($q->have_posts()): while($q->have_posts()): $q->the_post();
  ?><tr><td><?php format_date() ?><br><a href="<?php echo the_permalink()?>"><?php the_title();?></a></td></tr><?php
  endwhile;
  endif;
  ?></tbody></table></div></div><?php
}


function leros_pages() {
  $categories = get_the_category();
  $category = $categories[0];
  ?>   
  <div class="box">
    <div class="box-header">
      <?php echo __('Pages', 'leros');?>
    </div>
    <div class="box-content">
  <table width="100%" class="feed">
    
    <tbody>
  <?php
  $q = new WP_Query(array('post_type' => 'page', 'posts_per_page' => 5));
  $q->query(array('posts_per_page' => 5,  'post_type' => 'page'));
  if ($q->have_posts()): while($q->have_posts()): $q->the_post();
  ?><tr><td><?php format_date() ?><br><a href="<?php echo the_permalink()?>"><?php the_title();?></a></td></tr><?php
  endwhile;
  endif;
  ?></tbody></table></div></div><?php
}
function leros_categories() {
  $categories = get_categories();
  ?>   
  <div class="box">
    <div class="box-header">
      <?php echo __('Categories', 'leros');?>
    </div>
    <div class="box-content">
      <table width="100%" class="feed">
      <tbody>
  <?php
  foreach($categories as $category):
  ?><tr><td><a href="<?php echo get_category_link($category->id)?>"><?php echo $category->name;?></a></td></tr><?php
  endforeach;
  ?></tbody></table></div></div><?php
}

function leros_register_menus() {
  register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu' ),
      'extra-menu' => __( 'Extra Menu' )
    )
  );
  register_post_type('scoop', array(
    'labels' => array(
      'name' => __('Scoops', 'leros'),
      'singular_name' => __('Scoop', 'leros'),
    ),
    'description' => __('', 'leros'),
    'public' => true,
    'menu_position' => 5,
    'supports' => array('title', 'editor'),
    'has_archive' => true
  ));
}
add_action( 'init', 'leros_register_menus' );

add_action( 'customize_register', 'leros_customize_register' ); 

/**
 * Register our sidebars and widgetized areas.
 *
 */
function leros_widgets_init() {

  register_sidebar( array(
    'name'          => 'Extra Sidebar',
    'id'            => 'extra-sidebar',
    'before_widget' => '<div>',
    'after_widget'  => '</div>',
    'before_title'  => '<h2 class="rounded">',
    'after_title'   => '</h2>',
  ) );
  register_widget("Leros_NewsFeed_Widget");

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

// A callback function to add a custom field to our "presenters" taxonomy
function leros_taxonomy_custom_fields($tag, $taxonomy = '') {
   // Check for existing taxonomy meta for the term you're editing
    $t_id = $tag->term_id; // Get the ID of the term you're editing
    $term_meta = get_option( "taxonomy_term_$t_id" ); // Do the check


?>

<tr class="form-field">
  <th scope="row" valign="top">
    <label for="color"><?php _e('Color', 'leros'); ?></label>
  </th>
  <td>
    <input type="text" name="term_meta[color]" id="term_meta[color]" size="25" style="width:60%;" value="<?php echo $term_meta['color'] ? $term_meta['color'] : ''; ?>"><br />
    <span class="description"><?php _e('The Presenter\'s WordPress User ID'); ?></span>
  </td>
</tr>

<?php
}

// Save extra taxonomy fields callback function.
function leros_save_taxonomy_custom_meta( $term_id ) {

  if ( isset( $_POST['term_meta'] ) ) {
    $t_id = $term_id;
    $term_meta = get_option( "taxonomy_$t_id" );
    $cat_keys = array_keys( $_POST['term_meta'] );
    foreach ( $cat_keys as $key ) {
      if ( isset ( $_POST['term_meta'][$key] ) ) {
        $term_meta[$key] = $_POST['term_meta'][$key];
      }
    }
    // Save the option array.
    update_option( "taxonomy_$t_id", $term_meta );

  }
}  
add_action( 'edited_category', 'leros_save_taxonomy_custom_meta');  
add_action( 'create_category', 'leros_save_taxonomy_custom_meta');

add_action( 'category_add_form_fields', 'leros_taxonomy_custom_fields');
add_action( 'category_edit_form_fields', 'leros_taxonomy_custom_fields');