<div>
    <h2 class=" text-justify mb-2">
        <span class=" font-extrabold">DILIGENCIA:</span> {{$this->actual->descripcion}};
    </h2>
    <p class=" text-justify mb-5">
        <span class=" font-semibold">OBSERVACIONES: </span>{{$this->actual->observaciones}}
    </p>
    <form class="max-w-3xl mx-auto">

        <div class="relative z-0 w-full mb-5 group">
            <textarea wire:model.live="observaciones" name="observaciones" id="observaciones" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required ></textarea>
            <label for="observaciones" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Observaciones</label>
            @error('observaciones')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>

        <div class="relative z-0 w-full mb-5 group">
            <input wire:model.live="cobro" name="cobro" id="cobro" type="number" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
            <label for="cobro" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Dinero recibido.</label>
            @error('cobro')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>

        <div class="relative z-0 w-full mb-5 group">
            <input wire:model.live="guias" name="guias" id="guias" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
            <label for="guias" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Número de guías registradas</label>
            @error('guias')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>

        <div class="relative z-0 w-full mb-5 group">
            <input type="file" wire:model.live="foto" accept="image/jpg, image/bmp, image/png, image/jpeg" name="foto" id="foto" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
            <label for="foto" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Cargue Imagen</label>
            @error('foto')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
            <div wire:loading wire:target="foto" class="text-center text-xl font-extrabold text-orange-500 uppercase">Cargando</div>
        </div>

        <div class="relative z-0 w-full mb-5 group">
            <div class="flex">
                <div class="flex items-center me-4">
                    <input type="radio" value="1" name="cierra" wire:model="cierra" checked class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="inline-radio" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">En proceso</label>
                </div>
                <div class="flex items-center me-4">
                    <input type="radio" value="2" name="cierra" wire:model="cierra" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="inline-2-radio" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Finaliza</label>
                </div>
                <div class="flex items-center me-4">
                    <input type="radio" value="3" name="cierra" wire:model="cierra" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="inline-2-radio" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Devolución</label>
                </div>
            </div>
        </div>

        <button type="button" wire:click.prevent="edit" class="text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-cyan-600 dark:hover:bg-cyan-700 dark:focus:ring-cyan-800">
            Guardar
        </button>

        <button type="button" wire:click.prevent="$dispatch('fotografiando')" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
            Cancelar
        </button>
    </form>
    @push('js')
        <script>
            document.getElementById('foto').addEventListener('change', async function(event) {
                const compress = new Compress();
                const files = [...event.target.files];
                const options = {
                    size: 1, // el tamaño máximo de la imagen en MB
                    quality: 0.75, // calidad de la imagen
                    maxWidth: 800, // ancho máximo de la imagen
                    maxHeight: 600, // alto máximo de la imagen
                    resize: true // redimensionar la imagen
                };

                const result = await compress.compress(files, options);
                const { photo } = result[0];
                const base64str = photo.data;
                const imgExt = photo.ext;
                const file = Compress.convertBase64ToFile(base64str, imgExt);

                // Crear un DataTransfer para enviar el archivo a Livewire
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);

                // Asignar el archivo comprimido al input file
                document.getElementById('foto').files = dataTransfer.files;

                // Disparar el evento de cambio manualmente
                const changeEvent = new Event('change');
                document.getElementById('foto').dispatchEvent(changeEvent);
            });
        </script>

    @endpush
</div>
