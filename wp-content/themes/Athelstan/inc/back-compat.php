<?php
/*
 *  ENQUEUE SCRIPTS
 */

function theme_enqueue_script() {
    // Initialize variables
    $script_handle = 'wp-script';
    // Register project js files
    $js_files = glob(THEME_DIR.'/js/*.js');
    foreach ( $js_files as $file ) {
        $handle = $script_handle. '-' .basename($file, '.js');
        wp_enqueue_script($handle, THEME_URL.'/js/'.basename($file), array('jquery'),'1.0.0',true);
    }
}
add_action('wp_enqueue_scripts', 'theme_enqueue_script');

/*
 *  ENQUEUE STYLES
 */

function theme_enqueue_styles(){
    // Initialize variables
    $script_handle = 'wp-style';
    // Register main styles and other if defined
    $css_files = glob(THEME_DIR.'/css/*.css');
    foreach ($css_files as $file) {
        $handle = $script_handle. '-' .basename($file, '.css');
        wp_enqueue_style($handle,THEME_URL.'/css/'.basename($file),array(),'1.0.0');
    }
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
