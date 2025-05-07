# 📝 TodoMaster - Laravel Todo App Api

*A sleek, productivity-boosting todo application with task management, deadlines, and collaboration features.*

[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-8892BF.svg)](https://php.net/)  
[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-FF2D20.svg)](https://laravel.com)  
[![Live Demo](https://img.shields.io/badge/LIVE_DEMO-▶_Launch_App-2EA043.svg)](https://todo-vue.ar-techpro.com)

![TodoMaster Dashboard Screenshot]()

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
