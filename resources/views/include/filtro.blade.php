<div class="grid sm:grid-cols-1 md:grid-cols-6 gap-4 m-2">
    <div class="relative z-0 w-full mb-5 group sm:col-span-1 md:col-span-3">
        <input wire:model.live="buscar"
        wire:keydown="buscando" name="buscar" id="buscar" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
        <label for="buscar" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 capitalize">{{$text}}</label>
    </div>
    @if ($is_filtro)
        @if ($is_creacion)
            <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">
                <label for="filtroCreades" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de creación</label>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="date" wire:model.live="filtroCreades" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  />
                    <label for="filtroCreades" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Desde</label>
                </div>
                @if ($filtroCreades)
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="date" wire:model.live="filtroCreahas" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  />
                        <label for="filtroCreahas" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Hasta</label>
                    </div>
                @endif
            </div>
        @endif

        @if ($is_inicia)
            <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">
                <label for="filtroIniciades" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de inicio - Creación</label>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="date" wire:model.live="filtroIniciades" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  />
                    <label for="filtroCreades" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Desde</label>
                </div>
                @if ($filtroIniciades)
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="date" wire:model.live="filtroIniciahas" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  />
                        <label for="filtroCreahas" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Hasta</label>
                    </div>
                @endif
            </div>
        @endif

        @if ($is_termina)
            <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">
                <label for="filtroTerminades" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de finalización - Vencimiento</label>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="date" wire:model.live="filtroTerminades" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  />
                    <label for="filtroCreades" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Desde</label>
                </div>
                @if ($filtroTerminades)
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="date" wire:model.live="filtroTerminahas" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  />
                        <label for="filtroCreahas" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Hasta</label>
                    </div>
                @endif
            </div>
        @endif

        @if ($is_entrega)
            <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">
                <label for="filtroCreades" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de entrega</label>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="date" wire:model.live="filtroEntdes" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  />
                    <label for="filtroCreades" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Desde</label>
                </div>
                @if ($filtroEntdes)
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="date" wire:model.live="filtroEnthas" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  />
                        <label for="filtroCreahas" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Hasta</label>
                    </div>
                @endif
            </div>
        @endif
        @if ($is_ubicaenvia)
            <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">
                <label for="filtroCreades" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Desde donde se envío</label>
                <div class="relative z-0 w-full mb-5 group">
                    <select wire:model.live="sucursal_id" id="sucursal_id" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer capitalize">
                        <option>Elegir...</option>
                        @foreach ($sucursales as $item)
                            <option value={{$item->id}}>{{$item->name}} - {{$item->ciudad->name}}</option>
                        @endforeach
                    </select>
                    <label for="sucursal_id" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Elegir Sucursal</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <select wire:model.live="area_id" id="area_id" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer capitalize">
                        <option>Elegir...</option>
                        @foreach ($areas->areas as $item)
                            <option value={{$item->id}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                    <label for="area_id" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Elegir Área</label>
                </div>
            </div>
        @endif
        @if ($is_asignados)
            <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">
                <label for="mensafiltro" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Verificar asignaciones</label>
                <div class="relative z-0 w-full mb-5 group">
                    <select wire:model.live="mensafiltro" id="mensafiltro" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer capitalize">
                        <option>Elegir...</option>
                        @foreach ($seleccionados as $item)
                            <option value={{$item->id}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                    <label for="mensafiltro" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Elegir Mensajero</label>
                </div>
            </div>
        @endif
        @if ($is_ubicarecibe)
            <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">
                <label for="filtroCreades" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Donde se recibe</label>
                <div class="relative z-0 w-full mb-5 group">
                    <select wire:model.live="sucursal_id" id="sucursal_id" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer capitalize">
                        <option>Elegir...</option>
                        @foreach ($sucursales as $item)
                            <option value={{$item->id}}>{{$item->name}} - {{$item->ciudad->name}}</option>
                        @endforeach
                    </select>
                    <label for="sucursal_id" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Elegir Sucursal</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <select wire:model.live="area_id" id="area_id" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer capitalize">
                        <option>Elegir...</option>
                        @foreach ($areas->areas as $item)
                            <option value={{$item->id}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                    <label for="area_id" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Elegir Área</label>
                </div>
            </div>
        @endif
        @if ($is_conceptos)
            <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">
                <label for="concepto_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Conceptos</label>
                <div class="relative z-0 w-full mb-5 group">
                    <select wire:model.live="concepto_id" id="concepto_id" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer capitalize">
                        <option>Elegir...</option>
                        @foreach ($conceptos as $item)
                            <option value={{$item->id}}>{{$item->concepto}}</option>
                        @endforeach
                    </select>
                    <label for="concepto_id" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Elegir Concepto</label>
                </div>
            </div>
        @endif
    @endif

    <div>
        <a href="" wire:click.prevent="$dispatch('limpiando')" class=" text-black bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:focus:ring-yellow-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center capitalize" >
            <i class="fa-solid fa-eraser"></i>
        </a>
        <a href="" wire:click.prevent="filtroMostrar" class=" text-black bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center capitalize" >
            <i class="fa-solid fa-filter"></i>
        </a>
    </div>
    <div>
        @if ($is_crear)
            @can($permiso)
                <a href="" wire:click.prevent="$dispatch('created')" class=" text-black bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center capitalize" >
                    <i class="fa-solid fa-plus"></i> crear
                </a>
            @endcan
        @endif


    </div>
</div>
