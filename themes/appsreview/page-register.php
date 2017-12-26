<?php
/*
  Template Name: Page Register
 */
?>
<?php
if (isset($_SESSION['current_user_login'])) {
    header("location: " . home_url());
}
$msg = array(
    'warning' => array(),
    'success' => array()
);
if (getRequestMethod() == 'POST' and $_SESSION['security_code'] == getRequest('captcha')) {
    $sanitized_user_login = sanitize_user(getRequest('username'));
    $email = getRequest('email');
    $password = getRequest('pwd');
    $password2 = getRequest('repwd');

    if ($sanitized_user_login == "") {
        array_push($msg['warning'], "<p>Vui lòng nhập tài khoản!</p>");
    } elseif (!validate_username($sanitized_user_login)) {
        array_push($msg['warning'], "<p>Tài khoản không hợp lệ, vui lòng nhập tài khoản khác!</p>");
    } elseif (username_exists($sanitized_user_login)) {
        array_push($msg['warning'], "<p>Tài khoản đã tồn tại, vui lòng nhập tài khoản khác!</p>");
    } elseif (!is_email($email)) {
        array_push($msg['warning'], "<p>Địa chỉ email không hợp lệ!</p>");
    } elseif (email_exists($email)) {
        array_push($msg['warning'], "<p>Địa chỉ email này đã tồn tại!</p>");
    } elseif ($password == "") {
        array_push($msg['warning'], "<p>Vui lòng nhập mật khẩu!</p>");
    } elseif ($password2 != $password) {
        array_push($msg['warning'], "<p>Xác nhận mật khẩu không chính xác!</p>");
    } else {
        $user_id = wp_create_user($sanitized_user_login, $password, $email);
        if (!$user_id || is_wp_error($user_id)) {
            array_push($msg['warning'], "Đăng ký lỗi. Vui lòng liên hệ <a href='mailto:" . get_option('admin_email') . "'>quản trị website</a>!");
        } else {
            array_push($msg['success'], "Đăng ký thành công!");
            //Set up the Password change nag.
            update_user_option($user_id, 'default_password_nag', true, true);
            update_user_meta( $user_id, 'user_dob_day', intval(getRequest('user_dob_day')) );
            update_user_meta( $user_id, 'user_dob_month', intval(getRequest('user_dob_month')) );
            update_user_meta( $user_id, 'user_dob_year', intval(getRequest('user_dob_year')) );
            // notification for user
            //wp_new_user_notification($user_id, $password);
            custom_wp_new_user_notification($user_id, $password);
        }
    }
}
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
        <div class="reg-form-title">
            <span>Đăng ký</span>
        </div>
        <div id="message" class="<?php 
            if(!empty($msg['warning'])){
                echo 'warning';
            }elseif(!empty($msg['success'])){
                echo 'success';
            }
            ?>">
            <?php 
            if(!empty($msg['warning'])){
                foreach ($msg['warning'] as $m) {
                    echo $m;
                }
            }
            if(!empty($msg['success'])){
                foreach ($msg['success'] as $m) {
                    echo $m;
                }
            }
            ?>
        </div>
        <div class="social_login">
            <div class="facebook fbsignup">
                <a href="<?php bloginfo( 'siteurl' ); ?>/wp-login.php?loginFacebook=1&redirect=<?php bloginfo( 'siteurl' ); ?>" onclick="window.location = '<?php bloginfo( 'siteurl' ); ?>/wp-login.php?loginFacebook=1&redirect='+window.location.href; return false;">Đăng ký với Facebook</a>
            </div>
        </div>
        <div class="reg-form">
            <form action="" method="post" id="registerform" name="registerform">
                <label for="username">Tên đăng nhập *</label>
                <span class="input-text">
                    <input type="text" value="<?php echo getRequest('username'); ?>" name="username" id="username" />
                </span>
                <label for="user_email">Email *</label>
                <span class="input-text">
                    <input type="text" value="<?php echo getRequest('email'); ?>" name="email" id="user_email" />
                </span>
                <label>Ngày sinh</label>
                <span class="input-text">
                    <select name="user_dob_day">
                        <?php for ($i = 1; $i <= 31; $i++): ?>
                            <?php if($i == getRequest('user_dob_day')): ?>
                            <option value="<?php echo $i; ?>" selected="selected"><?php echo $i; ?></option>
                            <?php else: ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </select>
                </span>
                <span class="input-text">
                    <select name="user_dob_month">
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                            <?php if($i == getRequest('user_dob_month')): ?>
                            <option value="<?php echo $i; ?>" selected="selected"><?php echo $i; ?></option>
                            <?php else: ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </select>
                </span>
                <input type="text" value="<?php echo getRequest('user_dob_year'); ?>" name="user_dob_year" class="input-dob" />
                
                <label for="user_pass">Mật khẩu *</label>
                <span class="input-text">
                    <input type="password" value="<?php echo getRequest('pwd'); ?>" name="pwd" id="user_pass" />
                </span>
                
                <label for="user_pass2">Nhập lại mật khẩu *</label>
                <span class="input-text">
                    <input type="password" value="" name="repwd" id="user_pass2" />
                </span>
                <label for="captcha">Mã bảo vệ *</label>
                <span class="input-text">
                    <input type="text" value="" name="captcha" id="captcha" style="width: 195px;" class="fl" />
                    <img alt="" src="<?php bloginfo( 'stylesheet_directory' ); ?>/includes/captcha.php" width="123" height="50" class="fr" />
                    <div class="clearfix"></div>
                </span>
                <div class="btn-bot">
                    <div class="links">
                        <a href="<?php echo get_page_link(get_option('appsreview_pageLoginID')); ?>">Đăng nhập</a>
                        <a href="<?php bloginfo( 'siteurl' ); ?>/wp-login.php?action=lostpassword">Quên mật khẩu?</a>
                    </div>
                    <input type="submit" class="btn-submit" id="btnReg" value="Đăng ký" />
                    <div class="clearfix"></div>
                    <input type="hidden" name="token" value="<?php echo random_string(); ?>" />
                    <input type="hidden" name="redirect_to" value="<?php echo (getRequest('redirect_to') != "") ? getRequest('redirect_to') : home_url(); ?>" />
                </div>
            </form>
        </div>
    </div>

    <!--/.main-content-->
    <?php get_sidebar(); ?>
    <div class="clearfix"></div>
</div>
<script type="text/javascript">
    $(function(){
        User.register();
    });
</script>

<?php get_footer(); ?>