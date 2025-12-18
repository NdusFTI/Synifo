<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login() {
        return view("login.index");
    }

    public function loginPost(Request $request) {
        $email = $request->input("email");
        $password = $request->input("password");

        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect("login")->with("alert", "Email atau password salah");
        } else {
            return redirect("home")->with("alert", "Login berhasil");
        }
    }

    public function logout(){
        Auth::logout();
        return redirect("login")->with("alert", "Anda telah logout");
    }

    public function changePassword() {
        return view("auth.change_password");
    }

    public function changePasswordPost(Request $request) {
        $user = Auth::user();

        if (!Auth::attempt(['email' => $user->email, 'password' => $request->current_password])) {
            return redirect("change.password")->with("alert", "Password saat ini salah");
        }

        $user->update([
            'password' => bcrypt($request->new_password)
        ]);

        return redirect("home")->with("alert", "Password berhasil diubah");
    }
}
