# Tooth Tycoon API - Postman Collection

This directory contains a comprehensive Postman collection for testing all Tooth Tycoon mobile API endpoints.

## Files Included

1. **ToothTycoon_API.postman_collection.json** - Complete API collection with all endpoints
2. **ToothTycoon_Local.postman_environment.json** - Local development environment
3. **ToothTycoon_Production.postman_environment.json** - Production environment template

## Quick Start

### 1. Import into Postman

1. Open Postman
2. Click **Import** button (top left)
3. Drag and drop all three JSON files
4. Select **Tooth Tycoon - Local** environment from the environment dropdown

### 2. Start Local Server

```bash
cd /Users/lukelanterme/Documents/Code/Personal/Web/Projects/tooth_tycoon
php artisan serve
```

### 3. Run Your First Request

1. Navigate to **Authentication → Register** or **Authentication → Login**
2. Click **Send**
3. The access token will be automatically saved to your environment
4. All subsequent requests will use this token automatically

## API Overview

### Authentication Endpoints (Public)

All authentication endpoints are **public** (no token required):

| Endpoint | Method | Description |
|----------|--------|-------------|
| `/api/register` | POST | Register new user account |
| `/api/login` | POST | Login with email/password |
| `/api/Social` | POST | Social login (Google, Facebook, etc.) |
| `/api/forgot` | POST | Request password reset code |
| `/api/reset` | POST | Reset password with code |
| `/api/currency/get` | GET | Get available currencies |

### Protected Endpoints (Require Authentication)

All other endpoints require a valid Bearer token:

#### User Profile
- `GET /api/user` - Get user profile
- `POST /api/ProfileUpdate` - Update profile (supports image upload)
- `POST /api/ChangePassword` - Change password
- `POST /api/logout` - Logout (revokes tokens)

#### Children Management
- `GET /api/child` - Get all children
- `POST /api/child/add` - Add new child (supports image upload)
- `POST /api/child/pull_history` - Get pull history for a child

#### Budget
- `POST /api/SetBudget` - Set reward budget per tooth

#### Tooth Pull Process
- `POST /api/child/teeth/pull` - Record tooth pull (requires image upload)
- `POST /api/child/invest` - Create investment from rewards
- `POST /api/child/cashout` - Cash out rewards
- `POST /api/MillStone` - Record milestone

#### Badges & Achievements
- `POST /api/Budges` - Get badges and progress for a child

#### Quiz Questions
- `POST /api/Questions` - Get all quiz questions
- `POST /api/SubmitQuestions` - Submit daily quiz answers

## Environment Variables

The collection uses the following environment variables:

### Automatically Set Variables

These are set automatically by test scripts:

- `access_token` - JWT bearer token (set after login/register)
- `child_id` - Selected child ID (set after adding/listing children)
- `pull_detail_id` - Pull detail ID (set after recording tooth pull)
- `currency_id` - Selected currency ID (set after getting currencies)

### Manual Configuration

- `base_url` - API base URL (default: `http://127.0.0.1:8000`)
- `user_email` - Test user email (default: `parent@example.com`)
- `user_password` - Test user password (default: `password123`)

## Testing Workflow

### Complete Test Flow

Follow this order for a complete test of all features:

1. **Setup**
   - Get Currency List → Sets `currency_id`
   - Register → Sets `access_token`

2. **Profile Management**
   - Get Profile
   - Update Profile
   - Set Budget

3. **Child Management**
   - Add Child → Sets `child_id`
   - Get Children List

4. **Tooth Pull Process**
   - Pull Tooth → Sets `pull_detail_id`
   - Get Pull History
   - Invest Amount (optional)
   - Cash Out (optional)
   - Record Milestone (optional)

5. **Achievements**
   - Get Questions
   - Submit Questions
   - Get Badges

6. **Cleanup**
   - Logout

## Request Body Examples

### Register
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

### Login
```json
{
    "email": "parent@example.com",
    "password": "password123",
    "device_id": "device-uuid-here",
    "fcm_token": "firebase-token-here"
}
```

### Add Child
```form-data
name: "Tommy"
age: 7
image: [file upload]
```

### Set Budget
```json
{
    "currency_id": "1",
    "amount": "5.00"
}
```

### Pull Tooth
```form-data
child_id: 1
teeth_number: 1
pull_date: 2025-11-03
picture: [file upload]
```

### Invest Amount
```json
{
    "child_id": "1",
    "pull_detail_id": "1",
    "years": "5",
    "rate": "5.0",
    "amount": "10.00",
    "final_amount": "12.76",
    "end_date": "2030-12-31"
}
```

