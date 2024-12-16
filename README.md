Laravel Shopping Cart Application

Introduction

This is a Laravel-based shopping cart application with features like product management, cart functionality, and order processing. This guide provides steps to set up the project, understand its functionality, and manage the provided sample files.

Features

Product Management (CRUD operations)

File Uploads for Product Images

Shopping Cart

Checkout with Order Processing

Import Products from CSV

Soft Delete and Force Delete for Products

Prerequisites

Before you begin, ensure you have the following:

PHP >= 8.1

Composer

MySQL

Node.js & npm (for frontend assets)

Laravel Installer

Installation Steps

Clone the Repository:

git clone https://github.com/your-repo/shopping-cart.git
cd shopping-cart

Install Dependencies:

composer install
npm install && npm run dev

Set Up Environment Variables:
Copy .env.example to .env and configure the database and other settings:

cp .env.example .env

Update your .env file with the following:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shopping_cart
DB_USERNAME=root
DB_PASSWORD=

AWS_ACCESS_KEY_ID=your-access-key
AWS_SECRET_ACCESS_KEY=your-secret-key
AWS_DEFAULT_REGION=your-region
AWS_BUCKET=your-bucket-name
AWS_URL=https://your-bucket-url

Generate Application Key:

php artisan key:generate

Run Migrations:

php artisan migrate

Seed Database (Optional):

php artisan db:seed

Link Storage:

php artisan storage:link

Run the Application:

php artisan serve

Access the application at http://127.0.0.1:8000.

Usage

Product Management

Navigate to the "Products" section to create, update, delete, and view products.

Use the import functionality to bulk upload products from a CSV file.

Shopping Cart

Add products to the cart and manage quantities.

Proceed to checkout to place an order.

Importing Products

Upload Sample File

A sample CSV file is provided in the storage/app/public directory.

File Path:

storage/app/public/product-sample.csv

File Content:

name,price,stock,description
Product 1,19.99,100,This is a description for Product 1
Product 2,29.99,50,This is a description for Product 2
Product 3,9.99,200,This is a description for Product 3

Steps to Import:

Navigate to the "Import Products" page.

Upload the product-sample.csv file.

The file will be processed and products will be added to the database.

Deployment

Set Up Server:

Ensure the server meets Laravel's requirements.

Set up a database.

Clone Repository on Server:

git clone https://github.com/your-repo/shopping-cart.git

Repeat Installation Steps:
Follow the same steps as in the local setup to install dependencies, set environment variables, and migrate the database.

Set Up Scheduler:
Add the Laravel scheduler to your cron jobs:

* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1

Set Up Queue:
Ensure the queue worker is running for jobs like product imports:

php artisan queue:work

Testing

Run automated tests using PHPUnit:

php artisan test

Notes

Ensure proper permissions for the storage and bootstrap/cache directories:

chmod -R 775 storage bootstrap/cache

Use the .env file to configure environment-specific settings.

Contribution Guidelines

Fork the repository.

Create a feature branch (git checkout -b feature-name).

Commit changes and push to your branch.

Open a pull request.

License

This project is open-sourced software licensed under the MIT license.