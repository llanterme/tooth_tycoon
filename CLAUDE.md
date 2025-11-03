# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Tooth Tycoon is a Laravel 10 application that gamifies tooth fairy rewards for children. Parents can track when their children lose teeth, set budgets, manage investments, and award badges with quizzes. The application has both a web admin panel (using AdminLTE) and a mobile API backend using Laravel Passport for authentication.

**Recent Update (November 2025)**: The application has been successfully upgraded from Laravel 7 → Laravel 8 → Laravel 9 → Laravel 10 with full PHP 8.1+ compatibility.

## Technology Stack

- **Backend Framework**: Laravel 10.x (PHP ^8.1)
  - ✅ **Fully compatible** with PHP 8.1+ and modern development practices
  - Upgraded from Laravel 7 through incremental versions (7→8→9→10)
- **Authentication**: Laravel Passport (^11.10) for OAuth2 API authentication
- **Admin Panel**: Laravel AdminLTE (^3.15.2)
- **Database**: MySQL
- **Frontend Assets**: Laravel Mix (Webpack), SASS
- **Testing**: PHPUnit 10.x

## Laravel 10 Upgrade History

### Upgrade Timeline (November 2025)

The application was successfully upgraded from Laravel 7 to Laravel 10 through incremental version upgrades:

**Phase 1: Laravel 7 → Laravel 8**
- Updated `composer.json` to require Laravel 8 framework
- Updated dependencies for Laravel 8 compatibility
- Resolved breaking changes from Laravel 8 upgrade guide

**Phase 2: Laravel 8 → Laravel 9**
- Updated to Laravel 9 framework
- Updated PHP requirement to ^8.0
- Resolved additional breaking changes

**Phase 3: Laravel 9 → Laravel 10**
- Updated to Laravel 10 framework
- Updated PHP requirement to ^8.1
- Updated Laravel Passport to ^11.10
- Updated testing framework to PHPUnit 10

**Phase 4: Database Migrations**
- Created Laravel 10-compatible migrations for all application tables:
  - `badges`: Achievement badges with quiz questions
  - `budgets`: Per-user reward budgets
  - `childe`: Children profiles
  - `pull_detail`: Tooth pulling records
  - `questions`: Badge-related quiz questions
  - `cash_outs`: Withdrawal transactions
  - `invest_amounts`: Investment records with compound interest
  - `teeth_details`: Teeth tracking details
  - `tooth_rewards`: Reward amounts per tooth type
  - `submit_questions`: User quiz submissions
  - `mile_stores`: Milestone achievements

**Phase 5: AdminLTE Compatibility**
- Resolved compatibility issues with Laravel AdminLTE package
- Removed outdated published views from Laravel 7 era
- Application now uses vendor's current views (v3.15.2) directly
- Fixed `@inject` directive syntax issues
- Removed references to deprecated helper methods

### Key Dependencies Updated

| Package | Old Version | New Version |
|---------|-------------|-------------|
| Laravel Framework | 7.x | 10.49.1 |
| Laravel Passport | 7.x | 11.10+ |
| Laravel AdminLTE | 3.4 | 3.15.2 |
| PHPUnit | 8.5 | 10.x |
| PHP | 7.2.5+ | 8.1+ |

## Local Deployment on Mac

### Prerequisites

This application requires PHP 8.1+, MySQL, Composer, and Node.js. Follow these steps to install them:

#### 1. Install Homebrew (if not already installed)
```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```

#### 2. Install PHP 8.1 or higher
```bash
# Install PHP (Laravel 10 requires PHP ^8.1)
brew install php@8.1

# Add PHP to your PATH
echo 'export PATH="/opt/homebrew/opt/php@8.1/bin:$PATH"' >> ~/.bash_profile
echo 'export PATH="/opt/homebrew/opt/php@8.1/sbin:$PATH"' >> ~/.bash_profile

# IMPORTANT: Restart your terminal or run this to apply changes:
source ~/.bash_profile

# Verify installation (should show PHP 8.1.x or higher)
php -v

# If php command is still not found, try:
/opt/homebrew/opt/php@8.1/bin/php -v
```

