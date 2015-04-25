<?php
$post_types = array(
    'post' => array(
        'meta_fields' => array(
            'facts' => array(
                'title' => 'Facts',
                'type' => 'text'
            ),
            'live_duration' => array(
                'title' => __('Live duration', 'leros'),
                'type' => 'number'
            )
        )
    ),
    'scoop' => array(
        'meta_fields' => array(
            'priority' => array(
                'title' => 'Priority',
                'type' => 'number'
            ),
            'color' => array(
                'title' => 'Color',
            ),
            'tag' => array(
                'title' => 'tag',

            )

        )
    )
);
/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function leros_meta_box_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'leros_meta_box', 'leros_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    
    $post_type = get_post_type($post->ID);
    
    global $post_types;
    $meta_fields = $post_types[$post_type]['meta_fields'];
    foreach($meta_fields as $k => $v) {

        $value = get_post_meta( $post->ID, 'leros_' . $k, true );


        echo '<label for="leros_' . $k . '">';
        _e( $v['title'], 'leros' );
        echo '</label><br> ';
        if ($v['type'] == 'text'):
            wp_editor(htmlspecialchars_decode($value), 'leros_' . $k, $settings = array('textarea_name' => 'leros_' . $k));    
        else:
            echo '<input type="text" id="leros_' . $k . '" name="leros_' . $k . '" value="' . esc_attr( $value ) . '" size="25" /><br>';
        endif;
        if ($v['type'] == 'image'):
            echo '<input type="button" id="leros_image_btn_' . $k . '" class="button" value="Choose or upload an image">';
            ?>
        <script>
            jQuery(document).ready(function($){

            // Instantiates the variable that holds the media library frame.
            var meta_image_frame;

            // Runs when the image button is clicked.
            $('#leros_image_btn_<?php echo $k ?>').click(function(e) {

                // Prevents the default action from occuring.
                e.preventDefault();

                // If the frame already exists, re-open it.
                if ( meta_image_frame ) {
                    wp.media.editor.open();
                    return;
                }

                // Sets up the media library frame
                meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
                    title: 'Title',
                    button: { text:  'text' },
                    library: { type: 'image' }
                });

                // Runs when an image is selected.
                meta_image_frame.on('select', function(e){

                    // Grabs the attachment selection and creates a JSON representation of the model.
                    var media_attachment = meta_image_frame.state().get('selection').first().toJSON();

                    // Sends the attachment URL to our custom image input field.
                    $('#leros_<?php echo $k?>').val(media_attachment.url);

                    return false;

                });

                // Opens the media library frame.
                meta_image_frame.open();
            });
        });
</script><?php
        endif;
    }
}

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function leros_add_meta_box() {

    $screens = array( 'post', 'scoop' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'leros_tour',
            __( 'Details', 'leros' ),
            'leros_meta_box_callback',
            $screen
        );
    }
}

add_action( 'add_meta_boxes', 'leros_add_meta_box' );
/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function leros_save_meta_box_data( $post_id ) {
    global $meta_fields;
    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['leros_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['leros_meta_box_nonce'], 'leros_meta_box' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    $post_type = $_POST['post_type'];



    /* OK, it's safe for us to save the data now. */
    
    global $post_types;
    $meta_fields = $post_types[$post_type]['meta_fields'];
    foreach($meta_fields as $k => $v) {
        if (isset($_POST['leros_' . $k])) {
            $value = get_post_meta( $post->ID, 'leros_' . $k, true );

            $my_data = sanitize_text_field( $_POST['leros_' . $k] );
            update_post_meta( $post_id, 'leros_' . $k, $my_data );
        }

    }
    // Sanitize user input.

    // Update the meta field in the database.
}
add_action( 'save_post', 'leros_save_meta_box_data' );