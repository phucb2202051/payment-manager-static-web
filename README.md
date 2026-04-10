# 💰 Payment Manager Static Web

## 📖 Description

Payment Manager là ứng dụng web giúp quản lý chi tiêu cá nhân.
Người dùng có thể đăng nhập, thêm, xem, sửa và xóa các khoản chi tiêu trong hệ thống.

Dự án được xây dựng bằng PHP thuần nhằm thực hành thao tác với database và xử lý CRUD.

---

## 🚀 Features

* Đăng nhập và kết nối database
* Thêm dữ liệu chi tiêu
* Truy vấn dữ liệu với nhiều điều kiện
* Cập nhật và xóa dữ liệu
* Hỗ trợ tìm kiếm với:

  * Toán tử >, <, = cho số/ngày
  * LIKE cho chuỗi

---

## 🛠 Tech Stack

* PHP (thuần)
* MySQL
* HTML, CSS

---

## 📂 Project Structure

```id="l0nq5w"
ExCSS/        # CSS styles
ExFunct/      # Logic xử lý (class, database, function)
picture/      # Hình ảnh giao diện

login.php     # Đăng nhập & kết nối DB
query.php     # Thêm & truy vấn dữ liệu
alter.php     # Update & delete dữ liệu
table.sql     # Database schema
```

---

## ⚙️ How It Works

1. Người dùng đăng nhập tại `login.php`
2. Sau khi đăng nhập:

   * Thêm hoặc truy vấn dữ liệu tại `query.php`
3. Kết quả truy vấn được chuyển sang `alter.php`
4. Tại đây người dùng có thể:

   * Cập nhật dữ liệu
   * Xóa dữ liệu

---

## 🗄 Database

* File: `table.sql`
* Bao gồm các bảng quản lý chi tiêu

---

## 🔧 Core Components

### 📁 ExFunct

* `class.php`: định nghĩa các model (Table, attributes…)
* `connection.php`: xử lý CRUD với database
* `function.php`: render form và dữ liệu
* `var.inc`: cấu hình kết nối DB

### 📁 ExCSS

* format.css: layout
* frame.css: khung hiển thị
* hover.css: hiệu ứng
* proImg.css: ảnh nền
* text.css: style text

---

## 📌 Notes

* ID được tự động tăng khi thêm dữ liệu
* Hệ thống xử lý lỗi và hiển thị thông báo khi thao tác thất bại

---

## 🎯 Purpose

Dự án được xây dựng nhằm thực hành:

* Lập trình PHP
* Làm việc với MySQL
* Xây dựng hệ thống CRUD

---

## 👨‍💻 Author

Nguyễn Hoàng Phúc
