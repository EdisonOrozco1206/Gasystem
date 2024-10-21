<div>
    <div class="flex justify-center items-center mt-3 gap-2 px-3">
        <x-button class="py-3 w-1/6 justify-center" wire:click="openPopUp()">
            {{ __('Agregar') }}
        </x-button>
        <x-input id="search" class="block w-5/6" type="text" name="search" required autocomplete="search" placeholder="Buscar por nombre, fecha de inicio o fecha de finalizacion" wire:model.live='search'/>
    </div>

    @if($popup)
        @include('quarters.popup')
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
                        Nombre
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha inicio
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha fin
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
                @if($quarters->count() != 0)
                    @foreach($quarters as $q)
                        <tr class="border-b bg-gray-800 border-gray-700">
                            <td scope="row" class="px-6 py-4 font-medium text-white text-center capitalize">
                                {{ $q->name }}
                            </td>
                            <td scope="row" class="px-6 py-4 font-medium text-white text-center capitalize">
                                {{ $q->startDate }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ $q->endDate }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="" wire:click.prevent="editModal({{ $q->id }})" class="font-medium text-blue-500 underline">Editar</a>
                            </td>
                            @if(Auth::user()->role == "admin")
                                <td class="px-6 py-4 text-center">
                                    <a href=""  wire:click.prevent="deleteModal({{ $q->id }})" class="font-medium text-red-500 underline">Eliminar</a>
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
