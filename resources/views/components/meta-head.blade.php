<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base_url" content="{{ URL::to('/') }}/">
        <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="theme-color" content="#A3031C">

        @vite('resources/js/app.js')
        @stack('styles')