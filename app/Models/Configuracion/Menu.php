<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function menus():HasMany
    {
        return $this->hasMany(Menu::class);
    }

    public function submenus():HasMany
    {
        return $this->hasMany(Menu::class)->with('menus');
    }
}
