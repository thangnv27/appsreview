<?php
/*if ($_SERVER['PHP_AUTH_USER'] != 'admin' or $_SERVER['PHP_AUTH_PW'] != 'Admin1#') { // Authorization
Header('WWW-Authenticate: Basic realm="Firewall!"');
Header('HTTP/1.0 401 Unauthorized');
echo "<html>
         <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
            <title>AppsReview</title>
         </head>
         <body>
            <center>
                <img alt=\"\" src=\"http://115.78.228.130:8081/ec/website-under-construction.gif\" />
            </center>
        </body>
    </html>";
    exit();
}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="vi-VN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
<?php get_the_pages_title(); ?>
<meta name="robots" content="index, follow" /> 
<meta name="keywords" content="<?php echo get_option('keywords_meta'); ?>" />
<meta name="description" content="<?php echo get_option('description_meta'); ?>" />
<meta name="author" content="fotu.vn" />

<?php get_favicon(); ?>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'/>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_directory' ); ?>/css/wp-default.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_directory' ); ?>/css/common.css" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/jquery.lightbox-0.5.css" media="screen" />

<?php
if(is_single()){
    $post_id = get_the_ID();
    echo "<link rel=\"exclude_post_id\" content=\"{$post_id}\"/>";
}
?>

<script>
    var siteUrl = "<?php bloginfo( 'siteurl' ); ?>";
    var themeUrl = "<?php bloginfo('stylesheet_directory'); ?>";
    //var loginUrl = "<?php echo wp_login_url(getCurrentRquestUrl() ); ?>";
    var loginUrl = "<?php echo get_page_link(get_option('appsreview_pageLoginID')); ?>?redirect_to=<?php echo getCurrentRquestUrl(); ?>";
    var registerUrl = "<?php echo get_page_link(get_option('appsreview_pageRegisterID')); ?>";
</script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.min.js"></script>
<!--<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery-1.9.1.js"></script>-->
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery-scrolltofixed-min.js"></script>
<!--<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.lightbox-0.5.js"></script>-->
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/custom.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/app.js"></script>

<?php 
if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
wp_head();
?>
<?php get_google_analytics(); ?>
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div id="header">
    <div class="head_bar">
        <ul class="nav_bar">
            <li class="logo_bar">
                <a href="<?php bloginfo( 'siteurl' ); ?>" title="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
                    <img src="<?php echo get_option('sitelogo'); ?>" alt="<?php bloginfo( 'name' ); ?>"/>
                    <!--<span class="logo_text">AppsReview</span>-->
                </a>
            </li>
            <li class="nav-menu">
                <?php $term = get_queried_object(); ?>
                <ul>
                    <li class="<?php if(is_home()) echo 'active'; ?>"><a href="<?php bloginfo( 'siteurl' ); ?>">Trang chủ</a></li>
                    <li class="nav-apps <?php if($term->term_id == get_option('appsreview_catIOSAppsID')) echo 'active'; ?>"><a class="icons-ios" href="<?php echo get_term_link(intval(get_option('appsreview_catIOSAppsID')), 'apps_category' ); ?>">IOS</a>
                        <?php 
                        $menuIOS = wp_nav_menu(array(
                            'menu' => 'Menu IOS',
                            'container' => '',
                            'fallback_cb' => '__return_false'
                        )); 
                        if(!empty($menuIOS)){
                            echo $menuIOS;
                        }
                        ?>
                    </li>
                    <li class="nav-apps <?php if($term->term_id == get_option('appsreview_catAndroidAppsID')) echo 'active'; ?>"><a class="icons-android" href="<?php echo get_term_link(intval(get_option('appsreview_catAndroidAppsID')), 'apps_category' ); ?>">Android</a>
                        <?php
                        $menuAndroid = wp_nav_menu(array(
                            'menu' => 'Menu Android',
                            'container' => '',
                            'fallback_cb' => '__return_false'
                        )); 
                        if(!empty($menuAndroid)){
                            echo $menuAndroid;
                        }
                        ?>
                    </li>
                    <li class="nav-news <?php if(get_the_ID() == get_option('appsreview_pageNewsID')) echo 'active'; ?>"><a href="<?php echo get_page_link(get_option('appsreview_pageNewsID')); ?>">Tin tức</a>
                        <?php 
                        $menuNews = wp_nav_menu(array(
                            'menu' => 'Menu Tin Tuc',
                            'container' => '',
                            'fallback_cb' => '__return_false'
                        )); 
                        if(!empty($menuNews)){
                            echo $menuNews;
                        }
                        ?>
                    </li>
                </ul>
            </li>
            <li class="nav-search">
                <form action="<?php bloginfo( 'siteurl' ); ?>" method="get">
                    <input type="text" name="s" value="" placeholder="Tìm kiếm" class="input-search2" />
                    <input type="submit" value="" style="border: none; background: none; display: none;" />
                </form>
            </li>
        </ul>
        <!--/.nav_bar-->
        <div class="user-bar">
            <?php if(isset($_SESSION['current_user_login'])): $current_user = $_SESSION['current_user_login']; ?>
            <div class="avatar">
                <a href="<?php echo admin_url(); ?>"><?php echo get_avatar($current_user->ID); ?></a>
            </div>
            <ul class="user_options">
                <li class="display_name">
                    <a href="javascript://"><?php echo $current_user->display_name; ?></a>
                    <ul>
                        <li><a href="<?php bloginfo( 'siteurl' ); ?>/wp-admin/profile.php">Hồ sơ cá nhân</a></li>
                        <li><a href="<?php echo wp_logout_url( home_url() ); ?>">Thoát</a></li>
                    </ul>
                </li>
                <li class="logout"><a href="<?php echo wp_logout_url( home_url() ); ?>">Thoát</a></li>
            </ul>
            <div class="clearfix"></div>
            <?php else: ?>
            <ul class="user_options">
                <li class="fl mr8 pdt10"><a href="<?php echo get_page_link(get_option('appsreview_pageLoginID')); ?>" class="bold" style="font: 8pt Helvetica;">Đăng nhập</a></li>
                <li class="fl mr8 pdt10">|</li>
                <li class="fl pdt10"><a href="<?php echo get_page_link(get_option('appsreview_pageRegisterID')); ?>" class="bold" style="font: 8pt Helvetica;">Đăng ký</a></li>
            </ul>
            <?php endif; ?>
        </div>
        <!--/.user-bar-->
        <div class="clearfix"></div>
    </div>
</div>
<!--/#header-->

