<?php

namespace App\Repositories;

use App\Models\Subject;

class SubjectRepository
{
    // جلب كل المواد
    public function all()
    {
        return Subject::orderBy('name')->get();
    }

    // إيجاد مادة بواسطة id أو تفشل برمي Exception
    public function find($id)
    {
        return Subject::findOrFail($id);
    }

    // إنشاء مادة جديدة
    public function create(array $data)
    {
        return Subject::create([
            'name' => $data['name'],
        ]);
    }

    // تحديث مادة موجودة
    public function update($id, array $data)
    {
        $subject = $this->find($id);
        $subject->update([
            'name' => $data['name'],
        ]);
        return $subject;
    }

    // حذف مادة
    public function delete($id)
    {
        $subject = $this->find($id);
        return $subject->delete();
    }
}
