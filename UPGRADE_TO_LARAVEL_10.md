# Upgrade Guide: Laravel 7 to Laravel 10

This guide provides step-by-step instructions to upgrade the Tooth Tycoon application from Laravel 7 to Laravel 10.

## Overview

**Current Version**: Laravel 7.x (PHP 7.2.5+)
**Target Version**: Laravel 10.x (PHP 8.1+)

**Upgrade Path**: Laravel 7 → 8 → 9 → 10

**Estimated Time**: 4-8 hours depending on testing thoroughness

## Before You Begin

### 1. Backup Everything
```bash
# Create a backup branch
git checkout -b backup-laravel-7
git push origin backup-laravel-7

# Create a new upgrade branch
git checkout -b upgrade-laravel-10

# Backup database
mysqldump -u root -p tooth_tycoon > backup-$(date +%Y%m%d).sql
```

### 2. Ensure Tests Pass (if any exist)
```bash
./vendor/bin/phpunit
```

### 3. Document Current State
```bash
# Save current package versions
composer show --installed > packages-before-upgrade.txt

# Note current PHP version
php -v >> packages-before-upgrade.txt
```

---

## Phase 1: Upgrade to Laravel 8

### Step 1.1: Update composer.json Dependencies

Edit `composer.json` and update the `require` section:

```json
"require": {
    "php": "^7.3|^8.0",
    "fideloper/proxy": "^4.4",
    "fruitcake/laravel-cors": "^2.0",
    "guzzlehttp/guzzle": "^7.0.1",
    "jeroennoten/laravel-adminlte": "^3.7",
    "laravel/framework": "^8.75",
    "laravel/passport": "^10.0",
    "laravel/tinker": "^2.5",
    "laravel/ui": "^3.0",
    "rap2hpoutre/laravel-log-viewer": "^2.0"
},
"require-dev": {
    "facade/ignition": "^2.5",
    "fakerphp/faker": "^1.9.1",
    "mockery/mockery": "^1.4.4",
    "nunomaduro/collision": "^5.10",
    "phpunit/phpunit": "^9.5.10"
}
```

### Step 1.2: Update Autoload Section

In `composer.json`, update the autoload classmap:

```json
"autoload": {
    "psr-4": {
        "App\\": "app/",
        "Database\\Factories\\": "database/factories/",
        "Database\\Seeders\\": "database/seeders/"
    }
},
```

### Step 1.3: Rename Directories

```bash
# Rename database directories (Laravel 8 convention)
mv database/seeds database/seeders
mv database/factories database/factories-temp
mkdir database/factories
```

### Step 1.4: Update Namespace in Seeders

Update all files in `database/seeders/` to use the new namespace:

**Before:**
```php
<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
```

**After:**
```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
```

### Step 1.5: Update Factory Pattern

Laravel 8 uses class-based factories. For each model, you'll need to convert old factories.

**Old (Laravel 7) - database/factories/UserFactory.php:**
```php
$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
    ];
});
```

**New (Laravel 8) - database/factories/UserFactory.php:**
```php
<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => Str::random(10),
        ];
    }
}
```

### Step 1.6: Update Models Directory

Laravel 8 moved models to `app/Models/` directory:

```bash
# Create Models directory
mkdir -p app/Models

# Move User model
mv app/User.php app/Models/User.php

# Move all other model files to app/Models/
mv app/*.php app/Models/ 2>/dev/null
# Move controllers back
mv app/Models/Http app/ 2>/dev/null
mv app/Models/Console app/ 2>/dev/null
mv app/Models/Exceptions app/ 2>/dev/null
mv app/Models/Providers app/ 2>/dev/null
```

### Step 1.7: Update Model Namespaces

Update all model files to use `App\Models` namespace:

**In each model file (e.g., app/Models/User.php):**
```php
<?php

namespace App\Models;  // Changed from: namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
```

### Step 1.8: Update Model References Throughout Codebase

Search and replace all model references:

```bash
# Find all controller files that reference old model namespace
grep -r "use App\\User;" app/Http/Controllers/
grep -r "App\\Childe" app/Http/Controllers/
# etc. for each model
```

Update to:
```php
use App\Models\User;
use App\Models\Childe;
use App\Models\Budget;
// etc.
```

### Step 1.9: Update RouteServiceProvider

Edit `app/Providers/RouteServiceProvider.php`:

