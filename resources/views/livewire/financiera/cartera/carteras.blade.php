<div>
    @if ($is_modify)
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            @include('include.filtro')
            <h1 class=" text-center text-2xl font-extrabold">
                Saldo de cartera: ${{number_format($saldo, 0, '.', ',')}} de un total de: ${{number_format($total, 0, '.', ',')}}
            </h1>

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">

                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('nit')">
                            NIT
                            @if ($ordena != 'nit')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('cliente')">
                            CLIENTE
                            @if ($ordena != 'cliente')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('factura_id')">
                            FACTURA
                            @if ($ordena != 'factura_id')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('total')">
                            TOTAL
                            @if ($ordena != 'total')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('descuento')">
                            DESCUENTO
                            @if ($ordena != 'descuento')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('saldo')">
                            SALDO
                            @if ($ordena != 'saldo')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            COMENTARIOS
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('status')">
                            ESTADO
                            @if ($ordena != 'status')
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
                    @foreach ($carteras as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                {{-- <div class="inline-flex rounded-md shadow-sm" role="group">
                                    @can('fi_bancosModify')
                                        <button wire:click.prevent="show({{$item->id}},{{2}})" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-yellow-900 bg-gradient-to-r from-yellow-300 via-yellow-400 to-yellow-500 border border-yellow-900 rounded-lg hover:bg-yellow-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-yellow-500 focus:bg-yellow-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-yellow-700">
                                            <i class="fa-brands fa-creative-commons-sa"></i>
                                        </button>
                                    @endcan
                                </div> --}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$item->nit}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$item->cliente}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                <a href="{{Storage::url($item->factura->ruta)}}" target="_blank">
                                    <i class="fa-solid fa-download "></i> {{$item->factura->numero}}
                                </a>
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 text-right  dark:text-white uppercase">
                                ${{number_format($item->total, 0, '.', ',')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 text-right  dark:text-white capitalize">
                                ${{number_format($item->descuento, 0, '.', ',')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 text-right  dark:text-white capitalize">
                                ${{number_format($item->saldo, 0, '.', ',')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 text-justify  dark:text-white capitalize">
                                {{$item->comentarios}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 text-center  dark:text-white capitalize">
                                @switch($item->status)
                                    @case(1)
                                        Activa
                                        @break
                                    @case(2)
                                        Abonada
                                        @break

                                    @case(3)
                                        Cancelada
                                        @break

                                    @case(4)
                                        Anulada
                                        @break

                                @endswitch
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
                    {{ $carteras->links() }}
                </div>
            </div>
        </div>
    @endif
    {{-- @if ($is_creating)

    @endif --}}

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
                        timer: 1500
                    })
                });
            });
        </script>
    @endpush
</div>
