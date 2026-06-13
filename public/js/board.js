/**
 * Kanban Drag-and-Drop via SortableJS
 *
 * Supports Livewire wire:navigate (SPA mode) by:
 *  - Listening to livewire:navigated to re-init after page transitions
 *  - Destroying existing Sortable instances before re-attaching (avoids doubles)
 *  - Using a WeakMap to track instances per element (no dataset pollution)
 */

const sortableInstances = new WeakMap();

function initSortable() {
    const columns = document.querySelectorAll('.sortable-column');
    if (columns.length === 0 || typeof Sortable === 'undefined') return;

    columns.forEach(column => {
        // Destroy any existing instance on this element to avoid duplicate handlers
        if (sortableInstances.has(column)) {
            sortableInstances.get(column).destroy();
            sortableInstances.delete(column);
        }

        const instance = new Sortable(column, {
            group: 'kanban',
            animation: 150,
            ghostClass: 'opacity-40',
            dragClass: 'ring-2',
            forceFallback: false,

            onEnd: function (evt) {
                const newColumn = evt.to;
                const newColumnId = newColumn.getAttribute('data-column-id');

                // Filter out any non-task children (e.g. empty placeholder divs)
                const taskIds = Array.from(newColumn.children)
                    .map(child => child.getAttribute('data-task-id'))
                    .filter(id => id !== null);

                // Locate the Livewire component that wraps this column
                const componentEl = newColumn.closest('[wire\\:id]');
                if (!componentEl) return;

                const componentId = componentEl.getAttribute('wire:id');
                const component = Livewire.find(componentId);
                if (component) {
                    component.updateTaskOrder(taskIds, newColumnId);
                }
            }
        });

        sortableInstances.set(column, instance);
    });
}

// Init on first hard page load
document.addEventListener('livewire:init', () => {
    initSortable();

    // Re-init after every Livewire DOM update (morph)
    Livewire.hook('commit', ({ succeed }) => {
        succeed(() => {
            queueMicrotask(() => {
                initSortable();
            });
        });
    });
});

// Re-init after wire:navigate SPA navigation
document.addEventListener('livewire:navigated', () => {
    // Small delay to let Livewire finish mounting the new component
    setTimeout(() => {
        initSortable();
    }, 50);
});
