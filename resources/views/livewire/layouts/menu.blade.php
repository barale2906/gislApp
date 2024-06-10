<div>

    <nav class="fixed top-0 z-50 w-full bg-blue-300 border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button data-drawer-target="logo-sidebar"
                    x-on:click="open=!open"
                    aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg  hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">

                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                        </svg>
                    </button>
                    <a href="/dashboard" class="flex ml-2 md:mr-24">
                        <img src="{{$urlempr}}" class="object-cover h-10 mr-3 rounded-t-lg" alt="{{env('APP_NAME')}}" />
                        <span class="self-center font-semibold sm:invisible dark:text-white uppercase">

                        </span>
                    </a>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center ms-3">
                        <div>
                            <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-8 h-8 rounded-full" src="{{$url}}" alt="user photo">
                            </button>
                        </div>
                        <div class="z-50 hidden my-4 text-base list-none bg-green-400 divide-y divide-gray-100 rounded-2xl shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-gray-900 dark:text-white capitalize" role="none">
                                    {{ Auth::user()->name }}
                                </p>
                                <p class="text-sm font-medium text-gray-900 lowercase truncate dark:text-gray-300" role="none">
                                    {{ Auth::user()->email }}
                                </p>
                                <p class="text-sm font-medium text-gray-900 uppercase truncate dark:text-gray-300" role="none">
                                    {{$empactual->name}}
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Dashboard</a>
                                </li>
                                <li>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Settings</a>
                                </li>
                                <li>
                                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white uppercase" role="menuitem">
                                        {{ __('Profile') }}
                                    </a>
                                </li>
                                <div class="py-1">
                                    <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf

                                        <x-dropdown-link class="bg-cyan-600 hover:bg-cyan-300 text-2xl uppercase font-extrabold rounded-lg text-black text-center" href="{{ route('logout') }}"
                                                @click.prevent="$root.submit();">
                                            Cerrar Sesión
                                        </x-dropdown-link>
                                    </form>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-blue-300 border-r border-gray-200  dark:bg-gray-800 dark:border-gray-700"
    :class="{
        '-translate-x-full': !open,
        'transform-none': open,
    }"
    aria-label="Sidebar">

        <div class="h-full px-3 pb-4 overflow-y-auto bg-blue-300 dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                @foreach ($menus as $item)
                    <li>
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger" >
                                @can($item->permiso)
                                    <button type="button" class="iflex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs($item->identificaRuta) ? 'bg-gray-100' : ''}} ">
                                        <i class="{{$item->icono}}"></i>
                                        <span class="ml-3">{{$item->name}}</span>
                                    </button>
                                @endcan
                            </x-slot>
                            <x-slot name="content">
                                @foreach ($item->submenus as $it)
                                    @can($it->permiso)
                                        <a href="{{route($it->ruta)}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs($it->identificaRuta) ? 'bg-gray-100' : ''}}">
                                            <i class="{{$it->icono}}"></i>
                                            <span class="ml-3">{{$it->name}}</span>
                                        </a>
                                    @endcan
                                @endforeach
                            </x-slot>
                        </x-dropdown>
                    </li>
                @endforeach
        </div>
    </aside>


</div>
