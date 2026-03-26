<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index() {
        return view('welcome');
    }

    public function registration() {
        return view('user.registration');
    }

    public function authorization() {
        return view('user.authorization');
    }
}
