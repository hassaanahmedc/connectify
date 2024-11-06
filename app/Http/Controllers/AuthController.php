<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rules\Password;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function RegisterUser(Request $request)
    {
        $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('login');
    }

    public function Login(LoginRequest $request)
    {
        $validated = $request->validated();

        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {

            $request->session()->regenerate();

            return redirect()->route('home'); 

        }

        return  back()->withError(['error' => 'The provided credentials are incorrect'])->onlyInput('error');

    }

    public function Logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect()->route('login');
    }

}
