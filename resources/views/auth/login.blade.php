<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Akreditasi TI Polinema</title>
    <link href="{{ asset('css/output.css') }}" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white shadow-xl rounded-lg w-full max-w-sm p-8 space-y-6">
            <div class="text-center">
                <img src="{{ asset('images/polinema-logo.png') }}" alt="Logo Polinema" class="w-20 mx-auto mb-4">
                <h1 class="text-3xl font-semibold text-blue-800">Sistem Akreditasi</h1>
                <p class="text-gray-600 text-sm">Jurusan Teknologi Informasi<br>Politeknik Negeri Malang</p>
            </div>

            <form method="POST" action="{{ url('/login') }}">
                @csrf

                @if ($errors->any())
                    <div class="mb-4 text-red-600 text-sm">
                        <strong>{{ $errors->first() }}</strong>
                    </div>
                @endif

                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input id="username" name="username" type="text" required autofocus
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" required
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-700 text-white px-6 py-3 rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                        Login
                    </button>
                </div>
            </form>

            <p class="text-xs text-center text-gray-500 mt-6">© {{ date('Y') }} Jurusan TI - Polinema. All rights
                reserved.</p>
        </div>
    </div>

</body>

</html>
