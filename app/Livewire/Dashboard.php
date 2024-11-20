<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Schedules;
use App\Models\Environment;
use Illuminate\Support\Carbon;
use App\Models\Quarter;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SchedulesExport;

class Dashboard extends Component
{
    public $keys;
    public $teacher, $class, $user, $type, $quarter, $nextAmbientsToOcupe, $message, $errors = [], $success, $quarters;

    public function render(){
        $this->quarter = Quarter::where('startDate', '<=', Carbon::now()->format('Y-m-d'))
                         ->where('endDate', '>=', Carbon::now()->format('Y-m-d'))->first();
        $ambientEvents = [];
        $auditoryEvents = [];
        $this->nextAmbientsToOcupe = [];
        if($this->quarter){
            $ambient_events = Schedules::whereHas('environment', function($query) { $query->where('code', 'not like', '%AU%'); })->whereBetween('date', [$this->quarter->startDate, $this->quarter->endDate])->get();
            $auditory_events = Schedules::whereHas('environment', function($query) {$query->where('code', 'like', '%AU%'); })->whereBetween('date', [$this->quarter->startDate, $this->quarter->endDate])->get();
            $this->nextAmbientsToOcupe = Schedules::where('date', '=', Carbon::now("America/Bogota")->toDateString())->where('handOveredKeys', '=', 0)->orderBy('startTime', 'asc')->get();

            foreach($ambient_events as $event){
                $env = Environment::find($event->environment_id);
                $user = User::find($event->user_id);
                $ambientEvents[] = [
                    'title' => "$env->name",
                    'start' => "$event->date $event->startTime",
                    'end' => "$event->date $event->startTime",
                    "responsableInfo" => "$user",
                    "envInfo" => "$env",
                    "eventInfo" => "$event",
                    'responsable' => "$user->name $user->lastname",
                    'handOveredKeys' => "$event->handOveredKeys",
                ];
            }

            foreach($auditory_events as $event){
                $env = Environment::find($event->environment_id);
                $user = User::find($event->user_id);
                $auditoryEvents[] = [
                    'title' => "Reunión $env->code",
                    'start' => "$event->date $event->startTime",
                    'end' => "$event->date $event->startTime",
                    "responsableInfo" => "$user",
                    "envInfo" => "$env",
                    "eventInfo" => "$event",
                    'responsable' => "$user->name $user->lastname",
                    'handOveredKeys' => "$event->handOveredKeys",
                ];
            }
        }

        return view('livewire.dashboard', ['ambientEvents' => $ambientEvents, 'auditoryEvents' => $auditoryEvents]);
    }

    public function searchClasses(){
        $this->message = '';
        $this->user = User::whereRaw("MATCH(code) AGAINST (? IN NATURAL LANGUAGE MODE)", [$this->clearCodeCharacters($this->teacher)])->first();
        $date = Carbon::now("America/Bogota")->toDateString();

        if($this->user){
            if($this->type == "aud"){
                if($this->user->role != "coordinador"){
                    $this->message = "El usuario no es un coordinador";
                }else{
                    $this->class = Schedules::where("user_id", "=", $this->user->id)
                                            ->where('date', "=", $date)
                                            ->whereHas('environment', function($query) { $query->where('code', 'like', '%AU%'); })
                                            ->where('handOveredKeys', "=", 0)
                                            ->where('startTime', '>=', Carbon::now("America/Bogota")->format('H:i'))
                                            ->orderBy("startTime", "asc")
                                            ->first();
                }
                
            }elseif($this->type == "amb"){
                if($this->user->role != "instructor"){
                    $this->message = "El usuario no es un instructor";
                }else{
                    $this->class = Schedules::where("user_id", "=", $this->user->id)
                                            ->where('date', "=", $date)
                                            ->whereHas('environment', function($query) { $query->where('code', 'not like', '%AU%'); })
                                            ->where('handOveredKeys', "=", 0)
                                            ->where('startTime', '>=', Carbon::now("America/Bogota")->format('H:i'))
                                            ->orderBy("startTime", "asc")
                                            ->first();
                }
            }

            if(!$this->class && $this->type == "aud"){
                $this->message = "No se ha encontrado nada en la agenda o usuario no es coordinador";
            }elseif(!$this->class && $this->type == "amb"){
                $this->message = "No se ha encontrado nada en la agenda";
            }
        }else{
            $this->message = "Usuario no encontrado";
        }
    }

    public function clearCodeCharacters() {
        if($clearCode = str_replace("'", "", $this->teacher)){
            return $clearCode;
        }
        return null;
    }

    public function selectQuarter(){
        $this->quarters = Quarter::all();
    }

    // Export data in excel
    public function exportData($id){
        $this->clearErrors();
        try {
            $this->quarters = '';
            $this->success = "Información exportada";
            return Excel::download(new SchedulesExport($id), "reporte.xlsx");
        } catch (\Throwable $th) {
            $this->errors['export'] = "Información no exportada: ".$th->getMessage();
        }
    }

    public function bringKeys(){
        if($this->class && $this->user){
            $class = Schedules::find($this->class->id);
            $class->handOveredKeys = 1;
            $class->update();
            $this->type = '';
            $this->cancel();
        }
    }

    public function clearErrors(){
        $this->errors = [];
        $this->success = '';
    }

    public function handOverKeys(){
        $this->keys = true;
    }

    public function changeType($type){
        $this->type = $type;
    }

    public function cancel(){
        $this->keys = false;
        $this->teacher = '';
        $this->class = '';
        $this->user = '';
        $this->type = '';
        $this->message = '';
        $this->quarters = '';
    }
}
