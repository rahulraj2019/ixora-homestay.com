<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request): RedirectResponse|JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (! Auth::user()->isAdmin()) {
                Auth::logout();

                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'You do not have admin access.',
                    ], 403);
                }

                return back()->withErrors(['email' => 'You do not have admin access.']);
            }

            $redirect = redirect()->intended(route('admin.dashboard'))->getTargetUrl();

            if ($request->expectsJson()) {
                return response()->json([
                    'ok' => true,
                    'redirect' => $redirect,
                    'name' => Auth::user()->name,
                ]);
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Invalid credentials.',
            ], 422);
        }

        return back()->withErrors(['email' => 'Invalid credentials.'])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
