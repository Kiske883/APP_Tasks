<section class="">
    <div class="container">
        <div>
            <button class="px-4 py-1 mb-6 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-lg shadow-md hover:from-indigo-600 hover:to-blue-500 hover:scale-105 transform transition duration-300"
                wire:click="openCreateModal">
                Nuevo
            </button>
        </div>

        <div>
            <table class="w-full text-left table-auto min-w-max">
                <thead>
                    <tr>
                        <th class="p-4 border-b border-slate-600 bg-slate-700 w-1/6">
                            <p class="text-sm font-normal leading-none text-slate-300">Titulo</p>
                        </th>
                        <th class="p-4 border-b border-slate-600 bg-slate-700 w-4/6">
                            <p class="text-sm font-normal leading-none text-slate-300">Descripcion</p>
                        </th>
                        <th class="p-4 border-b border-slate-600 bg-slate-700 w-1/6">
                            <p class="text-sm font-normal leading-none text-slate-300">Acciones</p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                    <tr class="hover:bg-slate-700">
                        <td class="p-4 border-b border-slate-700 w-1/6">
                            <p class="text-sm text-slate-100 font-semibold">{{$task->title}}</p>
                        </td>
                        <td class="p-4 border-b border-slate-700 w-4/6">
                            <p class="text-sm text-slate-300">{{$task->description}}</p>
                        </td>
                        <td class="p-4 border-b border-slate-700 w-1/6 flex gap-2">
                            <button class="px-4 py-1 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-lg shadow-md hover:from-indigo-600 hover:to-blue-500 hover:scale-105 transform transition duration-300"
                                wire:click.prevent="openEditModal({{ $task->id }})">
                                Editar
                            </button>
                            <button class="px-4 py-1 bg-gradient-to-r from-red-500 to-pink-600 text-white font-semibold rounded-lg shadow-md hover:from-pink-600 hover:to-red-500 hover:scale-105 transform transition duration-300"
                                wire:click.prevent="deleteTask({{ $task->id }})"
                                wire:confirm="Deseas eliminar la tarea {{$task->title}}">
                                Borrar
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @if($modal)
    <!-- component -->
    <div class="fixed left-0 top-0 flex h-full w-full items-center justify-center bg-black bg-opacity-50 py-10">
        <div class="max-h-full w-full max-w-xl overflow-y-auto sm:rounded-2xl bg-gray-900 shadow-xl">
            <div class="w-full m-8 my-20 max-w-[400px] mx-auto">
                <h1 class="mb-4 text-4xl font-extrabold text-gray-100 text-center">
                    {{ $taskId ? 'Editar tarea' : 'Crear nueva tarea' }}
                </h1>

                <form>
                    <div class="mb-6">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-300">Título</label>
                        <input wire:model="title" type="text" id="title" class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-300">Descripción</label>
                        <input wire:model="description" type="text" id="description" class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                </form>

                <div class="flex gap-4">
                    <button wire:click.prevent="createOrUpdateTask()" class="flex-1 py-3 bg-blue-600 rounded-full text-white font-semibold hover:bg-blue-700 transition">
                        {{ $taskId ? 'Actualizar Tarea' : 'Crear Tarea' }}
                    </button>
                    <button wire:click="closeCreateModal" class="flex-1 py-3 bg-gray-700 border border-gray-600 rounded-full text-gray-100 font-semibold hover:bg-gray-600 transition">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</section>