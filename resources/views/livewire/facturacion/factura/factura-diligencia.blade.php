<div>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">

                </th>
                <th scope="col" class="px-6 py-3" >
                    EMPRESA
                </th>
                <th scope="col" class="px-6 py-3" >
                    CANTIDAD
                </th>
                <th scope="col" class="px-6 py-3" >
                    FECHA
                </th>
                <th scope="col" class="px-6 py-3" >
                    DESTINO
                </th>
                <th scope="col" class="px-6 py-3" >
                    OBSERVACIONES
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($diligencias as $item)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                        <div class="inline-flex rounded-md shadow-sm" role="group">
                            <button wire:click.prevent="cargar({{$item->id}},{{$item->empresa_id}})" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-900 bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 border border-blue-900 rounded-s-lg hover:bg-blue-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-blue-500 focus:bg-blue-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-blue-700 dark:focus:bg-blue-700">
                                <i class="fa-solid fa-check"></i>
                            </button>
                            <button wire:click.prevent="desiste({{$item->id}})" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-900 bg-gradient-to-r from-red-300 via-red-400 to-red-500 border border-red-900 rounded-e-lg hover:bg-red-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-red-500 focus:bg-red-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-red-700">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                            <form class="max-w-3xl mx-auto">
                                <div class="relative z-0 w-full mb-5 group">
                                    <select wire:model.live="produ" id="produ" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer capitalize" placeholder=" " required>
                                        <option >Elegir ...</option>
                                        @foreach ($productos as $value)
                                            <option value='{{$value->id}}'>{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="produ" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Elegir Producto</label>
                                    @error('produ')
                                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                                        </div>
                                    @enderror
                                </div>
                            </form>
                        </div>
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white">
                        {{$item->empresa->name}}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                        {{$item->guias}}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white uppercase">
                        {{$item->created_at}}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white uppercase">
                        {{$item->direccion_dest}}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                        {{$item->descripcion}}
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
