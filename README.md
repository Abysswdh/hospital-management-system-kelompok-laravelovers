# Hospital Management System

A Laravel-based hospital management system scaffold. This project includes foundational application structure with models and database migrations for hospital entities.

## Project Overview

The current codebase provides a skeleton Laravel application with the following domain models:

- `Doctor`
- `Patient`
- `Schedule`
- `Appointment`
- `MedicalRecord`
- `File`

Each model currently extends Laravel's base `Model` class and is paired with a migration that creates the corresponding table with standard primary key and timestamps.

## Current Status

- Laravel 12 application skeleton
- Default route: `/` returning the default `welcome` view
- No custom controllers or UI workflows implemented yet
- Schema setup for hospital-related tables with placeholder fields

## Requirements

- PHP 8.2+
- Composer
- Node.js and npm

## Setup

1. Install PHP dependencies:
   ```bash
   composer install
   ```
2. Copy the environment file and generate app key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
3. Run migrations:
   ```bash
   php artisan migrate
   ```
4. Install frontend dependencies:
   ```bash
   npm install
   ```
5. Build assets for production:
   ```bash
   npm run build
   ```

## Development

Start the local development server:

```bash
php artisan serve
```

Open your browser at `http://127.0.0.1:8000`.

## Notes

This repository currently contains the base data model and migration structure for a hospital management application, but it does not yet include business logic, form handling, or a complete administrative interface. Additional controllers, views, and API endpoints are required to make it a full working system.

## License

This project is open source and available under the MIT license.
