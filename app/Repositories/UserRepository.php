<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function generateToken($user){
        $device_name="Default";
        return $user->createToken($device_name)->plainTextToken;
    }

    public function store(array $data){
        $data['password']=Hash::make($data['password']);
        return $this->model->create($data);
    }

    public function update($id, array $data=[]){
        $user = $this->findOrFail($id);
        $data['password']=Hash::make($data['password']);
        $user->fill($data);
        $user->save();
        return $user;
    }
    

    public function storeValidation(array $data){
        return Validator::make($data, [
            'name'      => 'required|min:3|max:100',
            'email'     => 'required|email|max:255|unique:users',
            'password'  => 'required|min:6',
        ]);
    }
    public function updateValidation(array $data){
        return Validator::make($data, [
            'name'      => 'required|min:3|max:100',
            'password'  => 'required|min:6',
        ]);
    }

    public function signinValidation(array $data){
        return Validator::make($data, [
            'email'     => 'required|email',
            'password'  => 'required',
        ]);
    }

}
