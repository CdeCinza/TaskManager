<div class="relative" x-data="{ open: false }" @click.away="open = false">
    <button @click="open = !open"
            class="flex items-center gap-2 bg-slate-850 hover:bg-slate-850/80 text-slate-300 hover:text-white px-3.5 py-2 rounded-xl text-xs font-semibold border border-slate-700/60 transition duration-200 group">
        <i data-lucide="globe" class="w-3.5 h-3.5 text-indigo-400 group-hover:text-white"></i>
        <span>
            @if(app()->getLocale() === 'en')
                English
            @elseif(app()->getLocale() === 'es')
                Español
            @else
                Português
            @endif
        </span>
        <i data-lucide="chevron-down" class="w-3 h-3 text-slate-500 group-hover:text-indigo-400 transition-transform duration-200" :class="{'rotate-180': open}"></i>
    </button>
    <div x-show="open"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95 translate-y-1"
         x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="transform opacity-0 scale-95 translate-y-1"
         class="absolute top-full mt-1.5 right-0 w-36 bg-slate-800 border border-slate-700 rounded-xl shadow-xl overflow-hidden z-50 py-1"
         style="display: none;">
        <button wire:click="setLocale('pt_BR')" @click="open = false"
                class="w-full text-left px-3 py-2 text-xs font-medium transition-colors hover:bg-slate-700/50 hover:text-white {{ app()->getLocale() === 'pt_BR' ? 'text-indigo-400 bg-indigo-500/10' : 'text-slate-300' }}">
            Português
        </button>
        <button wire:click="setLocale('en')" @click="open = false"
                class="w-full text-left px-3 py-2 text-xs font-medium transition-colors hover:bg-slate-700/50 hover:text-white {{ app()->getLocale() === 'en' ? 'text-indigo-400 bg-indigo-500/10' : 'text-slate-300' }}">
            English
        </button>
        <button wire:click="setLocale('es')" @click="open = false"
                class="w-full text-left px-3 py-2 text-xs font-medium transition-colors hover:bg-slate-700/50 hover:text-white {{ app()->getLocale() === 'es' ? 'text-indigo-400 bg-indigo-500/10' : 'text-slate-300' }}">
            Español
        </button>
    </div>
</div>
