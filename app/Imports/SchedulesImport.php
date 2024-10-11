<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Schedules;
use App\Models\User;
use App\Models\Environment;

class SchedulesImport implements ToCollection, ToModel
{
    private $current = 0;

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
    }

    public function model(array $row){
        $this->current++;
        if($this->current > 1){
            $user = User::where("document_number", '=', $row[0])->first();
            $env = Environment::where("code", '=', $row[1])->first();

            $sch = new Schedules();
            $sch->user_id = $user->id;
            $sch->environment_id = $env->id;
            $sch->date = $row[2];
            $sch->startTime = $row[3];
            $sch->endTime = $row[4];
            $sch->save();
        }
    }
}
