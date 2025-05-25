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

            <!-- Unsuccess Notification -->
            {{-- @if($errors->any())
            <div id="error-notification" class="mb-4 px-3 py-2 bg-red-100 border border-red-300 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm text-red-700 font-medium">
                        The username or password you entered is incorrect
                    </span>
                </div>
            </div>
            @endif --}}

            <form id="login-form" class="space-y-6">
                @csrf

                <div>
                    <input type="text" name="username" id="username"
                        class="w-full px-4 py-3 rounded-md bg-green-100/40 focus:outline-none focus:ring-2 focus:ring-green-500"
                        placeholder="username" required>
                </div>

                <div>
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-3 rounded-md bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-500"
                        placeholder="Password" required>
                </div>

                <div>
                    <button type="submit"
                        class="w-full py-3 rounded-md bg-ijobg text-white font-medium hover:bg-green-700 transition duration-200">
                        Login
                    </button>
                </div>

                <div>
                    <a href="{{ route('home') }}"
                        class="block w-full py-3 rounded-md bg-ijobg text-white font-medium hover:bg-green-700 transition duration-200 text-center">
                        Back To Home page
                    </a>
                </div>
            </form>

                <div class="mt-10 text-center text-gray-500" style="font-size: 12px;">
                    &copy; Copyright 2025 | The Accreditation Program
                </div>
        </div>
    </div>


    {{-- script --}}
    <script>
        document.getElementById('login-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);
            const token = document.querySelector('input[name="_token"]').value;

            // Hapus pesan sebelumnya
            document.getElementById('feedback')?.remove();

            const response = await fetch("{{ route('login') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();

            const feedback = document.createElement('div');
            feedback.id = 'feedback';
            feedback.className = 'mt-4 px-4 py-3 rounded relative text-sm text-center';

            if (data.status === 'success') {
                feedback.classList.add('bg-green-100', 'text-green-700', 'border', 'border-green-400');
                feedback.textContent = data.message;
                form.before(feedback);

                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 2000);
            } else {
                feedback.classList.add('bg-red-100', 'text-red-700', 'border', 'border-red-400');
                feedback.textContent = data.message;
                form.before(feedback);
            }
        });
    </script>
</body>

</html>
