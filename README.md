# Project Name

Laravel Multi Authentication

## Introduction

This project utilizes the Stisla admin template and the Spatie permission package to create a robust and user-friendly web application. Stisla provides a sleek and modern interface for the admin dashboard, while Spatie permission package offers a convenient way to manage user roles and permissions within the application.

## Features

- **Stisla Admin Template**: Utilize the modern and responsive Stisla admin template to create a visually appealing and intuitive dashboard interface.

- **Spatie Permission Package Integration**: Seamlessly integrate the Spatie permission package to manage user roles and permissions efficiently.

- **User Management**: Easily manage user accounts, roles, and permissions through the provided interface.

- **Role-Based Access Control (RBAC)**: Implement role-based access control to restrict access to certain features or sections of the application based on user roles.

- **Customization**: Extend and customize the functionality of the application according to specific project requirements.

## Installation

1. Clone the repository:

```bash
https://github.com/mdashraful305/laravel-multiauth.git
```

2. Navigate to the project directory:

```bash
cd laravel-multiauth
```

3. Install dependencies using Composer:

```bash
composer install
```

4. Set up your environment variables by copying the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

5. Generate a new application key:

```bash
php artisan key:generate
```

6. Configure your database settings in the `.env` file:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Migrate the database:

```bash
php artisan migrate
```

8. Seed the database with initial data:

```bash
php artisan db:seed
```

## Usage

1. Start the development server:

```bash
php artisan serve
```

2. Access the application in your web browser at `http://localhost:8000`.

3. Log in with the default credentials:

To access the application after installation, you can use the following default credentials for the predefined user roles:

- **Super Admin**:
  - **Email:** super@admin.com
  - **Password:** 123456

- **Admin**:
  - **Email:** admin@admin.com
  - **Password:** 123456

These credentials can be used to log in to the application and access the admin dashboard. It is recommended to change these default passwords and user details after the initial setup for security reasons.

## Credits

- Stisla Admin Template: [https://getstisla.com](https://getstisla.com)
- Spatie Permission Package: [https://spatie.be/docs/laravel-permission](https://spatie.be/docs/laravel-permission)

## License

This project is open-source and licensed under the [MIT License](https://opensource.org/license/mit/).
