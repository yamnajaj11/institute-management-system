<?php

namespace App\Repositories;

use App\Models\Mark;
use App\Models\Test;
use App\Models\User;

class MarkRepository implements \App\Interfaces\MarkRepositoryInterface
{
    // جلب جميع العلامات مع الطلاب والاختبارات
      public function all()
    {
        return Mark::with(['student', 'test.subject'])->get();
    }
    // جلب العلامات الخاصة بطالب معين مع بيانات الاختبارات
    public function getByStudent($studentId)
    {
        return Mark::with('test') // تحميل بيانات الاختبار المرتبطة
                    ->where('student_id', $studentId)
                    ->get();
    }

    // جلب علامة معينة بناءً على الـ ID
    public function find($id)
    {
        return Mark::findOrFail($id);
    }

    // إنشاء أو تحديث علامة
     public function createOrUpdate(array $data, $id = null)
    {
        // التحقق من أن الطالب والاختبار موجودين في قاعدة البيانات
        $student = User::findOrFail($data['student_id']);
        $test = Test::findOrFail($data['test_id']);

        // إنشاء أو تحديث العلامة
        return Mark::updateOrCreate(
            ['student_id' => $data['student_id'], 'test_id' => $data['test_id']],
            ['mark' => $data['mark']]
        );
    }

    // حذف علامة معينة
    public function delete($id)
    {
        $mark = $this->find($id);
        return $mark->delete();
    }
     public function deleteBy(array $conditions)
    {
        return Mark::where($conditions)->delete();
    }
}
