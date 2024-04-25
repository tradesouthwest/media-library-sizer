<?php
/**
 * Prevent direct access to the file.
 * @subpackage media_library_sizer/inc/media_library_sizer-theme-admin.php
 * @since 1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Media Library Sizer Options Page
 *
 * Add options page for the plugin.
 *
 * @since 1.0
 */
function media_library_sizer_custom_plugin_page() {

	add_options_page(
		__( 'Media Library Sizer Options', 'media-library-sizer' ),
		__( 'Media Sizer Editor', 'media-library-sizer' ),
		'manage_options',
		'media_library_sizer',
		'media_library_sizer_render_admin_page'
	);

}
add_action( 'admin_menu', 'media_library_sizer_custom_plugin_page' );
add_action( 'admin_init', 'media_library_sizer_register_admin_options' ); 
/**
 * Register settings for options page
 *
 * @since    1.0.0
 * 
 * a.) register all settings groups
 * Register Settings $option_group, $option_name, $sanitize_callback 
 */
function media_library_sizer_register_admin_options() 
{
    
    register_setting( 'media_library_sizer_options', 'media_library_sizer_options' );
        
    //add a section to admin page
    add_settings_section(
        'media_library_sizer_options_settings_section',
        '',
        'media_library_sizer_options_settings_section_callback',
        'media_library_sizer_options'
    );
    add_settings_field(
        'media_library_sizer_print_styles',
        __( 'Style Editor', 'media-library-sizer' ),
        'media_library_sizer_print_styles_cb',
        'media_library_sizer_options',
        'media_library_sizer_options_settings_section',
        array( 
            'type'        => 'text',
            'option_name' => 'media_library_sizer_options', 
            'name'        => 'media_library_sizer_print_styles',
            'value'       => ( empty( get_option('media_library_sizer_options')['media_library_sizer_print_styles'] )) 
                            ? false : get_option('media_library_sizer_options')['media_library_sizer_print_styles'],
            'default'     => '',
            'description' => esc_html__( 'Enter styles. Please validate', 'media-library-sizer' ),
            'tip'         => esc_attr__( 'Be sure to check your styles', 'media-library-sizer' )
        ) 
    );    
    add_settings_field(
        'media_library_sizer_priority_order',
        __( 'Style Editor', 'media-library-sizer' ),
        'media_library_sizer_priority_order_cb',
        'media_library_sizer_options',
        'media_library_sizer_options_settings_section',
        array( 
            'type'        => 'number',
            'option_name' => 'media_library_sizer_options', 
            'name'        => 'media_library_sizer_priority_order',
            'value'       => ( empty( get_option('media_library_sizer_options')['media_library_sizer_priority_order'] )) 
                            ? absint( 10 ) : get_option('media_library_sizer_options')['media_library_sizer_priority_order'],
            'default'     => '',
            'description' => esc_html__( 'Enter Priority of this styles script', 'media-library-sizer' ),
            'tip'         => esc_attr__( '10 is default and should allow styles to show last in the head. Raise number to 11 or 12 if your styles are not taking.', 'media-library-sizer' )  
        ) 
    );    
    // settings checkbox 
    add_settings_field(
        'media_library_sizer_styles_radio',
        __('Activate Styles', 'media-library-sizer'),
        'media_library_sizer_styles_radio_cb',
        'media_library_sizer_options',
        'media_library_sizer_options_settings_section',
        array( 
            'type'        => 'checkbox',
            'option_name' => 'media_library_sizer_options', 
            'name'        => 'media_library_sizer_styles_radio',
            'value'       => (!isset( get_option('media_library_sizer_options')['media_library_sizer_styles_radio']))
                                ? 0 : get_option('media_library_sizer_options')['media_library_sizer_styles_radio'],
	    'checked' => (!isset( get_option('media_library_sizer_options')['media_library_sizer_styles_radio']))
                            ? '' : 'checked',
            'description' => esc_html__( 'Check to use styles. Uncheck to disable.', 'media-library-sizer' ),
            'tip'         => esc_attr__( 'Default is OFF. Check to continue using styles. Only effects admin pages.', 'media-library-sizer' )  
        )
    ); 
    // settings checkbox 
    add_settings_field(
        'media_library_sizer_debug_radio',
        __('Activate Debug', 'media-library-sizer'),
        'media_library_sizer_debug_radio_cb',
        'media_library_sizer_options',
        'media_library_sizer_options_settings_section',
        array( 
            'type'        => 'checkbox',
            'option_name' => 'media_library_sizer_options', 
            'name'        => 'media_library_sizer_debug_radio',
            'value'       => (!isset( get_option('media_library_sizer_options')['media_library_sizer_debug_radio']))
                                ? 0 : get_option('media_library_sizer_options')['media_library_sizer_debug_radio'],
            'checked'     => (!isset( get_option('media_library_sizer_options')['media_library_sizer_debug_radio']))
                                ? '' : 'checked',
            'description' => esc_html__( 'Check to use debug. Uncheck to disable.', 'media-library-sizer' ),
            'tip'         => esc_attr__( 'Default is OFF. Used to start new debug functions.', 'media-library-sizer' )  
        )
    ); 
}

