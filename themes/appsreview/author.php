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
        <div class="author">
            <?php $author = get_queried_object(); ?>
            <div class="author-avatar">
                <?php echo get_avatar($author->ID, 140); ?>
            </div>
            <div class="author-info">
                <h1 class="author-name"><?php echo $author->display_name; ?></h1>
                <div class="author-regency"><?php echo $author->regency; ?></div>
                <div class="author-joindate">Ngày tham gia: <span><?php echo date('d/m/Y', strtotime($author->user_registered)); ?></span></div>
                <div class="author-postcount">Số bài viết: <span><?php 
                        $query = new WP_Query( array(
                                'author' => $author->ID,
                                'post_type' => array('post', 'apps'),
                            ));
                        echo $query->post_count;
                        ?></span>
                </div>
            </div>
            <div class="social_box" style="position: absolute; right: 0; top: 120px;">
                <?php if($author->fb_url != ""): ?>
                <div class="fb-follow" data-href="<?php echo $author->fb_url; ?>" data-width="125" data-layout="button_count" data-show-faces="false"></div>
                <?php endif; ?>
                <!-- AddThis Button BEGIN -->
                <div class="addthis_toolbox addthis_default_style" style="display: inline;">
                <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                <a class="addthis_button_tweet"></a>
                <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
                <a class="addthis_counter addthis_pill_style"></a>
                </div>
                <script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
                <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e5a517830ae061f"></script>
                <!-- AddThis Button END -->
            </div>
            <div class="clearfix"></div>
            
            <?php if($author->description != ""): ?>
            <div class="biographical_info">
                <?php echo $author->description; ?>
            </div>
            <?php endif; ?>
        </div>
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
                    'author' => $author->ID,
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
                            <?php the_content(''); ?>
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
            <!--/#tab-news-->
            <div id="tab-apps" class="tab-apps">
                <?php
                $loop2 = new WP_Query(array(
                    'post_type' => 'apps',
                    'author' => $author->ID,
                    'paged' => $paged,
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
                            <span><?php //the_time('d/m/Y'); ?></span> | <span><?php //the_author_posts_link(); ?></span>
                        </div>-->
                        <div class="item-description">
                            <?php the_content(''); ?>
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
