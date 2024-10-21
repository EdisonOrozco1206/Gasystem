<div>
    <div class="flex justify-center items-center mt-3 gap-2 px-3">
        <x-button class="py-3 w-1/6 justify-center" wire:click="openPopUp">
            {{ __('Agregar') }}
        </x-button>

        @if(!$file)
            <input wire:model='file' type="file" name="dataFile" accept=".csv, .xls, .xlsx" class="w-1/6 py-3 justify-center inline-flex items-center px-4 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
        @endif
        
        @if($file)
            <x-secondary-button class="py-3 w-1/6 justify-center" wire:click="importData">
                {{ __('Importar') }}
            </x-secondary-button>
        @endif

        <x-input id="search" class="block w-4/6" type="text" name="search" required autocomplete="search" placeholder="Buscar por nombre o numero de documento" wire:model.live='search'/>
    </div>

    @if($popup)
        @include('users.popup')
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
        <table class="w-full text-sm text-left rtl:text-right text-gray-400">
            <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Rol
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nombre
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Apellido
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Correo
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tipo documento
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Numero documento
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
                @if($users->count() != 0)
                    @foreach($users as $user)
                        <tr class="border-b bg-gray-800 border-gray-700">
                            <td scope="row" class="px-6 py-4 font-medium text-white text-center capitalize">
                                {{ $user->role }}
                            </td>
                            <td scope="row" class="px-6 py-4 font-medium text-white text-center capitalize">
                                {{ $user->name }}
                            </td>
                            <td scope="row" class="px-6 py-4 font-medium text-white text-center capitalize">
                                {{ $user->lastname }}
                            </td>
                            <td scope="row" class="px-6 py-4 font-medium text-white text-center">
                                {{ $user->email }}
                            </td>
                            <td scope="row" class="px-6 py-4 font-medium text-white text-center capitalize">
                                {{ $user->document_type }}
                            </td>
                            <td scope="row" class="px-6 py-4 font-medium text-white text-center capitalize">
                                {{ $user->document_number }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="" wire:click.prevent="editModal({{ $user->id }})" class="font-medium text-blue-500 underline">Editar</a>
                            </td>
                            @if(Auth::user()->role == "admin")
                                <td class="px-6 py-4 text-center">
                                    <a href=""  wire:click.prevent="deleteModal({{ $user->id }})" class="font-medium text-red-500 underline">Eliminar</a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
