# Hospital Management System - Entity Relationship Diagram

## Database Schema Overview

```
┌─────────────────────────────────────────────────────────────────┐
│                                                                   │
│  ╔════════════════╗                      ╔════════════════╗      │
│  ║    USERS       ║                      ║    DOCTORS     ║      │
│  ╠════════════════╣                      ╠════════════════╣      │
│  ║ id (PK)       ║◄─────────────────────►║ id (PK)       ║      │
│  ║ name          ║         1:1           ║ user_id (FK)  ║      │
│  ║ email         ║                      ║ specialization║      │
│  ║ password      ║                      ║ phone         ║      │
│  ║ role          ║                      ║ photo         ║      │
│  ║ timestamps    ║                      ║ timestamps    ║      │
│  ╚════════════════╝                      ╚════════════════╝      │
│         ▲                                                         │
│         │                                                         │
│         │ 1:1                                                    │
│         │                                                         │
│         │                                 ┌──────────────────┐   │
│         │                                 │   PATIENTS       │   │
│         │                    ┌────────────┤                  │   │
│         └────────────────────┤            ║ id (PK)         ║   │
│                              │            ║ user_id (FK)    ║   │
│                              │            ║ date_of_birth   ║   │
│                              │            ║ address         ║   │
│                              │            ║ phone           ║   │
│                              │            ║ photo           ║   │
│                              │            ║ timestamps      ║   │
│                              │            ╚──────────────────┘   │
│                              │                                   │
│                              └──────────────────────────────────► 1:N
│                                                                   │
│  ┌──────────────────┐          ┌──────────────────────────┐     │
│  │  APPOINTMENTS    │          │   MEDICAL_RECORDS        │     │
│  ├──────────────────┤          ├──────────────────────────┤     │
│  │ id (PK)         ║          │ id (PK)                  ║     │
│  │ patient_id (FK) ├──────────┤ appointment_id (FK)      ║     │
│  │ doctor_id (FK)  ├──┐       │ diagnosis                ║     │
│  │ appointment_date │  └──────┤ treatment                ║     │
│  │ status          ║          │ prescription             ║     │
│  │ complaint       ║          │ notes                    ║     │
│  │ timestamps      ║          │ timestamps               ║     │
│  ╚──────────────────╝          ╚──────────────────────────╝     │
│         ▲                                                         │
│         │ N:1                                                    │
│         │ (from DOCTORS)                  ┌─────────────────┐   │
│         └──────────────────────────────────►│    FILES        │   │
│                                             ├─────────────────┤   │
│                                             │ id (PK)        ║   │
│                                             │ file_path      ║   │
│                                             │ file_name      ║   │
│                                             │ description    ║   │
│                                             │ timestamps     ║   │
│                                             ╚─────────────────┘   │
│                                                                   │
│  ┌──────────────────────┐                                        │
│  │   SCHEDULES          │                                        │
│  ├──────────────────────┤                                        │
│  │ id (PK)             ║                                        │
│  │ doctor_id (FK)      ║                                        │
│  │ day_of_week         ║                                        │
│  │ start_time          ║                                        │
│  │ end_time            ║                                        │
│  │ timestamps          ║                                        │
│  ╚──────────────────────╝                                        │
│                                                                   │
└─────────────────────────────────────────────────────────────────┘
```

## Table Definitions

### USERS
Stores all user accounts (doctors, patients, admins)

| Column       | Type         | Constraints      | Description                          |
|--------------|--------------|------------------|--------------------------------------|
| id           | BIGINT       | PRIMARY KEY, AUTO | Unique user identifier               |
| name         | VARCHAR(255) | NOT NULL         | User's full name                     |
| email        | VARCHAR(255) | UNIQUE, NOT NULL | User's email address                 |
| email_verified_at | TIMESTAMP | NULLABLE        | Email verification timestamp         |
| password     | VARCHAR(255) | NOT NULL         | Hashed password (bcrypt)             |
| role         | VARCHAR(50)  | NOT NULL         | User role: admin, doctor, patient    |
| remember_token | VARCHAR(100) | NULLABLE        | "Remember me" token                  |
| created_at   | TIMESTAMP    | NOT NULL         | Account creation timestamp           |
| updated_at   | TIMESTAMP    | NOT NULL         | Last update timestamp                |

