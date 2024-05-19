# Document Management System

This is a Document Management System built using PHP 8.1.26 and CodeIgniter v4.5.1.

## Requirements

- PHP 8.1.26
- Composer

## Installation

1. Clone the repository:

    ```sh
    git clone [https://github.com/your-repo/document-management-system.git](https://github.com/Ajeeshks857/www.onlinedocument.com.git)
    cd www.onlinedocument.com
    ```

2. Install the dependencies:

    ```sh
    composer install
    ```

3. Set up your database:

    Update the `.env` file with your database configuration. For example:

    ```dotenv
    database.default.hostname = localhost
    database.default.database = your_database
    database.default.username = your_username
    database.default.password = your_password
    database.default.DBDriver = MySQLi
    ```

4. Run the migrations:

    ```sh
    php spark migrate
    ```

5. Seed the database:

    ```sh
    php spark db:seed RolesSeeder
    php spark db:seed UsersSeeder
    ```

6. Start the development server:

    ```sh
    php spark serve
    ```

## Default Users

### Admin

- **Email**: admin@codepoint.com
- **Password**: Admin@123

### User

- **Email**: user@codepoint.com
- **Password**: User@123

## Usage

1. Navigate to `http://localhost:8080` in your web browser.
2. Log in using the default admin or user credentials provided above.

## Contributing

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Make your changes.
4. Commit your changes (`git commit -am 'Add new feature'`).
5. Push to the branch (`git push origin feature-branch`).
6. Create a new Pull Request.

## License

This project is licensed under the MIT License.
