<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Schedules;
use App\Models\Environment;
use Illuminate\Support\Carbon;

class Dashboard extends Component
{
    public $keys;
    public $teacher, $class, $user, $type, $nextAmbientsToOcupe, $message;

    public function render(){
        $ambient_events = Schedules::whereHas('environment', function($query) { $query->where('code', 'not like', '%AU%'); })->get();
        $auditory_events = Schedules::whereHas('environment', function($query) {$query->where('code', 'like', '%AU%'); })->get();
        $this->nextAmbientsToOcupe = Schedules::where('date', '=', Carbon::now("America/Bogota")->toDateString())->where('handOveredKeys', '=', 0)->orderBy('startTime', 'asc')->get();
        
        $ambientEvents = [];
        $auditoryEvents = [];

        foreach($ambient_events as $event){
            $env = Environment::find($event->environment_id);
            $user = User::find($event->user_id);
            $ambientEvents[] = [
                'title' => "$user->lastname $user->name - $env->code",
                'start' => "$event->date $event->startTime",
                'end' => "$event->date $event->startTime",
                'handOveredKeys' => "$event->handOveredKeys"
            ];
        }

        foreach($auditory_events as $event){
            $env = Environment::find($event->environment_id);
            $user = User::find($event->user_id);
            $auditoryEvents[] = [
                'title' => "$user->lastname $user->name - $env->code",
                'start' => "$event->date $event->startTime",
                'end' => "$event->date $event->startTime",
                'handOveredKeys' => "$event->handOveredKeys"
            ];
        }

        return view('livewire.dashboard', ['ambientEvents' => $ambientEvents, 'auditoryEvents' => $auditoryEvents]);
    }

    public function searchClasses(){
        $this->message = '';
        $this->user = User::where("code", "=", $this->extractDocumentNumber($this->teacher))->first();
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

    public function extractDocumentNumber() {
        if (preg_match('/(\d+)(?=PubDSK)/', $this->teacher, $matches)) {
            return $matches[1];
        }
        return null;
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
    }
}