/** 
 * render for '0' field
 * @since 1.0.0
 */
function media_library_sizer_print_styles_cb($args)
{  
    printf(
    '<fieldset><b class="grctip" data-title="%5$s">?</b><sup></sup>
    <p><span class="vmarg">%4$s </span></p>
    <textarea id="%1$s" class="widefat textarea media_library_sizer-textarea" name="%2$s[%1$s]" cols="40" rows="5">%3$s</textarea><br>
    </fieldset><p>Try: .media-frame-content[data-columns="10"] .attachment {
        width: 8.25&#37; ; }</p>',
        $args['name'],
        $args['option_name'],
        $args['value'],
        $args['description'],
        $args['tip']
    );
}
/** 
 * render for '0' field
 * @since 1.0.0
 */
function media_library_sizer_priority_order_cb($args)
{  
    printf(
    '<fieldset><b class="grctip" data-title="%5$s">?</b><sup></sup>
    <p><span class="vmarg">%4$s </span></p>
    <input id="%1$s" class="text-field" name="%2$s[%1$s]" type="%6$s" value="%3$s"/>
    </fieldset>',
        $args['name'],
        $args['option_name'],
        $args['value'],
        $args['description'],
        $args['tip'],
        $args['type']
    );
}
/** 
 * switch for 'allow styles' field
 * @since 1.0.1
 * @input type checkbox
 */
function media_library_sizer_styles_radio_cb($args)
{ 
     printf(
        '<fieldset><b class="grctip" data-title="%6$s">?</b><sup></sup>
        <input type="hidden" name="%3$s[%1$s]" value="0">
        <input id="%1$s" type="%2$s" name="%3$s[%1$s]" value="1"  
        class="regular-checkbox" %7$s /><br>
        <span class="vmarg">%5$s </span> v=%4$s</fieldset>',
            $args['name'],
            $args['type'],
            $args['option_name'],
            $args['value'],
            $args['description'],
            $args['tip'],
            $args['checked']
        );
}   

/** 
 * switch for 'allow debug' field
 * @since 1.0.1
 * @input type checkbox
 */
function media_library_sizer_debug_radio_cb($args)
{ 
     printf(
        '<fieldset><b class="grctip" data-title="%6$s">?</b><sup></sup>
        <input type="hidden" name="%3$s[%1$s]" value="0">
        <input id="%1$s" type="%2$s" name="%3$s[%1$s]" value="1"  
        class="regular-checkbox" %7$s /><br>
        <span class="vmarg">%5$s </span> v=%4$s</fieldset>',
            $args['name'],
            $args['type'],
            $args['option_name'],
            $args['value'],
            $args['description'],
            $args['tip'],
            $args['checked']
        );
}   

//callback for description of options section
function media_library_sizer_options_settings_section_callback() 
{
	echo '<h2>' . esc_html__( 'Admin Styles Editor', 'media-library-sizer' ) . '</h2>';
}
// display the plugin settings page
function media_library_sizer_render_admin_page()
{
	// check if user is allowed access
    if ( ! current_user_can( 'manage_options' ) ) return;
    
	print( '<form action="options.php" method="post">' );

	// output security fields
	settings_fields( 'media_library_sizer_options' );

	// output setting sections
	do_settings_sections( 'media_library_sizer_options' );
	submit_button();

print( '</form>' ); 

printf( '<p>%s <a href="%s" target="_blank" title="%s">%s</a> <img src="%s" title="opens in new tab" alt="opens in new tab" height="14" /></p>',
esc_html__( 'To validate your work visit', 'media-library-sizer' ),
esc_url( 'http://www.css-validator.org/' ),
esc_attr__( 'css-validator.org', 'media-library-sizer' ),
esc_html__( 'css-validator.org', 'media-library-sizer' ),
esc_url( MEDIA_LIBRARY_SIZER_URL . 'inc/external-link.png' )
);
	
}
