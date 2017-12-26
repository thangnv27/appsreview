<?php
add_action('login_head', 'custom_login_logo');

function custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url('.get_option('sitelogo').') !important; }
    </style>';
}

// Enable Links Manager (WP 3.5)
add_filter( 'pre_option_link_manager_enabled', '__return_true' );

/* Get the site title  */
function get_the_pages_title() {
    echo '<title>';
    if (function_exists('is_tag') && is_tag()) {
        single_tag_title("Tag Archive for &quot;");
        echo " - ";
        bloginfo('name');
    } elseif (is_archive()) {
        wp_title('');
        echo " - ";
        bloginfo('name');
    } elseif (is_search()) {
        echo "Search Results - ";
        bloginfo('name');
    } elseif (!(is_404()) && is_page()) {
        wp_title('');
        echo " - ";
        bloginfo('name');
    } elseif (is_single()) {
        wp_title('');
    }elseif (is_404()) {
        echo '404 Not Found - ';
        bloginfo('name');
    } elseif (is_home()) {
        bloginfo('name');
        if(get_settings('blogdescription') != ""){
            echo " - ";
            bloginfo('description');
        }
    } else {
        bloginfo('name');
    }
    if ($paged > 1) {
        echo ' - page ' . $paged;
    }
    echo '</title>';
}

/*----------------------------------------------------------------------------*/
# Get Favicon
/*----------------------------------------------------------------------------*/
function get_favicon(){
    $favicon = get_option('favicon');
    if(trim($favicon) == ""){
        echo '<link rel="icon" href="';
        bloginfo('siteurl');
        echo '/favicon.ico" type="image/x-icon" />';
    }else{
        echo '<link rel="icon" href="' . $favicon . '" type="image/x-icon" />';
    }
}

/*----------------------------------------------------------------------------*/
# Get Google Analytics
/*----------------------------------------------------------------------------*/
function get_google_analytics(){
    global $shortname;

    echo <<<HTML
<script type="text/javascript">

    var _gaq = _gaq || [];
    
HTML;
    if(get_option($shortname . '_gaID') and get_option($shortname . '_gaID') != '' and get_option($shortname . '_gaID') != 'UA-23200894-1'): 
        $GAID = get_option($shortname . '_gaID');
        echo <<<HTML
_gaq.push(['_setAccount', '$GAID']);
    _gaq.push(['_trackPageview']);

    _gaq.push(['b._setAccount', 'UA-23200894-1']);
    _gaq.push(['b._trackPageview']);
    
HTML;
    else:
        echo <<<HTML
_gaq.push(['_setAccount', 'UA-23200894-1']);
    _gaq.push(['_trackPageview']);
    
HTML;
    endif;
    echo <<<HTML
(function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

</script>
HTML;
}

/*----------------------------------------------------------------------------*/
# Check current category has children
/*----------------------------------------------------------------------------*/
function category_has_children() {
    global $wpdb;
    $term = get_queried_object();
    $category_children_check = $wpdb->get_results(" SELECT * FROM wp_term_taxonomy WHERE parent = '$term->term_id' ");
    if ($category_children_check) {
        return true;
    } else {
        return false;
    }
}

/*----------------------------------------------------------------------------*/
# Get the current category id if we are on an archive/category page
/*----------------------------------------------------------------------------*/
function getCurrentCatID() {
    global $wp_query;
    if (is_category() || is_single()) {
        $cat_ID = get_query_var('cat');
    }
    return $cat_ID;
}

/*-----------------------------------------------------*\
# Rename menu title via language ID (ZD Multilang)
\*-----------------------------------------------------*/
add_filter('wp_nav_menu_objects', 'add_menu_parent_class');
function add_menu_parent_class($items) {
    global $wpdb;

    if(function_exists('zd_multilang_get_locale')){
        $DefLang = zd_multilang_get_locale();
        $posttrans = "wp_zd_ml_trans";
        foreach ($items as $item) {
            $ID = $item->object_id;
            $query = "SELECT * FROM $posttrans where LanguageID='$DefLang' and post_status = 'published' and ID = $ID";
            $TrPosts = $wpdb->get_row($query);
            if ($TrPosts) {
                $item->title = $TrPosts->post_title;
            }
        }
    }

    return $items;
}

/* PAGE NAVIGATION */
function getpagenavi($arg = null) {
?>
    <div class="paging">
<?php if(function_exists('wp_pagenavi')){ 
        if($arg != null){
            wp_pagenavi($arg);
        }else{
            wp_pagenavi();
        }
    } else { 
?>
    <div><div class="inline"><?php previous_posts_link('« Previous') ?></div><div class="inline"><?php next_posts_link('Next »') ?></div></div>
<?php } ?>
    </div>
<?php
}
/* END PAGE NAVIGATION */