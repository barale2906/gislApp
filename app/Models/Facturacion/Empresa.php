<?php

namespace App\Models\Facturacion;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Empresa extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación muchos a muchos.
     * Usuarios con empresas
     */
    public function users() : BelongsToMany
    {
        return $this->BelongsToMany(User::class);
    }
}
