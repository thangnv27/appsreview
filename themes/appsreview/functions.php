<?php

ob_start();
if (!isset($_SESSION)) session_start();

$themename = "Apps Review";
$shortname = "appsreview";

include 'includes/HttpFoundation/Request.php';
include 'includes/HttpFoundation/Response.php';
include 'includes/HttpFoundation/Session.php';
include 'includes/custom.php';
include 'includes/theme_functions.php';
include 'includes/common-scripts.php';
include 'includes/meta-box.php';
include 'includes/theme_settings.php';
include 'includes/custom-user.php';
include 'includes/social-post-link.php';
//include 'includes/taxonomy_displayorder.php';
include 'includes/apps.php';
include 'includes/postMeta.php';
include 'ajax.php';

user_check_login_status();
redirect_after_logout();

function user_check_login_status(){
    global $current_user;
    get_currentuserinfo();
    if (is_user_logged_in()) {
        $_SESSION['current_user_login'] = $current_user;
    }else{
        if(isset($_SESSION['current_user_login'])){
            unset($_SESSION['current_user_login']);
        }
    }
}

function redirect_after_logout() {
    if (preg_match('#(wp-login.php)?(loggedout=true)#', $_SERVER['REQUEST_URI']))
        wp_redirect(get_option('siteurl'));
}

// Redefine user notification function
if (!function_exists('custom_wp_new_user_notification')) {
    function custom_wp_new_user_notification($user_id, $plaintext_pass = '') {
        global $shortname;

        $user = new WP_User($user_id);

        $user_login = stripslashes($user->user_login);
        $user_email = stripslashes($user->user_email);

        $message = sprintf(__('New user registration on %s:'), get_option('blogname')) . "\r\n\r\n";
        $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
        $message .= sprintf(__('E-mail: %s'), $user_email) . "\r\n";

        @wp_mail(
                        get_option('admin_email'), sprintf(__('[%s] New User Registration'), get_option('blogname')), $message
        );

        if (empty($plaintext_pass))
            return;

        $login_url = get_page_link(get_option($shortname . '_pageLoginID'));
        
        $message = sprintf(__('Hi %s,'), $user->display_name) . "\r\n\r\n";
        $message .= sprintf(__("Welcome to %s! Here's how to log in:"), get_option('blogname')) . "\r\n\r\n";
        $message .= ($login_url == "") ? wp_login_url() : $login_url . "\r\n";
        $message .= sprintf(__('Username: %s'), $user_login) . "\r\n";
        $message .= sprintf(__('Password: %s'), $plaintext_pass) . "\r\n\r\n";

        wp_mail(
                $user_email, sprintf(__('[%s] Your username and password'), get_option('blogname')), $message
        );
    }

}

/* ----------------------------------------------------------------------------------- */
# Post Thumbnails
/* ----------------------------------------------------------------------------------- */
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
}
/*if (function_exists('add_image_size')) {
    add_image_size('thumb60x60', 60, 60, FALSE);
    add_image_size('thumb80x80', 80, 80, FALSE);
    add_image_size('thumb117x70', 117, 70, FALSE);
}*/

/* ----------------------------------------------------------------------------------- */
# Register Sidebar
/* ----------------------------------------------------------------------------------- */
register_sidebar(array(
    'name' => __('Sidebar'),
    'before_widget' => '<div id="%1$s" class="widget-container rbox %2$s">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="widget-title rbox-head">',
    'after_title' => '</div><div class="rbox-body">',
));

/**
 * Add wysiwyg to custom field textarea
 */
function admin_add_custom_js() {
    ?>
    <script type="text/javascript">/* <![CDATA[ */
        jQuery(function($){
        });
        /* ]]> */
    </script>
<?php
}

//add_action('admin_print_footer_scripts', 'admin_add_custom_js', 99);