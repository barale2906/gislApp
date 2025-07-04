<div>
    @if ($is_modify)
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <h1 class=" m-1 inline-flex">
                Saldos por cuenta
            </h1>
            <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4 rtl:space-x-reverse">
                @foreach ($saldos as $item)
                    <button wire:click.prevent="filban({{$item->banco_id}})" type="button" class="inline-flex items-center p-1 m-1 text-sm font-medium text-blue-900 bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 border border-blue-900 rounded-lg hover:bg-blue-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-blue-500 focus:bg-blue-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-blue-700 dark:focus:bg-blue-700">
                        <i class="fa-solid fa-file-invoice-dollar mr-2"></i> <span class=" font-extrabold uppercase">{{$item->banco->nombre}}</span> ---  Saldo: $ {{number_format($item->saldo, 0, '.', ' ')}}
                    </button>
                @endforeach
            </div>
            @include('include.filtro')

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">

                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('fecha')">
                            FECHA
                            @if ($ordena != 'fecha')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('banco')">
                            BANCO
                            @if ($ordena != 'banco')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('concepto')">
                            CONCEPTO
                            @if ($ordena != 'concepto')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('valor')">
                            VALOR
                            @if ($ordena != 'valor')
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
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('comentario')">
                            COMENTARIO
                            @if ($ordena != 'comentario')
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
                    @foreach ($movimientos as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white">

                                @if (!$item->soporte)
                                    <div class="inline-flex rounded-md shadow-sm" role="group">
                                        @can('fi_movimientosModify')
                                            <button wire:click.prevent="show({{$item->id}},{{2}})" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-cyan-900 bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 border border-cyan-900 rounded-lg hover:bg-cyan-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-cyan-500 focus:bg-cyan-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-cyan-700">
                                                <i class="fa-solid fa-upload"></i>
                                            </button>
                                        @endcan
                                    </div>
                                @else
                                    <a href="{{Storage::url($item->soporte)}}" target="_blank">
                                        <i class="fa-solid fa-download "></i>
                                    </a>
                                @endif

                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 capitalize dark:text-white">
                                {{$item->fecha}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                                {{$item->banco->nombre}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                                {{$item->concepto->concepto}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap text-right dark:text-white capitalize">
                                $ {{number_format($item->valor, 0, ',', '.')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-right whitespace-nowrap text-gray-900 dark:text-white capitalize">
                                $ {{number_format($item->saldo, 0, ',', '.')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                @switch($item->tipo)
                                    @case(0)
                                        Egreso
                                        @break
                                    @case(1)
                                        Ingreso
                                        @break
                                @endswitch
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-justify text-gray-900 dark:text-white capitalize">
                                {{$item->comentario}}
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
                    {{ $movimientos->links() }}
                </div>
            </div>
        </div>
    @endif
    @if ($is_creating)
        <livewire:financiera.movimiento.movimientos-create :elegido="$elegido" :tipo="$tipo"/>
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
                        timer: 1500
                    })
                });
            });
        </script>
    @endpush
</div>
