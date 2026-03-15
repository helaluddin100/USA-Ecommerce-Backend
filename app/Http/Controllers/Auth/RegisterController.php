<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            // Company Information
            'company_name' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'phone_no' => ['nullable', 'string', 'max:50'],
            'fax_no' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'string', 'max:20'],

            // Contact Information
            'contact_name' => ['required', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],

            // Authentication
            'username' => ['required', 'string', 'min:5', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],

            // Business Information
            'type_of_business' => ['nullable', 'in:retailer,wholesaler,online_shop,offline_shop,network_sales,sns_sales'],
            'registration_path' => ['nullable', 'in:stylekorean,google,instagram_facebook,tiktok,recommendation,others'],
            'interesting_business' => ['nullable', 'array'],
            'interesting_business.*' => ['in:kpop,kbeauty'],
            'introduce' => ['nullable', 'string', 'max:1000'],

            // NDA Agreement
            'nda_agreement' => ['required', 'accepted'],
        ]);

        // Create user with default role 'user' and pending approval
        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user', // Default role
            'company_name' => $validated['company_name'],
            'country' => $validated['country'],
            'website_url' => $validated['website_url'] ?? null,
            'phone_no' => $validated['phone_no'] ?? null,
            'fax_no' => $validated['fax_no'] ?? null,
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'],
            'state' => $validated['state'],
            'zip' => $validated['zip'],
            'contact_name' => $validated['contact_name'],
            'position' => $validated['position'] ?? null,
            'type_of_business' => $validated['type_of_business'] ?? null,
            'registration_path' => $validated['registration_path'] ?? null,
            'interesting_business' => $validated['interesting_business'] ?? null,
            'introduce' => $validated['introduce'] ?? null,
            'nda_agreement' => true,
            'nda_agreed_at' => now(),
            'is_active' => false, // Inactive until approved by sales team
        ]);

        // Redirect with success message
        return redirect()->route('register.success')
            ->with('success', 'Registration successful! Please wait for our sales team to approve your account. You will receive an email confirmation within 5 working days.');
    }
}

