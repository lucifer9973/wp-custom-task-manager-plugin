# WP Custom Task Manager Plugin

A lightweight WordPress plugin that demonstrates custom REST API development with database integration.

## Features

- **Custom REST API Endpoints** - Full CRUD operations for task management
- **Database Integration** - Uses WordPress `$wpdb` for data persistence
- **Security** - Includes nonce verification and authentication
- **No UI** - API-only plugin focusing on backend functionality

## REST API Endpoints

### Get All Tasks
```
GET /wp-json/tasks/v1/all
```
Retrieve all tasks from the database.

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Task Title",
      "description": "Task Description",
      "status": "pending",
      "created_at": "2024-01-08 10:00:00"
    }
  ]
}
```

### Create Task
```
POST /wp-json/tasks/v1/create
```
Create a new task.

**Request Body:**
```json
{
  "title": "New Task",
  "description": "Task description",
  "status": "pending"
}
```

**Required Headers:**
- `X-WP-Nonce: [nonce_value]` - WordPress nonce token

## Installation

1. Copy the `task-manager-api` folder to `/wp-content/plugins/`
2. Activate the plugin from WordPress admin
3. Plugin creates custom table on activation

## File Structure

```
task-manager-api/
├── task-manager-api.php          # Main plugin file
├── includes/
│   ├── class-database.php        # Database setup & queries
│   └── class-api.php             # REST API endpoints
└── README.md
```

## Technical Details

- **Language:** PHP 7.4+
- **Database:** Custom `wp_tasks` table
- **Authentication:** WordPress Nonce verification
- **Namespace:** `tasks/v1`

## Development

This plugin demonstrates:
- Custom post types via database
- REST API registration
- WordPress security practices
- Database migrations on activation
