<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concert extends Model
{
    use HasFactory;

    protected $fillable = ['artist_id', 'city', 'date'];

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
        ];
    }
}
