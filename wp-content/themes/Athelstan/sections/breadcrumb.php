<div id="breadcrumb" class="breadcrumb">
    <div class="wrapper-bg" style="background-image: url('<?php echo get_field('background_breadcrumb', 'option')['url'] ?>')"></div>
    <div class="text-center breadcrumb-content">
        <?php if (is_single()): ?>
        <h1 class="breadcrumb-title"><?php echo get_the_title(); ?></h1>
        <div class="single-items">
            <div class="item">
                <i class='bx bx-user-circle' ></i>
                <span><?php $author_id = get_post_field ('post_author', get_the_id()); echo get_the_author_meta( 'display_name' , $author_id); ?></span>
            </div>
            <div class="item">
                <i class='bx bx-calendar' ></i>
                <span><?php echo get_the_date('d') . " tháng " . get_the_date('m') . ", " . get_the_date('Y')  ?></span>
            </div>
            <?php if (get_the_category( $id )[0]->name): ?>
            <div class="item">
                <i class='bx bx-folder-open' ></i>
                <span><?php echo get_the_category( $id )[0]->name; ?></span>
            </div>
            <?php endif; ?>
        </div>
        <?php else: ?>
            <?php
            if(is_tag()):
            ?>
            <?php 
            $id=get_queried_object_id();
            $terms=get_term_by('ID',$id,'post_tag');
            ?>
            <h1 class="breadcrumb-title"><?php echo $terms->name; ?></h1>
            <nav class="page-breadcrumb">
                <a href="<?php echo get_home_url() ?>">Trang chủ</a>
                <span><i class="fa fa-angle-right"></i></span>
                <?php 
                    echo $terms->name;
                ?>
            </nav>
            <?php endif; ?>
            <?php
            if(is_category()):
            $id=get_queried_object_id();
            $terms=get_term_by('ID',$id,'category');
            ?>
            <h1 class="breadcrumb-title"><?php echo $terms->name; ?></h1>
            <nav class="page-breadcrumb">
                <a href="<?php echo get_home_url() ?>">Trang chủ</a>
                <span><i class="fa fa-angle-right"></i></span>
                <?php echo $terms->name; ?>
            </nav>
            <?php endif; ?>
            <?php
            if(is_page()):
            ?>
            <h1 class="breadcrumb-title"><?php echo get_the_title(); ?></h1>
            <nav class="page-breadcrumb">
                <a href="<?php echo get_home_url() ?>">Trang chủ</a>
                <span><i aria-hidden="true" class="fa fa-angle-right"></i></span>
                <?php echo get_the_title(); ?>
            </nav>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>