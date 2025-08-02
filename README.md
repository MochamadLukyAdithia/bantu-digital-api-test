# Article API

Ini adalah proyek REST API sederhana untuk mengelola artikel, dibuat sebagai bagian dari Take-Home Test Backend Developer. Proyek ini dibangun menggunakan **Laravel 12** dan **MySQL**.

## Fitur

-   Registrasi dan Login User (Authentication via Laravel Sanctum)
-   CRUD (Create, Read, Update, Delete) untuk Artikel
-   Endpoint yang dilindungi (hanya bisa diakses setelah login)
-   Validasi input dan penanganan error standar
-   Pagination pada list artikel
-   Fitur pencarian (search) berdasarkan judul atau konten

## Setup & Instalasi Lokal

Berikut adalah langkah-langkah untuk menjalankan proyek ini di lingkungan lokal Anda.

1.  **Clone Repositori**
    ```bash
    git clone https://github.com/MochamadLukyAdithia/bantu-digital-api-test.git
    cd bantu-digital-api-test
    ```

2.  **Install Dependencies**
    Pastikan Anda memiliki Composer terinstall.
    ```bash
    composer install
    ```

3.  **Setup Environment File**
    Salin file `.env.example` menjadi `.env`.
    ```bash
    cp .env.example .env
    ```

4.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

