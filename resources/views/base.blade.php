@props(['livewire'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ __('filament-panels::layout.direction') ?? 'ltr' }}"
    @class(['fi min-h-screen', 'dark' => filament()->hasDarkModeForced()])>

<head>
    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::head.start') }}

    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    @if ($favicon = filament()->getFavicon())
        <link rel="icon" href="{{ $favicon }}" />
    @endif

    <title>
        {{ filled($title = $livewire->getTitle()) ? "{$title} - " : null }}
        {{ filament()->getBrandName() }}
    </title>

    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::styles.before') }}

    <style>
        [x-cloak=''],
        [x-cloak='x-cloak'],
        [x-cloak='1'] {
            display: none !important;
        }

        @media (max-width: 1023px) {
            [x-cloak='-lg'] {
                display: none !important;
            }
        }

        @media (min-width: 1024px) {
            [x-cloak='lg'] {
                display: none !important;
            }
        }
    </style>

    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef" />
    <link rel="apple-touch-icon" href="{{ asset('logo.PNG') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">


    @filamentStyles
    {{ filament()->getTheme()->getHtml() }}
    {{ filament()->getFontHtml() }}

    <style>
        :root {
            --font-family: {!! filament()->getFontFamily() !!};
            --sidebar-width: {{ filament()->getSidebarWidth() }};
            --collapsed-sidebar-width: {{ filament()->getCollapsedSidebarWidth() }};
        }
    </style>

    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::styles.after') }}

    @if (!filament()->hasDarkMode())
        <script>
            localStorage.setItem('theme', 'light')
        </script>
    @elseif (filament()->hasDarkModeForced())
        <script>
            localStorage.setItem('theme', 'dark')
        </script>
    @else
        <script>
            const theme = localStorage.getItem('theme') ?? 'system'

            if (
                theme === 'dark' ||
                (theme === 'system' &&
                    window.matchMedia('(prefers-color-scheme: dark)')
                    .matches)
            ) {
                document.documentElement.classList.add('dark')
            }
        </script>
    @endif

    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::head.end') }}
</head>

<body class="min-h-screen bg-gray-50 font-normal text-gray-950 antialiased dark:bg-gray-950 dark:text-white">
    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::body.start') }}

    {{ $slot }}

    @livewire(Filament\Livewire\Notifications::class)

    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::scripts.before') }}

    @filamentScripts(withCore: true)

    @if (config('filament.broadcasting.echo'))
        <script>
            window.addEventListener('DOMContentLoaded'
                {{-- 'livewire:navigated' --}}, () => {
                    window.Echo = new window.EchoFactory(@js(config('filament.broadcasting.echo')))

                    window.dispatchEvent(new CustomEvent('EchoLoaded'))
                })
        </script>
    @endif

    @stack('scripts')

    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::scripts.after') }}

    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::body.end') }}
</body>

<script src="{{ asset('/sw.js') }}"></script>
<script>
    if ("serviceWorker" in navigator) {
        // Register a service worker hosted at the root of the
        // site using the default scope.
        navigator.serviceWorker.register("/sw.js").then(
            (registration) => {
                console.log("Service worker registration succeeded:", registration);
            },
            (error) => {
                console.error(`Service worker registration failed: ${error}`);
            },
        );
    } else {
        console.error("Service workers are not supported.");
    }
</script>

</html>
