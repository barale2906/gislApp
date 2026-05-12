<div>
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
    @if ($is_editar)
        @if ($diligencias->count()>0)
            <div class="flex items-center justify-end gap-2 mt-2 px-2 text-xs text-gray-500 dark:text-gray-400">
                <button wire:click.prevent="organizar('identificador')" type="button" class="inline-flex items-center gap-1 px-2 py-1 rounded bg-gray-100 dark:bg-gray-700 hover:bg-gray-200">
                    Ordenar por ID
                    @if ($ordena != 'identificador')
                        <i class="fas fa-sort"></i>
                    @else
                        @if ($ordenado=='ASC')
                            <i class="fas fa-sort-up"></i>
                        @else
                            <i class="fas fa-sort-down"></i>
                        @endif
                    @endif
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3 mt-3 px-1">
                @foreach ($diligencias as $item)
                    @php
                        $idCorto = substr($item->identificador, -6);
                        $esSuya = false;
                        $puedeGestionar = false;
                        foreach ($item->mensajeros as $val) {
                            if ($usuconsulta->id === $val->user_id && $val->status !== 4) {
                                $esSuya = true;
                            }
                            if ($usuconsulta->id === $val->user_id && $val->status === 2) {
                                $puedeGestionar = true;
                            }
                        }
                    @endphp

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col">
                        {{-- Header de la card --}}
                        <div class="flex flex-wrap items-center justify-between gap-2 px-3 py-2 bg-gradient-to-r from-slate-100 to-slate-200 dark:from-gray-700 dark:to-gray-800 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] uppercase font-semibold text-gray-500 dark:text-gray-400">ID</span>
                                <span class="font-mono font-bold text-base text-gray-900 dark:text-white tracking-wider">#{{ $idCorto }}</span>
                            </div>
                            <div class="flex items-center gap-1 text-xs text-gray-700 dark:text-gray-300">
                                <i class="fa-regular fa-calendar"></i>
                                <span class="font-medium">{{ $item->fecha_entrega }}</span>
                            </div>
                        </div>

                        {{-- Acciones --}}
                        <div class="flex items-center justify-between flex-wrap gap-2 px-3 py-2 bg-gray-50 dark:bg-gray-900/30 border-b border-gray-200 dark:border-gray-700">
                            <div class="inline-flex flex-wrap items-center gap-2" role="group">
                                @can('di_diligestmensa')
                                    <button wire:click.prevent="recibe({{$item->id}})" type="button" aria-label="Recibir diligencia" class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-blue-900 bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 border border-blue-900 rounded-full hover:bg-blue-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-blue-500 focus:bg-blue-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-blue-700 dark:focus:bg-blue-700">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                    @if ($puedeGestionar)
                                        <button wire:click.prevent="gest({{$item->id}})" type="button" aria-label="Gestionar" class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-green-900 bg-gradient-to-r from-green-300 via-green-400 to-green-500 border border-green-900 rounded-full hover:bg-green-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-green-500 focus:bg-green-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-green-700 dark:focus:bg-green-700">
                                            <i class="fa-solid fa-camera"></i>
                                        </button>
                                    @endif
                                @endcan
                            </div>
                            @if ($esSuya)
                                <span class="inline-flex items-center gap-1 bg-blue-100 text-blue-800 text-[11px] font-semibold px-2.5 py-1 rounded-full dark:bg-blue-900 dark:text-blue-200">
                                    <i class="fa-solid fa-thumbs-up"></i> Suya
                                </span>
                            @endif
                        </div>

                        {{-- Contenido: Destinatario (arriba) / Remitente (abajo) --}}
                        <div class="flex flex-col flex-1">
                            {{-- Destinatario --}}
                            <div class="p-3 bg-emerald-50/50 dark:bg-emerald-900/10 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="flex items-center gap-1 text-[11px] uppercase font-bold text-emerald-700 dark:text-emerald-400 mb-2">
                                    <i class="fa-solid fa-location-dot"></i> Destinatario
                                </h3>
                                <dl class="space-y-1 text-xs text-gray-700 dark:text-gray-300">
                                    <div>
                                        <dt class="text-[10px] uppercase text-gray-500 dark:text-gray-400">Nombre</dt>
                                        <dd class="font-medium capitalize break-words">{{ $item->name_dest }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-[10px] uppercase text-gray-500 dark:text-gray-400">Dirección</dt>
                                        <dd class="font-medium capitalize break-words">{{ $item->direccion_dest }}</dd>
                                    </div>
                                    @if ($item->descripcion)
                                        <div>
                                            <dt class="text-[10px] uppercase text-gray-500 dark:text-gray-400">Descripción</dt>
                                            <dd class="text-justify break-words">{{ $item->descripcion }}</dd>
                                        </div>
                                    @endif
                                    <div>
                                        <dt class="text-[10px] uppercase text-gray-500 dark:text-gray-400">Ciudad</dt>
                                        <dd class="font-medium capitalize break-words">
                                            @if($item->sucursal_dest)
                                                {{ $item->sucursal_dest }} -
                                            @endif
                                            {{ $item->ciudad->name }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>

                            {{-- Remitente: todos los datos en una sola línea --}}
                            <div class="p-3 bg-amber-50/50 dark:bg-amber-900/10">
                                <h3 class="flex items-center gap-1 text-[11px] uppercase font-bold text-amber-700 dark:text-amber-400 mb-1">
                                    <i class="fa-solid fa-paper-plane"></i> Remitente
                                </h3>
                                <p class="text-xs text-gray-700 dark:text-gray-300 capitalize break-words">
                                    <span class="font-medium">{{ $item->empresa->name }}</span>
                                    <span class="text-gray-400 mx-1">·</span>
                                    <span>{{ $item->ubica->user->name }}</span>
                                    <span class="text-gray-400 mx-1">·</span>
                                    <span>{{ $item->ubica->sucursal->name }}</span>
                                    <span class="text-gray-400 mx-1">·</span>
                                    <span>{{ $item->ubica->sucursal->ciudad->name }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-2 p-1 w-auto rounded-lg grid grid-cols-1 sm:grid-cols-2 gap-2 bg-blue-100">
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
            <h1 class=" text-center mt-4">No hay diligencias bajo estos parámetros</h1>
        @endif
    @endif

    @if ($is_historial)
        <div class="mt-3 mx-1 p-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm">
            <h3 class="text-xs font-bold uppercase text-gray-600 dark:text-gray-400 mb-2 flex items-center gap-2">
                <i class="fa-regular fa-calendar-days"></i>
                Período (fecha de entrega programada)
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-end">
                <div>
                    <label for="historialFechaDesde" class="block text-[10px] uppercase font-medium text-gray-500 dark:text-gray-400 mb-1">Desde</label>
                    <input type="date" wire:model.live="historialFechaDesde" id="historialFechaDesde" class="w-full text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white p-2 focus:ring-cyan-500 focus:border-cyan-500" />
                </div>
                <div>
                    <label for="historialFechaHasta" class="block text-[10px] uppercase font-medium text-gray-500 dark:text-gray-400 mb-1">Hasta</label>
                    <input type="date" wire:model.live="historialFechaHasta" id="historialFechaHasta" class="w-full text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white p-2 focus:ring-cyan-500 focus:border-cyan-500" />
                </div>
            </div>
            <p class="mt-2 text-[11px] text-gray-500 dark:text-gray-400">
                Solo se listan diligencias cuya <strong>fecha de entrega</strong> cae en el rango elegido. Al abrir el historial se usa <strong>hoy</strong> por defecto (desde y hasta el mismo día).
            </p>
        </div>

        @if ($dashboardHistorial)
            <div class="mt-3 mx-1 space-y-3">
                <h3 class="text-xs font-bold uppercase text-gray-600 dark:text-gray-400 flex items-center gap-2 px-1">
                    <i class="fa-solid fa-chart-pie"></i> Resumen del período
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <div class="rounded-xl border border-cyan-200 dark:border-cyan-800 bg-gradient-to-br from-cyan-50 to-white dark:from-cyan-900/20 dark:to-gray-800 p-3 shadow-sm">
                        <p class="text-[10px] uppercase font-semibold text-cyan-700 dark:text-cyan-300">Total diligencias</p>
                        <p class="text-2xl font-extrabold text-gray-900 dark:text-white tabular-nums">{{ number_format($dashboardHistorial['total'], 0, ',', '.') }}</p>
                    </div>
                    <div class="rounded-xl border border-sky-200 dark:border-sky-800 bg-gradient-to-br from-sky-50 to-white dark:from-sky-900/20 dark:to-gray-800 p-3 shadow-sm">
                        <p class="text-[10px] uppercase font-semibold text-sky-800 dark:text-sky-300">Total guías</p>
                        <p class="text-2xl font-extrabold text-gray-900 dark:text-white tabular-nums">{{ number_format($dashboardHistorial['total_guias'], 0, ',', '.') }}</p>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-0.5">Suma de guías del período</p>
                    </div>
                    <div class="rounded-xl border border-amber-200 dark:border-amber-800 bg-gradient-to-br from-amber-50 to-white dark:from-amber-900/20 dark:to-gray-800 p-3 shadow-sm">
                        <p class="text-[10px] uppercase font-semibold text-amber-800 dark:text-amber-300">Guías en cero</p>
                        <p class="text-2xl font-extrabold text-gray-900 dark:text-white tabular-nums">{{ number_format($dashboardHistorial['guias_cero'], 0, ',', '.') }}</p>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-0.5">Diligencias con guías ≤ 0</p>
                    </div>
                </div>

                <div class="rounded-xl border border-violet-200 dark:border-violet-800 bg-gradient-to-br from-violet-50 to-white dark:from-violet-900/20 dark:to-gray-800 p-3 shadow-sm">
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                        <h4 class="text-[11px] uppercase font-bold text-violet-800 dark:text-violet-300 flex items-center gap-2">
                            <i class="fa-solid fa-building"></i> Clientes (empresas)
                        </h4>
                        <span class="text-[10px] font-semibold text-violet-700 dark:text-violet-400 bg-violet-100 dark:bg-violet-900/40 px-2 py-0.5 rounded-full">
                            {{ $dashboardHistorial['clientes']->count() }} empresa(s)
                        </span>
                    </div>
                    @if ($dashboardHistorial['clientes']->isNotEmpty())
                        <ul class="divide-y divide-violet-100 dark:divide-gray-700 max-h-56 overflow-y-auto">
                            @foreach ($dashboardHistorial['clientes'] as $fila)
                                <li class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 py-2.5 text-sm">
                                    <span class="text-gray-800 dark:text-gray-200 capitalize font-medium truncate sm:flex-1" title="{{ $fila->cliente }}">{{ $fila->cliente }}</span>
                                    <div class="flex items-center gap-2 shrink-0">
                                        <span class="text-[10px] text-gray-500 dark:text-gray-400">{{ (int) $fila->diligencias }} dilig.</span>
                                        <span class="inline-flex items-center justify-center min-w-[2.5rem] px-2 py-1 rounded-lg text-xs font-extrabold bg-violet-600 text-white dark:bg-violet-500" title="Guías generadas">
                                            {{ number_format((int) $fila->guias, 0, ',', '.') }} guías
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-xs text-gray-500 dark:text-gray-400 py-2">Sin empresas en este período.</p>
                    @endif
                </div>
            </div>
        @endif

        @if ($historicas && $historicas->count() > 0)
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-3">
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
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                            @switch($item->diligencia->status)

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
        @else
            <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-4 px-2">
                No hay diligencias en este período. Ajuste las fechas o amplíe el rango.
            </p>
        @endif
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
