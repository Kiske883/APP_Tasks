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
                            Titulo
                        </th>
                        <th class="p-4 border-b border-slate-600 bg-slate-700 w-3/6">
                            Descripcion
                        </th>
                        <th class="p-4 border-b border-slate-600 bg-slate-700 w-2/6">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                    <tr class="hover:bg-slate-700">
                        <td class="p-4 border-b border-slate-700 truncate">
                            {{$task->title}}
                        </td>
                        <td class="p-4 border-b border-slate-700 truncate overflow-hidden">
                            {{$task->description}}
                        </td>
                        <td class="p-4 border-b border-slate-700 flex gap-2">
                            <button wire:click.prevent='openEditModal({{ $task->id }})'
                                class="flex-shrink-0 px-4 py-1 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-lg shadow-md hover:from-indigo-600 hover:to-blue-500 transition">
                                Editar
                            </button>
                            <button wire:click.prevent='deleteTask({{ $task->id }})'
                                wire:confirm='Deseas eliminar la tarea {{ $task->title }}'
                                class="flex-shrink-0 px-4 py-1 bg-gradient-to-r from-red-500 to-pink-600 text-white font-semibold rounded-lg shadow-md hover:from-pink-600 hover:to-red-500 transition">
                                Borrar
                            </button>
                            <button wire:click.prevent='openShareModal({{ $task->id }})'
                                class="flex-shrink-0 px-4 py-1 bg-gradient-to-r from-green-500 to-green-700 text-white font-semibold rounded-lg shadow-md hover:from-green-600 hover:to-green-800 transition">
                                Compartir
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

    @if($shareModal)
    <div class="fixed left-0 top-0 flex h-full w-full items-center justify-center bg-black bg-opacity-50 py-10">
        <div class="max-h-full w-full max-w-md overflow-y-auto sm:rounded-2xl bg-gray-900 shadow-xl p-6">
            <h2 class="text-2xl font-bold text-gray-100 mb-4 text-center">Compartir Tarea</h2>

            <div class="mb-4">
                <label class="block mb-2 text-gray-300">Selecciona un usuario</label>
                <select wire:model="selectedUser" class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 text-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">-- Elegir usuario --</option>
                    @foreach(\App\Models\User::all() as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-4">
                <button wire:click.prevent="shareTask" class="flex-1 py-3 bg-green-600 text-white font-semibold rounded-full hover:bg-green-700 transition">
                    Compartir
                </button>
                <button wire:click="$set('shareModal', false)" class="flex-1 py-3 bg-gray-700 text-gray-100 font-semibold rounded-full hover:bg-gray-600 transition">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
    @endif
</section>

@if (session()->has('message'))
    <div class="bg-green-500 text-white p-2 rounded mb-2">
        {{ session('message') }}
    </div>
@endif