**Add this property:**
```php
/**
 * The path to the "home" route for your application.
 *
 * @var string
 */
public const HOME = '/home';

/**
 * Define your route model bindings, pattern filters, etc.
 *
 * @return void
 */
public function boot()
{
    $this->configureRateLimiting();

    $this->routes(function () {
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    });
}

/**
 * Configure the rate limiters for the application.
 *
 * @return void
 */
protected function configureRateLimiting()
{
    RateLimiter::for('api', function (Request $request) {
        return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
    });
}
```

### Step 1.10: Remove Deprecated Middleware

Remove `app/Http/Middleware/CheckForMaintenanceMode.php` as it's been replaced by `PreventRequestsDuringMaintenance`.

Update `app/Http/Kernel.php`:

**Replace:**
```php
\App\Http\Middleware\CheckForMaintenanceMode::class,
```

**With:**
```php
\Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
```

### Step 1.11: Install Laravel 8 Dependencies

```bash
# Remove old dependencies and lock file
rm -rf vendor composer.lock

# Update dependencies
composer update

# If you get errors, try:
composer update --with-all-dependencies
```

### Step 1.12: Publish New Configuration Files

```bash
# Publish new config files for Laravel 8
php artisan vendor:publish --tag=laravel-pagination
```

### Step 1.13: Test Laravel 8

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Test the application
php artisan serve

# Visit http://localhost:8000 and test functionality
```

---

## Phase 2: Upgrade to Laravel 9

### Step 2.1: Update composer.json for Laravel 9

```json
"require": {
    "php": "^8.0.2",
    "guzzlehttp/guzzle": "^7.2",
    "jeroennoten/laravel-adminlte": "^3.9",
    "laravel/framework": "^9.0",
    "laravel/passport": "^11.0",
    "laravel/tinker": "^2.7",
    "laravel/ui": "^4.0",
    "rap2hpoutre/laravel-log-viewer": "^2.3"
},
"require-dev": {
    "fakerphp/faker": "^1.9.1",
    "laravel/pint": "^1.0",
    "laravel/sail": "^1.0.1",
    "mockery/mockery": "^1.4.4",
    "nunomaduro/collision": "^6.1",
    "phpunit/phpunit": "^9.5.10",
    "spatie/laravel-ignition": "^1.0"
}
```

### Step 2.2: Replace Flysystem v1 with v3

Laravel 9 uses Flysystem v3. Update any direct Flysystem usage in your code.

### Step 2.3: Update String Helpers

Laravel 9 removed string and array helpers. Install the compatibility package:

```bash
composer require laravel/helpers
```

Or update code to use `Str` and `Arr` facades:

**Before:**
```php
str_contains($string, 'foo');
```

**After:**
```php
use Illuminate\Support\Str;
Str::contains($string, 'foo');
```

### Step 2.4: Update Validated Method

Controllers using `$request->validated()` may need updates. The return type is now always an array.

### Step 2.5: Update Dependencies

```bash
rm -rf vendor composer.lock
composer update
```

### Step 2.6: Test Laravel 9

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan serve
```

---

## Phase 3: Upgrade to Laravel 10

### Step 3.1: Update composer.json for Laravel 10

```json
"require": {
    "php": "^8.1",
    "guzzlehttp/guzzle": "^7.2",
    "jeroennoten/laravel-adminlte": "^3.11",
    "laravel/framework": "^10.0",
    "laravel/passport": "^11.10",
    "laravel/tinker": "^2.8",
    "laravel/ui": "^4.2",
    "rap2hpoutre/laravel-log-viewer": "^2.3"
},
"require-dev": {
    "fakerphp/faker": "^1.9.1",
    "laravel/pint": "^1.0",
    "laravel/sail": "^1.18",
    "mockery/mockery": "^1.4.4",
    "nunomaduro/collision": "^7.0",
    "phpunit/phpunit": "^10.0",
    "spatie/laravel-ignition": "^2.0"
}
```

### Step 3.2: Remove fideloper/proxy

Laravel 10 has built-in trusted proxy support. Remove from composer.json:

```bash
composer remove fideloper/proxy
```

Update `app/Http/Middleware/TrustProxies.php`:

```php
<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array<int, string>|string|null
     */
    protected $proxies;

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;
}
```

### Step 3.3: Update Service Providers

