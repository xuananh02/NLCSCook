<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    {{-- <title>Delicious - Food Blog Template | Home</title> --}}

    <!-- Favicon -->
    <link rel="icon" href="/favicon.ico">

    <!-- Core Stylesheet -->
    <link rel="stylesheet" type="text/css" href="<?php echo asset('style.css'); ?>">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    

    @include('layouts.header')

    <main>
        {{ $slot }}
    </main>


    <!-- ##### All Javascript Files ##### -->
    <!-- jQuery-2.2.4 js -->
    <script src="<?php echo asset('js/jquery/jquery-2.2.4.min.js'); ?>"></script>
    <!-- Popper js -->
    <script src="<?php echo asset('js/bootstrap/popper.min.js'); ?>"></script>
    <!-- Bootstrap js -->
    <script src="<?php echo asset('js/bootstrap/bootstrap.min.js'); ?>"></script>
    <!-- All Plugins js -->
    <script src="<?php echo asset('js/plugins/plugins.js'); ?>"></script>
    <!-- Active js -->
    <script src="<?php echo asset('js/active.js'); ?>"></script>
</body>

</html>
