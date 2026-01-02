<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeUserMail;
use App\Mail\VerifyEmailMail;
use Illuminate\Auth\Notifications\VerifyEmail;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $attributes = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $attributes['password'] = Hash::make($attributes['password']);

        $userId = DB::table('users')->insertGetId([
            'name' => $attributes['name'],
            'surname' => $attributes['surname'],
            'phone' => $attributes['phone'],
            'address' => $attributes['address'],
            'email' => $attributes['email'],
            'password' => $attributes['password'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = DB::table('users')->where('id', $userId)->first();

        Mail::to($user->email)->send(new WelcomeUserMail($user));
        Mail::to($user->email)->send(new VerifyEmailMail($user));

        Auth::loginUsingId($userId);

        return redirect('/');
    }
    public function verifyEmail($userId, $token)
    {
        $record = DB::table('email_verifications')
            ->where('user_id', $userId)
            ->where('token', $token)
            ->first();

        if (!$record) {
            return redirect('/')->with('error', 'Невірне або прострочене посилання.');
        }

        DB::table('users')->where('id', $userId)
            ->update(['email_verified_at' => now()]);

        DB::table('email_verifications')->where('id', $record->id)->delete();

        return redirect('/')->with('success', 'Електронна пошта підтверджена!');
    }

}
