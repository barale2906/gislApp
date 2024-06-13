<div>
    <h1 class=" text-center text-2xl uppercase font-extrabold">
        @if ($tipo===0)
            Crear Lista de Precios
        @endif
        @if ($tipo===1)
            Editar Lista de Precios con Estado:
            @switch($actual->status)
                @case(1)
                    EN PROCESO
                    @break
                @case(2)
                    APROBADA
                    @break
                @case(3)
                    VIGENTE
                    @break
            @endswitch
        @endif
        @if ($tipo===2)
            Inactivar Lista de Precios
        @endif
    </h1>

    @if ($tipo!==2)
        <form class="max-w-3xl mx-auto">

            <div class="relative z-0 w-full mb-5 group">
                <input wire:model.live="name" name="name" id="name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nombre de la lista</label>
                @error('name')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <input wire:model.live="inicia" name="inicia" id="inicia" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" type="date" />
                <label for="inicia" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Inicia Vigencia</label>
                @error('inicia')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <input wire:model.live="finaliza" name="finaliza" id="finaliza" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" type="date" required />
                <label for="finaliza" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Finaliza vigencia</label>
                @error('finaliza')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <input wire:model.live="descripcion" name="descripcion" id="descripcion" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="descripcion" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Descripción</label>
                @error('descripcion')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>

            @if ($tipo===0)
                <button type="button" wire:click.prevent="new" class="text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-cyan-600 dark:hover:bg-cyan-700 dark:focus:ring-cyan-800">
                    Crear
                </button>
            @endif

            @if ($tipo===1)
                @switch($actual->status)
                    @case(1)
                        <button type="button" wire:click.prevent="edit" class="text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-cyan-600 dark:hover:bg-cyan-700 dark:focus:ring-cyan-800">
                            Editar
                        </button>
                        <button type="button" wire:click.prevent="aprobar(2)" class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                            Aprobar
                        </button>
                        @break
                    @case(2)
                        <button type="button" wire:click.prevent="aprobar(3)" class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                            Activar
                        </button>
                        @break

                    @case(3)
                        <button type="button" wire:click.prevent="aprobar(0)" class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                            Inactivar
                        </button>
                        @break

                @endswitch

            @endif

            <button type="button" wire:click.prevent="$dispatch('cancelando')" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                Cancelar
            </button>
        </form>
    @endif
    @if ($actual)
        <div class="grid grid-cols-1 md:grid-cols-3  gap-2 ring-4 rounded-lg">
            <div class=" ring-neutral-500 rounded-lg ring-2 p-2 mt-2 mb-2 ml-2">
                <livewire:facturacion.producto.productos :lista="$lista"/>
            </div>

            <div class=" ring-neutral-500 rounded-lg ring-2 p-2 mt-2 mb-2 ">
                <h1 class=" text-center font-semibold">Productos Seleccionados</h1>
                @if ($is_modifica)
                    <livewire:facturacion.producto.producto-cargar :actual="$detalle"/>
                @else
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">

                                </th>
                                <th scope="col" class="px-6 py-3" >
                                    PRODUCTO
                                </th>
                                <th scope="col" class="px-6 py-3" >
                                    PRECIO
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cargados as $item)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                                    <th scope="row" class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                        <div class="inline-flex rounded-md shadow-sm" role="group">
                                            @can('fa_listamodify')
                                                <button wire:click.prevent="show({{$item->id}},{{1}})" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-900 bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 border border-blue-900 rounded-lg hover:bg-blue-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-blue-500 focus:bg-blue-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-blue-700 dark:focus:bg-blue-700">
                                                    <i class="fa-solid fa-marker"></i>
                                                </button>
                                            @endcan
                                        </div>
                                    </th>
                                    <th scope="row" class="px-2 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                        {{$item->producto->name}}
                                    </th>
                                    <th scope="row" class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                        $ {{number_format($item->precio, 0, '.', ' ')}}
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <div class=" ring-neutral-500 rounded-lg ring-2 p-2 mt-2 mb-2 mr-2">
                <h1 class=" text-center font-semibold">
                    Clientes Asignados
                    <button wire:click.prevent="show(0,2)" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-green-900 bg-gradient-to-r from-green-300 via-green-400 to-green-500 border border-green-900 rounded-lg hover:bg-green-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-green-500 focus:bg-green-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-green-700 dark:focus:bg-green-700">
                        <i class="fa-solid fa-upload"></i>
                    </button>
                </h1>
                @switch($is_empresas)
                    @case(1)
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">

                                    </th>
                                    <th scope="col" class="px-6 py-3" >
                                        CLIENTE
                                    </th>
                                    <th scope="col" class="px-6 py-3" >
                                        DESCUENTO
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($empresas as $item)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                                        <th scope="row" class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                            <div class="inline-flex rounded-md shadow-sm" role="group">
                                                @can('fa_listamodify')

                                                    <button wire:click.prevent="elimremi({{$item->id}})" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-900 bg-gradient-to-r from-red-300 via-red-400 to-red-500 border border-red-900 rounded-lg hover:bg-red-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-red-500 focus:bg-red-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-red-700 dark:focus:bg-red-700">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                @endcan
                                            </div>
                                        </th>
                                        <th scope="row" class="px-2 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                            {{$item->empresa}}
                                        </th>
                                        <th scope="row" class="px-2 py-4 font-medium text-gray-900 text-center whitespace-nowrap dark:text-white capitalize">
                                            {{number_format($item->descuento, 0, '.', ' ')}} %
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @break
                    @case(2)
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">

                                    </th>
                                    <th scope="col" class="px-6 py-3" >
                                        CLIENTE
                                        <button wire:click.prevent="$dispatch('volviendo')" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-green-900 bg-gradient-to-r from-green-300 via-green-400 to-green-500 border border-green-900 rounded-lg hover:bg-green-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-green-500 focus:bg-green-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-green-700 dark:focus:bg-green-700">
                                            <i class="fa-solid fa-left-long"></i>
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($remitentes as $item)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                                        <th scope="row" class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                            <div class="inline-flex rounded-md shadow-sm" role="group">
                                                @can('fa_listamodify')
                                                    <button wire:click.prevent="show({{$item->id}},{{4}})" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-green-900 bg-gradient-to-r from-green-300 via-green-400 to-green-500 border border-green-900 rounded-lg hover:bg-green-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-green-500 focus:bg-green-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-green-700 dark:focus:bg-green-700">
                                                        <i class="fa-solid fa-upload"></i>
                                                    </button>
                                                @endcan
                                            </div>
                                        </th>
                                        <th scope="row" class="px-2 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                            {{$item->name}}
                                        </th>
                                    </tr>
                                    @if ($item->id===$remit)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                                            <th scope="row" class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <div class="relative z-0 w-full mb-5 group">
                                                    <input wire:model="descuento" name="descuento" id="descuento" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                                    <label for="descuento" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Descuento ( % )</label>
                                                </div>
                                            </th>
                                            <th scope="row" class="px-2 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                                    <button wire:click.prevent="show({{$item->id}},{{3}})" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-green-900 bg-gradient-to-r from-green-300 via-green-400 to-green-500 border border-green-900 rounded-lg hover:bg-green-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-green-500 focus:bg-green-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-green-700 dark:focus:bg-green-700">
                                                        <i class="fa-solid fa-upload"></i>
                                                    </button>
                                                </div>
                                            </th>
                                        </tr>
                                    @endif

                                @endforeach
                            </tbody>
                        </table>
                        @break
                    @case(3)
                        <livewire:facturacion.lista.lista-cliente :lista="$lista" :empresa="$remit" :descuento="$descuento"/>
                        @break
                @endswitch
            </div>
        </div>

    @endif

    @if ($tipo===2)
        @include('include.inactivar')
    @endif
</div>
