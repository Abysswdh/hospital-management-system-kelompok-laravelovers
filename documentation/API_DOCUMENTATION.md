# Hospital Management System - API Documentation

## Overview
Complete REST API for a Hospital Management System built with Laravel and Sanctum authentication.

**Base URL**: `http://127.0.0.1:8000/api`

**Authentication**: Bearer Token (Laravel Sanctum)

**Response Format**: JSON

---

## Authentication Endpoints

### Register User
Create a new user account.

**Endpoint**: `POST /register`

**Request Headers**:
```
Content-Type: application/json
Accept: application/json
```

**Request Body**:
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "role": "patient"
}
```

**Response** (201 Created):
```json
{
  "message": "User registered successfully.",
  "user": {
    "name": "John Doe",
    "email": "john@example.com",
    "role": "patient",
    "id": 1,
    "created_at": "2026-05-15T14:23:59.000000Z",
    "updated_at": "2026-05-15T14:23:59.000000Z"
  },
  "access_token": "1|abc123...",
  "token_type": "Bearer"
}
```

---

### Login
Authenticate user and receive access token.

**Endpoint**: `POST /login`

**Request Body**:
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response** (200 OK):
```json
{
  "message": "Login successful.",
  "user": { /* user object */ },
  "access_token": "1|abc123...",
  "token_type": "Bearer"
}
```

---

### Logout
Revoke current access token.

**Endpoint**: `POST /logout`

**Request Headers**:
```
Authorization: Bearer {access_token}
Content-Type: application/json
Accept: application/json
```

**Response** (200 OK):
```json
{
  "message": "Logged out successfully."
}
```

---

## Doctors Endpoints

### Get All Doctors
Retrieve list of all doctors with their details.

**Endpoint**: `GET /doctors`

**Request Headers**:
```
Accept: application/json
```

**Response** (200 OK):
```json
{
  "message": "Doctors retrieved successfully.",
  "data": [
    {
      "id": 1,
      "user_id": 1,
      "specialization": "Cardiology",
      "phone": "08123456789",
      "photo": null,
      "created_at": "2026-05-15T14:00:00.000000Z",
      "updated_at": "2026-05-15T14:00:00.000000Z",
      "user": { /* user data */ },
      "appointments": [ /* appointment list */ ]
    }
  ]
}
```

### Get Doctor by ID
Retrieve specific doctor details.

**Endpoint**: `GET /doctors/{id}`

**Response** (200 OK):
```json
{
  "message": "Doctor retrieved successfully.",
  "data": { /* doctor object */ }
}
```

### Create Doctor
Add new doctor profile.

**Endpoint**: `POST /doctors`

**Request Headers**:
```
Authorization: Bearer {access_token}
Content-Type: application/json
Accept: application/json
```

**Request Body**:
```json
{
  "user_id": 1,
  "specialization": "Cardiology",
  "phone": "08123456789",
  "photo": null
}
```

**Response** (201 Created):
```json
{
  "message": "Doctor created successfully.",
  "data": { /* doctor object */ }
}
```

### Update Doctor
Modify doctor information.

**Endpoint**: `PUT /doctors/{id}`

**Request Body** (all fields optional):
```json
{
  "specialization": "Neurology",
  "phone": "08987654321"
}
```

**Response** (200 OK):
```json
{
  "message": "Doctor updated successfully.",
  "data": { /* updated doctor object */ }
}
```

### Delete Doctor
Remove doctor profile.

**Endpoint**: `DELETE /doctors/{id}`

**Response** (200 OK):
```json
{
  "message": "Doctor deleted successfully."
}
```

---

## Patients Endpoints

### Get All Patients
Retrieve list of all patients.

**Endpoint**: `GET /patients`

**Response** (200 OK):
```json
{
  "message": "Patients retrieved successfully.",
  "data": [
    {
      "id": 1,
      "user_id": 2,
      "date_of_birth": "1990-01-15",
      "address": "123 Main Street",
      "phone": "08111111111",
      "photo": null,
      "created_at": "2026-05-15T14:00:00.000000Z",
      "updated_at": "2026-05-15T14:00:00.000000Z",
      "user": { /* user data */ },
      "appointments": [ /* appointment list */ ]
    }
  ]
}
```

### Get Patient by ID
Retrieve specific patient details.

**Endpoint**: `GET /patients/{id}`

### Create Patient
Add new patient profile.

**Endpoint**: `POST /patients`

**Request Body**:
```json
{
  "user_id": 2,
  "date_of_birth": "1990-01-15",
  "address": "123 Main Street",
  "phone": "08111111111"
}
```

### Update Patient
Modify patient information.

**Endpoint**: `PUT /patients/{id}`

### Delete Patient
Remove patient profile.

**Endpoint**: `DELETE /patients/{id}`

---

## Appointments Endpoints

### Get All Appointments
Retrieve list of all appointments with doctor and patient details.

**Endpoint**: `GET /appointments`

**Response** (200 OK):
```json
{
  "message": "Appointments retrieved successfully.",
  "data": [
    {
      "id": 1,
      "patient_id": 1,
      "doctor_id": 1,
      "appointment_date": "2026-05-20T14:00:00.000000Z",
      "status": "scheduled",
      "complaint": "Chest pain and shortness of breath",
      "created_at": "2026-05-15T14:00:00.000000Z",
      "updated_at": "2026-05-15T14:00:00.000000Z",
      "doctor": { /* doctor object */ },
      "patient": { /* patient object */ },
      "medicalRecord": null
    }
  ]
}
```

### Get Appointment by ID
Retrieve specific appointment with all relations.

**Endpoint**: `GET /appointments/{id}`

### Create Appointment
Schedule new appointment.

**Endpoint**: `POST /appointments`

**Request Body**:
```json
{
  "patient_id": 1,
  "doctor_id": 1,
  "appointment_date": "2026-05-20 14:00:00",
  "status": "scheduled",
  "complaint": "Chest pain"
}
```

**Validation Rules**:
- `patient_id`: Must exist in patients table
- `doctor_id`: Must exist in doctors table
- `appointment_date`: Format `Y-m-d H:i:s`, must be in future
- `status`: One of `scheduled`, `completed`, `cancelled`
- `complaint`: String, max 500 chars

### Update Appointment
Modify appointment details.

**Endpoint**: `PUT /appointments/{id}`

**Request Body** (all optional):
```json
{
  "appointment_date": "2026-05-21 14:00:00",
  "status": "completed",
  "complaint": "Updated complaint"
}
```

### Delete Appointment
Cancel appointment.

**Endpoint**: `DELETE /appointments/{id}`

---

## Medical Records Endpoints

### Get All Medical Records
Retrieve list of all medical records.

**Endpoint**: `GET /medical-records`

**Response** (200 OK):
```json
{
  "message": "Medical records retrieved successfully.",
  "data": [
    {
      "id": 1,
      "appointment_id": 1,
      "diagnosis": "Hypertension with left ventricular hypertrophy",
      "treatment": "Prescribe antihypertensive medications",
      "prescription": "Lisinopril 10mg daily, Amlodipine 5mg daily",
      "notes": "Patient advised to maintain low sodium diet",
      "created_at": "2026-05-15T14:00:00.000000Z",
      "updated_at": "2026-05-15T14:00:00.000000Z",
      "appointment": { /* appointment object */ }
    }
  ]
}
```

### Get Medical Record by ID
Retrieve specific medical record with appointment details.

**Endpoint**: `GET /medical-records/{id}`

### Create Medical Record
Add new medical record for appointment.

**Endpoint**: `POST /medical-records`

**Request Body**:
```json
{
  "appointment_id": 1,
  "diagnosis": "Hypertension",
  "treatment": "Medication",
  "prescription": "Lisinopril 10mg daily",
  "notes": "Follow-up in 2 weeks"
}
```

**Validation Rules**:
- `appointment_id`: Must exist and be unique (one record per appointment)
- `diagnosis`: Required, max 500 chars
- `treatment`: Required, max 500 chars
- `prescription`: Optional, max 1000 chars
- `notes`: Optional, max 1000 chars

### Update Medical Record
Modify medical record.

**Endpoint**: `PUT /medical-records/{id}`

### Delete Medical Record
Remove medical record.

**Endpoint**: `DELETE /medical-records/{id}`

---

## Files Endpoints

### Get All Files
Retrieve list of all uploaded files.

**Endpoint**: `GET /files`

**Response** (200 OK):
```json
{
  "message": "Files retrieved successfully.",
  "data": [
    {
      "id": 1,
      "file_path": "files/document.pdf",
      "file_name": "document.pdf",
      "description": "Patient medical report",
      "created_at": "2026-05-15T14:00:00.000000Z",
      "updated_at": "2026-05-15T14:00:00.000000Z"
    }
  ]
}
```

### Get File Metadata
Retrieve specific file metadata.

**Endpoint**: `GET /files/{id}`

### Upload File
Upload document or image.

**Endpoint**: `POST /files`

**Request Headers**:
```
Authorization: Bearer {access_token}
Content-Type: multipart/form-data
Accept: application/json
```

**Request Body** (form-data):
- `file`: Binary file (pdf, doc, docx, jpg, png, gif), max 10MB
- `description`: Optional text description

**Response** (201 Created):
```json
{
  "message": "File uploaded successfully.",
  "data": { /* file object */ }
}
```

### Update File
Modify file metadata.

**Endpoint**: `PUT /files/{id}`

**Request Body**:
```json
{
  "description": "Updated description"
}
```

### Delete File
Remove file.

**Endpoint**: `DELETE /files/{id}`

### Download File
Download file content.

**Endpoint**: `GET /files/{id}/download`

**Response**: Binary file content with appropriate headers

---

## Error Handling

### Validation Error (422)
```json
{
  "message": "Validation failed",
  "errors": {
    "email": ["The email has already been taken."],
    "password": ["The password must be at least 8 characters."]
  }
}
```

### Unauthorized (401)
```json
{
  "message": "Unauthenticated."
}
```

### Not Found (404)
```json
{
  "message": "Not found"
}
```

### Server Error (500)
```json
{
  "message": "Server error",
  "exception": "Error details"
}
```

---

## HTTP Status Codes
- `200 OK` - Request successful
- `201 Created` - Resource created successfully
- `400 Bad Request` - Invalid request
- `401 Unauthorized` - Missing or invalid token
- `404 Not Found` - Resource not found
- `422 Unprocessable Entity` - Validation error
- `500 Internal Server Error` - Server error

---

## Rate Limiting
Currently no rate limiting implemented. Production deployment should add rate limiting middleware.

---

## CORS Support
CORS is enabled for all origins (can be restricted in production via `config/cors.php`).

---

## Pagination
Not implemented. All endpoints return complete datasets. Implement pagination for production.

---

## Versioning
Current API version: v1 (no version prefix in routes)

---

## Database Backup
Latest backup available in `/docs/database_backup_*.sql`

Restore backup:
```bash
mysql -u root -h 127.0.0.1 hospital_management < database_backup_*.sql
```
