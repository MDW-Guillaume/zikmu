<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $user_info = User::find($user->id);

        if ($user_info) {
            if (isset($user->firstname)) {
                $username = $user_info->firstname . ' ' . $user_info->lastname;
            } else {
                $username = $user_info->username;
            }
        }
        return view('profile.index')->with(['username' => $username]);
    }

    public function show()
    {
        $user = Auth::user();

        $user_info = User::find($user->id);

        if ($user_info) {
            if (isset($user->firstname)) {
                $username = $user_info->firstname . ' ' . $user_info->lastname;
            } else {
                $username = $user_info->username;
            }
        }

        // $registered_date = $user_info
        $formattedDate = Carbon::createFromFormat('Y-m-d H:i:s', $user_info->created_at)->format('d/m/Y');

        return view('profile.show')->with(['username' => $username, 'user' => $user, 'user_regitered' => $formattedDate]);
    }

    /**
     * Display the user's profile form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     *
     * @param  \App\Http\Requests\ProfileUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();

        $user->firstname = $request->input('firstname');

        $user->lastname = $request->input('lastname');

        $request->user()->fill($request->validated());

        $request->user()->save();

        return Redirect::route('profile.show')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
