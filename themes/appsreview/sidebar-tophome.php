<div id="top_content">
    <div class="wrapper">
        <?php //include 'logo-banner.php'; ?>
        <div class="top-stories">
            <?php
            $loop = new WP_Query(array(
                'post_type' => array('post', 'apps'),
                'posts_per_page' => 7,
                'meta_query' => array(
                    array(
                        'key' => 'is_most',
                        'value' => '1',
                    )
                ),
            ));
            if($loop->post_count > 0):
            $counter = 1;
            while($loop->have_posts()) : $loop->the_post();
            if($counter == 1):
            ?>
            <div class="group1">
                <div class="thumb">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                        <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=460&h=460"/>
                    </a>
                </div>
                <h1 class="title">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                </h1>
            </div>
            <div class="group2">
                <?php elseif($counter == 2 || $counter == 3): ?>
                <div class="group2-item mb20">
                    <div class="thumb">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                            <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=220&h=220" />
                        </a>
                    </div>
                    <h3 class="title">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                    </h3>
                </div>
                <?php elseif($counter == 4): ?>
                <div class="group2-item mr0 mb20">
                    <div class="thumb">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                            <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=220&h=220" />
                        </a>
                    </div>
                    <h3 class="title">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                    </h3>
                </div>
                <?php elseif($counter == 7): ?>
                <div class="group2-item mr0">
                    <div class="thumb">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                            <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=220&h=220" />
                        </a>
                    </div>
                    <h3 class="title">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                    </h3>
                </div>
                <?php else: ?>
                <div class="group2-item">
                    <div class="thumb">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                            <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=220&h=220" />
                        </a>
                    </div>
                    <h3 class="title">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                    </h3>
                </div>
                <?php endif; ?>
                <?php $counter++; endwhile;?>
                <?php wp_reset_query(); ?>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <?php endif; ?>
        </div>
        <!--/.top-stories-->
    </div>
</div>
<!--/#top_content-->