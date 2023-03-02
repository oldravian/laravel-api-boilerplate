<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private $repository;

    public function __construct(
    UserRepositoryInterface $repository
    )
    {
       $this->repository = $repository;
    }

    public function signup(Request $request){
        $data = $request->input();

        try{
            $this->repository->storeValidation($data)->validate();
            $user = $this->repository->store($data);
            return $this->authenticated($user);
        }
        catch(\Exception $e){
            return $this->handleException($e);
        }
    }

    public function signin(Request $request){
        try{
            $this->repository->signinValidation($request->input())->validate();

            $user = $this->repository->findByQuery(['email'=>$request->email]);

            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            return $this->authenticated($user);
        }
        catch(\Exception $e){
            return $this->handleException($e);
        }
    }

    public function authenticated($user){
        $token = $this->repository->generateToken($user);
        return response()->success("User authenticated successfully", compact("user","token"));
    }

    public function logout(Request $request){
        // Revoke the token that was used to authenticate the current request...
        $request->user()->currentAccessToken()->delete();
        return response()->success("User logged out successfully");
    }

}