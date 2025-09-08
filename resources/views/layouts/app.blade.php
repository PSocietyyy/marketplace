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
        html {
            scroll-behavior: smooth;
        }
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

    <script>
        function scrollSpy() {
            return {
                active: '#home',
                sections: ['#home', '#about', '#contact'],
                init() {
                    const observer = new IntersectionObserver(
                        (entries) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting) {
                                    this.active = `#${entry.target.id}`;
                                }
                            });
                        },
                        {
                            threshold: 0.6 // 60% dari tinggi section terlihat baru dianggap aktif
                        }
                    );

                    this.sections.forEach(id => {
                        const el = document.querySelector(id);
                        if (el) observer.observe(el);
                    });
                }
            }
        }
        </script>

</body>
</html>