<?php

namespace App\Exports;

use App\Models\Schedules;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Quarter;

class SchedulesExport implements FromView
{

    protected $id;

    // El constructor acepta el ID como parámetro
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $quarter = Quarter::find($this->id);

        return view("exports.export", [
            'schedules' => Schedules::whereBetween('date', [$quarter->startDate, $quarter->endDate])->get()
        ]);
    }
}
