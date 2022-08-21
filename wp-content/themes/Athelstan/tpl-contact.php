<?php
/**
 * Template Name: Liên hệ
 */
get_header();
get_template_part('sections/header-main');
get_template_part('sections/breadcrumb');
?>
<section id="contact-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 align-self-center">
                <div class="info">
                    <div class="section-1-des-welcome wow animate__animated animate__slow animate__fadeInLeft"><?php echo get_field('contact_title_top', get_the_id()) ?></div>
                    <div class="section-1-des-body-heading"><?php echo get_field('contact_title', get_the_id()) ?></div>
                    <div class="text"><?php echo get_field('contact_excerpt', get_the_id()) ?></div>
                </div>
                <div class="contacts">
                    <?php $contacts = get_field('the_contact', get_the_id()); 
                    if($contacts):
                    foreach($contacts as $value):
                    ?>
                    <div class="contact">
                        <div class="icon"><?php echo $value['icon'] ?></div>
                        <div class="text">
                            <p class="title"><?php echo $value['title'] ?></p>
                            <p class="content"><?php echo $value['content'] ?></p>
                        </div>
                    </div>
                    <?php endforeach;endif; ?>
                </div>
                <div class="network">
                    <div class="text"><?php echo get_field('text_network', get_the_id()); ?></div>
                    <div class="socials">
                        <?php $socials = get_field('footer_contact_socials', 'option');
                        if (count($socials)):
                        foreach($socials as $social):
                        ?>
                        <a href="<?php echo $social['link'] ?>" class="item">
                            <?php echo $social['icon']; ?>
                        </a>
                        <?php endforeach;endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
            <?php
                $title_submit=__('Gửi liên hệ','athelstan_theme');
                $args = array(
                    'display_title' => false,
                    'display_description' => false,
                    'submit_text' => $title_submit,
                    'echo' => true,
                    'values' => array(),
                    'exclude_fields' => array(),
                    'uploader' => 'wp',
                    'filter_mode' => false,
                    'instruction_placement' => 'label',
                    'honeypot' => true,
                );
                advanced_form('form_63004fcdcdf21', $args );
            ?>
            </div>
        </div>
    </div>
</section>
<section id="contact-iframe">
    <div class="wrapper">
        <?php echo get_field('contact_iframe', get_the_id()) ?>
    </div>
</section>
<?php
get_footer();
?>