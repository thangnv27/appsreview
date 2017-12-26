<?php get_header(); ?>

<?php get_sidebar('tophome'); ?>

<div class="wrapper">
    <div class="main-content">
        <div class="tabs-news">
            <?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
            <ul>
                <li><a href="#tab-news">Tin tức</a></li>
                <li class="ml10 mr10">|</li>
                <li><a href="#tab-apps">Ứng dụng</a></li>
            </ul>
            <div id="tab-news" class="tab-news">
                <?php
                $loop1 = new WP_Query(array(
                    'post_type' => 'post',
                    'paged' => $paged,
                    'meta_query' => array(
                        'relation' => 'OR',
                        array(
                            'key' => 'is_most',
                            'value' => '0',
                        ),
                        array(
                            'key' => 'is_most',
                            'value' => '',
                            'compare' => 'NOT EXISTS',
                        )
                    ),
                ));
                if($loop1->post_count > 0):
                while($loop1->have_posts()) : $loop1->the_post(); 
                ?>
                <div class="item">
                    <div class="thumb">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                            <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=220&h=220" />
                        </a>
                    </div>
                    <div class="content">
                        <div class="item-title">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                        </div>
                        <div class="item-meta">
                            <span><?php the_time('d/m/Y'); ?></span> | <span><?php the_author_posts_link(); ?></span>
                        </div>
                        <div class="item-description"><?php echo strip_tags(get_the_content('')); ?></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php endwhile;?>
                <?php wp_reset_query(); ?>
                <?php getpagenavi(array( 'query' => $loop1 )); ?>
                <?php endif; ?>
            </div>
            <!--/#tab-news-->
            <div id="tab-apps" class="tab-apps">
                <?php
                $loop2 = new WP_Query(array(
                    'post_type' => 'apps',
                    'paged' => $paged,
                    'meta_query' => array(
                        'relation' => 'OR',
                        array(
                            'key' => 'is_most',
                            'value' => '0',
                        ),
                        array(
                            'key' => 'is_most',
                            'value' => '',
                            'compare' => 'NOT EXISTS',
                        )
                    ),
                ));
                if($loop2->post_count > 0):
                $counter = 1;
                while($loop2->have_posts()) : $loop2->the_post(); 
                    if($counter % 2 == 0):
                ?>
                <div class="item mr0">
                    <?php else: ?>
                <div class="item">
                    <?php endif; ?>
                    <div class="thumb">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                            <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=220&h=220" />
                        </a>
                    </div>
                    <div class="content">
                        <div class="item-title">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                        </div>
                        <?php if (get_post_meta(get_the_ID(), "nha_phat_hanh", true) != ""):?>
                        <div class="nph"><?php echo get_post_meta(get_the_ID(), "nha_phat_hanh", true);?></div>
                        <?php endif; ?>
                        <?php if (get_post_meta(get_the_ID(), "apps_price", true) != ""):?>
                        <div class="price"><?php echo get_post_meta(get_the_ID(), "apps_price", true);?></div>
                        <?php endif; ?>
                        <div class="rating">Rating: <?php if(function_exists('the_ratings')) { the_ratings(); } ?></div>
                        <!--<div class="item-meta">
                            <span><?php //the_time('H:s - d/m/Y'); ?></span> | <span><?php //the_author_posts_link(); ?></span>
                        </div>-->
                        <div class="item-description">
                            <?php echo strip_tags(get_the_content('')); ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php $counter++; endwhile;?>
                <?php wp_reset_query(); ?>
                <div class="clearfix"></div>
                <?php getpagenavi(array( 'query' => $loop2 )); ?>
                <?php endif; ?>
            </div>
            <!--/#tab-apps-->
        </div>
    </div>
    <!--/.main-content-->
    
    <?php get_sidebar(); ?>
    <div class="clearfix"></div>
</div>

<?php get_footer(); ?>
