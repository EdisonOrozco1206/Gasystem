<div class="main-modal fixed w-full h-100 inset-0 z-50 overflow-hidden flex justify-center items-center animated fadeIn faster" style="background: rgba(0,0,0,.7);">
  <div class="border border-teal-500 modal-container  bg-white w-[100%] sm:w-[70%] mx-auto rounded shadow-lg z-50 overflow-y-auto">
    <div class="modal-content py-4 text-left px-6">
      {{-- Title --}}
      <div class="flex justify-between items-center pb-3">
        <h1 class="text-xl font-bold text-center mt-4">Entregar llaves</h1>
        <div class="modal-close cursor-pointer z-50">
          <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
              wire:click="cancel" viewBox="0 0 18 18">
              <path
                  d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
              </path>
          </svg>
        </div>
      </div>

      {{-- Content --}}
      @if($type)
        <form method="" wire:submit.prevent='' class="pb-10 pt-4">
          @csrf

          <div class="flex justify-evenly flex-col items-center sm:flex-row">
            <div class="mt-4 sm:w-2/6 w-full">
              <x-label for="teacher" value="{{ __('Documento instructor') }}" />
              <x-input id="teacher" class="block mt-1 w-[100%]" type="text" name="teacher" :value="old('teacher')" required autocomplete="teacher" wire:model.live="teacher"/>
            </div>

            @if($message)
              <p class="text-red-500 font-bold mt-2">{{ $message }}</p>
            @endif

            @if($class)
              <div class="mt-4 w-full sm:w-2/6">
                <h2 class="text-xl font-bold text-center mt-4">Ambiente</h2>
                <div class="">
                  <x-label for="environment" value="{{ __('Codigo de ambiente') }}" class="mt-4" />
                  <x-input class="block mt-1 w-full" type="text" value="{{ $class->environment->code }}" disabled/>

                  <x-label for="classTime" value="{{ __('Tiempo de clase') }}" class="mt-4" />
                  <x-input class="block mt-1 w-full" type="text" value="{{ $class->startTime }} - {{ $class->endTime }}" disabled/>

                  <x-label for="teacherDocumentNumber" value="{{ __('Numero deocumento instructor') }}" class="mt-4" />
                  <x-input class="block mt-1 w-full" type="text" value="{{ $class->user->document_number }}" disabled/>

                  <x-label for="Teacher name" value="{{ __('Nombre instructor') }}" class="mt-4" />
                  <x-input class="block mt-1 w-full" type="text" value="{{ $class->user->name }} {{ $class->user->lastname }}" disabled/>
                </div>
              </div>
            @endif
          </div>

          @if(!$class)
            <x-button class="py-3 justify-center mt-4 mx-auto sm:float-right m-10 mr-20" wire:click.prevent="searchClasses">
              {{ __('Buscar clase') }}
            </x-button>
          @else
            <x-button class="py-3 justify-center mt-4 mx-auto sm:float-right m-10 mr-20" wire:click.prevent="bringKeys">
              {{ __('Entregar llaves') }}
            </x-button>
          @endif
        </form>
      @else
        <form method="" wire:submit.prevent='' class="pb-10 pt-4 overflow-x-scroll">
          @csrf

          <div class="flex justify-evenly items-center">
            <x-button class="py-3 justify-center mt-4 float-right m-10 mr-20" wire:click.prevent="changeType('amb')">
              {{ __('Ambiente de clase') }}
            </x-button>
            <x-secondary-button class="py-3 justify-center mt-4 float-right m-10 mr-20" wire:click.prevent="changeType('aud')">
              {{ __('Auditorio') }}
            </x-secondary-button>
          </div>
        </form>
      @endif
    </div>
  </div>
</div>