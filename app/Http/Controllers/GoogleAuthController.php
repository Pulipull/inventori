<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class GoogleAuthController extends Controller
{
    public function redirect(Request $request): RedirectResponse
    {
        $state = Str::random(40);
        $request->session()->put('google_oauth_state', $state);

        $query = http_build_query([
            'client_id' => $this->clientId(),
            'redirect_uri' => route('auth.google.callback'),
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => $state,
            'access_type' => 'online',
            'prompt' => 'select_account',
        ]);

        return redirect()->away('https://accounts.google.com/o/oauth2/v2/auth?'.$query);
    }

    public function callback(Request $request): RedirectResponse
    {
        if ($request->filled('error')) {
            return redirect()->route('login')->withErrors(['email' => 'Login Google dibatalkan.']);
        }

        abort_unless(
            $request->filled('state') && hash_equals((string) $request->session()->pull('google_oauth_state'), (string) $request->state),
            403
        );

        $token = Http::asForm()
            ->post('https://oauth2.googleapis.com/token', [
                'client_id' => $this->clientId(),
                'client_secret' => $this->clientSecret(),
                'code' => $request->string('code'),
                'grant_type' => 'authorization_code',
                'redirect_uri' => route('auth.google.callback'),
            ])
            ->throw()
            ->json();

        $profile = Http::withToken($token['access_token'])
            ->get('https://www.googleapis.com/oauth2/v3/userinfo')
            ->throw()
            ->json();

        if (! ($profile['email_verified'] ?? false)) {
            return redirect()->route('login')->withErrors(['email' => 'Email Google belum terverifikasi.']);
        }

        $user = User::where('google_id', $profile['sub'])
            ->orWhere('email', $profile['email'])
            ->first();

        if ($user) {
            $user->forceFill([
                'google_id' => $profile['sub'],
                'name' => $user->name ?: $profile['name'],
                'avatar' => $profile['picture'] ?? $user->avatar,
                'email_verified_at' => $user->email_verified_at ?? now(),
            ])->save();
        } else {
            $user = User::create([
                'google_id' => $profile['sub'],
                'name' => $profile['name'],
                'email' => $profile['email'],
                'email_verified_at' => now(),
                'avatar' => $profile['picture'] ?? null,
                'password' => Hash::make(Str::random(32)),
                'role' => 'petugas',
            ]);
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    private function clientId(): string
    {
        return $this->requiredConfig('client_id');
    }

    private function clientSecret(): string
    {
        return $this->requiredConfig('client_secret');
    }

    private function requiredConfig(string $key): string
    {
        $value = config("services.google.{$key}");

        if (! is_string($value) || $value === '') {
            throw new RuntimeException("Konfigurasi Google OAuth {$key} belum diisi.");
        }

        return $value;
    }
}
