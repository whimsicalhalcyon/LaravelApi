<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function reg(Request $request) {
        $request->validate([
            'fullname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ],
        [
            'required' => 'Поле обязательно для заполнения',
        ]);

        $user = new User();
        $user->fullname = $request->input('fullname');
        $user->login = $request->input('login');
        $user->email = $request->input('email');
        $user->password = $request->has('password') ? Hash::make($request->input('password')) : '';

        $user->save();
        return redirect()->route('welcome');

    }

    public function auth(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::query()
            ->where('email', $request->input('email'))
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route('welcome');
        } else {
            return redirect()->back()->with('error', 'Неправильный логин и пароль');
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('user.authorization');
    }
}
