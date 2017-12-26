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
                <div class="post-content pdl20" style="width:700px;">
                    <?php the_content(); ?>
                </div>
                <div class="col-left">
                    <div class="rbox">
                        <div class="rbox-head">Tin liên quan</div>
                        <div class="rbox-body">
                            <ul>
                                <?php
                                /*$posttags = get_the_tags();
                                $tag_slug = array();
                                if ($posttags) {
                                    foreach ($posttags as $tag) {
                                        array_push($tag_slug, $tag->slug);
                                    }
                                }*/
                                $categories = get_the_category();
                                $cat = array();
                                foreach ($categories as $category) {
                                    array_push($cat, $category->term_id);
                                }
                                $excludeID = array();
                                array_push($excludeID, get_the_ID());
                                $args = array(
                                    'post_type' => 'post',
                                    'post__not_in' => $excludeID,
                                    'posts_per_page' => 6,
                                    'category__in' => $cat,
                                    //'tag_slug__in' => $tag_slug,
                                );
                                $loop = new WP_Query($args);
                                while($loop->have_posts()) : $loop->the_post(); 
                                ?>
                                <li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
                                <?php endwhile;?>
                                <?php wp_reset_query(); ?>
                            </ul>
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
            <?php wp_reset_query(); ?>
        </div>
        
        <div class="post-other">
            <div class="title-other"><span>Tin khác</span></div>
            <div class="post-other-item">
                <ul>
                    <?php
                    $excludeID = array();
                    array_push($excludeID, $post->ID);
                    $args = array(
                        'post_type' => 'post',
                        'post__not_in' => $excludeID,
                        'posts_per_page' => 10,
                        //'orderby' => 'rand',
                    );
                    $loop = new WP_Query($args);
                    while($loop->have_posts()) : $loop->the_post(); 
                    ?>
                    <li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a> <span>(<?php the_time('H:s - d/m/Y'); ?>)</span></li>
                    <?php endwhile;?>
                    <?php wp_reset_query(); ?>
                </ul>
            </div>
        </div>
        <!--/.post-other-->
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
