<?php
add_action('init', 'add_custom_js');
add_action( 'wp_ajax_nopriv_' . getRequest('action'), getRequest('action') );  
add_action( 'wp_ajax_' . getRequest('action'), getRequest('action') ); 

function add_custom_js() {
    // code to embed th  java script file that makes the Ajax request  
    wp_enqueue_script('ajax.js', get_bloginfo('template_directory') . "/js/ajax.js", array('jquery'));
    // code to declare the URL to the file handling the AJAX request 
    //wp_localize_script( 'ajax-request', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) ); 
}
    
function get_top_view_news() {
    $html = "";
    $paged = intval(getRequest('paged'));
    if($paged > 10){
        $paged = 1;
    }
    $exclude_post_id = array();
    array_push($exclude_post_id, intval(getRequest('exclude_post_id')));
    $loop = new WP_Query(array(
                'post_type' => 'post',
                'paged' => $paged,
                'posts_per_page' => 3,
                'post__not_in' => $exclude_post_id,
                'orderby' => 'meta_value_num', 
                'meta_key' => 'views',
                'order' => 'DESC',
            ));
    $total_page = $loop->max_num_pages;
    if($total_page > 10){
        $total_page = 10;
    }
    while($loop->have_posts()) : $loop->the_post();
        $permalink = get_permalink( get_the_ID() );
        $title = get_the_title( get_the_ID() );
        $html .= "<li><a href=\"{$permalink}\" title=\"{$title}\">{$title}</a></li>";
    endwhile;
    wp_reset_query();
    
    Response(json_encode(array(
        'total_page' => $total_page,
        'current_page' => $paged,
        'next_page' => $paged + 1,
        'prev_page' => ($paged > 1) ? $paged - 1 : 1,
        'data' => $html,
    )));
    die();
}
function get_top_view_apps() {
    $html = "";
    $paged = intval(getRequest('paged'));
    if($paged > 10){
        $paged = 1;
    }
    $exclude_post_id = array();
    array_push($exclude_post_id, intval(getRequest('exclude_post_id')));
    $loop = new WP_Query(array(
                'post_type' => 'apps',
                'paged' => $paged,
                'posts_per_page' => 3,
                'post__not_in' => $exclude_post_id,
                'orderby' => 'meta_value_num', 
                'meta_key' => 'views',
                'order' => 'DESC',
            ));
    $total_page = $loop->max_num_pages;
    if($total_page > 10){
        $total_page = 10;
    }
    while($loop->have_posts()) : $loop->the_post();
        $themeurl = get_bloginfo('stylesheet_directory');
        $permalink = get_permalink( get_the_ID() );
        $title = get_the_title( get_the_ID() );
        $image_url = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full');
        $nph = get_post_meta(get_the_ID(), "nha_phat_hanh", true);
        $fee = get_post_meta(get_the_ID(), "apps_price", true);
        $rating = "";
        if(function_exists('the_ratings')) { 
            $rating = the_ratings('div', 0, FALSE);
        }
        if($image_url[0] == ""){
            $image_url = $themeurl . "/images/no_image_available.jpg";
        }else{
            $image_url = $image_url[0];
        }
        $html .= <<<HTML
        <div class="item">
            <div class="thumb">
                <a href="{$permalink}" title="{$title}">
                    <img src="{$themeurl}/timthumb.php?src={$image_url}&w=80&h=80">
                </a>
            </div>
            <div class="content">
                <div class="title"><a href="{$permalink}" title="{$title}">{$title}</a></div>
                <div class="nph">{$nph}</div>
                <div class="price">{$fee}</div>
                <div class="rating">Rating: {$rating}</div>
            </div>
            <div class="clearfix"></div>
        </div>
HTML;
    endwhile;
    wp_reset_query();
    
    Response(json_encode(array(
        'total_page' => $total_page,
        'current_page' => $paged,
        'next_page' => $paged + 1,
        'prev_page' => ($paged > 1) ? $paged - 1 : 1,
        'data' => $html,
    )));
    die();
}