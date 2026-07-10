<?php

namespace App\Interfaces;

interface MarkRepositoryInterface
{
    public function all();

    public function getByStudent($studentId);

    public function find($id);

    public function createOrUpdate(array $data, $id = null);
    public function delete($id);

    public function deleteBy(array $conditions);
}
