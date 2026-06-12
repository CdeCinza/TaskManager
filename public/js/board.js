document.addEventListener('livewire:init', () => {
    initSortable();

    if (typeof Livewire !== 'undefined') {
        Livewire.hook('commit', ({ succeed }) => {
            succeed(() => {
                queueMicrotask(() => {
                    initSortable();
                });
            });
        });
    }
});

function initSortable() {
    let columns = document.querySelectorAll('.sortable-column');
    if (columns.length === 0 || typeof Sortable === 'undefined') return;

    columns.forEach(column => {
        if (column.dataset.sortableInitialized) return;
        column.dataset.sortableInitialized = 'true';

        new Sortable(column, {
            group: 'kanban',
            animation: 150,
            ghostClass: 'opacity-40',
            dragClass: 'bg-indigo-650',
            
            onEnd: function (evt) {
                let newColumn = evt.to;
                let newColumnId = newColumn.getAttribute('data-column-id');
                let taskIds = Array.from(newColumn.children).map(child => child.getAttribute('data-task-id'));

                let componentEl = evt.to.closest('[wire\\:id]');
                if (componentEl) {
                    let componentId = componentEl.getAttribute('wire:id');
                    let component = Livewire.find(componentId);
                    if (component) {
                        component.updateTaskOrder(taskIds, newColumnId);
                    }
                }
            }
        });
    });
}
