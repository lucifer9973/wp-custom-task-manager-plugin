<?php
/**
 * Plugin Name: Task Manager API
 * Plugin URI: https://github.com/lucifer9973/wp-custom-task-manager-plugin
 * Description: Custom WordPress plugin with REST API for task management
 * Version: 1.0.0
 * Author: Lucifer9973
 * License: GPL v2 or later
 */

if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('TASK_MANAGER_API_DIR', plugin_dir_path(__FILE__));
define('TASK_MANAGER_API_URL', plugin_dir_url(__FILE__));
define('TASK_MANAGER_API_VERSION', '1.0.0');

// Include necessary files
require_once TASK_MANAGER_API_DIR . 'includes/class-database.php';
require_once TASK_MANAGER_API_DIR . 'includes/class-api.php';

// Activation hook
register_activation_hook(__FILE__, 'task_manager_api_activate');

function task_manager_api_activate() {
    Task_Manager_Database::create_table();
}

// Initialize plugin
add_action('plugins_loaded', 'task_manager_api_init');

function task_manager_api_init() {
    // Initialize API
    Task_Manager_API::register_routes();
}

// Deactivation hook
register_deactivation_hook(__FILE__, 'task_manager_api_deactivate');

function task_manager_api_deactivate() {
    // Cleanup if needed
}
