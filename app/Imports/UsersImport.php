<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;

class UsersImport implements ToCollection, ToModel
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
        $count = User::where("document_number", '=', $row[0])->count();
        if($this->current > 1 && empty($count)){
            if (preg_match('/(\d+)(?=PubDSK)/', $row[2], $matches)) {
                $row[2] = $matches[1];
            }

            $env = new User();
            $env->document_number = $row[0];
            $env->document_type = $row[1];
            $env->code = $row[2];
            $env->role = $row[3];
            $env->name = $row[4];
            $env->lastname = $row[5];
            $env->email = $row[6];
            $env->password = Hash::make($row[7]);
            $env->save();
        }
    }
}
