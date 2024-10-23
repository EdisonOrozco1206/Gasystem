<div>

    <div class="flex justify-center items-center mt-3 gap-2 px-3">
        <x-button class="py-3 w-1/6 justify-center p-2" wire:click="add">
            {{ __('Agregar') }}
        </x-button>
        @if(!$file)
            <input wire:model='file' type="file" name="dataFile" accept=".csv, .xls, .xlsx" class="inline-flex w-1/6 py-3 justify-center items-center px-4 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
        @endif
        @if($file)
            <x-secondary-button class="py-3 w-1/6 justify-center" wire:click="importData">
                {{ __('Importar') }}
            </x-secondary-button>
        @endif

        <x-input id="search" class="block w-4/6" type="text" name="search" required autocomplete="search" placeholder="Buscar por nombre o código" wire:model.live='search'/>
    </div>

    @if($popup)
        @include('environments.popup')
    @endif

    <div class="relative overflow-x-auto shadow-md mt-3">

        @if(isset($errors['id']) && !empty($errors['id']))
            <div class="flex justify-between items-center bg-red-500 text-white text-lg font-bold p-4">
                <p class="">{{ $errors['id'] }}</p>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x cursor-pointer" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round" wire:click.prevent='clearErrors'>
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M18 6l-12 12" />
                    <path d="M6 6l12 12" />
                </svg>
            </div>
        @elseif(isset($errors['foreing_kes']) && !empty($errors['foreing_kes']))
            <div class="flex justify-between items-center bg-red-500 text-white text-lg font-bold p-4">
                <p class="">{{ $errors['foreing_kes'] }}</p>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x cursor-pointer" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round" wire:click.prevent='clearErrors'>
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M18 6l-12 12" />
                    <path d="M6 6l12 12" />
                </svg>
            </div>
        @elseif(isset($errors['import']) && !empty($errors['import']))
            <div class="flex justify-between items-center bg-red-500 text-white text-lg font-bold p-4">
                <p class="">{{ $errors['import'] }}</p>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x cursor-pointer" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round" wire:click.prevent='clearErrors'>
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M18 6l-12 12" />
                    <path d="M6 6l12 12" />
                </svg>
            </div>
        @elseif(isset($success) && !empty($success))
            <div class="flex justify-between items-center bg-green-500 text-white text-lg font-bold p-4">
                <p class="">{{ $success }}</p>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x cursor-pointer" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round" wire:click.prevent='clearErrors'>
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M18 6l-12 12" />
                    <path d="M6 6l12 12" />
                </svg>
            </div>
        @endif

        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Código
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Ambiente
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Capacidad
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Disponibilidad
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Implementos
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Editar
                    </th>
                    @if(Auth::user()->role == "admin")
                        <th scope="col" class="px-6 py-3">
                            Eliminar
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if($environments->count() != 0)
                    @foreach($environments as $env)
                        <tr class="border-b bg-gray-800 border-gray-700">
                            <td scope="row" class="px-6 py-4 font-medium text-white text-center capitalize">
                                {{ $env->code }}
                            </td>
                            <td scope="row" class="px-6 py-4 font-medium text-white text-center capitalize">
                                {{ $env->name }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ $env->capacity }}
                            </td>
                            <td class="px-6 py-4 text-center capitalize">
                                @if($env->availability == "disponible") 
                                    <span class="text-green-400">{{ $env->availability }}</span> 
                                @elseif($env->availability == "ocupado")
                                    <span class="text-red-500">{{ $env->availability }}</span>
                                @elseif($env->availability == "reservado")
                                    <span class="text-orange-500">{{ $env->availability }}</span>
                                @elseif($env->availability == "deshabilitado")
                                    <span class="text-gray-500">{{ $env->availability }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('implements', ['id' => $env->id]) }}" class="font-medium text-white bg-purple-500 py-2 px-4 rounded-lg">Admin.</a>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="" wire:click.prevent="editModal({{ $env->id }})" class="font-medium text-blue-500 underline">Editar</a>
                            </td>
                            @if(Auth::user()->role == "admin")
                                <td class="px-6 py-4 text-center">
                                    <a href=""  wire:click.prevent="deleteModal({{ $env->id }})" class="font-medium text-red-500 underline">Eliminar</a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @else
                    <td colspan="6" class="text-center text-xl font-bold text-black mt-3">No hay elementos para mostrar</td>
                @endif
            </tbody>
        </table>
    </div>
</div>
