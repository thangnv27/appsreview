<?php
/**
 * Cutstom Theme Panel
 */
$menuname = $shortname . "_settings"; // Required

$options = array(
    array("name" => "Pages",
        "type" => "title",
        "desc" => "Tùy chọn trang.",
    ),
    array("type" => "open"),
    array("name" => "Trang đăng ký",
        "desc" => "Nhập ID trang đăng ký tài khoản.",
        "id" => $shortname . "_pageRegisterID",
        "std" => '',
        "type" => "text"),
    array("name" => "Trang đăng nhập",
        "desc" => "Nhập ID trang đăng nhập.",
        "id" => $shortname . "_pageLoginID",
        "std" => '',
        "type" => "text"),
    array("name" => "Trang tin tức",
        "desc" => "Nhập ID trang tin tức.",
        "id" => $shortname . "_pageNewsID",
        "std" => '',
        "type" => "text"),
    array("type" => "close"),
    
    array("name" => "Tin tức",
        "type" => "title",
        "desc" => "Tùy chọn tin tức.",
    ),
    array("type" => "open"),
    array("name" => "Tin iOS",
        "desc" => "Nhập ID danh mục tin iOS.",
        "id" => $shortname . "_catIOSNewsID",
        "std" => '',
        "type" => "text"),
    array("name" => "Tin Android",
        "desc" => "Nhập ID danh mục tin Android.",
        "id" => $shortname . "_catAndroidNewsID",
        "std" => '',
        "type" => "text"),
    array("name" => "Tin khác",
        "desc" => "Nhập ID danh mục tin khác.",
        "id" => $shortname . "_catOtherNewsID",
        "std" => '',
        "type" => "text"),
    array("type" => "close"),
    
    array("name" => "Apps Review",
        "type" => "title",
        "desc" => "Tùy chọn tin apps review.",
    ),
    array("type" => "open"),
    array("name" => "iOS",
        "desc" => "Nhập ID danh mục iOS.",
        "id" => $shortname . "_catIOSAppsID",
        "std" => '',
        "type" => "text"),
    array("name" => "Android",
        "desc" => "Nhập ID danh mục Android.",
        "id" => $shortname . "_catAndroidAppsID",
        "std" => '',
        "type" => "text"),
    array("type" => "close"),
    
    array("name" => "Tùy chọn khác",
        "type" => "title",
        "desc" => "Tìm chỉnh website.",
    ),
    array("type" => "open"),
    array("name" => "Google Analytics",
        "desc" => "Google Analytics. Ví dụ: UA-23200894-1",
        "id" => $shortname . "_gaID",
        "std" => "UA-23200894-1",
        "type" => "text"),
    array("type" => "close"),
);

$fields = array(
    "keywords_meta", "description_meta", "favicon", "sitelogo", "logo2", "banner_top", "banner_top_link",
    "ad_right", "ad_right_link",
);

/**
 * Add actions
 */
add_action('admin_init', 'theme_settings_init');
add_action('admin_menu', 'add_settings_page');

/**
 * Register settings
 */
function theme_settings_init(){
    register_setting( "theme_settings", "theme_settings");
}

/**
 * Add settings page menu
 */
function add_settings_page(){
    global $themename, $shortname, $menuname, $options, $fields;
    
    add_menu_page(__($themename . ' Settings'), // Page title
            __($themename.' Settings'), // Menu title
            'manage_options', // Capability - see: http://codex.wordpress.org/Roles_and_Capabilities#Capabilities
            $menuname, // menu id - Unique id of the menu
            'theme_settings_page',// render output function
            '', // URL icon, if empty default icon
            null // Menu position - integer, if null default last of menu list
        );
    
    //Add submenu page
    add_submenu_page($menuname, //Menu ID – Defines the unique id of the menu that we want to link our submenu to. 
                                    //To link our submenu to a custom post type page we must specify - 
                                    //edit.php?post_type=my_post_type
            __('Theme Options'), // Page title
            __('Theme Options'), // Menu title
            'edit_themes', // Capability - see: http://codex.wordpress.org/Roles_and_Capabilities#Capabilities
            'theme_options', // Submenu ID – Unique id of the submenu.
            'theme_options_page' // render output function
        );
    
    //add_theme_page("$themename Options", "$themename Options", 'edit_themes', 'theme_options', 'theme_options_page');

    /*-------------------------------------------------------------------------*/
    # Theme general settings
    /*-------------------------------------------------------------------------*/
    if ($_GET['page'] == $shortname . '_settings') {
        if (isset($_REQUEST['action']) and 'save' == $_REQUEST['action']) {
            foreach ($fields as $field) {
                update_option($field, $_REQUEST[$field]);
            }
            foreach ($fields as $field) {
                if (isset($_REQUEST[$field])) {
                    update_option($field, $_REQUEST[$field]);
                } else {
                    delete_option($field);
                }
            }
            header("Location: {$_SERVER['REQUEST_URI']}&saved=true");
            die();
        } 
    }
    /*-------------------------------------------------------------------------*/
    # Theme options processing
    /*-------------------------------------------------------------------------*/
    if ($_GET['page'] == 'theme_options') {
        if (isset($_REQUEST['action']) and 'save' == $_REQUEST['action']) {
            foreach ($options as $value) {
                update_option($value['id'], $_REQUEST[$value['id']]);
            }
            foreach ($options as $value) {
                if (isset($_REQUEST[$value['id']])) {
                    update_option($value['id'], $_REQUEST[$value['id']]);
                } else {
                    delete_option($value['id']);
                }
            }
            header("Location: {$_SERVER['REQUEST_URI']}&saved=true");
            die();
        } else if (isset($_REQUEST['action']) and 'reset' == $_REQUEST['action']) {
            foreach ($options as $value) {
                delete_option($value['id']);
                update_option($value['id'], $value['std']);
            }
            header("Location: {$_SERVER['REQUEST_URI']}&reset=true");
            die();
        }
    }
    
    /*-------------------------------------------------------------------------*/
    # Retitle for first sub-menu
    /*-------------------------------------------------------------------------*/
    global $submenu;
    if(isset($submenu[$shortname . '_settings'][0][0]) and $submenu[$shortname . '_settings'][0][0] == $themename . ' Settings'){
        $submenu[$shortname . '_settings'][0][0] = 'General Settings';
    }
}

