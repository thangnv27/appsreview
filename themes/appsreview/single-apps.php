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
        <div class="post">
            <?php while (have_posts()) : the_post(); ?>
                <h1 class="post-title"><?php the_title(); ?></h1>
                <div class="post-meta">
                    <span class="post-time"><?php the_time('H:s - d/m/Y'); ?></span> | <span class="post-author">Viết bởi: <?php the_author_posts_link(); ?></span>
                    <div class="social_box fr">
                        <!-- AddThis Button BEGIN -->
                        <div class="addthis_toolbox addthis_default_style ">
                        <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                        <a class="addthis_button_tweet"></a>
                        <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
                        <a class="addthis_counter addthis_pill_style"></a>
                        </div>
                        <script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e5a517830ae061f"></script>
                        <!-- AddThis Button END -->
                    </div>
                </div>
                <div class="post-content">
                    <?php the_content(); ?>
                </div>
                <div class="app-info col-left">
                    <div class="app-thumb">
                        <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=200&h=200" />
                    </div>
                    <div class="app-meta">
                        <div class="app-name"><?php the_title(); ?></div>
                        <?php if (get_post_meta(get_the_ID(), "nha_phat_hanh", true) != ""):?>
                        <div class="app-nph"><?php echo get_post_meta(get_the_ID(), "nha_phat_hanh", true);?></div>
                        <?php endif; ?>
                        <?php if (get_post_meta(get_the_ID(), "apps_price", true) != ""):?>
                        <div class="app-price"><?php echo get_post_meta(get_the_ID(), "apps_price", true);?></div>
                        <?php endif; ?>
                        <div class="app-rate">
                            <p>Bình chọn ứng dụng</p>
                            <div class="point"><?php if(function_exists('the_ratings')) { the_ratings(); } ?></div>
                            <!--<div class="point"><?php if(function_exists('the_ratings_results')) { echo the_ratings_results(get_the_ID()); } ?></div>
                            <div class="rating">
                                <?php 
//                                if(!check_rated(get_the_ID())){
//                                    echo the_ratings_vote(get_the_ID());
//                                }
                                ?>
                            </div>-->
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="post-tag">
                    <div style="width: 540px; float: left;"><?php the_tags('<span>TAGS: </span>', ', ', ''); ?></div>
                    <div class="social_box fr" style="margin-top: -2px;">
                        <!-- AddThis Button BEGIN -->
                        <div class="addthis_toolbox addthis_default_style ">
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
                </div>
            <?php endwhile; ?>
        </div>
        <!--/.post-->
        
        <div class="app-other">
            <div class="title-other"><span>Ứng dụng cùng thể loại</span></div>
            <div class="post-other-item">
                <?php
                $taxonomy = 'apps_category';
                $terms = get_the_terms( $post->ID, $taxonomy );
                $excludeID = array();
                array_push($excludeID, $post->ID);
                $args = array(
                    'post_type' => 'apps',
                    'post__not_in' => $excludeID,
                );
                if(count($terms) > 0){
                    $args['tax_query'] = array();
                    foreach ($terms as $term) {
                        array_push($args['tax_query'], array(
                            'taxonomy' => $taxonomy,
                            'field' => 'id',
                            'terms' => $term->term_id,
                        ));
                    }
                }
                $loop = new WP_Query($args);
                $counter = 1;
                while($loop->have_posts()) : $loop->the_post(); 
                    if($counter % 3 == 0):
                ?>
                <div class="item mr0">
                    <?php else: ?>
                <div class="item">
                    <?php endif; ?>
                    <div class="thumb">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                            <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=80&h=80" />
                        </a>
                    </div>
                    <div class="info">
                        <div class="name"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></div>
                        <?php if (get_post_meta(get_the_ID(), "apps_price", true) != ""):?>
                        <div class="price"><?php echo get_post_meta(get_the_ID(), "apps_price", true);?></div>
                        <?php endif; ?>
                        <div class="rate">Rating: <?php if(function_exists('the_ratings')) { the_ratings(); } ?></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php $counter++; endwhile;?>
                <?php wp_reset_query(); ?>
                <div class="clearfix"></div>
            </div>
            <!--/.post-other-item-->
        </div>
        <!--/.app-other-->
        
        <div class="comment-box">
            <div class="block-title"><span>Bình Luận</span></div>
            <div id="disqus_thread"></div>
            <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
        </div>
    </div>
    <!--/.main-content-->

    <?php get_sidebar(); ?>
    <div class="clearfix"></div>
</div>
    
<script type="text/javascript">
    $(function(){
        FixedColumn.single();
    });
</script>

<?php get_footer(); ?>
