<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>GaSystem</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles

    </head>
    <body>
        <div class="h-screen w-3/4 mx-auto flex flex-row justify-around items-center">
            <div class="w-2/4 flex flex-col items-center">
                <div class="w-5/6">
                    <img src="{{ asset('img/sena.png') }}" alt="Sena Logo" class="w-2/4 drop-shadow-2xl mx-auto">
                    <h1 class="text-3xl font-bold text-slate-900 mt-4 font-mono">SIGPA - SENA</h1>
                    <p class="mt-4 text-sm">Sistema integrado de gestion y programación de ambientes</p>
                </div>
            </div>
            <div class="w-2/6">
                @if (Route::has('login'))
                    <nav class="-mx-3 flex flex-col items-center">
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                                class="w-full py-4 px-3 text-center bg-green-500 border border-transparent rounded-md font-semibold text-l text-white uppercase tracking-widest hover:bg-green-500 focus:bg-gray-600 active:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
                                Inicio
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="w-full py-4 px-3 text-center bg-green-500 border border-transparent rounded-md font-semibold text-l text-white uppercase tracking-widest hover:bg-green-500 focus:bg-gray-600 active:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
                                Iniciar sesión
                            </a>

                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="mt-3 w-full text-center py-4 px-3 bg-white border border-gray-300 rounded-md font-semibold text-l text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    Registrarse
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </div>

        @livewireScripts
    </body>
</html>
