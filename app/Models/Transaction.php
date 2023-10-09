<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_account_number',
        'transaction_type_id',
        'amount_ghs',
    ];


    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function transactiontype(): BelongsTo
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
