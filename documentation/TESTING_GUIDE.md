# Hospital Management System - Complete Testing Guide

**For BNCC LnT Final Project 2026**

---

## 📖 Table of Contents

1. [Prerequisites & Setup](#prerequisites--setup)
2. [Starting the Server](#starting-the-server)
3. [Importing Postman Collection](#importing-postman-collection)
4. [Testing Workflow (Step by Step)](#testing-workflow-step-by-step)
5. [API Endpoints Reference](#api-endpoints-reference)
6. [Troubleshooting](#troubleshooting)

---

## Prerequisites & Setup

### What You Need

- ✅ **PHP 8.2+** - Check with: `php --version`
- ✅ **MySQL/MariaDB** - Running (via XAMPP or standalone)
- ✅ **Composer** - Check with: `composer --version`
- ✅ **Postman Desktop** - Download from https://www.postman.com/downloads/
- ✅ **Node.js** - For npm (optional, for frontend assets)

### Initial Setup (If Not Done Yet)

```bash
# Navigate to project
cd hospital-management-system-Laravelovers

# Install PHP dependencies
composer install

# Install JavaScript dependencies (optional)
npm install

# Create environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Configure database in .env:
# DB_DATABASE=hospital_management
# DB_USERNAME=root
# DB_PASSWORD=(leave empty for XAMPP)

# Run migrations
php artisan migrate

# (Optional) Seed database with test data
php artisan db:seed
```

---

## Starting the Server

### Method 1: Command Line (Recommended)

```bash
# Navigate to project folder
cd C:\xampp\htdocs\hospital-management-system-Laravelovers

# Start server
php artisan serve --host=127.0.0.1 --port=8000

# Output:
# INFO  Server running on [http://127.0.0.1:8000]
# Press Ctrl+C to stop
```

### Method 2: PowerShell

```powershell
cd 'C:\xampp\htdocs\hospital-management-system-Laravelovers'
php artisan serve --host=127.0.0.1 --port=8000
```

### Verify Server is Running

- Open browser: `http://127.0.0.1:8000`
- Should show Laravel welcome page
- API should respond at: `http://127.0.0.1:8000/api/doctors`

---

## Importing Postman Collection

### Step-by-Step Import

1. **Open Postman Desktop** (Download from https://www.postman.com/downloads/)

2. **Click: File → Import**
   
3. **Select File Tab** (should be default)

4. **Click "Choose Files" or Browse**

5. **Navigate to**:
   ```
   C:\xampp\htdocs\hospital-management-system-Laravelovers\documentation\
   ```

6. **Select**: `Hospital_Management_API.postman_collection.json`

7. **Click Open**

8. **Click Import** button

✅ **Success!** Your collection is now imported.

### Collection Contains

- 5 main endpoint groups
- 20+ individual test requests
- All request bodies pre-filled
- Ready to use!

---

## Testing Workflow (Step by Step)

### ⚠️ IMPORTANT: Server Must Be Running!

Before testing, make sure:
```bash
php artisan serve --host=127.0.0.1 --port=8000
```

---

### 🔑 Step 1: Register a User

**Endpoint**: `POST /api/auth/register`

In Postman:
1. Click on **"Register"** request in the collection
2. Make sure you're on **"Body"** tab
3. The JSON body is already filled with test data:
   ```json
   {
     "name": "Dr. Test",
     "email": "test@example.com",
     "password": "password123",
     "password_confirmation": "password123",
     "role": "doctor"
   }
   ```
4. Click **Send**

**Expected Response** (Status: 201 Created):
```json
{
  "message": "User registered successfully",
  "access_token": "1|a1b2c3d4e5f6...",
  "user": {
    "id": 1,
    "name": "Dr. Test",
    "email": "test@example.com",
    "role": "doctor"
  }
}
```

✅ **IMPORTANT**: Copy the `access_token` value - you'll need it for other requests!

---

### 🔐 Step 2: Save Token for Future Requests

The token you got is your authentication key.

In Postman, when using protected endpoints:
1. Go to **Headers** tab
2. Add header:
   - **Key**: `Authorization`
   - **Value**: `Bearer {paste_token_here}`

Example:
```
Authorization: Bearer 1|a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6
```

---

### 👥 Step 3: Create Doctor Profile

**Endpoint**: `POST /api/doctors`

**This requires authentication!**

1. Click on **"Create Doctor"** request
2. Go to **Headers** tab
3. Make sure you have:
   ```
   Authorization: Bearer {YOUR_TOKEN}
   ```
4. Go to **Body** tab
5. Edit the JSON (change user_id if needed):
   ```json
   {
     "user_id": 1,
     "specialization": "Cardiology",
     "phone": "08123456789"
   }
   ```
6. Click **Send**

**Expected Response** (Status: 201 Created):
```json
{
  "message": "Doctor created successfully",
  "data": {
    "id": 1,
    "user_id": 1,
    "specialization": "Cardiology",
    "phone": "08123456789",
    "created_at": "2026-05-16T15:30:00Z"
  }
}
```

---

### 👨‍⚕️ Step 4: List All Doctors (Public - No Auth Needed)

**Endpoint**: `GET /api/doctors`

1. Click on **"Get Doctors"** request
2. Click **Send**

**Expected Response** (Status: 200 OK):
```json
{
  "message": "Doctors retrieved successfully",
  "data": [
    {
      "id": 1,
      "user_id": 1,
      "specialization": "Cardiology",
      "phone": "08123456789",
      "user": {
        "id": 1,
        "name": "Dr. Test",
        "email": "test@example.com"
      }
    }
  ]
}
```

---

### 🔄 Step 5: Repeat for Patient

**Register another user with role: patient**

1. Click **Register** again
2. Change the body:
   ```json
   {
     "name": "John Doe",
     "email": "patient@example.com",
     "password": "password123",
     "password_confirmation": "password123",
     "role": "patient"
   }
   ```
3. Click **Send**
4. Copy the new token (different patient)

---

### 📅 Step 6: Create Appointment

**Endpoint**: `POST /api/appointments`

1. Click **"Create Appointment"** request
2. Add Authorization header with doctor's token
3. Update body with IDs from previous steps:
   ```json
   {
     "patient_id": 1,
     "doctor_id": 1,
     "appointment_date": "2026-05-25",
     "status": "pending",
     "complaint": "Chest pain"
   }
   ```
4. Click **Send**

---

### 📋 Step 7: Create Medical Record

**Endpoint**: `POST /api/medical-records`

1. Click **"Create Medical Record"** request
2. Add Authorization header (use doctor's token)
3. Update body:
   ```json
   {
     "appointment_id": 1,
     "diagnosis": "Hypertension",
     "prescription": "Lisinopril 10mg daily",
     "notes": "Follow-up in 2 weeks"
   }
   ```
4. Click **Send**

---

### 📁 Step 8: Upload File

**Endpoint**: `POST /api/files`

1. Click **"Upload File"** request
2. Add Authorization header
3. Go to **Body** tab
4. Switch from "raw" to **"form-data"**
5. Add:
   - **Key**: `file` (type: File) - Select any PDF or image
   - **Key**: `description` (type: Text) - "Medical Document"
6. Click **Send**

---

### ✅ Step 9: Verify Everything Works

Test these read endpoints (no auth needed):

1. **GET /api/doctors** - See list of doctors
2. **GET /api/appointments** - See list of appointments
3. **GET /api/medical-records** - See medical records
4. **GET /api/files** - See files

All should return 200 OK with data.

---

## API Endpoints Reference

### 🔐 Authentication

| Method | Endpoint | Auth | Purpose |
|--------|----------|------|---------|
| POST | `/api/auth/register` | No | Register new user, get token |
| POST | `/api/auth/login` | No | Login, get token |
| POST | `/api/auth/logout` | Yes | Logout, invalidate token |

### 👥 Patients

| Method | Endpoint | Auth | Purpose |
|--------|----------|------|---------|
| GET | `/api/patients` | No | List all patients |
| GET | `/api/patients/{id}` | No | Get patient details |
| PUT | `/api/patients/{id}` | Yes | Update patient info |

### 👨‍⚕️ Doctors

| Method | Endpoint | Auth | Purpose |
|--------|----------|------|---------|
| GET | `/api/doctors` | No | List all doctors |
| POST | `/api/doctors` | Yes | Create doctor profile |

### 📅 Appointments

| Method | Endpoint | Auth | Purpose |
|--------|----------|------|---------|
| GET | `/api/appointments` | No | List all appointments |
| POST | `/api/appointments` | Yes | Create appointment |
| GET | `/api/appointments/{id}` | No | Get appointment details |
| PUT | `/api/appointments/{id}` | Yes | Update appointment status |
| DELETE | `/api/appointments/{id}` | Yes | Cancel appointment |

### 📋 Medical Records

| Method | Endpoint | Auth | Purpose |
|--------|----------|------|---------|
| GET | `/api/medical-records` | No | List all records |
| POST | `/api/medical-records` | Yes | Create medical record |
| GET | `/api/medical-records/{id}` | No | Get record details |

### 📁 Files

| Method | Endpoint | Auth | Purpose |
|--------|----------|------|---------|
| GET | `/api/files` | No | List all files |
| POST | `/api/files` | Yes | Upload file |
| GET | `/api/files/{id}` | No | Get file metadata |
| GET | `/api/files/{id}/download` | Yes | Download file |
| DELETE | `/api/files/{id}` | Yes | Delete file |

---

## Troubleshooting

### ❌ "Could not connect to server"

**Problem**: Getting connection refused errors

**Solution**:
1. Make sure server is running: `php artisan serve`
2. Check if port 8000 is available
3. Try different port: `php artisan serve --port=8001`
4. Wait 5-10 seconds after starting server

---

### ❌ "401 Unauthorized"

**Problem**: "Unauthenticated" error on protected endpoints

**Solution**:
1. Check Authorization header is present
2. Verify token format: `Bearer {token}`
3. Token might be expired - register/login again
4. Copy token exactly (no extra spaces)

---

### ❌ "422 Validation Error"

**Problem**: Request body doesn't match requirements

**Solution**:
1. Check Content-Type header: `application/json`
2. Verify all required fields are present
3. Check field formats:
   - Dates: `YYYY-MM-DD` format
   - Email: valid email format
   - Role: `doctor` or `patient`
4. Check field values exist (e.g., user_id, doctor_id)

---

### ❌ "404 Not Found"

**Problem**: Resource doesn't exist

**Solution**:
1. Check endpoint URL is correct
2. Verify resource ID exists (try ID 1 first)
3. Check you're using correct HTTP method (GET vs POST)

---

### ❌ "500 Internal Server Error"

**Problem**: Server-side error

**Solution**:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Verify database is running
3. Check migrations are up-to-date: `php artisan migrate`
4. Restart server

---

## Running Tests

### PHPUnit Tests

```bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage

# Run specific test file
php artisan test tests/Feature/AuthenticationTest.php
```

Expected output: **60%+ code coverage on main controllers**

---

## Database Backup

**Backup file location**:
```
documentation/database_backup_20260515_213644.sql
```

To restore:
```bash
mysql -u root hospital_management < database_backup_20260515_213644.sql
```

---

## More Information

- **API Documentation**: See `API_DOCUMENTATION.md`
- **Database Design**: See `ERD_DIAGRAM.md`
- **Project Requirements**: See `finpro_bncc_lnt_2026.pdf`

---

## ✅ Testing Checklist

- [ ] Server started successfully
- [ ] Postman collection imported
- [ ] Registered user and got token
- [ ] Created doctor profile
- [ ] Registered patient user
- [ ] Created appointment
- [ ] Created medical record
- [ ] Uploaded file
- [ ] Listed all resources
- [ ] All tests pass: `php artisan test`

---

**Happy Testing! 🚀**
