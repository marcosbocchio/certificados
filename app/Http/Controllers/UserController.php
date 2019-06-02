<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\User\UserRepository;

class UserController extends Controller
{
    Protected $users;

    public function __construct(UserRepository $userRepository)
    {
      $this->users = $userRepository;
    }

    public function index()
    {
      return $this->users->getAll();
    }
}
