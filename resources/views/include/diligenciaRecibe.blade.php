<section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
        <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-8 md:p-12 mb-8">
            <a href="" class="bg-blue-100 text-blue-800 text-xl font-medium inline-flex items-center px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-blue-400 mb-2">
                Diligencia <i class="fa-solid fa-hashtag"></i>
                {{$actual->id}}
            </a>
            <h1 class="text-gray-900 dark:text-white text-3xl md:text-5xl font-extrabold mb-2 capitalize">
                para: {{$actual->name_dest}}
            </h1>
            <p class="text-lg font-normal text-gray-500 dark:text-gray-400 mb-6">
                Para la dirección:
                <span class=" capitalize font-extrabold text-xl">{{$actual->direccion_dest}}</span>
                @if ($actual->area_dest)
                    del área:
                    <span class=" capitalize font-extrabold text-xl">{{$actual->area_dest}}</span>
                @endif
                en la ciudad de:
                <span class=" capitalize font-extrabold text-xl">{{$actual->ciudad->name}}</span>
            </p>
            <p class="text-lg font-normal text-gray-500 dark:text-gray-400 mb-6">
                Enviado por:
                <span class=" uppercase font-extrabold text-xl">{{$actual->ubica->user->name}}</span>
                el día:
                <span class=" uppercase font-extrabold text-xl">{{$actual->created_at}}</span>
                desde la sucursal:
                <span class=" uppercase font-extrabold text-xl">{{$actual->ubica->sucursal->name}}</span>
                del área:
                <span class=" uppercase font-extrabold text-xl">{{$actual->ubica->area->name}}</span>
            </p>
            <p class="text-lg font-normal text-gray-500 dark:text-gray-400 mb-6">
                Descripción: {{$actual->descripcion}}
            </p>
            @if ($actual->ubica->user->id === Auth::user()->id || $actual->dest_id === Auth::user()->id)
                <p class="text-lg font-normal text-gray-500 dark:text-gray-400 mb-6">
                    Detalle: {{$actual->detalle}}
                </p>
            @endif
            @if ($actual->fecha_recepcion)
                <p class="text-lg font-normal text-gray-500 dark:text-gray-400 mb-6">
                    Recibida el: {{$actual->fecha_recepcion}}
                </p>
            @endif
            <a href="" wire:click.prevent="$dispatch('cancelando')" class="inline-flex justify-center items-center py-2.5 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                <i class="fa-solid fa-circle-left"></i> Volver
            </a>
            @if ($actual->status<=3)
                <a href="" wire:click.prevent="registroRecibir" class="inline-flex justify-center items-center py-2.5 px-5 text-base font-medium text-center text-white rounded-lg bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-900">
                    <i class="fa-solid fa-inbox"></i> Recibir / Cerrar Diligencia
                </a>
            @endif


            @if ($is_recibir)
                <div class="relative z-0 w-full mt-5 group">
                    <textarea wire:model.live="descripcion"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-yellow-500 focus:outline-none focus:ring-0 focus:border-yellow-600 peer" placeholder=" " required
                        name="descripcion"
                        id="descripcion" >
                    </textarea>
                    <label for="descripcion" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Observaciones</label>
                </div>
                @if ($descripcion)
                    <a href="" wire:click.prevent="$dispatch('recibiendo')" class="inline-flex justify-center mt-5 items-center py-2.5 px-5 text-base font-medium text-center text-white rounded-lg bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:ring-orange-300 dark:focus:ring-blue-900">
                        <i class="fa-solid fa-inbox"></i> Registra Recepción
                    </a>
                @endif

            @endif


        </div>
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-8 md:p-12">
                <a href="#" class="bg-green-100 text-green-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-green-400 mb-2">
                    <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                        <path d="M17 11h-2.722L8 17.278a5.512 5.512 0 0 1-.9.722H17a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1ZM6 0H1a1 1 0 0 0-1 1v13.5a3.5 3.5 0 1 0 7 0V1a1 1 0 0 0-1-1ZM3.5 15.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2ZM16.132 4.9 12.6 1.368a1 1 0 0 0-1.414 0L9 3.55v9.9l7.132-7.132a1 1 0 0 0 0-1.418Z"/>
                    </svg>
                    Recorrido Mensajería
                </a>
                <h2 class="text-gray-900 dark:text-white text-lg md:text-3xl font-extrabold mb-2">Historial de la diligencia</h2>
                @for ($i = 0; $i < count($this->observaciones); $i++)
                    <p class="text-sm md:text-lg text-justify font-normal  text-gray-500 dark:text-gray-400 mb-4">
                        - {{$this->observaciones[$i]}}
                    </p>
                @endfor
            </div>
            <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-8 md:p-12">
                <a href="#" class="bg-purple-100 text-purple-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-purple-400 mb-2">
                    <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4 1 8l4 4m10-8 4 4-4 4M11 1 9 15"/>
                    </svg>
                    Imágenes - Soportes anexos
                </a>
                <h2 class="text-gray-900 dark:text-white text-lg md:text-3xl font-extrabold mb-2">Soportes Anexos</h2>
                <p class="text-lg font-normal text-gray-500 dark:text-gray-400 mb-4">
                    Imagenes
                </p>

            </div>
        </div>
    </div>
</section>
