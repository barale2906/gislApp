<div class="max-w-3xl mx-auto px-1 py-2">
    @php
        $idCorto = substr($this->actual->identificador ?? '', -6);
    @endphp

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        {{-- Header --}}
        <div class="flex flex-wrap items-center justify-between gap-2 px-3 py-2 bg-gradient-to-r from-cyan-100 to-blue-100 dark:from-gray-700 dark:to-gray-800 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-clipboard-check text-cyan-700 dark:text-cyan-300"></i>
                <span class="text-[10px] uppercase font-semibold text-gray-500 dark:text-gray-400">ID</span>
                <span class="font-mono font-bold text-base text-gray-900 dark:text-white tracking-wider">#{{ $idCorto }}</span>
            </div>
            <div class="flex items-center gap-1 text-xs text-gray-700 dark:text-gray-300">
                <i class="fa-regular fa-calendar"></i>
                <span class="font-medium">{{ $this->actual->fecha_entrega }}</span>
            </div>
        </div>

        {{-- Info de la diligencia --}}
        <div class="px-3 py-3 bg-emerald-50/50 dark:bg-emerald-900/10 border-b border-gray-200 dark:border-gray-700">
            <h3 class="flex items-center gap-1 text-[11px] uppercase font-bold text-emerald-700 dark:text-emerald-400 mb-2">
                <i class="fa-solid fa-circle-info"></i> Información de la diligencia
            </h3>
            <dl class="space-y-1 text-xs text-gray-700 dark:text-gray-300">
                <div>
                    <dt class="text-[10px] uppercase text-gray-500 dark:text-gray-400">Dirección</dt>
                    <dd class="font-medium capitalize break-words">{{ $this->actual->direccion_dest }}</dd>
                </div>
                <div>
                    <dt class="text-[10px] uppercase text-gray-500 dark:text-gray-400">Descripción</dt>
                    <dd class="text-justify break-words capitalize">{{ $this->actual->descripcion }}</dd>
                </div>
                @if ($this->actual->observaciones)
                    <div>
                        <dt class="text-[10px] uppercase text-gray-500 dark:text-gray-400">Observaciones previas</dt>
                        <dd class="text-justify break-words italic text-gray-600 dark:text-gray-400">{{ $this->actual->observaciones }}</dd>
                    </div>
                @endif
            </dl>
        </div>

        {{-- Formulario de ejecución --}}
        <form class="px-3 py-3 space-y-4">
            <h3 class="flex items-center gap-1 text-[11px] uppercase font-bold text-cyan-700 dark:text-cyan-400">
                <i class="fa-solid fa-pen-to-square"></i> Registrar ejecución
            </h3>

            {{-- Observaciones --}}
            <div class="relative z-0 w-full group">
                <textarea wire:model.live="observaciones" name="observaciones" id="observaciones" rows="3" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required></textarea>
                <label for="observaciones" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Observaciones</label>
                @error('observaciones')
                    <div class="p-2 mt-2 text-xs text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span> {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Cobro y Guías en 2 columnas --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="relative z-0 w-full group">
                    <input wire:model.live="cobro" name="cobro" id="cobro" type="number" inputmode="numeric" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="cobro" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        <i class="fa-solid fa-dollar-sign"></i> Dinero recibido
                    </label>
                    @error('cobro')
                        <div class="p-2 mt-2 text-xs text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="relative z-0 w-full group">
                    <input wire:model.live="guias" name="guias" id="guias" type="number" inputmode="numeric" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="guias" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        <i class="fa-solid fa-route"></i> N° de guías
                    </label>
                    @error('guias')
                        <div class="p-2 mt-2 text-xs text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span> {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            {{-- Foto / Soporte --}}
            <div class="rounded-lg border border-dashed border-gray-300 dark:border-gray-600 p-3 bg-gray-50 dark:bg-gray-900/30">
                <label for="foto" class="flex items-center gap-2 text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fa-solid fa-camera-retro"></i> Cargar Imagen / Soporte (JPG, PNG, PDF)
                </label>
                <input type="file" wire:model.live="foto" accept="image/jpg, image/bmp, image/png, image/jpeg, application/pdf" name="foto" id="foto" class="block w-full text-xs text-gray-700 dark:text-gray-300 file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-medium file:bg-cyan-100 file:text-cyan-800 hover:file:bg-cyan-200 dark:file:bg-cyan-900/40 dark:file:text-cyan-300" />
                @error('foto')
                    <div class="p-2 mt-2 text-xs text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span> {{ $message }}
                    </div>
                @enderror
                <div wire:loading wire:target="foto" class="text-center text-sm font-bold text-orange-500 uppercase mt-2">
                    <i class="fa-solid fa-spinner fa-spin"></i> Cargando...
                </div>
            </div>

            {{-- Estado de cierre --}}
            <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-3 bg-white dark:bg-gray-800">
                <p class="text-[11px] uppercase font-semibold text-gray-600 dark:text-gray-400 mb-2">Estado de la diligencia</p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <label class="flex items-center gap-2 p-2 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-blue-50 dark:hover:bg-gray-700">
                        <input type="radio" value="1" name="cierra" wire:model="cierra" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:bg-gray-700 dark:border-gray-600">
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-300">
                            <i class="fa-solid fa-spinner text-blue-500"></i> En proceso
                        </span>
                    </label>
                    <label class="flex items-center gap-2 p-2 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-green-50 dark:hover:bg-gray-700">
                        <input type="radio" value="2" name="cierra" wire:model="cierra" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 dark:focus:ring-green-600 dark:bg-gray-700 dark:border-gray-600">
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-300">
                            <i class="fa-solid fa-flag-checkered text-green-600"></i> Finaliza
                        </span>
                    </label>
                    <label class="flex items-center gap-2 p-2 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-orange-50 dark:hover:bg-gray-700">
                        <input type="radio" value="3" name="cierra" wire:model="cierra" class="w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 focus:ring-orange-500 dark:focus:ring-orange-600 dark:bg-gray-700 dark:border-gray-600">
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-300">
                            <i class="fa-solid fa-rotate-left text-orange-600"></i> Devolución
                        </span>
                    </label>
                </div>
            </div>

            {{-- Botones --}}
            <div class="flex flex-col sm:flex-row gap-2 pt-2 border-t border-gray-200 dark:border-gray-700">
                <button type="button" wire:click.prevent="edit" class="flex-1 inline-flex items-center justify-center gap-2 text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-cyan-600 dark:hover:bg-cyan-700 dark:focus:ring-cyan-800">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar
                </button>
                <button type="button" wire:click.prevent="$dispatch('fotografiando')" class="flex-1 inline-flex items-center justify-center gap-2 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                    <i class="fa-solid fa-xmark"></i> Cancelar
                </button>
            </div>
        </form>
    </div>

    @push('js')
        <script>
            document.getElementById('foto').addEventListener('change', async function(event) {
                const compress = new Compress();
                const files = [...event.target.files];
                const options = {
                    size: 1,
                    quality: 0.75,
                    maxWidth: 800,
                    maxHeight: 600,
                    resize: true
                };

                const result = await compress.compress(files, options);
                const { photo } = result[0];
                const base64str = photo.data;
                const imgExt = photo.ext;
                const file = Compress.convertBase64ToFile(base64str, imgExt);

                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);

                document.getElementById('foto').files = dataTransfer.files;

                const changeEvent = new Event('change');
                document.getElementById('foto').dispatchEvent(changeEvent);
            });
        </script>
    @endpush
</div>
