<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\ImplementsEnv;

class ImplementsEnvironments extends Component
{
    public $implements, $search, $name, $status, $id, $errors = [], $success;
    public $popup = false;
    public $deletion = false;
    public $updating = false;

    public function mount($id){
        if(Auth::user()->role != "admin"){
            return redirect()->route("dashboard");
        }elseif(!isset($id) || empty($id)){
            return redirect()->route("dashboard");
        }
        
        $this->id = $id;
    }
    
    public function render(){
        if($this->search){
            $this->implements = ImplementsEnv::whereLike('name', "%$this->search%")->where('environment_id', $this->id)->get();
        }else{
            $this->implements = ImplementsEnv::all()->where('environment_id', $this->id);
        }
        
        return view('livewire.implements-environments');
    }

    public function add(){
        $this->openPopUp();
    }

    public function save(){
        $this->errors = [];
        $this->success = "";
        if(empty($this->name) || $this->name == ""){ $this->errors['name'] = "Este campo es obligatorio"; }
        if(empty($this->status) || $this->name == ""){ $this->errors['status'] = "Este campo es obligatorio"; }

        if($this->errors == [] && $this->id){
            $imp = new ImplementsEnv();
            $imp->name = $this->name;
            $imp->status = $this->status;
            $imp->environment_id = $this->id;
            $imp->save();
            $this->closePopUp();
            $this->success = "Agregado correctamente a la base de datos";
        }
    }

    public function update($id){
        if($id){
            $this->errors = [];
            $this->success = "";
            if(empty($this->name) || $this->name == ""){ $this->errors['name'] = "Este campo es obligatorio"; }
            if(empty($this->status) || $this->status == ""){ $this->errors['status'] = "Este campo es obligatorio"; }

            if($this->errors == []){
                $row = ImplementsEnv::find($id);
                $row->name = $this->name;
                $row->status = $this->status;
                $row->update();
                $this->closePopUp();
                $this->success = "Actualizado correctamente";
            }
            
        }else{
            $this->errors['id'] = "Identificador no asignado";
        }
    }

    public function delete($id){
        if($id){
            ImplementsEnv::find($id)->delete();
            $this->success = "Eliminado correctamente";
            $this->closePopUp();
        }else{
            $this->errors['id'] = "Identificador no asignado";
        }
    }

    public function deleteModal($id){
        if($id){
            $this->openPopUp();
            $this->deletion = $id;
        }else{
            $this->errors['id'] = "Identificador no asignado";
        }
    }

    public function editModal($id){
        if($id){
            $this->openPopUp();
            $record = ImplementsEnv::find($id);
            $this->name = $record->name;
            $this->status = $record->status;
            $this->updating = $record;
        }else{
            $this->errors['id'] = "Identificador no asignado";
        }
    }

    public function clearErrors(){
        $this->errors = [];
        $this->success = '';
    }

    public function cancel(){
        $this->closePopUp();
        $this->errors = [];
        $this->success = "";
    }

    public function openPopUp(){
        $this->popup = true;
    }

    public function closePopUp(){
        $this->popup = false;
        $this->deletion = false;
        $this->updating = false;
        $this->name = '';
        $this->status = '';
    }
}
