<?php
/*
  Template Name: Page News
 */
?>
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
        <div class="tabs-news mt0">
            <?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
            <ul>
                <li><a href="#tab-all">Tất cả</a></li>
                <li class="ml10 mr10">|</li>
                <li><a href="#tab-ios">Tin iOS</a></li>
                <li class="ml10 mr10">|</li>
                <li><a href="#tab-android">Tin Android</a></li>
                <li class="ml10 mr10">|</li>
                <li><a href="#tab-other">Tin khác</a></li>
            </ul>
            <div id="tab-all" class="tab-news">
                <?php
                $loop1 = new WP_Query(array(
                    'post_type' => 'post',
                    'paged' => $paged,
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
                        <div class="item-description">
                            <?php 
                            global $more;
                            $more = 0; 
                            the_content(''); 
                            ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php endwhile;?>
                <?php wp_reset_query(); ?>
                <?php getpagenavi(array( 'query' => $loop1 )); ?>
                <?php endif; ?>
            </div>
            <!--/#tab-all-->
            <div id="tab-ios" class="tab-news">
                <?php
                $iosID = intval(get_option('appsreview_catIOSNewsID'));
                if($iosID > 0):
                $loop2 = new WP_Query(array(
                    'post_type' => 'post',
                    'cat' => $iosID,
                    'paged' => $paged,
                ));
                if($loop2->post_count > 0):
                while($loop2->have_posts()) : $loop2->the_post(); 
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
                        <div class="item-description">
                            <?php 
                            global $more;
                            $more = 0; 
                            the_content(''); 
                            ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php endwhile;?>
                <?php wp_reset_query(); ?>
                <?php getpagenavi(array( 'query' => $loop2 )); ?>
                <?php endif; ?>
                <?php endif; ?>
            </div>
            <!--/#tab-ios-->
            <div id="tab-android" class="tab-news">
                <?php
                $androidID = intval(get_option('appsreview_catAndroidNewsID'));
                if($androidID > 0):
                $loop3 = new WP_Query(array(
                    'post_type' => 'post',
                    'cat' => $androidID,
                    'paged' => $paged,
                ));
                if($loop3->post_count > 0):
                while($loop3->have_posts()) : $loop3->the_post(); 
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
                        <div class="item-description">
                            <?php 
                            global $more;
                            $more = 0; 
                            the_content(''); 
                            ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php endwhile;?>
                <?php wp_reset_query(); ?>
                <?php getpagenavi(array( 'query' => $loop3 )); ?>
                <?php endif; ?>
                <?php endif; ?>
            </div>
            <!--/#tab-android-->
            <div id="tab-other" class="tab-news">
                <?php
                $otherID = intval(get_option('appsreview_catOtherNewsID'));
                if($otherID > 0):
                $loop4 = new WP_Query(array(
                    'post_type' => 'post',
                    'cat' => $otherID,
                    'paged' => $paged,
                ));
                if($loop4->post_count > 0):
                while($loop4->have_posts()) : $loop4->the_post(); 
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
                        <div class="item-description">
                            <?php 
                            global $more;
                            $more = 0; 
                            the_content(''); 
                            ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php endwhile;?>
                <?php wp_reset_query(); ?>
                <?php getpagenavi(array( 'query' => $loop4 )); ?>
                <?php endif; ?>
                <?php endif; ?>
            </div>
            <!--/#tab-other-->
        </div>
    </div>
    <!--/.main-content-->
    
    <?php get_sidebar(); ?>
    <div class="clearfix"></div>
</div>

<?php get_footer(); ?>
