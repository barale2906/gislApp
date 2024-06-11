<div>

    <h1 class=" text-center text-2xl uppercase font-extrabold">
        @if ($tipo===0)
            Crear Rol
        @endif
        @if ($tipo===1)
            Editar Rol
        @endif
        @if ($tipo===2)
            Inactivar Rol
        @endif
    </h1>

    @if ($tipo!==2)
        <form class="max-w-3xl mx-auto">
            <div class="mb-6">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del Rol</label>
                <input type="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre" wire:model.blur="name">
            </div>
            @error('name')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror

            @foreach ($encabezados as $it)
                <h2 class="text-lg text-justify mb-6">
                    Permisos para el modulo <strong class="font-extrabold uppercase">{{$it->modulo}}</strong>
                </h2>
                <div class="grid sm:grid-cols-1 md:grid-cols-6 gap-4">
                    @foreach ($listaPermisos as $item)
                        @if ($item->modulo===$it->modulo)
                            <div class="flex items-center mb-4 capitalize">
                                <input id="default-checkbox" wire:model.live="permis" type="checkbox" value="{{$item->id}}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 " >
                                <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    {{$item->descripcion}}
                                </label>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="inline-flex items-center justify-center w-full">
                    <hr class="w-64 h-1 my-8 bg-gray-200 border-0 rounded dark:bg-gray-700">
                    <div class="absolute px-4 -translate-x-1/2 bg-white left-1/2 dark:bg-gray-900">
                        <i class="fa-solid fa-pen-nib"></i>
                    </div>
                </div>
            @endforeach

            @if ($tipo===0)
                <button type="button" wire:click.prevent="new" class="text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-cyan-600 dark:hover:bg-cyan-700 dark:focus:ring-cyan-800">
                    Crear
                </button>
            @endif

            @if ($tipo===1)
                <button type="button" wire:click.prevent="edit" class="text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-cyan-600 dark:hover:bg-cyan-700 dark:focus:ring-cyan-800">
                    Editar
                </button>
            @endif
            <button type="button" wire:click.prevent="$dispatch('cancelando')" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                Cancelar
            </button>
        </form>
    @endif

    @if ($tipo===2)
        @include('include.inactivar')
    @endif


</div>
