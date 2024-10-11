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
                    <p class="text-2xl font-bold">Añadir usuario</p>
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
                            <x-label for="document_type" value="{{ __('Tipo documento') }}" />
                            <select name="document_type" id="document_type" class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" required wire:model.live='document_type'>
                                <option value="">Seleccionar tipo de documento...</option>
                                <option value="CC">Cedula de ciudadania</option>
                                <option value="TI">Tarjeta de identidad</option>
                                <option value="CE">Cedula de extranjeria</option>
                                <option value="P">Pasaporte</option>
                            </select>
                            @if(isset($errors['document_type']) && !empty($errors['document_type']))
                                <span class="text-red-500">{{ $errors['document_type'] }}</span>
                            @endif
                        </div>
            
                        <div class="mt-4">
                            <x-label for="document_number" value="{{ __('Numero documento') }}" />
                            <x-input id="document_number" class="block mt-1 w-full" type="text" name="document_number" :value="old('document_number')" required autofocus autocomplete="document_number" wire:model.live='document_number'/>
                            @if(isset($errors['document_number']) && !empty($errors['document_number']))
                                <span class="text-red-500">{{ $errors['document_number'] }}</span>
                            @endif
                        </div>

                        <div class="mt-4">
                            <x-label for="role" value="{{ __('Rol') }}" />
                            <select name="role" id="role" class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" required wire:model.live='role'>
                                <option value="">Seleccionar rol...</option>
                                <option value="instructor" @if($updating->role == "instructor") selected @endif>Instructor</option>
                                <option value="gestor" @if($updating->role == "gestor") selected @endif>Gestor</option>
                                <option value="coordinador" @if($updating->role == "coordinador") selected @endif>Coordinador</option>
                                <option value="admin" @if($updating->role == "admin") selected @endif>Administrador</option>
                            </select>
                            @if(isset($errors['role']) && !empty($errors['role']))
                                <span class="text-red-500">{{ $errors['role'] }}</span>
                            @endif
                        </div>
                        
                        <div class="mt-4">
                            <x-label for="name" value="{{ __('Nombre') }}" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" wire:model.live='name' />
                            @if(isset($errors['name']) && !empty($errors['name']))
                                <span class="text-red-500">{{ $errors['name'] }}</span>
                            @endif
                        </div>
            
                        <div class="mt-4">
                            <x-label for="lastname" value="{{ __('Apellido') }}" />
                            <x-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autofocus autocomplete="lastname" wire:model.live='lastname' />
                            @if(isset($errors['lastname']) && !empty($errors['lastname']))
                                <span class="text-red-500">{{ $errors['lastname'] }}</span>
                            @endif
                        </div>
            
                        <div class="mt-4">
                            <x-label for="email" value="{{ __('Correo') }}" />
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="" wire:model.live='email' />
                            @if(isset($errors['email']) && !empty($errors['email']))
                                <span class="text-red-500">{{ $errors['email'] }}</span>
                            @endif
                        </div>

                    </form>
                @else
                    <form method="POST" wire:submit="save" class="p-10">
                        @csrf

                        <div class="mt-4">
                            <x-label for="document_type" value="{{ __('Tipo documento') }}" />
                            <select name="document_type" id="document_type" class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" required wire:model.live='document_type'>
                                <option value="">Seleccionar tipo documento...</option>
                                <option value="CC">Cedula de ciudadania</option>
                                <option value="TI">Tarjeta de identidad</option>
                                <option value="CE">Cedula de extranjeria</option>
                                <option value="P">Pasaporte</option>
                            </select>
                            @if(isset($errors['document_type']) && !empty($errors['document_type']))
                                <span class="text-red-500">{{ $errors['document_type'] }}</span>
                            @endif
                        </div>
            
                        <div class="mt-4">
                            <x-label for="document_number" value="{{ __('Numero documento') }}" />
                            <x-input id="document_number" class="block mt-1 w-full" type="text" name="document_number" :value="old('document_number')" required autofocus autocomplete="document_number" wire:model.live='document_number'/>
                            @if(isset($errors['document_number']) && !empty($errors['document_number']))
                                <span class="text-red-500">{{ $errors['document_number'] }}</span>
                            @endif
                        </div>

                        <div class="mt-4">
                            <x-label for="code" value="{{ __('Código documento') }}" />
                            <x-input id="code" class="block mt-1 w-full" type="text" name="code" :value="old('code')" required autofocus autocomplete="code" wire:model.live='code'/>
                        </div>

                        <div class="mt-4">
                            <x-label for="role" value="{{ __('Rol') }}" />
                            <select name="role" id="role" class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" required wire:model.live='role'>
                                <option value="">Select document type</option>
                                <option value="instructor">Instructor</option>
                                <option value="gestor">Gestor</option>
                                <option value="coordinador">Coordinador</option>
                                <option value="admin">Administrador</option>
                            </select>
                            @if(isset($errors['role']) && !empty($errors['role']))
                                <span class="text-red-500">{{ $errors['role'] }}</span>
                            @endif
                        </div>
                        
                        <div class="mt-4">
                            <x-label for="name" value="{{ __('Nombre') }}" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" wire:model.live='name' />
                            @if(isset($errors['name']) && !empty($errors['name']))
                                <span class="text-red-500">{{ $errors['name'] }}</span>
                            @endif
                        </div>
            
                        <div class="mt-4">
                            <x-label for="lastname" value="{{ __('Apellido') }}" />
                            <x-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autofocus autocomplete="lastname" wire:model.live='lastname' />
                            @if(isset($errors['lastname']) && !empty($errors['lastname']))
                                <span class="text-red-500">{{ $errors['lastname'] }}</span>
                            @endif
                        </div>
            
                        <div class="mt-4">
                            <x-label for="email" value="{{ __('Correo') }}" />
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="" wire:model.live='email' />
                            @if(isset($errors['email']) && !empty($errors['email']))
                                <span class="text-red-500">{{ $errors['email'] }}</span>
                            @endif
                        </div>
            
                        <div class="mt-4">
                            <x-label for="password" value="{{ __('Contraseña') }}" />
                            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" wire:model.live='password' />
                            @if(isset($errors['password']) && !empty($errors['password']))
                                <span class="text-red-500">{{ $errors['password'] }}</span>
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