/**
 * Remove an Existing Sub-Menu
 */
function remove_settings_submenu($menu_name, $submenu_name) {
    global $submenu;
    $menu = $submenu[$menu_name];
    if (!is_array($menu)) return;
    foreach ($menu as $submenu_key => $submenu_object) {
        if (in_array($submenu_name, $submenu_object)) {// remove menu object
            unset($submenu[$menu_name][$submenu_key]);
            return;
        }
    }          
}

/**
 * Theme general settings ouput
 * 
 * @global string $themename
 */
function theme_settings_page() {
    global $themename;
?>
    <div class="wrap">
        <div class="opwrap" style="margin-top: 10px;" >
            <div class="icon32" id="icon-options-general"></div>
            <h2 class="wraphead"><?php echo $themename; ?> theme general settings</h2>
    <?php
    if (isset($_REQUEST['saved']))
        echo '<div id="message" class="updated fade"><p><strong>' . $themename . ' settings saved.</strong></p></div>';
    ?>
            <form method="post">
                <h3>Site Options</h3>
                <table class="form-table">
                    <tr>
                        <th><label for="keywords_meta">Keywords meta</label></th>
                        <td>
                            <input type="text" name="keywords_meta" id="keywords_meta" value="<?php echo stripslashes(get_settings('keywords_meta'));?>" class="regular-text" />
                            <br />
                            <span class="description">Enter the meta keywords for all pages. These are used by search engines to index your pages with more relevance.</span>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="description_meta">Description meta</label></th>
                        <td>
                            <input type="text" name="description_meta" id="description_meta" value="<?php echo stripslashes(get_settings('description_meta'));?>" class="regular-text" />
                            <br />
                            <span class="description">Enter the meta description for all pages. This is used by search engines to index your pages more relevantly.</span>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="favicon">Favicon</label></th>
                        <td>
                            <input type="text" name="favicon" id="favicon" value="<?php echo stripslashes(get_settings('favicon'));?>" class="regular-text" />
                            <input type="button" id="upload_favicon_button" class="button button-upload" value="Upload" />
                            <br />
                            <span class="description">An icon associated with a particular website, and typically displayed in the address bar of a browser viewing the site.</span>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="sitelogo">Logo 1</label></th>
                        <td>
                            <input type="text" name="sitelogo" id="sitelogo" value="<?php echo stripslashes(get_settings('sitelogo'));?>" class="regular-text" />
                            <input type="button" id="upload_sitelogo_button" class="button button-upload" value="Upload" /><br />
                            <span class="description">Logo on top bar. Size: 217x50</span>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="logo2">Logo 2</label></th>
                        <td>
                            <input type="text" name="logo2" id="logo2" value="<?php echo stripslashes(get_settings('logo2'));?>" class="regular-text" />
                            <input type="button" id="upload_logo2_button" class="button button-upload" value="Upload" /><br />
                            <span class="description">Logo on header. Size: 304x90</span>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="banner_top">Banner Top</label></th>
                        <td>
                            <input type="text" name="banner_top" id="banner_top" value="<?php echo stripslashes(get_settings('banner_top'));?>" class="regular-text" />
                            <input type="button" id="upload_banner_top_button" class="button button-upload" value="Upload" /><br />
                            <span class="description">Banner on header. Size: 1180x90</span><br />
                            <input type="text" name="banner_top_link" id="banner_top_link" value="<?php echo stripslashes(get_settings('banner_top_link'));?>" class="regular-text" /><br />
                            <span class="description">Link for banner.</span>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="ad_right">Ad right</label></th>
                        <td>
                            <input type="text" name="ad_right" id="ad_right" value="<?php echo stripslashes(get_settings('ad_right'));?>" class="regular-text" />
                            <input type="button" id="upload_ad_right_button" class="button button-upload" value="Upload" /><br />
                            <span class="description">Banner on sidebar. Size: 220x300</span><br />
                            <input type="text" name="ad_right_link" id="ad_right_link" value="<?php echo stripslashes(get_settings('ad_right_link'));?>" class="regular-text" /><br />
                            <span class="description">Link for ad.</span>
                        </td>
                    </tr>
                </table>
                <div class="submit">
                    <input name="save" type="submit" value="Save changes" class="button button-large button-primary" />
                    <input type="hidden" name="action" value="save" />
                </div>
            </form>
        </div>
    </div>
<?php
}

