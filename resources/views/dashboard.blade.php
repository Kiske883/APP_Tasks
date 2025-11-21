<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-3xl text-emerald-800">Bienvenido al gestor de tareas</h1>
                    <h2 class="text-xl text-emerald-800">{{ $tasks->count()}} tareas registradas</h2>
                    @foreach($tasks as $task)
                        <h3>{{ $task->title}}</h3>
                        <h3>{{ $task->description}}</h3>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>