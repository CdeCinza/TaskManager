window.tailwind = {
    config: {
        theme: {
            extend: {
                fontFamily: {
                    sans: ['Outfit', 'sans-serif'],
                }
            }
        }
    }
};

document.addEventListener('DOMContentLoaded', () => {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});

document.addEventListener('livewire:navigated', () => {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});

document.addEventListener('livewire:init', () => {
    if (typeof Livewire !== 'undefined') {
        Livewire.hook('commit', ({ succeed }) => {
            succeed(() => {
                queueMicrotask(() => {
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                });
            });
        });
    }
});

window.confirmAction = function(message, callback, title = 'Atenção', confirmText = 'Sim, confirmar!', cancelText = 'Cancelar') {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: title,
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
            cancelButtonColor: '#e11d48',
            confirmButtonText: confirmText,
            cancelButtonText: cancelText,
            background: '#1e293b',
            color: '#f8fafc',
            customClass: {
                popup: 'border border-slate-700 shadow-xl rounded-2xl',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                callback();
            }
        });
    } else {
        if (confirm(message)) {
            callback();
        }
    }
};
