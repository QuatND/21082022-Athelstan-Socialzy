<?php
define('THEME_DIR', get_stylesheet_directory());
define('THEME_URL', get_stylesheet_directory_uri());

$file_includes = [
    'inc/back-compat.php',
    'inc/setup.php',
    'inc/custom-field.php',
    'inc/woo-functions.php',
];
foreach ($file_includes as $file) {
    if (!$filePath = locate_template($file)) {
        trigger_error(sprintf(__('Missing included file'), $file), E_USER_ERROR);
    }
    require_once $filePath;
}