/**
 * Theme options ouput
 * 
 * @global string $themename
 * @global array $options
 */
function theme_options_page(){
    global $themename, $options;
?>
    <div class="wrap">
        <div class="opwrap" style="background:#fff; margin:20px auto; width: 80%;" >
            <h2 class="wraphead" style="margin:10px 0px; padding:15px 10px; font-family:arial black; font-style:normal; background:#B3D5EF;"><b><?php echo $themename; ?> theme options</b></h2>
    <?php
    if (isset($_REQUEST['saved']))
        echo '<div id="message" class="updated fade"><p><strong>' . $themename . ' settings saved.</strong></p></div>';
    if (isset($_REQUEST['reset']))
        echo '<div id="message" class="updated fade"><p><strong>' . $themename . ' settings reset.</strong></p></div>';
    ?>
            <form method="post">
    <?php
    foreach ($options as $value) {
        switch ($value['type']) {
            case "image":
                ?>
                            <tr>
                                <td width="30%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                                <td width="70%"><img src="<?php echo $value['id']; ?>" /></td>
                            </tr>
                            <tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #ffffff;">&nbsp;</td></tr>
                            <tr><td colspan="2">&nbsp;</td></tr>
                <?php
                break;
            case "open":
                ?>
                            <table width="100%" border="0" style="background-color:#eef5fb; padding:10px;">
                <?php
                break;
            case "close":
                ?>
                            </table><br />
                <?php
                break;
            case "break":
                ?>
                            <tr><td colspan="2" style="border-top:1px solid #C2DCEF;">&nbsp;</td></tr>
                <?php
                break;
            case "title":
                ?>
                            <table width="100%" border="0" style="background-color:#dceefc; padding:5px 10px;"><tr>
                                    <td colspan="2"><h3 style="font-size:18px;font-family:Georgia,'Times New Roman',Times,serif;"><?php echo $value['name']; ?></h3></td>
                                </tr>
                <?php
                break;
            case 'text':
                ?>
                                <tr>
                                    <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                                    <td width="80%"><input style="width:400px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if (get_settings($value['id']) != "") {
                    echo get_settings($value['id']);
                } else {
                    echo $value['std'];
                } ?>" /></td>
                                </tr>
                                <tr>
                                    <td><small><?php echo $value['desc']; ?></small></td>
                                </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #ffffff;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
                <?php
                break;
            case 'textarea':
                ?>
                                <tr>
                                    <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                                    <td width="80%"><textarea name="<?php echo $value['id']; ?>" style="width:400px; height:200px;" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if (get_settings($value['id']) != "") {
                    echo stripslashes(get_settings($value['id']));
                } else {
                    echo $value['std'];
                } ?></textarea></td>
                                </tr>
                                <tr>
                                    <td><small><?php echo $value['desc']; ?></small></td>
                                </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #ffffff;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
                <?php
                break;
            case 'select':
                ?>
                                <tr>
                                    <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                                    <td width="80%"><select style="width:240px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
                                        <?php foreach ($value['options'] as $key => $option) { ?>
                                            <option<?php if (get_settings($value['id']) == $key) {
                        echo ' selected="selected"';
                    } elseif ($key == $value['std']) {
                        echo ' selected="selected"';
                        } ?> value="<?php echo $key;?>"><?php echo $option; ?></option><?php } ?></select></td>
                                </tr>
                                <tr>
                                    <td><small><?php echo $value['desc']; ?></small></td>
                                </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #ffffff;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
                <?php
                break;
            case "checkbox":
                ?>
                                <tr>
                                    <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                                    <td width="80%"><? if (get_settings($value['id'])) {
                    $checked = "checked=\"checked\"";
                } else {
                    $checked = "";
                } ?>
                                        <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
                                    </td>
                                </tr>
                                <tr>
                                    <td><small><?php echo $value['desc']; ?></small></td>
                                </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #ffffff;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
                <?php
                break;
        }
    }
    ?>
                <p class="submit">
                    <input name="save" type="submit" value="Save changes" class="button button-large button-primary" />
                    <input type="hidden" name="action" value="save" />
                </p>
            </form>
            <form method="post">
                <input name="reset" type="submit" value="Reset" class="button button-large" />
                <input type="hidden" name="action" value="reset" />
            </form>
        </div>
    </div>
<?php
}