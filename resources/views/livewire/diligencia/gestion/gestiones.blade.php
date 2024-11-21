<div>
    @if ($is_modify)
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            @include('include.filtro')
            <a href="" wire:click.prevent="cerrados" class=" text-black bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm mx-2 px-5 py-2.5 text-center capitalize" >
                <i class="fa-solid fa-bars-progress"></i>
            </a>

            <div>
                @if ($diligencias->count()>0)
                    <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4 rtl:space-x-reverse">
                        <div class="ring-1 ring-zinc-600 rounded-md m-4 p-2">
                            <label for="mensajero" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Elegir Mensajero encargado</label>
                            <div class="relative z-0 w-full mb-5 group">
                                <select wire:model.live="mensajero" id="mensajero" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer capitalize">
                                    <option>Elegir...</option>
                                    @foreach ($mensajeros as $item)
                                        <option value={{$item->id}}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                                <label for="mensajero" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Mensajero</label>
                            </div>
                        </div>
                        @if ($usuconsulta)
                            <div class="ring-1 ring-zinc-600 rounded-md m-6  p-2">
                                <label for="elegido" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mensajero Elegido</label>
                                <div class="relative z-0 w-full mb-5 group">
                                    <span class=" uppercase font-bold">{{$usuconsulta->name}}</span> se eligen las diligencias para la ciudad de: <span class="uppercase font-bold">{{$ubicacion->sucursal->ciudad->name}}</span>
                                </div>
                            </div>
                        @endif

                    </div>


                    <table class="w-full text-sm text-left rtl:text-right mt-2 text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase ">
                            <tr>
                                <th scope="col" colspan="4" class="px-6 py-3 text-center text-xl font-extrabold bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    GESTIÓN
                                </th>
                                <th scope="col" colspan="1" class="px-6 py-3 text-center text-xl font-extrabold bg-gray-200 dark:bg-gray-800 dark:text-gray-500">
                                    REMITENTE
                                </th>
                                <th scope="col" colspan="2" class="px-6 py-3 text-center text-xl font-extrabold bg-gray-300 dark:bg-gray-900 dark:text-gray-600">
                                    DESTINATARIO
                                </th>
                            </tr>
                            <tr>
                                <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">

                                </th>
                                <th scope="col" class="px-6 py-3  bg-gray-50 dark:bg-gray-800 dark:text-gray-500" style="cursor: pointer;" wire:click="organizar('identificador')">
                                    ID
                                    @if ($ordena != 'identificador')
                                        <i class="fas fa-sort"></i>
                                    @else
                                        @if ($ordenado=='ASC')
                                            <i class="fas fa-sort-up"></i>
                                        @else
                                            <i class="fas fa-sort-down"></i>
                                        @endif
                                    @endif
                                </th>
                                <th scope="col" class="px-6 py-3  bg-gray-50 dark:bg-gray-800 dark:text-gray-500" style="cursor: pointer;" wire:click="organizar('guias')">
                                    GUIAS
                                    @if ($ordena != 'guias')
                                        <i class="fas fa-sort"></i>
                                    @else
                                        @if ($ordenado=='ASC')
                                            <i class="fas fa-sort-up"></i>
                                        @else
                                            <i class="fas fa-sort-down"></i>
                                        @endif
                                    @endif
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    OBSERVACIONES
                                </th>

                                <th scope="col" class="px-6 py-3 bg-gray-200 dark:bg-gray-800 dark:text-gray-500" style="cursor: pointer;" wire:click="organizar('fecha_entrega')">
                                    Fecha Entrega - Remite
                                    @if ($ordena != 'fecha_entrega')
                                        <i class="fas fa-sort"></i>
                                    @else
                                        @if ($ordenado=='ASC')
                                            <i class="fas fa-sort-up"></i>
                                        @else
                                            <i class="fas fa-sort-down"></i>
                                        @endif
                                    @endif
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-300 dark:bg-gray-900 dark:text-gray-600" style="cursor: pointer;" wire:click="organizar('name_dest')">
                                    Destinatario
                                    @if ($ordena != 'name_dest')
                                        <i class="fas fa-sort"></i>
                                    @else
                                        @if ($ordenado=='ASC')
                                            <i class="fas fa-sort-up"></i>
                                        @else
                                            <i class="fas fa-sort-down"></i>
                                        @endif
                                    @endif
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-300 dark:bg-gray-900 dark:text-gray-600" >
                                    Descripción
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($diligencias as $item)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="inline-flex rounded-md shadow-sm" role="group">
                                            @can('di_diligeModify')
                                                <button wire:click.prevent="show({{$item->id}},{{1}})" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-900 bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 border border-blue-900 rounded-lg hover:bg-blue-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-blue-500 focus:bg-blue-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-blue-700 dark:focus:bg-blue-700">
                                                    <i class="fa-solid fa-inbox"></i>
                                                </button>
                                                @if ($usuconsulta && $item->status<=3)
                                                    <button wire:click.prevent="asignar({{$item->id}})" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-green-900 bg-gradient-to-r from-green-300 via-green-400 to-green-500 border border-green-900 rounded-lg hover:bg-green-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-green-500 focus:bg-green-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-green-700 dark:focus:bg-green-700">
                                                        <i class="fa-solid fa-road"></i>
                                                    </button>
                                                @endif
                                            @endcan
                                        </div>
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{$item->identificador}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 text-center dark:text-white">
                                        {{$item->guias}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 text-justify dark:text-white">
                                        {{$item->observaciones}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 text-justify  dark:text-white capitalize">
                                        @switch($item->status)

                                            @case(1)
                                                <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">
                                                    Creada
                                                </span>
                                                @break
                                            @case(2)
                                                <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                                    Asignada
                                                </span>
                                                @break
                                            @case(3)
                                                <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-900 dark:text-blue-300">
                                                    En proceso
                                                </span>
                                                @break
                                            @case(3)
                                                <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-900 dark:text-blue-300">
                                                    En proceso
                                                </span>
                                                @break
                                            @case(4)
                                                <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-900 dark:text-blue-300">
                                                    Entregada Destinatario
                                                </span>
                                                @break
                                            @case(5)
                                                <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-900 dark:text-blue-300">
                                                    Ejecutada
                                                </span>
                                                @break
                                            @case(6)
                                                <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-900 dark:text-blue-300">
                                                    Cerrada
                                                </span>
                                                @break
                                            @case(7)
                                                <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-900 dark:text-blue-300">
                                                    Legalizada Mensajero
                                                </span>
                                                @break
                                            @case(8)
                                                <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-900 dark:text-blue-300">
                                                    Devolución
                                                </span>
                                                @break
                                            @case(9)
                                                <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-900 dark:text-blue-300">
                                                    Cancelada
                                                </span>
                                                @break
                                        @endswitch
                                        FECHA ENTREGA: {{$item->fecha_entrega}} EMPRESA: {{$item->empresa->name}} REMITE: {{$item->ubica->user->name}} SUCURSAL: {{$item->ubica->sucursal->name}} - Ciudad: {{$item->ubica->sucursal->ciudad->name}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 text-justify  dark:text-white capitalize">
                                        NOMBRE: {{$item->name_dest}} DIRECCIÓN: {{$item->direccion_dest}} CIUDAD: {{$item->sucursal_dest}} - {{$item->ciudad->name}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-justify text-gray-900 dark:text-white capitalize">
                                        {{$item->descripcion}}
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-2 p-1 w-auto rounded-lg grid grid-cols-2 gap-4 bg-blue-100">
                        <div>
                            <label class="relative inline-flex items-center mb-4 cursor-pointer">
                                <span class="ml-3 mr-3 text-sm font-medium text-gray-900 dark:text-gray-300">Registros:</span>
                                <select wire:click="paginas($event.target.value)" id="countries" class="w-20 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value=15>15</option>
                                    <option value=20>20</option>
                                    <option value=50>50</option>
                                    <option value=100>100</option>
                                    <option value=500>500</option>
                                </select>
                            </label>
                        </div>
                        <div>
                            {{ $diligencias->links() }}
                        </div>
                    </div>
                @else
                    <h1 class=" text-center">No hay diligencias bajo estos parámetros</h1>
                @endif
            </div>
        </div>
    @endif
    @if ($is_creating)
        <livewire:diligencia.diligencia.diligencia-modificar :elegido="$elegido" :tipo="$tipo"/>
    @endif

    @push('js')
        <script>
            document.addEventListener('livewire:initialized', function (){
                @this.on('alerta', (name)=>{
                    const variable = name;
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'success',
                        title: variable['name'],
                        showConfirmButton: false,
                        timer: 500
                    })
                });
            });
        </script>
    @endpush
</div>