Service providers no longer need `$namespace` property. Remove from `app/Providers/RouteServiceProvider.php`:

```php
// Remove this line:
protected $namespace = 'App\\Http\\Controllers';
```

### Step 3.4: Update Dependencies

```bash
rm -rf vendor composer.lock
composer update
```

### Step 3.5: Update PHPUnit Configuration

Update `phpunit.xml`:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true"
>
    <testsuites>
        <testsuite name="Unit">
            <directory>tests/Unit</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory>tests/Feature</directory>
        </testsuite>
    </testsuites>
    <source>
        <include>
            <directory>app</directory>
        </include>
    </source>
    <php>
        <env name="APP_ENV" value="testing"/>
        <env name="BCRYPT_ROUNDS" value="4"/>
        <env name="CACHE_DRIVER" value="array"/>
        <env name="MAIL_MAILER" value="array"/>
        <env name="QUEUE_CONNECTION" value="sync"/>
        <env name="SESSION_DRIVER" value="array"/>
        <env name="TELESCOPE_ENABLED" value="false"/>
    </php>
</phpunit>
```

### Step 3.6: Final Testing

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

# Generate fresh autoload files
composer dump-autoload

# Test the application
php artisan serve
```

---

## Post-Upgrade Checklist

### ✅ Test All Functionality

- [ ] User registration and login
- [ ] Admin panel login
- [ ] Child management (CRUD)
- [ ] Teeth pull tracking
- [ ] Investment features
- [ ] Cash out functionality
- [ ] Badge system
- [ ] Quiz questions
- [ ] API endpoints (test with Postman/Thunder Client)
- [ ] File uploads (if any)
- [ ] Email functionality
- [ ] Database migrations

### ✅ Check API Authentication

```bash
# Test Passport OAuth2
php artisan passport:install --force
```

Test API endpoints with your mobile app or API client.

### ✅ Update Environment Variables

Check `.env` for any new required variables in Laravel 10:

```bash
# Compare with fresh Laravel 10 .env.example
curl https://raw.githubusercontent.com/laravel/laravel/10.x/.env.example > .env.laravel10.example
diff .env.example .env.laravel10.example
```

### ✅ Performance Testing

```bash
# Run performance tests
php artisan route:cache
php artisan config:cache
php artisan view:cache

# Monitor performance
php artisan optimize
```

---

## Common Issues and Solutions

### Issue 1: Namespace Errors

**Error:** `Class 'App\User' not found`

**Solution:** Update all references from `App\User` to `App\Models\User`

```bash
# Find all occurrences
grep -r "App\\\\User" app/
grep -r "use App\\User" app/
```

### Issue 2: Factory Errors

**Error:** `Call to undefined method Illuminate\Database\Query\Builder::factory()`

**Solution:** Update factory calls in tests:

**Before:**
```php
factory(User::class)->create();
```

**After:**
```php
User::factory()->create();
```

### Issue 3: Passport Issues

**Error:** `Passport keys not found`

**Solution:**
```bash
php artisan passport:keys
php artisan passport:install --force
```

### Issue 4: Route Model Binding

If you have route model binding issues, check `RouteServiceProvider`:

```php
public function boot()
{
    // Add explicit bindings if needed
    Route::model('user', \App\Models\User::class);
}
```

### Issue 5: Middleware Issues

**Error:** `Target class [CheckForMaintenanceMode] does not exist`

**Solution:** Replace in `app/Http/Kernel.php`:
```php
\Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
```

---

## Rollback Plan

If the upgrade fails and you need to rollback:

```bash
# Switch back to backup branch
git checkout backup-laravel-7

# Restore database
mysql -u root -p tooth_tycoon < backup-YYYYMMDD.sql

# Reinstall old dependencies
composer install

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

---

## Additional Resources

- [Laravel 8 Upgrade Guide](https://laravel.com/docs/8.x/upgrade)
- [Laravel 9 Upgrade Guide](https://laravel.com/docs/9.x/upgrade)
- [Laravel 10 Upgrade Guide](https://laravel.com/docs/10.x/upgrade)
- [Laravel Shift](https://laravelshift.com/) - Automated upgrade service ($)

---

## Notes

- Take your time with each phase
- Test thoroughly after each major version upgrade
- Keep the backup branch until you're 100% confident
- Consider using Laravel Shift for automated assistance
- Document any custom changes you make during the upgrade

Good luck with your upgrade!
