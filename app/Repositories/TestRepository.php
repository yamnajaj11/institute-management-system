<?php

namespace App\Repositories;

use App\Models\Test;

class TestRepository
{
    // جلب جميع الاختبارات مع بيانات المواد وترتيبهم حسب تاريخ الاختبار
    public function all()
    {
        return Test::with('subject')->orderBy('test_date', 'desc')->get();
    }

    // جلب اختبار معين بناءً على الـ ID
    public function find($id)
    {
        return Test::findOrFail($id);
    }

    // إنشاء اختبار جديد
    public function create(array $data)
    {
        return Test::create([
            'subject_id' => $data['subject_id'],
            'name'       => $data['name'],
            'test_date'  => $data['test_date'] ?? null,
        ]);
    }

    // تحديث اختبار موجود
    public function update($id, array $data)
    {
        $test = $this->find($id); // جلب الاختبار
        $test->update([
            'subject_id' => $data['subject_id'],
            'name'       => $data['name'],
            'test_date'  => $data['test_date'] ?? null,
        ]);
        return $test;
    }

    // حذف اختبار معين
    public function delete($id)
    {
        $test = $this->find($id);
        return $test->delete();
    }
}
