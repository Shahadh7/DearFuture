# DearFuture - Digital Memory Locker

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-red.svg" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.2+-blue.svg" alt="PHP Version">
  <img src="https://img.shields.io/badge/Vue.js-3.x-green.svg" alt="Vue.js Version">
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-38B2AC.svg" alt="TailwindCSS Version">
</p>

## About DearFuture

DearFuture is a modern web application that allows users to create digital time capsules - messages, photos, and videos that are automatically delivered to recipients at a specified future date. Built with Laravel 12, Vue.js 3, and TailwindCSS, it provides a secure and user-friendly platform for sending messages to the future.

### Key Features

- **Digital Time Capsules**: Create messages with text, images, and videos
- **Scheduled Delivery**: Set specific dates for automatic message delivery
- **Secure Storage**: Encrypted storage with secure delivery tokens
- **Media Support**: Upload and attach various media types (images, videos, audio)
- **User Authentication**: Secure user registration and login system
- **Delivery Tracking**: Monitor delivery status and history
- **Responsive Design**: Modern, mobile-friendly interface

## Technology Stack

### Backend
- **Laravel 12** - PHP web framework
- **SQLite** - Database (easily configurable for production)
- **Laravel Sanctum** - API authentication
- **Spatie Media Library** - File upload and management
- **Laravel Queue** - Background job processing

### Frontend
- **Vue.js 3** - Progressive JavaScript framework
- **Inertia.js** - Modern monolith approach
- **TailwindCSS** - Utility-first CSS framework
- **Heroicons** - Beautiful SVG icons
- **Vite** - Build tool and dev server

### Development Tools
- **Laravel Breeze** - Authentication scaffolding
- **Laravel Pint** - PHP code style fixer
- **PHPUnit** - Testing framework
- **Laravel Pail** - Log viewer

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js 18+ and npm
- SQLite (or MySQL/PostgreSQL for production)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd DearFuture
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Build assets**
   ```bash
   npm run build
   ```

7. **Start the development server**
   ```bash
   # Option 1: Use the convenience script
   composer run dev
   
   # Option 2: Start services individually
   php artisan serve
   php artisan queue:listen
   npm run dev
   ```

The application will be available at `http://localhost:8000`

## Configuration

### Mail Configuration
DearFuture uses Laravel's mail system for delivering time capsules. Configure your mail settings in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@dearfuture.com
MAIL_FROM_NAME="DearFuture"
```

### File Storage
Media files are stored using Laravel's file system. For production, consider using cloud storage:

```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your-key
AWS_SECRET_ACCESS_KEY=your-secret
AWS_DEFAULT_REGION=your-region
AWS_BUCKET=your-bucket
```

## Usage

### Creating a Time Capsule

1. Register an account or log in
2. Navigate to "Create Capsule"
3. Fill in the capsule details:
   - Title
   - Message content
   - Recipient email
   - Unlock date
   - Attach media files (optional)
4. Save as draft or lock the capsule

### Managing Capsules

- **Draft**: Capsules in progress that can be edited
- **Locked**: Capsules scheduled for delivery
- **Delivered**: Capsules that have been sent to recipients

### Delivery System

The application includes a command-line tool for processing deliveries:

```bash
php artisan capsules:deliver
```

This command:
- Finds capsules ready for delivery
- Sends emails to recipients
- Updates delivery status
- Logs delivery attempts

## Project Structure

```
DearFuture/
├── app/
│   ├── Console/Commands/     # Artisan commands
│   ├── Http/Controllers/     # Application controllers
│   ├── Models/              # Eloquent models
│   ├── Notifications/       # Email notifications
│   └── Policies/           # Authorization policies
├── resources/
│   └── js/
│       ├── Components/      # Vue components
│       ├── Layouts/         # Page layouts
│       └── Pages/          # Inertia pages
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/           # Database seeders
└── storage/
    └── mail-logs/         # Email delivery logs
```

## Testing

Run the test suite:

```bash
composer test
```

Or run specific test files:

```bash
php artisan test --filter CapsuleTest
```

## Deployment

### Production Considerations

1. **Database**: Use MySQL or PostgreSQL for production
2. **Queue Worker**: Set up a proper queue worker (Redis recommended)
3. **File Storage**: Use cloud storage (AWS S3, DigitalOcean Spaces, etc.)
4. **Mail Service**: Configure a reliable mail service (Mailgun, SendGrid, etc.)
5. **SSL**: Ensure HTTPS is enabled
6. **Environment**: Set `APP_ENV=production` and `APP_DEBUG=false`

### Deployment Commands

```bash
composer install --optimize-autoloader --no-dev
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For support and questions:
- Create an issue on GitHub
- Check the Laravel documentation
- Review the application logs

---

**DearFuture** - Sending messages to the future, one capsule at a time. 