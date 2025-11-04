# Tooth Tycoon API - Quick Reference

## Base URL
```
Local: http://127.0.0.1:8000/api
Production: https://api.toothtycoon.com/api
```

## Authentication Header
```
Authorization: Bearer {access_token}
```

---

## 🔓 Public Endpoints (No Auth Required)

### Authentication
```http
POST /register
POST /login
POST /Social
POST /forgot
POST /reset
```

### Currency
```http
GET /currency/get
```

---

## 🔒 Protected Endpoints (Auth Required)

### User Profile
```http
GET  /user                  # Get profile
POST /ProfileUpdate         # Update profile (form-data with image)
POST /ChangePassword        # Change password
POST /logout                # Logout
```

### Children
```http
GET  /child                 # List children
POST /child/add             # Add child (form-data with image)
POST /child/pull_history    # Get pull history
```

### Budget
```http
POST /SetBudget             # Set reward budget
```

### Tooth Pull Process
```http
POST /child/teeth/pull      # Record pull (form-data with image)
POST /child/invest          # Create investment
POST /child/cashout         # Cash out
POST /MillStone             # Record milestone
```

### Badges & Achievements
```http
POST /Budges                # Get badges for child
```

### Quiz Questions
```http
POST /Questions             # Get question list
POST /SubmitQuestions       # Submit answers
```

---

## 📋 Required Fields by Endpoint

### Register
```json
{
  "name": "string (required)",
  "email": "email (required, unique)",
  "password": "string (required)",
  "password_confirmation": "string (required, must match)"
}
```

### Login
```json
{
  "email": "email (required)",
  "password": "string (required)",
  "device_id": "string (required)",
  "fcm_token": "string (required)"
}
```

### Social Login
```json
{
  "email": "email (required)",
  "social_id": "string (required)",
  "social_name": "string (required)", // 'google', 'facebook', etc.
  "name": "string (required)",
  "device_id": "string (required)",
  "fcm_token": "string (required)"
}
```

### Add Child
```form-data
name: string (required)
age: integer (required)
image: file (optional)
```

### Set Budget
```json
{
  "currency_id": "integer (required)",
  "amount": "decimal (required)"
}
```

### Pull Tooth
```form-data
child_id: integer (required)
teeth_number: integer 1-20 (required)
pull_date: YYYY-MM-DD (required)
picture: file (required)
```

### Invest
```json
{
  "child_id": "integer (required)",
  "pull_detail_id": "integer (required)",
  "years": "integer (required)",
  "rate": "decimal (required)",
  "amount": "decimal (required)",
  "final_amount": "decimal (required)",
  "end_date": "YYYY-MM-DD (required, must be future)"
}
```

### Cash Out
```json
{
  "child_id": "integer (required)",
  "pull_detail_id": "integer (required)",
  "amount": "decimal (required)"
}
```

### Get Badges
```json
{
  "child_id": "integer (required)"
}
```

### Submit Questions
```json
{
  "child_id": "integer (required)",
  "question1": "boolean (required)",
  "question2": "boolean (required)"
}
```

---

## 🦷 Tooth Numbering (1-20)

```
Upper Right: 1, 2, 3, 4, 5
Upper Left:  6, 7, 8, 9, 10
Lower Left:  11, 12, 13, 14, 15
Lower Right: 16, 17, 18, 19, 20

Types:
- Molars: 1, 2, 9, 10, 11, 12, 19, 20
- Canines: 3, 8, 13, 18
- Incisors: 4, 5, 6, 7, 14, 15, 16, 17
```

---

## 📊 Response Format

### Success (200/201)
```json
{
  "status": 1,
  "message": "Success message",
  "data": { /* response data */ }
}
```

### Error (422/401)
```json
{
  "status": 0,
  "message": "Error message",
  "errors": {
    "field": "Validation error"
  }
}
```

---

## 🎯 Badge Dependencies

Badges are earned when achievements reach `number_time` threshold:

| Badge Type | Depends On | Count |
|------------|-----------|-------|
| Pull Tooth | `Pull_tooth` | Total teeth pulled |
| Molars | `molars` | Molar teeth pulled |
| Canines | `canines` | Canine teeth pulled |
| Incisors | `incisor` | Incisor teeth pulled |
| Photos | `photos` | Pictures uploaded |
| Quiz 1 | `question1` | Question 1 correct |
| Quiz 2 | `question2` | Question 2 correct |
| Milestones | `mile_store` | Milestones recorded |

---

## 🔄 Testing Flow

### Quick Test Sequence
```
1. GET  /currency/get           → Save currency_id
2. POST /register               → Save access_token
3. POST /SetBudget              → Set reward amount
4. POST /child/add              → Save child_id
5. POST /child/teeth/pull       → Save pull_detail_id
6. POST /child/pull_history     → View summary
7. POST /Budges                 → Check badges
8. POST /Questions              → Get questions
9. POST /SubmitQuestions        → Submit answers
10. POST /logout                → Clean up
```

---

## ⚠️ Important Notes

### Encryption
- Mobile app encrypts: `email`, `password`, `password_confirmation`
- Postman testing: Use plain text or use `/encryption` endpoint

### Quiz Streak Logic
- Submit same day: "Already submitted"
- Submit next day: Streak continues
- Skip a day: Progress resets

### File Uploads
- Use `form-data` body type
- Don't set Content-Type header manually
- Postman auto-detects multipart/form-data

### Date Formats
- All dates: `YYYY-MM-DD`
- Investment end_date: Must be in future
- Pull date: Can be any date

### Token Management
- Tokens saved in environment after login/register
- Automatically included in all protected requests
- Revoked on logout

---

## 🐛 Common Errors

| Error | Cause | Solution |
|-------|-------|----------|
| 401 Unauthorized | No/invalid token | Login first |
| 422 Validation | Missing/invalid field | Check required fields |
| "Pull exists" | Tooth already pulled | Use different teeth_number |
| "Invalid credentials" | Wrong email/password | Check credentials |
| "Email exists" | Email not found (forgot) | Use registered email |

---

## 📝 Example cURL

### Login
```bash
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "parent@example.com",
    "password": "password123",
    "device_id": "device-uuid",
    "fcm_token": "firebase-token"
  }'
```

### Get Profile (Authenticated)
```bash
curl -X GET http://127.0.0.1:8000/api/user \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### Pull Tooth (File Upload)
```bash
curl -X POST http://127.0.0.1:8000/api/child/teeth/pull \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -F "child_id=1" \
  -F "teeth_number=5" \
  -F "pull_date=2025-11-03" \
  -F "picture=@/path/to/image.jpg"
```

---

## 💡 Pro Tips

1. **Use Collection Variables**: child_id, pull_detail_id auto-save
2. **Check Test Scripts**: See what gets saved automatically
3. **Postman Console**: View → Show Postman Console for debug info
4. **Environment Selector**: Switch between Local/Production easily
5. **Pre-request Scripts**: Collection uses auto-token management
6. **Test Order Matters**: Follow recommended testing flow

---

**Last Updated**: November 2025
**Laravel Version**: 10.49.1
