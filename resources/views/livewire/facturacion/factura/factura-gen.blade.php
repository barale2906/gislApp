<div>
    <div class="inline-flex rounded-md text-center shadow-sm m-2" role="group">
        <h1 class=" m-1 inline-flex">
            Seleccione la forma de facturación:
        </h1>
        <button wire:click.prevent="tipo({{1}})" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-900 bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 border border-blue-900 rounded-s-lg hover:bg-blue-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-blue-500 focus:bg-blue-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-blue-700 dark:focus:bg-blue-700">
            <i class="fa-solid fa-file-invoice-dollar"></i> Itemes
        </button>
        <button wire:click.prevent="tipo({{2}})" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-green-900 bg-gradient-to-r from-green-300 via-green-400 to-green-500 border border-green-900  hover:bg-green-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-green-500 focus:bg-green-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-green-700">
            <i class="fa-solid fa-motorcycle"></i> Diligencias
        </button>

        <button type="button" wire:click.prevent="$dispatch('cancelando')" class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-900 bg-gradient-to-r from-red-300 via-red-400 to-red-500 border border-red-900 rounded-e-lg hover:bg-red-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-red-500 focus:bg-red-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-red-700">
            Cancelar
        </button>
    </div>

    @if ($is_diligencias)
        <livewire:facturacion.factura.factura-diligencia/>
    @endif
    @if ($is_items)
        <livewire:facturacion.factura.factura-item/>
    @endif
</div>
