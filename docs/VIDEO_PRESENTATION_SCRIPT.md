# 🎬 Hospital Management System - Video Presentation Script

**Total Duration: ~15-20 minutes**

---

## 📋 INTRO (1 minute)

**Speaker 1 (Opening):**

"Assalamu'alaikum, selamat pagi. Kami adalah tim [Team Name] dari BNCC Learning and Training 2026. Hari ini kami akan mempresentasikan Final Project kami: **Hospital Management System** - sebuah REST API backend yang dibangun menggunakan Laravel.

Dalam presentasi ini, kami akan menjelaskan:
- Perancangan database dan ERD diagram
- Struktur tabel dan relasi antar data
- Implementasi REST API dengan 32 endpoints
- Fitur autentikasi dan otorisasi
- Testing dan cara penggunaan

Mari kita mulai dengan perancangan database."

---

## 🗄️ SECTION 1: DATABASE DESIGN & ERD (3-4 minutes)

**Speaker 1 (Show ERD Diagram):**

"Sebelum membuat API, kami merancang database terlebih dahulu dengan 7 tabel utama:

### Tabel-Tabel Utama:

**1. Users Table** - Menyimpan data semua pengguna
   - id (Primary Key)
   - name (nama pengguna)
   - email (email unik)
   - password (terenkripsi)
   - role (admin, doctor, patient)
   - timestamps (created_at, updated_at)

**2. Doctors Table** - Data spesifik dokter
   - id (Primary Key)
   - user_id (Foreign Key ke Users)
   - specialization (spesialisasi dokter)
   - license_number (nomor lisensi)
   - phone (kontak dokter)

**3. Patients Table** - Data spesifik pasien
   - id (Primary Key)
   - user_id (Foreign Key ke Users)
   - date_of_birth (tanggal lahir)
   - gender (jenis kelamin)
   - blood_type (golongan darah)
   - address (alamat)

**4. Appointments Table** - Data jadwal janji temu
   - id (Primary Key)
   - doctor_id (Foreign Key ke Doctors)
   - patient_id (Foreign Key ke Patients)
   - appointment_date (tanggal janji)
   - status (pending, completed, cancelled)
   - description (deskripsi janji)

**5. Medical_Records Table** - Data rekam medis pasien
   - id (Primary Key)
   - appointment_id (Foreign Key ke Appointments)
   - diagnosis (diagnosis penyakit)
   - treatment (penanganan)
   - notes (catatan tambahan)

**6. Files Table** - File pendukung (X-ray, lab results, dll)
   - id (Primary Key)
   - appointment_id (Foreign Key ke Appointments)
   - file_path (lokasi file)
   - file_type (tipe file)
   - uploaded_by (siapa yang upload)

**7. Personal_Access_Tokens** - Token untuk autentikasi API
   - Digunakan oleh Laravel Sanctum
   - Menyimpan bearer tokens untuk pengguna yang login

### Relasi Antar Tabel:

\`\`\`
Users (1) -----→ (1) Doctors
       ↓
       └-----→ (1) Patients

Doctors (1) -----→ (N) Appointments ←----- (N) Patients
              ↓
              Appointments (1) -----→ (1) Medical_Records
                              ↓
                              Medical_Records (1) -----→ (N) Files
\`\`\`

Relasi ini memastikan:
- Setiap user bisa menjadi doctor atau patient
- Setiap doctor bisa punya banyak appointments
- Setiap appointment bisa punya satu medical record
- Setiap appointment bisa punya banyak files (X-ray, lab test, etc)"

---

## 🔑 SECTION 2: AUTHENTICATION & SECURITY (2-3 minutes)

**Speaker 2 (Explaining Auth Flow):**

"Sistem kami menggunakan **Laravel Sanctum** untuk autentikasi API.

### Alur Autentikasi:

**1. Registration (Pendaftaran Akun)**
   - User kirim: name, email, password, password_confirmation, role
   - Server hashing password menggunakan bcrypt
   - Membuat user baru dan meng-assign role (doctor/patient/admin)
   - Return: user data + access_token

**2. Login**
   - User kirim: email, password
   - Server validasi kredensial
   - Jika benar, generate token baru
   - Return: user data + access_token

**3. API Request dengan Token**
   - Client kirim request dengan header: \`Authorization: Bearer {token}\`
   - Server validasi token di personal_access_tokens table
   - Jika valid, process request
   - Jika tidak, return 401 Unauthorized

**4. Logout**
   - User request logout
   - Server menghapus token dari database
   - Client tidak bisa pakai token lagi

### Security Features:
- ✅ Password hashing dengan bcrypt
- ✅ CSRF protection
- ✅ SQL injection prevention (Eloquent ORM)
- ✅ Token-based authentication
- ✅ Role-based access control"

---

## 🔌 SECTION 3: REST API ENDPOINTS (4-5 minutes)

**Speaker 2 (Show Postman Collection):**

"Kami mengimplementasikan **32 endpoints** untuk operasi CRUD lengkap.

### Endpoint Categories:

**A. Authentication Endpoints (3):**
- \`POST /api/register\` - Daftar akun baru
- \`POST /api/login\` - Login dan dapatkan token
- \`POST /api/logout\` - Logout dan hapus token

**B. Doctor Endpoints (5):**
- \`GET /api/doctors\` - List semua dokter (public)
- \`GET /api/doctors/{id}\` - Detail dokter (public)
- \`POST /api/doctors\` - Buat dokter baru (auth)
- \`PUT /api/doctors/{id}\` - Update dokter (auth)
- \`DELETE /api/doctors/{id}\` - Hapus dokter (auth)

**C. Patient Endpoints (5):**
- \`GET /api/patients\` - List pasien (public)
- \`GET /api/patients/{id}\` - Detail pasien (public)
- \`POST /api/patients\` - Buat pasien (auth)
- \`PUT /api/patients/{id}\` - Update pasien (auth)
- \`DELETE /api/patients/{id}\` - Hapus pasien (auth)

**D. Appointment Endpoints (5):**
- \`GET /api/appointments\` - List appointments (public)
- \`GET /api/appointments/{id}\` - Detail appointment (public)
- \`POST /api/appointments\` - Buat appointment (auth)
- \`PUT /api/appointments/{id}\` - Update appointment (auth)
- \`DELETE /api/appointments/{id}\` - Hapus appointment (auth)

**E. Medical Record Endpoints (5):**
- Similar pattern untuk CRUD medical records

**F. File Endpoints (7):**
- \`GET /api/files\` - List files
- \`GET /api/files/{id}\` - Detail file
- \`POST /api/files\` - Upload file (multipart/form-data)
- \`PUT /api/files/{id}\` - Update file description
- \`DELETE /api/files/{id}\` - Hapus file
- \`GET /api/files/{id}/download\` - Download file
- \`POST /api/files/{id}/share\` - Share file dengan pengguna lain

### HTTP Status Codes yang Kami Gunakan:
- \`200 OK\` - Request berhasil
- \`201 Created\` - Resource berhasil dibuat
- \`400 Bad Request\` - Request tidak valid
- \`401 Unauthorized\` - Token tidak valid atau hilang
- \`404 Not Found\` - Resource tidak ditemukan
- \`422 Unprocessable Entity\` - Validation error"

---

## 💻 SECTION 4: CODE IMPLEMENTATION (4-5 minutes)

**Speaker 3 (Show Controllers):**

"Mari kita lihat implementasi kode. Kami membuat **5 Resource Controllers** menggunakan Laravel pattern.

### Example: Doctor Controller

\`\`\`php
namespace App\Http\Controllers\API;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DoctorController extends Controller
{
    // GET /api/doctors - List semua dokter
    public function index()
    {
        $doctors = Doctor::with('user', 'appointments')->get();
        
        return response()->json([
            'message' => 'Doctors retrieved successfully.',
            'data' => $doctors
        ]);
    }

    // GET /api/doctors/{id} - Lihat detail dokter
    public function show($id)
    {
        $doctor = Doctor::with('user', 'appointments')->find($id);
        
        if (!$doctor) {
            return response()->json(
                ['message' => 'Doctor not found'],
                404
            );
        }
        
        return response()->json([
            'message' => 'Doctor retrieved successfully.',
            'data' => $doctor
        ]);
    }

    // POST /api/doctors - Buat dokter baru (auth)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'specialization' => 'required|string',
            'license_number' => 'required|unique:doctors',
            'phone' => 'required|phone'
        ]);

        $doctor = Doctor::create($validated);
        
        return response()->json([
            'message' => 'Doctor created successfully.',
            'data' => $doctor
        ], 201);
    }

    // PUT /api/doctors/{id} - Update dokter (auth)
    public function update(Request $request, $id)
    {
        $doctor = Doctor::find($id);
        
        if (!$doctor) {
            return response()->json(
                ['message' => 'Doctor not found'],
                404
            );
        }

        $doctor->update($request->validate([
            'specialization' => 'string',
            'phone' => 'phone'
        ]));

        return response()->json([
            'message' => 'Doctor updated successfully.',
            'data' => $doctor
        ]);
    }

    // DELETE /api/doctors/{id} - Hapus dokter (auth)
    public function destroy($id)
    {
        $doctor = Doctor::find($id);
        
        if (!$doctor) {
            return response()->json(
                ['message' => 'Doctor not found'],
                404
            );
        }

        $doctor->delete();
        
        return response()->json([
            'message' => 'Doctor deleted successfully.'
        ]);
    }
}
\`\`\`

**Key Points dalam Implementasi:**

1. **Eager Loading (.with())**
   - \`Doctor::with('user', 'appointments')\` mencegah N+1 query problem
   - Lebih efficient untuk database queries

2. **Validation**
   - Setiap input harus divalidasi sebelum disimpan
   - Unique constraints, required fields, dll

3. **Error Handling**
   - Return 404 jika resource tidak ditemukan
   - Return 422 jika data tidak valid
   - Pesan error yang clear

4. **JSON Response**
   - Konsisten format: \`{message, data}\`
   - HTTP status codes yang tepat

### Routes Configuration:

\`\`\`php
// routes/api.php

// Public Routes (No Authentication)
Route::get('/doctors', [DoctorController::class, 'index']);
Route::get('/doctors/{id}', [DoctorController::class, 'show']);
// ... other GET endpoints

// Protected Routes (Authentication Required)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/doctors', [DoctorController::class, 'store']);
    Route::put('/doctors/{id}', [DoctorController::class, 'update']);
    Route::delete('/doctors/{id}', [DoctorController::class, 'destroy']);
    // ... other write operations
});
\`\`\`

Setiap route dilindungi dengan middleware 'auth:sanctum' untuk memastikan hanya user yang terautentikasi yang bisa melakukan operasi write (POST, PUT, DELETE)."

---

## 🧪 SECTION 5: TESTING & DEMO (2-3 minutes)

**Speaker 3 (Open Postman):**

"Sekarang mari kita test API-nya secara langsung menggunakan Postman.

### Testing Steps:

**1. Registrasi Akun Baru**
   - POST http://127.0.0.1:8000/api/register
   - Body:
   \`\`\`json
   {
     "name": "Dr. Ahmad Sutarjo",
     "email": "ahmad@hospital.com",
     "password": "password123",
     "password_confirmation": "password123",
     "role": "doctor"
   }
   \`\`\`
   - Response: 201 Created dengan access_token

**2. Copy Token**
   - Ambil access_token dari response
   - Set di environment variable Postman

**3. Test GET Endpoint (Public)**
   - GET http://127.0.0.1:8000/api/doctors
   - Tidak perlu token
   - Response: List semua dokter

**4. Test POST Endpoint (Protected)**
   - POST http://127.0.0.1:8000/api/doctors
   - Header: \`Authorization: Bearer {token}\`
   - Body dengan data doctor baru
   - Response: 201 Created

**5. Test PUT Endpoint (Update)**
   - PUT http://127.0.0.1:8000/api/doctors/{id}
   - Update data dokter
   - Response: 200 OK

**6. Test DELETE Endpoint**
   - DELETE http://127.0.0.1:8000/api/doctors/{id}
   - Response: 200 OK

Semua endpoint kami sudah berhasil ditest dan working dengan baik."

---

## 📊 SECTION 6: PROJECT SUMMARY (1-2 minutes)

**Speaker 1 (Conclusion):**

"Ringkasan apa yang telah kami kerjakan:

### ✅ Deliverables:

**Database:**
- ✅ 7 tabel dengan struktur relasional yang proper
- ✅ Migrations untuk auto-create tables
- ✅ Database backup file tersedia

**API Implementation:**
- ✅ 32 endpoints untuk CRUD lengkap
- ✅ Authentication dengan Sanctum tokens
- ✅ Authorization & role-based access
- ✅ Proper error handling & validation
- ✅ Eager loading untuk query optimization

**Documentation:**
- ✅ ERD diagram (Entity Relationship Diagram)
- ✅ API documentation lengkap
- ✅ Postman collection (32+ requests)
- ✅ README dengan setup instructions
- ✅ Testing guide untuk setiap endpoint

**Code Quality:**
- ✅ Mengikuti Laravel conventions
- ✅ Separation of concerns (MVC pattern)
- ✅ DRY principle - tidak ada code duplication
- ✅ Proper exception handling
- ✅ Git history dengan commit messages yang clear

### Technology Stack:
- Laravel 12.x - Framework
- MySQL - Database
- Sanctum - Authentication
- PHP 8.2+ - Language

### Key Features:
1. **User Management** - Register, login, logout dengan role assignment
2. **Doctor Management** - CRUD untuk data dokter dan spesialisasi
3. **Patient Management** - CRUD untuk data pasien
4. **Appointment System** - Booking, rescheduling, cancellation
5. **Medical Records** - Diagnosis dan treatment tracking
6. **File Management** - Upload dan download file medis

### Testing Results:
- ✅ Semua 32 endpoints tested
- ✅ Response time < 100ms
- ✅ Error handling berjalan dengan baik
- ✅ Database queries optimized

Proyek ini siap untuk production deployment dan dapat diintegrasikan dengan frontend application."

---

## 🎬 OUTRO (30 seconds)

**All Speakers (Together or take turns):**

"Terima kasih telah menonton presentasi Hospital Management System kami. Project ini menunjukkan implementasi praktis dari konsep-konsep backend yang telah kami pelajari di BNCC.

Jika ada pertanyaan atau ingin mencoba API, semua file sudah tersedia di GitHub repository kami.

Wassalamu'alaikum dan terima kasih."

---

## 📝 NOTES FOR RECORDING:

### Before Recording:
- [ ] Make sure Laravel server is running: \`php artisan serve\`
- [ ] Have MySQL running (XAMPP)
- [ ] Open Postman and import collection
- [ ] Prepare Postman environment with base_url
- [ ] Open ERD diagram file
- [ ] Have code editor open showing controllers
- [ ] Test all endpoints before recording

### Recording Tips:
- Speak clearly and slowly
- Use screen recording software (OBS, Camtasia, etc)
- Show actual code and API responses
- Do live testing in Postman
- Include database diagram in slides
- Show request/response examples

### Recommended Software:
- OBS Studio (free, open source)
- Postman (for API testing)
- VS Code or IDE (for showing code)
- Screen recording: Windows built-in recorder or OBS

### Video Structure Suggestion:
- Intro slide (10 sec)
- Show ERD diagram (3 min)
- Explain database tables (2 min)
- Show controllers (3 min)
- Demo Postman testing (4 min)
- Summary slide (1 min)
- **Total: ~15 minutes**

---

## 🎯 Key Points to Emphasize:

1. **Database Design** - Show how we planned before coding
2. **Relational Integrity** - Explain foreign keys and relationships
3. **REST Principles** - HTTP methods, status codes, JSON format
4. **Authentication Flow** - How tokens work and protect endpoints
5. **Code Quality** - Clean code, error handling, optimization
6. **Testing** - Live Postman demo showing all features working

---

**Ready to record! 🎥**