#### 3. Install Composer
```bash
# Download and install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Verify installation
composer --version
```

#### 4. Install MySQL
```bash
# Install MySQL
brew install mysql

# Start MySQL service
brew services start mysql

# Secure MySQL installation (optional but recommended)
mysql_secure_installation

# Create database
mysql -u root -p
# Then run: CREATE DATABASE tooth_tycoon;
# Exit with: exit;
```

#### 5. Install Node.js and NPM
```bash
# Install Node.js (includes NPM)
brew install node

# Verify installation
node -v
npm -v
```

### Initial Setup

Once prerequisites are installed, set up the application:

```bash
# 1. Install PHP dependencies
# Note: composer.json requires PHP ^8.1 and Laravel 10
composer install

# 2. Install NPM dependencies
npm install

# 3. Copy environment file
cp .env.example .env

# 4. Edit .env file and configure database
# Update these values in .env:
#   DB_DATABASE=tooth_tycoon
#   DB_USERNAME=root
#   DB_PASSWORD=your_mysql_password

# 5. Generate application key
php artisan key:generate

# 6. Create required directories and set correct permissions
mkdir -p storage/logs
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache
mkdir -p bootstrap/cache

chmod -R 775 storage bootstrap/cache
chmod -R 777 storage/logs
chmod -R 777 storage/framework

# 7. Run migrations to create database tables
php artisan migrate

# 8. Install Laravel Passport (OAuth2 for API)
php artisan passport:install
# Save the Client ID and Client Secret shown after this command

# 9. Seed the admin user
php artisan db:seed --class=AdminSeeder

# 10. Compile frontend assets
npm run dev
```

### Admin Login Credentials

After running the setup, you can log in to the admin panel at `http://127.0.0.1:8000/login`:

```
Email: admin@toothtycoon.com
Password: password
```

**⚠️ Important**: Change the default admin password after your first login for security.

### Running the Application Locally

```bash
# Start the Laravel development server (runs on http://localhost:8000)
php artisan serve

# In a separate terminal, watch and compile assets on change
npm run watch
```

The application will be available at:
- **Web Admin Panel**: http://localhost:8000/admin
- **API Endpoints**: http://localhost:8000/api/*
- **Home Page**: http://localhost:8000

### Troubleshooting Local Setup

**PHP command not found:**
```bash
# If php command not found after installation, ensure PATH is set:
source ~/.bash_profile

# Or manually use the full path:
/opt/homebrew/opt/php@8.1/bin/php -v

# Restart your terminal and try again
```

**Fatal error with "Storage/logs" pointing to wrong directory:**
This happens when cached config files have old paths. Fix it:
```bash
# 1. Clear cached config files
rm -rf bootstrap/cache/*.php

# 2. Create .env file if missing
cp .env.example .env

# 3. Create required directories
mkdir -p storage/logs storage/framework/sessions storage/framework/views storage/framework/cache

# 4. Set permissions
chmod -R 777 storage bootstrap/cache

# 5. Try composer dump-autoload again
composer dump-autoload
```

**AdminLTE View Compatibility (RESOLVED):**
If you encounter errors like `Undefined constant "JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper"`, this was an issue with outdated published AdminLTE views from the Laravel 7 era. The solution:

```bash
# Backup any published AdminLTE views
mv resources/views/vendor/adminlte resources/views/vendor/adminlte.backup-$(date +%Y%m%d-%H%M%S)

# Clear view cache
php artisan view:clear
php artisan config:clear
```

This allows Laravel to use the vendor package's up-to-date views (v3.15.2) directly. All customizations should be done through the `config/adminlte.php` configuration file rather than publishing views.

**Permission Issues:**
```bash
# If you get "Permission denied" errors for storage/logs
mkdir -p storage/logs
chmod -R 777 storage
chmod -R 777 bootstrap/cache

# Re-run composer autoload dump
composer dump-autoload
```

