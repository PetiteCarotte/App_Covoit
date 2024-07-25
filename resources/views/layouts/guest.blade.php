<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Blabladef</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

     
</head>

<body class="font-sans text-gray-900 antialiased bg-gray-100 light:bg-gray-900">
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-10 bg-gray-100 light:bg-gray-900 -mt-8 pb-8">
        <div>
            <a href="/">
                <img src="{{ asset('images/blabladef-color.png') }}" alt="Application Logo" style="height:12rem;width:12rem; ">
            </a>
        </div>

        <div class="w-full sm:max-w-md px-6 py-4 bg-white light:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>


    </div>
</body>

</html>