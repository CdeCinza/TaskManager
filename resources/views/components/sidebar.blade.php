@props([
    'activePage' => '',
    'userBoards' => collect(),
    'currentBoardId' => null,
])

@php
    $subtitleMap = [
        'dashboard' => __('Painel de Controle'),
        'calendar' => __('Agenda'),
        'kanban' => 'Kanban Board',
        'tickets' => __('Chamados'),
        'reports' => __('Painel de Controle'),
    ];
    $subtitle = $subtitleMap[$activePage] ?? __('Painel de Controle');

    $navItems = [
        ['route' => 'dashboard', 'icon' => 'layout-dashboard', 'label' => __('Dashboard'), 'key' => 'dashboard'],
        ['route' => 'calendar', 'icon' => 'calendar-days', 'label' => __('Agenda'), 'key' => 'calendar'],
        ['route' => null, 'icon' => 'kanban', 'label' => __('Kanban'), 'key' => 'kanban'],
        ['route' => 'tickets', 'icon' => 'inbox', 'label' => __('Chamados'), 'key' => 'tickets'],
        ['route' => 'reports', 'icon' => 'bar-chart-3', 'label' => __('Relatórios'), 'key' => 'reports'],
    ];
@endphp

<aside class="w-full flex flex-col flex-shrink-0 border-b border-slate-800 bg-slate-900/95 z-20 lg:h-full lg:w-80 lg:justify-between lg:border-b-0 lg:border-r lg:bg-slate-900 {{ $activePage === 'reports' ? 'print:hidden' : '' }}">
    <div class="p-3 sm:p-4 lg:p-6 flex flex-col gap-3 lg:gap-6 overflow-visible lg:overflow-y-auto custom-scrollbar">
        {{-- App Brand Header --}}
        <div class="flex items-center gap-3">
            <img src="{{ asset('assets/identidade-visualpack/taskly_logo_mark.svg') }}" alt="" class="w-9 h-9 flex-shrink-0 lg:w-10 lg:h-10">
            <div class="min-w-0">
                <h1 class="text-lg sm:text-xl font-bold tracking-tight bg-gradient-to-r from-indigo-200 to-white bg-clip-text text-transparent">Taskly</h1>
                <p class="text-xs text-slate-400 truncate">{{ $subtitle }}</p>
            </div>
        </div>

        {{-- Navigation Section --}}
        <div class="flex gap-1 overflow-visible lg:flex-col lg:gap-1">
            <div class="hidden text-xs font-semibold text-slate-400 tracking-wider uppercase px-2 mb-2 lg:block">{{ __('Navegação') }}</div>

            @foreach($navItems as $item)
                @php
                    $isActive = $activePage === $item['key'];

                    if ($item['key'] === 'kanban') {
                        $href = $userBoards->isNotEmpty() ? route('board.show', $userBoards->first()->id) : null;
                    } else {
                        $href = route($item['route']);
                    }
                @endphp

                @if($item['key'] === 'kanban' && $userBoards->isEmpty())
                    @continue
                @endif

                <a href="{{ $isActive ? '#' : $href }}" title="{{ $item['label'] }}" @if(!$isActive) wire:navigate @endif
                   class="flex min-h-10 min-w-0 flex-1 items-center justify-center gap-1.5 rounded-xl px-2 py-2 text-xs font-medium whitespace-nowrap transition duration-200 lg:min-h-0 lg:flex-none lg:justify-start lg:gap-3 lg:px-3 lg:py-2.5 lg:text-sm
                       {{ $isActive
                           ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20'
                           : 'text-slate-300 hover:bg-slate-800/60 hover:text-white group' }}">
                    <i data-lucide="{{ $item['icon'] }}" class="w-4 h-4 {{ $isActive ? 'text-indigo-200' : 'text-indigo-400 group-hover:text-white' }}"></i>
                    <span class="sr-only sm:not-sr-only sm:flex-1 sm:truncate lg:block">{{ $item['label'] }}</span>
                    @if($isActive)
                        <span class="hidden w-1.5 h-1.5 rounded-full bg-white animate-pulse lg:block"></span>
                    @endif
                </a>
            @endforeach
        </div>

        {{-- Boards Section --}}
        <div class="hidden lg:flex flex-col gap-3">
            <div class="flex items-center justify-between text-xs font-semibold text-slate-400 tracking-wider uppercase px-2">
                <span>{{ __('Meus Quadros') }}</span>
                <i data-lucide="folder" class="w-4 h-4"></i>
            </div>
            <div class="flex gap-2 overflow-x-auto pb-1 custom-scrollbar lg:flex-col lg:gap-1 lg:overflow-visible lg:pb-0">
                @foreach($userBoards as $ub)
                    @php
                        $isCurrent = $currentBoardId !== null && $currentBoardId === $ub->id;
                    @endphp
                    <a href="{{ route('board.show', $ub->id) }}" wire:navigate
                       class="flex min-h-10 flex-none items-center gap-2 rounded-xl px-3 py-2 text-xs font-medium whitespace-nowrap transition duration-200 lg:min-h-0 lg:gap-3 lg:py-2.5 lg:text-sm
                           {{ $isCurrent
                               ? 'bg-indigo-600/20 text-indigo-300 border border-indigo-500/20'
                               : 'text-slate-300 hover:bg-slate-800/60 hover:text-white group' }}">
                        <i data-lucide="kanban" class="w-4 h-4 text-indigo-400 group-hover:text-white"></i>
                        <span class="truncate flex-1">{{ $ub->title }}</span>
                        @if($isCurrent)
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-400"></span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Extra Sidebar Content Slot (e.g. Quick Actions for Kanban) --}}
        {{ $extraContent ?? '' }}
    </div>

    {{-- Logged User Profile Footer --}}
    <div class="p-3 sm:p-4 lg:p-6 border-t border-slate-800 bg-slate-900/60 flex flex-col gap-3 lg:gap-4">
        <div class="flex items-center justify-between gap-3">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-8 h-8 lg:w-10 lg:h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-violet-500 flex items-center justify-center font-bold text-xs lg:text-sm text-white shadow-inner uppercase flex-shrink-0">
                    {{ substr(auth()->user()->name ?? 'A', 0, 2) }}
                </div>
                <div class="overflow-hidden">
                    <h4 class="text-xs lg:text-sm font-semibold text-white truncate">{{ auth()->user()->name ?? __('Usuário') }}</h4>
                    <p class="hidden text-xs text-slate-400 truncate sm:block">{{ auth()->user()->email ?? 'user@teste.com' }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="flex h-10 w-10 items-center justify-center text-slate-400 hover:text-rose-400 hover:bg-rose-500/10 rounded-xl transition duration-200" title="{{ __('Sair') }}">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                </button>
            </form>
        </div>

        {{-- Dev Credits --}}
        <div class="hidden lg:flex pt-4 border-t border-slate-800 flex-col items-center gap-2 text-center">
            <p class="text-[10px] text-slate-500 font-medium">
                {{ __('Desenvolvido por') }} <span class="text-slate-300 font-semibold">Matheus Marques</span>
            </p>
            <div class="flex items-center gap-2 mt-0.5">
                <a href="https://github.com/CdeCinza" target="_blank" class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-slate-950 border border-slate-800 hover:border-slate-700 text-slate-300 hover:text-white transition duration-200 text-[10px] font-semibold group">
                    <svg class="w-3.5 h-3.5 text-indigo-400 group-hover:text-white transition-colors animate-none" viewBox="0 0 512 512" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)">
                            <path d="M2360 5049 c-154 -11 -357 -47 -516 -93 -902 -259 -1603 -1017 -1790 -1934 -136 -669 -8 -1355 354 -1908 255 -390 580 -686 968 -886 141 -73 341 -154 403 -164 58 -9 109 19 133 73 18 40 18 60 12 286 l-7 243 -86 -14 c-97 -15 -256 -9 -386 13 -105 19 -211 71 -278 139 -53 53 -67 76 -136 229 -63 139 -135 231 -232 297 -66 46 -121 106 -117 128 6 30 48 43 121 38 141 -10 288 -113 393 -274 72 -110 143 -179 230 -222 62 -31 79 -35 169 -38 103 -4 207 12 291 44 41 16 43 18 58 85 19 86 56 164 106 228 l39 49 -82 11 c-264 38 -452 102 -627 215 -229 148 -365 379 -431 731 -20 109 -23 389 -5 492 29 167 98 319 200 445 l45 55 -20 62 c-52 168 -42 372 28 574 18 50 22 52 103 48 118 -6 371 -108 543 -218 l71 -46 56 11 c30 6 87 18 127 27 271 58 655 58 926 0 40 -9 97 -21 127 -27 l55 -10 95 58 c226 137 484 230 575 206 26 -7 33 -17 53 -75 43 -125 55 -210 50 -351 -4 -95 -11 -148 -26 -195 l-21 -64 44 -54 c89 -109 155 -244 192 -389 22 -89 25 -417 4 -544 -32 -198 -114 -406 -210 -532 -165 -217 -464 -366 -843 -418 l-87 -12 39 -49 c47 -60 85 -137 106 -221 14 -52 17 -137 20 -503 5 -490 5 -489 72 -521 46 -21 83 -15 229 42 738 284 1320 932 1533 1703 141 513 111 1108 -80 1601 -172 440 -475 842 -848 1122 -405 303 -865 474 -1367 507 -175 12 -192 12 -375 0z"/>
                        </g>
                    </svg>
                    GitHub
                </a>
                <a href="https://www.linkedin.com/in/matheus-marques-fernandes-vieiracln/" target="_blank" class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-slate-950 border border-slate-800 hover:border-slate-700 text-slate-300 hover:text-white transition duration-200 text-[10px] font-semibold group">
                    <svg class="w-3.5 h-3.5 text-indigo-400 group-hover:text-white transition-colors animate-none" viewBox="0 0 512 512" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)">
                            <path d="M395 5110 c-176 -28 -312 -145 -371 -320 -18 -53 -19 -130 -19 -2230 0 -2100 1 -2177 19 -2230 49 -146 148 -247 294 -303 l57 -22 2185 0 2185 0 57 22 c146 56 245 157 294 303 18 53 19 130 19 2230 0 2100 -1 2177 -19 2230 -49 146 -148 247 -294 303 l-57 22 -2150 1 c-1182 1 -2172 -2 -2200 -6z m880 -565 c207 -44 382 -218 424 -423 78 -376 -262 -724 -634 -649 -200 41 -355 175 -421 366 -31 89 -35 228 -9 318 42 148 150 276 289 343 124 60 222 72 351 45z m2625 -1298 c169 -44 276 -104 383 -215 166 -170 253 -399 288 -757 9 -91 13 -353 14 -875 0 -702 -1 -747 -18 -773 -10 -16 -32 -37 -50 -47 -30 -19 -53 -20 -365 -20 -363 0 -370 1 -411 58 -19 28 -20 46 -24 763 -3 623 -6 744 -19 799 -38 154 -98 254 -188 308 -78 46 -121 57 -235 56 -131 0 -192 -23 -279 -105 -72 -67 -123 -159 -159 -287 -21 -75 -22 -97 -27 -792 -5 -668 -6 -717 -23 -742 -38 -55 -56 -58 -404 -58 -356 0 -368 2 -405 71 -17 32 -18 92 -18 1267 0 1368 -4 1281 64 1323 29 18 56 19 361 19 310 0 332 -1 362 -20 52 -31 63 -64 63 -192 l1 -113 22 30 c74 102 202 206 309 253 141 61 271 82 488 78 147 -3 190 -8 270 -29z m-2379 -30 c19 -12 42 -38 52 -57 16 -33 17 -109 15 -1272 -3 -1233 -3 -1237 -24 -1265 -45 -61 -58 -63 -402 -63 -338 0 -341 0 -392 55 l-25 27 -3 1250 c-2 1206 -2 1252 16 1280 11 16 32 38 48 49 27 18 51 19 355 19 322 0 326 0 360 -23z"/>
                        </g>
                    </svg>
                    LinkedIn
                </a>
            </div>
        </div>
    </div>
</aside>
