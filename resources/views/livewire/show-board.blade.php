<div>
    <h1 class="text-3xl font-bold mb-6 text-gray-700">{{ $board->title }}</h1>

    <div class="flex space-x-4 overflow-x-auto pb-4">
        
        @foreach($board->columns as $column)
            <div class="bg-gray-200 rounded-lg shadow-sm w-80 flex-shrink-0 p-4">
                <h3 class="font-semibold text-gray-700 mb-3">{{ $column->title }}</h3>

                <div class="space-y-3 min-h-[50px]">
                    
                    @foreach($column->tasks as $task)
                        <div class="bg-white p-3 rounded shadow-sm border border-gray-100 cursor-pointer hover:bg-gray-50">
                            <h4 class="font-medium text-sm text-gray-800">{{ $task->title }}</h4>
                            @if($task->description)
                                <p class="text-xs text-gray-500 mt-1 truncate">{{ $task->description }}</p>
                            @endif
                        </div>
                    @endforeach

                </div>
            </div>
        @endforeach

    </div>
</div>
