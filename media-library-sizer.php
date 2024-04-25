<?php
/**
 * Plugin Name:       Media Library Sizer
 * Plugin URI:        http://themes.tradesouthwest.com/wordpress/plugins/
 * Description:       Admin pages editor for dev. Opens in Settings > GrandChild Editor
 * Author:            tradesouthwestgmailcom
 * Author URI:        https://tradesouthwest.com
 * Version:           1.0.0
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Requires at least: 4.5
 * Tested up to:      6.5.0
 * Requires PHP:      5.4
 * Text Domain:       media-library-sizer
 * Domain Path:       /languages
*/

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {	exit; }
/** 
 * Constants
 * 
 * @param MEDIA_LIBRARY_SIZER_VER         Using bumped ver.
 * @param MEDIA_LIBRARY_SIZER_URL         Base path
 * @since 1.0.0 
 */
if( !defined( 'MEDIA_LIBRARY_SIZER_VER' )) { define( 'MEDIA_LIBRARY_SIZER_VER', '1.0.01' ); }
if( !defined( 'MEDIA_LIBRARY_SIZER_URL' )) { define( 'MEDIA_LIBRARY_SIZER_URL', 
    plugin_dir_url(__FILE__)); }

    // Start the plugin when it is loaded.
    register_activation_hook(   __FILE__, 'media_library_sizer_activation' );
    register_deactivation_hook( __FILE__, 'media_library_sizer_deactivation' );
  
/**
 * Activate/deactivate hooks
 * 
 */
function media_library_sizer_activation() 
{

    return false;
}
function media_library_sizer_deactivation() 
{
    return false;
}
/**
 * Define the locale for this plugin for internationalization.
 * Set the domain and register the hook with WordPress.
 *
 * @uses slug `swedest`
 */
add_action( 'plugins_loaded', 'media_library_sizer_load_plugin_textdomain' );

function media_library_sizer_load_plugin_textdomain() 
{

    $plugin_dir = basename( dirname(__FILE__) ) .'/languages';
                  load_plugin_textdomain( 'media-library-sizer', false, $plugin_dir );
}

/** 
 * Admin side specific
 *
 * Enqueue admin only scripts 
 */ 
add_action( 'admin_enqueue_scripts', 'media_library_sizer_load_admin_scripts' );   
function media_library_sizer_load_admin_scripts() 
{
    /*
     * Enqueue styles */
    wp_enqueue_style( 'media-library-sizer-admin', 
                        MEDIA_LIBRARY_SIZER_URL . 'css/media-library-sizer-admin.css', 
                        array(), 
                        MEDIA_LIBRARY_SIZER_VER, 
                        false 
    );
    wp_register_script( 'js-code-editor', plugin_dir_url( __FILE__ ) 
    . 'js/js-code-editor.js', array( 'jquery' ), '', true );

    // Put scripts to head or footer.
    wp_enqueue_script( 'js-code-editor');
    wp_enqueue_code_editor( array( 'type' => 'text/html' ) );
}

require_once ( plugin_dir_path(__FILE__) . 'inc/media-library-sizer-theme-admin.php' );
require_once ( plugin_dir_path(__FILE__) . 'inc/media-library-sizer-styles-functions.php' );
?>