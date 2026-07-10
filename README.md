
# نظام إدارة معهد

نظام ويب متكامل لإدارة المعاهد التعليمية، تم تطويره باستخدام Laravel بهدف تنظيم وإدارة الطلاب، الدورات، الحضور، الاختبارات، الدرجات، والمدفوعات.

## فكرة المشروع

يساعد النظام المعاهد التعليمية على إدارة العمليات اليومية من خلال لوحة تحكم واحدة، مع تنظيم بيانات الطلاب والدورات والعمليات المالية.

## المميزات

### إدارة الطلاب
- إضافة وتعديل وحذف الطلاب.
- عرض بيانات الطلاب.
- متابعة معلومات الطلاب.

### الإدارة الأكاديمية
- إدارة الدورات.
- إدارة المواد.
- إدارة الشعب.
- تسجيل الحضور والغياب.
- إدارة الاختبارات والدرجات.

### الإدارة المالية
- إدارة الدفعات.
- متابعة الرسوم والمدفوعات.

### خصائص النظام
- نظام تسجيل دخول.
- إدارة المستخدمين والصلاحيات.
- لوحة تحكم.
- واجهة متجاوبة.

## التقنيات المستخدمة

- PHP
- Laravel
- MySQL
- Blade
- Bootstrap
- Livewire
- JavaScript
- HTML
- CSS

## بنية المشروع

تم تطوير المشروع باستخدام:

- MVC Architecture
- Repository Pattern
- Eloquent ORM
- Laravel Migrations

## قاعدة البيانات

تم تصميم قاعدة البيانات باستخدام Laravel Migrations مع إنشاء العلاقات بين الجداول باستخدام المفاتيح الأساسية والخارجية.

## طريقة التشغيل

تحميل المشروع:
git clone https://github.com/USERNAME/institute-management-system.git
 
composer install
cp .env.example .env
php artisan key:generate 
php artisan migrate
php artisan serve 


## Screenshots

### Login Page
![Login](screenshots/login.png)

### Dashboard
![Dashboard](screenshots/dashboard.png)

### Students Management
![Students](screenshots/students.png)

### Courses Management
![Courses](screenshots/courses.png)

### Attendance Management
![Attendance](screenshots/attendance.png)
 