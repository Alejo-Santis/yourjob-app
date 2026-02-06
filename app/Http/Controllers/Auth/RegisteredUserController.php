<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\JobSeekerProfile;
use App\Models\EmployerProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'user_type' => 'required|in:job_seeker,employer',
        ]);

        $user = User::create([
            'id' => Str::uuid(),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
        ]);

        // Create corresponding profile
        if ($user->user_type === 'job_seeker') {
            JobSeekerProfile::create([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'profile_completion_percentage' => 0,
            ]);
        } else if ($user->user_type === 'employer') {
            EmployerProfile::create([
                'id' => Str::uuid(),
                'user_id' => $user->id,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        // Redirect based on user type
        return match($user->user_type) {
            'job_seeker' => redirect('/job-seeker/profile/edit')->with('success', 'Welcome! Please complete your profile.'),
            'employer' => redirect('/employer/profile/edit')->with('success', 'Welcome! Please complete your company profile.'),
            default => redirect('/'),
        };
    }
}
