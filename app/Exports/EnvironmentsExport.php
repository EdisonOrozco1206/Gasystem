<?php

namespace App\Exports;

use App\Models\Environment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EnvironmentsExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view("exports.export", [
            'environments' => Environment::all()
        ]);
    }
}
