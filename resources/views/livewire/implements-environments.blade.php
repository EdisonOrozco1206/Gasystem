<div>
    <div>
        <div class="flex justify-center items-center mt-3 gap-2 px-3">
            <a href="{{ route('environments') }}" class="cursor-pointer inline-flex items-center px-4 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 focus:bg-red-700 active:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150 py-3 w-1/6 justify-center">
                {{ __('Regresar') }}
            </a>
            <x-button class="py-3 w-1/6 justify-center" wire:click="add">
                {{ __('Agregar') }}
            </x-button>

            <x-input id="search" class="block w-4/6" type="text" name="search" required autocomplete="search" placeholder="Buscar por nombre" wire:model.live='search'/>
        </div>

        @if($popup)
            @include('implements.popup')
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

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Editar
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Eliminar
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if($implements->count() != 0)
                        @foreach($implements as $imp)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td scope="row" class="px-6 py-4 font-medium text-white text-center capitalize">
                                    {{ $imp->name }}
                                </td>
                                <td class="px-6 py-4 text-center capitalize">
                                    @if($imp->status == "perfecto") 
                                        <span class="text-green-400">{{ $imp->status }}</span> 
                                    @elseif($imp->status == "malo")
                                        <span class="text-red-500">{{ $imp->status }}</span>
                                    @elseif($imp->status == "regular")
                                        <span class="text-orange-500">{{ $imp->status }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="" wire:click.prevent="editModal({{ $imp->id }})" class="font-medium text-blue-500 underline">Editar</a>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href=""  wire:click.prevent="deleteModal({{ $imp->id }})" class="font-medium text-red-500 underline">Eliminar</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <td colspan="4" class="text-center text-xl font-bold text-black mt-3">No hay elementos para mostrar</td>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>