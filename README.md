# 🎓 E-Learning Kampus API

API untuk platform e-learning berbasis Laravel 10, dikembangkan untuk mengelola proses perkuliahan seperti kursus, materi, tugas, diskusi, dan pelaporan.

---

## 🚀 Teknologi

-   **Framework**: Laravel 10
-   **Autentikasi**: Laravel Sanctum
-   **Database**: MySQL
-   **Mail System**: Laravel Mail (dengan dukungan Queue)

---

## 🔐 Autentikasi

Semua endpoint (kecuali `login` dan `register`) menggunakan **Bearer Token (Sanctum)**.

### **Register**

```http
POST /api/register
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "secret",
  "password_confirmation": "secret",
  "role": ["lecturer", "student"]
}
RESPONSE
{
    "success" => true,
    "message" => "User registered successfully"
}
```

### **Login**

```http
POST /api/login
{
  "email": "john@example.com",
  "password": "secret",
}
RESPONSE
{
    "success": true,
    "access_token": "your_token",
    "user": "detail_user"
}
```

### **Logout**

```http
Authorization: Bearer <token>
Accept: application/json

POST /api/logout
RESPONSE
{
    "success": true,
    "message": "Logged out successfully",
}
```

### **Lecturer Features**

```http
Authorization: Bearer <token>
Accept: application/json

GET /api/courses
RESPONSE
{
    "success": true,
    "message": "List Data Courses",
    "data": "data_courses"
}
```

```http
Authorization: Bearer <token>
Accept: application/json

POST /api/courses
{
    "lecturer_id" => "required",
    "name" => "required",
    "description" => "required",
}
RESPONSE
{
    "success": true,
    "message": "Course stored successfully",
    "data": "data_course"
}
```

```http
Authorization: Bearer <token>
Accept: application/json

PUT /api/courses/{id}
{
    "lecturer_id" => "required",
    "name" => "string",
    "description" => "string",
}
RESPONSE
{
    "success": true,
    "message": "Course updated successfully",
    "data": "data_course"
}
```

```http
Authorization: Bearer <token>
Accept: application/json

DELETE /api/courses/{id}
RESPONSE
{
    "success": true,
    "message": "Course deleted successfully",
}
```

```http
Authorization: Bearer <token>
Accept: application/json

POST /api/materials
{
    "course_id" => "required",
    "title" => "required",
    "file_path" => "required|file|mimes:pdf,doc,docx,ppt,pptx,zip",
}
RESPONSE
{
    "success": true,
    "message": "File uploaded successfully",
    "data": "data_uploaded"
}
```

```http
Authorization: Bearer <token>
Accept: application/json

POST /api/assignments
{
    "course_id" => "required",
    "title" => "required",
    "description" => "required",
    "deadline" => "required|date",
}
RESPONSE
{
    "success": true,
    "message": "Assignment stored successfully",
    "data": "data_assignment"
}
```

```http
Authorization: Bearer <token>
Accept: application/json

POST /api/submissions/{id}/grade
{
    "score" => "required",
}
RESPONSE
{
    "success": true,
    "message": "Submission graded successfully",
    "data": "data_grade"
}
```

### **Student Features**

```http
Authorization: Bearer <token>
Accept: application/json

POST /api/courses/{id}/enroll
RESPONSE
{
    "success": true,
    "message": "Student enrolled in course successfully",
    "data": "data"
}
```

```http
Authorization: Bearer <token>
Accept: application/json

GET /api/materials/{id}/download
RESPONSE
{
    "success": true,
    "message": "Student enrolled in course successfully",
    "data": "data"
}
```

```http
Authorization: Bearer <token>
Accept: application/json

POST /api/submissions
{
    "assignment_id" => "required",
    "student_id" => "required",
    "file_path" => "required|file|mimes:pdf,doc,docx,zip|max:2048",
}
RESPONSE
{
    "success": true,
    "message": "Submission stored successfully",
    "data": "data_submission"
}
```

### **Auth Features**

```http
Authorization: Bearer <token>
Accept: application/json

POST /api/discussions
{
    "course_id" => "required",
    "user_id" => "required",
    "content" => "required",
}
RESPONSE
{
    "success": true,
    "message": "Discussion created successfully",
    "data": "data"
}
```

```http
Authorization: Bearer <token>
Accept: application/json

POST /api/discussions/{id}/replies
{
    "discussion_id" => "required",
    "user_id" => "required",
    "content" => "required",
}
RESPONSE
{
    "success": true,
    "message": "Replies created successfully",
    "data": "data"
}
```