### DOCTORS
Stores doctor profile information linked to users

| Column         | Type         | Constraints     | Description                      |
|----------------|--------------|-----------------|----------------------------------|
| id             | BIGINT       | PRIMARY KEY     | Doctor record ID                 |
| user_id        | BIGINT       | UNIQUE, FK      | Links to users table             |
| specialization | VARCHAR(255) | NOT NULL        | Medical specialization           |
| phone          | VARCHAR(20)  | NOT NULL        | Contact phone number             |
| photo          | VARCHAR(255) | NULLABLE        | Profile photo URL/path           |
| created_at     | TIMESTAMP    | NOT NULL        | Record creation timestamp        |
| updated_at     | TIMESTAMP    | NOT NULL        | Last update timestamp            |

**Relationships**:
- 1:1 with USERS (each doctor has one user)
- 1:N with APPOINTMENTS (doctor has many appointments)
- 1:N with SCHEDULES (doctor has many schedules)

### PATIENTS
Stores patient profile information linked to users

| Column       | Type         | Constraints | Description                  |
|--------------|--------------|-------------|------------------------------|
| id           | BIGINT       | PRIMARY KEY | Patient record ID            |
| user_id      | BIGINT       | UNIQUE, FK  | Links to users table         |
| date_of_birth | DATE        | NOT NULL    | Patient's date of birth      |
| address      | VARCHAR(255) | NOT NULL    | Home address                 |
| phone        | VARCHAR(20)  | NOT NULL    | Contact phone number         |
| photo        | VARCHAR(255) | NULLABLE    | Profile photo URL/path       |
| created_at   | TIMESTAMP    | NOT NULL    | Record creation timestamp    |
| updated_at   | TIMESTAMP    | NOT NULL    | Last update timestamp        |

**Relationships**:
- 1:1 with USERS (each patient has one user)
- 1:N with APPOINTMENTS (patient has many appointments)

### APPOINTMENTS
Stores appointment bookings between patients and doctors

| Column          | Type         | Constraints | Description                    |
|-----------------|--------------|-------------|--------------------------------|
| id              | BIGINT       | PRIMARY KEY | Appointment ID                 |
| patient_id      | BIGINT       | FK, NOT NULL| Links to patients table        |
| doctor_id       | BIGINT       | FK, NOT NULL| Links to doctors table         |
| appointment_date | TIMESTAMP   | NOT NULL    | Scheduled appointment time     |
| status          | VARCHAR(50)  | NOT NULL    | scheduled, completed, cancelled|
| complaint       | TEXT         | NOT NULL    | Patient's complaint/reason     |
| created_at      | TIMESTAMP    | NOT NULL    | Record creation timestamp      |
| updated_at      | TIMESTAMP    | NOT NULL    | Last update timestamp          |

**Relationships**:
- N:1 with PATIENTS (many appointments for patient)
- N:1 with DOCTORS (many appointments for doctor)
- 1:1 with MEDICAL_RECORDS (appointment has optional record)

**Indexes**:
- patient_id, doctor_id (for faster queries)
- appointment_date (for scheduling queries)

### MEDICAL_RECORDS
Stores diagnosis and treatment records for completed appointments

| Column         | Type         | Constraints      | Description                 |
|----------------|--------------|------------------|-----------------------------|
| id             | BIGINT       | PRIMARY KEY      | Medical record ID           |
| appointment_id | BIGINT       | UNIQUE, FK, NOT NULL | Links to appointments     |
| diagnosis      | TEXT         | NOT NULL         | Diagnosis description       |
| treatment      | TEXT         | NOT NULL         | Treatment provided          |
| prescription   | TEXT         | NULLABLE         | Medication prescription     |
| notes          | TEXT         | NULLABLE         | Additional medical notes    |
| created_at     | TIMESTAMP    | NOT NULL         | Record creation timestamp   |
| updated_at     | TIMESTAMP    | NOT NULL         | Last update timestamp       |

