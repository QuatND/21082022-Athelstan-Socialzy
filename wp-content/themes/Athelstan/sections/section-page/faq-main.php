<section id="faq">
    <div class="advice-question">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-12 advice-question__content ScrollMagic">
                    <?php $faq_items = get_field('the_faq',get_the_id());
                    if ($faq_items):
                    foreach($faq_items as $number => $value):
                    ?>
                    <div class="faq-item">
                        <div class="advice-question__content--heading">
                            <?php if ($value['faq_title_top']): ?>
                            <h4 class="section-1-des-welcome"><?php echo $value['faq_title_top']; ?></h4>
                            <?php endif; ?>
                            <h4 class="section-1-des-body-heading <?php echo $number > 0 ? 'fs-24' : ''; ?>"><?php echo $value['faq_title']; ?></h4>
                            <p class="text">
                                <?php echo $value['faq_excerpt']; ?>
                            </p>
                        </div>
                        <ul class="advice-question__content--list">
                        <?php
                        $the_faqs = $value['the_faqs'];
                        if ($the_faqs) :
                        foreach ($the_faqs as $key => $value) :
                        ?>
                            <li class="advice-question__content--list--item adviceQuestion">
                                <a href="#itemQuestion_<?php echo $number.'_'.$key ?>" class="advice-question__content--list--item--link">
                                    <h4 class="heading">
                                        <?php echo $value['question'] ?>
                                        <i class="bx bx-chevron-down advice-question__icon--down"></i>
                                        <i class="bx bx-chevron-up advice-question__icon--top"></i>
                                    </h4>
                                </a>
                                <p class="text" id="itemQuestion_<?php echo $number.'_'.$key ?>" style="display: none">
                                    <?php echo $value['answer'] ?>
                                </p>
                            </li>
                        <?php endforeach;
                        endif; ?>
                        </ul>
                    </div>
                    <?php endforeach;endif; ?>
                </div>
                <div class="col-lg-4 col-md-12 col-12 advice-question__contact">
                    <div class="position widget_scroll">
                        <div class="elementor-background-overlay" style="background-image: url('<?php echo get_template_directory_uri() ?>/images/background-2.webp')"></div>
                        <div class="wrapper">
                            <?php $faq_contact = get_field('faq_contact', 46); ?>
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