<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    public function show(): View
    {
        $user = Auth::user();
        $orders = $user->orders()->with('orderItems.watcher')->latest()->get();
        $cart = session()->get('cart', []);

        return view('profile.profile', compact('user', 'orders', 'cart'));
    }


    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();

        $user->fill($request->validated());

        $user->save();

        return redirect()->route('profile.profile')->with('success', 'Дані успішно оновлено');
    }

}
