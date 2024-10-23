<div class="main-modal fixed w-full h-100 inset-0 z-50 overflow-hidden flex justify-center items-center animated fadeIn faster" style="background: rgba(0,0,0,.7);">
    <div class="border border-teal-500 modal-container  bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto" style="max-height: 90vh;">
        <div class="modal-content py-4 text-left px-6">
				<!--Title-->
            <div class="flex justify-between items-center pb-3">
                <p class="text-2xl font-bold">Descargar informes</p>

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
                @if($quarters)
                    @foreach($quarters as $q)
                        <x-button class="w-full uppercase justify-center text-3xl py-3 my-2" wire:click='exportData({{ $q->id }})'>
                            {{ $q->name }}
                        </x-button>
                    @endforeach
                @else
                    <p class="text-2xl font-bold">No hay trimestres disponibles</p>
                @endif
            </div>
				<!--Footer-->
            <div class="flex justify-end pt-2">
                <x-secondary-button wire:click="cancel" class="mr-2">
                    {{ __('Cerrar') }}
                </x-secondary-button>
            </div>
        </div>
    </div>
</div>