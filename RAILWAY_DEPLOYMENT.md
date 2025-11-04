# Railway.app Deployment Guide

This guide walks you through deploying the Tooth Tycoon Laravel application to Railway.app.

## Prerequisites

1. GitHub account with this repository
2. Railway.app account (sign up at https://railway.app)

## Deployment Steps

### 1. Create Railway Project

1. Go to https://railway.app
2. Click "Start a New Project"
3. Choose "Deploy from GitHub repo"
4. Select your `tooth_tycoon` repository
5. Select the `upgrade-laravel-10` branch (or `main` after merging)

### 2. Add MySQL Database

1. In your Railway project dashboard, click "+ New"
2. Select "Database" → "MySQL"
3. Railway will automatically provision a MySQL database

### 3. Configure Environment Variables

In your Railway project settings, add these environment variables:

```env
APP_NAME="Tooth Tycoon"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-app.up.railway.app

# Database (Railway auto-injects these from MySQL service)
# DB_CONNECTION=mysql
# DB_HOST=${{MYSQL.MYSQLHOST}}
# DB_PORT=${{MYSQL.MYSQLPORT}}
# DB_DATABASE=${{MYSQL.MYSQLDATABASE}}
# DB_USERNAME=${{MYSQL.MYSQLUSER}}
# DB_PASSWORD=${{MYSQL.MYSQLPASSWORD}}

# Laravel Passport
PASSPORT_PRIVATE_KEY="-----BEGIN RSA PRIVATE KEY-----\nYOUR_PRIVATE_KEY_HERE\n-----END RSA PRIVATE KEY-----"
PASSPORT_PUBLIC_KEY="-----BEGIN PUBLIC KEY-----\nYOUR_PUBLIC_KEY_HERE\n-----END PUBLIC KEY-----"

# File Storage
FILESYSTEM_DRIVER=public

# Encryption (for API)
DISABLE_ENCRYPTION=false

# Mail (optional - configure if you want to enable emails)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=noreply@toothtycoon.com
MAIL_FROM_NAME="${APP_NAME}"

# Session & Cache
SESSION_DRIVER=file
SESSION_LIFETIME=120
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

### 4. Get Your APP_KEY

Run locally to generate a new key:
```bash
php artisan key:generate --show
```

Copy the output (including `base64:`) and paste it into Railway's `APP_KEY` variable.

### 5. Get Your Passport Keys

Run locally:
```bash
php artisan passport:keys
```

Then copy the keys:
```bash
cat storage/oauth-private.key
cat storage/oauth-public.key
```

Paste each key into Railway variables (preserve line breaks - use `\n` for newlines in the variable).

### 6. Connect Database Variables

In Railway, connect your MySQL database to your Laravel service:

1. Click on your Laravel service
2. Go to "Variables" tab
3. Click "+ Add Reference"
4. Select your MySQL database
5. This auto-creates variables like `${{MYSQL.MYSQLHOST}}`

Then set these variables to use the MySQL references:
```env
DB_CONNECTION=mysql
DB_HOST=${{MYSQL.MYSQLHOST}}
DB_PORT=${{MYSQL.MYSQLPORT}}
DB_DATABASE=${{MYSQL.MYSQLDATABASE}}
DB_USERNAME=${{MYSQL.MYSQLUSER}}
DB_PASSWORD=${{MYSQL.MYSQLPASSWORD}}
```

### 7. Deploy

Railway will automatically deploy when you push to your GitHub branch. The deployment process:

1. Installs PHP dependencies (`composer install`)
2. Installs Node dependencies (`npm ci`)
3. Builds frontend assets (`npm run build`)
4. Runs migrations (`php artisan migrate --force`)
5. Creates storage symlink (`php artisan storage:link`)
6. Starts the application

### 8. Create Admin User

After first deployment, run this command in Railway's terminal:

1. Click on your service
2. Go to "Deployments" tab
3. Click on latest deployment
4. Open terminal (top right icon)
5. Run:
```bash
php artisan db:seed --class=AdminSeeder
```

## Post-Deployment

### Access Your Application

- **Web Admin**: `https://your-app.up.railway.app/admin`
- **API Endpoint**: `https://your-app.up.railway.app/api/*`
- **Admin Login**: admin@toothtycoon.com / password

### Custom Domain (Optional)

1. Go to your service settings
2. Click "Settings" → "Domains"
3. Add your custom domain
4. Update DNS records as instructed

### Update APP_URL

After getting your Railway URL or custom domain, update the `APP_URL` environment variable to match.

## Troubleshooting

### Build Fails

Check the build logs in Railway dashboard. Common issues:
- Missing environment variables
- Composer dependencies conflict
- Node/NPM version issues

### Database Connection Errors

Verify that:
1. MySQL service is running
2. Database variables are correctly referenced
3. Railway has linked the MySQL service to your app

### Storage/Upload Issues

Run in Railway terminal:
```bash
php artisan storage:link
chmod -R 775 storage
```

### Clear Caches

If you make config changes:
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

## Monitoring & Logs

- View logs in Railway dashboard under "Deployments" → "Logs"
- Monitor resource usage in "Metrics" tab
- Set up health checks in "Settings"

## Cost Estimate

- **Hobby Plan**: $5/month
- **MySQL Database**: Included in hobby plan
- **Storage**: 100GB included
- **Bandwidth**: Unlimited

## Updating the Application

1. Push changes to your GitHub branch
2. Railway automatically detects and deploys
3. Migrations run automatically on each deploy
4. Zero-downtime deployments

## Rollback

If a deployment fails:
1. Go to "Deployments" tab
2. Find a previous successful deployment
3. Click "Redeploy"
