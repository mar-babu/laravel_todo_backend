# 📝 TodoMaster - Laravel Todo App Api

*A sleek, productivity-boosting todo application with task management, deadlines, and collaboration features.*

[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-8892BF.svg)](https://php.net/)  
[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-FF2D20.svg)](https://laravel.com)  
[![Live Demo](https://img.shields.io/badge/LIVE_DEMO-▶_Launch_App-2EA043.svg)](https://todo-vue.ar-techpro.com)

---

## ✨ Key Features
✔️ **Create/Update/Delete Tasks**  
✔️ **Mark Tasks as Complete**  
✔️ **Secure Validation**  
✔️ **Clear Completed Tasks by One Click**  
✔️ **Filter Tasks Status**  
✔️ **Sunctum Authentication** (Login/Register/Logout)  
✔️ **Automated Tests** (12 Tests Passed)

---
## Apis Documentation For Authenticate and Task Module

```php
//Base Api URL
http://127.0.0.1:8000/api;
or
http://localhost:8000/api;
```

#### Register

<details>
<summary>
<code>POST</code> <code><b>/auth/register</b></code> <code>create an user</code>
</summary>

##### Parameters

> | name                  | type     | data type | description                |
> |-----------------------|----------|-----------|----------------------------|
> | name                  | required | string    | N/A              |
> | email                 | required | string    | unique string                        |
> | password              | integer | string    | N/A                        |
> | password_confirmation | required | string    | N/A                        |

##### Responses

> | http code | content-type | response 
> |-----------|--------------|----------
> | `201`     | `json`       | [] 

```php
{
    "status": true,
    "message": "User registered successfully.",
    "token": "1|NZo9LHRD8LD36eBwzP8ZS9KQfXwPpK8tSaaCTqhq8f93781d"
}
```

</details>


#### Login

<details>
<summary>
<code>POST</code> <code><b>/auth/login</b></code> <code>user login</code>
</summary>

##### Parameters

> | name                  | type     | data type | description                |
> |-----------------------|----------|-----------|----------------------------|
> | email                 | required | string    | unique string                        |
> | password              | integer | string    | N/A                        |

##### Responses

> | http code | content-type | response 
> |-----------|--------------|----------
> | `200`     | `json`       | [] 

```php
{
    "status": true,
    "message": "User logged in successfully",
    "token": "2|C7rSL7rPMadM4xgj6RPQGbvJiaUdqrHLCIV3r6Ol03696b94",
    "isVerified": false
}
```

</details>

#### Get All Tasks as List

<details>
<summary>
<code>GET</code> <code><b>/tasks</b></code> <code>get all the tasks list through this api</code>
</summary>


> Need authorize Bearer Token

##### Responses

> | http code | content-type | response 
> |-----------|--------------|----------
> | `200`     | `json`       | [] 

```php
[
    {
        "id": 4,
        "name": "Onboarding preparation",
        "description": "<p>Set up equipment for new hires starting Monday</p>",
        "status": 0,
        "status_name": "Pending"
    },
    {
        "id": 3,
        "name": "Nutrition consultation",
        "description": "<p>Review meal plans with weight loss clients</p>",
        "status": 2,
        "status_name": "Completed"
    },
    {
        "id": 2,
        "name": "Code review: payment module",
        "description": "<p>Review PR #142 for security vulnerabilities</p>",
        "status": 0,
        "status_name": "Pending"
    },
    {
        "id": 1,
        "name": "Team practice: 5pm",
        "description": "<p>Focus on defensive formations and set pieces</p>",
        "status": 0,
        "status_name": "Pending"
    }
]
```

</details>


#### Create Task

<details>
<summary>
<code>POST</code> <code><b>/tasks</b></code> <code>to create new task</code>
</summary>

##### Parameters

> | name                 | type     | data type | description |
> |----------------------|----------|-----------|-------------|
> | name                 | required | string    | N/A         |
> | description          | required | string    | N/A         |

##### Responses

> | http code | content-type | response 
> |-----------|--------------|----------
> | `200`     | `json`       | [] 

```php
{
    "success": true,
    "message": "Task created successfully."
}
```

</details>


#### Update Task

<details>
<summary>
<code>PUT</code> <code><b>/tasks/11</b></code> <code>to update a task</code>
</summary>

##### Parameters

> | name                 | type     | data type | description |
> |----------------------|----------|-----------|-------------|
> | name                 | required | string    | N/A         |
> | description          | required | string    | N/A         |

##### Responses

> | http code | content-type | response 
> |-----------|--------------|----------
> | `200`     | `json`       | [] 

```php
{
    "success": true,
    "message": "Task updated successfully.",
    "data": {
        "id": 11,
        "name": "Reach at ar-techpro.com",
        "description": "<p>To conduct and experience with future technology....<\/p>",
        "status": 0,
        "status_name": "Pending"
    }
}
```

</details>

#### Individual Task

<details>
<summary>
<code>GET</code> <code><b>/tasks/12</b></code> <code>get individual task</code>
</summary>

##### Responses

> | http code | content-type | response 
> |-----------|--------------|----------
> | `200`     | `json`       | [] 

```php
{
    "data": {
        "id": 12,
        "name": "Do the great job",
        "description": "<p>To conduct and experience with ar-techpro.com</p>",
        "status": 0,
        "status_name": "Pending"
    }
}
```

</details>

#### Destroy Task

<details>
<summary>
<code>DELETE</code> <code><b>/tasks/12</b></code> <code>delete individual task</code>
</summary>

##### Responses

> | http code | content-type | response 
> |-----------|--------------|----------
> | `200`     | `json`       | [] 

```php
{
    "success": true,
    "message": "Task deleted successfully."
}
```

</details>


#### Change Task Status (mark as complete)

<details>
<summary>
<code>PUT</code> <code><b>/tasks/11/status</b></code> <code>to change status that task would get complete or pending</code>
</summary>

##### Parameters

> | name        | type     | data type | description |
> |-------------|----------|-----------|-------------|
> | status      | required | string    | enum value  |

##### Responses

> | http code | content-type | response 
> |-----------|--------------|----------
> | `200`     | `json`       | [] 

```php
{
    "success": true,
    "message": "Task status updated successfully."
}
```

</details>



---

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- MySQL

```bash
# Clone & Setup
git clone https://github.com/mar-babu/laravel_todo_backend.git
cd laravel_todo_backend
composer install
cp .env.example .env
php artisan key:generate

# Configure Database (edit .env)
DB_CONNECTION=mysql
DB_DATABASE=todomaster
DB_USERNAME=root
DB_PASSWORD=

# Run Migrations
php artisan migrate --seed

# Start Server
php artisan serve

# Automated Tests
php artisan test

```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
