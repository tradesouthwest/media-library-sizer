<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) 	exit;
/**
 * Plugin Scripts
 * @subpackage media_library_sizer/inc/media-library-sizer-styles-functions
 * 
 * Register and Enqueues public side styles -if used
 *
 * @since 1.0.0
 */

/**
 * Option to add a priority position of styles in head order.
 * @since 1.0.0
 * @param string $priory Priority order from plugin options
 * 
 */
function media_library_sizer_get_position()
{

    $priory = '';
    $priory = ( empty( get_option('media_library_sizer_options')['media_library_sizer_priority_order'] )) 
    ? absint( 10 ) : get_option('media_library_sizer_options')['media_library_sizer_priority_order'];

        return absint( $priory );
}

// A1
add_action( 'admin_head', 'media_library_sizer_use_admin_styles' );
 //A2
add_action('admin_init', 'media_library_sizer_turn_on_debug' );
//add_action( 'wp_enqueue_scripts', 'media_library_sizer_plugin_public_scripts' ); 

function media_library_sizer_plugin_public_scripts() 
{
    /*
     * Register Styles */
    // The plugin stylesheet 
    wp_enqueue_style( 'media-library-sizer-theme', 
                    MEDIA_LIBRARY_SIZER_URL . 'css/media-library-sizer-theme.css', 
                        array(), MEDIA_LIBRARY_SIZER_VER, 
                        false 
                    );
}

/** #A1
 * Put scripts in the head.
 * @since 1.0.0
 * @param wp_unslash   Remove slashes from a string or array of strings.
 */

function media_library_sizer_use_admin_styles()
{ 
    $output     = '';
    $html_toget = '';
    $default = '';
    $html_toget = ( empty( get_option('media_library_sizer_options')['media_library_sizer_print_styles'])) 
    ? $default : get_option('media_library_sizer_options')['media_library_sizer_print_styles'];

    $opt_styles = (isset( get_option('media_library_sizer_options')['media_library_sizer_styles_radio']))
                    ? 1 : 0;
    
    if( $html_toget ) {
        $output .= '<style type="text/css" id="media-library-sizer-styles">';
    if( $opt_styles == "1" ) : 
        $output .= wp_unslash( $html_toget );
    endif;
        $output .= '</style> ';
    } 
    
    print( $output );

}

/** #A2
 * Proper ob_end_flush() for all levels
 *
 * This replaces the WordPress `wp_ob_end_flush_all()` function
 * with a replacement that doesn't cause PHP notices.
 */

function media_library_sizer_turn_on_debug(){
    $mlsdebug = (empty(get_option('media_library_sizer_options')['media_library_sizer_debug_radio']))
            ? 0 : get_option('media_library_sizer_options')['media_library_sizer_debug_radio'];
    if ( 1 == ( $mlsdebug )) : 
        if (defined('WP_DEBUG') && true === WP_DEBUG) :
            remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );
            add_action( 'shutdown', function() {
                    while ( @ob_end_flush() );
                } 
            );
        endif;
    endif;
        return false;
}