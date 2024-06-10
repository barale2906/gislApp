<?php

namespace App\Livewire\Layouts;

use App\Models\Configuracion\Menu as ConfiguracionMenu;
use App\Models\Facturacion\Empresa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Menu extends Component
{
    public $url;
    public $urlempr;
    public $empactual;

    public function mount(){
        if(Auth::user()->profile_photo_path){
            $this->url=Storage::url(Auth::user()->profile_photo_path);
        }else{
            $this->url=asset('img/usuario.jpg');
        }
        $this->empresa();
    }

    public function empresa(){
        $this->empactual=Empresa::find(Auth::user()->empresa_id);
        //dd($this->empactual->logo,Auth::user()->profile_photo_path);

        if($this->empactual->logo){
            $this->urlempr=Storage::url($this->empactual->logo);
        }else{
            $this->urlempr=asset('img/logo.jpg');
        }

    }

    private function menus(){
        return ConfiguracionMenu::where('status', true)
                    ->whereNull('menu_id')
                    ->with('submenus')
                    ->get();
    }
    public function render()
    {
        return view('livewire.layouts.menu', [
            'menus' => $this->menus(),
        ]);
    }
}
