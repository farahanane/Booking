<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $user = Socialite::driver('google')->user();

            \Log::info('Google Callback Data', ['user' => $user]);

            $existingUser = User::where('email', $user->email)->first();

            if ($existingUser) {
                Auth::login($existingUser, true);
            } else {
                // Ensure avatar is stored in storage/avatars/
                $avatarPath = $user->avatar ? 'avatars/' . md5($user->email) . '.jpg' : null;
                if ($avatarPath && $user->avatar) {
                    file_put_contents(storage_path('app/public/' . $avatarPath), file_get_contents($user->avatar));
                }

                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => Hash::make('default_password'),
                    'provider' => 'google',
                    'provider_id' => $user->id,
                    'avatar' => $avatarPath,
                    'role' => 'client',
                ]);

                Auth::login($newUser, true);
            }

            \Log::info('User logged in via Google', ['user_id' => Auth::id(), 'email' => $user->email]);

            return Auth::user()->email === 'admin@gmail.com'
                ? redirect()->route('auth.dashboard')
                : redirect()->route('listings.index');

        } catch (Exception $e) {
            \Log::error('Google login failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect('/login')->withErrors(['email' => 'Unable to login with Google. Try again later. Error: ' . $e->getMessage()]);
        }
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback(Request $request)
    {
        try {
            $user = Socialite::driver('facebook')->user();

            \Log::info('Facebook Callback Data', ['user' => $user]);

            $existingUser = User::where('email', $user->email)->first();

            if ($existingUser) {
                Auth::login($existingUser, true);
            } else {
                // Ensure avatar is stored in storage/avatars/
                $avatarPath = $user->avatar ? 'avatars/' . md5($user->email) . '.jpg' : null;
                if ($avatarPath && $user->avatar) {
                    file_put_contents(storage_path('app/public/' . $avatarPath), file_get_contents($user->avatar));
                }

                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => Hash::make('default_password'),
                    'provider' => 'facebook',
                    'provider_id' => $user->id,
                    'avatar' => $avatarPath,
                    'role' => 'client',
                ]);

                Auth::login($newUser, true);
            }

            \Log::info('User logged in via Facebook', ['user_id' => Auth::id(), 'email' => $user->email]);

            return Auth::user()->email === 'admin@gmail.com'
                ? redirect()->route('auth.dashboard')
                : redirect()->route('listings.index');

        } catch (Exception $e) {
            \Log::error('Facebook login failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect('/login')->withErrors(['email' => 'Unable to login with Facebook. Try again later. Error: ' . $e->getMessage()]);
        }
    }
}