5.  **Konfigurasi Database**
    Buka file `.env` dan sesuaikan pengaturan database Anda (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=bantu-digital-api-test
    DB_USERNAME=root
    DB_PASSWORD=
    ```
    Pastikan Anda sudah membuat database dengan nama yang sesuai.

6.  **Jalankan Migrasi Database**
    Perintah ini akan membuat semua tabel yang dibutuhkan.
    ```bash
    php artisan migrate
    ```

7.  **Jalankan Server Lokal**
    ```bash
    php artisan serve
    ```
    API akan berjalan di `http://127.0.0.1:8000`.

## Kredensial Dummy

Untuk memudahkan pengujian, Anda bisa melakukan registrasi user baru melalui endpoint `POST /api/register` atau gunakan kredensial berikut setelah Anda melakukan registrasi manual:

-   **Email:** `testuser@example.com`
-   **Password:** `password123`

-----

# **Dokumentasi API**

Selamat datang di dokumentasi resmi untuk Simple Article API. API ini memungkinkan Anda untuk melakukan operasi CRUD (Create, Read, Update, Delete) pada artikel dan mengelola otentikasi pengguna.

## **Base URL**

Semua URL yang dirujuk dalam dokumentasi ini menggunakan base URL berikut:

  * **Lokal:** `http://127.0.0.1:8000`
  * **Produksi:** `https://your-project-name.up.railway.app` (Contoh jika deploy di Railway)

Contoh endpoint lengkap: `http://127.0.0.1:8000/api/register`

## **Autentikasi**

API ini menggunakan **Bearer Token Authentication** untuk melindungi endpoint artikel. Alur untuk mendapatkan akses adalah sebagai berikut:

1.  Daftarkan user baru melalui endpoint `POST /api/register`.
2.  Login menggunakan kredensial user melalui endpoint `POST /api/login` untuk mendapatkan `access_token`.
3.  Untuk setiap permintaan ke endpoint yang dilindungi, sertakan token tersebut di dalam `Authorization` header.

**Contoh Header:**
`Authorization: Bearer <your_access_token>`

## **Ringkasan Kode Status HTTP**

API ini menggunakan kode status HTTP standar untuk mengindikasikan keberhasilan atau kegagalan permintaan.

  * `200 OK` - Permintaan berhasil.
  * `201 Created` - Resource berhasil dibuat.
  * `204 No Content` - Permintaan berhasil namun tidak ada konten untuk dikembalikan (misalnya, setelah operasi DELETE).
  * `401 Unauthorized` - Terjadi kesalahan autentikasi. Token tidak valid atau tidak disertakan.
  * `422 Unprocessable Entity` - Validasi input gagal. Body respons akan berisi detail error per-field.
  * `404 Not Found` - Resource yang diminta tidak ditemukan.

-----

## **Endpoint Autentikasi**

Endpoint untuk registrasi dan login pengguna.

### **1. Registrasi User Baru**

Membuat akun user baru.

  * **Method:** `POST`
  * **URL:** `/api/register`
  * **Headers:**
      * `Accept: application/json`
      * `Content-Type: application/json`

**Request Body:**

| Field                   | Tipe   | Validasi                          | Deskripsi                       |
| ----------------------- | ------ | --------------------------------- | ------------------------------- |
| `name`                  | string | `required`, `max:255`             | Nama lengkap user.              |
| `email`                 | string | `required`, `email`, `unique`     | Alamat email user yang unik.    |
| `password`              | string | `required`, `min:8`, `confirmed`  | Password user (minimal 8 karakter). |
| `password_confirmation` | string | `required`                        | Konfirmasi password, harus sama. |

**Contoh Request Body:**

```json
{
    "name": "LukyAdithia",
    "email": "lukyadithia@example.com",
    "password": "lukyadithia123",
    "password_confirmation": "lukyadithia123"
}
```

**Respons Sukses (`201 Created`):**

```json
{
    "message": "Registration successful",
    "user": {
        "name": "LukyAdithia",
        "email": "lukyadithia@example.com",
        "updated_at": "2025-08-02T17:30:00.000000Z",
        "created_at": "2025-08-02T17:30:00.000000Z",
        "id": 1
    }
}
```

**Respons Error (`422 Unprocessable Entity`):**

```json
{
    "email": [
        "The email has already been taken."
    ],
    "password": [
        "The password confirmation does not match."
    ]
}
```

### **2. Login User**

Mengautentikasi user dan mendapatkan access token.

  * **Method:** `POST`
  * **URL:** `/api/login`

**Request Body:**

| Field      | Tipe   | Validasi     | Deskripsi                |
| ---------- | ------ | ------------ | ------------------------ |
| `email`    | string | `required`, `email` | Alamat email terdaftar.  |
| `password` | string | `required`   | Password user terdaftar. |

**Contoh Request Body:**

```json
{
    "email": "lukyadithia@example.com",
    "password": "lukyadithia123"
}
```

**Respons Sukses (`200 OK`):**

```json
{
    "message": "Login successful",
    "access_token": "2|h9fS...A7n1",
    "token_type": "Bearer"
}
```

**Respons Error (`401 Unauthorized`):**

```json
{
    "message": "Invalid credentials"
}
```

### **3. Logout User**

Menghapus token akses saat ini (membuat token tidak valid lagi).

  * **Method:** `POST`
  * **URL:** `/api/logout`
  * **Authentication:** **Wajib** (Bearer Token).

**Respons Sukses (`200 OK`):**

```json
{
    "message": "Successfully logged out"
}
```

-----

## **Endpoint Artikel**

Endpoint untuk mengelola data artikel. **Semua endpoint di bawah ini memerlukan autentikasi.**

### **1. Mendapatkan Semua Artikel**

Mengambil daftar semua artikel dengan paginasi dan fitur pencarian.

  * **Method:** `GET`
  * **URL:** `/api/articles`
  * **Authentication:** **Wajib** (Bearer Token).
  * **Query Parameters (Opsional):**
      * `page` (integer): Nomor halaman yang ingin ditampilkan. Contoh: `/api/articles?page=2`
      * `search` (string): Kata kunci untuk mencari artikel berdasarkan judul atau konten. Contoh: `/api/articles?search=laravel`

**Respons Sukses (`200 OK`):**

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "title": "Mengenal Laravel 12",
            "content": "Ini adalah konten tentang fitur baru di Laravel 12...",
            "author": "Luky Adithia",
            "created_at": "2025-08-02T17:45:00.000000Z",
            "updated_at": "2025-08-02T17:45:00.000000Z"
        }
    ],
    "first_page_url": "http://127.0.0.1:8000/api/articles?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://127.0.0.1:8000/api/articles?page=1",
    "links": [
        // ...
    ],
    "next_page_url": null,
    "path": "http://127.0.0.1:8000/api/articles",
    "per_page": 10,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```

### **2. Membuat Artikel Baru**

  * **Method:** `POST`
  * **URL:** `/api/articles`
  * **Authentication:** **Wajib** (Bearer Token).

**Request Body:**

| Field     | Tipe   | Validasi                | Deskripsi          |
| --------- | ------ | ----------------------- | ------------------ |
| `title`   | string | `required`, `max:255`   | Judul artikel.     |
| `content` | string | `required`              | Isi konten artikel.|
| `author`  | string | `required`, `max:255`   | Nama penulis.      |

**Contoh Request Body:**

```json
{
    "title": "Tips Efektif Belajar API",
    "content": "Berikut adalah beberapa tips untuk belajar REST API secara efektif...",
    "author": "Luky Adithia"
}
```

**Respons Sukses (`201 Created`):**
Body respons akan berisi data artikel yang baru saja dibuat.

### **3. Mendapatkan Detail Artikel**

  * **Method:** `GET`
  * **URL:** `/api/articles/{id}`
  * **Authentication:** **Wajib** (Bearer Token).
  * **Path Parameter:**
      * `id` (integer): ID dari artikel yang ingin ditampilkan.

**Respons Sukses (`200 OK`):**
Body respons akan berisi data lengkap dari satu artikel.

**Respons Error (`404 Not Found`):**

```json
{
    "message": "Not Found"
}
```

### **4. Memperbarui Artikel**

  * **Method:** `PUT` atau `PATCH`
  * **URL:** `/api/articles/{id}`
  * **Authentication:** **Wajib** (Bearer Token).

**Request Body:**
Sama seperti request body untuk membuat artikel, namun semua field bersifat opsional (`sometimes`).

**Respons Sukses (`200 OK`):**
Body respons akan berisi data artikel yang sudah diperbarui.

### **5. Menghapus Artikel**

  * **Method:** `DELETE`
  * **URL:** `/api/articles/{id}`
  * **Authentication:** **Wajib** (Bearer Token).

**Respons Sukses (`204 No Content`):**
Tidak ada body konten yang dikembalikan.

---

