<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "product",
        "monthly_payment",
        "balance",
        "debt",
        "start_date",
        "notes"
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
