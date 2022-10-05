<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description'];

    protected $hidden = ['pivot'];

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'games_genres');
    }
}
