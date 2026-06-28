<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? 'Task Manager' }}</title>
        <link rel="icon" href="{{ asset('assets/identidade-visualpack/favicon.svg') }}" type="image/svg+xml">
        <link rel="icon" href="{{ asset('assets/identidade-visualpack/favicon-32x32.png') }}" sizes="32x32" type="image/png">
        <link rel="apple-touch-icon" href="{{ asset('assets/identidade-visualpack/apple-touch-icon.png') }}">
        
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        
        <!-- Custom Stylesheet -->
        <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
        
        <!-- Script Configuration & Core Libraries -->
        <script data-navigate-once>
            window.TasklyI18n = {
                attention: @json(__('Atenção')),
                confirm: @json(__('Sim, confirmar!')),
                cancel: @json(__('Cancelar')),
            };
        </script>
        <script src="{{ asset('js/layout.js') }}" data-navigate-once></script>
        <script src="https://cdn.tailwindcss.com" data-navigate-once></script>
        <script src="https://unpkg.com/lucide@latest" data-navigate-once></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" data-navigate-once></script>
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js" data-navigate-once></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js" data-navigate-once></script>
        @livewireStyles
        <script>
            // Apply theme configuration as early as possible to prevent flashing
            (function() {
                const theme = localStorage.getItem('theme') || 'dark';
                if (theme === 'light') {
                    document.documentElement.classList.add('theme-light');
                }
            })();
        </script>
    </head>
    <body class="bg-slate-900 text-slate-100 antialiased overflow-hidden">
        <script>
            // Also apply to body immediately when it starts rendering
            if (localStorage.getItem('theme') === 'light') {
                document.body.classList.add('theme-light');
            }
        </script>
        {{ $slot }}

        <!-- Theme Switcher floating button -->
        <div class="fixed bottom-4 right-4 z-[9999] sm:bottom-6 sm:right-6" x-data="{
            theme: localStorage.getItem('theme') || 'dark',
            toggle() {
                this.theme = this.theme === 'dark' ? 'light' : 'dark';
                localStorage.setItem('theme', this.theme);
                if (this.theme === 'light') {
                    document.documentElement.classList.add('theme-light');
                    document.body.classList.add('theme-light');
                } else {
                    document.documentElement.classList.remove('theme-light');
                    document.body.classList.remove('theme-light');
                }
                // If on dashboard, force re-initialization of charts to redraw texts with new colors
                if (typeof window.Livewire !== 'undefined') {
                    // Small delay to let class list update
                    setTimeout(() => {
                        const dashboardEl = document.querySelector('[x-data*=\'initChart\']');
                        if (dashboardEl && dashboardEl.__x) {
                            // Find the initChart method if available and call it
                            const xData = dashboardEl.__x.$data;
                            if (xData && typeof xData.initChart === 'function' && xData.view === 'pie') {
                                xData.initChart();
                            }
                        }
                    }, 50);
                }
            }
        }">
            <button @click="toggle()" 
                    title="{{ __('Alternar Tema') }}"
                    class="w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-slate-800 border border-slate-700 shadow-2xl backdrop-blur-md flex items-center justify-center hover:scale-110 active:scale-95 transition-all duration-300 group">
                <span x-show="theme === 'dark'">
                    <i data-lucide="sun" class="w-5 h-5 text-amber-400"></i>
                </span>
                <span x-show="theme === 'light'" style="display: none;">
                    <i data-lucide="moon" class="w-5 h-5 text-indigo-600"></i>
                </span>
            </button>
        </div>

        @livewireScripts
        <script src="{{ asset('js/board.js') }}" data-navigate-once></script>
    </body>
</html>
