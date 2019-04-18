<?php
/**
 * Master Blog Theme Customizer
 *
 * @package Master Blog
 */

$master_blog_sections = array( 'info' );

foreach( $master_blog_sections as $s ){
    require get_template_directory() . '/lib/customizer/' . $s . '.php';
}

function master_blog_customizer_scripts() {
    wp_enqueue_style( 'master-blog-customize',get_template_directory_uri().'/lib/customizer/css/customize.css', '', 'screen' );
    wp_enqueue_script( 'master-blog-customize', get_template_directory_uri() . '/lib/customizer/js/customize.js', array( 'jquery' ), '20170404', true );
}
add_action( 'customize_controls_enqueue_scripts', 'master_blog_customizer_scripts' );
