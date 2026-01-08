<?php

if (!defined('ABSPATH')) {
    exit;
}

class Task_Manager_API {
    
    public static function register_routes() {
        register_rest_route('tasks/v1', '/all', array(
            'methods' => 'GET',
            'callback' => array(__CLASS__, 'get_all_tasks'),
            'permission_callback' => array(__CLASS__, 'check_permission'),
        ));
        
        register_rest_route('tasks/v1', '/create', array(
            'methods' => 'POST',
            'callback' => array(__CLASS__, 'create_task'),
            'permission_callback' => array(__CLASS__, 'check_permission'),
        ));
        
        register_rest_route('tasks/v1', '/(?P<id>\d+)', array(
            'methods' => 'GET',
            'callback' => array(__CLASS__, 'get_task'),
            'permission_callback' => array(__CLASS__, 'check_permission'),
        ));
        
        register_rest_route('tasks/v1', '/(?P<id>\d+)/update', array(
            'methods' => 'POST',
            'callback' => array(__CLASS__, 'update_task'),
            'permission_callback' => array(__CLASS__, 'check_permission'),
        ));
        
        register_rest_route('tasks/v1', '/(?P<id>\d+)/delete', array(
            'methods' => 'POST',
            'callback' => array(__CLASS__, 'delete_task'),
            'permission_callback' => array(__CLASS__, 'check_permission'),
        ));
    }
    
    public static function check_permission() {
        return current_user_can('edit_posts');
    }
    
    public static function get_all_tasks($request) {
        $tasks = Task_Manager_Database::get_all_tasks();
        return new WP_REST_Response(array(
            'success' => true,
            'data' => $tasks
        ), 200);
    }
    
    public static function get_task($request) {
        $id = $request->get_param('id');
        $task = Task_Manager_Database::get_task($id);
        
        if (!$task) {
            return new WP_REST_Response(array(
                'success' => false,
                'message' => 'Task not found'
            ), 404);
        }
        
        return new WP_REST_Response(array(
            'success' => true,
            'data' => $task
        ), 200);
    }
    
    public static function create_task($request) {
        $params = $request->get_json_params();
        
        if (empty($params['title'])) {
            return new WP_REST_Response(array(
                'success' => false,
                'message' => 'Title is required'
            ), 400);
        }
        
        $task_id = Task_Manager_Database::create_task($params);
        
        if (!$task_id) {
            return new WP_REST_Response(array(
                'success' => false,
                'message' => 'Failed to create task'
            ), 500);
        }
        
        $task = Task_Manager_Database::get_task($task_id);
        
        return new WP_REST_Response(array(
            'success' => true,
            'message' => 'Task created successfully',
            'data' => $task
        ), 201);
    }
    
    public static function update_task($request) {
        $id = $request->get_param('id');
        $params = $request->get_json_params();
        
        $result = Task_Manager_Database::update_task($id, $params);
        
        if ($result === false) {
            return new WP_REST_Response(array(
                'success' => false,
                'message' => 'Failed to update task'
            ), 500);
        }
        
        $task = Task_Manager_Database::get_task($id);
        
        return new WP_REST_Response(array(
            'success' => true,
            'message' => 'Task updated successfully',
            'data' => $task
        ), 200);
    }
    
    public static function delete_task($request) {
        $id = $request->get_param('id');
        
        $result = Task_Manager_Database::delete_task($id);
        
        if (!$result) {
            return new WP_REST_Response(array(
                'success' => false,
                'message' => 'Failed to delete task'
            ), 500);
        }
        
        return new WP_REST_Response(array(
            'success' => true,
            'message' => 'Task deleted successfully'
        ), 200);
    }
}
