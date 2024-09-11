<div class="max-w-3xl mx-auto md:mt-24">

    <a href="#" class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow-2xl md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
        <img class="object-cover w-full rounded-lg m-2 h-auto md:h-auto md:w-48 md:rounded-lg" src="{{asset('img/logo.jpg')}}" alt="{{ config('app.name', 'Consultas') }}">
        <div class="flex flex-col justify-between p-4 leading-normal">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ config('app.name', 'Consultas') }} S.A.S.</h5>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                Consulta el estado de tu diligencia:
            </p>
            <label for="codigo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Soluciona la operación: <span class=" text-2xl font-extrabold">{{$uno}} <i class="fa-solid fa-plus"></i> {{$dos}}</span>
            </label>
            <input wire:model.live="total" name="total" id="total" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Resultado de la operación" required />


            <label for="codigo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Código de la diligencia / Envío</label>
            <input wire:model.live="codigo" name="codigo" id="codigo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="código diligencia" required />

            @if ($codigo && $total && $intentos<3)
                <button type="button" wire:click="verifica" class="w-full mt-5  text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-cyan-600 dark:hover:bg-cyan-700 dark:focus:ring-cyan-800">Verificar</button>
            @endif

        </div>

    </a>

    @if ($is_referencia)

        @if ($diligencia)
            <ol class="items-center sm:flex mt-7 shadow-2xl shadow-teal-400 p-3">
                <li class="relative mb-6 sm:mb-0">
                    <div class="flex items-center">
                        <div class="z-10 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
                            <svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <div class="hidden sm:flex w-full bg-gray-200 h-0.5 dark:bg-gray-700"></div>
                    </div>
                    <div class="mt-3 sm:pe-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            SOLICITADO
                        </h3>
                        @if ($diligencia->status>=1)
                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">
                                La orden de entrega ha sido creada y esta en espera de asignación para mensajería.
                            </p>
                        @endif

                    </div>
                </li>
                <li class="relative mb-6 sm:mb-0">
                    <div class="flex items-center">
                        <div class="z-10 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
                            <svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <div class="hidden sm:flex w-full bg-gray-200 h-0.5 dark:bg-gray-700"></div>
                    </div>
                    <div class="mt-3 sm:pe-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            EN PROCESO
                        </h3>
                        @if ($diligencia->status>=3)
                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">
                                El operador motorizado ya esta asignado y/o ya recogio tu diligencia / envío.
                            </p>
                        @else
                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">
                                ---
                            </p>
                        @endif

                    </div>
                </li>
                <li class="relative mb-6 sm:mb-0">
                    <div class="flex items-center">
                        <div class="z-10 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
                            <svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <div class="hidden sm:flex w-full bg-gray-200 h-0.5 dark:bg-gray-700"></div>
                    </div>
                    <div class="mt-3 sm:pe-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            FINALIZADO
                        </h3>
                        @if ($diligencia->status>=4 && $diligencia->status<=7)
                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">
                                La diligencia / envío fue <span class=" uppercase font-extrabold">entregada(o).</span>
                            </p>

                        @endif
                        @if ($diligencia->status===8)
                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">
                                La diligencia / envío fue <span class=" uppercase font-extrabold">devuelta(o).</span>
                            </p>
                        @endif
                        @if ($diligencia->status===9)
                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">
                                La diligencia / envío fue <span class=" uppercase font-extrabold">cancelada(o).</span>
                            </p>
                        @endif
                        @if ($diligencia->status<4)

                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">
                                ---
                            </p>
                        @endif

                    </div>
                </li>
            </ol>
        @else
            <h1 class=" text-center text-4xl font-extrabold uppercase">
                no existe diligencia registrada con el código: {{$codigo}}.
            </h1>
        @endif



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
                        timer: 2500
                    })
                });
            });
        </script>
    @endpush


</div>
