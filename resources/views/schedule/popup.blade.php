<div class="main-modal fixed w-full h-100 inset-0 z-50 overflow-hidden flex justify-center items-center animated fadeIn faster" style="background: rgba(0,0,0,.7);">
    <div class="border border-teal-500 modal-container  bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto" style="max-height: 90vh;">
        <div class="modal-content py-4 text-left px-6">
				<!--Title-->
            <div class="flex justify-between items-center pb-3">
                
                @if($deletion)
                    <p class="text-2xl font-bold">Borrando registro!!</p>
                @elseif($updating)
                    <p class="text-2xl font-bold">Actualizar información</p>
                @else
                    <p class="text-2xl font-bold">Añadir programacion de ambiente</p>
                @endif
                <div class="modal-close cursor-pointer z-50">
                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                        wire:click="cancel" viewBox="0 0 18 18">
                        <path
                            d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                        </path>
                    </svg>
                </div>
            </div>
				<!--Body-->
            <div class="my-5">
                @if($deletion)
                    <p>Estás completamente seguro de realizar esta acción?</p>
                @elseif($updating)
                    <form method="POST" wire:submit="update({{ $updating->id }})" class="p-10">
                        @csrf

                        <div class="mt-4">
                            <x-label for="teacher" value="{{ __('Numero documento instructor') }}" />
                            <x-input id="teacher" class="block mt-1 w-full" type="text" name="teacher" :value="old('teacher')" required autofocus autocomplete="teacher" wire:model.live='teacher'/>
                            @if(isset($errors['teacher']) && !empty($errors['teacher']))
                                <span class="text-red-500">{{ $errors['teacher'] }}</span>
                            @endif
                        </div>
                        
                        <div class="mt-4">
                            <x-label for="environment" value="{{ __('Código ambiente') }}" />
                            <x-input id="environment" class="block mt-1 w-full" type="text" name="environment" :value="old('environment')" required autofocus autocomplete="environment" wire:model.live='environment' />
                            @if(isset($errors['environment']) && !empty($errors['environment']))
                                <span class="text-red-500">{{ $errors['environment'] }}</span>
                            @endif
                        </div>

                        <div class="mt-4">
                            <x-label for="handOveredKeys" value="{{ __('LLaves entregadas') }}" />
                            <select name="handOveredKeys" id="handOveredKeys" class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" required wire:model.live='handOveredKeys'>
                                <option value="">Selecciona una opación...</option>
                                <option value="0" selected>No</option>
                                <option value="1">Sí</option>
                            </select>
                            @if(isset($errors['handOveredKeys']) && !empty($errors['handOveredKeys']))
                                <span class="text-red-500">{{ $errors['handOveredKeys'] }}</span>
                            @endif
                        </div>
            
                        <div class="mt-4">
                            <x-label for="date" value="{{ __('Fecha') }}" />
                            <x-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date')" required autofocus autocomplete="date" wire:model.live='date' />
                            @if(isset($errors['date']) && !empty($errors['date']))
                                <span class="text-red-500">{{ $errors['date'] }}</span>
                            @endif
                        </div>
            
                        <div class="mt-4">
                            <x-label for="startTime" value="{{ __('Hora inicio') }}" />
                            <x-input id="startTime" class="block mt-1 w-full" type="time" name="startTime" :value="old('startTime')" required autocomplete="startTime" wire:model.live='startTime' />
                            @if(isset($errors['startTime']) && !empty($errors['startTime']))
                                <span class="text-red-500">{{ $errors['startTime'] }}</span>
                            @endif
                        </div>
            
                        <div class="mt-4">
                            <x-label for="endTime" value="{{ __('Hora fin') }}" />
                            <x-input id="endTime" class="block mt-1 w-full" type="time" name="endTime" required autocomplete="endTime" wire:model.live='endTime' />
                            @if(isset($errors['endTime']) && !empty($errors['endTime']))
                                <span class="text-red-500">{{ $errors['endTime'] }}</span>
                            @endif  
                        </div>

                    </form>
                @else
                    <form method="POST" wire:submit="save" class="p-10">
                        @csrf

                        <div class="mt-4">
                            <x-label for="teacher" value="{{ __('Numero documento instructor') }}" />
                            <x-input id="teacher" class="block mt-1 w-full" type="text" name="teacher" :value="old('teacher')" required autofocus autocomplete="teacher" wire:model.live='teacher'/>
                            @if(isset($errors['teacher']) && !empty($errors['teacher']))
                                <span class="text-red-500">{{ $errors['teacher'] }}</span>
                            @endif
                        </div>
                        
                        <div class="mt-4">
                            <x-label for="environment" value="{{ __('Código ambiente') }}" />
                            <x-input id="environment" class="block mt-1 w-full" type="text" name="environment" :value="old('environment')" required autofocus autocomplete="environment" wire:model.live='environment' />
                            @if(isset($errors['environment']) && !empty($errors['environment']))
                                <span class="text-red-500">{{ $errors['environment'] }}</span>
                            @endif
                        </div>

                        <div class="mt-4">
                            <x-label for="handOveredKeys" value="{{ __('LLaves entregadas') }}" />
                            <select name="handOveredKeys" id="handOveredKeys" class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" required wire:model.live='handOveredKeys'>
                                <option value="">Selecciona una opcion...</option>
                                <option value="0" selected>No</option>
                                <option value="1">Sí</option>
                            </select>
                            @if(isset($errors['handOveredKeys']) && !empty($errors['handOveredKeys']))
                                <span class="text-red-500">{{ $errors['handOveredKeys'] }}</span>
                            @endif
                        </div>
            
                        <div class="mt-4">
                            <x-label for="date" value="{{ __('Fecha') }}" />
                            <x-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date')" required autofocus autocomplete="date" wire:model.live='date' />
                            @if(isset($errors['date']) && !empty($errors['date']))
                                <span class="text-red-500">{{ $errors['date'] }}</span>
                            @endif
                        </div>
            
                        <div class="mt-4">
                            <x-label for="startTime" value="{{ __('Hora inicio') }}" />
                            <x-input id="startTime" class="block mt-1 w-full" type="time" name="startTime" :value="old('startTime')" required autocomplete="startTime" wire:model.live='startTime' />
                            @if(isset($errors['startTime']) && !empty($errors['startTime']))
                                <span class="text-red-500">{{ $errors['startTime'] }}</span>
                            @endif
                        </div>
            
                        <div class="mt-4">
                            <x-label for="endTime" value="{{ __('Hora fin') }}" />
                            <x-input id="endTime" class="block mt-1 w-full" type="time" name="endTime" required autocomplete="endTime" wire:model.live='endTime' />
                            @if(isset($errors['endTime']) && !empty($errors['endTime']))
                                <span class="text-red-500">{{ $errors['endTime'] }}</span>
                            @endif  
                        </div>
                    </form>
                @endif
            </div>
				<!--Footer-->
            <div class="flex justify-end pt-2">
                <x-secondary-button wire:click="cancel" class="mr-2">
                    {{ __('Cancelar') }}
                </x-secondary-button>
                @if($deletion)
                    <x-danger-button  wire:click="delete({{ $deletion }})">
                        {{  __('Eliminar') }}
                    </x-danger-button>
                @elseif($updating)
                    <x-button wire:click="update({{ $updating->id }})">
                        {{ __('Actualizar') }}
                    </x-button>
                @else
                    <x-button wire:click="save">
                        {{ __('Guardar') }}
                    </x-button>
                @endif
            </div>
        </div>
    </div>
</div>