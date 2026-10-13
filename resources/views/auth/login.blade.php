<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'My Business') }} - Sign In</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS CDN (Ensures immediate gorgeous styling out of the box) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0f7ff',
                            100: '#e0effe',
                            200: '#bae0fd',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .bg-mesh {
            background-color: #0b0f19;
            background-image:
                radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.22) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(99, 102, 241, 0.2) 0px, transparent 50%),
                radial-gradient(at 50% 100%, rgba(14, 165, 233, 0.15) 0px, transparent 50%);
        }

        .glass-card {
            background: rgba(17, 24, 39, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
    </style>
</head>

<body
    class="bg-mesh min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8 font-sans antialiased text-slate-100 selection:bg-blue-500 selection:text-white">

    <div class="w-full max-w-md">
        <!-- Logo / Brand Header -->
        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-500 shadow-lg shadow-blue-500/30 ring-1 ring-white/20 mb-4 transition-transform hover:scale-105 duration-200">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">
                Welcome back
            </h1>
            <p class="text-sm text-slate-400 mt-1">
                Enter your credentials to access your account
            </p>
        </div>

        <!-- Main Card -->
        <div class="glass-card rounded-2xl p-6 sm:p-8 shadow-2xl shadow-black/50">

            <!-- Session Status Alert (e.g. Password Reset confirmation) -->
            @if (session('status'))
                <div
                    class="mb-5 p-3.5 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs sm:text-sm flex items-center gap-2.5">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Validation Errors Banner -->
            @if ($errors->any())
                <div
                    class="mb-5 p-3.5 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-xs sm:text-sm">
                    <div class="flex items-center gap-2 font-medium mb-1">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Please check your inputs
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 text-xs text-rose-300/90 pl-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5" id="loginForm">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email"
                        class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                        Email address
                    </label>
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" autofocus
                            autocomplete="username" placeholder="name@company.com"
                            class="w-full pl-11 pr-4 py-2.5 rounded-xl bg-slate-800/80 border {{ $errors->has('email') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-700/80 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20' }} text-slate-100 placeholder-slate-500 text-sm transition-all duration-200 outline-none" />
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password"
                            class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                            Password
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-xs text-blue-400 hover:text-blue-300 font-medium transition-colors">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input id="password" type="password" name="password" autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full pl-11 pr-11 py-2.5 rounded-xl bg-slate-800/80 border {{ $errors->has('password') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-700/80 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20' }} text-slate-100 placeholder-slate-500 text-sm transition-all duration-200 outline-none" />
                        <!-- Password Visibility Toggle -->
                        <button type="button" onclick="togglePasswordVisibility()"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-200 transition-colors focus:outline-none"
                            title="Toggle password visibility">
                            <!-- Eye icon (shown when hidden) -->
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <!-- Eye slash icon (shown when visible) -->
                            <svg id="eyeSlashIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me Checkbox -->
                <div class="flex items-center">
                    <label class="relative flex items-center gap-3 cursor-pointer select-none">
                        <input type="checkbox" name="remember" id="remember_me"
                            class="w-4 h-4 rounded border-slate-700 bg-slate-800 text-blue-600 focus:ring-blue-500/20 focus:ring-offset-0 focus:ring-2 cursor-pointer transition-colors" />
                        <span class="text-xs sm:text-sm text-slate-400 hover:text-slate-300 transition-colors">
                            Remember this device
                        </span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="submitBtn"
                    class="w-full relative py-2.5 px-4 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-medium text-sm shadow-lg shadow-blue-600/30 transition-all duration-200 hover:shadow-blue-500/40 active:scale-[0.99] flex items-center justify-center gap-2 group">
                    <span id="btnText">Sign In</span>
                    <svg id="btnArrow" class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                    <!-- Spinner (hidden by default) -->
                    <svg id="btnSpinner" class="w-4 h-4 animate-spin hidden text-white" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                </button>
            </form>
        </div>

        <!-- Registration Link / Footer -->
        {{-- @if (Route::has('register'))
            <p class="text-center text-xs sm:text-sm text-slate-400 mt-6">
                Don't have an account?
                <a href="{{ route('register') }}"
                    class="text-blue-400 hover:text-blue-300 font-semibold transition-colors underline-offset-4 hover:underline">
                    Create account
                </a>
            </p>
        @endif --}}

        <!-- Footer Copyright -->
        <p class="text-center text-xs text-slate-600 mt-8">
            &copy; {{ date('Y') }} {{ config('app.name', 'My Business') }}. All rights reserved.
        </p>
    </div>

    <!-- Interactive Script -->
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeSlashIcon = document.getElementById('eyeSlashIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        }

        // Show loading spinner on submit to enhance UX
        document.getElementById('loginForm')?.addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnArrow = document.getElementById('btnArrow');
            const btnSpinner = document.getElementById('btnSpinner');

            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-80', 'cursor-not-allowed');
            btnText.textContent = 'Signing in...';
            btnArrow.classList.add('hidden');
            btnSpinner.classList.remove('hidden');
        });
    </script>
</body>

</html>
