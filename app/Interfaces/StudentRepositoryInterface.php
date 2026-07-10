<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreStudentRequest;
use Illuminate\Http\Request;

interface StudentRepositoryInterface
{
    public function index(): Collection;

    public function store(StoreStudentRequest $request): User;

    public function edit(int $id): ?User;

    public function update(StoreStudentRequest $request, int $id): User;

    public function destroy(int $id): bool;
     public function search(array $filters): Collection;


}   