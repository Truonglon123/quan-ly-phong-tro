# Quản Lý Phòng Trọ

Hệ thống **quản lý phòng trọ** được xây dựng với **Laravel** và **Filament**, hỗ trợ chủ trọ quản lý phòng, người thuê, hợp đồng, tiền thuê, điện nước và các khoản thu một cách tập trung.

Dự án hướng tới việc đơn giản hóa quy trình quản lý khu trọ, hạn chế việc theo dõi thủ công bằng Excel hoặc sổ sách.

---

## Tính năng

### Quản lý khu trọ

- Quản lý nhiều khu trọ
- Quản lý thông tin khu trọ
- Quản lý dãy phòng
- Theo dõi tổng số phòng
- Theo dõi phòng đang trống / đang thuê

### Quản lý phòng

- Thêm, sửa, xóa phòng
- Quản lý số phòng
- Quản lý giá thuê
- Trạng thái phòng:
    - Trống
    - Đang thuê
    - Đang sửa chữa
    - Đã đặt

- Quản lý diện tích và thông tin phòng
- Theo dõi người đang thuê phòng

### Quản lý người thuê

- Quản lý thông tin người thuê
- Họ tên
- Số điện thoại
- CCCD/CMND
- Ngày sinh
- Địa chỉ
- Thông tin liên hệ
- Quản lý người thuê chính / thành viên ở cùng

### Quản lý hợp đồng

- Tạo hợp đồng thuê phòng
- Ngày bắt đầu
- Ngày kết thúc
- Tiền cọc
- Giá thuê
- Số người ở
- Theo dõi trạng thái hợp đồng
- Gia hạn hợp đồng
- Thanh lý hợp đồng

### Quản lý điện nước

- Ghi chỉ số điện
- Ghi chỉ số nước
- Theo dõi chỉ số cũ / mới
- Tự động tính lượng tiêu thụ
- Tính tiền điện
- Tính tiền nước
- Lưu lịch sử chỉ số theo từng phòng

### Quản lý hóa đơn

Hệ thống hỗ trợ tổng hợp các khoản phải thu của phòng:

- Tiền phòng
- Tiền điện
- Tiền nước
- Phí dịch vụ
- Phí gửi xe
- Các khoản phụ thu khác

Có thể theo dõi trạng thái:

- Chưa thanh toán
- Đã thanh toán
- Thanh toán một phần
- Quá hạn

---

## 🛠️ Công nghệ sử dụng

| Công nghệ          | Mục đích            |
| ------------------ | ------------------- |
| PHP                | Ngôn ngữ lập trình  |
| Laravel            | Backend Framework   |
| Filament           | Admin Panel         |
| Livewire           | Tương tác giao diện |
| MySQL / PostgreSQL | Database            |
| Tailwind CSS       | UI                  |
| Vite               | Frontend build tool |

---

## 📋 Yêu cầu hệ thống

Trước khi cài đặt, đảm bảo môi trường đã có:

- PHP >= 8.2
- Composer
- Node.js >= 20
- pnpm / npm
- MySQL hoặc PostgreSQL
- Git

Kiểm tra phiên bản:

```bash
php -v
composer -V
node -v
npm -v
```

---

## Cài đặt

### 1. Clone repository

```bash
git clone https://github.com/your-username/quan-ly-phong-tro.git

cd quan-ly-phong-tro
```

### 2. Cài đặt PHP dependencies

```bash
composer install
```

### 3. Cài đặt frontend dependencies

```bash
npm install
```

Hoặc:

```bash
pnpm install
```

### 4. Tạo file `.env`

```bash
cp .env.example .env
```

### 5. Generate application key

```bash
php artisan key:generate
```

### 6. Cấu hình database

Mở file `.env` và cập nhật thông tin database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=quan_ly_phong_tro
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Chạy migration

```bash
php artisan migrate
```

Nếu project có Seeder:

```bash
php artisan migrate --seed
```

### 8. Build frontend

```bash
npm run build
```

Trong quá trình development:

```bash
npm run dev
```

### 9. Chạy Laravel

```bash
php artisan serve
```

Sau đó truy cập:

```text
http://127.0.0.1:8000
```

---

## Filament Admin Panel

Sau khi chạy project, truy cập:

```text
http://127.0.0.1:8000/admin
```

Tài khoản quản trị có thể được tạo bằng:

```bash
php artisan make:filament-user
```

Sau đó nhập:

```text
Name:
Email:
Password:
```

---

## Cấu trúc dự án

Cấu trúc chính của Laravel project:

```text
quan-ly-phong-tro/
├── app/
│   ├── Filament/
│   │   ├── Resources/
│   │   ├── Pages/
│   │   └── Widgets/
│   │
│   ├── Models/
│   ├── Policies/
│   └── Services/
│
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│
├── routes/
│   ├── web.php
│   └── console.php
│
├── public/
├── storage/
├── tests/
├── .env.example
├── artisan
├── composer.json
├── package.json
└── README.md
```

---

## Quy trình quản lý

Quy trình sử dụng cơ bản:

```text
Khu trọ
   ↓
Tạo phòng
   ↓
Thêm người thuê
   ↓
Tạo hợp đồng
   ↓
Ghi chỉ số điện / nước
   ↓
Tạo hóa đơn
   ↓
Thu tiền
   ↓
Theo dõi doanh thu
```

---

## Các lệnh Artisan thường dùng

```bash
# Chạy server
php artisan serve

# Migration
php artisan migrate

# Reset database
php artisan migrate:fresh

# Reset database + seed
php artisan migrate:fresh --seed

# Tạo Filament user
php artisan make:filament-user

# Clear cache
php artisan optimize:clear

# Cache config
php artisan config:cache

# Cache routes
php artisan route:cache

# Format code
./vendor/bin/pint

# Chạy test
php artisan test
```

---

## Environment Variables

Các biến môi trường quan trọng:

```env
APP_NAME="Quản Lý Phòng Trọ"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

> Không commit file `.env` lên repository.

---
