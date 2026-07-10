<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // مفتاح خارجي يربط القسط بجدول الطلاب (users)
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();

            // الأعمدة التي تحدد المبلغ الإجمالي والمبلغ المدفوع
            $table->decimal('total_amount', 15, 2); // المبلغ الإجمالي للقسط
            $table->decimal('paid_amount', 15, 2)->default(0); // المبلغ المدفوع حتى الآن، القيمة الافتراضية 0
            $table->decimal('remaining_amount', 15, 2)->default(0); // تمت إضافته: المبلغ المتبقي

            // حالة القسط: مثلاً 'pending', 'partially_paid', 'paid', 'overdue'
            $table->string('status')->default('pending');

            // تواريخ الدفع والاستحقاق
            $table->date('payment_date');
            $table->date('due_date'); // تمت إضافته: تاريخ استحقاق القسط

            // ملاحظات إضافية، يمكن أن تكون فارغة
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
        
    }
};
