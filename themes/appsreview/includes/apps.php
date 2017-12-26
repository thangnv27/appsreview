<?php

/**
 * Apps Menu Page
 */

# Custom apps post type
add_action('init', 'create_apps_post_type');

function create_apps_post_type(){
    register_post_type('apps', array(
        'labels' => array(
            'name' => __('Apps'),
            'singular_name' => __('Apps'),
            'add_new' => __('Add new'),
            'add_new_item' => __('Add new Apps'),
            'new_item' => __('New Apps'),
            'edit' => __('Edit'),
            'edit_item' => __('Edit Apps'),
            'view' => __('View Apps'),
            'view_item' => __('View Apps'),
            'search_items' => __('Search Apps'),
            'not_found' => __('No Apps found'),
            'not_found_in_trash' => __('No Apps found in trash'),
        ),
        'public' => true,
        'show_ui' => true,
        'publicy_queryable' => true,
        'exclude_from_search' => false,
        'menu_position' => 20,
        'hierarchical' => false,
        'has_archive' => true,
        'query_var' => true,
        'supports' => array(
            'title', 'editor', 'comments', 'author', 'excerpt', 'thumbnail',
            'custom-fields'
        ),
        'taxonomies' => array('apps_category', 'post_tag'),
        'rewrite' => array('slug' => 'apps', 'with_front' => false),
        'can_export' => true,
        'description' => __('Apps description here.')
    ));
}

# Custom apps taxonomies
add_action('init', 'create_apps_taxonomies');

function create_apps_taxonomies(){
    register_taxonomy('apps_category', 'apps', array(
        'hierarchical' => true,
        'labels' => array(
            'name' => __('Apps Categories'),
            'singular_name' => __('Apps Categories'),
            'add_new' => __('Add New'),
            'add_new_item' => __('Add New Category'),
            'new_item' => __('New Category'),
            'search_items' => __('Search Categories'),
        ),
    ));
}

# apps meta box
$apps_meta_box = array(
    'id' => 'apps-meta-box',
    'title' => 'Thông tin ứng dụng',
    'page' => 'apps',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => 'Nhà phát hành',
            'desc' => '',
            'id' => 'nha_phat_hanh',
            'type' => 'text',
            'std' => '',
        ),
        array(
            'name' => 'Giá',
            'desc' => '',
            'id' => 'apps_price',
            'type' => 'text',
            'std' => '',
        ),
        array(
            'name' => 'Tin nổi bật',
            'desc' => 'Tin sẽ hiển thị trên danh sách tin nổi bật.',
            'id' => 'is_most',
            'type' => 'radio',
            'std' => '',
            'options' => array(
                '1' => 'Yes',
                '0' => 'No'
            )
        ),
));

// Add apps meta box
add_action('admin_menu', 'apps_add_box');
add_action('save_post', 'apps_add_box');
add_action('save_post', 'apps_save_data');

function apps_add_box(){
    global $apps_meta_box;
    add_meta_box($apps_meta_box['id'], $apps_meta_box['title'], 'apps_show_box', $apps_meta_box['page'], $apps_meta_box['context'], $apps_meta_box['priority']);
}

// Callback function to show fields in apps meta box
function apps_show_box() {
    global $apps_meta_box, $post;
    custom_output_meta_box($apps_meta_box, $post);
}

// Save data from apps meta box
function apps_save_data($post_id) {
    global $apps_meta_box;
    custom_save_meta_box($apps_meta_box, $post_id);
}

/***************************************************************************/
// ADD NEW COLUMN  
function apps_columns_head($defaults) {
    $defaults['is_most'] = 'Nổi bật';
    return $defaults;
}

// SHOW THE COLUMN
function apps_columns_content($column_name, $post_id) {
    if ($column_name == 'is_most') {
        $is_most = get_post_meta( $post_id, 'is_most', true );
        if($is_most == 1){
            echo '<a href="edit.php?update_is_most=true&post_id=' . $post_id . '&is_most=' . $is_most . '&redirect_to=' . urlencode(getCurrentRquestUrl()) . '">Yes</a>';
        }else{
            echo '<a href="edit.php?update_is_most=true&post_id=' . $post_id . '&is_most=' . $is_most . '&redirect_to=' . urlencode(getCurrentRquestUrl()) . '">No</a>';
        }
    }
}

// Update is most stataus
function update_apps_is_most(){
    if(getRequest('update_is_most') == 'true'){
        $post_id = getRequest('post_id');
        $is_most = getRequest('is_most');
        $redirect_to = urldecode(getRequest('redirect_to'));
        if($is_most == 1){
            update_post_meta($post_id, 'is_most', 0);
        }else{
            update_post_meta($post_id, 'is_most', 1);
        }
        header("location: $redirect_to");
        exit();
    }
}

add_filter('manage_posts_columns', 'apps_columns_head');  
add_action('manage_posts_custom_column', 'apps_columns_content', 10, 2);  
add_filter('admin_init', 'update_apps_is_most');  
