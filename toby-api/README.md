# Toby Clone - API (Laravel)

This directory contains the **Laravel backend API** for the Toby Clone. The API provides a set of RESTful endpoints for managing documents, collections, and user collaboration, and integrates with the Vue.js frontend.

## Features

- **RESTful API** for workspace and document management.
- **JWT-based Authentication** for secure user login and session handling.

---

## Tech Stack

- **Backend Framework**: Laravel (PHP).
- **Database**: MySQL.
- **Authentication**: JWT.

---

## Setup Instructions

Follow these steps to set up and run the Laravel API locally:

1. **Clone the repository** (if you haven’t already):
   ```bash
   git clone https://github.com/hetari/toby.git
   cd toby/toby_api
   ```

2. **Install dependencies**:
   ```bash
   composer install
   ```

3. **Create a `.env` file**: 
   ```bash
   cp .env.example .env
   ```

4. **Configure the `.env` file**:
   
   Update the `.env` file with your database configuration and other environment-specific settings:

   ```bash
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=toby_db
   DB_USERNAME=root
   DB_PASSWORD=yourpassword
   ```

   Optionally, configure your **JWT Secret** if you're using JWT for authentication:
   ```bash
   JWT_SECRET=your-jwt-secret
   ```

5. **Generate the application key**:
   ```bash
   php artisan key:generate
   ```

6. **Run database migrations** to set up the necessary tables:
   ```bash
   php artisan migrate
   ```

7. **Serve the API**:
   ```bash
   php artisan serve
   ```

   The Laravel API will now be running at `http://localhost:8000`.

---

## API Documentation

To view the API documentation, visit this endpoint: `http://localhost:8000/docs/api`.

---

## Database Migrations

If you need to rollback the migrations or refresh the database, you can use the following commands:

- **Rollback Migrations**:
   ```bash
   php artisan migrate:rollback
   ```

- **Refresh Migrations** (rollback all and re-run):
   ```bash
   php artisan migrate:refresh
   ```

---

## Testing

To run unit tests or feature tests for the API, use Laravel’s testing framework:

1. **Run Tests**:
   ```bash
   php artisan test
   ```

Ensure that your testing environment is properly configured in your `.env.testing` file if you need separate database credentials.

---

## Contributing

Contributions to the API are welcome! To contribute:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Commit your changes (`git commit -m 'Add new feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Submit a pull request.

---

## License

This project is licensed under the MIT License. See the [LICENSE](../LICENSE) file for more information.
