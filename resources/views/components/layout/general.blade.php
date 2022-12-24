<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $title ?? config('app.name') }}</title>
    <x-meta-head></x-meta-head>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            {{ $slot }}
        </div>
    </div>
</body>

  {{-- footer 
  @include('layout.footer') --}}