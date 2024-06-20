<div>
    <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4 rtl:space-x-reverse">
        <button wire:click.prevent="tipo({{1}})" type="button" class="inline-flex items-center p-1 text-sm font-medium text-blue-900 bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 border border-blue-900 rounded-s-lg hover:bg-blue-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-blue-500 focus:bg-blue-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-blue-700 dark:focus:bg-blue-700">
            <i class="fa-solid fa-hand-peace"></i> ASIGNADAS
        </button>
        <button wire:click.prevent="tipo({{2}})" type="button" class="inline-flex items-center p-1 rounded-e-lg text-sm font-medium text-green-900 bg-gradient-to-r from-green-300 via-green-400 to-green-500 border border-green-900  hover:bg-green-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-green-500 focus:bg-green-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-green-700">
            <i class="fa-solid fa-check-double"></i> TODAS
        </button>
    </div>

    @if ($is_mias)
        mis Asignadas
    @endif

    @if ($is_todas)
        Todas las de la ciudad
    @endif

    @if ($is_editar)
        Cargamos fotos
    @endif
</div>
