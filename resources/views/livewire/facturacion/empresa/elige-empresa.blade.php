<div class=" mb-10">
    <h1 class=" text-center font-extrabold mb-3">
        SELECCIONE LA EMPRESA REQUERIDA
    </h1>
    <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4">
        @foreach ($empresas->empresas as $item)

            <div class="w-full max-w-sm bg-white border border-gray-200 rounded-2xl shadow dark:bg-gray-800 dark:border-gray-700">
                <img class="p-8 rounded-t-lg" src="{{$item->logo ? Storage::url($item->logo) : asset('img/logo.jpg')}}" alt="{{$item->name}}" />
                <div class="px-5 pb-5">
                    <h5 class="text-3xl uppercase text-center font-semibold tracking-tight text-gray-900 dark:text-white">
                        {{$item->name}}
                    </h5>
                    <div class="flex items-center justify-between">
                        <span class="text-lg capitalize font-bold text-gray-900 dark:text-white">
                            {{$item->direccion}}
                        </span>
                        @if ($item->id===$this->empresas->empresa_id)
                            <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span> Esta es la empresa actual.
                            </div>
                        @else
                            <a href="" wire:click.prevent="elegir({{$item->id}})" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Seleccionar
                            </a>
                        @endif

                    </div>
                </div>
            </div>

        @endforeach
    </div>

</div>
