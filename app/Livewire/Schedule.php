<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;
use App\Models\Schedules;
use App\Models\User;
use App\Models\Environment;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithFileUploads;
use App\Imports\SchedulesImport;
use Illuminate\Support\Facades\Auth;

class Schedule extends Component{
    use WithFileUploads; 

    public $search, $teacher, $environment, $date, $startTime, $endTime, $user, $env, $file, $handOveredKeys, $success, $errors = [];
    public $popup = false;
    public $schedules = '';
    public $deletion = false;
    public $updating = false;

    public function mount(){
        if(Auth::user()->role != "admin"){
            return redirect()->route("dashboard");
        }
    }

    public function render(){
        if($this->search){
            $this->schedules = Schedules::whereHas('environment', function ($query) { $query->where('code', 'like', "%$this->search%"); })->get();
        }else{
            $this->schedules = Schedules::all();
        }

        return view('livewire.schedule');
    }

    // Import data from excel
    public function importData(){
        if($this->file){
            Excel::import(new SchedulesImport, $this->file);
        }

        $this->success = "Información importada";
        $this->file = '';
    }

    public function save(){
        $this->success = '';
        $this->errors = [];

        if(empty($this->teacher) || $this->teacher == ""){ $this->errors['teacher'] = "Este campo es obligatorio"; }
        if(empty($this->environment) || $this->environment == ""){ $this->errors['environment'] = "Este campo es obligatorio"; }
        if(empty($this->date) || $this->date == ""){ $this->errors['date'] = "Este campo es obligatorio"; }
        if(empty($this->startTime) || $this->startTime == ""){ $this->errors['startTime'] = "Este campo es obligatorio"; }
        if(empty($this->endTime) || $this->endTime == ""){ $this->errors['endTime'] = "Este campo es obligatorio"; }
        if(empty($this->handOveredKeys) || $this->handOveredKeys == ""){ $this->errors['handOveredKeys'] = "Este campo es obligatorio"; }

        if($this->errors == []){
            $sch = new Schedules();
            $sch->user_id = User::where('document_number', '=', $this->teacher)->first()->id;
            $sch->environment_id = Environment::where('code', '=', $this->environment)->first()->id;
            $sch->date = $this->date;
            $sch->startTime = $this->startTime;
            $sch->endTime = $this->endTime;
            $sch->handOveredKeys = $this->handOveredKeys;
            $sch->save();
            $this->success = "Agregado correctamente";
            $this->cancel();
        }
    }

    public function update($id){
        $this->success = '';
        $this->errors = [];

        if($id){
            if(empty($this->teacher) || $this->teacher == ""){ $this->errors['teacher'] = "Este campo es obligatorio"; }
            if(empty($this->environment) || $this->environment == ""){ $this->errors['environment'] = "Este campo es obligatorio"; }
            if(empty($this->date) || $this->date == ""){ $this->errors['date'] = "Este campo es obligatorio"; }
            if(empty($this->startTime) || $this->startTime == ""){ $this->errors['startTime'] = "Este campo es obligatorio"; }
            if(empty($this->endTime) || $this->endTime == ""){ $this->errors['endTime'] = "Este campo es obligatorio"; }
            if(empty($this->handOveredKeys) || $this->handOveredKeys == ""){ $this->errors['handOveredKeys'] = "Este campo es obligatorio"; }

            if($this->errors == []){
                $row = Schedules::find($id);
                $row->user_id = User::where('document_number', '=', $this->teacher)->first()->id;
                $row->environment_id = Environment::where('code', '=', $this->environment)->first()->id;
                $row->date = $this->date;
                $row->startTime = $this->startTime;
                $row->endTime = $this->endTime;
                $row->handOveredKeys = $this->handOveredKeys;
                
                $row->update();
                $this->success = "Actualizado correctamente";
                $this->cancel();
            }
        }else{
            $this->errors['id'] = "Identificador no asignado";
        }
    }

    public function delete($id){
        if($id){
            $record = Schedules::find($id);
            $record->delete();
            $this->deletion = '';
            $this->popup = false;
        }else{
            $this->errors['id'] = "Identificador no asignado";
        }
    }

    public function add(){
        $this->popup = true;
    }

    public function clearErrors(){
        $this->errors = [];
        $this->success = '';
    }

    public function editModal($id){
        if($id){
            $this->popup = true;
            $record = Schedules::find($id);
            $this->teacher = User::find($record->user_id)->document_number;
            $this->environment = Environment::find($record->environment_id)->code;
            $this->startTime = $record->startTime;
            $this->endTime = $record->endTime;
            $this->date = $record->date;
            $this->handOveredKeys = $record->handOveredKeys;
            $this->updating = $record;   
        }else{
            $this->errors['id'] = "Identificador no asignado";
        }
    }

    public function deleteModal($id){
        if($id){
            $this->popup = true;
            $this->deletion = $id;
        }else{
            $this->errors['id'] = "Identificador no asignado";
        }
    }

    public function cancel(){
        $this->popup = false;
        $this->updating = '';
        $this->deletion = '';
        $this->teacher = '';
        $this->environment = '';
        $this->endTime = '';
        $this->startTime = '';
        $this->date = '';
        $this->handOveredKeys = '';
        $this->errors = [];
        $this->success = "";
    }
}
