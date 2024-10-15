<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Environment;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use App\Imports\EnvironmentsImport;
use Maatwebsite\Excel\Facades\Excel;

class Environments extends Component{
    use WithFileUploads;

    public $environments, $search, $name, $capacity, $availability, $code, $file, $errors = [], $success;
    public $popup = false;
    public $deletion = false;
    public $updating = false;

    public function mount(){
        if(Auth::user()->role != "admin" && Auth::user()->role != "coordinador"){
            return redirect()->route("dashboard");
        }
    }
    
    public function render(){
        if($this->search){
            $this->environments = Environment::where('name', 'like', "%$this->search%")->orWhere('code', 'like', "%$this->search%")->get();
        }else{
            $this->environments = Environment::all();
        }
        
        return view('livewire.environments');
    }

    public function add(){
        $this->openPopUp();
    }

    public function save(){
        $this->errors = [];
        $this->success = "";
        if(empty($this->code) || $this->code == ""){ $this->errors['code'] = "Este campo es obligatorio"; }
        if(empty($this->name) || $this->name == ""){ $this->errors['name'] = "Este campo es obligatorio"; }
        if(empty($this->capacity) || $this->capacity == ""){ $this->errors['capacity'] = "Este campo es obligatorio"; }


        $env = new Environment();
        $env->code = $this->code;
        $env->name = $this->name;
        $env->capacity = $this->capacity;

        if($this->errors == []){
            $env->save();
            $this->success = "Agregado correctamente";
            $this->errors = [];
            $this->closePopUp();
        }
    }

    public function update($id){
        $this->errors = [];
        $this->success = "";
        if($id){
            if(empty($this->code) || $this->code == ""){ $this->errors['code'] = "Este campo es obligatorio"; }
            if(empty($this->name) || $this->name == ""){ $this->errors['name'] = "Este campo es obligatorio"; }
            if(empty($this->capacity) || $this->capacity == ""){ $this->errors['capacity'] = "Este campo es obligatorio"; }
            if(empty($this->availability) || $this->availability == ""){ $this->errors['availability'] = "Este campo es obligatorio"; }
            
            if($this->errors == []){
                $row = Environment::find($id);
                $row->code = $this->code;
                $row->name = $this->name;
                $row->capacity = $this->capacity;
                $row->availability = $this->availability;
                $this->closePopUp();
                $row->update();
                $this->success = "Actualizado correctamente";
            }
        }else{
            $this->errors['id'] = "Identificador no asignado";
        }
    }

    public function delete($id){
        $this->errors = [];
        $this->success = "";
        if($id){
            Environment::find($id)->delete();
            $this->success = "Eliminado correctamente";
            $this->closePopUp();
        }else{
            $this->errors['id'] = "Identificador no asignado";
        }
    }

    // Import data from excel
    public function importData(){
        if($this->file){
            Excel::import(new EnvironmentsImport, $this->file);
        }

        $this->success = "Información importada";
        $this->file = '';
    }

    public function clearErrors(){
        $this->errors = [];
        $this->success = '';
    }

    public function deleteModal($id){
        $this->openPopUp();
        if($id){
            $this->deletion = $id;
        }else{
            $this->errors['id'] = "Identificador no asignado";
        }
    }

    public function editModal($id){
        if($id){
            $this->openPopUp();
            $record = Environment::find($id);
            $this->name = $record->name;
            $this->capacity = $record->capacity;
            $this->availability = $record->availability ;
            $this->code = $record->code;
            $this->updating = $record;
        }else{
            $this->errors['id'] = "Identificador no asignado";
        }
    }

    public function cancel(){
        $this->closePopUp();
        $this->errors = [];
    }

    public function openPopUp(){
        $this->popup = true;
    }

    public function closePopUp(){
        $this->popup = false;
        $this->deletion = false;
        $this->updating = false;
        $this->name = '';
        $this->availability = '';
        $this->capacity = '';
        $this->code = '';
        $this->errors = [];
        $this->success = "";
    }
}
