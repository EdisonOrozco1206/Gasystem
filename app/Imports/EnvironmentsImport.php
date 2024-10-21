<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Environment;
use Maatwebsite\Excel\Concerns\ToModel;

class EnvironmentsImport implements ToCollection, ToModel
{
    private $current = 0;

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection){
        // dd($collection);
    }

    public function model(array $row){
        $this->current++;
        $count = Environment::where("code", '=', $row[0])->count();
        if($this->current > 1 && !empty($row[0]) && empty($count)){
            $env = new Environment();
            $env->code = $row[0];
            $env->name = $row[1];
            $env->capacity = $row[2];
            $env->save();
        }
    }
}
