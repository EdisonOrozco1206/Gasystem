<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Quarter;
use Illuminate\Support\Facades\Auth;

class Quarters extends Component{

    public $quarters, $name, $startDate, $endDate, $search, $success, $errors = [];
    public $popup = false;
    public $schedules = '';
    public $deletion = false;
    public $updating = false;

    public function mount(){
        if(Auth::user()->role != "admin" && Auth::user()->role != "coordinador"){
            return redirect()->route("dashboard");
        }
    }

    public function render(){
        if($this->search){
            $this->quarters = Quarter::where('name', 'like', "%$this->search%")->orWhere('startDate', 'like', "%$this->search%")->orWhere('endDate', 'like', "%$this->search%")->get();
        }else{
            $this->quarters = Quarter::all();
        }

        return view('livewire.quarters');
    }

    public function save(){
        $this->clearErrors();
        if(empty($this->name) || $this->name == ""){ $this->errors['name'] = "Este campo es obligatorio"; }
        if(empty($this->startDate) || $this->startDate == ""){ $this->errors['startDate'] = "Este campo es obligatorio"; }
        if(empty($this->endDate) || $this->endDate == ""){ $this->errors['endDate'] = "Este campo es obligatorio"; }

        if($this->errors == []){
            $quarter = new Quarter();
            $quarter->name = $this->name;
            $quarter->startDate = $this->startDate;
            $quarter->endDate = $this->endDate;
            $quarter->save();
            $this->success = "Agregado correctamente";
            $this->closePopUp();
        }
    }

    public function update($id){
        $this->clearErrors();
        if($id){
            if(empty($this->name) || $this->name == ""){ $this->errors['name'] = "Este campo es obligatorio"; }
            if(empty($this->startDate) || $this->startDate == ""){ $this->errors['startDate'] = "Este campo es obligatorio"; }
            if(empty($this->endDate) || $this->endDate == ""){ $this->errors['endDate'] = "Este campo es obligatorio"; }
    
            if($this->errors == []){
                $quarter = Quarter::find($id);
                $quarter->name = $this->name;
                $quarter->startDate = $this->startDate;
                $quarter->endDate = $this->endDate;
                $quarter->update();
                $this->success = "Actualizado correctamente";
                $this->closePopUp();
            }
        }else{
            $this->errors['id'] = "Identificador no asignado";
        }
    }

    public function delete($id){
        $this->clearErrors();
        try{
            if($id){
                $quarter = Quarter::find($id);
                $quarter->delete();
                $this->deletion = '';
                $this->closePopUp();
            }else{
                $this->errors['id'] = "Identificador no asignado";
            }
        }catch (\Throwable $th) {
            $this->closePopUp(1);
            $this->errors['foreing_kes'] = "No se puedo eliminar el registro";
        }
    }

    public function editModal($id){
        $this->clearErrors();
        if($id){
            $this->openPopUp();
            $record = Quarter::find($id);
            $this->name = $record->name;
            $this->startDate = $record->startDate;
            $this->endDate = $record->endDate;
            $this->updating = $record;
        }else{
            $this->errors['id'] = "Identificador no asignado";
        }
    }

    public function deleteModal($id){
        $this->clearErrors();
        if($id){
            $this->openPopUp();
            $this->deletion = $id;
        }else{
            $this->errors['id'] = "Identificador no asignado";
        }
    }

    public function openPopUp(){
        $this->popup = true;
    }

    public function closePopUp($o = null){
        if(isset($o) && !empty($o) && $o == 1){
            $this->popup = false;
        }else{
            $this->popup = false;
            $this->name = '';
            $this->startDate = '';
            $this->endDate = '';
        }
    }

    public function clearErrors(){
        $this->errors = [];
        $this->success = '';
    }

    public function cancel(){
        $this->popup = false;
        $this->updating = '';
        $this->deletion = '';
        $this->name = '';
        $this->startDate = '';
        $this->endDate = '';
        $this->errors = [];
        $this->success = "";
    }

}
