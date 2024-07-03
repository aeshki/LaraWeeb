## Table of Contents
1. [Introduction](#introduction)
2. [Prerequisites](#prerequisites)
3. [Installation](#installation)
4. [Usage](#usage)
5. [Contributing](#contributing)
6. [License](#license)

## Introduction

About
LaraWeeb is an open-source project based on Laravel 11 and Vue3 technologies powered by ViteJs. It's a template that allows you to easily create a social network with an anime / video game / manga theme.


## Prerequisites

List the software and tools required to run the project:

- [Composer](https://getcomposer.org/) (version 2.7.2 or higher)
- [PHP](https://www.php.net/) (version 8.2.0 or higher)
- [Node.js](https://nodejs.org/) and [NPM](https://www.npmjs.com/) or [PNPM](https://pnpm.io/fr/)
- [MySQL](https://www.mysql.com/) or any other database supported by Laravel

## Installation

Steps to install and set up your project locally:

1. Clone the repository:
    ```sh
    git clone https://github.com/aeshki/LaraWeeb.git
    cd LaraWeeb
    ```

2. Install PHP dependencies with Composer:
    ```sh
    composer install
    ```

3. Install JavaScript dependencies with NPM or PNPM:
    ```sh
    npm i
    ```
    or
    ```sh
    pnpm i
    ```

4. Create a copy of the `.env` file:
    ```sh
    copy .env.example .env
    ```

5. Generate an application key:
    ```sh
    php artisan key:generate
    ```

6. Configure your database in the `.env` file ( optional ):
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
    ```

7. Run the migrations to create the tables in the database:
    ```sh
    php artisan migrate
    ```

8. (Optional) Run the seeders to add sample data:
    ```sh
    php artisan db:seed
    ```

## Usage

How to use or start the project:

1. Start the Laravel development server:
    ```sh
    php artisan serve
    ```
2. Start the ViteJs development server:
    ```sh
    npm run dev
    ```
    or
    ```sh
    pnpm run dev
    ```

3. Access the application in your browser at:
    ```
    http://localhost:8000
    ```
4. Login with admin user ( optional ):
    ```
    E-mail: admin@laraweeb.com
    Password: admin
    ```

## Contributing

If you want to contribute, here are some steps to get started:

1. Fork the project
2. Create a branch for your feature:
    ```sh
    git checkout -b new-feature
    ```
3. Commit your changes:
    ```sh
    git commit -m 'Add some feature'
    ```
4. Push to the branch:
    ```sh
    git push origin new-feature
    ```
5. Open a Pull Request

## License

This project is licensed under the [Apache 2.0 ] - see the [LICENSE](LICENSE) file for details.