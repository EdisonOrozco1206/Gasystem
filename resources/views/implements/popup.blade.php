<div class="main-modal fixed w-full h-100 inset-0 z-50 overflow-hidden flex justify-center items-center animated fadeIn faster" style="background: rgba(0,0,0,.7);">
    <div class="border border-teal-500 modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
        <div class="modal-content py-4 text-left px-6">
				<!--Title-->
            <div class="flex justify-between items-center pb-3">
                
                @if($deletion)
                    <p class="text-2xl font-bold">Borrando registro!!</p>
                @elseif($updating)
                    <p class="text-2xl font-bold">Actualizar información</p>
                @else
                    <p class="text-2xl font-bold">Añadir implemento al ambiente</p>
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

                        <div>
                            <x-label for="name" value="{{ __('Nombre') }}" />
                            <select name="name" id="name" wire:model.live="name" class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" required>
                                <option value="">Seleccionar estado del implemento...</option>
                                <option value="videoBeam">VideoBeam</option>
                                <option value="microfono">Microfono</option>
                                <option value="hdmi">HDMI</option>
                                <option value="cable de red">Cable de red</option>
                                <option value="sonido">Sonido</option>
                                <option value="monitor">Monitor</option>
                                <option value="telon videoBeam">Telón videoBeam</option>
                            </select>
                            @if(isset($errors['name']) && !empty($errors['name']))
                                <span class="text-red-500">{{ $errors['name'] }}</span>
                            @endif
                        </div>

                        <div class="mt-4">
                            <x-label for="status" value="{{ __('Estado') }}" />
                            <select name="status" id="status" wire:model.live="status" class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" required>
                                <option value="">Seleccionar estado del implemento...</option>
                                <option @if($updating->status == "perfecto") selected  @endif  value="perfecto">Perfecto</option>
                                <option @if($updating->status == "regular") selected  @endif  value="regular">Regular</option>
                                <option @if($updating->status == "malo") selected  @endif  value="malo">Malo</option>
                            </select>
                            @if(isset($errors['status']) && !empty($errors['status']))
                                <span class="text-red-500">{{ $errors['status'] }}</span>
                            @endif
                        </div>
                    </form>
                @else
                    <form method="POST" wire:submit="save" class="p-10">
                        @csrf

                        <div>
                            <x-label for="name" value="{{ __('Nombre') }}" />
                            <select name="name" id="name" wire:model.live="name" class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" required>
                                <option value="">Seleccionar implemento...</option>
                                <option value="videoBeam">VideoBeam</option>
                                <option value="microfono">Microfono</option>
                                <option value="hdmi">HDMI</option>
                                <option value="cable de red">Cable de red</option>
                                <option value="sonido">Sonido</option>
                                <option value="monitor">Monitor</option>
                                <option value="telon videoBeam">Telón videoBeam</option>
                            </select>
                            @if(isset($errors['name']) && !empty($errors['name']))
                                <span class="text-red-500">{{ $errors['name'] }}</span>
                            @endif
                        </div>

                        <div class="mt-4">
                            <x-label for="status" value="{{ __('Estado') }}" />
                            <select name="status" id="status" wire:model.live="status" class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" required>
                                <option value="">Seleccionar estado del implemento...</option>
                                <option value="perfecto">Perfecto</option>
                                <option value="regular">Regular</option>
                                <option value="malo">Malo</option>
                            </select>
                            @if(isset($errors['status']) && !empty($errors['status']))
                                <span class="text-red-500">{{ $errors['status'] }}</span>
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