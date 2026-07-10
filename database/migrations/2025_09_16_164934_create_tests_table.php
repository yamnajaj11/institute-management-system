<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained()->onDelete('cascade'); // ربط الاختبار بالمادة
            $table->string('name'); // مثل "اختبار الفصل الأول" أو "اختبار نهائي"
            $table->date('test_date')->nullable(); // تاريخ الاختبار
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tests');
    }
};
