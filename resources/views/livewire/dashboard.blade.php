<div>
  <div class="flex justify-center py-4">
    @if(!$keys)
      <x-button class="py-3 w-3/12 justify-center mx-3" wire:click="handOverKeys">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-key mr-3" width="25" height="25" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <path d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z" />
          <path d="M15 9h.01" />
        </svg>
        {{ __('Entregar llaves') }}
      </x-button>
    @endif
  </div>

  @if($keys)
    @include("dashboard.form")
  @endif

  <div>
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
  <div id="calendarAmbientes" class="w-5/6 mx-auto mb-5 border p-8 mt-4" wire:ignore></div>

  
  <h2 class="text-xl font-bold text-center mt-4">Agenda - auditorios</h2>
  <div id="auditoriesCalendar" class="w-5/6 mx-auto mb-5 border p-8 mt-4" wire:ignore></div>

  @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/locales/es.global.min.js"></script>
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
              <div>${info.event.extendedProps.responsable}</div>
            `;
            return { domNodes: [customEl] };
          },
          eventDidMount: function(info) {
            if (info.event.extendedProps.handOveredKeys == 1) {
              info.el.style.backgroundColor = 'green';
            } else {
              info.el.style.backgroundColor = 'yellow';
            }}
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
              <div>${info.event.extendedProps.responsable}</div>
            `;
            return { domNodes: [customEl] };
          },
          eventDidMount: function(info) {
            if (info.event.extendedProps.handOveredKeys == 1) {
              info.el.style.backgroundColor = 'green';
            } else {
              info.el.style.backgroundColor = 'yellow';
            }}
          })
          calendar2.render();
          calendar1.render();

        });
    </script>
  @endpush
</div>