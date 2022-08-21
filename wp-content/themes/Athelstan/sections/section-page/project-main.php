<section id="project">
    <div class="project">
        <div class="container">
            <div class="project__header">
                <div class="project__header--welcome">
                    <h4 class="section-1-des-welcome"><?php echo get_field('project_title_top', 50) ?></h4>
                </div>
                <div class="project__header--heading">
                    <h4 class="section-1-des-body-heading"><?php echo get_field('project_title', 50) ?></h4>
                </div>
                <div class="project__header--text">
                    <p class="text">
                        <?php echo get_field('project_excerpt', 50) ?>
                    </p>
                </div>
            </div>
            <div class="project__body row">
                <?php
                $the_projects = get_field('the_projects', 50);
                if ($the_projects) :
                    foreach ($the_projects as $key => $value) :
                ?>
                        <div class="project__body--item col-lg-4 col-sm-6 col-12 wow animate__animated animate__slow animate__fadeInUp <?php echo $key > 2 ? 'd-none' : '' ?>">
                            <div class="project__body--item--child">
                                <img src="<?php echo $value['image']['url'] ?>" alt="<?php echo $value['image']['alt'] ?>" />
                                <div class="project__body--item--child--content">
                                    <h4 class="heading"><?php echo $value['title'] ?></h4>
                                    <p class="text">
                                        <?php echo $value['content'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                <?php endforeach;
                endif; ?>
            </div>
            <div class="project-team">
                <p><?php echo get_field('project_excerpt', 2) ?></p>
                <a href="<?php echo get_field('project_link_button', 2) ?>" class="btn btn-custom not-flex"><?php echo get_field('project_text_button', 2) ?></a>
            </div>
        </div>
    </div>
</section>