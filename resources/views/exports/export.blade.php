<table>
    <thead>
        <tr>
            <th>Instructor</th>
            <th>Numero documento</th>
            <th>Ambiente</th>
            <th>Fecha</th>
            <th>Horas de uso</th>
            <th>LLaves reclamadas</th>
        </tr>
    </thead>
    <tbody>
        @if($schedules->count() != 0)
            @foreach($schedules as $sch)
                <tr>
                    <td>{{ $sch->user->name }} {{ $sch->user->lastname }}</td>
                    <td>{{ $sch->user->document_number }}</td>
                    <td> {{ $sch->environment->name }} </td>
                    <td>{{ $sch->date }}</td>
                    <td>{{ $sch->startTime }} - {{ $sch->endTime }}</td>
                    <td>
                        @if($sch->handOveredKeys == 0)
                            {{ __('No') }}
                        @elseif($sch->handOveredKeys == 1)
                            {{ __('Sí') }}
                        @endif
                    </td>
                </tr>
            @endforeach
        @else
            <td colspan="6" class="text-center text-xl font-bold text-black mt-3">No hay elementos para mostrar</td>
        @endif
    </tbody>
</table>