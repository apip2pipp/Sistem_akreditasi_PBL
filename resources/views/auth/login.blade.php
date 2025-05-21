<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Akreditasi System</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-green-900 min-h-screen flex">

    <!-- Left Side - Logo Area -->
    <div class="w-1/2 flex flex-col items-center justify-center text-white px-8 relative bg-cover bg-center" 
        style="background-image: url('{{ asset('img/gedung_jti.png') }}');">
        <!-- Layer blur -->
        <div class="absolute inset-0 backdrop-blur-sm bg-white/10"></div>
        <!-- Optional: Lapisan gelap agar teks tetap terbaca -->
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="text-center z-10">
            <img src="{{ asset('img/login_logo.png') }}" alt="Accreditation Logo"
                class="w-36 h-36 mx-auto object-contain mb-8 drop-shadow-2xl hover:scale-105 transition-transform duration-300 ease-in-out">

            <h1 class="text-5xl font-black tracking-wider leading-tight drop-shadow-md text-ijologin">
                ACCREDITATION
            </h1>
        </div>
    </div>

    <!-- Right Side - Login Form -->
    <div class="w-1/2 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-md p-10 w-4/5 max-w-md">
            <img src="{{ asset('img/p_logo.png') }}" alt="Accreditation Logo" class="w-32 h-32 mx-auto object-contain">
            
            <div class="text-center mb-8 pt-3">
                <h2 class="text-2xl font-bold text-green-800 drop-shadow-sm leading-snug">
                    Welcome to Accreditation
                </h2>
                <p class="text-lg font-semibold text-green-800 drop-shadow-sm mt-2">
                    D4-Business Information Systems
                </p>
                <p class="text-lg font-semibold text-green-800 drop-shadow-sm mt-1">
                POLINEMA
                </p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                <div class="pt-3">
                    <input type="email" name="email" id="email" 
                        class="w-full px-4 py-3 rounded-xl border-black shadow-md bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-500" 
                        placeholder="Email" required>
                </div>

                <div>
                    <input type="password" name="password" id="password" 
                        class="w-full px-4 py-3 rounded-xl border-black shadow-md bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-500" 
                        placeholder="Password" required>
                </div>

                <div class="mt-2 flex justify-center pt-10">
                    <button type="submit" 
                        class="w-2/3 py-3 rounded-full bg-green-800 text-white font-medium hover:bg-green-700 transition duration-200">
                        Login
                    </button>
                </div>

                <div class="mt-2 flex justify-center">
                    <a href="{{ route('home') }}" 
                        class="block w-2/3 py-3 rounded-full bg-green-800 text-white font-medium hover:bg-green-700 transition duration-200 text-center">
                        Back To Home page
                    </a>
                </div>

            </form>

            <div class="mt-12 text-center text-gray-500 text-sm">
                &copy; Copyright 2025 | The Accreditation Program
            </div>
        </div>
    </div>
</body>
</html>