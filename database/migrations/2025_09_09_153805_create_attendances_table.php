<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            // استخدام unsignedBigInteger لربط المفتاح الخارجي
            $table->unsignedBigInteger('student_id');
            $table->date('date');
            // 'present', 'absent', 'late'
            $table->string('status'); 
            $table->timestamps();

            // إضافة مفتاح خارجي لربط سجل الحضور بجدول الطلاب (users)
            // استخدام `onDelete('cascade')` لحذف سجل الحضور تلقائيًا عند حذف الطالب
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
