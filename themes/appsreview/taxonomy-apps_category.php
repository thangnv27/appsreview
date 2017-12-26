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
            $term = get_queried_object();
            echo $term->name;
            ?></span>
        </div>
        <?php if(!category_has_children()):  ?>
        <div class="apps-item">
            <?php
            $counter = 1;
            while (have_posts()) : the_post(); 
                if($counter % 3 == 0):
            ?>
            <div class="app-item mr0">
                <?php else: ?>
            <div class="app-item">
                <?php endif; ?>
                <div class="app-item-thumb">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                        <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=140&h=140" />
                    </a>
                </div>
                <div class="app-item-info">
                    <div class="name"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></div>
                    <?php if (get_post_meta(get_the_ID(), "nha_phat_hanh", true) != ""):?>
                    <div class="nph"><?php echo get_post_meta(get_the_ID(), "nha_phat_hanh", true);?></div>
                    <?php endif; ?>
                    <?php if (get_post_meta(get_the_ID(), "apps_price", true) != ""):?>
                    <div class="price"><?php echo get_post_meta(get_the_ID(), "apps_price", true);?></div>
                    <?php endif; ?>
                    <div class="vote">Rating: <?php if(function_exists('the_ratings')) { the_ratings(); } ?></div>
                    <!--<div class="date"><?php //the_time('d/m/Y'); ?></div>-->
                </div>
                <!--<div class="app-item-description"><?php //the_content(''); ?></div>-->
            </div>
            <?php $counter++; endwhile; ?>
            <div class="clearfix"></div>
            <?php if(function_exists('getpagenavi')){ getpagenavi(); } ?>
        </div>
        <!--/.apps-item-->
        <?php else: ?>
        <div class="cat-items">
            <?php 
            $taxonomy = 'apps_category';
            $args = array(
                'hide_empty' => 0,
                'child_of' => $term->term_id,
                'taxonomy' => $taxonomy,
                'orderby' => 'term_order',
                'order' => 'ASC',
            );
            $categories = get_categories( $args );
            foreach ($categories as $key => $category) :
                if($category->parent == $term->term_id):
                    if($key % 2 != 0):
            ?>
            <div class="cat-item mr0">
            <?php else: ?>
            <div class="cat-item">
            <?php endif; ?>
                <h3><?php echo $category->name; ?></h3>
                <div class="cat-thumb">
                    <a href="<?php echo get_term_link($category, $taxonomy ); ?>" title="<?php echo $category->name; ?>">
                        <img alt="<?php echo $category->name; ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php echo z_taxonomy_image_url($category->term_id); ?>&w=440&h=120" />
                    </a>
                </div>
            </div>
            <?php
                endif;
            endforeach;
            ?>
            <div class="clearfix"></div>
        </div>
        <!--/.cat-items-->
        <?php endif; ?>
    </div>
    <!--/.main-content-->

    <?php get_sidebar(); ?>
    <div class="clearfix"></div>
</div>

<?php get_footer(); ?>
