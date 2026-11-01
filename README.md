# Mobile Store Showcase

وب‌سایت معرفی و کاتالوگ فروشگاه فیزیکی موبایل و لوازم جانبی.

## فناوری‌ها
- PHP 8.1+
- MySQL 8+ یا MariaDB سازگار با InnoDB
- HTML5، CSS3 و Vanilla JavaScript (ES Modules)
- معماری CSS: فایل پایه به‌همراه فایل‌های مستقل Mobile / Tablet / Desktop

## محدوده محصول
این پروژه ویترین و کاتالوگ فروشگاه فیزیکی است؛ سبد خرید، پرداخت، ثبت سفارش، حساب مشتری یا انبارداری آنلاین در محدوده فعلی نیست. پنل مدیریت برای مدیریت محتوای ویترین توسعه داده می‌شود.

## معماری بک‌اند
- `app/Core`: زیرساخت‌هایی مانند PDO و پاسخ HTTP.
- `app/Repositories`: دسترسی به داده و SQL؛ هیچ View نباید مستقیماً SQL اجرا کند.
- `app/Services`: منطق کاربردی و هماهنگی Repositoryها.
- `app/Middleware`: کنترل دسترسی و CSRF.
- `database/schema.sql`: ساختار پایه جداول.
- `database/migrate.php`: اجرای migration پایه و ثبت checksum.
- `database/create_admin.php`: ساخت حساب مدیر از CLI؛ فقط hash رمز در دیتابیس ذخیره می‌شود.

## راه‌اندازی دیتابیس

1. PHP 8.1+ و افزونه‌های `pdo_mysql` و `mbstring` را فعال کن.
2. فایل `.env.example` را به `.env` کپی و مقادیر DB را تنظیم کن. رمز واقعی را در Git قرار نده.
3. از ریشه پروژه migration را اجرا کن:

```bash
php database/migrate.php
```

این دستور دیتابیس تعریف‌شده در `DB_NAME` را در صورت نیاز ایجاد می‌کند، جدول‌ها را می‌سازد و اجرای migration را ثبت می‌کند. کاربر MySQL باید مجوز CREATE DATABASE و CREATE/ALTER TABLE داشته باشد. اجرای مجدد، در صورت عدم تغییر checksum، بدون ایجاد مجدد جداول خاتمه می‌یابد.

## ساخت اولین مدیر

متغیرهای زیر را فقط در محیط shell تنظیم کن و سپس دستور CLI را اجرا کن. رمز را در کد یا فایل‌های commit‌شده قرار نده:

```bash
export ADMIN_NAME="Store Admin"
export ADMIN_EMAIL="admin@example.com"
export ADMIN_PASSWORD="use-a-unique-password-at-least-12-characters"
php database/create_admin.php
unset ADMIN_NAME ADMIN_EMAIL ADMIN_PASSWORD
```

برای محیط production از secret manager یا روش امن مدیریت متغیرهای محیطی هاست استفاده کن. این اسکریپت از طریق HTTP اجرا نمی‌شود.

## اجرای محلی

```bash
php -S localhost:8000
```

سپس `http://localhost:8000` را باز کن. برای Apache، ماژول `mod_rewrite` باید فعال باشد. پوشه `database/` و فایل‌های پیکربندی از طریق `.htaccess` مسدود شده‌اند.

## قراردادهای معماری
- View فقط داده را نمایش می‌دهد و نباید به PDO یا SQL وابسته شود.
- Queryها در Repository و منطق کاربردی در Service قرار می‌گیرند.
- تمام مقادیر ورودی SQL با Prepared Statements ارسال می‌شوند.
- اطلاعات اتصال و secretها در متغیر محیطی نگهداری می‌شوند و وارد Git نمی‌شوند.
- فایل‌های آپلودی باید از نظر MIME، پسوند و اندازه اعتبارسنجی شوند و اجرای اسکریپت در مسیر آپلود ممنوع باشد.

## وضعیت
زیرساخت دیتابیس و Repositoryهای پایه پیاده‌سازی شده‌اند. اتصال عملی به MySQL، اجرای migration و تست CRUD باید در محیط دارای PHP/MySQL انجام شود؛ در این محیط تست runtime دیتابیس انجام نشده است.
