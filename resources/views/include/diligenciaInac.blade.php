<div class="max-w-3xl mx-auto">
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 " role="alert">
        <span class="font-medium">¡IMPORTANTE!</span> ¿Está seguro(a) de cancelar la diligencia N°: <strong class="uppercase text-3xl"><h1>{{$actual->id}}</h1></strong>
    </div>
    <a href="" wire:click.prevent="$dispatch('inactivando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
        <i class="fa-solid fa-circle-xmark"></i> Cancelar Diligencia
    </a>

    <a href="" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
        <i class="fa-solid fa-rectangle-xmark"></i> Volver
    </a>
</div>
