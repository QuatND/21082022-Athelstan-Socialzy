<section id="team">
    <!-- Our team -->
    <div class="our-team">
        <div class="container">
            <div class="our-team__header">
                <h4 class="section-1-des-welcome wow animate__animated animate__slow animate__fadeInUp"><?php echo get_field('team_title_top', 'option') ?></h4>
                <h4 class="section-1-des-body-heading">
                    <?php echo get_field('team_title', 'option') ?>
                </h4>
                <p class="text">
                    <?php echo get_field('team_excerpt', 'option') ?>
                </p>
            </div>
            <div class="our-team__list-staff row">
                <?php $the_people = get_field('the_people', 'option');
                if ($the_people) :
                foreach ($the_people as $key => $value):
                ?>
                <div class="col-lg-4 col-md-6 col-6 our-team__list-staff--child <?php echo $key > 2 ? 'd-none' : '' ?>">
                    <div class="our-team__list-staff--card">
                        <img src="<?php echo $value['image']['url'] ?>" alt="<?php echo $value['image']['alt'] ?>" />
                        <ul class="our-team__list--icon">
                            <?php $network = $value['network'];
                            if ($network):
                            foreach($network as $val):
                            ?>
                            <li class="our-team__list--icon--item">
                                <a href="<?php echo $val['link'] ?>" class="our-team__list--icon--item--link"><?php echo $val['text'] ?></a>
                            </li>
                            <?php endforeach;
                            endif; ?>
                        </ul>
                        <div class="our-team__list--name">
                            <h4 class="heading"><?php echo $value['name'] ?> </h4>
                            <div class="text"><?php echo $value['position'] ?> </div>
                        </div>
                        <div class="our-team__list-staff__overlay"></div>
                    </div>
                </div>
                <?php endforeach;
                endif; ?>
            </div>
        </div>
    </div>
</section>