**Database Connection Issues:**
```bash
# Test MySQL connection
mysql -u root -p

# If MySQL isn't running
brew services restart mysql
```

**Composer Issues:**
```bash
# Clear Composer cache
composer clear-cache

# Update Composer itself
composer self-update
```

**Passport Issues:**
```bash
# If Passport keys are missing
php artisan passport:keys

# Reinstall Passport
php artisan passport:install --force
```

**Cache Issues:**
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Other Common Commands

### Asset Compilation
```bash
# Compile assets once (development)
npm run dev

# Watch and recompile assets on change
npm run watch

# Compile assets for production
npm run production
```

### Testing
```bash
# Run all tests
./vendor/bin/phpunit

# Run specific test suite
./vendor/bin/phpunit --testsuite Unit
./vendor/bin/phpunit --testsuite Feature

# Run specific test file
./vendor/bin/phpunit tests/Unit/ExampleTest.php
```

### Cache and Configuration
```bash
# Clear all caches (also available at /clear-cache route)
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Cache config for production
php artisan config:cache
```

### Database
```bash
# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Refresh database (drop and re-migrate)
php artisan migrate:refresh

# Run seeders
php artisan db:seed
```

## Architecture Overview

### Dual Interface Pattern

The application serves two distinct user interfaces:

1. **Web Admin Panel** (`/admin/*` routes in [routes/web.php](routes/web.php))
   - Traditional Laravel MVC with Blade templates
   - Uses AdminLTE theme for UI
   - Session-based authentication with custom `AdminCheck` middleware
   - Controllers in `app/Http/Controllers/` (e.g., AdminController, UserController, BadgesController)
   - Views in `resources/views/admin/`

2. **Mobile API** ([routes/api.php](routes/api.php))
   - RESTful API for mobile applications
   - Laravel Passport OAuth2 authentication (`auth:api` middleware)
   - Controllers in `app/Http/Controllers/API/`
   - Returns JSON responses

### Core Domain Models

The application revolves around a parent-child reward system:

