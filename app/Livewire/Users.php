<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class Users extends Component{
    use WithFileUploads;

    public $users, $search, $name, $lastname, $document_type, $document_number, $password, $email, $role, $file, $code, $errors = [], $success; 
    public $add = false;
    public $deletion = false; 
    public $updating = false;
    public $popup = false;

    public function mount(){
        if(Auth::user()->role != "admin"){
            return redirect()->route("dashboard");
        }
    }

    public function render(){
        if($this->search){
            $this->users = User::where('name', 'like', "%$this->search%")->orWhere('document_number', 'like', "%$this->search%")->get();
        }else{
            $this->users = User::all();
        }

        return view('livewire.users');
    }

    public function save(){
        $this->errors = [];
        $this->success = "";
        if(empty($this->name) || $this->name == ""){ $this->errors['name'] = "Este campo es obligatorio"; }
        if(empty($this->lastname) || $this->lastname == ""){ $this->errors['lastname'] = "Este campo es obligatorio"; }
        if(empty($this->document_number) || $this->document_number == ""){ $this->errors['document_number'] = "Este campo es obligatorio"; }
        if(empty($this->document_type) || $this->document_type == ""){ $this->errors['document_type'] = "Este campo es obligatorio"; }
        if(empty($this->code) || $this->code == ""){ $this->errors['code'] = "Este campo es obligatorio"; }
        if(empty($this->email) || $this->email == ""){ $this->errors['email'] = "Este campo es obligatorio"; }
        if(empty($this->password) || $this->password == ""){ $this->errors['password'] = "Este campo es obligatorio"; }

        if($this->errors == []){
            if (preg_match('/(\d+)(?=PubDSK)/', $this->code, $matches)) {
                $this->code = $matches[1];
            }

            $user = new User();
            $user->role = $this->role;
            $user->code = $this->code;
            $user->name = $this->name;
            $user->lastname = $this->lastname;
            $user->document_number = $this->document_number;
            $user->document_type = $this->document_type;
            $user->email = $this->email;
            $user->password = Hash::make($this->password);
            $user->save();
            $this->success = "Guardado correctamente";
            $this->cancel();
        }
    }


    public function update($id){
        $this->errors = [];
        $this->success = "";

        if($id){
            if(empty($this->name) || $this->name == ""){ $this->errors['name'] = "Este campo es obligatorio"; }
            if(empty($this->lastname) || $this->lastname == ""){ $this->errors['lastname'] = "Este campo es obligatorio"; }
            if(empty($this->document_number) || $this->document_number == ""){ $this->errors['document_number'] = "Este campo es obligatorio"; }
            if(empty($this->document_type) || $this->document_type == ""){ $this->errors['document_type'] = "Este campo es obligatorio"; }
            if(empty($this->code) || $this->code == ""){ $this->errors['code'] = "Este campo es obligatorio"; }
            if(empty($this->email) || $this->email == ""){ $this->errors['email'] = "Este campo es obligatorio"; }

            if($this->errors == []){
                $user = User::find($id);
                $user->role = $this->role;
                $user->name = $this->name;
                $user->lastname = $this->lastname;
                $user->email = $this->email;
                $user->document_type = $this->document_number;
                $user->document_type = $this->document_type;

                $user->update();
                $this->cancel();
            }
        }else{
            $this->errors['id'] = "Identificador no asignado";
        }
    }

    public function delete($id){
        if($id){
            $user = User::find($id);
            $user->delete();
            $this->cancel();
        }else{
            $this->errors['id'] = "Identificador no asignado";
        }
    }

    // Import data from excel
    public function importData(){
        if($this->file){
            Excel::import(new UsersImport, $this->file);
        }

        $this->success = "Información importada";
        $this->file = '';
    }

    public function editModal($id){
        if($id){
            $this->openPopUp();
            $record = User::find($id);
            $this->name = $record->name;
            $this->lastname = $record->lastname;
            $this->role = $record->role;
            $this->email = $record->email;
            $this->document_number = $record->document_number;
            $this->document_type = $record->document_type;
            $this->updating = $record;
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

    public function openPopUp(){
        $this->popup = true;
    }

    public function cancel(){
        $this->popup = false;
        $this->name = '';
        $this->lastname = '';
        $this->role = '';
        $this->document_type = '';
        $this->document_number = '';
        $this->password = '';
        $this->email = '';
        $this->deletion = false;
        $this->updating = false;
        $this->errors = [];
        $this->success = "";
    }

    public function clearErrors(){
        $this->errors = [];
        $this->success = '';
    }
}
