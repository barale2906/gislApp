<div class=" mt-3">

        <h1 class=" text-center">
            Generar factura, tenga presente que en las siguientes empresas se generaron diligencias y estan sin facturar:
        </h1>
    @foreach ($porfacturar as $item)
        <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full capitalize dark:bg-blue-900 dark:text-blue-300">{{$item->name}}</span>
    @endforeach

    @if ($status===3)

    @endif
    <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4 ring mt-5 mb-5 bg-orange-100 rounded-lg p-5">

        @if (!$is_factura)
            <div class="relative z-0 w-full mb-5 group">
                <select wire:model.live="cliente" id="cliente" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer capitalize">
                    <option>Elegir...</option>
                    @foreach ($clientes as $item)
                        <option value={{$item->id}}>{{$item->name}}</option>
                    @endforeach
                </select>
                <label for="cliente" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Elegir Cliente</label>
                @error('cliente')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
        @endif


        @if ($elementos)
            <div class="relative z-0 w-full mb-5 group">
                {{$elepro}}
                <select wire:model="elepro" id="elepro" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer capitalize">
                    <option>Elegir...</option>
                    @foreach ($elementos as $item)
                        <option value={{$item->producto_id}}>{{$item->name}}</option>
                    @endforeach
                </select>
                <label for="elepro" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Elegir producto</label>
                @error('elepro')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input wire:model="unidades" name="unidades" type="number" id="unidades" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="unidades" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Cantidad</label>
                @error('unidades')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <textarea wire:model="observaciones" name="observaciones" id="observaciones" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required></textarea>
                <label for="observaciones" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Observaciones</label>
                @error('observaciones')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
        @endif
        @if ($is_factura)
            <button type="button" wire:click.prevent="anexar()" class="text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-cyan-600 dark:hover:bg-cyan-700 dark:focus:ring-cyan-800">
                Cargar
            </button>
        @endif

        @if ($idetalle)
            <a href="" wire:click.prevent="modificar()">
                <button type="button"  class="text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-cyan-600 dark:hover:bg-cyan-700 dark:focus:ring-cyan-800">
                    Modificar
                </button>
            </a>
        @endif
        @if(!$idetalle && !$is_factura)
            <a href="" wire:click.prevent="generar()">
                <button type="button"  class="text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-cyan-600 dark:hover:bg-cyan-700 dark:focus:ring-cyan-800">
                    Generar
                </button>
            </a>
        @endif


        <button type="button" wire:click.prevent="$dispatch('cancelando')" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
            Cancelar
        </button>

    </div>

    @if ($is_factura)

        <div class="w-full p-4 text-center bg-green-50 border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white capitalize">{{$factura->empresa}}</h5>

            <div class="p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="stats" role="tabpanel" aria-labelledby="stats-tab">
                <dl class="grid max-w-screen-xl grid-cols-2 gap-6 p-4 mx-auto text-gray-900 sm:grid-cols-3 xl:grid-cols-6 dark:text-white sm:p-8">
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 md:text-2xl text-sm  font-extrabold">{{number_format($factura->numero, 0, '.', ' ')}} - <i class="fa-solid fa-download"></i></dt>
                        <dd class="text-gray-500 dark:text-gray-400">Número</dd>
                    </div>

                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 md:text-2xl text-sm  font-extrabold">$ {{number_format($factura->total, 0, '.', ' ')}}</dt>
                        <dd class="text-gray-500 dark:text-gray-400">Total</dd>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 md:text-2xl text-sm  font-extrabold">$ {{number_format($factura->descuento, 0, '.', ' ')}}</dt>
                        <dd class="text-gray-500 dark:text-gray-400">Descuento</dd>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 md:text-2xl text-sm  font-extrabold">$ {{number_format($factura->total-$factura->descuento, 0, '.', ' ')}}</dt>
                        <dd class="text-gray-500 dark:text-gray-400">Total Neto</dd>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 md:text-2xl text-sm  font-extrabold">{{$factura->fecha}}</dt>
                        <dd class="text-gray-500 dark:text-gray-400">Fecha</dd>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 md:text-2xl text-sm  font-extrabold">{{$factura->vencimiento}}</dt>
                        <dd class="text-gray-500 dark:text-gray-400">Vencimiento</dd>
                    </div>

                </dl>
            </div>
            <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">
                {{$factura->observaciones}}
            </p>
            <div class="w-full p-4 text-center bg-green-50 border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">

                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" colspan="7" class="px-6 py-3 text-center uppercase">
                                datos de la factura @if ($lista->descuento>0)
                                    Descuento aplicado: {{$lista->descuento}} %
                                @endif
                            </th>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3" >
                                CONCEPTO
                            </th>
                            <th scope="col" class="px-6 py-3" >
                                CANTIDAD
                            </th>
                            <th scope="col" class="px-6 py-3" >
                                UNITARIO
                            </th>
                            <th scope="col" class="px-6 py-3" >
                                SUB - TOTAL
                            </th>
                            <th scope="col" class="px-6 py-3" >
                                DESCUENTO TOTAL
                            </th>
                            <th scope="col" class="px-6 py-3" >
                                TOTAL NETO
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detinf as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">

                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$item->concepto}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-center text-gray-900  dark:text-white uppercase">
                                    {{number_format($item->cantidad, 0, '.', ' ')}}
                                </th>
                                <th scope="row" class="px-6 py-4 text-right font-medium text-gray-900  dark:text-white capitalize">
                                    $ {{number_format($item->unitario, 0, '.', ' ')}}
                                </th>
                                <th scope="row" class="px-6 py-4 text-right font-medium text-gray-900  dark:text-white capitalize">
                                    $ {{number_format($item->total, 0, '.', ' ')}}
                                </th>
                                <th scope="row" class="px-6 py-4 text-right font-medium text-gray-900  dark:text-white capitalize">
                                    $ {{number_format($item->descuento_total, 0, '.', ' ')}}
                                </th>
                                <th scope="row" class="px-6 py-4 text-right font-medium text-gray-900  dark:text-white capitalize">
                                    $ {{number_format($item->total-$item->descuento_total, 0, '.', ' ')}}
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4 rtl:space-x-reverse">
                <a href="#" class="w-full sm:w-auto bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                    <svg class="me-3 w-7 h-7" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="apple" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8-18.8-26.9-47.2-41.7-84.7-44.6-35.5-2.8-74.3 20.7-88.5 20.7-15 0-49.4-19.7-76.4-19.7C63.3 141.2 4 184.8 4 273.5q0 39.3 14.4 81.2c12.8 36.7 59 126.7 107.2 125.2 25.2-.6 43-17.9 75.8-17.9 31.8 0 48.3 17.9 76.4 17.9 48.6-.7 90.4-82.5 102.6-119.3-65.2-30.7-61.7-90-61.7-91.9zm-56.6-164.2c27.3-32.4 24.8-61.9 24-72.5-24.1 1.4-52 16.4-67.9 34.9-17.5 19.8-27.8 44.3-25.6 71.9 26.1 2 49.9-11.4 69.5-34.3z"></path></svg>
                    <div class="text-left rtl:text-right">
                        <div class="mb-1 text-xs">Download on the</div>
                        <div class="-mt-1 font-sans text-sm font-semibold">Mac App Store</div>
                    </div>
                </a>
                <a href="#" class="w-full sm:w-auto bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                    <svg class="me-3 w-7 h-7" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="google-play" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M325.3 234.3L104.6 13l280.8 161.2-60.1 60.1zM47 0C34 6.8 25.3 19.2 25.3 35.3v441.3c0 16.1 8.7 28.5 21.7 35.3l256.6-256L47 0zm425.2 225.6l-58.9-34.1-65.7 64.5 65.7 64.5 60.1-34.1c18-14.3 18-46.5-1.2-60.8zM104.6 499l280.8-161.2-60.1-60.1L104.6 499z"></path></svg>
                    <div class="text-left rtl:text-right">
                        <div class="mb-1 text-xs">Get in on</div>
                        <div class="-mt-1 font-sans text-sm font-semibold">Google Play</div>
                    </div>
                </a>
                @if (!$factura->ruta)
                    <div  class="w-full sm:w-auto bg-gray-600 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-100 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-gray-500 dark:hover:bg-gray-400 dark:focus:ring-gray-500">

                        <div class="text-left rtl:text-right">
                            <div class="relative z-0 w-full mb-5 group">
                                <input wire:model="zip" type="file" name="zips" id="zip" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                <label for="zip" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Cargar soporte</label>
                                @error('zip')
                                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                                    </div>
                                @enderror
                            </div>
                        </div>
                        @if ($zip)
                            <i class="fa-solid fa-upload " wire:click.prevent="cargarzip" style="cursor: pointer;"></i>
                        @endif

                    </div>
                @endif

            </div>
        </div>

        <div class="w-full p-4 text-center bg-green-50 border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">

                        </th>
                        <th scope="col" class="px-6 py-3" >
                            CONCEPTO
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            CANTIDAD
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            UNITARIO
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            SUB - TOTAL
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            DESCUENTO UNITARIO
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            DESCUENTO TOTAL
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            TOTAL NETO
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            OBSERVACIONES
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($factura->detalles as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                            <th scope="row" class="px-1 py-2 text-sm text-gray-900 dark:text-white">

                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    @can('fa_facturamodify')
                                        @if ($factura->status===3)
                                            <button wire:click.prevent="show({{$item->id}})" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-900 bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 border border-blue-900 rounded-s-lg hover:bg-blue-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-blue-500 focus:bg-blue-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-blue-700 dark:focus:bg-blue-700">
                                                <i class="fa-solid fa-marker"></i>
                                            </button>
                                            <button wire:click.prevent="delete({{$item}})" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-900 bg-gradient-to-r from-red-300 via-red-400 to-red-500 border border-red-900 rounded-e-lg hover:bg-red-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-red-500 focus:bg-red-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-red-700 dark:focus:bg-red-700">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        @endif
                                    @endcan

                                </div>
                            </th>
                            <th scope="row" class="px-1 py-2 text-sm text-gray-900 dark:text-white">
                                {{$item->concepto}}
                            </th>
                            <th scope="row" class="px-1 py-2 text-sm text-center text-gray-900  dark:text-white uppercase">
                                {{number_format($item->cantidad, 0, '.', ' ')}}
                            </th>
                            <th scope="row" class="px-1 py-2 text-right text-sm text-gray-900  dark:text-white capitalize">
                                $ {{number_format($item->unitario, 0, '.', ' ')}}
                            </th>
                            <th scope="row" class="px-1 py-2 text-right text-sm text-gray-900  dark:text-white capitalize">
                                $ {{number_format($item->total, 0, '.', ' ')}}
                            </th>
                            <th scope="row" class="px-1 py-2 text-right text-sm text-gray-900  dark:text-white capitalize">
                                $ {{number_format($item->descuento, 0, '.', ' ')}}
                            </th>
                            <th scope="row" class="px-1 py-2 text-right text-sm text-gray-900  dark:text-white capitalize">
                                $ {{number_format($item->descuento_total, 0, '.', ' ')}}
                            </th>
                            <th scope="row" class="px-1 py-2 text-right text-sm text-gray-900  dark:text-white capitalize">
                                $ {{number_format($item->total-$item->descuento_total, 0, '.', ' ')}}
                            </th>
                            <th scope="row" class="px-1 py-2 text-justify text-xs text-gray-900  dark:text-white capitalize">
                                {{$item->observaciones}}
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @endif
</div>
