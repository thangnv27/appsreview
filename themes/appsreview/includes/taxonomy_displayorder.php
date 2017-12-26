<?php
/**
 * @author Ngo Van Thang <ngothangit@gmail.com>
 * @copyright (c) 2013, Ngo Van Thang
 */

add_action('admin_init', 't_init');
// save our taxonomy image while edit or save term
add_action('edit_term', 't_save_taxonomy_displayorder');
add_action('create_term', 't_save_taxonomy_displayorder');

function t_init() {
    $z_taxonomies = get_taxonomies();
    if (is_array($z_taxonomies)) {
        foreach ($z_taxonomies as $z_taxonomy) {
            add_action($z_taxonomy . '_add_form_fields', 't_add_texonomy_field');
            add_action($z_taxonomy . '_edit_form_fields', 't_edit_texonomy_field');
            add_filter('manage_edit-' . $z_taxonomy . '_columns', 't_taxonomy_columns');
            add_filter('manage_' . $z_taxonomy . '_custom_column', 't_taxonomy_column', 10, 3);
        }
    }
}

// add image field in add form
function t_add_texonomy_field() {
    echo '<div class="form-field">
		<label for="taxonomy_displayorder">' . __('Display Order', 'zci') . '</label>
		<input type="text" name="taxonomy_displayorder" id="taxonomy_displayorder" value="1" />
	</div>';
}

// add image field in edit form
function t_edit_texonomy_field($taxonomy) {
    global $wp_query,$wpdb;
    
    //$displayorder = get_option('t_taxonomy_displayorder' . $taxonomy->term_id);
    
    $terms = $wpdb->prefix . "terms";
    $sql = "SELECT term_order FROM $terms WHERE term_id = {$taxonomy->term_id}";
    $term = $wpdb->get_row($sql);
    if($term){
        $displayorder = $term->term_order;
    }else{
        $displayorder = 0;
    }
    echo '<tr class="form-field">
		<th scope="row" valign="top"><label for="taxonomy_displayorder">' . __('Display Order', 'zci') . '</label></th>
		<td>
                    <input type="text" name="taxonomy_displayorder" id="taxonomy_displayorder" value="' . $displayorder . '" />
		</td>
	</tr>';
}

function t_save_taxonomy_displayorder($term_id) {
    global $wp_query,$wpdb;
    
    if (isset($_POST['taxonomy_displayorder'])){
        $displayorder = intval($_POST['taxonomy_displayorder']);
        //update_option('t_taxonomy_displayorder' . $term_id, $displayorder);
        $terms = $wpdb->prefix . "terms";
        $sql = "UPDATE $terms SET term_order = $displayorder WHERE term_id = $term_id";
        $wpdb->query($sql);
    }
}

/**
 * Thumbnail column added to category admin.
 *
 * @access public
 * @param mixed $columns
 * @return void
 */
function t_taxonomy_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['tax_disp_order'] = __('Display Order', 'zci');

    unset($columns['cb']);

    return array_merge($new_columns, $columns);
}

/**
 * Thumbnail column value added to category admin.
 *
 * @access public
 * @param mixed $columns
 * @param mixed $column
 * @param mixed $id
 * @return void
 */
function t_taxonomy_column($columns, $column, $id) {
    global $wp_query,$wpdb;
    
    if ($column == 'tax_disp_order'){
        //$columns = '<span>' . get_option('t_taxonomy_displayorder' . $id) . '</span>';
        $terms = $wpdb->prefix . "terms";
        $sql = "SELECT term_order FROM $terms WHERE term_id = {$taxonomy->term_id}";
        $term = $wpdb->get_row($sql);
        if($term){
            $displayorder = $term->term_order;
        }else{
            $displayorder = 0;
        }
        $columns = '<span>' . $displayorder . '</span>';
    }

    return $columns;
}
