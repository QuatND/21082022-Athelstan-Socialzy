<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>
    <script>
        var url_home="<?php echo get_home_url(); ?>";
        var url_template="<?php echo get_template_directory_uri(); ?>";
    </script>
</head>

<body <?php body_class(); ?>>
