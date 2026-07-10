<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use App\Interfaces\StudentRepositoryInterface;
use App\Repositories\StudentRepository;
use App\Interfaces\AttendanceRepositoryInterface;
use App\Repositories\AttendanceRepository;
use App\Interfaces\PaymentRepositoryInterface;
use App\Repositories\PaymentRepository;
use App\Interfaces\MarkRepositoryInterface;
use App\Repositories\MarkRepository;
use App\Interfaces\TestRepositoryInterface;
use App\Repositories\TestRepository;
use App\Interfaces\CourseRepositoryInterface;
use App\Repositories\CourseRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // ربط الواجهة بالتطبيق
        $this->app->bind(StudentRepositoryInterface::class, StudentRepository::class);
    
        $this->app->bind(AttendanceRepositoryInterface::class, AttendanceRepository::class);

        // إضافة ربط واجهة الدفعات هنا
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);

        $this->app->bind(MarkRepositoryInterface::class, MarkRepository::class);
        
        // ربط واجهة الدورات هنا
        $this->app->bind(CourseRepositoryInterface::class, CourseRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // تعيين اللغة العربية كلغة افتراضية إذا لم تكن محددة
        if (!Session::has('locale')) {
            App::setLocale('ar');
        } else {
            App::setLocale(Session::get('locale'));
        }
    }
}
