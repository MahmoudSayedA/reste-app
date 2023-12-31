<?php

namespace App\Models;

use App\Enums\TableLocations;
use App\Enums\TableStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Table extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status', 'guest_num', 'location'];

    protected $casts = [
        'location' => TableLocations::class,
        'status' => TableStatus::class,
    ];

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'table_id', 'id');
    }
}
