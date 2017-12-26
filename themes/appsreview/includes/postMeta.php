<?php

/**
 * Custom post type
 */

# post meta box
$post_meta_box = array(
    'id' => 'post-meta-box',
    'title' => 'Thông tin bài viết',
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
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

// Add post meta box
add_action('admin_menu', 'post_add_box');
add_action('save_post', 'post_add_box');
add_action('save_post', 'post_save_data');

function post_add_box(){
    global $post_meta_box;
    add_meta_box($post_meta_box['id'], $post_meta_box['title'], 'post_show_box', $post_meta_box['page'], $post_meta_box['context'], $post_meta_box['priority']);
}

function post_show_box() {
    // Use nonce for verification
    global $post_meta_box, $post;
    custom_output_meta_box($post_meta_box, $post);
}

// Save data from post meta box
function post_save_data($post_id) {
    global $post_meta_box;
    custom_save_meta_box($post_meta_box, $post_id);
}