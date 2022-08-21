<?php

/**
 * Template Name: Dịch vụ
 */
get_header();
get_template_part('sections/header-main');
get_template_part('sections/breadcrumb');
get_template_part('sections/service-main');
?>
<section id="appointment">
    <!-- Advice marketing -->
    <div class="advice-marketing">
        <div class="advice-marketing__overlay"></div>
        <div class="container">
            <div class="row advice-marketing--child">
                <div class="col-lg-6 col-md-12 col-12">
                    <?php
                    $title_submit = __('Đặt lịch ngay', 'athelstan_theme');
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
                    advanced_form('form_62ffab743370f', $args);
                    ?>
                </div>
                <div class="col-lg-6 col-md-12 col-12 align-self-center advice-marketing__desc">
                    <div class="advice-marketing__desc--header">
                        <h4 class="welcome section-1-des-welcome wow animate__animated animate__slow animate__fadeInRight"><?php echo get_field('appointment_title_top', get_the_id()) ?></h4>
                        <h4 class="section-1-des-body-heading"><?php echo get_field('appointment_title', get_the_id()) ?></h4>
                        <p class="text">
                            <?php echo get_field('appointment_excerpt', get_the_id()) ?>
                        </p>
                    </div>
                    <div class="advice-marketing__desc--advice">
                        <ul class="advice-marketing__desc--advice--list row">
                            <?php
                            $appointment_values = get_field('appointment_values', get_the_id());
                            if ($appointment_values) :
                                foreach ($appointment_values as $value) :
                            ?>
                                    <li class="advice-marketing__desc--advice--list--item col-lg-6 col-md-6 col-12">
                                        <div class="">
                                            <i class="bx bx-check"></i>
                                            <span class="text"><?php echo $value['text'] ?></span>
                                        </div>
                                    </li>
                            <?php endforeach;
                            endif; ?>
                        </ul>
                    </div>
                    <div class="advice-marketing__desc--address row">
                        <?php
                        $appointment_contacts = get_field('appointment_contacts', get_the_id());
                        if ($appointment_contacts) :
                            foreach ($appointment_contacts as $value) :
                        ?>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="advice-marketing__desc--address--personal">
                                        <span class="heading"><?php echo $value['text'] ?></span>
                                        <span class="text"><?php echo $value['content'] ?></span>
                                    </div>
                                </div>
                        <?php endforeach;
                        endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php 
get_template_part('sections/section-page/process-main');
get_template_part('sections/testimonials-main');
?>
<section id="faq">
    <div class="advice-question">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-12 advice-question__content">
                    <div>
                        <div class="advice-question__content--heading">
                            <h4 class="section-1-des-welcome wow animate__animated animate__slow animate__fadeInLeft"><?php echo get_field('faq_title_top', get_the_id()) ?></h4>
                            <h4 class="section-1-des-body-heading"><?php echo get_field('faq_title', get_the_id()) ?></h4>
                            <p class="text">
                                <?php echo get_field('faq_excerpt', get_the_id()) ?>
                            </p>
                        </div>
                        <ul class="advice-question__content--list">
                        <?php
                        $the_faqs = get_field('the_faqs', get_the_id());
                        if ($the_faqs) :
                        foreach ($the_faqs as $key => $value) :
                        ?>
                            <li class="advice-question__content--list--item adviceQuestion">
                                <a href="#itemQuestion_<?php echo $key ?>" class="advice-question__content--list--item--link">
                                    <h4 class="heading">
                                        <?php echo $value['question'] ?>
                                        <i class="bx bx-chevron-down advice-question__icon--down"></i>
                                        <i class="bx bx-chevron-up advice-question__icon--top"></i>
                                    </h4>
                                </a>
                                <p class="text" id="itemQuestion_<?php echo $key ?>" style="display: none">
                                    <?php echo $value['answer'] ?>
                                </p>
                            </li>
                        <?php endforeach;
                        endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-12 advice-question__contact">
                    <div class="position">
                        <div class="elementor-background-overlay" style="background-image: url('<?php echo get_template_directory_uri() ?>/images/background-2.webp')"></div>
                        <div class="wrapper">
                            <?php $faq_contact = get_field('faq_contact', get_the_id()); ?>
                            <div class="title"><?php echo $faq_contact['title'] ?></div>
                            <div class="content"><?php echo $faq_contact['content'] ?></div>
                            <a href="<?php echo $faq_contact['link_button'] ?>" class="btn btn-custom not-flex"><?php echo $faq_contact['text_button'] ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
get_footer();
?>