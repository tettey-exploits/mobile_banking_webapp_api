<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasFactory;
    use HasApiTokens;


    protected $fillable = [
        "first_name",
        "last_name",
        "date_of_birth",
        "contact",
        "location",
        "account_number",
        "username",
        "email",
        "password"
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at'
    ];

    public function getRouteKeyName(): string
    {
        return "account_number";
    }

    public function balance(): HasOne
    {
        return $this->hasOne(Balance::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, "customer_account_number");
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
}
