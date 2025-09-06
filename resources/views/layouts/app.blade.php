<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? env("APP_NAME") }}</title>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link
        href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
        rel="stylesheet"
    />
    <style>
        @keyframes progress {
            from {
                width: 100%;
            }
            to {
                width: 0%;
            }
        }

        .animate-progress {
            animation: progress 5s linear forwards;
        }
    </style>
</head>
<body class="min-w-full min-h-screen">
    <x-alert />
    {{ $slot }}
    @livewireScripts
</body>
</html>