# School Management System (Laravel)

A comprehensive School Management System built with Laravel, featuring student management, class lists, exam tracking, and user roles.

## Features

- **Student Management**: Add, edit, and track student records.
- **Class and Subject Organization**: Manage school classes and their associated subjects.
- **Exam Management**: Schedule exams, assign subjects, and record student marks.
- **User Roles**: Role-based access for Admins, Teachers, Students, and Parents.
- **Interactive Dashboards**: Data visualization and analytics (supported by Chart.js).
- **Dynamic Data Tables**: Fast and searchable listings using DataTables with AJAX.

## Tech Stack

- **Backend**: Laravel 8+
- **Frontend**: Blade Templates, Bootstrap, jQuery, DataTables
- **Database**: MySQL (XAMPP environment)

## Setup and Installation

### Prerequisites

- PHP 7.4+ (Included in XAMPP)
- Composer
- MySQL/MariaDB

### Installation Steps

1. **Clone the repository**:
   ```bash
   git clone [repository-url]
   cd SchoolLaravel
   ```

2. **Install Dependencies**:
   ```bash
   composer install
   ```

3. **Environment Configuration**:
   - Copy `.env.example` to `.env`.
   - Update database credentials in `.env`.
   ```bash
   cp .env.example .env
   ```

4. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

5. **Run Migrations and Seed Data**:
   ```bash
   php artisan migrate --seed
   ```

6. **Serve the Application**:
   ```bash
   php artisan serve
   ```

## Key Fixes and Improvements

During development, the following critical updates were made:
- **Environment Agnostic URLs**: Refactored hardcoded `http://localhost` links to use Laravel's `url()` helper.
- **Database Optimization**: Resolved `subjects.class_id` column conflicts and optimized AJAX data fetching.
- **Data Initialization**: Implemented a robust `DatabaseSeeder` to populate the application with trial data.
- **DataTables Stabilization**: Fixed "Unknown parameter" and AJAX errors across User, Student, and Occupation lists.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
