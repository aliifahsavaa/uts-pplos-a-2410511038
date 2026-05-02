# Sistem Manajemen Kos
**Nama** : Aliifah Sava Fikrana
**NIM** : 2410511038
**Kelas** :A

## Demo Video
https://www.youtube.com/watch?v=XHqnpXbVw1c

## Cara Menjalankan
### Prasyarat
- Node.js v18+
- PHP 8.2+
- Composer 
- MySQL 9.7 (port 3307)

### 1. Clone Repository
```bash
git clone https://github.com/aliifahsavaa/uts-pplos-a-2410511038-git
cd uts-pplos-a-2410511038
```

### 2. Setup Database
Buat 3 database di MySQL:
```sql
CREATE DATABASE auth_db;
CREATE DATABASE kos_db;
CREATE DATABASE payment_db;
```

### 3. Jalankan Auth-Service
```bash
cd services/auth-service
npm install
# Buat file .env (lihat .env.example)
node src/index.js
```

### 4. Jalankan Kos-Service
```bash
cd services/kos-service
composer install
# Sesuaikan .env dengan konfigurasi database
php artisan migrate
php artisan serve --port=8000
```

### 5. Jalankan Payment-Service
```bash
cd services/payment-service
npm install
# Buat file .env (lihat .env.example)
node index.js
```

### 6. Jalankan API Gateway
```bash
cd gateway
npm install
# Buat file .env
node index.js

### Semua Service Berjalan
- Service: API Gateway (Port: 3000)
- Service: Auth-Service (Port: 3001)
- Service: Kos-Service (Port: 8000)
- Service: Payment-Service (Port: 3003)
---

## Peta Endpoint
### Auth-Service
- POST /api/auth/regiter -> Daftar User Baru
- POST /api/auth/login -> Login dan Dapatkan Token
- POST /api/auth/refresh -> Perbarui Access Token
- POST /api/auth/logout -> Invalidasi Refresh Token
- GET /api/auth/google -> Redirect ke Google OAuth
- GET /api/auth/profile -> Lihat Profil User (JWT)

### Kos-Service
- GET /api/kos/api/kamar -> Listing Kamar (filter: status=tersedia, paging: ?per_page=5&page=1)
- POST /api/kos/api/kamar -> Tambah Kamar
- GET /api/kos/api/kamar/{id} -> Detail Kamar
- PUT /api/kos/api/kamar/{id} -> Update Kamar
- DELETE /api/kos/api/kamar/{id} -> Hapus kamar
- GET /api/kos/api/penyewa -> Listing Penyewa
- POST /api/kos/api/penyewa -> Tambah Penyewa
- GET /api/kos/api/penyewa/{id} -> Detail Penyewa
- PUT /api/kos/api/penyewa/{id} -> Update Penyewa
- DELETE /api/kos/api/penyewa/{id} -> Hapus Penyewa
- GET /api/kos/api/pemilik -> Listing Pemilik
- POST /api/kos/api/pemilik -> Tambah Pemilik
- GET /api/kos/api/pemilik/{id} -> Detail Pemilik
- PUT /api/kos/api/pemilik/{id} -> Update Pemilik
- DELETE /api/kos/api/pemilik/{id} -> Hapus Pemilik
- GET /api/kos/api/booking -> Listing Booking
- POST /api/kos/api/booking -> Buat Booking
- GET /api/kos/api/booking/{id} -> Detail Booking
- PUT /api/kos/api/booking/{id} -> Update Booking
- DELETE /api/kos/api/booking/{id} -> Hapus Booking

### Payment-Service
- POST /api/payments/api/payments -> Catat Pembayaran
- GET /api/payments/api/payments -> Riwayat Pembayaran
 