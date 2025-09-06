# Book Management App

A Laravel application for managing books and book loans with API support.

## Features

- CRUD operations for books
- Book loan management
- RESTful API with filtering and search
- Authentication with Sanctum
- Queue system for email notifications
- OpenAPI documentation

## Requirements

- PHP 8.0+
- Composer
- MySQL or SQLite

## Installation

1. Clone the repository:
in Terminal
- git clone <repository-url>
- cd book-management-app
2. Install Dependencies
- composer install
3. Copy Env file
- cp .env.example .env (pakai env yang ada di env.example karena saya sudah copy paste dengan yang .env)
4. Generate Aplication Key
- php artisan key:generate
5. Run Migration and seed
- php artisan migrate
- php artisan db:seed
6. Install Sanctum
  - php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
  - php artisan migrate
7. Generate Swagger
- php artisan l5-swagger:generate
8. Run
- php artisan serve
9. Usage API Interface
- Visit http://localhost:8000/api/documentation#/ to access the book management interface.
API Endpoints
- GET /api/books - List books (with filters: author, year, search)
- POST /api/loans - Create a book loan
- GET /api/loans/{user_id} - Get user's active loan
10. API endpoints require Sanctum authentication. Include the token in the Authorization header "authorize"
11. php artisan queue:work
12. 
