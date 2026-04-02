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

    public function reply() {
        return view('emails.reply');
    }

    public function cors() {
        return view('cors');
    }

    public function widget_contact() {
        return view('widgets.contact');
    }

    public function iframe_demo() {
        return view('widgets.iframe_demo');
    }
}
