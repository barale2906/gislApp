<?php

namespace App\Models\Financiera;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cuentaspagar extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relación uno a muchos invertida.
     * Concepto de pago
     */
    public function concepto() : BelongsTo
    {
        return $this->belongsTo(Concepto::class);
    }
}
