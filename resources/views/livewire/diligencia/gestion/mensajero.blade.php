<div>
    @if ($is_editar)
        @include('include.filtro')
        <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4 rtl:space-x-reverse">
            <button wire:click.prevent="tipo({{1}})" type="button" class="inline-flex items-center p-1 text-sm font-medium text-cyan-900 bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 border border-cyan-900 rounded-s-lg hover:bg-cyan-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-cyan-500 focus:bg-cyan-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-cyan-700 dark:focus:bg-cyan-700">
                <i class="fa-solid fa-chart-simple"></i> HISTORIAL
            </button>
            <button wire:click.prevent="tipo({{2}})" type="button" class="inline-flex items-center p-1 text-sm font-medium text-blue-900 bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 border border-blue-900 hover:bg-blue-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-blue-500 focus:bg-blue-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-blue-700 dark:focus:bg-blue-700">
                <i class="fa-solid fa-hand-peace"></i> ASIGNADAS
            </button>
            <button wire:click.prevent="tipo({{3}})" type="button" class="inline-flex items-center p-1 rounded-e-lg text-sm font-medium text-green-900 bg-gradient-to-r from-green-300 via-green-400 to-green-500 border border-green-900  hover:bg-green-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-green-500 focus:bg-green-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-green-700">
                <i class="fa-solid fa-check-double"></i> TODAS
            </button>
        </div>

        @if ($diligencias->count()>0)

            <table class="w-full text-sm text-left rtl:text-right mt-2 text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase ">
                    <tr>
                        <th scope="col" class="px-6 py-3  bg-gray-50 dark:bg-gray-800 dark:text-gray-500" style="cursor: pointer;" wire:click="organizar('identificador')">
                            DATOS
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($diligencias as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                            <th scope="row" class="font-medium p-1 text-gray-900 text-xs text-justify dark:text-white">
                                <div class="ring-1 ring-zinc-200 rounded-md m-1  p-1">
                                    <div class="inline-flex rounded-md shadow-sm" role="group">
                                        @can('di_diligestmensa')
                                            <button wire:click.prevent="recibe({{$item->id}})" type="button" class="inline-flex items-center p-1 text-xs font-medium text-blue-900 bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 border border-blue-900 rounded-lg hover:bg-blue-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-blue-500 focus:bg-blue-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-blue-700 dark:focus:bg-blue-700">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                            @foreach ($item->mensajeros as $val)
                                                @if ($usuconsulta->id===$val->user_id && $val->status===2)
                                                    <button wire:click.prevent="gest({{$item->id}})" type="button" class="inline-flex items-center p-1 text-xs font-medium text-green-900 bg-gradient-to-r from-green-300 via-green-400 to-green-500 border border-green-900 rounded-lg hover:bg-green-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-green-500 focus:bg-green-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-green-700 dark:focus:bg-green-700">
                                                        <i class="fa-solid fa-camera"></i>
                                                    </button>
                                                @endif
                                                @if ($usuconsulta->id===$val->user_id && $val->status!==4)
                                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                                        <i class="fa-solid fa-thumbs-up"></i> Suya
                                                    </span>
                                                @endif
                                            @endforeach
                                        @endcan
                                    </div>


                                    ID: <span class=" text-xs">{{$item->identificador}}</span> ENTREGA: {{$item->fecha_entrega}}  DESTINO: NOMBRE: {{$item->name_dest}} DIRECCIÓN: {{$item->direccion_dest}} CIUDAD: {{$item->sucursal_dest}} - {{$item->ciudad->name}} -- {{$item->descripcion}}
                                </div>
                                <div class="ring-1 ring-zinc-100 rounded-md m-1  p-1">
                                    REMITE: EMPRESA: {{$item->empresa->name}} REMITE: {{$item->ubica->user->name}} SUCURSAL: {{$item->ubica->sucursal->name}} - Ciudad: {{$item->ubica->sucursal->ciudad->name}}
                                </div>
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
    @endif

    @if ($is_historial)
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase ">
                <tr>
                    <th scope="col" colspan="2" class="px-6 py-3 text-center text-xl font-extrabold bg-gray-50 dark:bg-gray-800 dark:text-gray-500">
                        DATOS
                    </th>
                    <th scope="col" colspan="4" class="px-6 py-3 text-center text-xl font-extrabold bg-gray-200 dark:bg-gray-800 dark:text-gray-500">
                        REMITENTE
                    </th>
                    <th scope="col" colspan="4" class="px-6 py-3 text-center text-xl font-extrabold bg-gray-300 dark:bg-gray-900 dark:text-gray-600">
                        DESTINATARIO
                    </th>
                </tr>
                <tr>
                    <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        Guías
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        Observaciones
                    </th>
                    <th scope="col" class="px-6 py-3  bg-gray-200 dark:bg-gray-800 dark:text-gray-500" >
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-200 dark:bg-gray-800 dark:text-gray-500" >
                        Fecha Creación
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-200 dark:bg-gray-800 dark:text-gray-500" >
                        Empresa
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-200 dark:bg-gray-800 dark:text-gray-500" >
                        Nombre
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-300 dark:bg-gray-900 dark:text-gray-500" >
                        Fecha entrega programada
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-300 dark:bg-gray-900 dark:text-gray-600" >
                        Destinatario
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-300 dark:bg-gray-900 dark:text-gray-600" >
                        Dirección
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-300 dark:bg-gray-900 dark:text-gray-600" >
                        Descripción
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($historicas as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                        <th scope="row" class="px-6 py-4 font-medium  text-gray-900 whitespace-nowrap dark:text-white">
                            {{$item->diligencia->guias}}
                        </th><th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                            {{$item->diligencia->observaciones}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$item->diligencia->identificador}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            {{$item->diligencia->created_at}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            {{$item->diligencia->empresa->name}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            {{$item->diligencia->ubica->user->name}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            {{$item->diligencia->fecha_entrega}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            {{$item->diligencia->name_dest}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            {{$item->diligencia->direccion_dest}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                            {{$item->diligencia->descripcion}}
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
                {{ $historicas->links() }}
            </div>
        </div>
    @endif

    @if ($is_foto)
        <livewire:diligencia.gestion.mens-gestion :elegido="$elegido"/>
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
