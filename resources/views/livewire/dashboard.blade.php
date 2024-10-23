<div>
  @if($quarter)
    <h1 class="capitalize text-2xl font-bold text-center mt-4">{{ $quarter->name }}</h1>
  @endif

  @if(Auth::user()->role != "instructor")
    <div class="flex justify-center py-4">
      @if(!$keys && Auth::user()->role != "coordinador")
        <x-button class="py-3 w-full sm:w-3/12  justify-center mx-3" wire:click="handOverKeys">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-key mr-3" width="25" height="25" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z" />
            <path d="M15 9h.01" />
          </svg>
          {{ __('Entregar llaves') }}
        </x-button>
      @endif
      @if(Auth::user()->role == "coordinador")
        <x-button class="py-3 w-1/2 sm:w-3/12 justify-center mx-3" wire:click="handOverKeys">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-key mr-3" width="25" height="25" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z" />
            <path d="M15 9h.01" />
          </svg>
          {{ __('Entregar llaves') }}
        </x-button>
        <x-secondary-button class="py-3 sm:w-3/12 w-1/2 justify-center mx-3" wire:click='selectQuarter'>
          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download mr-3" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
            <path d="M7 11l5 5l5 -5" />
            <path d="M12 4l0 12" />
          </svg>
          {{ __('Descargar informe') }}
        </x-secondary-button>
      @endif
    </div>
  @endif

  @if($quarters)
    @include("dashboard.popup")
  @endif

  @if($keys)
    @include("dashboard.form")
  @endif

  <div>
    @if(isset($errors['export']) && !empty($errors['export']))
      <div class="flex justify-between items-center bg-red-500 text-white text-lg font-bold p-4">
        <p class="">{{ $errors['export'] }}</p>
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
    <h2 class="text-xl font-bold text-center mt-4">Proximos ambientes a ocupar</h2>
    <div class="mt-4">
      @if(count($nextAmbientsToOcupe) > 0)
        <div class="cards-container w-full gap-4 flex overflow-x-scroll bg-slate-100 p-4">
          @foreach($nextAmbientsToOcupe as $ambient)
            <div class="card min-w-[200px] border bg-white">
              <div class="card-header p-2 w-full border-b text-white bg-slate-950">
                <p class="capitalize">{{ $ambient->environment->name }}</p>
              </div>
              <div class="card-body p-2 w-full">
                <p>{{$ambient->startTime}} - {{ $ambient->endTime }}</p>
                <p>{{ $ambient->user->name }} {{ $ambient->user->lastname }}</p>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div class="cards-container w-full gap-4 flex overflow-x-scroll bg-slate-100 p-4">
          <p class="text-center w-full">No hay ambientes a ocupar el dia de hoy</p>
        </div>
      @endif
    </div>
  </div>

  <h2 class="text-xl font-bold text-center mt-4">Agenda - ambientes</h2>
  <div id="calendarAmbientes" class="sm:w-5/6 w-full mx-auto mb-5 border sm:p-8 p-2 mt-4" wire:ignore></div>

  
  <h2 class="text-xl font-bold text-center mt-4">Agenda - auditorios</h2>
  <div id="auditoriesCalendar" class="sm:w-5/6 w-full mx-auto mb-5 border sm:p-8 p-2 mt-4" wire:ignore></div>

  @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/locales/es.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const calendarAmbientes = document.getElementById('calendarAmbientes');
        const auditoryCalendar = document.getElementById("auditoriesCalendar");

        const calendar1 = new FullCalendar.Calendar(calendarAmbientes, {
          initialView: 'dayGridWeek',
          slotMinTime: "06:00", 
          slotMaxTime: "23:00", 
          locale: 'col',
          hiddenDays: [0],
          headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'dayGridWeek,dayGridDay'
          },
          events: @json($ambientEvents),
          eventContent: function(info){
            let customEl = document.createElement('div');
            customEl.style.padding = "5px";
            customEl.innerHTML = `
              <div><strong class='capitalize'>${info.event.title}</strong></div>
              <div class='capitalize'>${info.event.extendedProps.responsable}</div>
            `;
            return { domNodes: [customEl] };
          },
          eventDidMount: function(info) {
            if (info.event.extendedProps.handOveredKeys == 1) {
              info.el.style.backgroundColor = 'green';
            } else {
              info.el.style.backgroundColor = 'yellow';
            }},
            eventClick: function(info) {
              info.jsEvent.preventDefault();
              var title = info.event.title;
              var userInfo = JSON.parse(info.event.extendedProps.responsableInfo);
              var envInfo = JSON.parse(info.event.extendedProps.envInfo);
              var eventInfo = JSON.parse(info.event.extendedProps.eventInfo);

              Swal.fire({
                title: "Información de reserva",
                icon: "info",
                html: `
                  <p class='capitalize font-bold'>${envInfo.name}</p>
                  <p>${eventInfo.startTime} - ${eventInfo.endTime}</p>
                  <p class='my-2'></p>
                  <p class='capitalize'>${userInfo.name} ${userInfo.lastname}</p>
                  <p>${userInfo.document_type} - ${userInfo.document_number}</p>
                  <p>${userInfo.email}</p>
                `,
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: `
                  <i class="fa fa-thumbs-up"></i> Cerrar
                `,
                confirmButtonAriaLabel: "Thumbs up, great!",
                validRange: {
                  @if(isset($quarter) && !empty($quarter))
                    start: "{{ $quarter->startDate }}",
                    end: "{{ $quarter->endDate }}"
                  @else
                    start: "{{ now()->format('Y-m-d') }}",
                    end: "{{ now()->addMonth()->format('Y-m-d') }}" 
                  @endif
                }
              });
            }
          });

          const calendar2 = new FullCalendar.Calendar(auditoryCalendar, {
            initialView: 'dayGridWeek',
            slotMinTime: "06:00", 
            slotMaxTime: "23:00", 
            locale: 'col',
            hiddenDays: [0],
            headerToolbar: {
              left: 'prev,next',
              center: 'title',
              right: 'dayGridWeek,dayGridDay'
            },
            events: @json($auditoryEvents),
            eventContent: function(info){
              let customEl = document.createElement('div');
              customEl.style.padding = "5px";
              customEl.innerHTML = `
                <div><strong class='capitalize'>${info.event.title}</strong></div>
                <div class='capitalize'>${info.event.extendedProps.responsable}</div>
              `;
              return { domNodes: [customEl] };
            },
            eventDidMount: function(info) {
              if (info.event.extendedProps.handOveredKeys == 1) {
                info.el.style.backgroundColor = 'green';
              } else {
                info.el.style.backgroundColor = 'yellow';
            }},
            eventClick: function(info) {
              info.jsEvent.preventDefault();
              var title = info.event.title;
              var userInfo = JSON.parse(info.event.extendedProps.responsableInfo);
              var envInfo = JSON.parse(info.event.extendedProps.envInfo);
              var eventInfo = JSON.parse(info.event.extendedProps.eventInfo);

              Swal.fire({
                title: "Información de reserva",
                icon: "info",
                html: `
                  <h4>Ambiente: </h4>
                  <p class='capitalize font-bold'>${envInfo.name}</p>
                  <p>${eventInfo.startTime} - ${eventInfo.endTime}</p>
                  <p class='my-2'></p>
                  <h4>Responsable: </h4>
                  <p class='capitalize'>${userInfo.name} ${userInfo.lastname}</p>
                  <p>${userInfo.document_type} - ${userInfo.document_number}</p>
                  <p>${userInfo.email}</p>
                `,
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: `
                  <i class="fa fa-thumbs-up"></i> Cerrar
                `,
                confirmButtonAriaLabel: "Thumbs up, great!",
                validRange: {
                  @if(isset($quarter) && !empty($quarter))
                    start: "{{ $quarter->startDate }}",
                    end: "{{ $quarter->endDate }}"
                  @else
                    start: "{{ now()->format('Y-m-d') }}",
                    end: "{{ now()->addMonth()->format('Y-m-d') }}" 
                  @endif
                }
              });
            }
          })

          calendar2.render();
          calendar1.render();

        });
    </script>
  @endpush
</div>