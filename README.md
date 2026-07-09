# Online Examination System (Laravel)

A web-based online examination system built with **Laravel 11** and **MySQL**.

## Features
- Welcome page with Start Test button
- Multiple-choice questions loaded from a PDF file
- 30-minute timer with auto-submit
- Results with correct/wrong/unanswered counts, score, and percentage
- Negative marking: +1 correct, -0.5 wrong, 0 unanswered

## Requirements
- PHP 8.1+
- Composer
- MySQL

## Setup

```bash
# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Configure MySQL in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=online_exam
DB_USERNAME=root
DB_PASSWORD=

# Create the database
mysql -u root -p -e "CREATE DATABASE online_exam"

# Run migrations
php artisan migrate

# Seed questions from PDF
php artisan db:seed

# Start the server
php artisan serve
```

Visit `http://localhost:8000`

## PDF Format
The PDF must follow this format:
```
Q1. What is Python?
A. Programming Language
B. Database
C. Browser
D. Operating System
Answer: A
```

Place your PDF as `storage/app/pdfs/questions.pdf` and run `php artisan db:seed` to reload.
