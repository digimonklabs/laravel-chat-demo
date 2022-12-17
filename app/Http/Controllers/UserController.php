<?php

namespace App\Http\Controllers;

use App\UseCases\User\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $getUser = $this->user->getUser();
        return response()->json($getUser);
    }
}
