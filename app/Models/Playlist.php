<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'is_public'];

    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }
}
