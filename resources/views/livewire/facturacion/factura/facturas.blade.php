<div>
    @if ($is_modify)
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            @include('include.filtro')

            <div class="mt-3 mx-1 p-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm">
                <h3 class="text-xs font-bold uppercase text-gray-600 dark:text-gray-400 mb-2 flex items-center gap-2">
                    <i class="fa-regular fa-calendar-days"></i>
                    Período (fecha de facturación)
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-end">
                    <div>
                        <label for="facturaFechaDesde" class="block text-[10px] uppercase font-medium text-gray-500 dark:text-gray-400 mb-1">Desde</label>
                        <input type="date" wire:model.live="facturaFechaDesde" id="facturaFechaDesde" class="w-full text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white p-2 focus:ring-cyan-500 focus:border-cyan-500" />
                    </div>
                    <div>
                        <label for="facturaFechaHasta" class="block text-[10px] uppercase font-medium text-gray-500 dark:text-gray-400 mb-1">Hasta</label>
                        <input type="date" wire:model.live="facturaFechaHasta" id="facturaFechaHasta" class="w-full text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white p-2 focus:ring-cyan-500 focus:border-cyan-500" />
                    </div>
                </div>
                <p class="mt-2 text-[11px] text-gray-500 dark:text-gray-400">
                    Se listan facturas cuya <strong>fecha</strong> está en el rango. Por defecto: <strong>hoy</strong>. Las <strong>en proceso</strong> aparecen primero.
                    El <strong>valor facturado (neto)</strong> del resumen solo suma facturas <strong>enviadas</strong> y <strong>pagadas</strong> (no en proceso ni anuladas).
                </p>
            </div>

            @if ($dashboardFacturas)
                <div class="mt-3 mx-1 space-y-3">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 px-1">
                        <h3 class="text-xs font-bold uppercase text-gray-600 dark:text-gray-400 flex items-center gap-2">
                            <i class="fa-solid fa-chart-pie"></i> Resumen del período
                        </h3>
                        @can('fa_facturamodify')
                            <button type="button" wire:click="exportarDashboardExcel" wire:loading.attr="disabled" class="inline-flex items-center justify-center gap-2 rounded-lg border border-emerald-600 bg-emerald-600 px-3 py-1.5 text-[11px] font-semibold text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 disabled:opacity-60 dark:border-emerald-500 dark:bg-emerald-700 dark:hover:bg-emerald-600">
                                <span wire:loading.remove wire:target="exportarDashboardExcel"><i class="fa-regular fa-file-excel"></i> Descargar Excel</span>
                                <span wire:loading wire:target="exportarDashboardExcel"><i class="fa-solid fa-spinner fa-spin"></i> Generando…</span>
                            </button>
                        @endcan
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-2">
                        <div class="rounded-xl border border-emerald-200 dark:border-emerald-800 bg-gradient-to-br from-emerald-50 to-white dark:from-emerald-900/20 dark:to-gray-800 p-3 shadow-sm">
                            <p class="text-[10px] uppercase font-semibold text-emerald-800 dark:text-emerald-300">Valor facturado (neto)</p>
                            <p class="text-xl font-extrabold text-gray-900 dark:text-white tabular-nums">$ {{ number_format($dashboardFacturas['valor_facturado'], 0, ',', '.') }}</p>
                            <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-0.5">Total − descuento: solo enviadas y pagadas; sin en proceso ni anuladas</p>
                        </div>
                        <div class="rounded-xl border border-cyan-200 dark:border-cyan-800 bg-gradient-to-br from-cyan-50 to-white dark:from-cyan-900/20 dark:to-gray-800 p-3 shadow-sm">
                            <p class="text-[10px] uppercase font-semibold text-cyan-700 dark:text-cyan-300">Facturas en período</p>
                            <p class="text-2xl font-extrabold text-gray-900 dark:text-white tabular-nums">{{ number_format($dashboardFacturas['total_facturas'], 0, ',', '.') }}</p>
                        </div>
                        <div class="rounded-xl border border-violet-200 dark:border-violet-800 bg-gradient-to-br from-violet-50 to-white dark:from-violet-900/20 dark:to-gray-800 p-3 shadow-sm">
                            <p class="text-[10px] uppercase font-semibold text-violet-800 dark:text-violet-300">Empresas con factura</p>
                            <p class="text-2xl font-extrabold text-gray-900 dark:text-white tabular-nums">{{ number_format($dashboardFacturas['empresas_con_facturas'], 0, ',', '.') }}</p>
                        </div>
                        <div class="rounded-xl border border-rose-200 dark:border-rose-800 bg-gradient-to-br from-rose-50 to-white dark:from-rose-900/20 dark:to-gray-800 p-3 shadow-sm">
                            <p class="text-[10px] uppercase font-semibold text-rose-800 dark:text-rose-300">Facturas anuladas</p>
                            <p class="text-2xl font-extrabold text-gray-900 dark:text-white tabular-nums">{{ number_format($dashboardFacturas['facturas_anuladas_cantidad'], 0, ',', '.') }}</p>
                            <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-0.5">Monto ref. (no suma al neto): $ {{ number_format($dashboardFacturas['facturas_anuladas_monto_referencia'], 0, ',', '.') }}</p>
                        </div>
                    </div>

                    @if ($dashboardFacturas['por_empresa']->isNotEmpty())
                        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-3 shadow-sm max-w-3xl mx-auto w-full">
                            <p class="text-[10px] uppercase font-bold text-gray-600 dark:text-gray-400 mb-3 text-center">Detalle por empresa</p>
                            <p class="text-[10px] text-gray-500 dark:text-gray-400 text-center -mt-2 mb-2">Importe y listado de N°: solo enviadas y pagadas</p>
                            <ul class="divide-y divide-gray-100 dark:divide-gray-700 max-h-64 overflow-y-auto text-sm">
                                @foreach ($dashboardFacturas['por_empresa'] as $fila)
                                    <li class="py-3 flex flex-col items-center text-center gap-1.5 px-2">
                                        <span class="font-semibold text-gray-900 dark:text-white capitalize">{{ $fila->cliente }}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ (int) $fila->cantidad }} factura(s)</span>
                                        <span class="text-xs text-gray-600 dark:text-gray-300 max-w-full break-words" title="{{ $fila->numeros }}">
                                            <span class="font-medium">N°:</span> {{ $fila->numeros ?: '—' }}
                                        </span>
                                        <span class="text-sm font-bold text-emerald-700 dark:text-emerald-400">$ {{ number_format((float) $fila->total_neto, 0, ',', '.') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($dashboardFacturas['facturas_anuladas']->isNotEmpty())
                        <div class="rounded-xl border border-rose-200 dark:border-rose-800 bg-white dark:bg-gray-800 p-3 shadow-sm max-w-4xl mx-auto w-full">
                            <p class="text-[10px] uppercase font-bold text-rose-800 dark:text-rose-300 mb-3 text-center flex items-center justify-center gap-2">
                                <i class="fa-solid fa-ban"></i> Reporte de facturas anuladas (estados 4 y 5)
                            </p>
                            <div class="overflow-x-auto">
                                <table class="w-full text-xs text-left text-gray-600 dark:text-gray-300">
                                    <thead class="text-[10px] uppercase bg-rose-50 dark:bg-rose-900/30 text-rose-900 dark:text-rose-200">
                                        <tr>
                                            <th class="px-2 py-2">Cliente</th>
                                            <th class="px-2 py-2">Fecha</th>
                                            <th class="px-2 py-2">Número</th>
                                            <th class="px-2 py-2 text-right">Neto</th>
                                            <th class="px-2 py-2">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                        @foreach ($dashboardFacturas['facturas_anuladas'] as $fa)
                                            @php
                                                $neto = (float) $fa->total - (float) $fa->descuento;
                                                $numLabel = $fa->numero !== null && $fa->numero !== '' ? (string) $fa->numero : 'P-' . $fa->id;
                                                $estLabel = (int) $fa->status === 4 ? 'Anulada (4)' : 'Anulada (5)';
                                            @endphp
                                            <tr class="hover:bg-rose-50/50 dark:hover:bg-rose-900/10">
                                                <td class="px-2 py-2 capitalize font-medium">{{ $fa->cliente }}</td>
                                                <td class="px-2 py-2 tabular-nums whitespace-nowrap">{{ $fa->fecha ? \Illuminate\Support\Carbon::parse($fa->fecha)->format('d/m/Y') : '—' }}</td>
                                                <td class="px-2 py-2 tabular-nums">{{ $numLabel }}</td>
                                                <td class="px-2 py-2 text-right tabular-nums">$ {{ number_format($neto, 0, ',', '.') }}</td>
                                                <td class="px-2 py-2">{{ $estLabel }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            @if ($facturas->count() > 0)
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-3">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">

                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('numero')">
                            NÚMERO
                            @if ($ordena != 'numero')
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
                            EMPRESA
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
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('vencimiento')">
                            VENCE
                            @if ($ordena != 'vencimiento')
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
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('observaciones')">
                            OBSERVACIONES
                            @if ($ordena != 'observaciones')
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
                    @foreach ($facturas as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    @can('fa_facturamodify')
                                        <button wire:click.prevent="show({{$item->id}},{{1}})" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-900 bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 border border-blue-900 rounded-s-lg hover:bg-blue-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-blue-500 focus:bg-blue-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-blue-700 dark:focus:bg-blue-700">
                                            <i class="fa-solid fa-marker"></i>
                                        </button>
                                    @endcan

                                    @switch($item->status)

                                        @case(1)
                                            <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">En Proceso</span>
                                            @break
                                        @case(2)
                                            <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Enviada</span>
                                            @break
                                        @case(3)
                                            <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-900 dark:text-blue-300">Pagada</span>
                                            @break
                                        @case(4)
                                            <span class="bg-orange-100 text-orange-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-orange-900 dark:text-orange-300">Anulada</span>
                                            @break
                                        @case(5)
                                            <span class="bg-orange-100 text-orange-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-orange-900 dark:text-orange-300">Anulada</span>
                                            @break
                                    @endswitch

                                </div>
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$item->numero}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$item->cliente}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white uppercase">
                                {{$item->fecha}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white uppercase">
                                {{$item->vencimiento}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-right text-gray-900  dark:text-white uppercase">
                                $ {{number_format($item->total, 0, ',', '.')}}
                            </th>
                            <th scope="row" class="px-6 py-4 text-right font-medium text-gray-900  dark:text-white capitalize">
                                $ {{number_format($item->descuento, 0, ',', '.')}}
                            </th>

                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                                {{$item->observaciones}}
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
                    {{ $facturas->links() }}
                </div>
            </div>
            @else
            <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-4 px-2 py-6">
                No hay facturas en este período. Ajuste las fechas o el criterio de búsqueda.
            </p>
            @endif
        </div>
    @endif
    @if ($is_creating)
        <livewire:facturacion.factura.factura-gen />
    @endif

    @if ($is_modificar)
        <livewire:facturacion.factura.factura-item :factura="$factura"/>
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
