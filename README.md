# Shonen Street - E-commerce Platform

A modern e-commerce platform built with Laravel 10+, Vue 3, Inertia.js, and Tailwind CSS. Features a clean architecture following SOLID principles with separate admin and client interfaces.

## Features

### Admin Features

- 🔐 Secure admin authentication (separate from client auth)
- 👥 User management (CRUD operations)
- 📦 Product management with image uploads
- 📊 Order management with status tracking
- 🔔 Real-time notifications:
    - Low stock alerts (when stock < 10 units)
    - New order notifications
    - Daily sales reports (scheduled)
- 📈 Order status workflow: pending → processing → shipped → delivered

### Client Features

- 🛒 Shopping cart functionality
- 🔍 Product search and filtering
- 💳 Checkout process with shipping information
- 📧 Order confirmation emails
- 🔔 Order status update notifications
- 📱 Responsive design

## Tech Stack

- **Backend**: Laravel 10+
- **Frontend**: Vue 3 + Inertia.js
- **Styling**: Tailwind CSS + Shadcn UI
- **Database**: MySQL / PostgreSQL
- **Queue**: Database queue driver
- **Email**: Laravel Mail with custom templates

## Installation

### Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js 18+ and npm
- MySQL or PostgreSQL
- Laravel Herd (recommended) or Valet

### Setup Steps

1. **Clone the repository**

```bash
git clone <repository-url>
cd Shonen_street
```

2. **Install PHP dependencies**

```bash
composer install
```

3. **Install Node dependencies**

```bash
npm install
```

4. **Environment configuration**

```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure your `.env` file**

```env
APP_NAME="Shonen Street"
APP_URL=http://shonen_street.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shonen_street
DB_USERNAME=your_username
DB_PASSWORD=your_password

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@shonenstreet.test"
MAIL_FROM_NAME="${APP_NAME}"

QUEUE_CONNECTION=database
```

6. **Create database**

```bash
# For MySQL
mysql -u root -p
CREATE DATABASE shonen_street;
exit;
```

7. **Run migrations and seeders**

```bash
php artisan migrate:fresh --seed
```

This will create:

- Admin user: `admin@shonenstreet.test` / `password`
- 20 sample client users
- 10 sample products

8. **Create storage symlink**

```bash
php artisan storage:link
```

9. **Build frontend assets**

```bash
# Development
npm run dev

# Production
npm run build
```

## Running the Application

### Development Mode

1. **Start the development server** (if not using Herd/Valet)

```bash
php artisan serve
```

2. **Start Vite dev server** (for hot module replacement)

```bash
npm run dev
```

3. **Start queue worker** (required for notifications)

```bash
php artisan queue:work
```

### Production Mode

1. **Build assets**

```bash
npm run build
```

2. **Run queue worker as a daemon**

```bash
php artisan queue:work --daemon
```

3. **Setup cron job for scheduled tasks**

```bash
# Edit crontab
crontab -e

# Add this line:
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Queue Configuration

The application uses Laravel's queue system for:

- Sending email notifications
- Low stock alerts
- Daily sales reports

### Running the Queue Worker

**Development:**

```bash
php artisan queue:work
```

**Production (with supervisor):**

Create `/etc/supervisor/conf.d/shonen-street-worker.conf`:

```ini
[program:shonen-street-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path-to-your-project/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=your-user
numprocs=2
redirect_stderr=true
stdout_logfile=/path-to-your-project/storage/logs/worker.log
stopwaitsecs=3600
```

Then:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start shonen-street-worker:*
```

## Scheduled Tasks

The application includes a daily sales report that runs every day at 6 PM.

### Manual Testing

```bash
# Test the daily sales report command
php artisan sales:daily-report
```

### Cron Setup

Add to your crontab:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Default Credentials

### Admin Access

- URL: `http://shonen_street.test/admin/login`
- Email: `admin@shonenstreet.test`
- Password: `password`

