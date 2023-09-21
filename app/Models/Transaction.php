<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'transaction_type_id',
        'amount_ghs',
    ];


    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