- **User**: Parents who manage the system (uses Laravel Passport's `HasApiTokens`)
- **Childe** (sic): Children tracked by parents, with relationships to:
  - `PullDetails`: Records of teeth lost
  - `InvestAmount`: Investment tracking
  - `CashOut`: Withdrawal records
- **TeethDetails**: Tracks individual teeth pulled per user
- **Budget**: User's budget settings for tooth rewards
- **Badges**: Achievement badges that children can earn
- **Question**: Quiz questions associated with badges
- **ToothReward**: Global reward settings
- **Currency**: Currency configuration for the system

### Key Relationships

- User → hasMany → Childe (children)
- User → hasMany → TeethDetails
- User → hasOne → Budget
- Childe → hasMany → PullDetails (teeth pull history)
- Badges → hasMany → Questions (quiz questions for earning badges)

### API Authentication Flow

All protected API endpoints use `auth:api` middleware group (Laravel Passport). Public endpoints include:
- `/api/register` - User registration
- `/api/login` - User login
- `/api/Social` - Social login
- `/api/forgot` and `/api/reset` - Password reset

### Repository Pattern

The application uses a Repository pattern in `app/Http/Repository/` to abstract data access logic from controllers.

### Important Business Logic Locations

- **Tooth Pull Process**: [app/Http/Controllers/API/PullProcessController.php](app/Http/Controllers/API/PullProcessController.php) handles:
  - Setting budgets
  - Recording teeth pulls
  - Investment functionality
  - Cash out operations
  - Milestone tracking

- **Child Management**: [app/Http/Controllers/API/ChildController.php](app/Http/Controllers/API/ChildController.php)
  - CRUD operations for children
  - Pull history retrieval

- **Badge/Quiz System**: Questions are tied to badges, managed in [app/Http/Controllers/API/QuestionController.php](app/Http/Controllers/API/QuestionController.php) and [app/Http/Controllers/QuestionController.php](app/Http/Controllers/QuestionController.php)

## Configuration Notes

### Environment Variables

Copy `.env.example` to `.env` and configure:
- Database credentials (MySQL)
- Mail settings (for password reset emails)
- App URL and environment

### Laravel Passport

After initial setup, run `php artisan passport:install` to create encryption keys for API authentication. Client IDs and secrets will be generated for OAuth2.

### AdminLTE

The admin panel is configured in [config/adminlte.php](config/adminlte.php). The title prefix is "Admin - " and the main title is "Tooth".

**Important Note on AdminLTE Views:**
- **DO NOT** publish AdminLTE views using `php artisan vendor:publish`
- The application uses vendor package views directly (v3.15.2)
- Published views from older versions are incompatible with Laravel 10 and PHP 8.1+
- All customizations should be done through [config/adminlte.php](config/adminlte.php)
- If you have published views, back them up and remove them:
  ```bash
  mv resources/views/vendor/adminlte resources/views/vendor/adminlte.backup
  php artisan view:clear
  ```

**AdminLTE Package Compatibility:**
- Current version: v3.15.2
- Uses `SidebarItemHelper`, `LayoutHelper`, `PreloaderHelper` classes
- Blade `@inject` directives require string notation: `@inject('helper', 'ClassName')`
- Not compatible with old published views that use backslash notation: `@inject('helper', \ClassName)`

## Database Migrations

Migrations are in `database/migrations/`. The application uses Laravel Passport's OAuth tables plus custom tables for the tooth tracking system.

### Migration Files

All migrations have been updated for Laravel 10 compatibility (November 2025):

**Core Application Tables:**
- `2025_11_03_090829_create_badges_table.php` - Achievement badges
- `2025_11_03_090830_create_childe_table.php` - Children profiles
- `2025_11_03_090831_create_teeth_details_table.php` - Teeth tracking
- `2025_11_03_090831_create_tooth_rewards_table.php` - Reward amounts
- `2025_11_03_090832_create_budgets_table.php` - Budget settings
- `2025_11_03_090833_create_pull_detail_table.php` - Tooth pull records
- `2025_11_03_090834_create_questions_table.php` - Quiz questions
- `2025_11_03_090857_create_cash_outs_table.php` - Withdrawal transactions
- `2025_11_03_090857_create_invest_amounts_table.php` - Investment records
- `2025_11_03_090857_create_submit_questions_table.php` - Quiz submissions
- `2025_11_03_090858_create_mile_stores_table.php` - Milestones

**Laravel Passport Tables:**
- OAuth access tokens
- OAuth clients
- OAuth refresh tokens
- Personal access clients

All migrations use proper foreign key constraints and Laravel 10 migration syntax.

## Testing Configuration

PHPUnit is configured in [phpunit.xml](phpunit.xml) with:
- Unit tests in `tests/Unit/`
- Feature tests in `tests/Feature/`
- Test environment uses in-memory arrays for cache, sessions, and mail

## Log Viewing

The application includes Laravel Log Viewer package. Access logs at `/admin/logs` or `/logs` route.

## Common Development Patterns

### Adding a New API Endpoint

1. Define route in [routes/api.php](routes/api.php) within the `auth:api` middleware group
2. Create or update controller in `app/Http/Controllers/API/`
3. Return JSON responses from controller methods
4. Use Eloquent models from `app/` directory

### Adding Admin Panel Features

1. Define route in [routes/web.php](routes/web.php) within the `admin` prefix group
2. Create or update controller in `app/Http/Controllers/`
3. Create Blade view in `resources/views/admin/`
4. Use AdminLTE components for consistent UI

### Model Conventions

- Models use singular names (e.g., `User`, `Childe`)
- Tables can differ (e.g., `Childe` model uses `childe` table via `$table` property)
- Use `$appends` for computed attributes (see [app/Childe.php](app/Childe.php:14))
- Use `$casts` for type casting (see [app/User.php](app/User.php:41))
