# Simple Article API

Ini adalah proyek REST API sederhana untuk mengelola artikel, dibuat sebagai bagian dari Take-Home Test Backend Developer. Proyek ini dibangun menggunakan **Laravel 10** dan **MySQL**.

## Fitur

-   Registrasi dan Login User (Authentication via Laravel Sanctum)
-   CRUD (Create, Read, Update, Delete) untuk Artikel
-   Endpoint yang dilindungi (hanya bisa diakses setelah login)
-   Validasi input dan penanganan error standar
-   [Nilai Plus] Pagination pada list artikel
-   [Nilai Plus] Fitur pencarian (search) berdasarkan judul atau konten

## Setup & Instalasi Lokal

Berikut adalah langkah-langkah untuk menjalankan proyek ini di lingkungan lokal Anda.

1.  **Clone Repositori**
    ```bash
    git clone [https://github.com/](https://github.com/)[username-anda]/simple-article-api.git
    cd simple-article-api
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
    DB_DATABASE=simple_article_api_db
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

## Dokumentasi API (Opsional: Postman/Swagger)

[Jika Anda membuat dokumentasi Postman, letakkan linknya di sini. Contoh: "Dokumentasi lengkap API dapat diakses melalui [Link Postman Collection](link-anda)"]

---

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
