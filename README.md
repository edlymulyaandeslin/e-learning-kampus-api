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
  "role": ['lecturer', 'student']
}
POST /api/login
{
  "email": "john@example.com",
  "password": "secret"
}
Response
{
    "success" => true,
    "access_token" => "your_token",
    "user" => "detail_user"
}
Authorization: Bearer <token>
Accept: application/json
POST /api/logout
```