**Relationships**:
- 1:1 with APPOINTMENTS (one record per appointment)

### FILES
Stores uploaded file metadata (documents, reports, images)

| Column      | Type         | Constraints | Description                  |
|-------------|--------------|-------------|------------------------------|
| id          | BIGINT       | PRIMARY KEY | File record ID               |
| file_path   | VARCHAR(255) | NOT NULL    | Storage path of file         |
| file_name   | VARCHAR(255) | NOT NULL    | Original filename            |
| description | TEXT         | NULLABLE    | File description             |
| created_at  | TIMESTAMP    | NOT NULL    | Upload timestamp             |
| updated_at  | TIMESTAMP    | NOT NULL    | Last update timestamp        |

**Storage**:
- Files stored in `storage/app/public/files/`
- Accessible via `storage/` symlink

### SCHEDULES
Stores doctor availability/working hours

| Column       | Type         | Constraints | Description                |
|--------------|--------------|-------------|----------------------------|
| id           | BIGINT       | PRIMARY KEY | Schedule record ID         |
| doctor_id    | BIGINT       | FK, NOT NULL| Links to doctors table     |
| day_of_week  | VARCHAR(20)  | NOT NULL    | Monday-Sunday              |
| start_time   | TIME         | NOT NULL    | Shift start time           |
| end_time     | TIME         | NOT NULL    | Shift end time             |
| created_at   | TIMESTAMP    | NOT NULL    | Record creation timestamp  |
| updated_at   | TIMESTAMP    | NOT NULL    | Last update timestamp      |

**Relationships**:
- N:1 with DOCTORS (doctor has multiple schedules)

## Relationship Summary

```
User (1) ──────► Doctor (1)
                    │
                    ├─► (1:N) ──► Appointment ◄─────── (N:1) ── Patient ◄─── (1) ── User
                    │                    │
                    │                    └─► (1:1) ──► Medical Record
                    │
                    └─► (1:N) ──► Schedule

File (no direct relationships - storage service)
```

## Key Relationships

### 1:1 (One-to-One)
- User ↔ Doctor
- User ↔ Patient
- Appointment ↔ Medical Record

### 1:N (One-to-Many)
- Doctor → Appointments
- Patient → Appointments
- Doctor → Schedules

### Data Integrity
- Foreign keys with ON DELETE CASCADE for related records
- UNIQUE constraints on user_id in doctors and patients (prevent duplicates)
- Timestamps automatically managed by Laravel

## Access Patterns

### Common Queries
```sql
-- Get doctor with all appointments
SELECT doctors.*, appointments.* 
FROM doctors 
LEFT JOIN appointments ON doctors.id = appointments.doctor_id

-- Get patient with medical history
SELECT patients.*, appointments.*, medical_records.*
FROM patients
LEFT JOIN appointments ON patients.id = appointments.patient_id
LEFT JOIN medical_records ON appointments.id = medical_records.appointment_id

-- Get appointment with all related data
SELECT appointments.*, doctors.*, patients.*, medical_records.*
FROM appointments
JOIN doctors ON appointments.doctor_id = doctors.id
JOIN patients ON appointments.patient_id = patients.id
LEFT JOIN medical_records ON appointments.id = medical_records.appointment_id
```

## Performance Considerations

1. **Indexes**: Primary keys and foreign keys are automatically indexed
2. **Eager Loading**: Laravel uses `with()` to prevent N+1 queries
3. **Soft Deletes**: Not implemented (can be added for audit trail)
4. **Pagination**: Not implemented (consider adding for large datasets)
5. **Caching**: Not implemented (can be added for frequently accessed data)

## Future Enhancements

- Add prescription items table for detailed medication tracking
- Add patient medical history (conditions, allergies, procedures)
- Add doctor specializations table (normalize many-to-many)
- Add appointment status history/audit trail
- Add billing/invoicing system
- Add user roles and permissions table
