<?php

namespace App\Services\Contracts;

interface UserServiceInterface
{
    public function create(array $data);

    public function update(string $id,array $data);

    public function delete(string $id);

    public function getAll();

    public function findById(string $id);

    public function login(array $credentials);
}