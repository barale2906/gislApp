<div>
    @if ($is_modify)
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            @include('include.filtro')
            <div>
                <table class="text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase ">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-center font-extrabold bg-gray-50 dark:bg-gray-700 dark:text-gray-400 uppercase">
                                Salen
                            </th>
                            <th scope="col" class="px-6 py-3 text-center font-extrabold bg-gray-50 dark:bg-gray-700 dark:text-gray-400 uppercase">
                                Llegan
                            </th>
                            <th scope="col" class="px-6 py-3 text-center font-extrabold bg-gray-50 dark:bg-gray-700 dark:text-gray-400 uppercase">
                                Salen Historial
                            </th>
                            <th scope="col" class="px-6 py-3 text-center font-extrabold bg-gray-50 dark:bg-gray-700 dark:text-gray-400 uppercase">
                                Llegan Historial
                            </th>
                            <th scope="col" class="px-6 py-3 text-center font-extrabold bg-gray-50 dark:bg-gray-700 dark:text-gray-400 uppercase">
                                Cargar Diligencias
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="col" class="px-6 py-3 text-center font-extrabold bg-gray-50 dark:bg-gray-700 dark:text-gray-400 uppercase">
                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    <button type="button" wire:click.prevent="mostrar(1)" class="{{$is_lista===1 ? 'bg-gray-400': 'bg-green-300'}} inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900  border border-gray-900 rounded-s-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                                        <i class="fa-solid fa-paper-plane"></i>
                                        Mias
                                    </button>
                                    <button type="button" wire:click.prevent="mostrar(2)" class="{{$is_lista===2 ? 'bg-gray-400': 'bg-cyan-300'}} inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900  border border-gray-900 rounded-e-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                                        <i class="fa-solid fa-download"></i>
                                        Área
                                    </button>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-center font-extrabold bg-gray-50 dark:bg-gray-700 dark:text-gray-400 uppercase">
                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    <button type="button" wire:click.prevent="mostrar(3)" class="{{$is_lista===3 ? 'bg-gray-400': 'bg-green-400'}} inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900  border border-gray-900 rounded-s-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                                        <i class="fa-solid fa-paper-plane"></i>
                                        Mias
                                    </button>
                                    <button type="button" wire:click.prevent="mostrar(4)" class="{{$is_lista===4 ? 'bg-gray-400': 'bg-cyan-400'}} inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900  border border-gray-900 rounded-e-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                                        <i class="fa-solid fa-download"></i>
                                        Área
                                    </button>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-center font-extrabold bg-gray-50 dark:bg-gray-700 dark:text-gray-400 uppercase">
                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    <button type="button" wire:click.prevent="mostrar(5)" class="{{$is_lista===5 ? 'bg-gray-400': 'bg-green-500'}} inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900  border border-gray-900 rounded-s-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                                        <i class="fa-solid fa-paper-plane"></i>
                                        Mias
                                    </button>
                                    <button type="button" wire:click.prevent="mostrar(6)" class="{{$is_lista===6 ? 'bg-gray-400': 'bg-cyan-500'}} inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900  border border-gray-900 rounded-e-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                                        <i class="fa-solid fa-download"></i>
                                        Área
                                    </button>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-center font-extrabold bg-gray-50 dark:bg-gray-700 dark:text-gray-400 uppercase">
                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    <button type="button" wire:click.prevent="mostrar(7)" class="{{$is_lista===7 ? 'bg-gray-400': 'bg-green-600'}} inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900  border border-gray-900 rounded-s-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                                        <i class="fa-solid fa-paper-plane"></i>
                                        Mias
                                    </button>
                                    <button type="button" wire:click.prevent="mostrar(8)" class="{{$is_lista===8 ? 'bg-gray-400': 'bg-cyan-600'}} inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900  border border-gray-900 rounded-e-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                                        <i class="fa-solid fa-download"></i>
                                        Área
                                    </button>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-center font-extrabold bg-gray-50 dark:bg-gray-700 dark:text-gray-400 uppercase">
                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    <button type="button" wire:click.prevent="impor" class="bg-green-400 inline-flex items-center px-4 py-2 text-sm font-medium text-green-900  border border-green-900 rounded-lg hover:bg-green-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-green-500 focus:bg-green-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-green-700 dark:focus:bg-green-700">
                                        <i class="fa-solid fa-file-excel"></i>
                                    </button>
                                </div>
                            </th>
                        </tr>
                    </tbody>
                </table>
                @if ($diligencias->count()>0)

                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase ">
                            <tr>
                                <th scope="col" colspan="13" class="px-6 py-3 text-2xl text-center font-extrabold bg-gray-50 dark:bg-gray-700 dark:text-gray-400 uppercase">
                                    @switch($is_lista)
                                        @case(1)
                                            enviadas por mi
                                            @break
                                        @case(2)
                                            enviadas por el área: {{$ubica->area->name}} de la sucursal: {{$ubica->sucursal->name}}
                                            @break
                                        @case(3)
                                            llegan para mi
                                            @break
                                        @case(4)
                                            llegan para el área: {{$ubica->area->name}} de la sucursal: {{$ubica->sucursal->name}}
                                            @break
                                        @case(5)
                                            historial de mis envios
                                            @break
                                        @case(6)
                                            Historial envios área: {{$ubica->area->name}} de la sucursal: {{$ubica->sucursal->name}}
                                            @break
                                        @case(7)
                                            historial para mi
                                            @break
                                        @case(8)
                                            Historial envios para el área: {{$ubica->area->name}} de la sucursal: {{$ubica->sucursal->name}}
                                            @break
                                    @endswitch
                                </th>
                            </tr>
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center font-extrabold bg-gray-50 dark:bg-gray-700 dark:text-gray-400">

                                </th>
                                <th scope="col" colspan="6" class="px-6 py-3 text-center text-xl font-extrabold bg-gray-200 dark:bg-gray-800 dark:text-gray-500">
                                    REMITENTE
                                </th>
                                <th scope="col" colspan="6" class="px-6 py-3 text-center text-xl font-extrabold bg-gray-300 dark:bg-gray-900 dark:text-gray-600">
                                    DESTINATARIO
                                </th>
                            </tr>
                            <tr>
                                <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">

                                </th>
                                <th scope="col" class="px-6 py-3  bg-gray-200 dark:bg-gray-800 dark:text-gray-500" style="cursor: pointer;" wire:click="organizar('id')">
                                    ID
                                    @if ($ordena != 'id')
                                        <i class="fas fa-sort"></i>
                                    @else
                                        @if ($ordenado=='ASC')
                                            <i class="fas fa-sort-up"></i>
                                        @else
                                            <i class="fas fa-sort-down"></i>
                                        @endif
                                    @endif
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-200 dark:bg-gray-800 dark:text-gray-500" style="cursor: pointer;" wire:click="organizar('created_at')">
                                    Fecha
                                    @if ($ordena != 'created_at')
                                        <i class="fas fa-sort"></i>
                                    @else
                                        @if ($ordenado=='ASC')
                                            <i class="fas fa-sort-up"></i>
                                        @else
                                            <i class="fas fa-sort-down"></i>
                                        @endif
                                    @endif
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-200 dark:bg-gray-800 dark:text-gray-500" >
                                    Empresa
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-200 dark:bg-gray-800 dark:text-gray-500" >
                                    Nombre
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-200 dark:bg-gray-800 dark:text-gray-500" >
                                    Sucursal
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-200 dark:bg-gray-800 dark:text-gray-500" >
                                    Área
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
                                <th scope="col" class="px-6 py-3 bg-gray-300 dark:bg-gray-900 dark:text-gray-600" style="cursor: pointer;" wire:click="organizar('sucursal_dest')">
                                    Sucursal
                                    @if ($ordena != 'sucursal_dest')
                                        <i class="fas fa-sort"></i>
                                    @else
                                        @if ($ordenado=='ASC')
                                            <i class="fas fa-sort-up"></i>
                                        @else
                                            <i class="fas fa-sort-down"></i>
                                        @endif
                                    @endif
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-300 dark:bg-gray-900 dark:text-gray-600" style="cursor: pointer;" wire:click="organizar('area_dest')">
                                    Área
                                    @if ($ordena != 'area_dest')
                                        <i class="fas fa-sort"></i>
                                    @else
                                        @if ($ordenado=='ASC')
                                            <i class="fas fa-sort-up"></i>
                                        @else
                                            <i class="fas fa-sort-down"></i>
                                        @endif
                                    @endif
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-300 dark:bg-gray-900 dark:text-gray-600" style="cursor: pointer;" wire:click="organizar('direccion_dest')">
                                    Dirección
                                    @if ($ordena != 'direccion_dest')
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
                                    Ciudad
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
                                            @can('di_diligenciaModify')
                                                <button wire:click.prevent="show({{$item->id}},{{1}})" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-900 bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 border border-blue-900 rounded-s-lg hover:bg-blue-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-blue-500 focus:bg-blue-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-blue-700 dark:focus:bg-blue-700">
                                                    <i class="fa-solid fa-inbox"></i>
                                                </button>
                                                @if ($item->status===1 && $item->ubica->user->id===Auth::user()->id)
                                                    <button wire:click.prevent="show({{$item->id}},{{2}})" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-900 bg-gradient-to-r from-red-300 via-red-400 to-red-500 border border-red-900 rounded-e-lg hover:bg-red-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-red-500 focus:bg-red-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-red-700">
                                                        <i class="fa-solid fa-circle-xmark"></i>
                                                    </button>
                                                @endif
                                            @endcan


                                        </div>
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{$item->id}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                        {{$item->created_at}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                        {{$item->empresa->name}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                        {{$item->ubica->user->name}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                        {{$item->ubica->sucursal->name}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                        {{$item->ubica->area->name}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                        {{$item->name_dest}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                        {{$item->sucursal_dest}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                        {{$item->area_dest}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                        {{$item->direccion_dest}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                        {{$item->ciudad->name}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
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
    @if ($is_cargar)
        <livewire:diligencia.diligencia.diligencia-importar/>
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
                        timer: 2000
                    })
                });
            });
        </script>
    @endpush
</div>
