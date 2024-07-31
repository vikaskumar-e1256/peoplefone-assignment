```markdown
# Laravel 11 Notifications System

This project is a Laravel 11-based notifications system. It includes features such as creating notifications for users, marking notifications as read, “impersonate feature and displaying unread notifications with expiration handling.

## Installation

Follow these steps to set up the project:

### Prerequisites

Make sure you have the following installed on your machine:

- PHP 8.2 or higher
- Composer
- MySQL or any other supported database

### Steps

1. **Clone the repository:**
   ```bash
   https://github.com/vikaskumar-e1256/peoplefone-assignment.git
   cd your-repository
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install
   npm run build
   ```

3. **Copy the `.env.example` file to `.env`:**
   ```bash
   cp .env.example .env
   ```

4. **Generate the application key:**
   ```bash
   php artisan key:generate
   ```

5. **Configure your `.env` file:**

   Update the following variables in your `.env` file to match your database configuration:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run the database migrations and seeders:**
   ```bash
   php artisan migrate --seed
   ```

7. **Start the development server:**
   ```bash
   php artisan serve
   ```

8. **Login as admin:**

   Use the following credentials to log in as an admin:
   - **Email:** admin@admin.com
   - **Password:** 1234

## Usage

### Creating Notifications

To create a notification, navigate to the notifications creation page and fill out the form with the required details.

### Viewing Notifications

Users can view their notifications by clicking on the bell icon in the top bar. This will display a list of unread notifications.

### Marking Notifications as Read

Users can mark individual notifications as read by clicking on them. They can also mark all notifications as read using the "Mark All as Read" button.

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request with your changes.

## License

This project is open-source and available under the [MIT License](LICENSE).

## Support

If you encounter any issues or have questions, please open an issue on GitHub or contact the project maintainers.

---

```
Feel free to customize this `README.md` file further based on your project's specific details and requirements.
