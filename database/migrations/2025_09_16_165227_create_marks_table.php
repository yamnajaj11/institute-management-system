<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade'); // ربط الطالب
            $table->foreignId('test_id')->constrained()->onDelete('cascade'); // ربط الاختبار
            $table->decimal('mark', 5, 2); // العلامة
            $table->boolean('is_final_exam')->default(false); // حقل إضافي للعلامات النهائية

            $table->timestamps();

            // ضمان عدم تكرار العلامة لنفس الطالب في نفس الاختبار
            $table->unique(['student_id', 'test_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('marks');
    }
};
