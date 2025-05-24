<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Akreditasi System</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Wix+Madefor+Text:wght@400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body class="bg-ijobg min-h-screen flex">


    <!-- Left Side - Logo Area -->
    <div class="w-1/2 flex flex-col items-center justify-center text-white px-8 relative bg-cover bg-center"
        style="background-image: url('{{ asset('img/gedung_jti.png') }}');">
        <!-- Layer blur -->
        <div class="absolute inset-0 backdrop-blur-sm bg-ijologin/50"></div>

        <!-- Optional: Lapisan gelap agar teks tetap terbaca -->
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="text-center z-10">
            <img src="{{ asset('img/login_logo.png') }}" alt="Accreditation Logo"
                class="w-36 h-36 mx-auto object-contain mb-8 drop-shadow-2xl hover:scale-105 transition-transform duration-300 ease-in-out">

            <h1 class="text-5xl font-black tracking-wider leading-tight drop-shadow-md text-ijobg">
                ACCREDITATION
            </h1>
        </div>
    </div>

    <!-- Right Side - Login Area -->
    <div class="w-1/2 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-xs">
            <img src="{{ asset('img/p_logo.png') }}" alt="Accreditation Logo" class="w-28 h-28 mx-auto object-contain">

            <div class="text-center mb-6 pt-2">
                <h2 class="text-xl font-bold text-black">
                    Welcome to Accreditation
                </h2>
                <p class="text-base font-semibold text-black">
                    D4-Business Information Systems
                </p>
                <p class="text-base font-semibold text-black">
                    POLINEMA
                </p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Login Form -->
                <form class="space-y-4">
                    <!-- Input Username -->
                    <div>
                        <input type="text" name="username" id="username"
                            class="w-full px-4 py-2.5 rounded-xl border-black shadow-md bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="username" required>
                    </div>

                    <!-- Input Password -->
                    <div class="mb-6">
                        <input type="password" name="password" id="password"
                            class="w-full px-4 py-2.5 rounded-xl border-black shadow-md bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Password" required>
                    </div>

                    <!-- Space between password and buttons -->
                    <div class="pt-2"></div>

                    <!-- Tombol Login -->
                    <div class="mt-4">
                        <button type="submit"
                            class="w-full px-4 py-2.5 rounded-xl shadow-md bg-ijobg text-white font-medium text-center hover:bg-green-700 transition duration-200">
                            Login
                        </button>
                    </div>

                    <div>
                        <a href="{{ route('home') }}">
                            <button type="button"
                                class="w-full px-4 py-2.5 rounded-xl shadow-md bg-ijobg text-white font-medium text-center hover:bg-green-700 transition duration-200">
                                Back To Home page
                            </button>
                        </a>
                    </div>
                </form>

                <div class="mt-10 text-center text-gray-500" style="font-size: 12px;">
                    &copy; Copyright 2025 | The Accreditation Program
                </div>
        </div>
    </div>
</body>

</html>