### Client Access

- URL: `http://shonen_street.test/login`
- Use any seeded user or register a new account

## Project Structure

```
app/
├── Actions/           # Business logic (SOLID principle)
│   ├── Cart/
│   ├── Order/
│   ├── Product/
│   └── User/
├── Console/
│   └── Commands/      # Scheduled commands
├── Events/            # Domain events
├── Http/
│   ├── Controllers/
│   │   ├── Admin/     # Admin controllers
│   │   └── Client/    # Client controllers
│   ├── Middleware/
│   └── Requests/      # Form validation
├── Jobs/              # Queued jobs
├── Listeners/         # Event listeners
├── Models/
├── Notifications/     # Email & database notifications
│   ├── Admin/
│   └── Client/
└── Services/          # Shared services

resources/
├── js/
│   ├── components/
│   │   ├── client/    # Client-specific components
│   │   └── ui/        # Shadcn UI components
│   ├── layouts/
│   │   ├── AppLayout.vue      # Admin layout
│   │   └── ClientLayout.vue   # Client layout
│   └── pages/
│       ├── admin/     # Admin pages
│       └── client/    # Client pages
└── views/
    └── emails/        # Email templates
```

## Key Features Explained

### Low Stock Notification

- Automatically triggered when product stock falls below 10 units
- Sends email to all admin users
- Queued for asynchronous processing

### Daily Sales Report

- Scheduled to run daily at 6 PM
- Includes:
    - Total orders
    - Total revenue
    - Products sold with quantities
- Sent to all admin users

### Order Status Workflow

Admins can update order status with flexible transitions:

- `pending` → any status
- `processing` → any status except `pending`
- `shipped` → `delivered` or `cancelled`
- `delivered` → (final state)
- `cancelled` → (final state)

### File Upload Configuration

The application supports product images up to 20MB. PHP limits are configured in:

- `public/.htaccess` (for Apache)
- `.user.ini` (for Laravel Herd/Valet)

If you encounter upload issues, restart your web server:

```bash
# For Laravel Herd
herd restart

# For Valet
valet restart
```

## Testing

### Manual Testing Checklist

**Admin:**

- [ ] Login as admin
- [ ] Create/edit/delete products
- [ ] Create/edit/delete users
- [ ] View orders
- [ ] Update order status
- [ ] Receive low stock notification (when stock < 10)
- [ ] Receive new order notification

**Client:**

- [ ] Register new account
- [ ] Login
- [ ] Browse products
- [ ] Search and filter products
- [ ] Add products to cart
- [ ] Update cart quantities
- [ ] Checkout with shipping info
- [ ] Receive order confirmation email
- [ ] Receive order status update email

### Queue Testing

```bash
# Start queue worker
php artisan queue:work

# In another terminal, trigger an action (e.g., place an order)
# Watch the queue worker process the jobs
```

## Troubleshooting

### Vite WebSocket Issues

If you see WebSocket connection errors, ensure `vite.config.ts` has:

```typescript
server: {
  host: 'shonen_street.test',
  hmr: {
    host: 'shonen_street.test',
  },
}
```

### Queue Not Processing

```bash
# Check failed jobs
php artisan queue:failed

# Retry failed jobs
php artisan queue:retry all

# Clear all jobs
php artisan queue:flush
```

### Email Not Sending

For development, use Mailhog:

```bash
# With Laravel Herd, Mailhog is included
# Access at: http://localhost:8025
```

### Database Issues

```bash
# Reset database
php artisan migrate:fresh --seed

# Check migrations status
php artisan migrate:status
```

## Contributing

1. Follow SOLID principles
2. Use Actions for business logic
3. Use Form Requests for validation
4. Keep controllers thin
5. Write descriptive commit messages

## License

This project is open-sourced software licensed under the MIT license.

## Support

For issues or questions, please create an issue in the repository.

---

**Built with ❤️ using Laravel, Vue, and Inertia.js**
