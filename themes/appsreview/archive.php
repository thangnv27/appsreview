<?php get_header(); ?>

<?php get_sidebar('top'); ?>

<div class="wrapper">
    <div class="main-content">
        <div class="breadcrums">
            <?php
            if (function_exists('bcn_display')) {
                bcn_display();
            }
            ?>
        </div>
        <div class="cat-name">
            <span><?php 
            if(is_tag()):
                echo 'Tag Archive for "';
                single_tag_title();
                echo '":';
            elseif(is_category()):
                echo single_cat_title(); 
            endif;
            ?></span>
        </div>
        <div id="tab-news" class="tab-news">
            <?php while(have_posts()) : the_post(); ?>
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
                    <div class="item-description"><?php the_content(''); ?></div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <?php endwhile;?>
            <?php wp_reset_query(); ?>
        </div>
        <!--/#tab-news-->
        <?php if(function_exists('getpagenavi')){ getpagenavi(); } ?>
    </div>
    <!--/.main-content-->

    <?php get_sidebar(); ?>
    <div class="clearfix"></div>
</div>

<?php get_footer(); ?>
