<?php

namespace App\Exports;

use App\Models\Schedules;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SchedulesExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view("exports.export", [
            'schedules' => Schedules::all()
        ]);
    }
}
