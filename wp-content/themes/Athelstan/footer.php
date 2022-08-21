<footer id="footer" class="site-footer">
    <div class="elementor-background-overlay" style="background-image: url('<?php echo get_field('footer_background', 'option')['url'] ?>')"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-12 col-md-6 info">
                <div class="info-bg">
                    <a href="<?php echo home_url(); ?>"><img class="logo" width="100" height="100" src="<?php echo get_field('footer_info_logo', 'option')['url'] ?>" alt="<?php echo get_field('footer_info_logo', 'option')['alt'] ?>"></a>
                    <?php if (is_home()) : ?>
                        <h1 class="title-footer fs-18 text-white"><?php echo get_field('title_footer', 'option'); ?></h1>
                    <?php else : ?>
                        <p class="title-footer fs-18 text-white"><?php echo get_field('title_footer', 'option'); ?></p>
                    <?php endif; ?>
                    <div class="connect">
                        <?php $connect = get_field('footer_contacts', 'option');
                        if ($connect) :
                        foreach ($connect as $cnt) :
                        ?>
                        <div class="connect-item">
                            <span><?php echo $cnt['icon'] ?></span>
                            <span><?php echo $cnt['text'] ?></span>
                        </div>
                        <?php endforeach;
                        endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-12 col-md-6 info">
                <div class="title-footer"><?php echo get_field('footer_tab_one_title', 'option') ?></div>
                <ul>
                    <?php $tab_one = get_field('footer_tab_one_links', 'option');
                    if ($tab_one && count($tab_one) > 0):
                    foreach($tab_one as $tab):
                    ?>
                    <li>
                        <a href="<?php echo $tab['link'] ?>">
                            <span class="list-icon">
							    <i aria-hidden="true" class="fa fa-angle-right"></i>
                            </span>
                            <?php echo $tab['title'] ?>
                        </a>
                    </li>
                    <?php endforeach;endif; ?>
                </ul>
            </div>
            <div class="col-lg-2 col-12 col-md-6 info">
                <div class="title-footer"><?php echo get_field('footer_tab_one_title', 'option') ?></div>
                <ul>
                    <?php $tab_two = get_field('footer_tab_two_links', 'option');
                    if ($tab_two && count($tab_two) > 0):
                    foreach($tab_two as $tab):
                    ?>
                    <li>
                        <a href="<?php echo $tab['link'] ?>">
                            <span class="list-icon">
							    <i aria-hidden="true" class="fa fa-angle-right"></i>
                            </span>
                            <?php echo $tab['title'] ?>
                        </a>
                    </li>
                    <?php endforeach;endif; ?>
                </ul>
            </div>
            <div class="col-lg-4 col-12 col-md-6 info">
                <div class="title-footer"><?php echo get_field('footer_contact_title', 'option') ?></div>
                <?php
                $title_submit=__('Đăng ký','athelstan_theme');
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
                advanced_form('form_62fa4788cc5a5', $args );
                ?>
                <div class="excerpt-footer"><?php echo get_field('footer_contact_text', 'option') ?></div>
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
    </div>
    <?php wp_footer(); ?>
</footer>
<section>
    <div class="modal fade in" id="video-modal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
            <div class="modal-content">
                <div class="modal-body">
                    <iframe width="100" height="100" src="" allowfullscreen="" class="embed-responsive-item lazyloaded"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="af-close-side"></div>
</section>

</body>

</html>