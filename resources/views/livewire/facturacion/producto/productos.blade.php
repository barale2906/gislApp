<div>
    @if ($is_modify)
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            @if ($lista>0)
                <h1 class=" text-center font-semibold">
                    Seleccione los productos a agregar a lista
                </h1>
            @else
                @include('include.filtro')
            @endif

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">

                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('name')">
                            NOMBRE
                            @if ($ordena != 'name')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('tipo')">
                            TIPO
                            @if ($ordena != 'tipo')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('descripcion')">
                            DESCRIPCION
                            @if ($ordena != 'descripcion')
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
                    @foreach ($productos as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                            <th scope="row" class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                <div class="inline-flex rounded-md shadow-sm" role="group">

                                    @if ($lista>0)
                                        <button wire:click.prevent="cargar({{$item->id}})" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-indigo-900 bg-gradient-to-r from-indigo-300 via-indigo-400 to-indigo-500 border border-indigo-900 rounded-lg hover:bg-indigo-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-indigo-500 focus:bg-indigo-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-indigo-700">
                                            <i class="fa-solid fa-tags"></i>
                                        </button>
                                    @else
                                        @can('fa_productomodify')
                                            @if ($item->status===1)
                                                <button wire:click.prevent="show({{$item->id}},{{1}})" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-900 bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 border border-blue-900 rounded-s-lg hover:bg-blue-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-blue-500 focus:bg-blue-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-blue-700 dark:focus:bg-blue-700">
                                                    <i class="fa-solid fa-marker"></i>
                                                </button>
                                            @endif
                                            <button wire:click.prevent="show({{$item->id}},{{2}})" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-yellow-900 bg-gradient-to-r from-yellow-300 via-yellow-400 to-yellow-500 border border-yellow-900 rounded-e-lg hover:bg-yellow-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-yellow-500 focus:bg-yellow-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-yellow-700">
                                                <i class="fa-brands fa-creative-commons-sa"></i>
                                            </button>
                                        @endcan
                                    @endif
                                </div>
                            </th>
                            <th scope="row" class="px-2 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$item->name}}
                            </th>

                            <th scope="row" class="px-2 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                @switch($item->tipo)
                                    @case(1)
                                        Entrega por evento
                                        @break
                                    @case(2)
                                        Entrega global
                                        @break
                                @endswitch
                            </th>
                            <th scope="row" class="px-2 py-4 font-medium text-gray-900  dark:text-white capitalize">
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
                    {{ $productos->links() }}
                </div>
            </div>
        </div>
    @endif
    @if ($is_creating)
        <livewire:facturacion.producto.producto-modificar :elegido="$elegido" :tipo="$tipo"/>
    @endif
    @if ($is_producto)
        <livewire:facturacion.producto.producto-cargar :lista="$lista" :producto="$producto"/>
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
