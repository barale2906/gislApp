<div>

    <h1 class=" text-center text-2xl uppercase font-extrabold">
        @if ($tipo===0)
            Crear Pago de Nómina
        @endif
        @if ($tipo===1)
            Ver / Editar Pago de Nómina
        @endif
        @if ($tipo===2)
            Cambiar status Pago de Nómina
        @endif
    </h1>

    @if ($tipo!==2)
        <form class="max-w-3xl mx-auto">

            @if ($user_id===0)

                <div class="relative z-0 w-full mb-5 group">
                    <select wire:model.live="anio" id="anio" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer capitalize">
                        <option>Elegir...</option>
                        @for ($i = 0; $i < 5; $i++)
                            <option value={{$eleanios+$i}}>{{$eleanios+$i}}</option>
                        @endfor
                    </select>
                    <label for="anio" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        Seleccione año aplicable
                    </label>
                    @error('anio')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <select wire:model.live="mes" id="mes" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer capitalize">
                        <option>Elegir...</option>
                        @for ($i = 0; $i < 12; $i++)
                            <option value={{$meses[$i]}}>{{$meses[$i]}}</option>
                        @endfor
                    </select>
                    <label for="mes" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        Seleccione mes aplicable
                    </label>
                    @error('mes')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input wire:model.live="dias" name="dias" id="dias" type="number" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="dias" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Días laborados</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <select wire:model.live="planta_id" id="planta_id" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer capitalize">
                        <option>Elegir...</option>
                        @foreach ($empleados as $item)
                            <option value={{$item->id}}>{{$item->nombre}}</option>
                        @endforeach
                    </select>
                    <label for="planta_id" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        Seleccione empleado
                    </label>
                    @error('planta_id')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
                <button type="button" wire:click.prevent="creardevengado" class="text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-cyan-600 dark:hover:bg-cyan-700 dark:focus:ring-cyan-800 mb-4">
                    Cargar Básico
                </button>
            @endif

            @if ($actual && $valorapagar)
            <div class="w-full bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 mt-3 mb-3">
                <ul class="flex flex-wrap font-extrabold text-4xl text-center text-gray-500 border-b border-gray-200 rounded-t-lg bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800 " id="defaultTab" data-tabs-toggle="#defaultTabContent" role="tablist">
                    <li class="me-2">
                        <button id="statistics-tab" data-tabs-target="#statistics" type="button" role="tab" aria-controls="statistics" aria-selected="false" class="inline-block p-4 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                            Datos del pago para: <span class=" uppercase"> {{$actual->nombre}}</span> del mes de: {{$actual->mes}} del año: {{$actual->anio}}
                        </button>
                    </li>
                    @if ($actual->status===1)
                        <li class="me-2">
                            <button id="statistics-tab" data-tabs-target="#statistics" type="button" role="tab" aria-controls="statistics" aria-selected="false" class="inline-block p-4 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                                Soporte de pago: <a href="{{Storage::url($actual->soporte_pago)}}" target="_blank">
                                    <i class="fa-solid fa-download "></i>
                                </a>
                            </button>
                        </li>
                    @endif

                </ul>
                <div id="defaultTabContent">
                    <div class="p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="statistics" role="tabpanel" aria-labelledby="statistics-tab">
                        <dl class="grid max-w-screen-xl grid-cols-2 gap-8 p-4 mx-auto text-gray-900 sm:grid-cols-3 xl:grid-cols-3 dark:text-white sm:p-8">
                            <div class="flex flex-col">
                                <dt class="mb-2 text-3xl font-extrabold">
                                    $ {{number_format($valorapagar, 0, ',', '.')}}
                                </dt>
                                <dd class="text-gray-500 dark:text-gray-400">
                                    Valor a Pagar
                                </dd>
                            </div>
                            <div class="flex flex-col">
                                <dt class="mb-2 text-3xl font-extrabold">
                                    $ {{number_format($actual->total_empleado, 0, ',', '.')}}
                                </dt>
                                <dd class="text-gray-500 dark:text-gray-400">
                                    Descuentos
                                </dd>
                            </div>
                            <div class="flex flex-col">
                                <dt class="mb-2 text-3xl font-extrabold">
                                    $ {{number_format($adicionales->sum('total'), 0, ',', '.')}}
                                </dt>
                                <dd class="text-gray-500 dark:text-gray-400">
                                    Total adicionales
                                </dd>
                            </div>
                        </dl>

                        @if ($adicionales && $adicionales->count()>0)
                            <div class="overflow-hidden rounded-lg shadow-lg border border-gray-300 mb-5">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 bg-green-200">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" colspan="4" class="px-6 py-3 border-b border-gray-300 text-center text-xl">
                                                CONSOLIDADO ADICIONALES
                                            </th>
                                        </tr>
                                        <tr>
                                            <th scope="col" class="px-6 py-3 border-b border-gray-300">
                                                CONCEPTO
                                            </th>
                                            <th scope="col" class="px-6 py-3 border-b border-gray-300" >
                                                CANTIDAD
                                            </th>
                                            <th scope="col" class="px-6 py-3 border-b border-gray-300" >
                                                UNITARIO
                                            </th>
                                            <th scope="col" class="px-6 py-3 border-b border-gray-300" >
                                                TOTAL
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($adicionaleagrupados as $value)
                                            <tr class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 last:border-b-0">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white uppercase border-r border-gray-200">
                                                    {{$value->adicional->nombre}}
                                                </th>
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize border-r border-gray-200 text-center">
                                                    {{number_format($value->total_cantidad, 0, ',', '.')}}
                                                </th>
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize border-r border-gray-200 text-right">
                                                    $ {{number_format($value->unitario, 0, ',', '.')}}
                                                </th>
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize text-right">
                                                    $ {{number_format($value->total_valor, 0, ',', '.')}}
                                                </th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">

                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            CONCEPTO
                                        </th>
                                        <th scope="col" class="px-6 py-3" >
                                            VALOR UNITARIO
                                        </th>
                                        <th scope="col" class="px-6 py-3" >
                                            CANTIDAD
                                        </th>
                                        <th scope="col" class="px-6 py-3" >
                                            TOTAL
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            DETALLE
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($adicionales as $item)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                                    @if ($actual->status===0)
                                                        @can('hu_contratosModify')
                                                            <button wire:click.prevent="eliminAdicional({{$item->id}},{{1}})" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-900 bg-gradient-to-r from-red-300 via-red-400 to-red-500 border border-red-900 rounded-lg hover:bg-red-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-red-500 focus:bg-red-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-red-700 dark:focus:bg-red-700">
                                                                <i class="fa-solid fa-marker"></i>
                                                            </button>
                                                        @endcan
                                                    @endif
                                                </div>
                                            </th>
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white uppercase">
                                                {{$item->adicional->nombre}}
                                            </th>
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                                {{number_format($item->unitario, 0, ',', '.')}}
                                            </th>
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                                {{number_format($item->cantidad, 0, ',', '.')}}
                                            </th>
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                                {{number_format($item->total, 0, ',', '.')}}
                                            </th>
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                                {{$item->detalle}}
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class=" capitalize">
                                No tiene valores adicionales cargados
                            </p>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            @if ($actual && $valorapagar && $actual->status===0)

                <div class="w-full bg-blue-400 border border-blue-800 border-spacing-8 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 mt-3 mb-3 p-8">
                    <h2 class=" font-semibold text-center uppercase">
                        Cargar valores adicionales.
                    </h2>
                    <div class="relative z-0 w-full m-5 group">
                        <select wire:model.live="adicional_id" id="adicional_id" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer capitalize">
                            <option>Elegir...</option>
                            @foreach ($concepadicionales as $item)
                                <option value={{$item->id}}><span class=" uppercase font-bold">{{$item->nombre}}: </span> {{$item->descripcion}}</option>
                            @endforeach
                        </select>
                        <label for="adicional_id" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            Seleccione adicional a aplicar
                        </label>
                    </div>
                    @if ($adicional_id>0)
                        <div class="relative z-0 w-full m-5 group">
                            <textarea wire:model.live="detalle"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required
                                name="detalle"
                                id="detalle" >
                            </textarea>
                            <label for="detalle" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Observaciones</label>
                            @error('detalle')
                                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                                </div>
                            @enderror
                        </div>
                        <div class="relative z-0 w-full m-5 group">
                            <input wire:model.live="cantidad" name="cantidad" id="cantidad" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="cantidad" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Cantidad</label>
                        </div>
                        @if ($cantidad>0)
                            <button type="button" wire:click.prevent="calculadicional" class="text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-cyan-600 dark:hover:bg-cyan-700 dark:focus:ring-cyan-800 m-5">
                                Carga Adicional
                            </button>
                        @endif
                    @endif
                </div>

                <div class="w-full bg-green-200 border border-green-800 border-spacing-8 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 mt-3 mb-3 p-8">
                    <h2 class=" font-semibold text-center uppercase">
                        cargar diligencias
                    </h2>

                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    FECHA ENTREGA
                                </th>
                                <th scope="col" class="px-6 py-3" >
                                    GUÍAS
                                </th>
                                <th scope="col" class="px-6 py-3" >
                                    CLIENTE
                                </th>
                                <th scope="col" class="px-6 py-3" >

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($diligencias as $value)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white uppercase">
                                        {{$value->diligencia->fecha_entrega}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                        {{number_format($value->diligencia->guias, 0, ',', '.')}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                        {{$value->diligencia->empresa->name}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                        <select wire:model.live="adicional_id" id="adicional_id" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer capitalize">
                                            <option>Elegir...</option>
                                            @foreach ($concepadicionales as $item)
                                                <option value={{$item->id}}><span class=" uppercase font-bold">{{$item->nombre}}: </span> {{$item->descripcion}}</option>
                                            @endforeach
                                        </select>

                                    </th>
                                    <th scope="row" class="p-3 font-medium text-gray-900  dark:text-white capitalize">
                                        <button type="button" wire:click.prevent="recibeDiligencia({{$value->diligencia_id}})" class="text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-cyan-600 dark:hover:bg-cyan-700 dark:focus:ring-cyan-800 m-5">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="w-full bg-green-200 border border-green-800 border-spacing-8 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 mt-3 mb-3 p-8">
                    <h2 class=" text-center font-extrabold uppercase">
                        REgistro de pago
                    </h2>
                    <div class="relative z-0 w-full mb-5 group">
                        <select wire:model.live="banco_id" id="banco_id" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer capitalize">
                            <option>Elegir...</option>
                            @foreach ($bancos as $item)
                                <option value={{$item->id}}>{{$item->nombre}}</option>
                            @endforeach
                        </select>
                        <label for="banco_id" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Banco</label>
                        @error('banco_id')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <select wire:model.live="concepto_id" id="concepto_id" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer capitalize">
                            <option>Elegir...</option>
                            @foreach ($conceptos as $item)
                                <option value={{$item->id}}>{{$item->concepto}}</option>
                            @endforeach
                        </select>
                        <label for="concepto_id" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Concepto</label>
                        @error('concepto_id')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="file" wire:model.live="foto" accept="image/jpg, image/bmp, image/png, image/jpeg, application/pdf" name="foto" id="foto" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                        <label for="foto" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Cargue Soporte</label>

                        <div wire:loading wire:target="foto" class="text-center text-xl font-extrabold text-orange-500 uppercase">Cargando</div>
                    </div>

                    <div class="relative z-0 w-full mb-5 group">
                        <input type="date" wire:model.live="fecha_pago" name="fecha_pago" id="fecha_pago" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                        <label for="fecha_pago" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Fecha de Pago</label>
                    </div>
                    @if ($foto && $fecha_pago)
                        <button type="button" wire:click.prevent="registraPago" class="text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-cyan-600 dark:hover:bg-cyan-700 dark:focus:ring-cyan-800">
                            Registrar pago y cerrar
                        </button>
                    @endif
                </div>



            @endif



            <button type="button" wire:click.prevent="$dispatch('cancelando')" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                Cancelar
            </button>
        </form>

    @endif

    @if ($tipo===2)
        @include('include.inactivar')
    @endif

</div>