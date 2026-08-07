<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\MakeLoginRequest;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(MakeLoginRequest $request)
    {
        if ($request->attempt()) {
            $user = Auth::user();

            return $user->role === 'admin'
                ? to_route('admin.inicio')
                : to_route('user.inicio');
        }

        return back()->with(['message' => 'Não deu certo!!']);
    }

    public function logout(Request $request)
    {

         Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('login'));
    }
}