### Submit Questions
```json
{
    "child_id": "1",
    "question1": true,
    "question2": false
}
```

## Tooth Numbering System

Teeth are numbered 1-20 according to the primary dentition numbering system:

**Upper Right**: 1, 2, 3, 4, 5
**Upper Left**: 6, 7, 8, 9, 10
**Lower Left**: 11, 12, 13, 14, 15
**Lower Right**: 16, 17, 18, 19, 20

### Tooth Types (for badge tracking)
- **Molars**: 1, 2, 9, 10, 11, 12, 20, 19
- **Canines**: 3, 8, 18, 13
- **Incisors**: 4, 5, 6, 7, 14, 15, 16, 17

## Badge System

Badges are earned based on achievements:

| Badge Type | Requirement | Depends On |
|------------|-------------|------------|
| Tooth Puller | Pull N teeth | `Pull_tooth` count |
| Molar Master | Pull N molars | `molars` count |
| Canine Champion | Pull N canines | `canines` count |
| Incisor Expert | Pull N incisors | `incisor` count |
| Photo Pro | Upload N photos | `photos` count |
| Quiz Master 1 | Answer N question 1s correctly | `question1` count |
| Quiz Master 2 | Answer N question 2s correctly | `question2` count |
| Milestone Maker | Reach N milestones | `mile_store` count |

## Response Format

All API responses follow this structure:

### Success Response (200/201)
```json
{
    "status": 1,
    "message": "Success message here",
    "data": {
        // Response data
    }
}
```

### Error Response (422/401)
```json
{
    "status": 0,
    "message": "Error message here",
    "errors": {
        "field_name": "Validation error"
    }
}
```

## Authentication

The collection uses **Bearer Token** authentication. The token is automatically:
1. Extracted from login/register responses
2. Saved to the environment variable `access_token`
3. Included in all subsequent requests via the collection-level auth

You can view/modify the token in:
- Environment settings (click the eye icon)
- Authorization tab (collection or request level)

## Image Upload Endpoints

The following endpoints support file uploads (use `form-data`):

1. **Profile Update** - `image` field (optional)
2. **Add Child** - `image` field (optional)
3. **Pull Tooth** - `picture` field (required)

## Custom Encryption

**Note**: The mobile app uses custom encryption for sensitive fields in authentication endpoints:
- `email`, `password`, `password_confirmation` in `/register`
- `email`, `password` in `/login`
- `email`, `password` in `/reset`

For testing in Postman, you can send these fields as **plain text** if you comment out the encryption/decryption logic in the controllers, or use the encryption endpoints:
- `POST /api/encryption` - Encrypt a value
- `POST /api/decryption` - Decrypt a value

## Daily Quiz Streak Logic

The quiz submission endpoint (`/api/SubmitQuestions`) tracks daily streaks:

- **Submit Today**: Returns "already submitted today" message
- **Submit After 1 Day Gap**: Continues streak, increments count
- **Submit After 2+ Day Gap**: Resets all previous submissions, starts fresh

## Troubleshooting

### Token Not Saved
- Check if login/register returned a 200/201 status
- Open Postman Console (View → Show Postman Console) to see test script output
- Manually set `access_token` in environment if needed

### 401 Unauthorized
- Ensure you've logged in first
- Check that `access_token` is set in your environment
- Token may have expired - login again

### 422 Validation Error
- Check request body matches required fields
- Ensure date format is `YYYY-MM-DD`
- Verify `child_id` exists in your account

### File Upload Issues
- Ensure Content-Type is NOT set (Postman auto-detects for form-data)
- Check file exists and is accessible
- Verify request uses `form-data` body type

### Missing child_id or pull_detail_id
- Run "Get Children List" or "Add Child" first
- Run "Pull Tooth" before invest/cashout requests
- Check collection variables (not environment) for these IDs

## Production Setup

To use the production environment:

1. Select **Tooth Tycoon - Production** environment
2. Update `base_url` to your production API URL
3. Update or remove default `user_email` and `user_password`
4. Register/login to get production tokens

## API Documentation

For detailed API behavior and business logic, see:
- [routes/api.php](../routes/api.php) - Route definitions
- [app/Http/Controllers/API/](../app/Http/Controllers/API/) - Controller implementations
- [CLAUDE.md](../CLAUDE.md) - Project architecture documentation

## Support

For issues or questions about the API:
1. Check the controller code for exact validation rules
2. Review [CLAUDE.md](../CLAUDE.md) for architecture details
3. Check Laravel logs at `storage/logs/laravel.log`

## Version

- **Laravel**: 10.49.1
- **API Version**: 1.0
- **Last Updated**: November 2025
