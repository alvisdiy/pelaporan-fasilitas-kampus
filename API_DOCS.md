# Dokumentasi RESTful API - Pelaporan Fasilitas Kampus

Dokumentasi ini menjelaskan spesifikasi dan cara penggunaan API untuk sistem pelaporan fasilitas kampus. API ini dibangun menggunakan Laravel dan dilindungi dengan autentikasi Token (Sanctum).

## Informasi Dasar
- **Base URL**: `http://localhost:8000/api` (Sesuaikan dengan URL domain saat deploy)
- **Content-Type**: `application/json`
- **Accept**: `application/json`

## Autentikasi
Sebagian besar endpoint membutuhkan autentikasi. Gunakan endpoint Login untuk mendapatkan **Access Token**.
Setiap request ke endpoint yang diproteksi **WAJIB** menyertakan token di Header:

```http
Authorization: Bearer <your_access_token>
Accept: application/json
Daftar Endpoint
1. Autentikasi
A. Login (Dapatkan Token)
Digunakan untuk menukar NIM dan Password dengan Access Token.

URL: /login

Method: POST

Body (JSON):

JSON

{
    "nim": "12345678",
    "password": "password"
}
Response Sukses (200 OK):

JSON

{
    "status": true,
    "message": "Login berhasil",
    "access_token": "1|CzV2SJzEgP90TOcOTBPhUgBtMZW22yt6cDSgJmltd5384c55",
    "token_type": "Bearer",
    "user": {
        "id": 1,
        "name": "Alvisganteng",
        "nim": "12345678",
        "created_at": "2025-12-17T11:29:22.000000Z",
        "updated_at": "2025-12-17T11:29:22.000000Z"
    }
}
Response Gagal (401 Unauthorized):

JSON

{
    "status": false,
    "message": "NIM atau Password salah!"
}
B. Cek Profil User
Melihat data user yang sedang login berdasarkan token.

URL: /user

Method: GET

Header: Wajib Authorization

Response Sukses (200 OK):

JSON

{
    "id": 1,
    "name": "Alvisganteng",
    "nim": "12345678",
    ...
}
2. Manajemen Laporan
Semua endpoint di bawah ini membutuhkan Header Authorization.

A. Lihat Semua Laporan
Mengambil daftar semua laporan kerusakan fasilitas.

URL: /laporan

Method: GET

Response Sukses (200 OK):

JSON

{
    "data": [
        {
            "id": 1,
            "gedung": "Gedung A",
            "ruang": "101",
            "fasilitas": "AC",
            "kerusakan": "AC Bocor parah",
            "status": "Diterima",
            "foto": "laporan/foto1.jpg",
            "pelapor_nama": "Alvisganteng",
            "pelapor_nim": "12345678",
            "created_at": "...",
            "updated_at": "..."
        },
        ...
    ]
}
B. Buat Laporan Baru
Melaporkan kerusakan fasilitas baru. Mendukung upload foto.

URL: /laporan

Method: POST

Header:

Content-Type: multipart/form-data (Karena upload file)

Authorization: Bearer <token>

Body (Form-Data):

gedung: (Text, Wajib) Contoh: "Gedung B"

ruang: (Text, Wajib) Contoh: "Lab Komputer"

fasilitas: (Text, Wajib) Contoh: "PC-05"

kerusakan: (Text, Wajib, Min 10 karakter) Contoh: "Monitor mati total tidak mau nyala"

foto: (File, Opsional) File gambar (jpg/png)

Response Sukses (201 Created):

JSON

{
    "data": {
        "id": 2,
        "gedung": "Gedung B",
        "ruang": "Lab Komputer",
        "fasilitas": "PC-05",
        "kerusakan": "Monitor mati total tidak mau nyala",
        "status": "Diterima",
        "pelapor_nama": "Alvisganteng",
        ...
    }
}
C. Detail Laporan
Melihat detail satu laporan spesifik.

URL: /laporan/{id}

Method: GET

Contoh: /laporan/1

Response Sukses (200 OK):

JSON

{
    "data": { ...data laporan... }
}