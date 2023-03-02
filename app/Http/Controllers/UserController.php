<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\Crudable;

class UserController extends Controller
{
    use Crudable;

    private $repository;
    private $resource = "User";

    public function __construct(
    UserRepositoryInterface $repository
    )
    {
       $this->repository = $repository;
    }

    public function me(Request $request){
        $user = $request->user();
        return response()->success("User fetched successfully", compact("user"));
    }

}