<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'client_id',
        'notes',
        'total_amount',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
