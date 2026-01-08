<?php

if (!defined('ABSPATH')) {
    exit;
}

class Task_Manager_Database {
    
    public static function create_table() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}tasks (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            title varchar(255) NOT NULL,
            description longtext,
            status varchar(50) DEFAULT 'pending',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    
    public static function get_all_tasks() {
        global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}tasks ORDER BY created_at DESC");
        return $results ? $results : array();
    }
    
    public static function get_task($id) {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}tasks WHERE id = %d", $id));
    }
    
    public static function create_task($data) {
        global $wpdb;
        $result = $wpdb->insert(
            $wpdb->prefix . 'tasks',
            array(
                'title' => sanitize_text_field($data['title']),
                'description' => isset($data['description']) ? sanitize_textarea_field($data['description']) : '',
                'status' => isset($data['status']) ? sanitize_text_field($data['status']) : 'pending',
            ),
            array('%s', '%s', '%s')
        );
        return $result ? $wpdb->insert_id : false;
    }
    
    public static function update_task($id, $data) {
        global $wpdb;
        return $wpdb->update(
            $wpdb->prefix . 'tasks',
            array(
                'title' => sanitize_text_field($data['title']),
                'description' => isset($data['description']) ? sanitize_textarea_field($data['description']) : '',
                'status' => isset($data['status']) ? sanitize_text_field($data['status']) : 'pending',
            ),
            array('id' => $id),
            array('%s', '%s', '%s'),
            array('%d')
        );
    }
    
    public static function delete_task($id) {
        global $wpdb;
        return $wpdb->delete(
            $wpdb->prefix . 'tasks',
            array('id' => $id),
            array('%d')
        );
    }
}
