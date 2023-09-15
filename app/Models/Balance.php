<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Balance extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function customer():HasOne
    {
        return $this->hasOne(Customer::class);
    }
}
