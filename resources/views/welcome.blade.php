<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Basketball League') }}</title>

        @fonts

            @vite(['resources/css/app.css', 'resources/js/app.js'])
       
    </head>
    <body class="antialiased bg-gray-100 text-gray-900">
        
        <div class="min-h-screen flex flex-col items-center justify-center p-4">
            <div class="bg-white p-8 rounded-2xl shadow border border-gray-200 max-w-md w-full text-center ">
                
                <x-application-logo class="w-25 h-25 mb-8 fill-current text-gray-600 mx-auto" />

                <h1 class="text-3xl font-black text-gray-900 mb-2 tracking-tight">
                    {{ __('Basketball League System') }}
                </h1>
                
                <p class="text-gray-500 font-medium mb-8">
                    {{ __('Login to see all the content!') }}
                </p>

                @if (Route::has('login'))
                    <div class="flex flex-col gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" 
                               class="w-full inline-flex justify-center items-center py-3 px-6 text-white bg-gray-900 hover:bg-gray-800 font-bold rounded-xl shadow transition">
                               {{ __('Go to Dashboard') }}
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                               class="w-full py-3 px-6 text-white bg-blue-500 hover:bg-blue-700 font-bold rounded-xl shadow transition">
                                {{ __('Log In') }}
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" 
                                   class="w-full py-3 px-6 text-gray-700 bg-gray-200 hover:bg-gray-300 font-semibold rounded-xl transition">
                                    {{ __('Register') }}
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif

            </div>
        </div>

    </body>
</html>