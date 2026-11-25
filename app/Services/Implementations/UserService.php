<?php

namespace App\Services\Implementations;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\IdGeneratorService;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Contracts\UserServiceInterface;

class UserService implements UserServiceInterface
{
    public function __construct(
        protected UserRepositoryInterface $repository
    ){}

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function findById(string $id)
    {
        return $this->repository->findById($id);
    }

    public function create(array $data)
    {
        $data['id_user'] = IdGeneratorService::generate('USR');

        $data['password'] = Hash::make($data['password']);

        return $this->repository->create($data);
    }

    public function update(string $id,array $data)
    {
        if(isset($data['password'])){

            $data['password'] = Hash::make($data['password']);

        }

        return $this->repository->update($id,$data);
    }

    public function delete(string $id)
    {
        return $this->repository->delete($id);
    }

    public function login(array $credentials)
    {
        if(Auth::attempt($credentials))
        {
            return Auth::user();
        }

        return null;
    }
}