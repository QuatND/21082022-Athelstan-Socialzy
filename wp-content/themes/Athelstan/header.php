<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <!-- <link rel="preload" href="<?php echo get_template_directory_uri() ?>/fonts/Barlow-Regular.woff" as="font" type="font/woff" crossorigin>
    <link rel="preload" href="<?php echo get_template_directory_uri() ?>/fonts/Barlow-Medium.woff" as="font" type="font/woff" crossorigin>
    <link rel="preload" href="<?php echo get_template_directory_uri() ?>/fonts/font-icon/fontawesome-webfont.woff2" as="font" type="font/woff2" crossorigin> -->
    <?php wp_head(); ?>
    <script>
        var url_home="<?php echo get_home_url(); ?>";
        var url_template="<?php echo get_template_directory_uri(); ?>";
    </script>
    <?php echo get_field('script_header','option') ?>
</head>
<body <?php body_class(); ?>>
<?php echo get_field('script_body','option') ?>
